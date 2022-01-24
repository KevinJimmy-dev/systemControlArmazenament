<?php
//Arquivo de código para cadastrar uma categoria nova
session_start();
include_once("conexao.php");

$busca = "SELECT nome_categoria FROM categorias_de_produtos";
$result = mysqli_query($conexaoMysqli, $busca);
$resu = mysqli_fetch_assoc($result);

$categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_STRING);

//Comando do MYSQL, e execução do comando
$insert_categoria = "INSERT INTO categorias_de_produtos (nome_categoria) VALUES ('$categoria')";

if ($categoria == "") {
    echo "<script>alert('Por favor, preencha o campo com um nome válido!');</script>";
    echo "<script>window.location.href = 'cadastrar_categoria.php';</script>";
} else if ($categoria == $resu['nome_categoria']) {
    echo "<script>alert('Essa categoria já existe!');</script>";
    echo "<script>window.location.href = 'cadastrar_categoria.php';</script>";
} else {
    $result = mysqli_query($conexaoMysqli, $insert_categoria);
    //Se afetar alguma linha
    if (mysqli_affected_rows($conexaoMysqli)) {
        $_SESSION['msg'] = "<p style='color:green;'>Uma nova Categoria foi adicionada com sucesso!</p>";
        header("Location: del_categoria.php");
    } else {
        //Senão
        $_SESSION['msg'] = "<p style='color:red;'>Erro ao adicionar nova Categoria!</p>";
        header("Location: del_categoria.php");
    }
}
