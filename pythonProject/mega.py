import serial
import sqlite3
import datetime

# Configurações da porta serial
porta_serial = serial.Serial('/dev/ttyACM0', 9600)  # Substitua '/dev/ttyACM0' pelo dispositivo correto da porta serial
porta_serial.timeout = 1  # Define o tempo limite de leitura da porta serial

# Conexão com o banco de dados
conexao = sqlite3.connect('Arduino_Esp32.db')
cursor = conexao.cursor()

# Cria a tabela "hora_acesso" se não existir
cursor.execute("CREATE TABLE IF NOT EXISTS hora_acesso (acessado TEXT, dia TEXT, hora TEXT)")

# Loop principal
while True:
    # Verifica se há dados disponíveis na porta serial
    if porta_serial.in_waiting > 0:
        # Lê a linha da porta serial e decodifica para string
        senha = porta_serial.readline().decode().strip().replace(" ", "")

        # Consulta o banco de dados
        cursor.execute("SELECT usuario FROM usuario_senha WHERE senha=?", (senha,))
        resultado = cursor.fetchone()

        # Verifica se a senha corresponde a um usuário válido
        if resultado is not None:
            usuario = resultado[0]
            print(f"Usuário: {usuario}")

            # Obtém a data e hora atual
            data_atual = datetime.date.today().strftime("%Y-%m-%d")
            hora_atual = datetime.datetime.now().strftime("%H:%M:%S")

            # Insere o registro na tabela "hora_acesso"
            cursor.execute("INSERT INTO hora_acesso (acessado, dia, hora) VALUES (?, ?, ?)", (usuario, data_atual, hora_atual))
            conexao.commit()

            # Envia sinal para o Arduino abrir o cofre
            porta_serial.write(b'1')  # Envie o sinal desejado para o Arduino
        #else:
        #   print("Senha inválida")

# Fecha a conexão com o banco de dados
conexao.close()
