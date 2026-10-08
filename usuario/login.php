<?php
require_once "../conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $sql = "SELECT nome, senha, id_usuario, root
            FROM usuario
            WHERE email = ?";
    
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('s', $_POST['email']);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $stmt->close();

    if ($resultado->num_rows == 1)
    {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($_POST['senha'], $usuario['senha']))
        {
            echo "Login efetuado com sucesso";

            session_start();
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['root'] = $usuario['root'];

            echo "<script>window.location.href='../index.php';</script>";
        }
        else
        {
            echo "Senha incorreta";
        }
    }
    else
    {
        echo "Usuário não encontrado";
    }
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

        * {
            box-sizing: border-box;
        }


        /* =========================
           BODY
        ========================= */

        body {
            margin: 0;
            min-height: 100vh;
            background: linear-gradient(
                135deg,
                #ffffff 0%,
                #eeeeee 50%,
                #cfcfcf 100%
            );
            font-family: Georgia, 'Times New Roman', serif;
            color: black;
        }


        /* =========================
           HEADER
        ========================= */

        header {
            background-color: #39bf00;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.20);
        }


        .header-top {
            min-height: 120px;
            padding: 15px 35px;
        }


        /* LOGO */

        .logo-area {
            display: flex;
            align-items: center;
        }


        .logo {
            width: 150px;
            max-width: 100%;
        }


        /* TÍTULO */

        .titulo-site {
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 65px;
            font-weight: bold;
            margin: 0;
            letter-spacing: 2px;
        }


        /* =========================
           AÇÕES DO HEADER
        ========================= */

        .acoes-header {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 22px;
        }


        .icone-header {
            color: black;
            text-decoration: none;
            font-size: 30px;
            transition: 0.2s;
        }


        .icone-header:hover {
            color: white;
            transform: translateY(-2px);
        }


        .login-header {
            display: flex;
            align-items: center;
            gap: 8px;

            color: black;
            text-decoration: none;

            font-weight: bold;
            font-size: 16px;
            line-height: 1.1;

            transition: 0.2s;
        }


        .login-header i {
            font-size: 38px;
        }


        .login-header:hover {
            color: white;
        }


        /* =========================
           MENU
        ========================= */

        .menu {
            background-color: black;
        }


        .menu .nav-link {
            color: white;
            font-size: 17px;
            font-weight: bold;
            letter-spacing: 1px;

            padding: 14px 28px;

            transition: 0.2s;
        }


        .menu .nav-link:hover {
            background-color: #39bf00;
            color: black;
        }


        .menu .nav-link.active {
            background-color: #39bf00;
            color: black;
        }


        /* =========================
           ÁREA DO LOGIN
        ========================= */

        .area-login {
            min-height: calc(100vh - 170px);

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 50px 20px 70px;
        }


        /* =========================
           CARD
        ========================= */

        .card-login {
            background-color: #39bf00;

            width: 560px;
            max-width: 100%;

            padding: 40px 65px 45px;

            border-radius: 25px;

            border: 2px solid rgba(0, 0, 0, 0.15);

            box-shadow:
                0 15px 35px rgba(0, 0, 0, 0.25);
        }


        /* =========================
           CABEÇALHO LOGIN
        ========================= */

        .cabecalho-login {
            text-align: center;
            margin-bottom: 35px;
        }


        .icone-login {
            font-size: 55px;
            line-height: 1;
            margin-bottom: 10px;
        }


        .titulo-login {
            font-family: Arial, sans-serif;
            font-size: 52px;
            font-weight: 900;

            margin: 0;

            letter-spacing: 1px;
        }


        .subtitulo-login {
            font-family: Arial, sans-serif;
            font-size: 15px;
            font-weight: bold;

            opacity: 0.7;

            margin-top: 6px;
        }


        .linha-titulo {
            width: 70px;
            height: 5px;

            background-color: black;

            margin: 14px auto 0;

            border-radius: 10px;
        }


        /* =========================
           CAMPOS
        ========================= */

        .campo {
            margin-bottom: 25px;
        }


        .form-label {
            display: block;

            font-family: Arial, sans-serif;

            font-size: 18px;
            font-weight: bold;

            margin-bottom: 8px;
        }


        .form-control {
            height: 52px;

            background-color: rgba(255, 255, 255, 0.35);

            border: 2px solid transparent;

            border-radius: 10px;

            font-family: Arial, sans-serif;

            font-size: 17px;

            padding: 10px 15px;

            color: black;

            transition: 0.2s;

            box-shadow: none !important;
        }


        .form-control:hover {
            background-color: rgba(255, 255, 255, 0.5);
        }


        .form-control:focus {
            background-color: white;

            border-color: black;

            box-shadow:
                0 0 0 3px rgba(0, 0, 0, 0.10) !important;
        }


        /* =========================
           BOTÃO LOGIN
        ========================= */

        .btn-login {
            display: flex;

            align-items: center;
            justify-content: center;

            gap: 10px;

            width: 100%;
            height: 60px;

            margin: 35px auto 15px;

            background-color: black;

            color: white;

            border: none;

            border-radius: 12px;

            font-family: Arial, sans-serif;

            font-size: 18px;
            font-weight: 900;

            letter-spacing: 1px;

            transition: 0.25s;
        }


        .btn-login:hover {
            background-color: #222;

            color: white;

            transform: translateY(-3px);

            box-shadow:
                0 8px 15px rgba(0, 0, 0, 0.25);
        }


        .btn-login i {
            font-size: 20px;
        }


        /* =========================
           LINKS
        ========================= */

        .links-login {
            text-align: center;

            font-family: Arial, sans-serif;

            margin-top: 20px;
        }


        .links-login a {
            color: black;

            font-weight: bold;

            text-decoration: none;

            transition: 0.2s;
        }


        .links-login a:hover {
            text-decoration: underline;
        }


        .separador {
            margin: 0 8px;
            opacity: 0.5;
        }


        /* =========================
           LOGOUT
        ========================= */

        .logout-area {
            margin-top: 25px;

            padding-top: 20px;

            border-top: 1px solid rgba(0, 0, 0, 0.25);

            text-align: center;
        }


        .btn-logout {
            background-color: transparent;

            color: black;

            border: 2px solid black;

            border-radius: 10px;

            width: 150px;
            height: 42px;

            font-family: Arial, sans-serif;

            font-weight: bold;

            transition: 0.2s;
        }


        .btn-logout:hover {
            background-color: black;

            color: white;

            transform: translateY(-2px);
        }


        /* =========================
           RESPONSIVIDADE
        ========================= */

        @media (max-width: 992px) {

            .titulo-site {
                font-size: 48px;
            }

            .logo {
                width: 120px;
            }

            .acoes-header {
                gap: 12px;
            }

            .icone-header {
                font-size: 25px;
            }

            .login-header i {
                font-size: 32px;
            }

        }


        @media (max-width: 768px) {

            .header-top {
                padding: 15px;
            }

            .logo-area {
                justify-content: center;
                margin-bottom: 10px;
            }

            .titulo-site {
                font-size: 42px;
                text-align: center;
            }

            .acoes-header {
                justify-content: center;
                margin-top: 10px;
            }

            .menu .nav-link {
                padding: 12px 10px;
                font-size: 14px;
            }

            .card-login {
                padding: 35px 30px 40px;
            }

            .titulo-login {
                font-size: 42px;
            }

        }


        @media (max-width: 500px) {

            .titulo-site {
                font-size: 34px;
            }

            .logo {
                width: 100px;
            }

            .menu .nav {
                flex-wrap: wrap;
            }

            .menu .nav-link {
                font-size: 12px;
                padding: 10px 8px;
            }

            .card-login {
                padding: 30px 22px 35px;
            }

            .titulo-login {
                font-size: 36px;
            }

            .icone-login {
                font-size: 45px;
            }

        }

    </style>

