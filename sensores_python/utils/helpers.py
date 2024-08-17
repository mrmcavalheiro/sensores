def log_mensagem(mensagem):
    from datetime import datetime
    data_hora = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
    mensagem_completa = f"{data_hora} - {mensagem}"
    print(mensagem_completa)
    with open("log.txt", "a") as log_file:
        log_file.write(mensagem_completa + "\n")
