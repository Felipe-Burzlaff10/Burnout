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

    <header class="header-home">
        <div class="container-fluid">
            <div class="row align-items-center">

                <div class="col-3 d-flex align-items-center gap-2">
                    <?php
                    if (!empty($_SESSION['dados']['root'])) {
                        echo "<button
                            class='botao-menu'
                            id='abrirSidebar'
                            type='button'
                            aria-label='Abrir menu lateral'
                            aria-controls='sidebar'
                            aria-expanded='false'>
                                <i class='bi bi-list'></i>
                            </button>";
                    }
                    ?>

                    <img src="img_site/logo.png" alt="Logo BURNOUT" class="logo">
                </div>

                <div class="col-6 text-center">
                    <h1 class="titulo">BURNOUT</h1>
                </div>

                <div class="col-3 d-flex justify-content-end align-items-center gap-3">
                    <a href="produto/carrinho.php" class="icone-header" title="Carrinho">
                        <i class="bi bi-cart3"></i>
                    </a>

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

        <ul class="nav justify-content-center">
            <li class="nav-item">
                <a class="nav-link" href="index.php">HOME</a>
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

    <?php if (!empty($_SESSION['dados']['root'])): ?>
        <div class="fundo-sidebar" id="fundoSidebar"></div>

        <aside class="sidebar" id="sidebar" aria-label="Menu lateral">
            <div class="sidebar-topo">
                <h2>BURNOUT</h2>
                <button class="fechar-sidebar" id="fecharSidebar" type="button" aria-label="Fechar menu">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <a href="usuario/listar.php"><i class="bi bi-person-circle"></i> Listar Usuarios</a>
            <a href="produto/alterar.php"><i class="bi bi-pencil-square"></i> Alterar Produtos</a>
            <a href="usuario/cadastro.php"><i class="bi bi-person-add"></i> Cadastrar Usuário</a>
            <a href="produto/cadastro.php"><i class="bi bi-file-earmark-plus"></i> Cadastrar Produto</a>

            <hr class="separador">
        </aside>
    <?php endif; ?>

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
                            Insira aqui o texto da sua história. Descreva como a marca começou,
                            os objetivos iniciais, os desafios enfrentados e a evolução do projeto até hoje.
                        </p>
                        <p>
                            Este espaço pode ser preenchido com a trajetória da empresa, a inspiração da ideia
                            e o crescimento ao longo do tempo.
                        </p>
                    </article>

                    <article class="sobre-card">
                        <h3>Sobre Nós</h3>
                        <p>
                            Insira aqui o texto sobre a equipe, a missão, a visão e os valores da marca.
                            Explique o que você deseja transmitir ao cliente e o que torna a BURNOUT especial.
                        </p>
                        <p>
                            Você pode escrever sobre qualidade, compromisso, estilo e relacionamento com a comunidade.
                        </p>
                    </article>
                </div>
            </div>
        </section>
    </main>

    <script src="usuario_menu.js"></script>
    <script>
        usuario_menu_suspenso();

        <?php if (!empty($_SESSION['dados']['root'])): ?>
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
        <?php endif; ?>
    </script>
</body>
</html>
