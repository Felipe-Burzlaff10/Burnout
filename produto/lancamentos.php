<?php 
session_start();

if (!isset($_SESSION['dados']['id_usuario']))
{
    echo "<script>window.location.href='../index.php';</script>";
    exit();
}

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BURNOUT - Lançamentos</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="../CSS/produto/lancamentos.css">
</head>
<body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

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

                <img src="../img_site/logo.png" alt="Logo BURNOUT" class="logo">
            </div>

            <!-- TÍTULO -->
            <div class="col-6 text-center">
                <h1 class="titulo">BURNOUT</h1>
            </div>

            <!-- ÍCONES -->
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
                        <a href="../perfil.php"><i class="bi bi-person"></i> Minha conta</a>
                        <a href="../historico.php"><i class="bi bi-clock-history"></i> Histórico de compras</a>
                        <a href="../usuario/alterar.php"><i class="bi bi-gear"></i> Alterar meus dados</a>
                        <hr>
                        <a href="../usuario/logout.php" class="sair">
                            <i class="bi bi-box-arrow-right"></i> Sair da conta
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MENU PRINCIPAL -->
    <ul class="nav justify-content-center">
        <li class="nav-item">
            <a class="nav-link" href="../index.php">HOME</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="catalogo.php">CATALOGO</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="lancamentos.php">LANÇAMENTOS</a>
        </li>
        <li class="nav-item">
            <a class="nav-link">SOBRE NÓS</a>
        </li>
    </ul>
</header>

<!-- FUNDO ESCURO -->
<div class="fundo-sidebar" id="fundoSidebar"></div>

<!-- BARRA LATERAL -->
<aside class="sidebar" id="sidebar" aria-label="Menu lateral">
    <div class="sidebar-topo">
        <h2>BURNOUT</h2>
        <button class="fechar-sidebar" id="fecharSidebar" type="button" aria-label="Fechar menu">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <a href="../usuario/listar.php">
        <i class="bi bi-person-circle"></i> Listar Usuarios
    </a>
    <a href="alterar.php">
        <i class="bi bi-pencil-square"></i> Alterar Produtos
    </a>
    <a href="../usuario/cadastro.php">
        <i class="bi bi-person-add"></i> Cadastrar Usuário
    </a>
    <a href="cadastro.php">
        <i class="bi bi-file-earmark-plus"></i> Cadastrar Produto
    </a>

    <hr class="separador">
</aside>

<script>
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

<div class="catalogo-area">
    <h1>Lançamentos - 2026</h1>
    
    <!-- PRODUTOS -->

    <div class="catalogo">

<?php
require_once "../conexao.php";

$sql = "SELECT * FROM produto
        order by id_produto desc
        limit 3";

$resultado = $conexao->query($sql);

$stmt = $conexao->prepare($sql);
$stmt->execute();

$resultado = $stmt->get_result();

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
</div>


<?php
echo "<script src='../usuario_menu.js'></script>";
echo "<script>usuario_menu_suspenso();</script>";
$conexao->close();
?>

</body>
</html>