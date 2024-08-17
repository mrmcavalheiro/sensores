import pandas as pd
import pymysql
import pytz
from prettytable import PrettyTable
import datetime
import logging
from logging.handlers import RotatingFileHandler
import os
import sys
from utils.database import get_db_connection
import subprocess

# Definir os fusos horários
timezone_brasilia = pytz.timezone('America/Sao_Paulo')
timezone_japan = pytz.timezone('Asia/Tokyo')

# Configuração do logger
logger = None

def configurar_logger(mode):
    global logger
    if not os.path.exists('log'):
        os.makedirs('log')
    data_atual = datetime.datetime.now().strftime("%Y_%m_%d_%H_%M")
    log_filename = os.path.join('log', f"Sensores_02_CSV_Upload_log_{data_atual}.log")

    log_format = logging.Formatter('%(asctime)s - %(levelname)s - %(message)s')

    file_handler = RotatingFileHandler(log_filename, maxBytes=5*1024*1024, backupCount=2)
    file_handler.setFormatter(log_format)

    logger = logging.getLogger()
    logger.setLevel(logging.INFO)
    logger.addHandler(file_handler)

    if mode == '1' or mode == '3':
        console_handler = logging.StreamHandler()
        console_handler.setFormatter(log_format)
        logger.addHandler(console_handler)

# Função para tratar valores nulos
def tratar_valores(valor):
    """Converter o valor para float ou retornar None se o valor for vazio."""
    try:
        if pd.isna(valor):
            return None
        return float(valor)
    except ValueError:
        return None

# Função para buscar device_id a partir de device_name
def obter_device_id(device_name):
    """Obter o device_id correspondente ao device_name do banco de dados."""
    try:
        conn = get_db_connection()
        cursor = conn.cursor(pymysql.cursors.DictCursor)
        cursor.execute("SELECT device_id FROM baseSensores.site_devices_status WHERE device_name = %s", (device_name,))
        result = cursor.fetchone()
        cursor.close()
        conn.close()
        return result['device_id'] if result else None
    except Exception as e:
        logger.error(f"Erro ao obter device_id para {device_name}: {e}")
        return None

# Função para converter data/hora do formato japonês para o formato de Brasília
def converter_para_brasilia(data_hora_str):
    """Converter a string de data e hora do formato japonês para o formato de Brasília."""
    try:
        if 'T' in data_hora_str:
            data_hora_japan = datetime.datetime.strptime(data_hora_str, '%Y-%m-%dT%H:%M:%S%z')
        else:
            data_hora_japan = datetime.datetime.strptime(data_hora_str, '%Y-%m-%d')
            data_hora_japan = timezone_japan.localize(data_hora_japan)
        data_hora_brasilia = data_hora_japan.astimezone(timezone_brasilia)
        return data_hora_brasilia
    except ValueError:
        return None

