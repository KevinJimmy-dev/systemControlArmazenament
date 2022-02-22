<?php
//Arquivo para deletar um produto
session_start(); //inicia a sessão...

include_once 'conexao.php'; //incluindo o arquivo de conexão....

$id_produto = filter_input(INPUT_GET, 'id_produto', FILTER_SANITIZE_NUMBER_INT);

//Se a variavel não estiver vazia... Vai executar o if e deletar o que pedir...
if(!empty($id_produto)){
    $result_produto = "DELETE FROM produto WHERE id_produto = '$id_produto'";
    $resultado_produto = mysqli_query($conexaoMysqli, $result_produto);
    
    //Imprimi na tela uma mensagem de sucesso e realoca a pessoa para a area privada...
    if(mysqli_affected_rows($conexaoMysqli)){
        echo "<script>alert('O produto foi excluído com sucesso!');</script>";
        echo "<script>window.location.href = '../../resources/View/Pages/funcionario.php'</script>";

    //Imprimi uma mensagem de erro e realoca a pessoa para a area privada...
    } else{
        echo "<script>alert('ERRO: O produto não foi excluído!');</script>";
        echo "<script>window.location.href = '../../resources/View/Pages/funcionario.php'</script>";
    }

//Se der um erro, faltar o ID, imprimi uma mensagem e realoca para a area privada...
} else{
    echo "<script>alert('ERRO: É necessario selecionar um produto!');</script>";
    echo "<script>window.location.href = '../../resources/View/Pages/funcionario.php'</script>";
    }
?>