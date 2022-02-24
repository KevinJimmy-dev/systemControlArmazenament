<?php
//Arquivo para deletar uma categoria

//Inicia sessão
session_start(); 

//Inclui o arquivo de conexão
include_once 'conexao.php'; 

//Variável que recebe o valor do id da categoria
$id_categoria = filter_input(INPUT_GET, 'id_categoria', FILTER_SANITIZE_NUMBER_INT);

//Se a variável não estiver vazia
if(!empty($id_categoria)){
    //Deleta no banco
    $result_categoria    = "DELETE FROM categorias_de_produtos WHERE id_categoria = '$id_categoria'";
    $resultado_categoria = mysqli_query($conexaoMysqli, $result_categoria);

    //Se der certo
    if(mysqli_affected_rows($conexaoMysqli)){
        //Busca produtos que possuem essa categoria
        $busca_produtos_cat = "SELECT * FROM produto WHERE id_categoria = '$id_categoria'";
        $res_busca          = mysqli_query($conexaoMysqli, $busca_produtos_cat);

        //Se algum possuir
        if(mysqli_num_rows($res_busca) >= 1){
            //Imprimi uma mensagem de erro e realoca a pessoa para a página que exibe as categorias
            $_SESSION['msg'] = "<p style='color:red;'>Existem produtos que possuem essa categoria, modifique eles primeiro!</p>";
            header("Location: ../../resources/View/Pages/exibir_categorias.php");

        //Se não imprimi uma mensagem e realoca a pessoa para a página que exibe as categorias
        } else{
           $_SESSION['msg'] = "<p style='color:green;'>A categoria foi excluída com sucesso!</p>";
           header("Location: ../../resources/View/Pages/exibir_categorias.php"); 
        }
        
    //Se não der certo
    } else{
        //Imprimi uma mensagem de erro e realoca a pessoa para a página que exibe as categorias
        $_SESSION['msg'] = "<p style='color:red;'>ERRO: A categoria não foi excluída!</p>";
        header("Location: ../../resources/View/Pages/exibir_categorias.php");
    }

//Senão tiver um ID da categoria
} else{
    //Imprimi uma mensagem de erro e realoca a pessoa para a página que exibe as categorias
    $_SESSION['msg'] = "<p style='color:yellow;'>Necessário selecionar uma categoria!</p>";
    header("Location: ../../resources/View/Pages/exibir_categorias.php");
    }
?>