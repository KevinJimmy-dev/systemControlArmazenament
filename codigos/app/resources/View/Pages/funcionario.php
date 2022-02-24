<?php
//Página principal dos funcionários, assim que sair do login, serão redirecionados pra cá...

//Inclui a conexão
include '../../../Model/Entity/conexao.php';

//inicia a sessão
session_start(); 

//Se não estiver logado
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['status_usuario'])) {
    //Realoca para o login
    header("location: login.php");
    exit;

//Se for um administrador
} else if ($_SESSION['nivel_usuario'] != 0) {
    //Realoca para a pagina de administrador
    header("location: administrador.php");

//Se estiver logado
} else if ($_SESSION['status_usuario'] != 1) {
    //Exibe um alert e realoca para a pagina de login
    echo "<script>alert('Usuário sem acesso!');</script>";
    header("location: login.php");
    exit;
}

//Paginação
//definindo a quantidade de itens por página
$itens_por_pagina = 10;
//pegar página atual
@$pagina = intval($_GET['pagina']);
$inicio = $pagina * $itens_por_pagina;

$consulta = "SELECT * FROM produto LIMIT $inicio, $itens_por_pagina"; //variavel que vai consultar o banco de dados...
$con = $conexaoMysqli->query($consulta) or die($conexaoMysqli->error); //vai fazer a conexao com outra variavel, caso der errado, vai matar a conexao...
$num = $con->num_rows;

//pega a quantidade total de itens no banco de dados
$num_total = $conexaoMysqli->query("SELECT * FROM produto")->num_rows;

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
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="shortcut icon" href="../imgs/icon.PNG" type="image/x-icon">
    <link rel="stylesheet" href="../_css/style.css">
    <title>Sistema de armazenamento</title>
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="brand-title">
                <abbr title="Página Inicial">
                    <a href="funcionario.php?pagina=0"><img class="img-logo" src="../imgs/logo-storage1.png" alt="Logo Storage. System" width="120px"></a>
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

    <main>
        <div class="d-flex justify-content-center">
            <h1>Tabela de Produtos</h1>
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

        <!-- Tabela -->
        <div class="container">
            <div class="table-responsive" id="tbl">
                <table class="tabela table table-bordered">
                    <thread>
                        <tr>
                            <th>Produto</td>
                            <th>Quantidade</td>
                            <th>Entrega</td>
                            <th>Validade</td>
                            <th>Observação</td>
                            <th>Categoria</td>
                            <th>Ações</td>
                        </tr>
                    </thread>
                    <?php
                    //vai emprimir tudo da tabela...
                    while ($dados = $con->fetch_assoc()) {
                        //para emprimir o nome da categoria...
                        $busca_categoria = "SELECT nome_categoria FROM categorias_de_produtos WHERE id_categoria = '$dados[id_categoria]'";
                        $buscou = $conexaoMysqli->query($busca_categoria);
                        $categoria = $buscou->fetch_assoc();

                        echo "<tr>";
                        echo "<td class='left-align'>" . $dados['nome_produto'] . "</td>";
                        $search = ",";
                        $dados['quantidade_produto'] = str_replace(".", ",", $dados['quantidade_produto']);
                        if (strpos($dados['quantidade_produto'], $search) !== false) {
                            echo "<td> $dados[quantidade_produto] <abbr title='Quilos'><strong>Kg</strong></abbr> </td>";
                        } else {
                            echo "<td> $dados[quantidade_produto] <abbr title='Unidades'><strong>Un</strong></abbr> </td>";
                        }
                        echo "<td>" . date("d/m/Y", strtotime($dados['entrega_produto'])) . "</td>";
                        echo "<td>" . date("d/m/Y", strtotime($dados['validade_produto'])) . "</td>";
                        echo "<td class='left-align'>" . $dados['observacao_produto'] . "</td>";
                        echo "<td>" . $categoria['nome_categoria'] . "</td>";
                        echo "<td> 
                                    <a class='black-color' href='editar_produto.php?id_produto=" . $dados['id_produto'] . "'>
                                        <abbr title='Clique para editar' style='text-decoration: none !important; cursor: pointer;'>
                                            <i class='fas fa-pen'></i>
                                        </abbr>
                                    </a>
                                    <strong  style='margin: 0 10px;'>|</strong>  
                                    <a class='black-color' href='del_produto.php?id_produto=" . $dados['id_produto'] . "' data-bs-toggle='modal' data-bs-target='#exampleModal".$dados['id_produto']."'>
                                        <abbr title='Clique para excluir' style='text-decoration: none !important; cursor: pointer;'>
                                            <i class='fas fa-trash'></i>
                                        </abbr>
                                    </a>
                                    <!-- Modal -->
                                    <form id='del_produto".$dados['id_produto']."' name='del_produto".$dados['id_produto']."' action='../../../Model/Entity/del_produto.php?id_produto=".$dados['id_produto']."' method='POST'>
                                        <div class='modal fade' id='exampleModal".$dados['id_produto']."' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                            <div class='modal-dialog'>
                                                <div class='modal-content'>
                                                    <div class='modal-header'>
                                                        <h5 class='modal-title' id='exampleModalLabel'>Excluir produto</h5>
                                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                                    </div>
                                                    <div class='modal-body'>
                                                    Deseja excluir o produto <strong>".$dados['nome_produto']."</strong>?
                                                    </div>
                                                    <input type='hidden' name='id_produto' value='".$dados['id_produto']."'>
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
                    }
                    ?>
                </table>
            </div>
        </div>
        <!-- fim da table -->
    </main>

    <nav aria-label="..." class="distance-bottom">
        <ul class="pagination justify-content-center">
            <li class="page-item">
                <a href="funcionario.php?pagina=0" class="page-link">Primeira</a>
            </li>
            <?php
            for ($i = 0; $i < $num_paginas; $i++) {
                if ($pagina == $i) {
                    echo "<li class='page-item active'>
                            <a class='page-link' href='funcionario.php?pagina=$i'>
                                " . $i + 1 . "
                            </a>
                        </li>";
                } else {
                    echo "<li class='page-item'>
                            <a class='page-link' href='funcionario.php?pagina=$i'>
                                " . $i + 1 . "
                            </a>
                        </li>";
                }
            } ?>
            <li class="page-item">
                <a href="funcionario.php?pagina=<?php echo $num_paginas - 1; ?>" class="page-link">Ultima</a>
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
                    <li><a href="#"><i class="far fa-question-circle"></i> Clique aqui</a></li>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="../../../Controller/Pages/_js/navbar.js"></script>
</body>

</html>