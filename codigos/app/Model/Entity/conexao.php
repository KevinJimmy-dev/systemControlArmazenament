<?php
//Arquivo de conexão com o banco de dados

//Variáveis recendo os respectivos valores
$host     = "localhost";
$usuario  = "root";
$senha    = "";
$dataBase = "db_finecrew";

//Cria a conexão
$conexaoMysqli = new mysqli($host, $usuario, $senha, $dataBase);

//Se der algum erro
if($conexaoMysqli->connect_errno)
    //Imprimi a mensagem
    echo "Falha na conexão: ("  . $conexaoMysqli->connect_errno . ") " . $conexaoMysqli->connect_error;

?>