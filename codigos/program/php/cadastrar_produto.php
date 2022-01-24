<?php
//Página para cadastrar um produto
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
        <label for="nome">Produto: </label> <abbr title="Campo obrigatório">*</abbr>
        <input type="text" required name="nome_produto" id="nome" onkeyup="checar()" maxlength="75" placeholder="Digite o nome do produto"><br><br>

        <label>Categoria: </label> <abbr title="Campo obrigatório">*</abbr>
        <select name="categoria_produto" required id="categoria" onkeyup="checar()">
            <option>Selecione</option> <abbr title="Campo obrigatório">*</abbr>
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

        <label>Quantidade: </label> <abbr title="Campo obrigatório">*</abbr>
        <input type="number" required name="quantidade_produto" id="quantidade" onkeyup="checar()" min="0.00" step="0.01" placeholder="Digite a quantidade">
        <div id="retorno"></div><br>

        <label>Validade: </label> <abbr title="Campo obrigatório">*</abbr>
        <input type="date" required name="validade_produto" id="validade" onkeyup="checar()" min="2022-01-01"><br><br>
 
        <label>Data de entrega: </label> <abbr title="Campo obrigatório">*</abbr>
        <input type="date" required name="entrega_produto" id="entrega" onkeyup="checar()" min="2022-01-01"><br><br>

        <label>Observação:</label>
        <input type="text" name="observacao_produto" id="obs" placeholder="Se tiver alguma observação..."><br><br>

        <abbr title="Preencha os campos para cadastrar um produto!" id="abbr">
            <input type="submit" value="CADASTRAR" id="botao" disabled>
        </abbr>

        <!-- Javascript com uma função para habilitar o botão -->
        <script>
            function checar() {
                var nome_produto       = document.getElementById("nome").value;
                var categoria_produto  = document.getElementById("categoria").value;
                var quantidade_produto = document.getElementById("quantidade").value;
                var validade_produto   = document.getElementById("validade").value;
                var entrega_produto    = document.getElementById("entrega").value;

                var botao = document.getElementById("botao");
                var abbr  = document.getElementById("abbr");

                //Se tiver um dos campos obrigatórios vazios
                if (nome_produto == "" && categoria_produto == "" && quantidade_produto == "" && validade_produto == "" && entrega_produto == "") {
                    botao.setAttribute('disabled', 'disabled');
                    abbr.setAttribute('title', 'Preencha os campos para cadastrar um produto!');
                //Senão
                } else {
                    botao.removeAttribute('disabled');
                    abbr.setAttribute('title', 'Clique para cadastrar um produto!');
                }

                if(quantidade_produto == ""){
                    document.getElementById("retorno").innerHTML = 'Se for <strong>Quilos</strong>, adicione o caractere "," e pelo menos o número 1 após a virgula, para o sistema entender...';
                } else{
                    document.getElementById("retorno").innerHTML = "";
                }
            }
        </script>
    </form>
</body>

</html>