"""
Este programa automatiza a extração de dados de dispositivos de um site específico, faz o download de arquivos CSV
e processa esses dados, registrando logs detalhados do processo. Ele pode ser executado em modo visível ou oculto.

Parâmetros:
- `mode`: '0' para modo oculto, '1' para modo visível.

Funções principais:
- `configurar_logger`: Configura o logger para registrar mensagens em arquivo e opcionalmente no console.
- `configurar_chromedriver`: Configura o ChromeDriver para ser executado no modo oculto, se especificado.
- `configurar_webdriver`: Configura o WebDriver com opções específicas para download.
- `executar_bot`: Função principal que executa todo o fluxo de trabalho do bot.
"""

import sys
import os
import time
import datetime
import logging
from logging.handlers import RotatingFileHandler
import pandas as pd
from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import pymysql
from pymysql.err import IntegrityError
from bs4 import BeautifulSoup
from utils.api import ler_config_api
from utils.database import get_db_connection
import shutil
from prettytable import PrettyTable
from datetime import datetime
from selenium.webdriver.chrome.options import Options
import subprocess
import xml.etree.ElementTree as ET

# Declaração da variável global
matriz_detalhes = []
pasta_csv_baixados = 'Bot_csv_Baixados'


# Função para configurar o logger
def configurar_logger(mode):
    global logger
    if not os.path.exists('log'):
        os.makedirs('log')
    data_atual = datetime.now().strftime("%Y_%m_%d_%H_%M")
    log_filename = os.path.join('log', f"Sensores_01_Bot_Site_{data_atual}.log")

    log_format = logging.Formatter('%(asctime)s - %(levelname)s - %(message)s')

    file_handler = RotatingFileHandler(log_filename, maxBytes=5*1024*1024, backupCount=2)
    file_handler.setFormatter(log_format)

    logger = logging.getLogger()
    logger.setLevel(logging.INFO)
    logger.addHandler(file_handler)

    if mode == '1':
        console_handler = logging.StreamHandler()
        console_handler.setFormatter(log_format)
        logger.addHandler(console_handler)

    return logger

# Função para configurar o ChromeDriver
def configurar_chromedriver(modo_oculto):
    chrome_options = Options()
    if modo_oculto:
        chrome_options.add_argument("--headless")
        chrome_options.add_argument("--disable-gpu")
        chrome_options.add_argument("--no-sandbox")
        chrome_options.add_argument("--disable-dev-shm-usage")
    
    service = Service('/path/to/chromedriver')  # Substitua pelo caminho do seu ChromeDriver
    driver = webdriver.Chrome(service=service, options=chrome_options)
    return driver

# Função para configurar o WebDriver com opções específicas de download
def configurar_webdriver(download_path, driver_path, modo_oculto):
    options = webdriver.ChromeOptions()
    prefs = {
        "download.default_directory": os.path.abspath(download_path),  # Certifique-se de usar o caminho absoluto
        "download.prompt_for_download": False,
        "download.directory_upgrade": True,
        "safebrowsing.enabled": True
    }
    options.add_experimental_option("prefs", prefs)
    options.add_argument("--window-size=1000,800")
    if modo_oculto:
        options.add_argument("--headless")
        options.add_argument("--disable-gpu")
        options.add_argument("--no-sandbox")
        options.add_argument("--disable-dev-shm-usage")
    service = Service(driver_path)
    driver = webdriver.Chrome(service=service, options=options)
    
    # Log the download path for verification
    logger.info(f"Configured download path: {os.path.abspath(download_path)}")
    
    return driver

# Função para acessar a página de login
def acessar_pagina_login(driver, login_url):
    logger.info("Acessando a página de login...")
    driver.get(login_url)
    logger.info("Página de login acessada.")

