<?php
//Arquivo para cadastrar uma nova categoria

//Inicia a sessão
session_start();

//Inclui o arquivo de conexão
include_once 'conexao.php';

//Busca no banco o nome da categoria
$busca = "SELECT nome_categoria FROM categorias_de_produtos";
$result = mysqli_query($conexaoMysqli, $busca);
$resu = mysqli_fetch_assoc($result);

//Variável recebendo o valor digitado
$categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_STRING);

//Inserção no banco
$insert_categoria = "INSERT INTO categorias_de_produtos (nome_categoria) VALUES ('$categoria')";

//Se a variável estiver vazia
if ($categoria == "") {
    //Manda um alert e realoca o usuário para a página
    echo "<script>alert('Por favor, preencha o campo com um nome válido!');</script>";
    echo "<script>window.location.href = '../../resources/View/Pages/cadastrar_categoria.php';</script>";

//Se a categoria já existir
} else if ($categoria == $resu['nome_categoria']) {
    //Manda um alert e realoca o usuário para a página
    echo "<script>alert('Essa categoria já existe!');</script>";
    echo "<script>window.location.href = '../../resources/View/Pages/cadastrar_categoria.php';</script>";

//Senão, faz a inserção no banco
} else {
    $result = mysqli_query($conexaoMysqli, $insert_categoria);
    //Se der certo
    if (mysqli_affected_rows($conexaoMysqli)) {
        //Manda uma mensagem e realoca o usuário para a página que exibe as categorias
        $_SESSION['msg'] = "<p style='color:green;'>Uma nova Categoria foi adicionada com sucesso!</p>";
        header("Location: ../../resources/View/Pages/exibir_categorias.php");

    //Senão afetar
    } else {
        //Manda uma mensagem e realoca o usuário para a página que exibe as categorias
        $_SESSION['msg'] = "<p style='color:red;'>Erro ao adicionar nova Categoria!</p>";
        header("Location: ../../resources/View/Pages/exibir_categorias.php");
    }
}
