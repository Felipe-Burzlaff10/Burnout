<?php
session_start();

if (!isset($_SESSION['dados']['id_usuario']))
    echo "<script>window.location.href='usuario/login.php';</script>";

$isRoot = !empty($_SESSION['dados']['root']);
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
        /* MENU PRINCIPAL */
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

        /* HEADER */
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

        /* BOTÃO DA SIDEBAR */
        .botao-menu {
            background: black;
            color: #39bf00;
            border: 2px solid black;
            border-radius: 8px;
            padding: 5px 12px;
            font-size: 27px;
            cursor: pointer;
            transition: 0.2s;
            line-height: 1.2;
        }

        .botao-menu:hover {
            background: white;
            color: black;
        }

        /* ÍCONES DO HEADER */
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

        /* USUÁRIO */
        .usuario-header {
            color: black;
            font-weight: bold;
            font-size: 18px;
            text-decoration: none;
        }

        .usuario-header:hover {
            color: white;
        }

        /* CAROUSEL */
        .carousel img {
            display: block;
            width: 100%;
            height: clamp(300px, 55vw, 700px);
            object-fit: cover;
        }

        /* LOGOUT */
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

        .admin-shortcut {
            position: fixed;
            right: 20px;
            bottom: 82px;
            z-index: 1000;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 16px;
            border: 2px solid #111;
            border-radius: 10px;
            background: #fff;
            color: #111;
            font-weight: 800;
            text-decoration: none;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
            transition: background-color 0.2s, transform 0.2s;
        }

        .admin-shortcut:hover {
            background: #39bf00;
            color: #111;
            transform: translateY(-2px);
        }

        .account-settings {
            display: block;
            width: fit-content;
            margin: 18px auto;
            padding: 10px 16px;
            border: 2px solid #111;
            border-radius: 10px;
            background: #fff;
            color: #111;
            font-weight: 800;
            text-decoration: none;
            transition: background-color 0.2s, transform 0.2s;
        }

        .account-settings:hover {
            background: #39bf00;
            color: #111;
            transform: translateY(-1px);
        }


        .fundo-sidebar.aberto {
            opacity: 1;
            visibility: visible;
        }

        /* BARRA LATERAL */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 290px;
            max-width: 85vw;
            height: 100vh;
            background: #111;
            color: white;
            padding: 25px 20px;
            z-index: 1050;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            overflow-y: auto;
            box-shadow: 5px 0 20px rgba(0, 0, 0, 0.4);
        }

        .sidebar.aberto {
            transform: translateX(0);
        }

        .sidebar-topo {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #39bf00;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .sidebar-topo h2 {
            color: #39bf00;
            font-family: Georgia, 'Times New Roman', serif;
            font-weight: bold;
            font-size: 27px;
            margin: 0;
        }

        .fechar-sidebar {
            background: none;
            color: white;
            border: none;
            font-size: 26px;
            cursor: pointer;
        }

        .fechar-sidebar:hover {
            color: #39bf00;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            font-size: 17px;
            font-weight: bold;
            padding: 14px 12px;
            margin-bottom: 5px;
            border-radius: 7px;
            transition: 0.2s;
        }

        .sidebar a i {
            margin-right: 10px;
            font-size: 20px;
        }

        .sidebar a:hover {
            background: #39bf00;
            color: black;
        }

        .sidebar .separador {
            border: 0;
            border-top: 1px solid #444;
            margin: 15px 0;
        }

        /* RESPONSIVO */
        @media (max-width: 600px) {
            .header-home {
                padding: 10px 8px 0;
            }

            .logo {
                width: 75px;
            }

            .titulo {
                font-size: 30px;
            }

            .botao-menu {
                font-size: 21px;
                padding: 4px 8px;
            }

            .icone-header {
                font-size: 21px;
            }

            .usuario-header {
                display: none;
            }

            .nav-link {
                font-size: 13px;
                margin: 0 4px;
            }

            .carousel img {
                height: 450px;
            }

            .admin-shortcut {
                right: 12px;
                bottom: 76px;
                padding: 9px 12px;
                font-size: 13px;
            }

            .logout {
                right: 12px;
                bottom: 12px;
                padding: 9px 14px;
            }
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <header class="header-home">

        <div class="container-fluid">

            <div class="row align-items-center">

                <!-- BOTÃO DA BARRA LATERAL + LOGO -->
                <div class="col-3 d-flex align-items-center gap-2">

                    <?php 
                        if ($_SESSION['dados']['root'])
                            echo "<button
                                  class='botao-menu'
                                  id='abrirSidebar'
                                  type='button'
                                  aria-label='Abrir menu lateral'
                                  aria-controls='sidebar'
                                  aria-expanded='false'>

                                    <i class='bi bi-list'></i>

                                  </button>";
                    ?>

                    <img
                        src="img_site/logo.png"
                        alt="Logo BURNOUT"
                        class="logo">

                </div>

                <!-- TÍTULO -->
                <div class="col-6 text-center">

                    <h1 class="titulo">BURNOUT</h1>

                </div>

                <!-- ÍCONES -->
                <div class="col-3 d-flex justify-content-end align-items-center gap-3">

                    <a href="pesquisa.php"
                        class="icone-header"
                        title="Pesquisar">

                        <i class="bi bi-search"></i>

                    </a>

                    <a href="carrinho.php"
                        class="icone-header"
                        title="Carrinho">

                        <i class="bi bi-cart3"></i>

                    </a>

                    <a href="perfil.php" class="usuario-header">

                        <?php echo $_SESSION['dados']['nome']; ?>

                    </a>

                </div>

            </div>

        </div>

        <!-- MENU PRINCIPAL -->
        <ul class="nav justify-content-center">

            <li class="nav-item">
                <a class="nav-link active" href="index.php">HOME</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="produto/catalogo.php">CATALOGO</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="lancamentos.php">LANÇAMENTOS</a>
            </li>

            <li class="nav-item">
                <a class="nav-link disabled" aria-disabled="true">PINTO</a>
            </li>

        </ul>

    </header>

    <?php if ($isRoot): ?>
        <a class="admin-shortcut" href="usuario/listar.php">
            <i class="bi bi-people-fill"></i>
            Gerenciar usuários
        </a>
    <?php endif; ?>


    <!-- BARRA LATERAL -->
    <aside class="sidebar" id="sidebar" aria-label="Menu lateral">

        <div class="sidebar-topo">

            <h2>BURNOUT</h2>

            <button
                class="fechar-sidebar"
                id="fecharSidebar"
                type="button"
                aria-label="Fechar menu">

                <i class="bi bi-x-lg"></i>

            </button>

        </div>

        <a href="usuario/listar.php">
            <i class="bi bi-person-circle"></i> Listar Usuarios
        </a>

        <a href="usuario/alterar.php">
            <i class="bi bi-pencil-square"></i> Alterar Produtos
        </a>

        <hr class="separador">

        <a href="usuario/logout.php">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>

    </aside>

    <!-- CAROUSEL -->
    <div id="carouselExample" class="carousel slide">

        <div class="carousel-inner">

            <div class="carousel-item active">
                <img
                    src="img_site/imagemPromocional.png"
                    class="d-block w-100"
                    alt="Promoção BURNOUT">
            </div>

            <div class="carousel-item">
                <img
                    src="img_site/imagemLançamento.png"
                    class="d-block w-100"
                    alt="Lançamento BURNOUT">
            </div>

            <div class="carousel-item">
                <img
                    src="img_site/imagemPatrocinio.png"
                    class="d-block w-100"
                    alt="Patrocínio BURNOUT">
            </div>

        </div>

        <!-- BOTÃO ANTERIOR -->
        <button
            class="carousel-control-prev"
            type="button"
            data-bs-target="#carouselExample"
            data-bs-slide="prev">

            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>

        </button>

        <!-- BOTÃO PRÓXIMO -->
        <button
            class="carousel-control-next"
            type="button"
            data-bs-target="#carouselExample"
            data-bs-slide="next">

            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Próximo</span>

        </button>
    </div>

</body>
</html>