# Função para carregar CSV para banco de dados
def carregar_csv_para_banco(arquivo_csv, device_id):
    resumo = {
        "device_id": device_id,
        "linhas_processadas": 0,
        "linhas_gravadas": 0,
        "linhas_existentes": 0,
        "erros": 0
    }
    try:
        conn = get_db_connection()
        if conn is None:
            logger.error("Erro na conexão com o banco de dados.")
            return resumo
        logger.info("Conectado ao banco de dados.")

        if os.path.getsize(arquivo_csv) == 0:
            logger.error(f"O arquivo CSV {arquivo_csv} está vazio.")
            resumo["erros"] += 1
            return resumo

        df = pd.read_csv(arquivo_csv)
        if df.empty:
            logger.error(f"O arquivo CSV {arquivo_csv} está vazio ou não possui colunas.")
            resumo["erros"] += 1
            return resumo

        # Verificar e converter colunas de data/hora
        if 'Date and time' in df.columns:
            df['datetime_BR'] = df['Date and time'].apply(converter_para_brasilia)
        else:
            logger.error("A coluna 'Date and time' não está presente no CSV.")
            resumo["erros"] += 1
            return resumo

        cursor = conn.cursor()
        for i, row in df.iterrows():
            resumo["linhas_processadas"] += 1
            data_hora_brasilia = row['datetime_BR']
            consulta_SQL = f"""
                SELECT COUNT(*) FROM sensor_readings WHERE device_id = '{device_id}' AND datetime_BR = '{data_hora_brasilia.strftime('%Y-%m-%d %H:%M:%S')}'
            """
            cursor.execute(consulta_SQL)

            result = cursor.fetchone()
            if result and result['COUNT(*)'] > 0:
                resumo["linhas_existentes"] += 1
                if resumo["linhas_processadas"] % 300 == 0:
                    logger.info(f"Lidas: {i+1:6d} de {len(df):6d}  Gravadas: {resumo['linhas_gravadas']:6d}  Já estavam Gravadas: {resumo['linhas_existentes']:6d}")
                continue

            sensor_count = sum(1 for col in df.columns if pd.notna(row[col]) and col != 'Date and time' and col != 'datetime_BR')

            # Corrigir o formato da data/hora para o banco de dados
            datetime_jap = datetime.datetime.strptime(row['Date and time'], '%Y-%m-%dT%H:%M:%S%z').astimezone(timezone_japan).strftime('%Y-%m-%d %H:%M:%S')

            try:
        
                cursor.execute("""
                    INSERT INTO sensor_readings (device_id, datetime_BR, datetime_Jap, sensor_count, volumetric_humidity_s1, volumetric_humidity_s2, temperature_s1, temperature_s2, dew_point_s1, dew_point_s2, humidity_deficit_s1, humidity_deficit_s2, relative_humidity_s1, relative_humidity_s2, soil_electronic_conductivity_s1, soil_electronic_conductivity_s2, soil_vwc_s1, soil_vwc_s2, solar_radiation_w_m2_a1, solar_radiation_w_m2_a2, thermister_a1g, thermister_a1r, thermister_s1, thermister_s2, water_depth_s1, created_at)
                    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, NOW())
                """, (
                    device_id,
                    row['datetime_BR'].strftime('%Y-%m-%d %H:%M:%S'),
                    datetime_jap,
                    sensor_count,
                    tratar_valores(row.get('Volumetric humidity(S1)')),
                    tratar_valores(row.get('Volumetric humidity(S2)')),
                    tratar_valores(row.get('temperature(S1)')),
                    tratar_valores(row.get('temperature(S2)')),
                    tratar_valores(row.get('Dew point(S1)')),
                    tratar_valores(row.get('Dew point(S2)')),
                    tratar_valores(row.get('Humidity deficit(S1)')),
                    tratar_valores(row.get('Humidity deficit(S2)')),
                    tratar_valores(row.get('Relative humidity(S1)')),
                    tratar_valores(row.get('Relative humidity(S2)')),
                    tratar_valores(row.get('Soil Electronic Conductivity(S1)')),
                    tratar_valores(row.get('Soil Electronic Conductivity(S2)')),
                    tratar_valores(row.get('soil vwc(S1)')),
                    tratar_valores(row.get('soil vwc(S2)')),
                    tratar_valores(row.get('Solar radiation (W/m2)(A1)')),
                    tratar_valores(row.get('Solar radiation (W/m2)(A2)')),
                    tratar_valores(row.get('Thermister(A1G)')),
                    tratar_valores(row.get('Thermister(A1R)')),
                    tratar_valores(row.get('Thermister(S1)')),
                    tratar_valores(row.get('Thermister(S2)')),
                    tratar_valores(row.get('Water depth(S1)'))
                ))
                resumo["linhas_gravadas"] += 1
            except pymysql.err.IntegrityError as e:
                if e.args[0] == 1062:  # Duplicate entry error code
                    resumo["linhas_existentes"] += 1
                    logger.warning(f"Entrada duplicada encontrada na linha {i}: {e}")
                else:
                    logger.error(f"Erro ao inserir device_id = {device_id}  linha {i}: {e}")
                    resumo["erros"] += 1
            except Exception as e:
                logger.error(f"Erro ao inserirdevice_id = {device_id}  linha {i}: {e}")
                resumo["erros"] += 1

            if resumo["linhas_gravadas"] % 300 == 0:
                conn.commit()
            if resumo["linhas_processadas"] % 300 == 0:
                conn.commit()
                logger.info(f"Lidas: {i+1:6d} de {len(df):6d}  Gravadas: {resumo['linhas_gravadas']:6d}  Já estavam Gravadas: {resumo['linhas_existentes']:6d}")

        conn.commit()
        
        # Consulta para obter a primeira e última linha gravada para o dispositivo
        cursor.execute(f"""
            SELECT 
                MIN(datetime_BR) AS Data_Primeira_Linha_Gravada, 
                MAX(datetime_BR) AS Data_Ultima_Linha_Gravada 
            FROM sensor_readings 
            WHERE device_id = '{device_id}'
        """)
        result = cursor.fetchone()
        resumo["primeira_linha_gravada"] = result['Data_Primeira_Linha_Gravada']
        resumo["ultima_linha_gravada"] = result['Data_Ultima_Linha_Gravada']

        cursor.close()
        conn.close()
        logger.info(f"Arquivo {arquivo_csv} processado e commit realizado.")
    except Exception as e:
        logger.error(f"Erro ao popular tabela sensor_readings: {e}")
        resumo["erros"] += 1

    return resumo

