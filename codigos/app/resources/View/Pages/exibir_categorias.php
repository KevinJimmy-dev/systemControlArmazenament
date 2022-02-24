<?php
//Página que exibe todas as categorias, e com funções: EDITAR | EXCLUIR

//Inclui o arquivo de conexão
include '../../../Model/Entity/conexao.php';

//Inicia a sessão
session_start();

//Se não estiver logado
if (!isset($_SESSION['id_usuario'])) {
    //Realoca para a pagina de login
    header("location: login.php");
    exit;
}

//Paginação
//definindo a quantidade de itens por página
$itens_por_pagina = 10;
//pegar página atual
@$pagina = intval($_GET['pagina']);
$inicio = $pagina * $itens_por_pagina;

$consult = "SELECT * FROM categorias_de_produtos LIMIT $inicio, $itens_por_pagina";
$conexao = $conexaoMysqli->query($consult) or die($conexaoMysqli->error);
$num = $conexao->num_rows;

//pega a quantidade total de itens no banco de dados
$num_total = $conexaoMysqli->query("SELECT * FROM categorias_de_produtos")->num_rows;

//definir numero de paginas
$num_paginas = ceil($num_total / $itens_por_pagina);

?>

<!DOCTYPE html>
<html lang="pr-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../_css/style.css">
    <link rel="shortcut icon" href="../imgs/icon.PNG" type="image/x-icon">
    <title>Excluir Categoria</title>
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="brand-title">
                <abbr title="Página Inicial">
                    <a href="funcionario.php">
                        <img class="img-logo" src="../imgs/logo-storage1.png" alt="Logo Storage. System" width="120px">
                    </a>
                </abbr>
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


    <main style="margin-bottom: 20px;">
        <div class="d-flex justify-content-center">
            <h1>Categorias</h1>
        </div>

        
        <div class="msg">
            <?php
            if (isset($_SESSION['msg'])) { //msg se
                echo $_SESSION['msg'];     //deu certo
                unset($_SESSION['msg']);   //ou nao
            }
            ?>
        </div>

        <!-- Tudo será exibido em uma tabela -->
        <div class="container">
            <div class="table-responsive">
                <table class="tabela table table-bordered">
                    <thread>
                        <tr>
                            <th>Categoria</th>
                            <th>Ações</th>
                        </tr>
                    </thread>
                    <?php
                    //Enquanto tiver itens no array, será imprimido, junto com duas funções: EDITAR e EXCLUIR
                    while ($info = $conexao->fetch_assoc()) {
                        echo "<tbody>";
                        echo "<tr>";
                        echo "<td> $info[nome_categoria] </td>";
                        echo "<td>
                                <a href='editar_categoria.php?id_categoria=" . $info['id_categoria'] . "'>
                                    <abbr title='Clique para editar' style='text-decoration: none !important; cursor: pointer;'>
                                        <i class='fas fa-edit black-color'></i>
                                    </abbr> 
                                </a>
                                <strong  style='margin: 0 10px;'>|</strong>
                                <a href='../../../Model/Entity/dell_categoria.php?id_categoria=".$info['id_categoria']."' data-bs-toggle='modal' data-bs-target='#exampleModal".$info['id_categoria']."'>
                                    <abbr title='Clique para excluir' style='text-decoration: none !important; cursor: pointer;'>
                                        <i class='fas fa-trash black-color'></i>
                                    </abbr>
                                </a>
                                <!-- Modal -->
                                    <form id='dell_categoria".$info['id_categoria']."' name='dell_categoria".$info['id_categoria']."' action='../../../Model/Entity/dell_categoria.php?id_categoria=".$info['id_categoria']."' method='POST'>
                                        <div class='modal fade' id='exampleModal".$info['id_categoria']."' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                            <div class='modal-dialog'>
                                                <div class='modal-content'>
                                                    <div class='modal-header'>
                                                        <h5 class='modal-title' id='exampleModalLabel'>Excluir Categoria</h5>
                                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                                    </div>
                                                    <div class='modal-body'>
                                                    Deseja excluir a categoria <strong>".$info['nome_categoria']."</strong>?
                                                    </div>
                                                    <input type='hidden' name='id_categoria' value='".$info['id_categoria']."'>
                                                    <div class='modal-footer'>
                                                        <button type='button' name='action' value='Cancelar' class='btn btn-danger' data-bs-dismiss='modal'> Cancelar </button>
                                                        <button type='submit' name='action' value='Excluir' class='btn btn-success'> Excluir </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                             </td>";
                        echo "</tr>";
                        echo "</tbody>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </main>

    <nav aria-label="..." class="distance-bottom">
        <ul class="pagination justify-content-center">
            <li class="page-item">
                <a href="exibir_categorias.php?pagina=0" class="page-link">Anterior</a>
            </li>
            <?php
            for ($i = 0; $i < $num_paginas; $i++) {
                if ($pagina == $i) {
                    echo "<li class='page-item active'>
                            <a class='page-link' href='exibir_categorias.php?pagina=$i'>
                                " . $i + 1 . "
                            </a>
                        </li>";
                } else {
                    echo "<li class='page-item'>
                            <a class='page-link' href='exibir_categorias.php?pagina=$i'>
                                " . $i + 1 . "
                            </a>
                        </li>";
                }
            } ?>
            <li class="page-item">
                <a href="exibir_categorias.php?pagina=<?php echo $num_paginas - 1; ?>" class="page-link" href="#">Próxima</a>
            </li>
        </ul>
    </nav>

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
                    <h5 class="modal-title" id="exampleModalLabel">Cadastrar Funcionário(a) - Ajuda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <article>
                        <h6>Para o que serve essa página?</h6>
                        <p>Essa página exibe todas as categorias que já foram cadastradas.</p>
                        <p>No final de cada linha tem duas opções: <i class='fas fa-edit black-color'></i> para editar e <i class='fas fa-trash black-color'></i> para excluir.</p>
                        <br>
                        <p>Além de um cabeçalho para melhor navegação pelo site, e um rodapé para ter mais informações sobre o desenvolvimento e para ajudar o usuário a como usar o software.</p>
                    </article>
                    <hr>
                    <article>
                        <h6>Como cadastrar uma nova Categoria?</h6>
                        <p>Clique na opção <strong>Categorias <i class="fas fa-list"></i> </strong>, depois abaixo clique em <strong>Cadastrar Categoria</strong>, e você será levado a página de cadastro.</p>
                    </article>
                    <hr>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ocultar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="../../../Controller/Pages/_js/navbar.js"></script>
</body>

</html>