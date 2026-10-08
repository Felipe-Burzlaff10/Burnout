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

        .header-auth {
            width: 100%;
            height: 100px;

            background-color: #39bf00;

            border-bottom: 2px solid black;

            display: flex;
            align-items: center;

            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
        }


        .header-auth-conteudo {
            width: 100%;

            display: grid;
            grid-template-columns: 1fr 1fr 1fr;

            align-items: center;

            padding: 0 35px;
        }


        /* LOGO */

        .logo-link {
            display: flex;
            align-items: center;

            width: fit-content;

            text-decoration: none;
        }


        .logo-auth {
            width: 115px;

            display: block;
        }


        /* NOME BURNOUT */

        .marca-auth {
            text-align: center;

            font-family: Georgia, 'Times New Roman', serif;

            font-size: 48px;

            font-weight: bold;

            letter-spacing: 2px;

            color: black;
        }


        /* LADO DIREITO */

        .header-auth-direita {
            min-height: 1px;
        }


        /* =========================
           ÁREA DO LOGIN
        ========================= */

        .area-login {
            min-height: calc(100vh - 100px);

            display: flex;
            justify-content: center;
            align-items: center;

            padding: 40px 20px;
        }


        /* =========================
           CARD
        ========================= */

        .card-login {
            width: 520px;
            max-width: 100%;

            background-color: #39bf00;

            padding: 40px 60px 35px;

            border-radius: 22px;

            border: 2px solid rgba(0, 0, 0, 0.15);

            box-shadow:
                0 15px 35px rgba(0, 0, 0, 0.22);
        }


        /* =========================
           TÍTULO
        ========================= */

        .cabecalho-login {
            text-align: center;

            margin-bottom: 35px;
        }


        .icone-login {
            font-size: 48px;

            margin-bottom: 8px;
        }


        .titulo-login {
            font-family: Arial, sans-serif;

            font-size: 48px;

            font-weight: 900;

            margin: 0;

            letter-spacing: 1px;
        }


        .linha-titulo {
            width: 65px;
            height: 5px;

            background-color: black;

            margin: 13px auto;

            border-radius: 10px;
        }


        .subtitulo-login {
            font-family: Arial, sans-serif;

            font-size: 15px;

            font-weight: bold;

            opacity: 0.7;

            margin: 0;
        }


        /* =========================
           CAMPOS
        ========================= */

        .campo {
            margin-bottom: 23px;
        }


        .form-label {
            display: block;

            font-family: Arial, sans-serif;

            font-size: 18px;

            font-weight: bold;

            margin-bottom: 7px;
        }


        .form-control {
            width: 100%;

            height: 52px;

            background-color: rgba(255, 255, 255, 0.4);

            border: 2px solid transparent;

            border-radius: 10px;

            font-family: Arial, sans-serif;

            font-size: 17px;

            padding: 10px 15px;

            color: black;

            box-shadow: none !important;

            transition: 0.2s;
        }


        .form-control:hover {
            background-color: rgba(255, 255, 255, 0.6);
        }


        .form-control:focus {
            background-color: white;

            border-color: black;

            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.10) !important;
        }


        /* =========================
           BOTÃO ENTRAR
        ========================= */

        .btn-login {
            width: 100%;

            height: 60px;

            margin-top: 15px;

            background-color: black;

            color: white;

            border: none;

            border-radius: 12px;

            font-family: Arial, sans-serif;

            font-size: 18px;

            font-weight: 900;

            letter-spacing: 1px;

            transition: 0.2s;
        }


        .btn-login:hover {
            background-color: #222;

            color: white;

            transform: translateY(-2px);

            box-shadow: 0 7px 15px rgba(0, 0, 0, 0.25);
        }


        .btn-login i {
            margin-right: 8px;
        }


        /* =========================
           LINK PARA CADASTRO
        ========================= */

        .link-auth {
            text-align: center;

            margin-top: 23px;

            font-family: Arial, sans-serif;

            font-size: 15px;
        }


        .link-auth a {
            color: black;

            font-weight: bold;

            text-decoration: none;

            margin-left: 5px;
        }


        .link-auth a:hover {
            text-decoration: underline;
        }


        /* =========================
           RESPONSIVO
        ========================= */

        @media (max-width: 600px) {

            .header-auth {
                height: 80px;
            }


            .header-auth-conteudo {
                padding: 0 20px;
            }


            .logo-auth {
                width: 85px;
            }


            .marca-auth {
                font-size: 30px;
            }


            .area-login {
                min-height: calc(100vh - 80px);

                padding: 30px 15px;
            }


            .card-login {
                padding: 30px 25px;
            }


            .titulo-login {
                font-size: 38px;
            }

        }

    </style>

</head>


<body>


    <!-- =========================
         HEADER
    ========================= -->

    <header class="header-auth">

        <div class="header-auth-conteudo">


            <!-- LOGO -->

            <a
                href="login.php"
                class="logo-link"
            >

                <img
                    src="../img_site/logo.png"
                    alt="Logo BURNOUT"
                    class="logo-auth"
                >

            </a>


            <!-- BURNOUT -->

            <div class="marca-auth">
                BURNOUT
            </div>


            <!-- ESPAÇO -->

            <div class="header-auth-direita"></div>

        </div>

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



                <!-- BOTÃO -->

                <button
                    type="submit"
                    class="btn-login"
                >

                    <i class="bi bi-box-arrow-in-right"></i>

                    ENTRAR

                </button>

            </form>



            <!-- CADASTRO -->

            <div class="link-auth">

                <span>
                    Ainda não possui uma conta?
                </span>

                <a href="cadastro.php">
                    Cadastre-se
                </a>

            </div>

        </div>

    </main>


</body>

</html>

