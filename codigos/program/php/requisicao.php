<?php
//Página que fará a requisição
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
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
    <script type="text/javascript" src="../javascript/personalizado.js"></script>
    <title>Requisição</title>
</head>

<body>
    <a href="areaPrivada.php">Voltar</a>
    <br>
    <h1>Requisição</h1>

    <?php
    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
    }
    ?>
    <br>
    <form method="POST" id="form-pesquisa" action="">
        <input type="text" name="pesquisa" id="pesquisa" placeholder="Pesquisar...">
        
        <ul class="resultado">
            
        </ul>
        
    </form>
    <br>
    
    <form method='POST' action='requisita.php'>
    <table border="1" name="tbl" id="tbl">
        <tr>
            <td>Produto</td>
            <td>Quantidade Disp</td>
            <td>Requisição</td>
        </tr>
        
    </table>

    <div id="div">
        
    </div>

    <br>

    <input type="submit" name="botao" value="Requisitar">
    </form>
    
</body>

</html>