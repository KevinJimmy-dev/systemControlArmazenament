<?php
session_start(); //inicia a sessão...
include_once("conexao.php"); //incluindo o arquivo de conexão....

$result_produto = "UPDATE armazenamento SET nome_produto = '$nome_produto', quantidade_produto = '$quantidade_produto', validade_produto = '$validade_produto', entrega_produto = '$entrega_produto', observacao_produto = '$observacao_produto' WHERE id_produto = '$id_produto'"; //variavel que contém o comando de update, para atualizar no banco de dados o produto...
$resultado_produto = mysqli_query($conexaoMysqli, $result_produto); //variavel que faz a conexão...

if(mysqli_affected_rows($conexaoMysqli)){ //se alguma coisa foi alterada no banco de dados,
    $_SESSION['msg'] = "<p style='color:green;'>Produto com o nome de: <strong style='color:black'>". $nome_produto . "</strong>, e com o ID <strong style='color:black'>" . $id_produto . "</strong>, foi editado com sucesso!</p>"; //vai aparecer essa mensagem...
    header("Location: areaPrivada.php"); //vai redirecionar para a areaPrivada.php...
} else{
    $_SESSION['msg'] = "<p style='color:red;'>Produto não foi editado com sucesso!</p>";
    header("Location: editar_produto.php?id=$id_produto"); //caso nada for alterado, vai aparecer essa mensagem... 
}
?>