# Função para realizar o login
def fazer_login(driver, username, password):
    try:
        logger.info("Página de login carregada.")
        username_input = WebDriverWait(driver, 30).until(
            EC.presence_of_element_located((By.NAME, 'id'))
        )
        username_input.send_keys(username)
        logger.info("Campo de username preenchido.")

        password_input = driver.find_element(By.NAME, 'password')
        password_input.send_keys(password)
        logger.info("Campo de password preenchido.")

        terms_checkbox = driver.find_element(By.NAME, 'terms')
        if not terms_checkbox.is_selected():
            terms_checkbox.click()
        logger.info("Termos de uso aceitos.")

        login_button = driver.find_element(By.XPATH, '//button[@type="submit"]/span/span[text()="サインイン"]')
        login_button.click()
        logger.info("Botão de login clicado.")
        logger.info("Esperar 15 segundos para redirecionamento.")
        time.sleep(15)  # Esperar 15 segundos para redirecionamento
        logger.info("Redirecionamento.")
        WebDriverWait(driver, 90).until(EC.url_contains('https://g3-app.e-kakashi.com/'))
        logger.info("Login realizado com sucesso!")
    except Exception as e:
        logger.error("Login falhou!")
        logger.error(f"Erro durante o login: {e}")
        driver.quit()
        exit()

# Função para verificar se a página principal foi acessada após o login
def verificar_pagina_principal(driver):
    try:
        logger.info("Verificando a URL da página atual...")
        current_url = driver.current_url
        logger.info(f"URL atual: {current_url}")
        if "https://g3-app.e-kakashi.com/" in current_url:
            logger.info("Página principal após login detectada.")
        else:
            raise Exception("Página principal não detectada.")
    except Exception as e:
        logger.error(f"Erro ao verificar a página: {e}")
        driver.quit()
        exit()

# Função para acessar a lista de dispositivos
def acessar_lista_devices(driver):
    try:
        logger.info("Navegando para a página de dispositivos: https://g3-app.e-kakashi.com/setting/devices")
        driver.get("https://g3-app.e-kakashi.com/setting/devices")
        logger.info("Página de dispositivos acessada.")
        logger.info("Esperando a página de dispositivos carregar...")
        WebDriverWait(driver, 60).until(EC.presence_of_element_located((By.XPATH, '//h2[text()="Device list"]')))
        logger.info("Elemento 'Device list' localizado.")
        time.sleep(15)  # Esperar 15 segundos para garantir que os dispositivos sejam carregados
    except Exception as e:
        logger.error(f"Falha ao localizar a página de dispositivos: {driver.current_url}")
        logger.error(f"Erro: {e}")
        driver.quit()

# Função para extrair dados dos dispositivos
def extrair_dados_devices(driver):
    logger.info("Extraindo dados dos dispositivos.")
    try:
        devices = WebDriverWait(driver, 30).until(
            EC.presence_of_all_elements_located((By.XPATH, '//a[@class="MuiTableRow-root MuiTableRow-hover"]'))
        )
        data = []
        for index, device in enumerate(devices, start=1):
            device_name = device.find_element(By.CLASS_NAME, 'MuiTableCell-body').text
            device_id = device.get_attribute('href').split('/')[-1]
            href = device.get_attribute('href')
            data.append((index, device_id, device_name, href))
        return data
    except Exception as e:
        logger.error(f"Erro ao extrair dados dos dispositivos: {e}")
        return []

# Função para mostrar a tabela de dispositivos
def mostrar_tabela_devices(devices):
    tabela_devices = PrettyTable()
    tabela_devices.field_names = ["Index", "Device ID", "Device Name", "HREF"]

    for device in devices:
        tabela_devices.add_row(device)
    logger.info("Tabela de Dispositivos:\n" + tabela_devices.get_string())

