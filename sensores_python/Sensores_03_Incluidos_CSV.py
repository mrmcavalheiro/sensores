import os
import sys
import datetime
import logging
from logging.handlers import RotatingFileHandler
import pandas as pd
import pymysql
from prettytable import PrettyTable
from utils.database import get_db_connection
import pytz
import shutil
import subprocess

# Definir os fusos horários
timezone_brasilia = pytz.timezone('America/Sao_Paulo')
timezone_japan = pytz.timezone('Asia/Tokyo')

# Configuração do logger
logger = None

def configurar_logger():
    global logger
    if not os.path.exists('log'):
        os.makedirs('log')
    data_atual = datetime.datetime.now().strftime("%Y_%m_%d_%H_%M")
    log_filename = os.path.join('log', f"Sensores_03_Incluidos_CSV_{data_atual}.log")

    log_format = logging.Formatter('%(asctime)s - %(levelname)s - %(message)s')

    file_handler = RotatingFileHandler(log_filename, maxBytes=5*1024*1024, backupCount=2)
    file_handler.setFormatter(log_format)

    logger = logging.getLogger()
    logger.setLevel(logging.INFO)
    logger.addHandler(file_handler)

    console_handler = logging.StreamHandler()
    console_handler.setFormatter(log_format)
    logger.addHandler(console_handler)

def obter_device_id(device_name):
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

def verificar_se_ja_gravado(device_id, data_hora_brasilia):
    try:
        conn = get_db_connection()
        cursor = conn.cursor(pymysql.cursors.DictCursor)
        cursor.execute("SELECT COUNT(*) as count FROM sensor_readings WHERE device_id = %s AND datetime_BR = %s", (device_id, data_hora_brasilia))
        result = cursor.fetchone()
        cursor.close()
        conn.close()
        return result['count'] > 0 if result else False
    except Exception as e:
        logger.error(f"Erro ao verificar se já está gravado: {e}")
        return False

def converter_para_brasilia(data_hora_str):
    try:
        data_hora_japan = datetime.datetime.strptime(data_hora_str, '%Y-%m-%dT%H:%M:%S%z')
        data_hora_brasilia = data_hora_japan.astimezone(timezone_brasilia)
        return data_hora_brasilia.strftime('%Y-%m-%d %H:%M:%S')
    except ValueError:
        return None

