<?php
include("conexao.php");

session_start(); //inicia a sessão...
if (!isset($_SESSION['id_usuario'])) { //se não estiver definida, não possuir um id_usuario
    header("location: ../../login/php/login.php"); // vai mandar ele devolta para a página de login...
    exit; //para a execução, do codigo restante...
}

$consulta = "SELECT * FROM armazenamento"; //varaivel que vai consultar o banco de dados...
$con = $conexaoMysqli->query($consulta) or die($conexaoMysqli->error);//vai fazer a conexao com outra variavel, caso der errado, vai matar a conexao...

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
        <a href="cadastrar_produto.php">Cadastrar Produto</a><br><br> <!-- botão para cadastrar o produto -->
        <h1>Pesquisar produto</h1>

        <form method="POST" action="">
        <label>Produto: </label>
        <input type="text" name="nome_produto" placeholder="Digite o nome do produto">

        <input name="pesquisarProduto" type="submit" value="PESQUISAR">
        </form>
        <h1>Tabela de Produtos</h1>
        <br>

        <!-- Arrumar essa table-->
        <table border="2">
        <tr>
            <td>ID</td>
            <td>Nome</td>
            <td>Quantidade</td>
            <td>Validade</td>
            <td>Entrega</td>
            <td>Observação</td>
            <td>Ações</td>
        </tr>
        
        <?php

        while($dados = $con->fetch_assoc()){
            echo "<tr>";
            echo "<td>" . $dados['id_produto'] . "</td>";
            echo "<td>" . $dados['nome_produto'] . "</td>";
            echo "<td>" . $dados['quantidade_produto'] . "</td>";
            echo "<td>" . date("d/m/Y", strtotime($dados['validade_produto'])) . "</td>";
            echo "<td>" . date("d/m/Y", strtotime($dados['entrega_produto'])) . "</td>";
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
        $pesquisarProduto = filter_input(INPUT_POST, 'pesquisarProduto', FILTER_SANITIZE_STRING);

        $nome_produto = filter_input(INPUT_POST, 'nome_produto', FILTER_SANITIZE_STRING);
        $result_produto = "SELECT * FROM armazenamento WHERE nome_produto LIKE '%$nome_produto%'";
        $resultado_produto = mysqli_query($conexaoMysqli, $result_produto);

        if(isset($_POST["pesquisarProduto"])){
         if(empty($nome_produto)){
                echo "<script>alert('Preencha o campo para pesquisar!');</script>";
        ?>

        <table border="2">
        <tr>
            <td>ID</td>
            <td>Nome</td>
            <td>Quantidade</td>
            <td>Validade</td>
            <td>Entrega</td>
            <td>Observação</td>
            <td>Ações</td>
        </tr>

        <?php
            if($con->num_rows > 0){
                while($dados = $con->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>" . $dados['id_produto'] . "</td>";
                    echo "<td>" . $dados['nome_produto'] . "</td>";
                    echo "<td>" . $dados['quantidade_produto'] . "</td>";
                    echo "<td>" . date("d/m/Y", strtotime($dados['validade_produto'])) . "</td>";
                    echo "<td>" . date("d/m/Y", strtotime($dados['entrega_produto'])) . "</td>";
                    echo "<td>" . $dados['observacao_produto'] . "</td>";
                    echo "<td> <a href='editar_produto.php?id_produto=" . $dados['id_produto'] . "'> EDITAR </a>
                            | <a href='del_produto.php?id_produto=" . $dados['id_produto'] . "' data-confirm='Tem certeza de que deseja excluir o item selecionado?'> EXCLUIR </a>
                        </td>"; //botões de editar e excluir
                    echo "</tr>";
                }
            }
        
        ?>

        </table>

        <?php
        } else{
            if(($resultado_produto) AND ($resultado_produto->num_rows != 0)){
                ?>
                <p style='color:green;'>Esses foram os resultados...</p>
                    <table border='2'>
                        <tr>
                            <td>ID</td>
                            <td>Nome</td>
                            <td>Quantidade</td>
                            <td>Validade</td>
                            <td>Entrega</td>
                            <td>Observação</td>
                            <td>Ações</td>
                        </tr>
                <?php
                while($dados = mysqli_fetch_assoc($resultado_produto)){
                    echo "<tr>";
                    echo "<td>" . $dados['id_produto'] . "</td>";
                    echo "<td>" . $dados['nome_produto'] . "</td>";
                    echo "<td>" . $dados['quantidade_produto'] . "</td>";
                    echo "<td>" . date("d/m/Y", strtotime($dados['validade_produto'])) . "</td>";
                    echo "<td>" . date("d/m/Y", strtotime($dados['entrega_produto'])) . "</td>";
                    echo "<td>" . $dados['observacao_produto'] . "</td>";
                    echo "<td> <a href='editar_produto.php?id_produto=" . $dados['id_produto'] . "'> EDITAR</a> | <a href='del_produto.php?id_produto=" . $dados['id_produto'] . "' data-confirm='Tem certeza de que deseja excluir o item selecionado?'> EXCLUIR </a>  </td>"; 
                    echo "</tr>";
                }
                ?>

                    </table>

                <?php 
            } else{
                echo "<script>alert('Este produto ainda não foi cadastrado, ou nome incorreto!');</script>";

                echo "<table border='2'>";
                echo "<tr>";
                echo "<td>ID</td>
                        <td>Nome</td>
                        <td>Quantidade</td>
                        <td>Validade</td>
                        <td>Entrega</td>
                        <td>Observação</td>
                        <td>Ações</td>";
                echo "</tr>";

                while($dados = $con->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>" . $dados['id_produto'] . "</td>";
                    echo "<td>" . $dados['nome_produto'] . "</td>";
                    echo "<td>" . $dados['quantidade_produto'] . "</td>";
                    echo "<td>" . date("d/m/Y", strtotime($dados['validade_produto'])) . "</td>";
                    echo "<td>" . date("d/m/Y", strtotime($dados['entrega_produto'])) . "</td>";
                    echo "<td>" . $dados['observacao_produto'] . "</td>";
                    echo "<td> <a href='editar_produto.php?id_produto=" . $dados['id_produto'] . "'> EDITAR </a>
                            | <a href='del_produto.php?id_produto=" . $dados['id_produto'] . "' data-confirm='Tem certeza de que deseja excluir o item selecionado?'> EXCLUIR </a>
                        </td>"; //botões de editar e excluir
                    echo "</tr>";
                    echo "</table>";
            }
        }
    }
}
        ?>

        <?php
        if(isset($_SESSION['msg'])){
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