# Função para extrair detalhes de um dispositivo
def extrair_detalhes_device(driver, device_id, href, index, total):
    logger.info(f"{index}/{total} Acessando detalhes do dispositivo: {href}")
    driver.get(href)
    WebDriverWait(driver, 30).until(EC.presence_of_element_located((By.XPATH, '//div[@class="MuiContainer-root MuiContainer-maxWidthSm"]')))
    time.sleep(15)  # Esperar 15 segundos para garantir que os detalhes sejam carregados

    page_source = driver.page_source
    soup = BeautifulSoup(page_source, 'html.parser')

    container_div = soup.find('div', class_='MuiContainer-root MuiContainer-maxWidthSm')
    detalhes = {}

    if container_div:
        sections = container_div.find_all('div', class_='jss77')
        for section in sections:
            label = section.find('h2').text.strip()
            value = section.find('span', class_='MuiTypography-root MuiListItemText-primary MuiTypography-body1 MuiTypography-displayBlock').text.strip()
            if label == "Latitude/Longitude":
                lat, lon = value.split('/')
                detalhes["Latitude"] = lat.strip() or "0.0"
                detalhes["Longitude"] = lon.strip() or "0.0"
            else:
                detalhes[label] = value.strip() or None

    detalhes["Device ID"] = device_id
    detalhes.setdefault("Device Name", None)
    detalhes.setdefault("Last measurement date and time", None)
    detalhes.setdefault("Received status", None)
    detalhes.setdefault("Href", href)

    # Tratar valores "null" para Latitude e Longitude
    if detalhes["Latitude"].lower() == "null":
        detalhes["Latitude"] = "0.0"
    if detalhes["Longitude"].lower() == "null":
        detalhes["Longitude"] = "0.0"
    return detalhes

# Função para obter dias de consulta para um dispositivo
def obter_dias_consulta(device_id):
    try:
        conn = get_db_connection()
        cursor = conn.cursor(pymysql.cursors.DictCursor)
        cursor.execute("SELECT MAX(datetime_BR) as last_datetime FROM sensor_readings WHERE device_id = %s", (device_id,))
        ultima_data = cursor.fetchone()
        cursor.close()
        conn.close()
        if ultima_data and ultima_data['last_datetime']:
            data_ultima = ultima_data['last_datetime']
            dias_consulta = (datetime.now() - data_ultima).days + 1
        else:
            dias_consulta = 361
            logger.info(f"Dispositivo {device_id} ainda não está cadastrado. Utilizando {dias_consulta} dias.")
    except Exception as e:
        logger.error(f"Erro ao obter dias de consulta para o dispositivo {device_id}: {e}")
        dias_consulta = 361

    return dias_consulta
 
# Função para inserir ou atualizar o status de um dispositivo no banco de dados
def inserir_ou_atualizar_device_status(detalhes):
    cursor = None
    conn = None
    try:
        conn = get_db_connection()
        if not conn:
            raise Exception("Falha ao obter a conexão com o banco de dados.")

        cursor = conn.cursor(pymysql.cursors.DictCursor)
        
        # Verificar se o dispositivo já existe
        select_query = "SELECT COUNT(*) AS count FROM site_devices_status WHERE device_id = %s"
        cursor.execute(select_query, (detalhes.get('Device ID'),))
        result = cursor.fetchone()
        exists = result['count'] if result and result['count'] else 0
        if exists:
            # Se o dispositivo existe, atualiza o registro
            update_query = """
            UPDATE site_devices_status
            SET device_name = %s,
                color = %s,
                latitude = %s,
                longitude = %s,
                last_measurement_datetime = %s,
                received_status = %s,
                battery_voltage = %s,
                href = %s,
                last_updated = CURRENT_TIMESTAMP
            WHERE device_id = %s
            """
            cursor.execute(update_query, (
                detalhes.get('Device Name'),
                detalhes.get('Color'),
                detalhes.get('Latitude'),
                detalhes.get('Longitude'),
                detalhes.get('Last measurement date and time'),
                detalhes.get('Received status'),
                detalhes.get('Battery voltage'),
                detalhes.get('Href'),
                detalhes.get('Device ID')
            ))
            conn.commit()
            logger.info(f"Dados do dispositivo {detalhes.get('Device ID')} atualizados com sucesso.")
        else:
            # Se o dispositivo não existe, insere o registro
            insert_query = """
            INSERT INTO site_devices_status (device_id, device_name, color, latitude, longitude, last_measurement_datetime, received_status, battery_voltage, href)
            VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)
            """
            cursor.execute(insert_query, (
                detalhes.get('Device ID'),
                detalhes.get('Device Name'),
                detalhes.get('Color'),
                detalhes.get('Latitude'),
                detalhes.get('Longitude'),
                detalhes.get('Last measurement date and time'),
                detalhes.get('Received status'),
                detalhes.get('Battery voltage'),
                detalhes.get('Href')
            ))
            conn.commit()
            logger.info(f"Dados do dispositivo {detalhes.get('Device ID')} inseridos com sucesso.")
    
    except Exception as e:
        logger.error(f"Erro ao inserir/atualizar o status do dispositivo: {e}")
    
    finally:
        if cursor:
            cursor.close()
        if conn:
            conn.close()

