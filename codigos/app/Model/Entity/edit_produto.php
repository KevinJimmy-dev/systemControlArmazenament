<?php
//Arquivo para editar produtos

//Inicia a sessão
session_start(); 

//Incluindo o arquivo de conexão
include_once 'conexao.php'; 

//Variáveis que pegam os novos valores na input
$id_produto         = filter_input(INPUT_POST, 'id_produto',         FILTER_SANITIZE_NUMBER_INT);
$nome_produto       = filter_input(INPUT_POST, 'nome_produto',       FILTER_SANITIZE_STRING);
$quantidade_produto = filter_input(INPUT_POST, 'quantidade_produto', FILTER_SANITIZE_STRING);
$validade_produto   = filter_input(INPUT_POST, 'validade_produto',   FILTER_SANITIZE_STRING);
$entrega_produto    = filter_input(INPUT_POST, 'entrega_produto',    FILTER_SANITIZE_STRING);
$observacao_produto = filter_input(INPUT_POST, 'observacao_produto', FILTER_SANITIZE_STRING);
$id_categoria       = filter_input(INPUT_POST, 'categoria_produto',  FILTER_SANITIZE_NUMBER_INT);

//Comando que possui o update
$result_produto = "UPDATE produto SET nome_produto = '$nome_produto', quantidade_produto = '$quantidade_produto', validade_produto = '$validade_produto', entrega_produto = '$entrega_produto', observacao_produto = '$observacao_produto', id_categoria = '$id_categoria' WHERE id_produto = '$id_produto'";

//Busca o id do produto
$busca_produto = "SELECT id_produto FROM produto WHERE nome_produto = '$nome_produto'";
$exec = mysqli_query($conexaoMysqli, $busca_produto);

//Caso o produto já exista
if (mysqli_num_rows($exec) >= 2) {
    //Imprimi uma mensagem e realoca o usuário para a página de editar produtos
    echo "<script>alert('Esse produto já existe!');</script>";
    echo "<script>window.location.href = '../../../resources/View/Pages/editar_produto.php?id_produto=$id_produto'</script>";

//Se não existir, executa o update
} else if ($resultado_produto = mysqli_query($conexaoMysqli, $result_produto)) {
    //Imprimi uma mensagem e realoca o usuário para a página dos funcionários
    $_SESSION['msg'] = "<p style='color:green;'>O Produto foi editado com sucesso!</p>";
    header("Location: ../../resources/View/Pages/funcionario.php");

//Se não der certo  
} else {
    //Imprimi uma mensagem de erro e realoca o usuário para a página de editar
    $_SESSION['msg'] = "<p style='color:red;'>ERRO: O Produto não foi editado!</p>";
    header("Location: ../../../resources/View/Pages/editar_produto.php?id=$id_produto");
}