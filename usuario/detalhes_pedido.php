<?php 
session_start();

if (!isset($_SESSION['dados']['id_usuario']))
{
    echo "<script>window.location.href='../index.php';</script>";
    exit();
}

require_once "../conexao.php";

$sql = "SELECT p.id_pedido, p.data_compra,
               pcp.quantidade, pcp.preco_unitario, pcp.preco,
               pr.nome, u.nome AS nome_usuario, u.endereco
        FROM pedido_contem_produto pcp
        JOIN pedido p ON pcp.id_pedido = p.id_pedido
        JOIN produto pr ON pcp.id_produto = pr.id_produto
        JOIN usuario u ON p.id_usuario = u.id_usuario
        WHERE pcp.id_pedido = ? AND p.id_usuario = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param('ii', $_GET['id_pedido'], $_SESSION['dados']['id_usuario']);
$stmt->execute();
$resultado = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BURNOUT - Detalhes do pedido</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CSS da página (depois do Bootstrap para poder sobrescrevê-lo) -->
    <link rel="stylesheet" href="../CSS/usuario/detalhes_pedido.css">
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

<main class="pagina-pedido">

<?php
if($resultado->num_rows > 0)
{
    $titulo = true;
    $total = 0;

    while($item = $resultado->fetch_assoc())
    {
        if($titulo)
        {
            echo "<section class='pedido-resumo'>";
            echo "<h2 class='pedido-titulo'><i class='bi bi-receipt'></i> Pedido #" . $item['id_pedido'] . "</h2>";

            echo "<div class='pedido-meta'>";
            echo "<div class='pedido-data'><i class='bi bi-person'></i> Feito por " . htmlspecialchars($item['nome_usuario']) . "</div>";
            echo "<div class='pedido-data'><i class='bi bi-geo-alt'></i> " . htmlspecialchars($item['endereco']) . "</div>";
            echo "<div class='pedido-data'><i class='bi bi-calendar-event'></i> " . $item['data_compra'] . "</div>";
            echo "</div>";
            echo "</section>";

            echo "<div class='pedido-itens'>";
            $titulo = false;
        }

        $total += $item['preco'];

        echo "<article class='card item-pedido'>";

        echo "<div class='item-nome'><i class='bi bi-box-seam'></i> " . htmlspecialchars($item['nome']) . "</div>";

        echo "<div class='item-dados'>";
        echo "<div class='dado'><span class='rotulo'>Quantidade</span><span class='valor'>" . $item['quantidade'] . "</span></div>";
        echo "<div class='dado'><span class='rotulo'>Preço unitário</span><span class='valor'>R$" .number_format($item['preco_unitario'], 2, ',', '.') . "</span></div>";
        echo "<div class='dado dado-subtotal'><span class='rotulo'>Subtotal</span><span class='valor'>R$" .  number_format($item['preco'], 2, ',', '.') . "</span></div>";
        echo "</div>";

        echo "</article>";
    }

    echo "</div>";

    echo "<div class='pedido-total'><span class='rotulo'>Total do pedido</span><span class='valor'>R$" . number_format($total, 2, ',', '.') . "</span></div>";
}
else
{
    echo "<div class='pedido-vazio'><i class='bi bi-search'></i><p>Pedido não encontrado.</p></div>";
}
?>

<a href="historico_compras.php" class="btn-voltar-historico">
    <i class="bi bi-clock-history"></i> Voltar ao histórico de compras
</a>

</main>

</body>
</html>