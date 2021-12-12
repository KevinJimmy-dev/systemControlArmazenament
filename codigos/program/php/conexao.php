<?php //arquivo de conexao do site com o banco de dados...

$host = "localhost";
$usuario = "root";
$senha = "";
$dataBase = "db_finecrew"; //mudei o banco... 24/11

//armazenando o valor de uma input dentro de uma váriavel com um filtro... -- NÃO faz parte da conexão...
$id_produto = filter_input(INPUT_POST, 'id_produto', FILTER_SANITIZE_NUMBER_INT); 
$nome_produto = filter_input(INPUT_POST, 'nome_produto', FILTER_SANITIZE_STRING);
$quantidade_produto = filter_input(INPUT_POST, 'quantidade_produto', FILTER_SANITIZE_NUMBER_INT);
$validade_produto = filter_input(INPUT_POST, 'validade_produto', FILTER_SANITIZE_STRING);
$entrega_produto = filter_input(INPUT_POST, 'entrega_produto', FILTER_SANITIZE_STRING);
$observacao_produto =  filter_input(INPUT_POST, 'observacao_produto', FILTER_SANITIZE_STRING);
$id_categoria = filter_input(INPUT_POST, 'categoria_produto', FILTER_SANITIZE_STRING);
//---

$conexaoMysqli = new mysqli($host, $usuario, $senha, $dataBase);

if($conexaoMysqli->connect_errno)
    echo "Falha na conexão: ("  . $conexaoMysqli->connect_errno . ") " . $conexaoMysqli->connect_error;

?>