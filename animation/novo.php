<?php
$conexao = new SQLite3('/home/SamuelLucas/arduinomega/pythonProject/Arduino_Esp32.db');

header("Refresh:16");

$query = "SELECT * FROM hora_acesso";
$resultado = $conexao->query($query);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Tabela de Acessos</title>

    <style>

      @import url('https://fonts.googleapis.com/css2?family=Lato:wght@300&family=Merriweather+Sans:wght@600&display=swap');

    body {
    font-family: Arial, sans-serif;
    color: #ffffff;
    margin: 0;
    padding: 0;
    background-color: black;
}

.video-background {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    z-index: -1;
}

.video-background video {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    min-width: 100%;
    min-height: 100%;
    width: auto;
    height: auto;
}

h1 {
    color: rgb(11, 219, 42);
    margin-top: 70px;
    text-align: center;
    font-size: 60px;
    text-shadow: 6px 10px 6px rgba(11, 219, 42, 0.451);
    margin-bottom: 20px; 
    font-family: 'Lato', sans-serif;

}

.console-main {
    border-color: #ae12c2;
    display: flex;
    justify-content: center;
    align-items: flex-start; /* Altere 'center' para 'flex-start' */
    height: 20vh;
    width: 80vw;
    margin: 0 auto;
    margin-top: 30px;
     /* Adicione overflow-y: auto para permitir a rolagem vertical */
}

table {
    table-layout: fixed;
    width: 70%;
    margin: 20px auto; /* Use 'auto' para centralizar horizontalmente e remover a margem direita */
    border: 1px solid rgba(15, 222, 53, 0.6);
    border-width: 3px;
    box-shadow: #ffffff;
}

th,
td {
    padding: 5px;
}

th {
    background-color: rgba(255, 255, 255, 0.52);
    text-align: left;
    border: #ffffff;
    font-family: 'Merriweather Sans', sans-serif;

}

tr:nth-child(even) {
    background-color: #6fee715e;
}

tr:hover {
    background-color: #ae12c2;
}

    </style>

</head>
<body>
    <div class="video-background">
        <video autoplay muted loop>
            <source src="thme10.mp4" type="video/mp4">
        </video>
    </div>
    
    <h1>Registros de Acesso</h1>
    <?php if ($row = $resultado->fetchArray(SQLITE3_ASSOC)) : ?>
    <div class="console-main"> 
        <table>
            <tr>
                <th>ID</th>
                <th>Acessado</th>
                <th>Dia</th>
                <th>Hora</th>
            </tr>
            <?php do { ?>
                <tr>
                    <td><?php echo $row['ID']; ?></td>
                    <td><?php echo $row['Acessado']; ?></td>
                    <td><?php echo $row['dia']; ?></td>
                    <td><?php echo $row['hora']; ?></td>
                </tr>
            <?php } while ($row = $resultado->fetchArray(SQLITE3_ASSOC)); ?>
        </table>
    </div>
    <script>
    // Função para rolar a tabela até o final
    function rolarTabela() {
        var tabela = document.getElementById("tabela-acessos");
        tabela.scrollTop = tabela.scrollHeight;
    }

    // Chama a função para rolar a tabela assim que a página é carregada
    window.onload = function() {
        rolarTabela();
    };
</script>

    <?php else: ?>
        <p>Nenhum dado encontrado.</p>
    <?php endif; ?>

    <?php $conexao->close(); ?>
</body>
</html>

