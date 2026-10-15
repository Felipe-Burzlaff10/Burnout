<?php
session_start();

if ($_SESSION['dados']['root'] != 1)
{
    echo "<script>window.location.href='../index.php';</script>";
    exit();
}

require_once "../conexao.php";

$sql = "SELECT * FROM usuario";
$resultado = $conexao->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['pesquisa']))
{
    $pesquisa = "%" . $_GET['pesquisa'] . "%";

    $sql = "SELECT * FROM usuario
            WHERE nome LIKE ?
            OR cpf LIKE ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('ss', $pesquisa, $pesquisa);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_apagar']))
{
    $sql = "DELETE FROM usuario
            WHERE id_usuario = ?";

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
    <title>Usuários - BURNOUT</title>
    <link rel="stylesheet" href="../assets/css/burnout-admin.css">
</head>
<body class="admin-page">
<header class="admin-header">
    <a class="admin-brand" href="../index.php">
        <img src="../img_site/logo.png" alt="">
        <span>BURNOUT</span>
    </a>
    <a class="admin-back" href="../index.php">Voltar à loja</a>
</header>

<main class="admin-main">
    <h1 class="admin-heading">Usuários cadastrados</h1>
    <p class="admin-subheading">Pesquise e gerencie as contas da loja.</p>

    <form class="admin-search" method="GET">
        <input
            type="text"
            name="pesquisa"
            placeholder="Pesquisar por nome ou CPF"
            value="<?php echo htmlspecialchars($_GET['pesquisa'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
        >
        <button type="submit">Pesquisar</button>
    </form>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>E-mail</th>
                    <th>Senha</th>
                    <th>Endereço</th>
                    <th>Root</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($resultado && $resultado->num_rows > 0): ?>
                    <?php while ($usuario = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($usuario['id_usuario'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($usuario['nome'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($usuario['cpf'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($usuario['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($usuario['senha'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($usuario['endereco'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($usuario['root'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <?php if (!$usuario['root']): ?>
                                    <form method="POST">
                                        <button
                                            class="admin-delete"
                                            type="submit"
                                            name="id_apagar"
                                            value="<?php echo (int) $usuario['id_usuario']; ?>"
                                        >Apagar</button>
                                    </form>
                                <?php else: ?>
                                    —
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">Nenhum usuário encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>
</body>
</html>

<?php
$conexao->close();
?>