def contar_arquivos_csv(diretorio):
    try:
        itens = os.listdir(diretorio)
        arquivos_csv = [item for item in itens if item.endswith('.csv') and os.path.isfile(os.path.join(diretorio, item))]
        numero_de_arquivos_csv = len(arquivos_csv)
        return numero_de_arquivos_csv
    except Exception as e:
        logger.error(f"Erro ao contar arquivos CSV no diretório {diretorio}: {e}")
        return 0

def verificar_primeira_ultima_linha(device_id):
    try:
        conn = get_db_connection()
        cursor = conn.cursor(pymysql.cursors.DictCursor)
        query = """
        SELECT 
            MIN(datetime_BR) AS primeira_linha, 
            MAX(datetime_BR) AS ultima_linha 
        FROM sensor_readings 
        WHERE device_id = %s
        """
        cursor.execute(query, (device_id,))
        result = cursor.fetchone()
        cursor.close()
        conn.close()
        return result
    except Exception as e:
        logger.error(f"Erro ao verificar primeira e última linha no banco de dados para device_id {device_id}: {e}")
        return None

def processar_arquivos_csv(mode):
    configurar_logger(mode)
    logger.info("\n ********  Iniciando o script Sensores_02_CSV_Upload.py ******\n")
    if mode in ['0', '1']:
        download_folder = 'Bot_csv_Baixados'
    elif mode in ['2', '3']:
        download_folder = 'API_csv_Baixados'
    else:
        logger.error(f"Modo desconhecido: {mode}")
        return

    if not os.path.exists(download_folder):
        logger.error(f"A pasta {download_folder} não existe.")
        return

    # Contar o número de arquivos no diretório
    numero_de_arquivos = contar_arquivos_csv(download_folder)
    logger.info(f"Número de arquivos no diretório '{download_folder}': {numero_de_arquivos}")

    arquivos_csv = [f for f in os.listdir(download_folder) if f.endswith('.csv')]
    resumo_lista = []
    tabela_resumo = []
    cont_arq_csv = 0

    for idx, arquivo in enumerate(arquivos_csv, start=1):
        device_name = arquivo.split('_')[0]
        device_id = obter_device_id(device_name)
        if not device_id:
            logger.error(f"Device ID não encontrado para o dispositivo: {device_name}")
            continue

        caminho_arquivo = os.path.join(download_folder, arquivo)
        num_linhas = sum(1 for line in open(caminho_arquivo)) - 1
        tamanho_arquivo = os.path.getsize(caminho_arquivo)

        try:
            df = pd.read_csv(caminho_arquivo)
            if df.empty:
                raise ValueError("Arquivo CSV vazio ou sem colunas.")

            if 'Date and time' not in df.columns:
                raise ValueError("Coluna 'Date and time' não encontrada no CSV.")

            sensor_columns = [col for col in df.columns if col not in ['Date and time']]
            sensor_count = len(sensor_columns)
            sensores_com_dados = [col for col in sensor_columns if df[col].notna().any()]
            data_primeira_linha = df['Date and time'].iloc[0]
            data_ultima_linha = df['Date and time'].iloc[-1]

            tabela_resumo.append([
                idx, arquivo, device_id, device_name, num_linhas, sensor_count,
                ', '.join(sensores_com_dados), data_primeira_linha, data_ultima_linha, tamanho_arquivo
            ])
            cont_arq_csv += 1
            logger.info(f"{cont_arq_csv}/{numero_de_arquivos} - Extraindo device_id: {device_id} do arquivo: {arquivo}")
            resumo = carregar_csv_para_banco(caminho_arquivo, device_id)
            resumo_lista.append(resumo)
        except Exception as e:
            logger.error(f"Erro ao processar arquivo {arquivo}: {e}")
            tabela_resumo.append([idx, arquivo, device_id, device_name, 0, 0, '', '', '', tamanho_arquivo])
            resumo_lista.append({
                "device_id": device_id, "linhas_processadas": 0, "linhas_gravadas": 0,
                "linhas_existentes": 0, "erros": 1
            })

    # Exibir resumo dos arquivos processados
    tabela_arquivos = PrettyTable()
    tabela_arquivos.field_names = [
        'Index', 'Arquivo', 'Device ID', 'Device Name', 'Total Linhas', 
        'Total Sensores', 'Sensores com Dados', 'Data Primeira Linha', 'Data Última Linha', 'Tamanho do Arquivo (bytes)'
    ]
    for linha in tabela_resumo:
        tabela_arquivos.add_row(linha)
    print(tabela_arquivos)
    logger.info("Resumo dos Arquivos CSV:\n" + tabela_arquivos.get_string())

    # Verificar e exibir as primeiras e últimas linhas gravadas no banco de dados para cada device_id
    tabela_verificacao = PrettyTable()
    tabela_verificacao.field_names = [
        'Device ID', 'Data Primeira Linha Gravada', 'Data Última Linha Gravada'
    ]
    for resumo in resumo_lista:
        device_id = resumo['device_id']
        resultado = verificar_primeira_ultima_linha(device_id)
        if resultado:
            tabela_verificacao.add_row([device_id, resultado['primeira_linha'], resultado['ultima_linha']])
        else:
            tabela_verificacao.add_row([device_id, 'Erro ao consultar', 'Erro ao consultar'])
    logger.info("Verificação das Primeiras e Últimas Linhas Gravadas:\n" + tabela_verificacao.get_string())

    # Exibir resumo do upload
    logger.info("Resumo do upload dos arquivos CSV:")
    for resumo in resumo_lista:
        logger.info(f"\ndevice_id  linhas_processadas  linhas_gravadas  linhas_existentes  erros")
        logger.info(f"  {resumo['device_id']:>8} {resumo['linhas_processadas']:>20} {resumo['linhas_gravadas']:>15} {resumo['linhas_existentes']:>20} {resumo['erros']:>5}")
        logger.info(f"Data Primeira Linha Gravada: {resumo.get('primeira_linha_gravada')}")
        logger.info(f"Data Última Linha Gravada: {resumo.get('ultima_linha_gravada')}")

if __name__ == "__main__":
    if len(sys.argv) < 2:
        print(f"Modo não especificado. Use '0', '1', '2' ou '3'.")
    else:
        mode = sys.argv[1] if len(sys.argv) > 1 else '1'
        processar_arquivos_csv(mode)
        # Chamar o script Sensores_02_CSV_Upload.py ao final
        try:
            logger.info("\n\nChamando o script Sensores_03_Incluidos_CSV.py")
            subprocess.run(['python', 'Sensores_03_Incluidos_CSV.py', mode], check=True)
            logger.info("Script Sensores_03_Incluidos_CSV.py executado com sucesso.\n")
        except subprocess.CalledProcessError as e:
            logger.error(f"Erro ao executar o script Sensores_03_Incluidos_CSV.py: {e}")
        except Exception as e:
            logger.error(f"Ocorreu um erro inesperado ao chamar o script Sensores_03_Incluidos_CSV.py: {e}")