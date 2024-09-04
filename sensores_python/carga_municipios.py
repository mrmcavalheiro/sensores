import requests
import mysql.connector

# Conexão com o banco de dados MySQL
conn = mysql.connector.connect(
    host="200.132.192.32",
    user="RedeSensores",
    password="Rede2024",
    database="baseSensores"

)

cursor = conn.cursor()

# Criar a tabela
cursor.execute("""
CREATE TABLE IF NOT EXISTS municipios (
    id INT NOT NULL PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    uf VARCHAR(2) NOT NULL,
    codigo_ibge INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
""")

# Requisição à API do IBGE para obter a lista de municípios
response = requests.get("https://servicodados.ibge.gov.br/api/v1/localidades/municipios")
municipios = response.json()

# Inserir os dados na tabela
for municipio in municipios:
    cursor.execute("""
    INSERT INTO municipios (id, nome, uf, codigo_ibge)
    VALUES (%s, %s, %s, %s)
    """, (
        municipio['id'],
        municipio['nome'],
        municipio['microrregiao']['mesorregiao']['UF']['sigla'],
        municipio['codigo_ibge']
    ))

# Commit e fechar a conexão
conn.commit()
cursor.close()
conn.close()
