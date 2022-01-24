<?php
//Página para pesquisar produtos
include("conexao.php");

session_start(); //inicia a sessão...
if (!isset($_SESSION['id_usuario'])) { //se não estiver definida, não possuir um id_usuario
    header("location: ../../login/php/login.php"); // vai mandar ele devolta para a página de login...
    exit; //para a execução, do codigo restante...
}

$consulta = "SELECT * FROM produto"; //varaivel que vai consultar o banco de dados...
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
    <title>Pesquisar Produtos</title>
</head>

<body>
    <div class="container">
        <a href="areaPrivada.php">Voltar</a><br><br>

        <h1>Pesquisar produto</h1>

        <form method="POST" action="">
            <label>Produto: </label>
            <input type="text" name="nome_produto" placeholder="Digite o nome do produto">
            <input name="pesquisarProduto" type="submit" value="PESQUISAR">
        </form>

        <h1>Tabela de Produtos</h1>
        <br>

        <?php
        //Codigos para pesquisar o produto...
        $pesquisarProduto = filter_input(INPUT_POST, 'pesquisarProduto', FILTER_SANITIZE_STRING);
        $nome_produto = filter_input(INPUT_POST, 'nome_produto', FILTER_SANITIZE_STRING);
        $result_produto = "SELECT * FROM produto WHERE nome_produto LIKE '%$nome_produto%'";
        $resultado_produto = mysqli_query($conexaoMysqli, $result_produto);

        //Se a variavel esta definida, vai chamar os codigos para pesquisar...
        if (isset($_POST["pesquisarProduto"])) {
            //Se a variavel esta está vazia...
            if (empty($nome_produto)) {
                //Vai emprimir um alert, e a tabela na tela do usuario...
                echo "<script>alert('Preencha o campo para pesquisar!');</script>";
            } else {
                //Se a pesquisa der certo...
                if (($resultado_produto) and ($resultado_produto->num_rows != 0)) {
        ?>

                    <p style='color:green;'>Esses foram os resultados...</p>
                    <table border='2'>
                        <tr>
                            <td>Produto</td>
                            <td>Quantidade</td>
                            <td>Entrega</td>
                            <td>Validade</td>
                            <td>Observação</td>
                            <td>Categoria</td>
                            <td>Ações</td>
                        </tr>

                        <?php
                        //Imprimindo a tabela...
                        while ($dados = mysqli_fetch_assoc($resultado_produto)) {
                            //para emprimir o nome da categoria...
                            $busca_categoria = "SELECT nome_categoria FROM categorias_de_produtos WHERE id_categoria = '$dados[id_categoria]'";
                            $buscou = $conexaoMysqli->query($busca_categoria); 
                            $categoria = $buscou->fetch_assoc();

                            echo "<tr>";
                            echo "<td>" . $dados['nome_produto'] . "</td>";
                            echo "<td>" . $dados['quantidade_produto'] . "</td>";
                            echo "<td>" . date("d/m/Y", strtotime($dados['entrega_produto'])) . "</td>";
                            echo "<td>" . date("d/m/Y", strtotime($dados['validade_produto'])) . "</td>";
                            echo "<td>" . $dados['observacao_produto'] . "</td>";
                            echo "<td>" . $categoria['nome_categoria'] . "</td>";
                            echo "<td> <a href='editar_produto.php?id_produto=" . $dados['id_produto'] . "'> EDITAR</a> | <a href='del_produto.php?id_produto=" . $dados['id_produto'] . "' data-confirm='Tem certeza de que deseja excluir o item selecionado?'> EXCLUIR </a>  </td>";
                            echo "</tr>";
                        }
                        ?>

                    </table>

        <?php
                } else {
                    echo "<script>alert('Este produto ainda não foi cadastrado, ou nome incorreto!');</script>";
                }
            }
        }

        //Caso ocorrer algum erro, vai imprimir uma msg nessa variavel...
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        
        <!-- JavaScript Bundle with Popper -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <script src="../javascript/controller.js"></script>
    </div>

</body>

</html>