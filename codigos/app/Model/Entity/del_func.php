<?php
//Arquivo para deletar um funcionário

//Inicia sessão
session_start();

//Inclui a conexão
include_once 'conexao.php';

//Pega o id do usuário
$id_usuario = filter_input(INPUT_GET, 'id_usuario', FILTER_SANITIZE_NUMBER_INT);

//Se tiver um ID
if(!empty($id_usuario)){
    
    //Deleta no banco o usuário
    $result = "DELETE FROM usuarios WHERE id_usuario = '$id_usuario'";
    $resultado = mysqli_query($conexaoMysqli, $result);
    
    //Se der certo
    if(mysqli_affected_rows($conexaoMysqli)){
        //Imprimi uma mensagem e realoca o usuário para a página que exibe os funcionários
        $_SESSION['msg'] = "<p style='color:green;'>O Usuário foi excluído com sucesso!</p>";
        header("Location: ../../resources/View/Pages/exibir_func.php");

    //Se não der certo
    } else{
        //Imprimi uma mensagem e realoca o usuário para a página que exibe os funcionários
        $_SESSION['msg'] = "<p style='color:red;'>ERRO: O Usuário não foi excluído!</p>";
        header("Location: ../../resources/View/Pages/exibir_func.php");
    }

//Se não tiver selecionado um usuário
} else{
    //Imprimi uma mensagem e realoca o usuário para a página que exibe os funcionários
    $_SESSION['msg'] = "<p style='color:yellow;'>Necessário selecionar um Usuário!</p>";
    header("Location: ../../resources/View/Pages/exibir_func.php");
    }
?>