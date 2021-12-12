<?php
include("conexao.php");

session_start(); //inicia a sessão...
if (!isset($_SESSION['id_usuario'])) { //se não estiver definida, não possuir um id_usuario
    header("location: ../../login/php/login.php"); // vai mandar ele devolta para a página de login...
    exit; //para a execução, do codigo restante...
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Produto</title>
</head>

<body>
    <a href="areaPrivada.php">Voltar</a>
    <h1>Cadastrar produto</h1>

    <?php
    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    ?>

    <form method="POST" action="processa.php">
        <label>Produto: </label>
        <input type="text" name="nome_produto" maxlength="75" placeholder="Digite o nome do produto"><br><br>

        <label>Categoria: </label>
        <select name="categoria_produto">
            <option>Selecione</option>
            <?php
            $result_categoria = "SELECT * FROM categorias_de_produtos";
            $resultado_categoria = mysqli_query($conexaoMysqli, $result_categoria);
        
            while ($row_categoria = mysqli_fetch_assoc($resultado_categoria)) { ?>
                <option value="<?php echo $row_categoria['id_categoria'] ?>">
                    <?php echo $row_categoria['nome_categoria']; ?>
                </option> <?php
                        }
                            ?>
        </select><br><br>

        <label>Quantidade: </label>
        <input type="number" required name="quantidade_produto" min="0.00" step="0.01" placeholder="Digite a quantidade"><br><br>

        <label>Validade: </label>
        <input type="date" name="validade_produto"><br><br>

        <label>Data de entrega: </label>
        <input type="date" name="entrega_produto"><br><br>

        <label>Observação:</label>
        <input type="text" name="observacao_produto" placeholder="Se tiver alguma observação..."><br><br>

        <input type="submit" value="CADASTRAR">
    </form>
</body>

</html>