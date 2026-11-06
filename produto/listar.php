<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>BURNOUT - Listar Produtos</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CSS da página -->
    <link rel="stylesheet" href="../CSS/produto/listar.css">
</head>

<body>

<header class="header-listar">
    <div class="container-fluid">
        <img src="../img_site/logo.png" alt="Logo BURNOUT" class="logo">
        <h1 class="titulo">BURNOUT</h1>
        <a href="../index.php" class="link-voltar">
            <i class="bi bi-arrow-left"></i> <span>Voltar ao início</span>
        </a>
    </div>
</header>

<main class="pagina-listar">

<div class="pagina-topo">

<h2>Listar produtos</h2>

<form method="GET" class="busca-form">
     <input 
                type="text" 
                name="pesquisa"
                placeholder="Pesquisar produto..."
            >

            <label for="categoria">Categoria: </label>
        <select name="categoria" id="categoria">
            <option value="Camiseta">Camiseta</option>
            <option value="Calça">Calça</option>
            <option value="Tênis">Tênis</option>
        </select><br>

    <button type="submit"><i class="bi bi-search"></i> Pesquisar</button>
</form>

</div>

<?php
session_start();

if ($_SESSION['dados']['root'] != 1)
{
    echo "<script>window.location.href='../index.php';</script>";
    exit();
}

require_once "../conexao.php";

$sql = "SELECT * FROM produto";
$resultado = ($conexao->query($sql));  

if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    if (isset($_GET['pesquisa']))
    {
        $pesquisa = "%" . $_GET['pesquisa'] . "%";

        $sql = "SELECT * FROM produto
                WHERE nome LIKE ?
                AND categoria = ?";

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param('ss', $pesquisa, $_GET['categoria']);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $stmt->close();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (isset($_POST['id_apagar']))
    {
        $sql = "DELETE FROM produto
                WHERE id_produto = ?";

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param('i', $_POST['id_apagar']);
        $stmt->execute();
        $stmt->close();

        //apenas para recarregar a pagina e retirar o produto da tela, no banco ja foi excluso
        echo "<script>window.location.href='listar.php'</script>";
    }
}

echo "<div class='lista-wrapper'>";

echo "<form method='post' class='lista-produtos'>";

while($produto = $resultado -> fetch_assoc())
{
    echo "<div class='produto-card'>";

    echo "<br>";
    
    foreach ($produto as $key => $value)
    {
        if ($key == "foto")
        {
            echo "<img src='" . "../img_produto/" . $produto['foto'] . "' width='20%' ><br>";
            continue;
        }

        echo "<div class='campo campo-" . $key . "'><span class='rotulo'>" . $key . "</span> <span class='valor'>" . htmlspecialchars($produto[$key]) . "</span></div>";
    }

    echo "<div class='produto-acoes'>";
    echo "<button type='submit' name='id_apagar' value='" . $produto['id_produto'] . "' class='btn-apagar'>Apagar</button>";
    echo "<button class='btn-alterar'><a href='alterar.php?id_alterar=" . $produto['id_produto'] . "'>Alterar</a></button>";
    echo "</div>";

    echo "</div>";

}

echo "</form>";

echo "</div>";
echo "<hr>";

$conexao->close();
?>

</main>

</body>

</html>