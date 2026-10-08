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

    <title>BURNOUT - Home</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

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
           HEADER
        ========================= */

        .header-home {
            background-color: #39bf00;
            padding: 10px 20px 0;
            border-bottom: 2px solid black;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
        }

        .logo {
            width: 170px;
        }

        .titulo {
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 70px;
            font-weight: bold;
            margin: 0;
            color: black;
        }


        /* =========================
           ÍCONES
        ========================= */

        .icone-header {
            color: black;
            font-size: 32px;
            text-decoration: none;
            transition: 0.2s;
        }

        .icone-header:hover {
            color: white;
            transform: scale(1.1);
        }


        /* =========================
           USUÁRIO
        ========================= */

        .usuario-header {
            color: black;
            font-weight: bold;
            font-size: 18px;
            text-decoration: none;
        }

        .usuario-header:hover {
            color: white;
        }


        /* =========================
           CAROUSEL
        ========================= */

        .carousel img {
            width: 100%;
            height: 750px;
            object-fit: cover;
        }


        /* =========================
           BOTÃO LOGOUT
        ========================= */

        .logout {
            position: fixed;
            right: 20px;
            bottom: 20px;

            background-color: black;
            color: white;

            border: none;
            border-radius: 10px;

            padding: 10px 18px;

            font-weight: bold;
            text-decoration: none;

            z-index: 1000;

            transition: 0.2s;
        }

        .logout:hover {
            background-color: #39bf00;
            color: black;
            transform: scale(1.05);
        }


        /* =========================
           RESPONSIVO
        ========================= */

        @media (max-width: 900px) {

            .titulo {
                font-size: 50px;
            }

            .logo {
                width: 130px;
            }

            .icone-header {
                font-size: 26px;
            }

            .usuario-header {
                font-size: 15px;
            }

            .carousel img {
                height: 600px;
            }
        }


        @media (max-width: 600px) {

            .header-home {
                padding: 10px;
            }

            .logo {
                width: 100px;
            }

            .titulo {
                font-size: 32px;
            }

            .icone-header {
                font-size: 22px;
            }

            .usuario-header {
                display: none;
            }

            .nav-link {
                font-size: 14px;
                margin: 0 5px;
            }

            .carousel img {
                height: 450px;
            }
        }

    </style>

</head>


<body>


    <!-- =========================
         HEADER
    ========================= -->

    <header class="header-home">

        <div class="container-fluid">

            <div class="row align-items-center">

                <!-- LOGO -->
                <div class="col-3">

                    <img
                        src="img_site/logo.png"
                        alt="Logo BURNOUT"
                        class="logo">

                </div>


                <!-- TÍTULO -->
                <div class="col-6 text-center">

                    <h1 class="titulo">
                        BURNOUT
                    </h1>

                </div>


                <!-- ÍCONES -->
                <div class="col-3 d-flex justify-content-end align-items-center gap-3">


                    <!-- PESQUISA -->
                    <a
                        href="pesquisa.php"
                        class="icone-header"
                        title="Pesquisar">

                        <i class="bi bi-search"></i>

                    </a>


                    <!-- CARRINHO -->
                    <a
                        href="carrinho.php"
                        class="icone-header"
                        title="Carrinho">

                        <i class="bi bi-cart3"></i>

                    </a>


                    <!-- USUÁRIO -->
                    <a
                        href="perfil.php"
                        class="usuario-header">

                        <?php echo $_SESSION['nome']; ?>

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
                    class="nav-link active"
                    href="home.php">

                    HOME

                </a>

            </li>


            <li class="nav-item">

                <a
                    class="nav-link"
                    href="produto/catalogo.php">

                    CATALOGO

                </a>

            </li>


            <li class="nav-item">

                <a
                    class="nav-link"
                    href="lancamentos.php">

                    LANÇAMENTOS

                </a>

            </li>


            <li class="nav-item">

                <a
                    class="nav-link disabled"
                    aria-disabled="true">

                    PINTO

                </a>

            </li>

        </ul>

    </header>



    <!-- =========================
         CAROUSEL
    ========================= -->

    <div
        id="carouselExample"
        class="carousel slide">

        <div class="carousel-inner">


            <!-- IMAGEM 1 -->

            <div class="carousel-item active">

                <img
                    src="img_site/imagemPromocional.png"
                    class="d-block w-100"
                    alt="Promoção BURNOUT">

            </div>


            <!-- IMAGEM 2 -->

            <div class="carousel-item">

                <img
                    src="img_site/imagemLançamento.png"
                    class="d-block w-100"
                    alt="Lançamento BURNOUT">

            </div>

        </div>


        <!-- BOTÃO PRÓXIMO -->

        <button
            class="carousel-control-next"
            type="button"
            data-bs-target="#carouselExample"
            data-bs-slide="next">

            <span
                class="carousel-control-next-icon"
                aria-hidden="true">
            </span>

            <span class="visually-hidden">
                Próximo
            </span>

        </button>

    </div>



    <!-- =========================
         LINK DE ALTERAÇÃO
    ========================= -->

    <a
        href="usuario/alterar.php"
        style="
            display: block;
            text-align: center;
            margin: 20px;
            color: black;
            font-weight: bold;
            text-decoration: none;
        ">

        PCD

    </a>



    <!-- =========================
         LOGOUT
    ========================= -->

    <a
        href="usuario/logout.php"
        class="logout">

        <i class="bi bi-box-arrow-right"></i>

        Logout

    </a>



    <!-- Bootstrap JS -->

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous">
    </script>


</body>

</html>