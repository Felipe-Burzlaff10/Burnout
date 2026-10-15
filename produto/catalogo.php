<?php
session_start();

if (!isset($_SESSION['dados']['id_usuario']))
{
    echo "<script>window.location.href='index.php';</script>";
    exit();
}

require_once "../conexao.php";

$sql = "SELECT * FROM produto";
$resultado = $conexao->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['pesquisa']))
{
    $pesquisa = "%" . $_GET['pesquisa'] . "%";

    $sql = "SELECT * FROM produto
            WHERE nome LIKE ?
            OR categoria LIKE ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('ss', $pesquisa, $pesquisa);
    $stmt->execute();

    $resultado = $stmt->get_result();

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>BURNOUT - Home</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* =========================
           CONFIGURAÇÕES GERAIS
        ========================= */

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #e9e9e9;
            color: #111;
            font-family: Arial, Helvetica, sans-serif;
        }

        a {
            -webkit-tap-highlight-color: transparent;
        }

        /* =========================
           CABEÇALHO
        ========================= */

        .header-home {
            background: #39bf00;
            padding: 12px 20px 0;
            border-bottom: 3px solid #111;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.12);
            position: relative;
            z-index: 10;
        }

        .logo {
            width: 170px;
            max-width: 100%;
            height: auto;
            object-fit: contain;
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.04);
        }

        .titulo {
            margin: 0;
            color: #080808;
            font-family: Georgia, "Times New Roman", serif;
            font-size: 70px;
            font-weight: 900;
            letter-spacing: 5px;
        }

        /* =========================
           ÍCONES E USUÁRIO
        ========================= */

        .icone-header {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #080808;
            font-size: 30px;
            text-decoration: none;
            transition: color 0.25s, transform 0.25s;
        }

        .icone-header:hover {
            color: white;
            transform: translateY(-3px);
        }

        .usuario-header {
            color: #080808;
            font-size: 16px;
            font-weight: 800;
            text-decoration: none;
            transition: color 0.25s;
        }

        .usuario-header:hover {
            color: white;
        }

        /* =========================
           MENU
        ========================= */

        .menu-principal {
            background: #39bf00;
            padding: 10px 0 14px;
        }

        .menu-principal .nav-link {
            position: relative;
            color: #080808;
            font-size: 15px;
            font-weight: 800;
            letter-spacing: 1px;
            text-decoration: none;
            margin: 0 12px;
            padding: 8px 4px;
            transition: color 0.25s;
        }

        .menu-principal .nav-link::after {
            content: "";
            position: absolute;
            left: 50%;
            bottom: 0;
            width: 0;
            height: 3px;
            background: #080808;
            transition: width 0.25s, left 0.25s;
        }

        .menu-principal .nav-link:hover::after,
        .menu-principal .nav-link.active::after {
            width: 100%;
            left: 0;
        }

        .menu-principal .nav-link:hover {
            color: white;
        }

        .menu-principal .nav-link.active {
            color: #080808;
        }

        .menu-principal .nav-link.disabled {
            color: #333;
            opacity: 0.55;
        }

        /* =========================
           CATÁLOGO
        ========================= */

        .catalogo-area {
            background: #e9e9e9;
            min-height: 100vh;
            padding: 32px;
            margin: 0 auto;
            max-width: 1600px;
        }

        .catalogo-topo {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 25px;
        }

        .catalogo-titulo {
            margin: 0;
            font-size: 28px;
            font-weight: 900;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .catalogo-titulo::after {
            content: "";
            display: block;
            width: 65px;
            height: 4px;
            margin-top: 8px;
            background: #39bf00;
            border-radius: 5px;
        }

        /* =========================
           PESQUISA
        ========================= */

        .pesquisa-container {
            width: 100%;
            margin-bottom: 28px;
        }

        .pesquisa-container form {
            display: flex;
            gap: 10px;
            width: 100%;
            max-width: 650px;
        }

        .pesquisa-container input {
            flex: 1;
            min-width: 0;
            height: 48px;
            padding: 0 20px;
            border: 2px solid #222;
            border-radius: 10px;
            background: white;
            color: #111;
            font-size: 15px;
            outline: none;
            transition: border-color 0.25s, box-shadow 0.25s;
        }

        .pesquisa-container input:focus {
            border-color: #39bf00;
            box-shadow: 0 0 0 4px rgba(57, 191, 0, 0.13);
        }

        .pesquisa-container button {
            height: 48px;
            padding: 0 24px;
            border: 2px solid #111;
            border-radius: 10px;
            background: #111;
            color: white;
            font-size: 14px;
            font-weight: 800;
            cursor: pointer;
            transition: background 0.25s, color 0.25s;
        }

        .pesquisa-container button:hover {
            background: #39bf00;
            color: #111;
        }

        /* =========================
           GRADE DE PRODUTOS
        ========================= */

        .catalogo-produtos {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 24px;
            width: 100%;
            align-items: stretch;
        }

        /* =========================
           CARD
        ========================= */

        .card-produto {
            display: flex;
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
            min-width: 0;
            padding: 14px;
            background: #fff;
            border: 1px solid #dedede;
            border-radius: 14px;
            text-align: left;
            overflow: hidden;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease,
                        box-shadow 0.3s ease,
                        border-color 0.3s ease;
        }

        .card-produto:hover {
            transform: translateY(-5px);
            border-color: #39bf00;
            box-shadow: 0 12px 26px rgba(0, 0, 0, 0.12);
        }

        /* =========================
           IMAGEM
        ========================= */

        .imagem-produto {
            display: block;
            width: 100%;
            aspect-ratio: 3 / 4;
            object-fit: cover;
            border-radius: 9px;
            background: #f0f0f0;
            transition: transform 0.3s ease;
        }

        .card-produto:hover .imagem-produto {
            transform: scale(1.02);
        }

        /* =========================
           NOME DO PRODUTO
        ========================= */

        .nome-produto {
            margin: 5px 0 0;
            color: #171717;
            font-size: 17px;
            line-height: 1.4;
            font-weight: 800;
            overflow-wrap: anywhere;
        }

        /* =========================
           PREÇO
        ========================= */

        .preco-produto {
            margin: auto 0 0;
            padding-top: 3px;
            color: #178b00;
            font-size: 22px;
            line-height: 1.3;
            font-weight: 900;
        }

        /* =========================
           SEM PRODUTOS
        ========================= */

        .sem-produtos {
            grid-column: 1 / -1;
            padding: 55px 20px;
            border: 2px dashed #aaa;
            border-radius: 14px;
            background: #f7f7f7;
            color: #444;
            text-align: center;
            font-size: 21px;
            font-weight: 800;
        }

        /* =========================
           CARROSSEL
        ========================= */

        .carousel img {
            display: block;
            width: 100%;
            height: 600px;
            object-fit: cover;
        }

        /* =========================
           TELAS GRANDES
        ========================= */

        @media (min-width: 1600px) {
            .catalogo-produtos {
                grid-template-columns: repeat(5, minmax(0, 1fr));
                gap: 26px;
            }
        }

        /* =========================
           NOTEBOOKS
        ========================= */

        @media (max-width: 1350px) {
            .catalogo-produtos {
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 20px;
            }

            .catalogo-area {
                padding: 25px;
            }

            .titulo {
                font-size: 56px;
            }

            .logo {
                width: 140px;
            }
        }

        /* =========================
           TABLETS
        ========================= */

        @media (max-width: 900px) {
            .catalogo-area {
                margin-left: 0;
                padding: 25px;
            }

            .catalogo-produtos {
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 16px;
            }

            .titulo {
                font-size: 45px;
                letter-spacing: 2px;
            }

            .logo {
                width: 115px;
            }

            .icone-header {
                font-size: 25px;
            }

            .menu-principal .nav-link {
                font-size: 13px;
                margin: 0 7px;
            }

            .carousel img {
                height: 400px;
            }
        }

        /* =========================
           CELULARES
        ========================= */

        @media (max-width: 600px) {
            .header-home {
                padding: 12px 8px 0;
            }

            .header-home .row {
                flex-wrap: nowrap;
            }

            .header-home .col-3:first-child {
                width: 22%;
            }

            .header-home .col-6 {
                width: 48%;
            }

            .header-home .col-3:last-child {
                width: 30%;
                gap: 8px !important;
            }

            .logo {
                width: 65px;
            }

            .titulo {
                font-size: 25px;
                letter-spacing: 0;
            }

            .icone-header {
                font-size: 20px;
            }

            .usuario-header {
                display: none;
            }

            .menu-principal {
                padding: 7px 2px 10px;
            }

            .menu-principal .nav {
                gap: 0;
            }

            .menu-principal .nav-link {
                font-size: 11px;
                margin: 0 4px;
                padding: 7px 3px;
                letter-spacing: 0;
            }

            .catalogo-area {
                margin-left: 0;
                padding: 22px 12px 35px;
            }

            .catalogo-topo {
                margin-bottom: 20px;
            }

            .catalogo-titulo {
                font-size: 23px;
            }

            .pesquisa-container {
                margin-bottom: 22px;
            }

            .pesquisa-container form {
                gap: 7px;
            }

            .pesquisa-container input {
                height: 43px;
                padding: 0 12px;
                font-size: 13px;
            }

            .pesquisa-container button {
                height: 43px;
                padding: 0 13px;
                font-size: 12px;
            }

            .catalogo-produtos {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 12px;
            }

            .card-produto {
                gap: 8px;
                padding: 9px;
                border-radius: 10px;
            }

            .imagem-produto {
                border-radius: 7px;
            }

            .nome-produto {
                font-size: 15px;
            }

            .preco-produto {
                font-size: 18px;
            }

            .carousel img {
                height: 280px;
            }
        }

        /* =========================
           CELULARES PEQUENOS
        ========================= */

        @media (max-width: 360px) {
            .titulo {
                font-size: 21px;
            }

            .logo {
                width: 52px;
            }

            .icone-header {
                font-size: 18px;
            }

            .catalogo-produtos {
                gap: 8px;
            }

            .card-produto {
                padding: 7px;
            }

            .nome-produto {
                font-size: 13px;
            }

            .preco-produto {
                font-size: 15px;
            }
        }
    </style>
</head>

<body>

    <!-- =========================
         CABEÇALHO
    ========================= -->

    <header class="header-home">

        <div class="container-fluid">

            <div class="row align-items-center">

                <!-- LOGO -->

                <div class="col-3">
                    <img
                        src="../img_site/logo.png"
                        alt="Logo BURNOUT"
                        class="logo">
                </div>

                <!-- TÍTULO -->

                <div class="col-6 text-center">
                    <h1 class="titulo">BURNOUT</h1>
                </div>

                <!-- ÍCONES E USUÁRIO -->

                <div class="col-3 d-flex justify-content-end align-items-center gap-3">

                    <a
                        href="pesquisa.php"
                        class="icone-header"
                        title="Pesquisar"
                        aria-label="Pesquisar">

                        <i class="bi bi-search"></i>

                    </a>

                    <a
                        href="carrinho.php"
                        class="icone-header"
                        title="Carrinho"
                        aria-label="Carrinho">

                        <i class="bi bi-cart3"></i>

                    </a>

                    <a href="perfil.php" class="usuario-header">
                        <?php echo $_SESSION['dados']['nome']; ?>
                    </a>

                </div>

            </div>

        </div>

        <!-- MENU -->

        <nav class="menu-principal">

            <ul class="nav justify-content-center">

                <li class="nav-item">
                    <a class="nav-link active" href="index.php">
                        HOME
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="produto/catalogo.php">
                        CATÁLOGO
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="lancamentos.php">
                        LANÇAMENTOS
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link disabled"
                        aria-disabled="true"
                        tabindex="-1">
                        PINTO
                    </a>
                </li>

            </ul>

        </nav>

    </header>

    <!-- =========================
         ÁREA PRINCIPAL
    ========================= -->

    <main class="catalogo-area">

        <!-- TÍTULO DO CATÁLOGO -->

        <div class="catalogo-topo">

            <h2 class="catalogo-titulo">
                Nossos produtos
            </h2>

        </div>

        <!-- PESQUISA -->

        <div class="pesquisa-container">

            <form method="GET">

                <input
                    type="text"
                    name="pesquisa"
                    placeholder="Pesquisar produto..."
                    value="<?php echo htmlspecialchars($_GET['pesquisa'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">

                <button type="submit">
                    <i class="bi bi-search"></i>
                    Pesquisar
                </button>

            </form>

        </div>

        <!-- PRODUTOS -->

        <section class="catalogo">

            <?php

            if ($resultado->num_rows > 0)
            {
                echo "<div class='catalogo-produtos'>";

                while ($produto = $resultado->fetch_assoc())
                {
                    echo "<div class='card-produto'>";

                    echo "<img
                            class='imagem-produto'
                            src='../img_produto/" . htmlspecialchars($produto['foto'], ENT_QUOTES, 'UTF-8') . "'
                            alt='" . htmlspecialchars($produto['nome'], ENT_QUOTES, 'UTF-8') . "'
                          >";

                    echo "<p class='nome-produto'>"
                            . htmlspecialchars($produto['nome'], ENT_QUOTES, 'UTF-8') .
                         "</p>";

                    echo "<p class='preco-produto'>R$ "
                            . number_format($produto['preco'], 2, ',', '.') .
                         "</p>";

                    echo "</div>";
                }

                echo "</div>";
            }
            else
            {
                echo '<h2 class="sem-produtos">
                        Nenhum produto encontrado.
                      </h2>';
            }

            ?>

        </section>

    </main>

    <!-- =========================
         RODAPÉ / SCRIPTS
    ========================= -->

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
    </script>

</body>

</html>

<?php
$conexao->close();
?>
