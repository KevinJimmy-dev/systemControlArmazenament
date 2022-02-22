<?php
//Página que exibe todos os funcionários, com funções: EDITAR e EXCLUIR
include '../../../Model/Entity/conexao.php';

session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("location: login.php");
    exit;
} else if ($_SESSION['nivel_usuario'] != 1) {
    header("location: funcionario.php");
}

//definindo a quantidade de itens por página
$itens_por_pagina = 10;
//pegar página atual
@$pagina = intval($_GET['pagina']);
$inicio = $pagina * $itens_por_pagina;

//Comando MYSQL e execução dele
$consultar = "SELECT * FROM usuarios WHERE nivel_usuario != 1 LIMIT $inicio, $itens_por_pagina";
$conex = $conexaoMysqli->query($consultar) or die($conexaoMysqli->error);
$num = $conex->num_rows;

//pega a quantidade total de itens no banco de dados
$num_total = $conexaoMysqli->query("SELECT * FROM categorias_de_produtos")->num_rows;

//definir numero de paginas
$num_paginas = ceil($num_total / $itens_por_pagina);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="../_css/style.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="shortcut icon" href="../imgs/icon.PNG" type="image/x-icon">
    <title>Exibir Funcionários</title>
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="brand-title">
                <a href="administrador.php">
                    <abbr title="Página Inicial">
                        <img class="img-logo" src="../imgs/logo-layoff.png" alt="Logo" width="120px">
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
            <h1>Exibir Funcionários</h1>
        </div>

        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>

        <!-- Todos os funcionários estão sendo exibidos dentro de uma tabela -->
        <div class="container">
            <div class="table-responsive" id="tbl">
                <table class="tabela table table-bordered">
                    <thread>
                        <tr>
                            <th>Nome do Funcionário(a)</td>
                            <th>Nome de Usuário</td>
                            <th>Nivel</td>
                            <th>Status</td>
                            <th>Ações</td>
                        </tr>
                    </thread>
                    <?php
                    //Jogará os resultados para uma variável, e enquanto tiver valores não emprimidos
                    while ($stats = $conex->fetch_assoc()) {
                        echo "<tbody>";
                        echo "<tr>";
                        echo "<td class='left-align'> $stats[nome_usuario] </td>";
                        echo "<td class='left-align'> $stats[username_usuario] </td>";
                        //Se o nível do usuário for 0, ele é um funcionário
                        if ($stats['nivel_usuario'] == 0) {
                            echo "<td> Funcionário(a) </td>";
                            //Se o nível do usuário for 1, ele é um administrador
                        } else if ($stats['nivel_usuario'] == 1) {
                            echo "<td> Administrador </td>";
                        }
                        //Se o status do usuário for 1, ele está ativo
                        if ($stats['status_usuario'] == 1) {
                            echo "<td> Ativo </td>";
                            //Se o status do usuário for 0, ele está inativo
                        } else if ($stats['status_usuario'] == 0) {
                            echo "<td class='text-danger'> Inativo </td>";
                        }
                        //Botões de editar e excluir, com janela modal no excluir
                        echo "
                            <td>
                                <a class='black-color' href='editar_func.php?id_usuario=" . $stats['id_usuario'] . "'>
                                    <abbr title='Clique para editar' style='text-decoration: none !important; cursor: pointer;'>
                                        <i class='fas fa-user-edit'></i>
                                    </abbr>
                                </a>
                                <strong  style='margin: 0 10px;'>|</strong>
                                <a class='black-color' href='../../../Model/Entity/del_func.php?id_usuario=". $stats['id_usuario']."' data-bs-toggle='modal' data-bs-target='#exampleModal".$stats['id_usuario']."'>
                                    <abbr title='Clique para excluir' style='text-decoration: none !important; cursor: pointer;'>
                                        <i class='fas fa-user-minus'></i>
                                    </abbr>
                                </a>
                                <!-- Modal -->
                                    <form id='del_funcionario".$stats['id_usuario']."' name='del_funcionario".$stats['id_usuario']."' action='../../../Model/Entity/del_func.php?id_usuario=".$stats['id_usuario']."' method='POST'>
                                        <div class='modal fade' id='exampleModal".$stats['id_usuario']."' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                            <div class='modal-dialog'>
                                                <div class='modal-content'>
                                                    <div class='modal-header'>
                                                        <h5 class='modal-title' id='exampleModalLabel'>Excluir produto</h5>
                                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                                    </div>
                                                    <div class='modal-body'>
                                                    Deseja excluir o funcionário(a) <strong>".$stats['nome_usuario']."</strong>?
                                                    </div>
                                                    <input type='hidden' name='id_usuario' value='".$stats['id_usuario']."'>
                                                    <div class='modal-footer'>
                                                        <button type='button' name='action' value='Cancelar' class='btn btn-danger' data-bs-dismiss='modal'> Cancelar </button>
                                                        <button type='submit' name='action' value='Excluir' class='btn btn-success'> Excluir </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                            </td>";
                        echo "<tr>";
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
                <a href="exibir_func.php?pagina=0" class="page-link">Anterior</a>
            </li>
            <?php
            for ($i = 0; $i < $num_paginas; $i++) {
                if ($pagina == $i) {
                    echo "<li class='page-item active'>
                            <a class='page-link' href='exibir_func.php?pagina=$i'>
                                " . $i + 1 . "
                            </a>
                        </li>";
                } else {
                    echo "<li class='page-item'>
                            <a class='page-link' href='exibir_func.php?pagina=$i'>
                                " . $i + 1 . "
                            </a>
                        </li>";
                }
            } ?>
            <li class="page-item">
                <a href="exibir_func.php?pagina=<?php echo $num_paginas - 1; ?>" class="page-link" href="#">Próxima</a>
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
                    <h5 class="modal-title" id="exampleModalLabel">Exibir Funcionários - Ajuda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <article>
                        <h6>Para o que serve essa página?</h6>
                        <p>Essa página contém uma tabela com todos os funcionários cadastrados no sistema, com as suas respectivas informações. </p>
                        <br>
                        <p>Ao fim de cada linha possui dois icones, que são botões, sendo eles:  <i class='fas fa-user-edit'></i> para editar e <i class='fas fa-user-minus'></i> para excluir.</p>
                        <br>
                        <p>Além de um cabeçalho para melhor navegação pelo site, e um rodapé para ter mais informações sobre o desenvolvimento e para ajudar o usuário a como usar o software.</p>
                    </article>
                    <hr>
                    <article>
                        <h6>O que cada informação da tabela significa?</h6>
                        <p>São dados de cada funcionário(a), sendo eles: <br>
                            <strong>Nome do Funcionário(a)</strong> - é o nome dele(a)
                            <br>
                            <strong>Nome de Usuário</strong> -  é utilizado para fazer login
                            <br>
                            <strong>Nível</strong> - o nível é para diferenciar um administrador de um funcionário(a)
                            <br>
                            <strong>Status</strong> - o status é para saber se o funcionário ainda está com acesso ao sistema
                        </p>
                    </article>
                    <hr>
                    <article>
                        <h6>Como cadastrar um novo funcionário(a)?</h6>
                        <p>No menu de navegação superior, clique em <strong>Funcionários</strong>, e depois em <strong>Cadastrar Funcionário(a)</strong>.</p>
                    </article>
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