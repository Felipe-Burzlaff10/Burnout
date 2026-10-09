<?php
session_start();

if (!isset($_SESSION['id_usuario']))
{
    echo "<script>window.location.href='index.php';</script>";
    exit();
}


require_once "../conexao.php";

$sql = "SELECT * FROM produto";
$resultado = $conexao->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['pesquisa'])) {

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



<style>
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
    height: auto;
    object-fit: contain;
}

.titulo {
    font-family: Georgia, "Times New Roman", serif;
    font-size: 70px;
    font-weight: bold;
    margin: 0;
    color: black;
}

/* ÍCONES DO HEADER */

.icone-header {
    color: black;
    font-size: 32px;
    text-decoration: none;
    transition: 0.2s ease;
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
    transition: 0.2s ease;
}

.usuario-header:hover {
    color: white;
}

/* =========================
   MENU DE NAVEGAÇÃO
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
    text-decoration: none;
    margin: 0 15px;
    transition: 0.2s ease;
}

.nav-link:hover {
    color: white;
}

.nav-link.active {
    color: black;
    border-bottom: 2px solid black;
}

.nav-link.disabled {
    color: #333;
    opacity: 0.6;
}

/* =========================
   ÁREA DO CATÁLOGO BURNOUT
========================= */

.catalogo-area {
    background: #d3d3d3;
    min-height: 100vh;
    padding: 18px 22px 40px;
    margin-left: 255px;
    box-sizing: border-box;
}

/* =========================
   PESQUISA
========================= */

.pesquisa-container {
    width: 100%;
    margin-bottom: 18px;
}

.pesquisa-container form {
    display: flex;
    gap: 8px;
    max-width: 600px;
}

.pesquisa-container input {
    flex: 1;
    min-width: 0;
    height: 40px;
    border: 2px solid #000;
    border-radius: 20px;
    padding: 0 18px;
    font-family: Arial, sans-serif;
    font-size: 15px;
    outline: none;
    box-sizing: border-box;
}

.pesquisa-container input:focus {
    border-color: #27d000;
}

.pesquisa-container button {
    height: 40px;
    padding: 0 22px;
    border: 2px solid #000;
    border-radius: 20px;
    background: #000;
    color: white;
    font-weight: bold;
    cursor: pointer;
    transition: 0.2s ease;
}

.pesquisa-container button:hover {
    background: #27d000;
    color: #000;
}

/* =========================
   GRID DOS PRODUTOS
========================= */

.catalogo {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 38px 48px;
    width: 100%;
}

/* =========================
   CARD DO PRODUTO
========================= */

.produto-card {
    background: transparent;
    min-width: 0;
    font-family: Arial, Helvetica, sans-serif;
}

/* IMAGEM DO PRODUTO */

.produto-imagem {
    width: 100%;
    aspect-ratio: 1.35 / 1;
    object-fit: cover;
    display: block;
    border: 4px solid #000;
    border-radius: 28px;
    background: #aaa;
    transition: transform 0.25s ease;
    box-sizing: border-box;
}

.produto-card:hover .produto-imagem {
    transform: scale(1.02);
}

/* INFORMAÇÕES DO PRODUTO */

.produto-info {
    padding: 9px 5px 0;
}

.produto-nome {
    margin: 0;
    font-size: 19px;
    font-weight: bold;
    color: #000;
}

.produto-categoria {
    margin-top: 3px;
    font-size: 14px;
    color: #444;
}

.produto-preco {
    margin-top: 5px;
    font-size: 18px;
    font-weight: bold;
    color: #000;
}

/* NENHUM PRODUTO ENCONTRADO */

.sem-produtos {
    grid-column: 1 / -1;
    text-align: center;
    font-family: Arial, sans-serif;
    font-size: 20px;
    font-weight: bold;
    padding: 50px;
}

/* =========================
   CARROSSEL
========================= */

.carousel img {
    height: 600px;
    object-fit: cover;
}

/* =========================
   RESPONSIVIDADE - TABLETS
========================= */

@media (max-width: 1000px) {
    .catalogo {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 30px;
    }
}

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

    .nav-link {
        margin: 0 8px;
        font-size: 16px;
    }
}

/* =========================
   RESPONSIVIDADE - CELULARES
========================= */

@media (max-width: 700px) {
    .catalogo-area {
        margin-left: 0;
        padding: 18px 15px 30px;
    }

    .catalogo {
        grid-template-columns: 1fr;
        gap: 28px;
    }

    .pesquisa-container form {
        width: 100%;
    }

    .pesquisa-container button {
        padding: 0 16px;
    }
}

@media (max-width: 600px) {
    .header-home {
        padding: 10px 5px 0;
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
        gap: 10px !important;
    }

    .logo {
        width: 75px;
    }

    .titulo {
        font-size: 27px;
    }

    .icone-header {
        font-size: 21px;
    }

    .usuario-header {
        display: none;
    }

    .nav {
        padding: 8px 0;
        flex-wrap: wrap;
    }

    .nav-link {
        font-size: 12px;
        margin: 0 4px;
        padding: 6px 4px;
    }

    .carousel img {
        height: 300px;
        object-fit: cover;
    }

    .produto-nome {
        font-size: 18px;
    }

    .produto-preco {
        font-size: 17px;
    }
}
</style>




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
                    <?php echo htmlspecialchars($_SESSION['nome'] ?? 'Usuário'); ?>
                </a>

            </div>

        </div>

    </div>

    <!-- MENU -->
    <ul class="nav justify-content-center">

        <li class="nav-item">
            <a class="nav-link active" href="home.php">
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
            <a class="nav-link disabled"
               aria-disabled="true"
               tabindex="-1">
                PINTO
            </a>
        </li>

    </ul>

</header>


<div class="catalogo-area">

    <!-- PESQUISA -->

    <div class="pesquisa-container">

        <form method="GET">

            <input 
                type="text" 
                name="pesquisa"
                placeholder="Pesquisar produto..."
                value="<?php echo isset($_GET['pesquisa']) ? htmlspecialchars($_GET['pesquisa']) : ''; ?>"
            >

            <button type="submit">
                Pesquisar
            </button>

        </form>

    </div>


    <!-- PRODUTOS -->

    <div class="catalogo">

        <?php

        if ($resultado->num_rows > 0) {

            while ($produto = $resultado->fetch_assoc()) {

                ?>

                <div class="produto-card">

                    <img 
                        class="produto-imagem"
                        src="../img_produto/<?php echo htmlspecialchars($produto['foto']); ?>"
                        alt="<?php echo htmlspecialchars($produto['nome']); ?>"
                    >

                    <div class="produto-info">

                        <p class="produto-nome">
                            <?php echo htmlspecialchars($produto['nome']); ?>
                        </p>

                        <p class="produto-categoria">
                            <?php echo htmlspecialchars($produto['categoria']); ?>
                        </p>

                        <p class="produto-preco">
                            R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?>
                        </p>

                    </div>

                </div>

                <?php

            }

        } else {

            echo '<div class="sem-produtos">Nenhum produto encontrado.</div>';

        }

        ?>

    </div>

</div>


<?php
$conexao->close();
?>