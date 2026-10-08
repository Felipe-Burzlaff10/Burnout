<?php
session_start();

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
   CATÁLOGO BURNOUT
========================= */

.catalogo-area {
    background: #d3d3d3;
    min-height: 100vh;
    padding: 18px 22px 40px 22px;

    /* espaço para a barra lateral do protótipo */
    margin-left: 255px;
}

/* PESQUISA */

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
    height: 40px;

    border: 2px solid #000;
    border-radius: 20px;

    padding: 0 18px;

    font-family: Arial, sans-serif;
    font-size: 15px;

    outline: none;
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

    transition: 0.2s;
}

.pesquisa-container button:hover {
    background: #27d000;
    color: #000;
}


/* GRID DOS PRODUTOS */

.catalogo {
    display: grid;

    grid-template-columns: repeat(3, 1fr);

    gap: 38px 48px;

    width: 100%;
}


/* CARD */

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

    transition: 0.25s;
}

.produto-card:hover .produto-imagem {
    transform: scale(1.02);
}


/* INFORMAÇÕES */

.produto-info {
    padding: 9px 5px 0 5px;
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


/* CASO NÃO ENCONTRE PRODUTOS */

.sem-produtos {
    grid-column: 1 / -1;

    text-align: center;

    font-family: Arial, sans-serif;

    font-size: 20px;
    font-weight: bold;

    padding: 50px;
}


/* RESPONSIVIDADE */

@media (max-width: 1000px) {

    .catalogo {
        grid-template-columns: repeat(2, 1fr);
    }

}

@media (max-width: 700px) {

    .catalogo-area {
        margin-left: 0;
    }

    .catalogo {
        grid-template-columns: 1fr;
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