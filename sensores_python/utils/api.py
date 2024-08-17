import xml.etree.ElementTree as ET
import logging

logger = logging.getLogger(__name__)

def ler_config_api():
    try:
        tree = ET.parse('xml/config.xml')
        root = tree.getroot()
        
        config = {
            'api_url': root.find('api/api_host').text if root.find('api/api_host') is not None else None,
            'username': root.find('api/id').text if root.find('api/id') is not None else None,
            'password': root.find('api/password').text if root.find('api/password') is not None else None,
            'driver_path': root.find('driver/driver_path').text if root.find('driver/driver_path') is not None else None
        }
        
        if None in config.values():
            raise ValueError("Um ou mais elementos de configuração estão ausentes ou são inválidos.")
        
        return config
    except Exception as e:
        logger.error(f"Erro ao ler o arquivo de configuração: {e}")
        return None

def obter_token_do_arquivo():
    try:
        tree = ET.parse('xml/token.xml')
        root = tree.getroot()
        return root.find('token').text
    except Exception as e:
        logger.error(f"Erro ao ler o arquivo de token: {e}")
        return None

def verificar_token(token):
    return token is not None and len(token) > 0

def salvar_token(token):
    try:
        root = ET.Element("root")
        ET.SubElement(root, "token").text = token
        tree = ET.ElementTree(root)
        tree.write('xml/token.xml')
    except Exception as e:
        logger.error(f"Erro ao salvar o token: {e}")

def obter_token(api_url, username, password):
    # Implementar a lógica para obter um novo token usando a api_url e credenciais
    return "novo_token"
