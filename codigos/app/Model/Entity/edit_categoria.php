<?php
//Arquivo para editar categoria
session_start();

//Inclui o arquivo de conexão
include_once 'conexao.php';

//Variáveis recebendo os valores da ID e nome
$id_categoria   = filter_input(INPUT_POST, 'id_categoria', FILTER_SANITIZE_NUMBER_INT);
$nome_categoria = filter_input(INPUT_POST, 'nome_categoria', FILTER_SANITIZE_STRING);

//Update
$result_produto = "UPDATE categorias_de_produtos SET nome_categoria = '$nome_categoria' WHERE id_categoria = '$id_categoria'";

//Busca o nome da categoria do banco
$busca_categoria = "SELECT nome_categoria FROM categorias_de_produtos WHERE nome_categoria = '$nome_categoria'";
$resultado_categoria = mysqli_query($conexaoMysqli, $busca_categoria);

//Caso o nome seja igual a um que já exista
if (mysqli_num_rows($resultado_categoria) >= 1) {
    //Mostra um alert e realoca o usuário para a página de editar
    echo "<script>alert('Essa categoria já existe!');</script>";
    echo "<script>window.location.href = '../../../resources/View/Pages/editar_categoria.php?id_categoria=$id_categoria'</script>";

//Senão, executa o update
} else if (mysqli_query($conexaoMysqli, $result_produto)) {
    //Imprimi uma mensagem e realoca o usuario para a página que exibe as categorias
    $_SESSION['msg'] = "<p style='color:green;'>A Categoria foi editada com sucesso!</p>";
    header("Location: ../../resources/View/Pages/exibir_categorias.php");

//Se não fizer nenhuma alteração, der erro
} else {
    //Imprimi uma mensagem e realoca o usuário para a página de editar categoria
    $_SESSION['msg'] = "<p style='color:red;'>ERRO: A Categoria não foi editada!</p>";
    header("Location: ../../../resources/View/Pages/editar_categoria.php?id=$id_categoria");
}