# Função para processar detalhes dos dispositivos e inserir/atualizar no banco de dados
def processar_detalhes_dispositivos(driver, devices):
    tabela_detalhes = PrettyTable()
    tabela_detalhes.field_names = ["Device ID", "Device Name", "Latitude", "Longitude", "Last measurement datetime", "Received status", "Href"]

    global matriz_detalhes
    matriz_detalhes = []

    for index, device in enumerate(devices, start=1):
        device_id, device_name, href = device[1], device[2], device[3]
        detalhes = extrair_detalhes_device(driver, device_id, href, index, len(devices))

        tabela_detalhes.add_row([
            detalhes.get('Device ID'),
            detalhes.get('Device Name'),
            detalhes.get('Latitude'),
            detalhes.get('Longitude'),
            detalhes.get('Last measurement date and time'),
            detalhes.get('Received status'),
            detalhes.get('Href')
        ])

        # Armazena na lista global
        matriz_detalhes.append([detalhes.get('Device ID'), detalhes.get('Device Name'), detalhes.get('Received status'), detalhes.get('Href')])

        # Insere ou atualiza o status do dispositivo no banco de dados
        inserir_ou_atualizar_device_status(detalhes)

    logger.info("Tabela de Detalhes dos Dispositivos:\n" + tabela_detalhes.get_string())

    return tabela_detalhes

# Função para criar uma pasta temporária para os arquivos CSV
def criar_pasta_temp():
    timestamp = datetime.now().strftime("%Y_%m_%d_%H_%M_%S")
    temp_folder = f"bot_csv_{timestamp}"
    if not os.path.exists(temp_folder):
        os.makedirs(temp_folder)
    return temp_folder

def baixar_csv(driver, device_name, url_csv, download_path, dias_consulta):
  #  logger.info(f"Parâmetro device_name: {device_name}")
  #  logger.info(f"Parâmetro url_csv: {url_csv}")
  #  logger.info(f"Parâmetro download_path: {download_path}") 
  #  logger.info(f"Parâmetro dias_consulta: {dias_consulta}")

    try:
        logger.info(f"Acessando URL CSV: {url_csv}")
        driver.get(url_csv)

        # Esperar que a página carregue completamente
        WebDriverWait(driver, 30).until(
            EC.presence_of_element_located((By.NAME, 'relative_days'))
        )

        logger.info(f"Preenchendo o campo de dias com {dias_consulta} dias.")
        days_input = driver.find_element(By.NAME, 'relative_days')
        days_input.clear()
        days_input.send_keys(str(dias_consulta))

        logger.info("Clicando no botão CSV Export.")
        csv_export_button = driver.find_element(By.XPATH, '//span[text()="CSV Export"]/parent::button')
        csv_export_button.click()

        logger.info("Esperando o download do arquivo CSV.")
        arquivos_antes = set(os.listdir(download_path))
        tempo_maximo_espera = 900  # Tempo máximo de espera em segundos (15 minutos)
        intervalo_espera = 10  # Intervalo de verificação em segundos
        tempo_decorrido = 0

        while tempo_decorrido < tempo_maximo_espera:
            time.sleep(intervalo_espera)
            tempo_decorrido += intervalo_espera
            arquivos_depois = set(os.listdir(download_path))
            novos_arquivos = arquivos_depois - arquivos_antes

            if novos_arquivos:
                for arquivo in novos_arquivos:
                    if arquivo.endswith('.csv'):
                        arquivo_csv = os.path.join(download_path, arquivo)
                        if os.path.exists(arquivo_csv) and os.path.getsize(arquivo_csv) > 0:
                            logger.info(f"Arquivo CSV baixado com sucesso em: {arquivo_csv}")
                            return arquivo_csv, True
                        else:
                            logger.error(f"Falha ao baixar o arquivo CSV ou arquivo vazio: {arquivo_csv}")
                            return None, False

            logger.info(f"Aguardando {tempo_decorrido}/{tempo_maximo_espera} segundos pelo arquivo CSV.")

        logger.error("Falha ao baixar o arquivo CSV dentro do tempo máximo de espera.")
        return None, False
    except Exception as e:
        logger.error(f"Erro ao baixar o arquivo CSV: {e}")
        return None, False

