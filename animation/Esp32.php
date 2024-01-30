<?php

$conexao = new SQLite3('/home/SamuelLucas/arduinomega/pythonProject/Arduino_Esp32.db');

header("Refresh:1");

$query = "SELECT * FROM hora_acesso";
$resultado = $conexao->query($query);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Tabela de Acessos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #f2f2f2;
            text-align: left;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <h1>Banco do Cofre</h1>
    <?php if ($resultado->fetchArray()) : ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Acessado</th>
            <th>Dia</th>
            <th>Hora</th>
        </tr>
        <?php while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) : ?>
        <tr>
            <td><?php echo $row['ID']; ?></td>
            <td><?php echo $row['Acessado']; ?></td>
            <td><?php echo $row['dia']; ?></td>
            <td><?php echo $row['hora']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php else : ?>
    <p>Nenhum dado encontrado.</p>
    <?php endif; ?>
</body>
</html>

<?php

$conexao->close();

?>
