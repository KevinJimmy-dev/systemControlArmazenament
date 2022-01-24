<?php
//Página que exibe todas as categorias, e com funções: EDITAR | EXCLUIR
include("conexao.php");

session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("location: ../../login/php/login.php"); 
    exit; 
}

$consult = "SELECT * FROM categorias_de_produtos";
$conexao = $conexaoMysqli->query($consult) or die($conexaoMysqli->error);

?>

<!DOCTYPE html>
<html lang="pr-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Excluir Categoria</title>
</head>

<body>
    <a href="cadastrar_categoria.php">Cadastrar Categoria</a><br>
    <a href="areaPrivada.php">Voltar</a><br>

    <h1>Categorias</h1>
    
    <?php
    if (isset($_SESSION['msg'])) { //msg se
        echo $_SESSION['msg'];     //deu certo
        unset($_SESSION['msg']);   //ou nao
    }
    ?>
    
    <!-- Tudo será exibido em uma lista -->
    <ul>
        <?php
            //Enquanto tiver itens no array, será imprimido, junto com duas funções: EDITAR e EXCLUIR
            while ($info = $conexao->fetch_assoc()) {
                echo "<li> $info[nome_categoria] </li>";
                echo "<a href='editar_categoria.php?id_categoria=" . $info['id_categoria'] . "'> EDITAR </a>
                | <a href='dell_categoria.php?id_categoria=" . $info['id_categoria'] . "' data-confirm='Tem certeza de que deseja excluir a categoria selecionada?'> EXCLUIR </a>";
                echo "<hr>";
            }
        ?>
    </ul>
    
    <!-- JavaScript Bundle with Popper -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="../javascript/controller.js"></script>
</body>

</html>