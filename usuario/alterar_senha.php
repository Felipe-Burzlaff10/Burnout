<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BURNOUT - Alterar senha</title>

    <link rel="stylesheet" href="../CSS/usuario/alterar_senha.css">
</head>
<body>

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
    echo "<p class='mensagem'>senha alterada com sucesso</p>";
}
else
{
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

 <a href="../index.php">
        <button type="button" class="btn-voltar">
        ← Voltar
        </button>
    </a>

</body>
</html>