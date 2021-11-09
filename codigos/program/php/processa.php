<?php

session_start();
include_once("conexao.php");

$nome_produto = filter_input(INPUT_POST, 'nome_produto', FILTER_SANITIZE_STRING);
$quantidade_produto = filter_input(INPUT_POST, 'quantidade_produto', FILTER_SANITIZE_NUMBER_INT);
$validade_produto = filter_input(INPUT_POST, 'validade_produto', FILTER_SANITIZE_STRING);
$entrega_produto = filter_input(INPUT_POST, 'entrega_produto', FILTER_SANITIZE_STRING);
$observacao_produto =  filter_input(INPUT_POST, 'observacao_produto', FILTER_SANITIZE_STRING);

$result_produto = "INSERT INTO armazenamento (nome_produto, quantidade_produto, validade_produto, entrega_produto, observacao_produto) VALUES ('$nome_produto', '$quantidade_produto', '$validade_produto', '$entrega_produto', '$observacao_produto')";
$resultado_produto = mysqli_query($conexaoMysqli, $result_produto);

if(mysqli_insert_id($conexaoMysqli)){
    $_SESSION['msg'] = "<p style='color:green;'>Produto com o nome de: <strong style='color:black'>".       $nome_produto . "</strong> foi cadastrado com sucesso!</p>" . $tabela;

    header("Location: areaPrivada.php");
} else{
    $_SESSION['msg'] ="<p style='color:red;'>Produto não foi cadastrado com sucesso!</p>";
    header("Location: areaPrivada.php");
}

?>