# Função para carregar CSV dos dispositivos
def carregar_csv_01(driver, download_path):
    resultados_download = []
     # Contar o número de linhas onde linha[2] == "OK"
    numero_de_linhas = len(matriz_detalhes)
    linhas_ok = [linha for linha in matriz_detalhes if linha[2] == "OK"]
    numero_de_linhas_ok = len(linhas_ok)
    logger.info(f"Número de linhas em matriz_detalhes com 'OK': {numero_de_linhas_ok}/{numero_de_linhas}")
    cont=0
    for linha in linhas_ok:
        cont+=1
        device_id = linha[0]
        device_name = linha[1]
        href = linha[3]
        url_csv = f"{href}/csv"
        dias_consulta = obter_dias_consulta(device_id)           
        try:
            logger.info(f"{cont}/{numero_de_linhas_ok} Baixando CSV para o dispositivo {device_id} ({device_name})   Dias de consulta: {dias_consulta}")
            arquivo_csv, sucesso = baixar_csv(driver, device_name, url_csv, download_path, dias_consulta)
            if sucesso:
                tamanho_arquivo = os.path.getsize(arquivo_csv)
                resultados_download.append([device_id, device_name, "sim", tamanho_arquivo, arquivo_csv])
            else:
                resultados_download.append([device_id, device_name, "não", 0, ""])
        except Exception as e:
            logger.error(f"Erro ao carregar o CSV para o dispositivo {device_id}: {e}")
            resultados_download.append([device_id, device_name, "não", 0, ""])

    mostrar_tabela_download(resultados_download, numero_de_linhas_ok, numero_de_linhas)

# Função para mostrar tabela de downloads
def mostrar_tabela_download(resultados_download, numero_de_linhas_ok, numero_de_linhas):
    tabela_download = PrettyTable()
    tabela_download.field_names = ["Device_ID", "Device_Name", "Download", "Tamanho do Arquivo (bytes)", "Local do Arquivo"]
    for resultado in resultados_download:
        tabela_download.add_row(resultado)
    logger.info("Tabela de Downloads:\n" + tabela_download.get_string())
    logger.info(f"Downloads bem-sucedidos: {numero_de_linhas_ok}/{numero_de_linhas}")

# Função para processar o CSV baixado
def processar_csv(arquivo_csv):
    try:
        df = pd.read_csv(arquivo_csv)
        # Realizar o processamento necessário no DataFrame, como limpeza de dados, transformações, etc.
        logger.info(f"Arquivo CSV processado com sucesso: {arquivo_csv}")
    except Exception as e:
        logger.error(f"Erro ao processar o arquivo CSV: {e}")

# Função para copiar arquivos para a pasta pasta_csv_baixados
def copiar_arquivos_para_csv_baixados(temp_folder, pasta_csv_baixados):
    try:
        if not os.path.exists(pasta_csv_baixados):
            os.makedirs(pasta_csv_baixados)
        else:
            # Excluir todos os arquivos existentes na pasta pasta_csv_baixados
            for arquivo_existente in os.listdir(pasta_csv_baixados):
                arquivo_existente_path = os.path.join(pasta_csv_baixados, arquivo_existente)
                if os.path.isfile(arquivo_existente_path):
                    os.remove(arquivo_existente_path)
                logger.info(f"Arquivo {arquivo_existente} excluído da pasta {pasta_csv_baixados}.")
        
        # Copiar os novos arquivos para a pasta pasta_csv_baixados
        for arquivo in os.listdir(temp_folder):
            src_file = os.path.join(temp_folder, arquivo)
            dst_file = os.path.join(pasta_csv_baixados, arquivo)
            shutil.copy(src_file, dst_file)
        logger.info(f"Todos os arquivos CSV foram copiados para a pasta {pasta_csv_baixados}.")
    except Exception as e:
        logger.error(f"Erro ao copiar arquivos para a pasta {pasta_csv_baixados}: {e}")

