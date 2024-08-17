import time
import pandas as pd
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from bs4 import BeautifulSoup
import logging

logger = logging.getLogger()

def acessar_pagina_login(driver, login_url):
    driver.get(login_url)

def fazer_login(driver, username, password):
    username_input = WebDriverWait(driver, 20).until(
        EC.presence_of_element_located((By.NAME, 'id'))
    )
    username_input.send_keys(username)

    password_input = driver.find_element(By.NAME, 'password')
    password_input.send_keys(password)

    terms_checkbox = driver.find_element(By.NAME, 'terms')
    if not terms_checkbox.is_selected():
        terms_checkbox.click()

    login_button = driver.find_element(By.XPATH, '//button[@type="submit"]/span/span[text()="サインイン"]')
    login_button.click()

    WebDriverWait(driver, 40).until(EC.url_contains('https://g3-app.e-kakashi.com/'))

def acessar_lista_devices(driver):
    driver.get("https://g3-app.e-kakashi.com/setting/devices")
    time.sleep(15)
    WebDriverWait(driver, 40).until(EC.presence_of_element_located((By.XPATH, '//h2[text()="Device list"]')))
    time.sleep(10)

def extrair_dados_devices(driver):
    devices = driver.find_elements(By.XPATH, '//a[@class="MuiTableRow-root MuiTableRow-hover"]')
    data = []
    for device in devices:
        device_name = device.find_element(By.CLASS_NAME, 'MuiTableCell-body').text
        device_id = device.get_attribute('href').split('/')[-1]
        href = device.get_attribute('href')
        data.append((device_name, device_id, href))
    return data

def extrair_detalhes_device(driver, device_id, href):
    driver.get(href)
    WebDriverWait(driver, 20).until(EC.presence_of_element_located((By.XPATH, '//div[@class="MuiContainer-root MuiContainer-maxWidthSm"]')))
    time.sleep(5)

    page_source = driver.page_source
    soup = BeautifulSoup(page_source, 'html.parser')

    container_div = soup.find('div', class_='MuiContainer-root MuiContainer-maxWidthSm')
    detalhes = {}
    download_available = False

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

        if soup.find('a', {'href': lambda x: x and x.endswith('/csv')}):
            download_available = True

    # Buscando e exibindo o conteúdo do <div class="MuiBox-root jss174">
    main_div = soup.find('main', class_='jss2')
    if main_div:
        content_div = main_div.find('div', class_='MuiBox-root jss174')
        if content_div:
            logger.info("Conteúdo do <div class='MuiBox-root jss174'> encontrado:")
            logger.info(content_div.prettify())
        else:
            logger.info("<div class='MuiBox-root jss174'> não encontrado.")
    else:
        logger.info("<main class='jss2'> não encontrado.")

    detalhes["Device ID"] = device_id
    detalhes.setdefault("Device Name", None)
    detalhes.setdefault("Color", None)
    detalhes.setdefault("Last measurement date and time", None)
    detalhes.setdefault("Received status", None)
    detalhes.setdefault("Battery voltage", None)
    detalhes.setdefault("Href", href)
    detalhes["Download"] = download_available

    return detalhes

def filtrar_dispositivos(data, ids_interesse):
    df_devices = pd.DataFrame(data, columns=['Device Name', 'Device ID', 'Href'])
    dispositivos_interesse = df_devices[df_devices['Device ID'].isin(ids_interesse)]
    return dispositivos_interesse
