<?php
//Arquivo para deletar um produto

//Inicia a sessão
session_start();

//Incluindo o arquivo de conexão
include_once 'conexao.php'; 

//Variável recebendo o id do produto
$id_produto = filter_input(INPUT_GET, 'id_produto', FILTER_SANITIZE_NUMBER_INT);

//Se a variavel não estiver vazia
if(!empty($id_produto)){
    //Executa o delete no banco
    $result_produto = "DELETE FROM produto WHERE id_produto = '$id_produto'";
    $resultado_produto = mysqli_query($conexaoMysqli, $result_produto);
    
    //Se der certo
    if(mysqli_affected_rows($conexaoMysqli)){
        //Imprimi uma mensagem e realoca o usuário para a página do funcionário
        echo "<script>alert('O produto foi excluído com sucesso!');</script>";
        echo "<script>window.location.href = '../../resources/View/Pages/funcionario.php'</script>";

    //Se não der certo
    } else{
        //Imprimi uma mensagem de erro e realoca a pessoa para a página do funcionário
        echo "<script>alert('ERRO: O produto não foi excluído!');</script>";
        echo "<script>window.location.href = '../../resources/View/Pages/funcionario.php'</script>";
    }

//Se não tiver um id
} else{
    //Imprimi uma mensagem de erro e realoca a pessoa para a página do funcionário
    echo "<script>alert('ERRO: É necessario selecionar um produto!');</script>";
    echo "<script>window.location.href = '../../resources/View/Pages/funcionario.php'</script>";
    }
?>