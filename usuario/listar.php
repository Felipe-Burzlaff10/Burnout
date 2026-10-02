<?php

session_start();

require_once "../conexao.php";

$mensagem = "";
$tipoMensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT nome, senha, id_usuario, root
            FROM usuario
            WHERE email = ?";

    $stmt = $conexao->prepare($sql);

    $stmt->bind_param("s", $email);

    $stmt->execute();

    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1)
    {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($senha, $usuario['senha']))
        {
            session_regenerate_id(true);

            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['root'] = $usuario['root'];

            header("Location: ../index.php");
            exit;
        }
        else
        {
            $mensagem = "Senha incorreta.";
            $tipoMensagem = "danger";
        }
    }
    else
    {
        $mensagem = "Usuário não encontrado.";
        $tipoMensagem = "danger";
    }

    $stmt->close();
}

$conexao->close();

?>

<!DOCTYPE html>

<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - BURNOUT</title>


    <!-- Bootstrap -->

    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" 
        rel="stylesheet"
    >


    <!-- Bootstrap Icons -->

    <link 
        rel="stylesheet" 
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >


    <style>

        /* =========================
           GERAL
        ========================= */

        body {

            margin: 0;

            min-height: 100vh;

            background: linear-gradient(
                to bottom,
                #ffffff,
                #a8a8a8
            );

            font-family: Georgia, 'Times New Roman', serif;

        }


        /* =========================
           HEADER
        ========================= */

        header {

            background-color: #39bf00;

            padding: 10px 20px 0;

        }


        /* =========================
           MENU
        ========================= */

        .nav {

            background-color: #39bf00;

            padding: 10px 0;

        }


        .nav-link {

            color: black;

            font-weight: bold;

            font-size: 18px;

            text-transform: uppercase;

            margin: 0 15px;

        }


        .nav-link:hover {

            color: white;

        }


        .nav-link.active {

            border-bottom: 2px solid black;

        }


        /* =========================
           LOGIN
        ========================= */

        .area-login {

            padding: 40px 0;

        }


        .card-login {

            background-color: #39bf00;

            border-radius: 20px;

            width: 600px;

            max-width: 90%;

            margin: 0 auto;

            padding: 20px 70px 35px 70px;

        }


        .titulo-login {

            font-family: Arial, sans-serif;

            font-size: 60px;

            font-weight: bold;

            text-align: center;

            margin-bottom: 30px;

            color: black;

        }


        /* =========================
           LABELS
        ========================= */

        .form-label {

            font-size: 30px;

            font-weight: bold;

            margin-bottom: 0;

            color: black;

        }


        /* =========================
           INPUTS
        ========================= */

        .form-control {

            background-color: transparent;

            border: none;

            border-bottom: 3px solid black;

            border-radius: 0;

            font-size: 22px;

            height: 45px;

            padding: 0 5px;

            color: black;

            box-shadow: none !important;

        }


        .form-control:focus {

            background-color: transparent;

            border-color: black;

            box-shadow: none;

        }


        .campo {

            margin-bottom: 25px;

        }


        /* =========================
           BOTÃO LOGIN
        ========================= */

        .btn-login {

            display: block;

            margin: 30px auto 15px auto;

            background-color: black;

            color: white;

            border: none;

            border-radius: 20px;

            width: 245px;

            height: 75px;

            font-family: Georgia, 'Times New Roman', serif;

            font-size: 20px;

            font-weight: bold;

        }


        .btn-login:hover {

            background-color: #222;

            color: white;

        }


        /* =========================
           BOTÃO LOGOUT
        ========================= */

        .btn-logout {

            display: block;

            margin: 10px auto 0 auto;

            background-color: transparent;

            color: black;

            border: 2px solid black;

            border-radius: 15px;

            width: 150px;

            height: 45px;

            font-weight: bold;

        }


        .btn-logout:hover {

            background-color: black;

            color: white;

        }


        /* =========================
           RESPONSIVO
        ========================= */

        @media (max-width: 768px) {

            .titulo-login {

                font-size: 45px;

            }

            .card-login {

                padding: 20px 35px 35px 35px;

            }

            .form-label {

                font-size: 25px;

            }

        }

    </style>

