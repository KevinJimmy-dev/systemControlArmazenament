<?php
//Página para editar uma categoria
include_once("conexao.php");

//Inicia uma sessão
session_start();
if (!isset($_SESSION['id_usuario'])) { 
    header("location: ../../login/php/login.php"); 
    exit; 
}

//Recebe o id de uma categoria, em outra tem um comando MYSQL e a execução dele, jogando os resultados pra uma variável
$id_categoria        = filter_input(INPUT_GET, 'id_categoria', FILTER_SANITIZE_NUMBER_INT);
$result_categoria    = "SELECT * FROM categorias_de_produtos WHERE id_categoria = '$id_categoria'";
$resultado_categoria = mysqli_query($conexaoMysqli, $result_categoria); 
$linha_categoria     = mysqli_fetch_assoc($resultado_categoria); 

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoria</title>
</head>

<body>
    <a href="del_categoria.php">Voltar</a>
    <h1>Editar Categoria</h1>

    <?php
    if (isset($_SESSION['msg'])) { //msg se
        echo $_SESSION['msg'];    //deu certo
        unset($_SESSION['msg']);   //ou nao
    }
    ?>

    <form method="POST" action="edit_categoria.php">
        <input type="hidden" name="id_categoria" value="<?php echo $linha_categoria['id_categoria']; ?>">

        <label>Produto: </label>
        <input type="text" name="nome_categoria" id="nome" onkeyup="comparar()" value="<?php echo $linha_categoria['nome_categoria']; ?>"><br><br>

        <abbr title="Faça alguma mudança para habilitar o botão..." id="abbr">
            <input type='submit' value='SALVAR' id="botao" disabled>
        </abbr>

        <!-- Para ativar o button caso houver alguma alteração -->
        <!-- Pegando os valores originais, com Javascript dentro do PHP...-->
        <?php
        $script =
            "<script>
                var categoria_or = '$linha_categoria[nome_categoria]';
            </script>";
        echo $script;
        ?>

        <!-- Função que compara os valores antigos e os novos -->
        <script>
            function comparar() {
                //Variáveis que possuem os novos valores (caso houver)
                var categoria_novo = document.getElementById('nome').value;

                //Colocando o botao em uma variavel
                var button = document.getElementById('botao');
                var abbr   = document.getElementById('abbr');

                //Estrutura de decisão caso houver alguma modificação em um dos campos
                if (categoria_or === categoria_novo) {
                    //Se não, o botão continua desativado
                    button.setAttribute('disabled', 'disabled');
                    abbr.setAttribute('title', 'Faça alguma mudança para habilitar o botão...');
                    //Se o usuario deixar o campo vazio
                } else if(categoria_novo === ""){
                    button.setAttribute('disabled', 'disabled');
                    abbr.setAttribute('title', 'Não deixe o campo vazio!');
                } else{
                    //Se sim, o botão é ativado
                    button.removeAttribute('disabled');
                    abbr.setAttribute('title', 'Clique para salvar a alteração');
                }
            }
        </script>

    </form>
</body>

</html>