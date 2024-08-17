import pymysql
import logging
import xml.etree.ElementTree as ET

logger = logging.getLogger(__name__)

def ler_config_db():
    try:
        tree = ET.parse('xml/config.xml')
        root = tree.getroot()
        
        config = {
            'db_host': root.find('database/db_host').text if root.find('database/db_host') is not None else None,
            'db_port': int(root.find('database/db_port').text) if root.find('database/db_port') is not None else 3306,
            'db_user': root.find('database/db_user').text if root.find('database/db_user') is not None else None,
            'db_password': root.find('database/db_password').text if root.find('database/db_password') is not None else None,
            'db_name': root.find('database/db_name').text if root.find('database/db_name') is not None else None
        }
        
        if None in config.values():
            raise ValueError("Um ou mais elementos de configuração estão ausentes ou são inválidos.")
        
        return config
    except Exception as e:
        logger.error(f"Erro ao ler o arquivo de configuração: {e}")
        return None

def get_db_connection():
    config = ler_config_db()
    if config is None:
        return None
    
    try:
        connection = pymysql.connect(
            host=config['db_host'],
            port=config['db_port'],
            user=config['db_user'],
            password=config['db_password'],
            db=config['db_name'],
            charset='utf8mb4',
            cursorclass=pymysql.cursors.DictCursor
        )
        return connection
    except pymysql.MySQLError as e:
        logger.error(f"Erro ao conectar ao MySQL: {e}")
        return None