# Função para ler a configuração do banco de dados
def ler_config_db():
    try:
        config_path = os.path.join(os.getcwd(), 'xml', 'config.xml')  # Ajuste o caminho conforme necessário
        tree = ET.parse(config_path)
        root = tree.getroot()
        config = {
            'host': root.find('database/db_host').text,
            'user': root.find('database/db_user').text,
            'password': root.find('database/db_password').text,
            'database': root.find('database/db_name').text
        }
        return config
    except Exception as e:
        logger.error(f"Erro ao ler o arquivo de configuração: {e}")
        return None

# Função para obter a conexão com o banco de dados
def get_db_connection():
    try:
        config = ler_config_db()
        if not config:
            raise Exception("Falha ao obter a configuração do banco de dados.")
        conn = pymysql.connect(
            host=config['host'],
            user=config['user'],
            password=config['password'],
            database=config['database'],
            cursorclass=pymysql.cursors.DictCursor
        )
        return conn
    except pymysql.Error as e:
        logger.error(f"Erro ao conectar ao banco de dados: {e}")
        return None
    
# Função principal para executar o bot
def executar_bot(mode):
    logger = configurar_logger(mode)
    logger.info("\n ********  Iniciando o script Sensores_01_Bot_Site.py ******\n")
    api_config = ler_config_api()
    driver_path = api_config['driver_path']
    login_url = 'https://g3-app.e-kakashi.com/login'
    username = api_config['username']
    password = api_config['password']   
    logger.info(f"Usando driver path: {driver_path}")
    logger.info(f"Usando username: {username}")
    
    # Criar pasta temporária para salvar os arquivos .csv
    temp_folder = criar_pasta_temp()
    logger.info(f"Pasta temporária criada: {temp_folder}")

    # Configurar e iniciar o WebDriver
    modo_oculto = mode == '0'
    driver = configurar_webdriver(temp_folder, driver_path, modo_oculto)
    logger.info(f"WebDriver configurado com o caminho de download: {temp_folder}")

    acessar_pagina_login(driver, login_url)
    fazer_login(driver, username, password)
    verificar_pagina_principal(driver)
    acessar_lista_devices(driver)

    devices = extrair_dados_devices(driver)
    mostrar_tabela_devices(devices)
    tabela_detalhes = processar_detalhes_dispositivos(driver, devices)
    
    carregar_csv_01(driver, temp_folder)

    driver.quit()

    # Chamada da função copiar_arquivos_para_csv_baixados com os dois argumentos
    copiar_arquivos_para_csv_baixados(temp_folder, pasta_csv_baixados)

    return tabela_detalhes

# Chamar o script Sensores_02_CSV_Upload.py ao final
if __name__ == "__main__":

    mode = sys.argv[1] if len(sys.argv) > 1 else '1'
    tabela_detalhes = executar_bot(mode)

    # Chamar o script Sensores_02_CSV_Upload.py ao final
    try:
        logger.info("\n\nChamando o script Sensores_02_CSV_Upload.py")
        subprocess.run(['python', 'Sensores_02_CSV_Upload.py', mode], check=True)
        logger.info("Script Sensores_02_CSV_Upload.py executado com sucesso.\n")
    except subprocess.CalledProcessError as e:
        logger.error(f"Erro ao executar o script Sensores_02_CSV_Upload.py: {e}")
    except Exception as e:
        logger.error(f"Ocorreu um erro inesperado ao chamar o script Sensores_02_CSV_Upload.py: {e}")

