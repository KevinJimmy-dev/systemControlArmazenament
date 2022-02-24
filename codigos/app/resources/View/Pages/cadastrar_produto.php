<?php
//Página para cadastrar um produto
include '../../../Model/Entity/conexao.php';

session_start(); //inicia a sessão...
if (!isset($_SESSION['id_usuario'])) { //se não estiver definida, não possuir um id_usuario
    header("location: login.php"); // vai mandar ele devolta para a página de login...
    exit; //para a execução, do codigo restante...
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../_css/style.css">
    <link rel="shortcut icon" href="../imgs/icon.PNG" type="image/x-icon">
    <title>Cadastrar Produto</title>
</head>

<body>
    <header>
        <nav class="navbar" style="padding-right: 16px; padding-left: 16px;">
            <div class="brand-title">
                <a href="administrador.php">
                    <abbr title="Página Inicial">
                        <img class="img-logo" src="../imgs/logo-storage1.png" alt="Logo Storage. System" width="120px">
                    </abbr>
                </a>
            </div>
            <a href="#" class="toggle-button">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </a>
            <div class="navbar-links">
                <ul>
                    <!-- Dropdown Funcionarios -->
                    <?php
                    if ($_SESSION['nivel_usuario'] != 1) {
                    } else {
                        echo '<li class="dropdown">
                                    <a class="dropdown-toggle" href="exibir_func.php" data-bs-toggle="dropdown">
                                        <strong>Funcionários <i class="fas fa-users black-color"></i> </strong>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="exibir_func.php">Exibir Funcionários</a></li>
                                        <li><a class="dropdown-item" href="cadastrar_funcionario.php">Cadastrar Funcionário(a)</a>
                                        </li>
                                    </ul>
                                </li>';
                    }
                    ?>
                    <!-- Dropdown Categorias -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" href="exibir_categorias.php" data-bs-toggle="dropdown">
                            <strong>Categorias <i class="fas fa-list black-color"></i> </strong>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="exibir_categorias.php">Exibir Categorias</a></li>
                            <li><a class="dropdown-item" href="cadastrar_categoria.php">Cadastrar Categoria</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="pesquisar_produto.php" class="li-color"><strong>Pesquisar Produto <i class="fas fa-search black-color"></i> </strong></a>
                    </li>
                    <li>
                        <a href="requisicao.php" class="li-color"><strong>Requisição <i class="fas fa-utensils black-color"></i> </strong></a>
                    </li>
                    <li>
                        <a href="cadastrar_produto.php" class="li-color"><strong>Cadastrar Produto <i class="fas fa-plus-circle black-color"></i> </strong></a>
                    </li>
                    <li>
                        <a class="sair-li" href="../../../Controller/Pages/sair.php"><strong class="black-color"> Sair <i class="fas fa-sign-out-alt"></i> </strong>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <div class="d-flex justify-content-center">
            <h1>Cadastrar produto</h1>
        </div>

        <div class="msg">
            <?php
            //Caso ocorrer algum erro, vai imprimir uma msg nessa variavel
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>
        </div>

        <div class="container w-50 p-3 text-center">
            <!-- Formulario -->
            <form method="POST" action="../../../Model/Entity/processa.php">

                <!-- Input do nome do produto -->
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" required name="nome_produto" id="nome" onkeyup="checar()" maxlength="75" placeholder="Digite o nome do produto">
                    <label for="nome" class="required">Produto</label>
                </div>

                <!-- Select da categoria -->
                <div class="form-floating">
                    <select class="form-select" name="categoria_produto" required id="categoria" onkeyup="checar()">
                        <option>Selecione</option>
                        <?php
                        $result_categoria = "SELECT * FROM categorias_de_produtos";
                        $resultado_categoria = mysqli_query($conexaoMysqli, $result_categoria);
                        while ($row_categoria = mysqli_fetch_assoc($resultado_categoria)) { ?>
                            <option value="<?php echo $row_categoria['id_categoria'] ?>">
                                <?php echo $row_categoria['nome_categoria']; ?>
                            </option> <?php
                                    }
                                        ?>
                    </select>
                    <label for="categoria" class="required">Categoria</label>
                </div>

                <!-- Input da quantidade -->
                <div class="form-floating mb-3 mt-3">
                    <input type="number" class="form-control" required name="quantidade_produto" id="quantidade" onkeyup="checar()" min="0.00" step="0.01" placeholder="Digite a quantidade">
                    <label for="quantidade" class="required">Quantidade</label>
                </div>

                <!-- Div que vai aparecer uma mensagem -->
                <div id="retorno"></div>

                <!-- Input da validade -->
                <div class="form-floating mb-3">
                    <input type="date" class="form-control" required name="validade_produto" id="validade" onkeyup="checar()" min="2022-01-01">
                    <label for="validade" class="required">Validade</label>
                </div>

                <!-- Input da entrega -->
                <div class="form-floating mb-3">
                    <input type="date" class="form-control" required name="entrega_produto" id="entrega" onkeyup="checar()" min="2022-01-01">
                    <label for="entrega" class="required">Data de entrega</label>
                </div>

                <!-- Textarea da observação -->
                <div class="form-floating">
                    <textarea type="text" class="form-control" name="observacao_produto" id="obs" placeholder="Se tiver alguma observação..." style="height: 100px"></textarea>
                    <label for="obs">Observação</label>
                </div>

                <!-- Botão -->
                <abbr title="Preencha os campos para cadastrar um produto!" id="abbr">
                    <div class="row">
                        <div class="col text-center">
                            <input type="submit" class="btn btn-info mt-4" value="CADASTRAR" id="botao" disabled>
                        </div>
                    </div>
                </abbr>
            </form>
        </div>
    </main>

    <!-- Rodapé -->
    <footer>
        <div class="cont">
            <div class="sobre isso">
                <h2>Sobre</h2>
                <p>
                    Esse site foi desenvolvido pelo Squad Fine Crew, com 4 integrantes, sendo eles: Allyfer, Kevin, Maria Eduarda e Paulo.<br>
                    O objetivo dele é ajudar e facilitar o trabalho do setor da cozinha do Marista Ir. Acácio.
                </p>
            </div>
            <div class="sobre links">
                <h2>Precisa de ajuda?</h2>
                <ul>
                    <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="far fa-question-circle"></i> Clique aqui</a></li>
                </ul>
            </div>
            <div class="sobre contato">
                <h2>Contatos</h2>
                <ul class="info">
                    <li>
                        <p>
                            <a href="https://www.instagram.com/allyfer16/" target="_blank"><i class="fab fa-instagram"></i> Allyfer - Front-End</a><br>
                            <a href="https://www.instagram.com/kevin_jim.my/" target="_blank"><i class="fab fa-instagram"></i> Kevin - Back-End e Front-End</a><br>
                            <a href="#"><i class="fab fa-instagram"></i> Maria Eduarda - Design</a><br>
                            <a href="https://www.instagram.com/paulo.henriq512/" target="_blank"><i class="fab fa-instagram"></i> Paulo Henrique - Front-End</a><br>
                        </p>
                    </li>
                </ul>
            </div>
        </div>
    </footer>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastrar Produto - Ajuda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <article>
                        <h6>Para o que serve essa página?</h6>
                        <p>Essa página é responsável pelo cadastro de novos produtos. </p>
                        <br>
                        <p>Além de um cabeçalho para melhor navegação pelo site, e um rodapé para ter mais informações sobre o desenvolvimento e para ajudar o usuário a como usar o software.</p>
                    </article>
                    <hr>
                    <article>
                        <h6>Como cadastrar um novo Produto?</h6>
                        <p>Preencha todos os campos para cadastrar um novo produto, e depois clique no botão cadastrar.</p>
                    </article>
                    <hr>
                    <article>
                        <h6>Onde vejo os produtos cadastrados?</h6>
                        <p>Clique na logo <strong>Layoff</strong> e será encaminhado a tela inicial, que contém uma tabela que exibe todos os produtos. Abaixo da tabela existe uma paginação que mostra mais resultados, são exibidos 10 resultados por página.</p>
                        <br>
                        <p>Caso ainda não tenha achado o produto que você cadastrou, acesse a aba  <strong>Pesquisar Produto <i class="fas fa-search"></i> </strong> na navegação, e você será encaminhado para a página responsável por isso.</p>
                    </article>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ocultar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Javascript com uma função para habilitar o botão -->
    <script>
        //Função para ativar/desativar o botão
        function checar() {
            //Variaveis recebendo os antigos valores
            var nome_produto       = document.getElementById("nome").value;
            var categoria_produto  = document.getElementById("categoria").value;
            var quantidade_produto = document.getElementById("quantidade").value;
            var validade_produto   = document.getElementById("validade").value;
            var entrega_produto    = document.getElementById("entrega").value;

            var botao = document.getElementById("botao");
            var abbr = document.getElementById("abbr");

            //Se tiver um dos campos obrigatórios vazios
            if (nome_produto == "" && categoria_produto == "" && quantidade_produto == "" && validade_produto == "" && entrega_produto == "") {
                botao.setAttribute('disabled', 'disabled');
                abbr.setAttribute('title', 'Preencha os campos para cadastrar um produto!');

            //Se não ativa, e muda o abbr
            } else {
                botao.removeAttribute('disabled');
                abbr.setAttribute('title', 'Clique para cadastrar um produto!');
            }

            //Se a quantidade for zero
            if (quantidade_produto == "") {
                //Adiciona um frase de aviso
                document.getElementById("retorno").innerHTML = '<p class=left-align>Se for <strong>Quilos</strong>, adicione uma virgula,  e pelo menos o número 1 após a virgula, para o sistema entender...</p><br>';

            //Se não, nada
            } else {
                document.getElementById("retorno").innerHTML = "";
            }
        }
    </script>
    <script src="../../../Controller/Pages/_js/navbar.js"></script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>