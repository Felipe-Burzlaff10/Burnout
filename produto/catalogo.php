<?php session_start();

require_once "../conexao.php";

$sql = "SELECT * FROM produto";
$resultado = $conexao->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['pesquisa']))
{

    $pesquisa = $_GET['pesquisa'] . "%";

    $sql = "SELECT * FROM produto 
            WHERE nome LIKE ? ";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('s', $pesquisa);
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


/* =========================
   BOTÃO E MENU DO USUÁRIO
========================= */

/* Área do usuário */
.usuario-menu {
    position: absolute;
    top: 122px; /* Ajuste conforme a altura do cabeçalho */
    right: 28px;
    left: auto;
    display: inline-block;
    z-index: 2000;
}

/* Botão com o nome do usuário */
.usuario-header {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;

    background-color: #111;
    color: white;

    font-weight: bold;
    font-size: 14px;

    border: 1px solid #292929;
    border-radius: 8px;
    padding: 10px 14px;

    cursor: pointer;
    white-space: nowrap;
}

/* Menu suspenso */
.usuario-dropdown {
    display: none;
    position: absolute;
    top: 100%;
    right: 0;
    left: auto;

    width: 230px;
    box-sizing: border-box;

    background-color: #111;
    border: 1px solid #292929;
    border-radius: 0 0 8px 8px;

    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3);
    overflow: hidden;
}

.usuario-dropdown.aberto {
    display: block;
}

/* Opções */
.usuario-dropdown a {
    display: flex;
    align-items: center;
    gap: 10px;

    padding: 13px 14px;
    color: #f2f2f2;
    text-decoration: none;
    font-size: 14px;

    transition: background-color 0.2s, color 0.2s;
}

.usuario-dropdown a:hover {
    background-color: #39bf00;
    color: black;
}

.usuario-dropdown hr {
    margin: 0;
    border: 0;
    border-top: 1px solid #333;
}

.usuario-dropdown .sair {
    color: #ff5555;
}

.usuario-dropdown .sair:hover {
    background-color: #39bf00;
    color: black;
}

.usuario-header:hover {
    background-color: #222;
    color: #39bf00;
}


/* =========================
   MENU SUSPENSO
========================= */

.usuario-dropdown {
    display: none;

    position: absolute;
    top: 100%;
    left: 0;
    right: auto;

    width: 100%;
    box-sizing: border-box;

    background-color: #111;
    border: 1px solid #292929;
    border-top: none;

    border-radius: 0 0 8px 8px;

    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3);

    z-index: 2000;
    overflow: hidden;
}

.usuario-dropdown.aberto {
    display: block;
}


/* Une visualmente o botão e o menu */

.usuario-menu:has(.usuario-dropdown.aberto) .usuario-header {
    border-radius: 8px 8px 0 0;
    border-bottom-color: #111;
}


/* =========================
   OPÇÕES DO MENU
========================= */

.usuario-dropdown a {
    display: flex;
    align-items: center;
    gap: 10px;

    padding: 13px 14px;

    color: #f2f2f2;
    text-decoration: none;

    font-size: 14px;
    font-weight: normal;

    transition: background-color 0.2s, color 0.2s;
}

.usuario-dropdown a:hover {
    background-color: #39bf00;
    color: black;
}


/* ÍCONES */

.usuario-dropdown a i {
    font-size: 14px;
}


/* SEPARADOR */

.usuario-dropdown hr {
    margin: 0;
    border: 0;
    border-top: 1px solid #333;
}


/* SAIR DA CONTA */

.usuario-dropdown .sair {
    color: #ff5555;
}

.usuario-dropdown .sair:hover {
    background-color: #39bf00;
    color: black;
}


/* =========================
   RESPONSIVIDADE DO USUÁRIO
========================= */

@media (max-width: 900px) {
    .usuario-header {
        font-size: 15px;
        padding: 9px 10px;
    }
}

@media (max-width: 600px) {
    .usuario-header {
        display: inline-flex;
        font-size: 12px;
        padding: 8px;
        white-space: normal;
        max-width: 150px;
    }

    .usuario-dropdown a {
        padding: 11px 10px;
        font-size: 12px;
    }
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


/* CATÁLOGO DE PRODUTOS */

.catalogo-produtos {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 25px;
    padding: 25px;
}

/* CARD DO PRODUTO */

.card-produto {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 14px;

    padding: 25px;
    background-color: #fff;
    border-radius: 12px;
    text-align: center;

    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.10);
    transition: transform 0.2s, box-shadow 0.2s;
}

.card-produto:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.16);
}

/* IMAGEM */

