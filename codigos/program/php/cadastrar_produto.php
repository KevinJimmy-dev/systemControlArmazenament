<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Produto</title>
</head>
<body>
    <h1>Cadastrar produto</h1>
    <?php 
    if(isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    ?>
    <form method="POST" action="processa.php">
        <label>Produto: </label>
        <input type="text" name="nome_produto" placeholder="Digite o nome do produto"><br><br>

        <label>Quantidade: </label>
        <input type="number" name="quantidade_produto" placeholder="Digite a quantidade"><br><br>

        <label>Validade: </label>
        <input type="date" name="validade_produto"><br><br>

        <label>Data de entrega: </label>
        <input type="date" name="entrega_produto" ><br><br>

        <label>Observação:</label>
        <input type="text" name="observacao_produto" placeholder="Se tiver alguma observação..."><br><br>

        <input type="submit" value="CADASTRAR">
    </form>
</body>
</html>