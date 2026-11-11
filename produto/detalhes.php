<?php 
session_start();

if (!isset($_SESSION['dados']['id_usuario']))
{
    echo "<script>window.location.href='../index.php';</script>";
    exit();
}

require_once "../CLASSE/carrinho.php";
require_once "../conexao.php";

$sql = "SELECT * FROM produto
        WHERE id_produto = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param('i', $_GET['id_produto']);
$stmt->execute();
$resultado = $stmt->get_result();
$stmt->close();

$produto = $resultado -> fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BURNOUT - Detalhes do produto</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CSS da página (depois do Bootstrap para poder sobrescrevê-lo) -->
    <link rel="stylesheet" href="../CSS/produto/detalhes.css">
</head>
<body>

<header class="header-detalhes">
    <div class="container-fluid">
        <img src="../img_site/logo.png" alt="Logo BURNOUT" class="logo">
        <h1 class="titulo">BURNOUT</h1>
        <a href="carrinho.php" class="icone-header" title="Carrinho" aria-label="Carrinho">
            <i class="bi bi-cart3"></i>
        </a>
    </div>
</header>

<main class="pagina-detalhes">

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script src='../mensagem_erro.js'></script>";
    
    if($produto['estoque'] == 0)
    {
         echo "<script>erro_mensagem('Não foi possivel adicionar ao carrinho, produto fora de estoque!');</script>";
    }
    else
    {
        $qtd = $_POST['qtd'];

        if($qtd < 1 || $qtd > $produto['estoque'])
        {
            echo "<script>erro_mensagem('Quantidade inválida!');</script>";
        }
        elseif(isset($_POST['add_carrinho']))
        {
            $_SESSION['confirma_add'] = true;
            echo "<script>a('O produto adicionado ao carrinho com sucesso!');</script>";
            Carrinho::adicionar_produto($_SESSION['dados']['id_usuario'], $produto['id_produto'], $qtd);
            unset($_SESSION['confirma_add']);
        }
        elseif(isset($_POST['comprar']))
        {
            Carrinho::comprar_em_detalhes($_SESSION['dados']['id_usuario'], $qtd, $produto['id_produto']);
        }

    }

}

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

echo "<div class='detalhes-info'>";

echo "<h2 class='detalhes-nome'>" . $produto['nome'] . "</h2>";

echo "<div class='detalhes-preco'>R$" . $produto['preco'] . "</div>";


echo "<div class='detalhes-campo'><span class='rotulo'>Categoria</span><span class='valor'>" . $produto['categoria'] . "</span></div>";

echo "<div class='detalhes-campo'><span class='rotulo'>Tamanho</span><span class='valor'>" . $produto['tamanho'] . "</span></div>";

echo "<div class='detalhes-campo'><span class='rotulo'>Estoque</span><span class='valor'>" . $produto['estoque'] . "</span></div>";

echo "<div class='detalhes-descricao'><span class='rotulo'>Descrição</span><p>" . $produto['descricao'] . "</p></div>";

echo "<form method='post' class='form-carrinho'>";

echo "<label for='qtd'>Quantidade</label>";

echo "<div class='input-group qtd-grupo'>";

echo "<button type='button' class='btn btn-outline-secondary' onclick=\"document.getElementById('qtd').stepDown()\">-</button>";

echo "<input type='number' id='qtd' name='qtd' class='form-control text-center' value='1' min='1' max='" . $produto['estoque'] . "'>";

echo "<button type='button' class='btn btn-outline-secondary' onclick=\"document.getElementById('qtd').stepUp()\">+</button>";

echo "</div>";

echo "<input type='submit' name='add_carrinho' value='Adicionar ao carrinho'>";
echo "<input type='submit' name='comprar' value='Comprar'>";

echo "</form>";


echo "<a href='catalogo.php'><button class='btn-voltar'>Voltar</button></a>";
echo "<br>";

echo "</div>";

echo "</div>";

$conexao->close();
?>

</main>

</body>
</html>