</head>


<body>


    <!-- =========================
         HEADER
    ========================= -->

    <header>

        <div class="header-top">

            <div class="container-fluid">

                <div class="row align-items-center">


                    <!-- LOGO -->

                    <div class="col-lg-3 col-md-3 col-12">

                        <div class="logo-area">

                            <img
                                src="logo.png"
                                alt="Logo BURNOUT"
                                class="logo"
                            >

                        </div>

                    </div>


                    <!-- TÍTULO -->

                    <div class="col-lg-6 col-md-6 col-12">

                        <h1 class="titulo-site">
                            BURNOUT
                        </h1>

                    </div>


                    <!-- AÇÕES -->

                    <div class="col-lg-3 col-md-3 col-12">

                        <div class="acoes-header">


                            <!-- PESQUISA -->

                            <a
                                href="pesquisa.php"
                                class="icone-header"
                                title="Pesquisar"
                            >

                                <i class="bi bi-search"></i>

                            </a>


                            <!-- CARRINHO -->

                            <a
                                href="carrinho.php"
                                class="icone-header"
                                title="Carrinho"
                            >

                                <i class="bi bi-cart3"></i>

                            </a>


                            <!-- LOGIN -->

                            <a
                                href="login.php"
                                class="login-header"
                            >

                                <i class="bi bi-person-circle"></i>

                                <span>
                                    entrar ou<br>
                                    cadastrar
                                </span>

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- MENU -->

        <nav class="menu">

            <ul class="nav justify-content-center">


                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="home.php"
                    >
                        HOME
                    </a>

                </li>


                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="catalogo.php"
                    >
                        CATÁLOGO
                    </a>

                </li>


                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="lancamentos.php"
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

        </nav>

    </header>



    <!-- =========================
         LOGIN
    ========================= -->

    <main class="area-login">

        <div class="card-login">


            <!-- CABEÇALHO -->

            <div class="cabecalho-login">

                <div class="icone-login">

                    <i class="bi bi-person-circle"></i>

                </div>


                <h1 class="titulo-login">
                    LOGIN
                </h1>


                <div class="linha-titulo"></div>


                <p class="subtitulo-login">
                    Entre na sua conta BURNOUT
                </p>

            </div>



            <!-- FORMULÁRIO -->

            <form action="" method="POST">


                <!-- EMAIL -->

                <div class="campo">

                    <label
                        for="email"
                        class="form-label"
                    >
                        E-mail
                    </label>

                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="form-control"
                        placeholder="Digite seu e-mail"
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
                        placeholder="Digite sua senha"
                        required
                    >

                </div>



                <!-- LOGIN -->

                <button
                    type="submit"
                    class="btn-login"
                >

                    <i class="bi bi-box-arrow-in-right"></i>

                    ENTRAR

                </button>

            </form>



            <!-- LINKS -->

            <div class="links-login">

                <span>
                    Ainda não possui uma conta?
                </span>

                <a href="cadastro.php">
                    Cadastre-se
                </a>

            </div>



            <!-- LOGOUT -->

            <div class="logout-area">

                <a
                    href="usuario/logout.php"
                    class="text-decoration-none"
                >

                    <button
                        type="button"
                        class="btn-logout"
                    >

                        <i class="bi bi-box-arrow-right"></i>

                        LOGOUT

                    </button>

                </a>

            </div>

        </div>

    </main>



    <!-- Bootstrap JS -->

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    ></script>


</body>

</html>