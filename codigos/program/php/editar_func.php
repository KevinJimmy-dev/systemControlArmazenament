<?php
//Página para editar um funcionário
include_once("conexao.php");

session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("location: ../../login/php/login.php");
    exit;
} else if($_SESSION['nivel_usuario'] != 1){
    header("location: areaPrivada_func.php");
}

//Recebe o ID, e em outra possui comando MYSQL e a execução dele, jogando os resultados para uma variável que será um array
$id_usuario = filter_input(INPUT_GET, 'id_usuario', FILTER_SANITIZE_NUMBER_INT);
$result_usuarios = "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario'";
$resultado_usuarios = mysqli_query($conexaoMysqli, $result_usuarios);
$linha_usuarios = mysqli_fetch_assoc($resultado_usuarios);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Funcionário</title>
</head>

<body>
    <a href="exibir_func.php">Voltar</a>

    <h1>Editar Funcionário</h1>

    <?php
    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    ?>

    <form method="POST" action="edit_func.php">
        <input type="hidden" name="id_usuario" value="<?php echo $linha_usuarios['id_usuario']; ?>">

        <label>Nome: </label>
        <input type="text" name="nome_usuario" onkeyup="comparar()" id="nome" value="<?php echo $linha_usuarios['nome_usuario']; ?>"><br><br>

        <label>Nome de Usuário: </label>
        <input type="text" name="username_usuario" onkeyup="comparar()" id="username" value="<?php echo $linha_usuarios['username_usuario']; ?>"><br><br>

        <!-- <label>Senha: </label>
        <input type="text" name="senha_usuario" onkeyup="comparar()" id="senha" value="<?php echo $linha_usuarios['senha_usuario']; ?>"><br><br> -->

        <label>Nivel de Usuário: </label>
        <select name="nivel_usuario" onmouseleave="comparar()" id="nivel">

            <!-- Option para colocar o nível de usuário  -->
            <?php
                if($linha_usuarios['nivel_usuario'] == 0){
                    echo "
                    <option value='0' selected>Funcionário</option>
                    <option value='1'>Administrador</option>
                    ";
                }
            ?>
        </select><br><br>

        <label>Status de Usuário: </label>
        <select name="status_usuario" onmouseleave="comparar()" id="status">

            <!-- Option para mudar o status do usuário -->
            <?php
                if($linha_usuarios['status_usuario'] == 1){
                    echo "
                    <option value='1' selected>Ativo</option>
                    <option value='0'>Inativo</option>
                    ";
                } else{
                    echo "
                    <option value='1'>Ativo</option>
                    <option value='0' selected>Inativo</option>
                    ";
                }
            ?>
        </select><br><br>

        <abbr title="Altere um dos campos..." id="abbr">
        <input type='submit' name='botao' id="botao" value='SALVAR' disabled>
        </abbr>

        <!-- Para ativar o button caso houver alguma alteração -->
        <!-- Pegando os valores originais, com Javascript dentro do PHP...-->
        <?php
        $script = 
            "<script>
                var nome_or    = '$linha_usuarios[nome_usuario]';
                var usuario_or = '$linha_usuarios[username_usuario]';
                var nivel_or   = '$linha_usuarios[nivel_usuario]';
                var status_or  = '$linha_usuarios[status_usuario]';
            </script>";
        echo $script;
        ?>

        <!-- Função que compara os valores antigos e os novos -->
        <script>
            function comparar() {
                //Variáveis que possuem os novos valores (caso houver)
                var nome_novo    = document.getElementById('nome').value;
                var usuario_novo = document.getElementById('username').value;
                //var senha_novo   = document.getElementById('senha').value;
                var nivel_novo   = document.getElementById('nivel');
                var value = nivel_novo.options[nivel_novo.selectedIndex].value;
                var status_novo  = document.getElementById('status');
                var value1 = status_novo.options[status_novo.selectedIndex].value;

                //Colocando o botao em uma variavel
                var button = document.getElementById('botao');
                var abbr   = document.getElementById('abbr');

                //Estrutura de decisão caso houver alguma modificação em um dos campos
                if (nome_or === nome_novo && usuario_or === usuario_novo && nivel_or === value && status_or === value1) {
                    //Se não, o botão continua desativado
                    button.setAttribute('disabled', 'disabled');    
                    abbr.setAttribute('title', 'Altere um dos campos...');
                } else if(nome_novo === "" || usuario_novo === "" || nivel_novo === "" || status_novo === ""){
                    button.setAttribute('disabled', 'disabled');
                    abbr.setAttribute('title', 'Não deixe nenhum campo vazio!');
                } else{
                    //Se sim, o botão é ativado
                    button.removeAttribute('disabled');
                    abbr.setAttribute('title', 'Clique para salvar as alterações!');
                }
            }
        </script>
    </form>
</body>

</html>