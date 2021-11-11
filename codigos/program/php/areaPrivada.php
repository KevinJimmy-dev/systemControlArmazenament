<?php
include("conexao.php");

session_start(); //inicia a sessão...
if (!isset($_SESSION['id_usuario'])) { //se não estiver definida, não possuir um id_usuario
    header("location: ../../login/php/login.php"); // vai mandar ele devolta para a página de login...
    exit; //para a execução, do codigo restante...
}

$consulta = "SELECT * FROM armazenamento"; //varaivel que vai consultar o banco de dados...
$con = $conexaoMysqli->query($consulta) or die($conexaoMysqli->error); //vai fazer a conexao com outra variavel, caso der errado, vai matar a conexao...

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Sistema de armazenamento</title>
</head>

<body>
    <div class="container">
        <!-- Essa página vai ser a do sistema do armazenamento... -->
        <a href="sair.php">Sair</a><br> <!-- vai ser um botão para deslogar -->
        <a href="cadastrar_produto.php">Cadastrar Produto</a><br><!-- botão para cadastrar o produto -->
        <a href="pesquisar_produto.php">Pesquisar Produto</a><br><br>

        <h1>Tabela de Produtos</h1>
        <br>

        <!-- Arrumar essa table-->
        <table border="2">
            <tr>
                <td>Produto</td>
                <td>Quantidade</td>
                <td>Entrega</td>
                <td>Validade</td>
                <td>Observação</td>
                <td>Ações</td>
            </tr>

            <?php

            //vai emprimir tudo da tabela...
            while ($dados = $con->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $dados['nome_produto'] . "</td>";
                echo "<td>" . $dados['quantidade_produto'] . "</td>";
                echo "<td>" . date("d/m/Y", strtotime($dados['entrega_produto'])) . "</td>";
                echo "<td>" . date("d/m/Y", strtotime($dados['validade_produto'])) . "</td>";
                echo "<td>" . $dados['observacao_produto'] . "</td>";
                echo "<td> <a href='editar_produto.php?id_produto=" . $dados['id_produto'] . "'> EDITAR </a>
                    | <a href='del_produto.php?id_produto=" . $dados['id_produto'] . "' data-confirm='Tem certeza de que deseja excluir o item selecionado?'> EXCLUIR </a>
                </td>"; //botões de editar e excluir
                echo "</tr>";
            }
            ?>

        </table>
        <!-- fim da table -->

        <?php
        //Caso ocorrer algum erro, vai imprimir uma msg nessa variavel...
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
    </div>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="../javascript/controller.js"></script>
</body>

</html>