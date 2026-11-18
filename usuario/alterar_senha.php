<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BURNOUT - Alterar senha</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../CSS/usuario/alterar_senha.css">
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

<h1 class="titulo-pagina">Alterar senha</h1>

<form method="post">
    <label for="senha_antiga"></label>
    <input type="password" name="senha_antiga" id="senha_antiga" placeholder="Digite sua senha antiga" required><br>

    <label for="nova_senha"></label>
    <input type="password" name="nova_senha" id="nova_senha" placeholder="Digite a nova senha" required><br>

    <button type="submit">Alterar Senha</button>
</form>

<?php
session_start();
require_once "../conexao.php";
$sql = "SELECT senha FROM usuario
        WHERE id_usuario = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('i', $_SESSION['dados']['id_usuario']);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $usuario = $resultado->fetch_assoc();
    $stmt->close();


if($_SERVER['REQUEST_METHOD'] == 'POST')
{

if(password_verify($_POST['senha_antiga'], $usuario['senha']) && !empty($_POST['senha_antiga']))
{
    $senha_hash = password_hash($_POST['nova_senha'], PASSWORD_DEFAULT);
    echo "<p class='mensagem'>senha alterada com sucesso!</p>";
}
else
{
    echo "<p class='mensagem'>senha antiga está incorreta!</p>";
    $senha_hash = '';
}

    $sql = "UPDATE usuario
            SET senha = COALESCE(NULLIF(?, ''), senha)
            WHERE id_usuario = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('si', $senha_hash ,$_SESSION['dados']['id_usuario']);
    $stmt->execute();
    $stmt->close();
}
?>

</body>
</html>