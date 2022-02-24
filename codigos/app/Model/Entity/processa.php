<?php
//Arquivo para cadastrar produtos

//Inicia sessão
session_start();

//Inclui arquivo de conexão
include_once 'conexao.php';

//Variaveis recebendo  os novos valores
$nome_produto = filter_input(INPUT_POST, 'nome_produto', FILTER_SANITIZE_STRING);
$categoria_produto = filter_input(INPUT_POST, 'categoria_produto', FILTER_SANITIZE_STRING);
$quantidade_produto = filter_input(INPUT_POST, 'quantidade_produto', FILTER_SANITIZE_STRING);
$validade_produto = filter_input(INPUT_POST, 'validade_produto', FILTER_SANITIZE_STRING);
$entrega_produto = filter_input(INPUT_POST, 'entrega_produto', FILTER_SANITIZE_STRING);
$observacao_produto =  filter_input(INPUT_POST, 'observacao_produto', FILTER_SANITIZE_STRING);

//Fazendo uma busca no nome dos produtos, pra ver se já possui
$busca_produtos = "SELECT nome_produto FROM produto WHERE nome_produto = '$nome_produto'";
$exec = mysqli_query($conexaoMysqli, $busca_produtos);

//Cadastrando o produto na tabela produto
$insert_produto = "INSERT INTO produto (nome_produto, quantidade_produto, entrega_produto, validade_produto, observacao_produto, id_categoria) VALUES ('$nome_produto', '$quantidade_produto', '$entrega_produto', '$validade_produto', '$observacao_produto', '$categoria_produto')";

//Se algum dos campos estiver vazios
if ($nome_produto == "" || $categoria_produto == "" || $quantidade_produto == "" || $validade_produto == "" || $entrega_produto == "") {
    //Mostra um alert e realoca o usuario para a página de cadastrar produto
    echo "<script>alert('Preencha todos os campos!');</script>";
    echo "<script>window.location.href = '../../resources/View/Pages/cadastrar_produto.php';</script>";

  //Se já possuir um produto com esse nome
} else if (mysqli_num_rows($exec) >= 1) {
    //Exibe um alert e realoca o usuario para a página de funcionarios
    echo "<script>alert('Esse produto já existe!');</script>";
    echo "<script>window.location.href = '../../resources/View/Pages/Funcionario.php';</script>";
    
  //Se der certo o insert na tabela
} else if (mysqli_query($conexaoMysqli, $insert_produto)) {
    //Comando de insert na tabela controle
    $insert_controle = "INSERT INTO controle (dataCriacao_controle, observacao_controle, id_usuario) VALUES (NOW(), '$observacao_produto', '$_SESSION[id_usuario]')";

    //Se der certo o insert na tabela controle
    if (mysqli_query($conexaoMysqli, $insert_controle)) {
        //Buscando o id do produto e fazendo um array
        $select_produto = "SELECT id_produto FROM produto WHERE nome_produto = '$nome_produto'";
        $busca = $conexaoMysqli->query($select_produto);
        $produto = $busca->fetch_assoc();

        //Passando o valor para uma variavel global
        $_SESSION['id_produto'] = $produto['id_produto'];

        //Buscando o id do controle e fazendo o array
        $select_controle = "SELECT id_controle FROM controle WHERE observacao_controle = '$observacao_produto'";
        $busca1 = $conexaoMysqli->query($select_controle);
        $controle = $busca1->fetch_assoc();

        //Passando o valor para uma variavel global
        $_SESSION['id_controle'] = $controle['id_controle'];

        $insert_controle_produto = "INSERT INTO controle_produto (id_controle, id_produto) VALUES ('$_SESSION[id_controle]', '$_SESSION[id_produto]')";

        //Executa o insert na tabel controle produto
        mysqli_query($conexaoMysqli, $insert_controle_produto); 
    }

    //Mensagem caso ocorra tudo certo, e realoca pra página inicial...
    echo "<script>alert('Um novo produto foi cadastrado!');</script>";
    echo "<script>window.location.href = '../../resources/View/Pages/Funcionario.php';</script>";

//Se der errado
} else {
    //Imprimi uma mensagem e realoca o usuario para a pagina dos funcionarios
    $_SESSION['msg'] = "<p style='color:red;'>ERRO: O Produto não foi cadastrado!</p>";
    header("Location: ../../resources/View/Pages/Funcionario.php");
}
