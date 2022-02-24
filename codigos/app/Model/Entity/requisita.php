<?php
//Arquivo que fará a requisição

//Inclui o arquivo de conexão
include_once 'conexao.php';

//Inicia sessão
session_start();

//Se tiver apertado o botão
if (isset($_POST['botao'])) {
        //Variaveis que recebem os valores da input
        @$qntDisp      = $_POST['qnt'];
        @$requisicao   = $_POST['req'];
        @$nome_produto = $_POST['escondido'];

        //Se adicionar não adicionar nada a tabela e clicar no botão de requistar
        if (empty($qntDisp)) {
            //Exibe um alert e realoca o usuario para a pagina de requisição
            echo "<script>alert('Por favor, selecione algum item para fazer uma requisição!');</script>";
            echo "<script>window.location.href = '../../resources/View/Pages/requisicao.php';</script>";

        //Se não estiver vazia
        } else {
            //Estrutura de repetição para fazer as requisições
            for ($i = 0; $i < count($requisicao); $i++) {
                //Busca algumas informações do produto desejado
                $busca = "SELECT id_produto, quantidade_produto FROM produto WHERE nome_produto = '$nome_produto[$i]'";
                $resultados = mysqli_query($conexaoMysqli, $busca);

                //Faz um array com a busca
                while ($resu = mysqli_fetch_assoc($resultados)) {
                    //Variavel recebendo o valor de uma do array
                    $id = $resu['id_produto'];

                    //Se a requisição for invalida
                    if ($requisicao[$i] < 0) {
                        //Exibe um alert e realoca o usuario para a pagina de requisição
                        echo "<script>alert('Por favor preencha um ou mais campos da requisição!');</script>";
                        echo "<script>window.location.href = '../../resources/View/Pages/requisicao.php';</script>";

                    //Se a o valor desejado for maior do que o disponivel
                    } else if ($requisicao[$i] > $qntDisp[$i]) {
                        //Exibe um alert e realoca o usuario para a pagina de requisiçaõ
                        echo "<script>alert('O valor desejado é maior do que o dísponivel!');</script>";
                        echo "<script>window.location.href = '../../resources/View/Pages/requisicao.php';</script>";

                    //Se estiver tudo certo
                    } else {
                        //Variavel recebendo a subtração das variaveis
                        $sub[$i] = $qntDisp[$i] - $requisicao[$i];
                        $subtr = "UPDATE produto SET quantidade_produto = '$sub[$i]' WHERE id_produto = '$id'";

                        //Se der certo a execução do comando
                        if (mysqli_query($conexaoMysqli, $subtr)) {
                            //Comando do insert na tabela requisicao
                            $insert_requisicao = "INSERT INTO requisicao (data_requisicao, id_produto, id_usuario) VALUES (NOW(), '$id', '$_SESSION[id_usuario]')";

                            //Se der certo a execução do insert na tabela requisicao
                            if (mysqli_query($conexaoMysqli, $insert_requisicao)) {
                                //Select para pegar o id da requisicao e faz um array
                                $select_req = "SELECT id_requisicao FROM requisicao WHERE id_produto = '$id' AND data_requisicao = NOW()";
                                $busca = $conexaoMysqli->query($select_req);
                                $req = $busca->fetch_assoc();

                                //Comando do insert na tabela requisicao_produto
                                $insert_requisicaoProduto = "INSERT INTO requisicao_produto (quantidade, id_requisicao, id_produto) VALUES ('$requisicao[$i]', '$req[id_requisicao]', '$id')";

                                //Se der certo a execução do insert na tabela requisicao_produto
                                if (mysqli_query($conexaoMysqli, $insert_requisicaoProduto)) {
                                    //Exibe um alert e realoca o usuario para a pagina dos funcionarios
                                    echo "<script>alert('A requisição foi feita com sucesso!');</script>";
                                    echo "<script>window.location.href = '../../resources/View/Pages/funcionario.php'</script>";
                                }
                            }
                        //Se der algum erro
                        } else {
                            //Exibe uma mensagem e realoca o usuario para a pagina de requisicao
                            $_SESSION['msg'] = "<p style='color:red;'>A Requisição falhou!</p>";
                            header("location: ../../resources/View/Pages/requisicao.php");
                        }
                    }
                }
            }
        }
    }