.imagem-produto {
    width: 100%;
    aspect-ratio: 3 / 4;
    object-fit: cover;
    border-radius: 8px;
}

/* NOME */

.nome-produto {
    margin: 10px 0 0;
    font-family: Arial, sans-serif;
    font-size: 22px;
    color: #333;
}

/* PREÇO */

.preco-produto {
    margin: 0;
    font-family: Arial, sans-serif;
    font-size: 26px;
    font-weight: bold;
    color: #000;
}
}
/* RESPONSIVIDADE */

@media (max-width: 1200px) {
    .catalogo-produtos {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
}

@media (max-width: 800px) {
    .catalogo-produtos {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 500px) {
    .catalogo-produtos {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
        padding: 10px;
    }

    .card-produto {
        padding: 10px;
    }

    .nome-produto {
        font-size: 17px;
    }

    .preco-produto {
        font-size: 20px;
    }
}

</style>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <header class="header-home">

    <div class="container-fluid">

        <div class="row align-items-center">

            <!-- LOGO -->
            <div class="col-3">
                <img src="../img_site/logo.png" alt="Logo BURNOUT" class="logo">
            </div>

            <!-- TÍTULO -->
            <div class="col-6 text-center">
                <h1 class="titulo">BURNOUT</h1>
            </div>

            <!-- CARRINHO + USUÁRIO -->
            <div class="col-3 d-flex justify-content-end align-items-center gap-3">

                <a href="carrinho.php" class="icone-header" title="Carrinho" aria-label="Carrinho">
                    <i class="bi bi-cart3"></i>
                </a>

                <div class="usuario-menu">

                    <button type="button" class="usuario-header" id="usuarioBtn"
                            aria-expanded="false" aria-controls="usuarioDropdown">
                        <?php echo htmlspecialchars($_SESSION['dados']['nome']); ?>
                        <i class="bi bi-chevron-down"></i>
                    </button>

                    <div class="usuario-dropdown" id="usuarioDropdown">
                        <a href="perfil.php"><i class="bi bi-person"></i> Minha conta</a>
                        <a href="historico.php"><i class="bi bi-clock-history"></i> Histórico de compras</a>
                        <a href="usuario/alterar.php"><i class="bi bi-gear"></i> Alterar meus dados</a>
                        <hr>
                        <a href="usuario/logout.php" class="sair">
                            <i class="bi bi-box-arrow-right"></i> Sair da conta
                        </a>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- MENU -->
    <ul class="nav justify-content-center">
         <ul class="nav justify-content-center">

            <li class="nav-item">
                <a class="nav-link" href="../index.php">HOME</a>
            </li>

              <li class="nav-item">
                <a class="nav-link active" href="">CATALOGO</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="lancamentos.php">LANÇAMENTOS</a>
            </li>

            <li class="nav-item">
                <a class="nav-link disabled" aria-disabled="true">PINTO</a>
            </li>

        </ul>
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
            >

            <button type="submit">
                Pesquisar
            </button>

        </form>

    </div>


    <!-- PRODUTOS -->

    <div class="catalogo">

<?php
if ($resultado->num_rows > 0)
{
    echo "<form method='post' class='d-flex flex-wrap align-items-start p-2 bg-light'>";
    while($produto = $resultado -> fetch_assoc())
    {   
        if($produto['estoque'] > 0)
        {
            $disponibilidade = "Em estoque";
            $estilo = "";
        }
        else
        {
            $disponibilidade = "Fora de estoque";
            $estilo = "filter: blur(2px);";
        }
        
        echo "<div class='card m-2 p-2' style='white-space: nowrap;'>";
        
    echo "<img style='width: 100%; height: 150px; object-fit: cover; $estilo' src='../img_produto/" . $produto['foto'] . "'><br>";
        
        echo "Nome: " . $produto['nome'] . "<br>";
        
        echo "Preço: R$" . $produto['preco'];
        
        echo "<br>";
        
        echo "<details>";
        
        echo "<summary>Ver mais</summary>";

         echo "Categoria: ". $produto['categoria']. "<br>";
        
        echo "Estoque: ". $produto['estoque']. "<br>";
        
        echo "Tamanho: ". $produto['tamanho']. "<br>";
        
        echo "Descrição: " . $produto['descricao']. "<br>";
        
        
        echo "Disponibilidade: " . $disponibilidade. "<br>";
        
        
        echo "</details>";
        
        echo "</div>";
    }

    echo "</form>";
}
?>

</div>


<?php
echo "<script src='../usuario_menu.js'></script>";
echo "<script>usuario_menu_suspenso();</script>";
$conexao->close();
?>