</head>


<body>


    <!-- =========================
         HEADER
    ========================= -->

    <header>

        <div class="container-fluid">

            <div class="row align-items-center">


                <!-- LOGO -->

                <div class="col-3">

                    <img 
                        src="../logo.png" 
                        alt="Logo Burnout"
                        style="width: 170px;"
                    >

                </div>


                <!-- TÍTULO -->

                <div class="col-6 text-center">

                    <h1
                        style="
                            font-family: Georgia, 'Times New Roman', serif;
                            font-size: 70px;
                            font-weight: bold;
                            margin: 0;
                            color: black;
                        "
                    >

                        BURNOUT

                    </h1>

                </div>


                <!-- ÍCONES -->

                <div class="col-3 d-flex justify-content-end align-items-center gap-3">


                    <!-- PESQUISA -->

                    <a 
                        href="../pesquisa.php"
                        style="
                            color: black;
                            font-size: 32px;
                        "
                    >

                        <i class="bi bi-search"></i>

                    </a>


                    <!-- CARRINHO -->

                    <a 
                        href="../carrinho.php"
                        style="
                            color: black;
                            font-size: 32px;
                        "
                    >

                        <i class="bi bi-cart3"></i>

                    </a>


                    <!-- USUÁRIO -->

                    <a 
                        href="login.php"
                        style="
                            color: black;
                            font-size: 38px;
                        "
                    >

                        <i class="bi bi-person-circle"></i>

                    </a>


                    <!-- ENTRAR / CADASTRAR -->

                    <a 
                        href="login.php"
                        style="
                            color: black;
                            text-decoration: none;
                            font-weight: bold;
                            font-size: 18px;
                            line-height: 1.1;
                        "
                    >

                        entrar ou<br>
                        cadastrar

                    </a>

                </div>

            </div>

        </div>


        <!-- =========================
             MENU
        ========================= -->

        <ul class="nav justify-content-center">

            <li class="nav-item">

                <a 
                    class="nav-link"
                    href="../index.php"
                >

                    HOME

                </a>

            </li>


            <li class="nav-item">

                <a 
                    class="nav-link"
                    href="../catalogo.php"
                >

                    CATALOGO

                </a>

            </li>


            <li class="nav-item">

                <a 
                    class="nav-link"
                    href="../lancamentos.php"
                >

                    LANÇAMENTOS

                </a>

            </li>


            <li class="nav-item">

                <a 
                    class="nav-link disabled"
                    aria-disabled="true"
                >

                    PINTO

                </a>

            </li>

        </ul>

    </header>



    <!-- =========================
         LOGIN
    ========================= -->

    <div class="container-fluid area-login">

        <div class="card-login">


            <h1 class="titulo-login">

                LOGIN

            </h1>


            <!-- MENSAGEM DE ERRO -->

            <?php if ($mensagem != ""): ?>

                <div 
                    class="alert alert-<?php echo $tipoMensagem; ?> text-center"
                    role="alert"
                >

                    <?php echo $mensagem; ?>

                </div>

            <?php endif; ?>


            <form action="" method="POST">


                <!-- EMAIL -->

                <div class="campo">

                    <label 
                        for="email"
                        class="form-label"
                    >

                        Email

                    </label>


                    <input 
                        type="email"
                        name="email"
                        id="email"
                        class="form-control"
                        required
                    >

                </div>



                <!-- SENHA -->

                <div class="campo">

                    <label 
                        for="senha"
                        class="form-label"
                    >

                        Senha

                    </label>


                    <input 
                        type="password"
                        name="senha"
                        id="senha"
                        class="form-control"
                        required
                    >

                </div>



                <!-- BOTÃO LOGIN -->

                <button 
                    type="submit"
                    class="btn btn-login"
                >

                    LOGAR

                </button>

            </form>



            <!-- LOGOUT -->

            <a 
                href="logout.php"
                class="text-decoration-none"
            >

                <button 
                    type="button"
                    class="btn btn-logout"
                >

                    LOGOUT

                </button>

            </a>

        </div>

    </div>



    <!-- Bootstrap JS -->

    <script 
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
    </script>


</body>

</html>