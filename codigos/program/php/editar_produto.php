<?php
include_once("conexao.php");

session_start(); //inicia a sessão...
if (!isset($_SESSION['id_usuario'])) { //se não estiver definida, não possuir um id_usuario
    header("location: ../../login/php/login.php"); // vai mandar ele devolta para a página de login...
    exit; //para a execução, do codigo restante...
}

$id_produto = filter_input(INPUT_GET, 'id_produto', FILTER_SANITIZE_NUMBER_INT); //variavel armazenando o id com um filtro...
$result_produto = "SELECT * FROM armazenamento WHERE id_produto = '$id_produto'"; //variavel que possui o id do produto selecionado para editar...
$resultado_produto = mysqli_query($conexaoMysqli, $result_produto); //variavel que faz a conexão...
$linha_produto = mysqli_fetch_assoc($resultado_produto); // variavel que fez um array, que armazena os itens dentro dela...

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
</head>

<body>
    <h1>Editar Produto</h1>
    <?php 
    if(isset($_SESSION['msg'])){ //msg se
        echo $_SESSION['msg'];    //deu certo
        unset($_SESSION['msg']);   //ou nao
    }
    ?>
    <form method="POST" action="edit_produto.php">
        <input type="hidden" name="id_produto" value="<?php echo $linha_produto['id_produto']; ?>">

        <label>Produto: </label>
        <input type="text" name="nome_produto" value="<?php echo $linha_produto['nome_produto']; ?>"><br><br>

        <label>Quantidade: </label>
        <input type="number" name="quantidade_produto" value="<?php echo $linha_produto['quantidade_produto']; ?>"><br><br>

        <label>Data de Validade: </label>
        <input type="date" name="validade_produto" value="<?php echo $linha_produto['validade_produto']; ?>"><br><br>

        <label>Data de entrega: </label>
        <input type="date" name="entrega_produto" value="<?php echo $linha_produto['entrega_produto']; ?>"><br><br>

        <label>Observação: </label>
        <input type="text" name="observacao_produto" value="<?php echo $linha_produto['observacao_produto']; ?>"><br><br>
        
        <input type="submit" value="EDITAR">
    </form>

</body>

</html>