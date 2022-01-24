<?php
//Página que exibe todos os funcionários, com funções: EDITAR e EXCLUIR
include("conexao.php");

session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("location: ../../login/php/login.php");
    exit; 
} else if($_SESSION['nivel_usuario'] != 1){
    header("location: areaPrivada_func.php");
}

//Comando MYSQL e execução dele
$consultar = "SELECT * FROM usuarios WHERE nivel_usuario != 1";
$conex = $conexaoMysqli->query($consultar) or die($conexaoMysqli->error);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Exibir Funcionários</title>
</head>

<body>
    <a href="areaPrivada.php">Voltar</a><br>
    <a href="cadastrar_usuario.php">Cadastrar Funcionário(a)</a>

    <h1>Exibir Funcionários</h1>

    <?php
    if (isset($_SESSION['msg'])) { 
        echo $_SESSION['msg'];     
        unset($_SESSION['msg']);   
    }
    ?>

    <!-- Todos os funcionários estão sendo exibidos dentro de uma lista -->
    <ul>
    
    <?php
            //Jogará os resultados para uma variável, e enquanto tiver valores não emprimidos
            while ($stats = $conex->fetch_assoc()) {
                echo "<li> Nome:            $stats[nome_usuario] </li>";
                echo "<li> Nome de usuário: $stats[username_usuario]</li>";

                //Se o nível do usuário for 0, ele é um funcionário
                if($stats['nivel_usuario'] == 0){
                    echo "<li> Nivel: Funcionário(a)</li>";
                //Se o nível do usuário for 1, ele é um administrador
                } else if($stats['nivel_usuario'] == 1){
                    echo "<li> Nivel: Administrador</li>";
                }
                
                //Se o status do usuário for 1, ele está ativo
                if($stats['status_usuario'] == 1){
                    echo "<li> Status: Ativo</li>";
                //Se o status do usuário for 0, ele está inativo
                } else if($stats['status_usuario'] == 0){
                    echo "<li> Status: Inativo</li>";
                }

                //Botões de editar e excluir, com janela modal no excluir
                echo "<a href='editar_func.php?id_usuario=" . $stats['id_usuario'] . "'> EDITAR </a>
                |    <a href='del_func.php?id_usuario="     . $stats['id_usuario'] . "'
                 data-confirm='Tem certeza de que deseja excluir o funcionário(a) selecionado?'> EXCLUIR </a>";
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