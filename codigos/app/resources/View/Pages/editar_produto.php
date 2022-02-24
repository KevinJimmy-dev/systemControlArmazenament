<?php
//Página para editar um produto

//Inclui o arquivo de conexao
include_once '../../../Model/Entity/conexao.php';

//Inicia a sessão
session_start();

//Se não estiver logado
if (!isset($_SESSION['id_usuario'])) {
    //Realoca para a página de login
    header("location: login.php");
    exit;
}

//Variavel que recebe o id do produto e faz um select. Depois um array
$id_produto = filter_input(INPUT_GET, 'id_produto', FILTER_SANITIZE_NUMBER_INT);
$result_produto = "SELECT * FROM produto WHERE id_produto = '$id_produto'";
$resultado_produto = mysqli_query($conexaoMysqli, $result_produto);
$linha_produto = mysqli_fetch_assoc($resultado_produto);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="shortcut icon" href="../imgs/icon.PNG" type="image/x-icon">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../_css/style.css">
    <link rel="stylesheet" href="../_css/cads.css">
    <title>Editar Produto</title>
</head>

<body>
    <header>
        <nav class="navbar" style="padding-right: 16px; padding-left: 16px;">
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

    <main>
        <div class="d-flex justify-content-center">
            <h1>Editar Produto</h1>
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

        <div class="container w-50 p-3">
            <form method="POST" action="../../../Model/Entity/edit_produto.php" name="myForm" id="form">
                <input type="hidden" name="id_produto" value="<?php echo $linha_produto['id_produto']; ?>">

                <div class="form-floating mb-3">
                    <input type="text" name="nome_produto" class="form-control" id="nome" onkeyup="comparar()" value="<?php echo $linha_produto['nome_produto']; ?>">
                    <label for="nome">Produto</label>
                </div>


                <div class="form-floating mb-3">
                    <input type="number" name="quantidade_produto" class="form-control" id="quantidade" step=".01" onkeyup="comparar()" value="<?php echo $linha_produto['quantidade_produto']; ?>">
                    <label>Quantidade</label>
                </div>


                <div class="form-floating mb-3">
                    <input type="date" name="entrega_produto" class="form-control" id="entrega" onkeyup="comparar()" value="<?php echo $linha_produto['entrega_produto']; ?>" min="2022-01-01">
                    <label>Data de entrega</label>
                </div>


                <div class="form-floating mb-3">
                    <input type="date" name="validade_produto" class="form-control" id="validade" onkeyup="comparar()" value="<?php echo $linha_produto['validade_produto']; ?>" min="2022-01-01">
                    <label>Data de Validade</label>
                </div>


                <div class="form-floating mb-3">
                    <textarea type="text" name="observacao_produto" class="form-control" id="observacao" onkeyup="comparar()"><?php echo $linha_produto['observacao_produto']; ?></textarea>
                    <label>Observação</label>
                </div>


                <div class="form-floating mb-3">
                    <select name="categoria_produto" class="form-select" id="categoria" onmouseleave="comparar()">
                        <!-- Option com PHP que mostrará todas as categorias que possui, e já virá selecionada a que o produto possui atualmente -->
                        <?php
                        //Busca e execução
                        $result_categoria = "SELECT * FROM categorias_de_produtos";
                        $resultado_categoria = mysqli_query($conexaoMysqli, $result_categoria);

                        //Estrutura de repetição, se der certo a formação do array
                        while ($row_categoria = mysqli_fetch_assoc($resultado_categoria)) { ?>
                            <!-- Se for igual, imprimi como selected -->
                            <?php if ($row_categoria['id_categoria'] == $linha_produto['id_categoria']) {
                                echo "<option value='" . $row_categoria['id_categoria'] . "' selected>" . $row_categoria['nome_categoria'] . "</option>";
                            //Se não for igual, impimi normal mesmo
                            } else { ?>
                                <option value="<?php echo $row_categoria['id_categoria'] ?>">
                                    <?php echo $row_categoria['nome_categoria']; ?>
                                </option> <?php
                                        }
                                    }
                                            ?>
                    </select>
                    <label>Categoria</label>
                </div>

                <div class="row">
                    <div class="col text-center">
                        <abbr title="Altere um dos campos..." id="abbr">
                            <input type='submit' name='botao' class="btn btn-info" id="botao" value='SALVAR' disabled>
                        </abbr>
                    </div>
                </div>
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

    <!-- Para ativar o button caso houver alguma alteração -->
    <!-- Pegando os valores originais, com Javascript dentro do PHP...-->
    <?php
    //Pega os antigos valores para comparar depois
    $script =
        "<script>
                    var produto_or    = '$linha_produto[nome_produto]';
                    var quantidade_or = '$linha_produto[quantidade_produto]';
                    var entrega_or    = '$linha_produto[entrega_produto]';
                    var validade_or   = '$linha_produto[validade_produto]';
                    var observacao_or = '$linha_produto[observacao_produto]';
                    var categoria_or  = '$linha_produto[id_categoria]';
                </script>";
    echo $script;
    ?>
    <!-- Função que compara os valores antigos e os novos -->
    <script>
        function comparar() {
            //Variáveis que possuem os novos valores (caso houver)
            var produto_novo = document.getElementById('nome').value;
            var quantidade_novo = document.getElementById('quantidade').value;
            var entrega_novo = document.getElementById('entrega').value;
            var validade_novo = document.getElementById('validade').value;
            var observacao_novo = document.getElementById('observacao').value;
            var categoria_novo = document.getElementById('categoria').value;
            //Colocando o botao em uma variavel
            var button = document.getElementById('botao');
            var abbr = document.getElementById('abbr');

            //Se não houver alguma modificação em um dos campos
            if (produto_or === produto_novo && quantidade_or === quantidade_novo && entrega_or === entrega_novo && validade_or === validade_novo && observacao_or === observacao_novo && categoria_or === categoria_novo) {
                //o botão continua desativado
                button.setAttribute('disabled', 'disabled');
                abbr.setAttribute('title', 'Altere um dos campos...');

            //Se estiver vazias
            } else if (produto_novo === "" || quantidade_novo === "" || entrega_novo === "" || validade_novo === "" || categoria_novo === "") {
                //Se o usuário deixar algum campo obrigatório vazio
                button.setAttribute('disabled', 'disabled');
                abbr.setAttribute('title', 'Não deixe nenhum campo obrigatório vazio!');

            //Se tiver mudanças 
            } else {
                //O botão é ativado
                button.removeAttribute('disabled');
                abbr.setAttribute('title', 'Clique para salvar as alterações...');
            }
        }
    </script>
    <script src="../../../Controller/Pages/_js/navbar.js"></script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>