<?php
session_start();

if (!isset($_SESSION['dados']['id_usuario'])) {
    echo "<script>window.location.href='usuario/login.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>BURNOUT - Sobre nós</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="CSS/sobre_nos.css">
</head>

<body>
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
                <a class="nav-link" href="home.php">HOME</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="produto/catalogo.php">CATALOGO</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="produto/lancamentos.php">LANÇAMENTOS</a>
            </li>

            <li class="nav-item">
                <a class="nav-link active" href="sobre_nos.php">SOBRE NÓS</a>
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

        <a href="produto/alterar.php">
            <i class="bi bi-pencil-square"></i> Alterar Produtos
        </a>

        <a href="usuario/cadastro.php">
            <i class="bi bi-person-add"></i> Cadastrar Usuário
        </a>

        <a href="produto/cadastro.php">
            <i class="bi bi-file-earmark-plus"></i> Cadastrar Produto
        </a>

        <hr class="separador">

    </aside>

    <main class="sobre-main">
        <section class="sobre-banner">
            <div class="container">
                <div class="banner-text">
                    <span class="tag">Quem somos</span>
                    <h2>Sobre a BURNOUT</h2>
                </div>
            </div>
        </section>

        <section class="sobre-conteudo">
            <div class="container">
                <div class="sobre-grid">
                    <article class="sobre-card">
                        <h3>Nossa História</h3>
                        <p>
                            A Burnout surgiu como parte de um projeto escolar desenvolvido em equipe, com a proposta de criar um site para uma loja de roupas fictícia. A ideia nasceu da vontade de explorar o universo da moda streetwear, unindo atitude, autenticidade e criatividade em uma marca com identidade visual própria. A partir desse conceito, começamos a transformar nossas ideias em um projeto digital, planejando como seria a experiência de quem visitasse nossa loja.
Durante o desenvolvimento, trabalhamos na criação da identidade da Burnout, desde o estilo das peças e as estampas até as cores, o logotipo e a aparência do site. Inspirados pela estética streetwear, escolhemos elementos marcantes, com predominância do preto e detalhes em verde, para transmitir a personalidade da marca. Cada etapa foi uma oportunidade de colocar em prática nossos conhecimentos, compartilhar ideias e transformar conceitos em algo concreto.
O resultado foi a criação de um site que representa nossa visão de uma loja de roupas moderna, com personalidade e estilo próprio. Mais do que desenvolver uma página na internet, buscamos construir uma experiência visual coerente com a proposta da Burnout, aplicando os conhecimentos adquiridos durante o projeto escolar e enfrentando, em equipe, os desafios de planejar e desenvolver um site do início ao fim.
                        </p>
                    </article>

                    <article class="sobre-card">
                        <h3>Sobre Nós</h3>
                        <p>
                            Acreditamos que estilo não é sobre criar tendências, é sobre criar presença. Cada peça é pensada na atitude no contraste e detalhes marcantes que fazem toda a diferença pra quem te enxerga na rua, transformando o básico em algo memorável. 
Burnout nasceu não apenas para ser uma loja de roupas, mas sim para criar identidade, atitude e personalidade para quem não foi feito para passar despercebido. Criamos coleções únicas que entregam não só uma estampa, mas sim conforto e caráter em um único visual.
Vista Burnout, vista indentidade.
                        </p>
                    </article>
                </div>
            </div>
        </section>
    </main>

    <script src="usuario_menu.js"></script>
    <script>
        usuario_menu_suspenso();

        const sidebar = document.getElementById("sidebar");
        const fundoSidebar = document.getElementById("fundoSidebar");
        const abrirSidebar = document.getElementById("abrirSidebar");
        const fecharSidebar = document.getElementById("fecharSidebar");

        if (sidebar && fundoSidebar && abrirSidebar && fecharSidebar) {
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
        }
    </script>
</body>
</html>
