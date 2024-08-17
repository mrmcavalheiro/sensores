import pymysql
import logging
from logging.handlers import RotatingFileHandler
import datetime
import os
import sys
from utils.database import get_db_connection
import subprocess

# Configuração do logger
logger = None

def configurar_logger():
    global logger
    if not os.path.exists('log'):
        os.makedirs('log')
    data_atual = datetime.datetime.now().strftime("%Y_%m_%d_%H_%M")
    log_filename = os.path.join('log', f"Sensores_04_Calcula_Media_{data_atual}.log")

    log_format = logging.Formatter('%(asctime)s - %(levelname)s - %(message)s')

    file_handler = RotatingFileHandler(log_filename, maxBytes=5*1024*1024, backupCount=2)
    file_handler.setFormatter(log_format)

    logger = logging.getLogger()
    logger.setLevel(logging.INFO)
    logger.addHandler(file_handler)

    console_handler = logging.StreamHandler()
    console_handler.setFormatter(log_format)
    logger.addHandler(console_handler)

def atualizar_medias_tabelas():
    try:
        conn = get_db_connection()
        if conn is None:
            return

        with conn.cursor() as cursor:
            # Atualizar daily_sensor_averages_Jap
            logger.info("Atualizando daily_sensor_averages_Jap...")
            sql_jap = """
            INSERT INTO daily_sensor_averages_Jap (device_id, date_Jap, avg_soil_vwc_s1, avg_soil_vwc_s2)
            SELECT 
                device_id,
                DATE(datetime_Jap) AS date_Jap,
                CASE WHEN COUNT(soil_vwc_s1) > 0 THEN ROUND(AVG(soil_vwc_s1), 5) ELSE NULL END AS avg_soil_vwc_s1,
                CASE WHEN COUNT(soil_vwc_s2) > 0 THEN ROUND(AVG(soil_vwc_s2), 5) ELSE NULL END AS avg_soil_vwc_s2
            FROM 
                sensor_readings
            GROUP BY 
                device_id, DATE(datetime_Jap)
            ON DUPLICATE KEY UPDATE
                avg_soil_vwc_s1 = VALUES(avg_soil_vwc_s1),
                avg_soil_vwc_s2 = VALUES(avg_soil_vwc_s2)
            """
            linhas_afetadas = cursor.execute(sql_jap)
            logger.info(f"{linhas_afetadas} linhas afetadas em daily_sensor_averages_Jap.")

            # Atualizar daily_sensor_averages_BR
            logger.info("Atualizando daily_sensor_averages_BR...")
            sql_br = """
            INSERT INTO daily_sensor_averages_BR (device_id, date_BR, avg_soil_vwc_s1, avg_soil_vwc_s2)
            SELECT 
                device_id,
                DATE(datetime_BR) AS date_BR,
                CASE WHEN COUNT(soil_vwc_s1) > 0 THEN ROUND(AVG(soil_vwc_s1), 5) ELSE NULL END AS avg_soil_vwc_s1,
                CASE WHEN COUNT(soil_vwc_s2) > 0 THEN ROUND(AVG(soil_vwc_s2), 5) ELSE NULL END AS avg_soil_vwc_s2
            FROM 
                sensor_readings
            GROUP BY 
                device_id, DATE(datetime_BR)
            ON DUPLICATE KEY UPDATE
                avg_soil_vwc_s1 = VALUES(avg_soil_vwc_s1),
                avg_soil_vwc_s2 = VALUES(avg_soil_vwc_s2)
            """
            linhas_afetadas = cursor.execute(sql_br)
            logger.info(f"{linhas_afetadas} linhas afetadas em daily_sensor_averages_BR.")

            # Atualizar region_daily_averages
            logger.info("Atualizando region_daily_averages...")
            sql_region = """
            INSERT INTO region_daily_averages (region_id, device_id, date_BR, avg_soil_vwc_s1, avg_soil_vwc_s2)
            SELECT 
                rd.region_id,
                srs.device_id,
                DATE(srs.datetime_BR) AS date_BR,
                CASE WHEN COUNT(srs.soil_vwc_s1) > 0 THEN ROUND(AVG(srs.soil_vwc_s1), 5) ELSE NULL END AS avg_soil_vwc_s1,
                CASE WHEN COUNT(srs.soil_vwc_s2) > 0 THEN ROUND(AVG(srs.soil_vwc_s2), 5) ELSE NULL END AS avg_soil_vwc_s2
            FROM 
                sensor_readings srs
            JOIN 
                region_device rd ON srs.device_id = rd.device_id
            GROUP BY 
                rd.region_id, srs.device_id, DATE(srs.datetime_BR)
            ON DUPLICATE KEY UPDATE
                avg_soil_vwc_s1 = VALUES(avg_soil_vwc_s1),
                avg_soil_vwc_s2 = VALUES(avg_soil_vwc_s2)
            """
            linhas_afetadas = cursor.execute(sql_region)
            logger.info(f"{linhas_afetadas} linhas afetadas em region_daily_averages.")

        conn.commit()
    except Exception as e:
        logger.error(f"Erro ao atualizar médias nas tabelas: {e}")
    finally:
        conn.close()
if __name__ == "__main__":
    if len(sys.argv) < 2:
        print(f"Modo não especificado. Use '0', '1', '2' ou '3'.")
    else:
        mode = sys.argv[1] if len(sys.argv) > 1 else '1'
        configurar_logger()
        logger.info("\n ********  Iniciando o script Sensores_04_Calcula_Media.py ******\n")
        atualizar_medias_tabelas()
