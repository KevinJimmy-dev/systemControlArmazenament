<?php
session_start(); //inicia a sessão...
include_once("conexao.php"); //incluindo o arquivo de conexão....

$id_produto = filter_input(INPUT_GET, 'id_produto', FILTER_SANITIZE_NUMBER_INT);
if(!empty($id_produto)){
    $result_produto = "DELETE FROM armazenamento WHERE id_produto = '$id_produto'";
    $resultado_produto = mysqli_query($conexaoMysqli, $result_produto);
    if(mysqli_affected_rows($conexaoMysqli)){
        $_SESSION['msg'] = "<p style='color:green;'>Produto com o nome de: <strong style='color:black'>". $nome_produto . "</strong>, e com o ID <strong style='color:black'>" . $id_produto . "</strong>, foi apagado com sucesso!</p>";
        header("Location: areaPrivada.php");
    } else{
        $_SESSION['msg'] = "<p style='color:red;'>Produto não foi apagado com sucesso!</p>";
        header("Location: areaPrivada.php");
        }
} else{
    $_SESSION['msg'] = "<p style='color:red;'>Necessário selecionar um produto!</p>";
    header("Location: areaPrivada.php");
    }
?>