<?php

//Arquivo com funções do login...

Class Usuario{  //criando uma classe...
    private $pdo; //atributo privado PDO...
    public $msgErro = ""; //atributo publico que contem o erro...

    public function conectar($dbnome, $servidor, $usuario, $senha){ //método/função pública que contem a conexão entre o banco de dados e a página... o que esta dentro dos (são parametros)...
        global $pdo; //para poder ser acessada...
        global $msgErro; //para poder ser acessada...
        //Try catch: uma função que é feita pra tratar de erros e falhas como exceções
        try{ //caso ocorra algum problema com o que está dentro do try...
            $pdo =  new PDO("mysql:dbname=" . $dbnome . ";host=" . $servidor, $usuario, $senha); //fazendo a conexão com o banco...
        }catch (PDOException $e) { //será redirecionado ao bloco catch...
            $msgErro = $e->getMessage(); //inserindo o erro dentro da variável...
        }
        
    }

    public function logar($usuario, $senha){ //método/função pública para logar...
        global $pdo; //para poder ser acessada...
        global $msgErro; //para poder ser acessada...
        //verificar se o email e senha estao cadastrados, se sim
        $sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE usuario = :u AND senha = :s");
        $sql->bindValue(":u",$usuario); //basicamento o bindValue ele meio que abrevia, o $usuario virou: :u...
        $sql->bindValue(":s",md5($senha)); // a $senha virou: :s. E o md5, basicamente criptografa a senha do usúario, dando mais segurança...
        $sql->execute(); //vai executar...
        if($sql->rowCount() > 0){
            //entrar no sistema (sessao)
            $dado = $sql->fetch();
            session_start(); //inicia a sessão...
            $_SESSION['id_usuario'] = $dado['id_usuario']; //verifica se possui o id_usuario...
            return true; //ele está cadastrado, ou seja ele logou...
        } else{
            return false; //não foi possível logar...
        }

        
    }
}

?>