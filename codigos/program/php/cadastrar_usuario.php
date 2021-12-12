<?php 
include("conexao.php");
require_once("../../login/php/usuarios.php");
$u = new Usuario;

session_start(); //inicia a sessão...
if (!isset($_SESSION['id_usuario'])) { //se não estiver definida, não possuir um id_usuario
    header("location: ../../login/php/login.php"); // vai mandar ele devolta para a página de login...
    exit; //para a execução, do codigo restante...
} else if($_SESSION['nivel_usuario'] != 1){
    header("location: areaPrivada_func.php");
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>
</head>

<body>
    <a href="areaPrivada.php">Voltar</a>
    <h1>Cadastrar Usuário</h1>

    <?php
    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    ?>

    <form method="POST" action="">
        <label>Nome do funcionário(a): </label>
        <input type="text" name="nome_usuario" placeholder="Digite o nome do funcionário(a)" maxlength="75"><br><br>

        <label>Username: </label>
        <input type="text" name="username_usuario" placeholder="Digite o username" maxlength="75"><br><br>

        <label>Senha: </label>
        <input type="password" name="senha_usuario" placeholder="Digite uma senha" maxlength="75"><br><br>

        <label>Confirme a senha: </label>
        <input type="password" name="confSenha_usuario" placeholder="Confirme a senha" maxlength="75"><br><br>

        <!-- <label>Nivel do usúario: </label>
        <select name="nivel_usuario">
            <option value="1">1 - Funcionário(a)</option>
        </select><br><br> -->

        <input type="submit" value="CADASTRAR">
    </form>

    <?php   
    //Verificar se clicou no botão
    if(isset($_POST['nome_usuario'])){
        $nome_usuario = addslashes($_POST['nome_usuario']);
        $username_usuario = addslashes($_POST['username_usuario']);
        $senha_usuario = addslashes($_POST['senha_usuario']);
        $confSenha_usuario = addslashes($_POST['confSenha_usuario']);

        //Verificar se está preenchido
        if(!empty($nome_usuario) && !empty($username_usuario) && !empty($senha_usuario) && !empty($confSenha_usuario)){
            $u->conectar("db_finecrew", "localhost", "root", "");

            if($u->msgErro == ""){// se está vazia, está tudo certo

                if($senha_usuario == $confSenha_usuario){

                    if($u->cadastrar($nome_usuario, $username_usuario, $senha_usuario)){
                        $_SESSION['msg'] = "<script>alert('Cadastrado com sucesso!');</script>";
                        header("location:areaPrivada.php");

                    } else{
                        echo "<script>alert('Nome de usuário já cadastrado!');</script>";
                    }

                } else{
                    echo "<script>alert('Senha e confirmar senha não correspodem!');</script>";
                }
                
            } else{
                echo "Erro: " . $u->msgErro;
            }
            
        } else{
            echo "<script>alert('Preencha todos os campos!');</script>";
        }
    }
    ?>

</body>

</html>
