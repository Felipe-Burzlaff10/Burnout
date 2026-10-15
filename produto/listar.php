<?php
session_start();

if ($_SESSION['dados']['root'] != 1)
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
            WHERE nome LIKE ?
            OR categoria LIKE ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('ss', $pesquisa, $pesquisa);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_apagar']))
{
    $sql = "DELETE FROM produto
            WHERE id_produto = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('i', $_POST['id_apagar']);
    $stmt->execute();
    $stmt->close();

    echo "<script>window.location.href='listar.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos - BURNOUT</title>
    <link rel="stylesheet" href="../assets/css/burnout-admin.css">
</head>
<body class="admin-page">
<header class="admin-header">
    <a class="admin-brand" href="../index.php">
        <img src="../img_site/logo.png" alt="">
        <span>BURNOUT</span>
    </a>
    <a class="admin-back" href="cadastro.php">Cadastrar produto</a>
</header>

<main class="admin-main">
    <h1 class="admin-heading">Produtos cadastrados</h1>
    <p class="admin-subheading">Consulte, edite ou remova produtos da loja.</p>

    <form class="admin-search" method="GET">
        <input
            type="text"
            name="pesquisa"
            placeholder="Pesquisar por nome ou categoria"
            value="<?php echo htmlspecialchars($_GET['pesquisa'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
        >
        <button type="submit">Pesquisar</button>
    </form>

    <section class="admin-products" aria-label="Lista de produtos">
        <?php if ($resultado && $resultado->num_rows > 0): ?>
            <?php while ($produto = $resultado->fetch_assoc()): ?>
                <article class="admin-product">
                    <img
                        src="../img_produto/<?php echo htmlspecialchars($produto['foto'], ENT_QUOTES, 'UTF-8'); ?>"
                        alt="<?php echo htmlspecialchars($produto['nome'], ENT_QUOTES, 'UTF-8'); ?>"
                    >
                    <h2><?php echo htmlspecialchars($produto['nome'], ENT_QUOTES, 'UTF-8'); ?></h2>
                    <p><?php echo htmlspecialchars($produto['categoria'], ENT_QUOTES, 'UTF-8'); ?> · Tamanho <?php echo htmlspecialchars($produto['tamanho'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p class="admin-product-price">R$ <?php echo number_format((float) $produto['preco'], 2, ',', '.'); ?></p>
                    <div class="admin-product-actions">
                        <a href="alterar.php?id_alterar=<?php echo (int) $produto['id_produto']; ?>">Alterar</a>
                        <form method="POST">
                            <button
                                class="admin-delete"
                                type="submit"
                                name="id_apagar"
                                value="<?php echo (int) $produto['id_produto']; ?>"
                            >Apagar</button>
                        </form>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="admin-empty">Nenhum produto encontrado.</p>
        <?php endif; ?>
    </section>
</main>
</body>
</html>

<?php
$conexao->close();
?>
