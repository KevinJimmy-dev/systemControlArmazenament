<?php
//Arquivo para deletar uma categoria
session_start(); 

include_once 'conexao.php'; 

$id_categoria = filter_input(INPUT_GET, 'id_categoria', FILTER_SANITIZE_NUMBER_INT);

//Senão tiver um ID da categoria
if(!empty($id_categoria)){
    
    //Comando MYSQL e execução dele
    $result_categoria    = "DELETE FROM categorias_de_produtos WHERE id_categoria = '$id_categoria'";
    $resultado_categoria = mysqli_query($conexaoMysqli, $result_categoria);

    
    //Se afetar alguma linha do bd
    if(mysqli_affected_rows($conexaoMysqli)){
        //Comando MYSQL e execução dele
        $busca_produtos_cat = "SELECT * FROM produto WHERE id_categoria = '$id_categoria'";
        $res_busca          = mysqli_query($conexaoMysqli, $busca_produtos_cat);
        if(mysqli_num_rows($res_busca) >= 1){
            $_SESSION['msg'] = "<p style='color:red;'>Existem produtos que possuem essa categoria, modifique eles primeiro!</p>";
            header("Location: ../../resources/View/Pages/exibir_categorias.php");
        } else{
           $_SESSION['msg'] = "<p style='color:green;'>A categoria foi excluída com sucesso!</p>";
           header("Location: ../../resources/View/Pages/exibir_categorias.php"); 
        }
        
    //Senão afetar
    } else{
        $_SESSION['msg'] = "<p style='color:red;'>ERRO: A categoria não foi excluída!</p>";
        header("Location: ../../resources/View/Pages/exibir_categorias.php");
    }

//Senão tiver um ID da categoria
} else{
    $_SESSION['msg'] = "<p style='color:yellow;'>Necessário selecionar uma categoria!</p>";
    header("Location: ../../resources/View/Pages/exibir_categorias.php");
    }
?>