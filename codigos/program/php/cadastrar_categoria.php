<?php
//Página para cadastrar uma categoria
include("conexao.php");

session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("location: ../../login/php/login.php"); 
    exit; 
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Categoria</title>
</head>

<body>
    <a href="del_categoria.php">Voltar</a>
    <h1>Cadastrar Categoria</h1>

    <form method="POST" action="cad_categoria.php">
        <label>Nome da Categoria: </label> <abbr title="Campo obrigatório">*</abbr>
        <input type="text" required name="categoria" maxlength="75" placeholder="Digite o nome da categoria"><br><br>

        <input type="submit" value="Cadastrar">
    </form>
</body>

</html>