<?php 
session_start();

if (!isset($_SESSION['dados']['id_usuario']))
{
    echo "<script>window.location.href='../index.php';</script>";
    exit();
}

require_once "../conexao.php";

$sql = "SELECT * FROM produto";
$resultado = $conexao->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['pesquisa']))
{

    $pesquisa = "%" . $_GET['pesquisa'] . "%";

    $sql = "SELECT * FROM produto 
            WHERE nome LIKE ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('s', $pesquisa);
    $stmt->execute();

    $resultado = $stmt->get_result();

    $stmt->close();
}
?>



<link rel="stylesheet" href="../CSS/produto/catalogo.css">


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
        
        echo "<a href='detalhes.php?id_produto=" . $produto['id_produto'] . "'>Ver detalhes</a>";
        
        echo "</div>";
    }

    

    }

?>

</div>


<?php
echo "<script src='../usuario_menu.js'></script>";
echo "<script>usuario_menu_suspenso();</script>";
$conexao->close();
?>