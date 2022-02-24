<?php
//Página para pesquisar produtos

//Inclui o arquivo de conexão
include '../../../Model/Entity/conexao.php';

//Inicia a sessão...
session_start(); 

//Se não estiver logado
if (!isset($_SESSION['id_usuario'])) {
    //vai realocar o usuario devolta para a página de login
    header("location: login.php"); 
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="../_css/style.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="shortcut icon" href="../imgs/icon.PNG" type="image/x-icon">
    <link rel="stylesheet" href="../_css/responsive1.css">
    <title>Pesquisar Produtos</title>
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="brand-title">
                <a href="funcionario.php">
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
        <div class="container">
            <form method="GET" action="../../../Model/Entity/pesquisar.php">
                <div class="row justify-content-md-center">
                    <div class="col-sm-4 my-4" id="div-pesquisa">
                        <div class="input-group">
                            <!-- Input para pesquisar -->
                            <input id="input-pesq" class="form-control" name="nome_produto" type="text" placeholder="Digite o nome do produto...">
                            <div class="input-group-btn">
                                <button id="btn-pesq" class="btn btn-default" type="submit" name="pesquisarProduto">
                                    <!-- Img dentro do button -->
                                    <img src="https://img.icons8.com/external-dreamstale-lineal-dreamstale/32/000000/external-search-seo-dreamstale-lineal-dreamstale-7.png" width="67%" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="d-flex justify-content-center">
            <h1 class="title" style="margin-top: 0;">Produtos</h1>
        </div>

        <div class="msg">
            <?php
            //Caso ocorrer algum erro, vai imprimir uma msg nessa variavel...
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>
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
                    <h5 class="modal-title" id="exampleModalLabel">Pesquisar Produto - Ajuda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <article>
                        <h6>Para o que serve essa página?</h6>
                        <p>Essa página exibe os resultados da pesquisa feita pelo usuário, no campo pesquisar.</p>
                        <br>
                        <p>Além de um cabeçalho para melhor navegação pelo site, e um rodapé para ter mais informações sobre o desenvolvimento e para ajudar o usuário a como usar o software.</p>
                    </article>
                    <hr>
                    <article>
                        <h6>Como pesquisar um produto?</h6>
                        <p>Para pesquisar um produto preencha o campo com a sua pesquisa e clique no botão <img src="https://img.icons8.com/external-dreamstale-lineal-dreamstale/32/000000/external-search-seo-dreamstale-lineal-dreamstale-7.png" width="3%" /> azul para executar a pesquisa.</p>
                        <br>
                        <p>Os resultados serão exibidos abaixo dentro de uma tabela.</p>
                    </article>
                    <hr>
                    <article>
                        <h6>Poucos resultados?</h6>
                        <p>Duas possibilidades, a primeira é de que existem poucos produtos de acordo com a sua pesquisa; E a segunda é de que são exibidos 10 produtos por página.</p>
                        <br>
                        <p>Para acessar outras páginas clique na paginação que aparece embaixo da tabela.</p>
                    </article>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ocultar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="../../../Controller/Pages/_js/navbar.js"></script>

</body>

</html>