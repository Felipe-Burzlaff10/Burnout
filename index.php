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

   <link rel="stylesheet" href="CSS/header.css">
   <link rel="stylesheet" href="CSS/index.css">
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

        <a href="usuario/perfil.php">
            <i class="bi bi-person"></i>
            Minha conta
        </a>

        <a href="usuario/historico_compras.php">
            <i class="bi bi-clock-history"></i>
            Histórico de compras
        </a>

        <a href="usuario/alterar.php">
            <i class="bi bi-gear"></i>
            Alterar meus dados
        </a>

         <a href="usuario/alterar_senha.php">
            <i class="bi bi-lock"></i>
            Alterar Senha
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
                <a class="nav-link active" href="index.php">HOME</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="produto/catalogo.php">CATALOGO</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="produto/lancamentos.php">LANÇAMENTOS</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="sobre_nos.php">SOBRE NÓS</a>
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