def processar_arquivos_csv():
    configurar_logger()
    
    download_folder = 'Bot_csv_Baixados'
    processados_folder = 'Arquivos_Processados'
    
    if not os.path.exists(download_folder):
        logger.error(f"A pasta {download_folder} não existe.")
        return
    
    if not os.path.exists(processados_folder):
        os.makedirs(processados_folder)

    arquivos_csv = [f for f in os.listdir(download_folder) if f.endswith('.csv')]

    tabela_resumo = PrettyTable()
    tabela_resumo.field_names = ["Index", "Arquivo", "Device ID", "Device Name", "Primeira Linha Gravada", "Última Linha Gravada", "Primeira Linha", "Última Linha", "Tamanho do Arquivo (bytes)", "Movido"]

    for idx, arquivo in enumerate(arquivos_csv, start=1):
        device_name = arquivo.split('_')[0]
        device_id = obter_device_id(device_name)
        if not device_id:
            logger.error(f"Device ID não encontrado para o dispositivo: {device_name}")
            continue

        caminho_arquivo = os.path.join(download_folder, arquivo)
        tamanho_arquivo = os.path.getsize(caminho_arquivo)

        if tamanho_arquivo == 0:
            logger.error(f"O arquivo CSV {arquivo} está vazio.")
            tabela_resumo.add_row([idx, arquivo, device_id, device_name, "N/A", "N/A", "N/A", "N/A", tamanho_arquivo, "Sim"])
            novo_nome_arquivo = f"{device_name}_{datetime.datetime.now().strftime('%Y_%m_%d_%H_%M_%S')}.csv"
            shutil.move(caminho_arquivo, os.path.join(processados_folder, novo_nome_arquivo))
            continue

        try:
            df = pd.read_csv(caminho_arquivo)
            if df.empty:
                logger.error(f"O arquivo CSV {arquivo} está vazio ou não possui colunas.")
                tabela_resumo.add_row([idx, arquivo, device_id, device_name, "N/A", "N/A", "N/A", "N/A", tamanho_arquivo, "Sim"])
                novo_nome_arquivo = f"{device_name}_{datetime.datetime.now().strftime('%Y_%m_%d_%H_%M_%S')}.csv"
                shutil.move(caminho_arquivo, os.path.join(processados_folder, novo_nome_arquivo))
                continue

            if 'Date and time' not in df.columns:
                logger.error(f"A coluna 'Date and time' não está presente no CSV: {arquivo}.")
                tabela_resumo.add_row([idx, arquivo, device_id, device_name, "N/A", "N/A", "N/A", "N/A", tamanho_arquivo, "Sim"])
                novo_nome_arquivo = f"{device_name}_{datetime.datetime.now().strftime('%Y_%m_%d_%H_%M_%S')}.csv"
                shutil.move(caminho_arquivo, os.path.join(processados_folder, novo_nome_arquivo))
                continue

            primeira_linha = df.iloc[0]['Date and time']
            ultima_linha = df.iloc[-1]['Date and time']

            primeira_linha_brasilia = converter_para_brasilia(primeira_linha)
            ultima_linha_brasilia = converter_para_brasilia(ultima_linha)

            primeira_gravada = verificar_se_ja_gravado(device_id, primeira_linha_brasilia)
            ultima_gravada = verificar_se_ja_gravado(device_id, ultima_linha_brasilia)

            movido = "Não"
            if primeira_gravada and ultima_gravada:
                novo_nome_arquivo = f"{device_name}_{datetime.datetime.now().strftime('%Y_%m_%d_%H_%M_%S')}.csv"
                shutil.move(caminho_arquivo, os.path.join(processados_folder, novo_nome_arquivo))
                movido = "Sim"

            tabela_resumo.add_row([
                idx, arquivo, device_id, device_name,
                "Sim" if primeira_gravada else "Não",
                "Sim" if ultima_gravada else "Não",
                primeira_linha, ultima_linha, tamanho_arquivo, movido
            ])
        except Exception as e:
            logger.error(f"Erro ao processar arquivo {arquivo}: {e}")
            tabela_resumo.add_row([idx, arquivo, device_id, device_name, "Erro", "Erro", "Erro", "Erro", tamanho_arquivo, "Sim"])
            novo_nome_arquivo = f"{device_name}_{datetime.datetime.now().strftime('%Y_%m_%d_%H_%M_%S')}.csv"
            shutil.move(caminho_arquivo, os.path.join(processados_folder, novo_nome_arquivo))

    logger.info("Resumo dos Arquivos CSV:\n" + tabela_resumo.get_string())

if __name__ == "__main__":

    if len(sys.argv) < 2:
        print(f"Modo não especificado. Use '0', '1', '2' ou '3'.")
    else:
        mode = sys.argv[1] if len(sys.argv) > 1 else '1'
        configurar_logger()
        logger.info("\n ********  Iniciando o script Sensores_03_Incluidos_CSV.py ******\n")
        processar_arquivos_csv()
        # Chamar o script Sensores_02_CSV_Upload.py ao final
        try:
            logger.info("\n\nChamando o script Sensores_04_Calcula_Media.py")
            subprocess.run(['python', 'Sensores_04_Calcula_Media.py', mode], check=True)
            logger.info("Script Sensores_04_Calcula_Media.py executado com sucesso.")
        except subprocess.CalledProcessError as e:
            logger.error(f"Erro ao executar o script Sensores_04_Calcula_Media.py: {e}")
        except Exception as e:
            logger.error(f"Ocorreu um erro inesperado ao chamar o script Sensores_04_Calcula_Media.py: {e}")