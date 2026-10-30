<?php
session_start();

if (!isset($_SESSION['dados']['id_usuario']))
{
    echo "<script>window.location.href='usuario/login.php';</script>";
    exit();
}
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
   USUÁRIO E MENU SUSPENSO
========================= */

.usuario-menu {
    position: relative;
}

.usuario-header {
    background-color: #111;
    color: white;
    font-weight: bold;
    font-size: 16px;
    text-decoration: none;

    border: 1px solid #292929;
    border-radius: 8px 8px 0 0;

    padding: 10px 14px;
    cursor: pointer;
    white-space: nowrap;

    transition: 0.2s;
}

.usuario-header:hover {
    background-color: #222;
    color: #39bf00;
}

#usuarioBtn
{
    color: white;
}

.usuario-dropdown {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    right: auto;
    width: 100%;

    background-color: #111;
    border: 1px solid #292929;
    border-top: none;

    border-radius: 0 0 8px 8px;

    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3);
    z-index: 2000;
    overflow: hidden;
    box-sizing: border-box;
}

.usuario-dropdown.aberto {
    display: block;
}

.usuario-dropdown a {
    display: flex;
    align-items: center;
    gap: 10px;

    padding: 13px 16px;

    color: #f2f2f2;
    text-decoration: none;
    font-size: 14px;
    font-weight: normal;

    transition: background-color 0.2s, color 0.2s;
}

.usuario-dropdown a:hover {
    background-color: #39bf00;
    color: #000;
}

.usuario-dropdown .sair {
    color: #ff5555;
}

.usuario-dropdown .sair:hover {
    background-color: #39bf00;
    color: #000;
}

.usuario-dropdown hr {
    margin: 0;
    border: 0;
    border-top: 1px solid #333;
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
            width: 100%;
            height: 80vh;
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

        /* FUNDO DA SIDEBAR */
        .fundo-sidebar {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s;
            z-index: 1040;
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
            
        }
    </style>
</head>

<body>

<!-- JAVASCRIPT -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

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


                    <a href="produto/carrinho.php"
                        class="icone-header"
                        title="Carrinho">

                        <i class="bi bi-cart3"></i>

                    </a>

                

                   
<!-- USUÁRIO E MENU SUSPENSO -->
<div class="usuario-menu">

    <button
        type="button"
        class="usuario-header"
        id="usuarioBtn"
        aria-expanded="false"
        aria-controls="usuarioDropdown">

        <?php echo htmlspecialchars($_SESSION['dados']['nome']); ?>
        <i class="bi bi-chevron-down"></i>

    </button>

    <div class="usuario-dropdown" id="usuarioDropdown">

        <a href="perfil.php">
            <i class="bi bi-person"></i>
            Minha conta
        </a>

        <a href="historico.php">
            <i class="bi bi-clock-history"></i>
            Histórico de compras
        </a>

        <a href="usuario/alterar.php">
            <i class="bi bi-gear"></i>
            Alterar meus dados
        </a>

        <hr>

        <a href="usuario/logout.php" class="sair">
            <i class="bi bi-box-arrow-right"></i>
            Sair da conta
        </a>

    </div>

</div>


                </div>

            </div>

        </div>

        <!-- MENU PRINCIPAL -->
        <ul class="nav justify-content-center">

            <li class="nav-item">
                <a class="nav-link active" href="home.php">HOME</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="produto/catalogo.php">CATALOGO</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="produto/lancamentos.php">LANÇAMENTOS</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" >SOBRE NÓS</a>
            </li>

        </ul>

    </header>

    <!-- FUNDO ESCURO -->
    <div class="fundo-sidebar" id="fundoSidebar"></div>

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

        <a href="produto/listar.php">
            <i class="bi bi-pencil-square"></i> Listar Produtos
        </a>

         <a href="usuario/cadastro.php">
            <i class="bi bi-person-add"></i> Cadastrar Usuário
        </a>

         <a href="produto/cadastro.php">
            <i class="bi bi-file-earmark-plus"></i> Cadastrar Produto
        </a>

        <hr class="separador">

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




    <script>
        const sidebar = document.getElementById("sidebar");
        const fundoSidebar = document.getElementById("fundoSidebar");
        const abrirSidebar = document.getElementById("abrirSidebar");
        const fecharSidebar = document.getElementById("fecharSidebar");

        function abrirMenu() {
            sidebar.classList.add("aberto");
            fundoSidebar.classList.add("aberto");

            abrirSidebar.setAttribute("aria-expanded", "true");
            document.body.style.overflow = "hidden";
        }

        function fecharMenu() {
            sidebar.classList.remove("aberto");
            fundoSidebar.classList.remove("aberto");

            abrirSidebar.setAttribute("aria-expanded", "false");
            document.body.style.overflow = "";
        }

        abrirSidebar.addEventListener("click", abrirMenu);
        fecharSidebar.addEventListener("click", fecharMenu);
        fundoSidebar.addEventListener("click", fecharMenu);

        document.addEventListener("keydown", function(event) {
            if (event.key === "Escape") {
                fecharMenu();
            }
        });
    </script>

</body>

<?php
 echo "<script src='usuario_menu.js'></script>";
  echo "<script>usuario_menu_suspenso();</script>";
?>

</html>
