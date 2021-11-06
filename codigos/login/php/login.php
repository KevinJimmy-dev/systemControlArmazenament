<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Links do Bootstrap -->
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Link do css -->
    <link rel="stylesheet" href="../css/login.css">

    <title>Login - 01</title>
</head>

<body>
    <!-- Usando uma tela de login do mdbootstrap -->
    <section class="h-100 gradient-form" style="background-color: #eee;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-10">
                    <div class="card rounded-3 text-black">
                        <div class="row g-0">
                            <div class="col-lg-6">
                                <div class="card-body p-md-5 mx-md-4">

                                    <div class="text-center">
                                        <!-- logo -->
                                        <img src="logo-aqui" style="width: 185px;" alt="logo">
                                        <!-- titulo -->
                                        <h4 class="mt-1 mb-5 pb-1">Cozinha Marista</h4>
                                    </div>

                                    <!-- Formulario -->
                                    <form method="POST">
                                        <p>Faça login para acessar o site</p>
                                        <!-- Usuario -->
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example11">Usúario</label>
                                            <input type="text" name="usuario" id="form2Example11" class="form-control" placeholder="" maxlength="30" />
                                        </div>
                                        <!-- Senha -->
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example22">Senha</label>
                                            <input type="password" name="senha" id="form2Example22" class="form-control" maxlength="32" />
                                        </div>
                                        <!-- Button -->
                                        <div class="text-center pt-1 mb-5 pb-1">
                                            <input type="submit" value="ACESSAR" class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3">
                                        </div>
                                    </form>

                                    <!-- PHP -->
                                    <?php
                                    require_once 'usuarios.php'; //chamando o arquivo usuarios.php...
                                    $u = new Usuario; //adiciona uma nova classe...

                                    if (isset($_POST['usuario'])) { //serve para saber se uma variável está definida
                                        $usuario = addslashes($_POST['usuario']); //addslashes adiciona 
                                        $senha = addslashes($_POST['senha']);     //uma proteção...

                                        if (!empty($usuario) && !empty($senha)) { //se $usuario e $senha NÃO estiverem vazias...
                                            $u->conectar("system", "localhost", "root", ""); //faz a conexão...
                                            if ($u->msgErro == "") { //se a msg de erro estiver vazia (tudo certo)...
                                                if ($u->logar($usuario, $senha)) { //vai usar o $usuario e $senha para conectar...
                                                    header("location:../../program/php/areaPrivada.php"); //se o login der certo vai mandar pra uma area privada...
                                                } else {                                        //se estiver incorreto as informações
                                                    echo "Usúario e/ou senha estão incorretos!";//vai imprimir uma mensagem...
                                                }
                                            } else {
                                                echo "Erro: " . $u->msgErro; //se tiver algum erro vai imprimir...
                                            }
                                        } else { //se tiver algum campo vazio, imprimira a mensagem...
                                            echo "Preencha todos os campos!";
                                        }
                                    }

                                    ?>
                                    <!-- Fim do PHP -->
                                    
                                </div>
                            </div>
                            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                                <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                    <h4 class="mb-4">Texto sobre</h4>
                                    <p class="small mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed
                                        do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                                        veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                        consequat.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
<script src="../javascript/login.js"></script>

</html>