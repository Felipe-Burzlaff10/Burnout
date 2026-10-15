<?php
session_start();

if (!isset($_SESSION['dados']['id_usuario']))
{
    echo "<script>window.location.href='index.php';</script>";
    exit();
}

require_once "../conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (!empty($_POST['senha']))
        $senha_hash = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    else
        $senha_hash = '';

    $campos_endereco = ['rua', 'num', 'bairro', 'cidade', 'uf', 'cep'];
    $preenchido = [];

    foreach ($campos_endereco as $key)
    {
        if (!empty($_POST[$key]))
            $preenchido[] = $key;
    }

    if (!empty($preenchido))
        $endereco_final = "{$_POST['rua']}, Nº: {$_POST['num']}, {$_POST['bairro']} - {$_POST['cidade']}/{$_POST['uf']} CEP: {$_POST['cep']}";
    else
        $endereco_final = '';

    if (!empty($_POST['email']))
        $email = $_POST['email'];
    else
        $email = '';

    $sql = "UPDATE usuario
            SET email = COALESCE(NULLIF(?, ''), email),
                senha = COALESCE(NULLIF(?, ''), senha),
                endereco = COALESCE(NULLIF(?, ''), endereco)
            WHERE id_usuario = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('sssi', $email, $senha_hash, $endereco_final, $_SESSION['dados']['id_usuario']);
    $stmt->execute();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar dados - BURNOUT</title>
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
    <h1 class="admin-heading">Alterar dados da conta</h1>
    <p class="admin-subheading">Deixe em branco os campos que não deseja modificar.</p>

    <section class="admin-panel">
        <form class="admin-form" method="POST">
            <label for="email">E-mail</label>
            <input type="email" name="email" id="email">

            <label for="senha">Senha</label>
            <input type="password" name="senha" id="senha">

            <label for="cep">CEP</label>
            <div class="admin-inline">
                <input type="text" name="cep" id="cep">
                <button type="button" onclick="buscarEndereco()">Buscar endereço</button>
            </div>

            <label for="uf">UF</label>
            <input type="text" name="uf" id="uf">

            <label for="bairro">Bairro</label>
            <input type="text" name="bairro" id="bairro">

            <label for="cidade">Cidade</label>
            <input type="text" name="cidade" id="cidade">

            <label for="rua">Rua</label>
            <input type="text" name="rua" id="rua">

            <label for="num">Nº</label>
            <input type="number" name="num" id="num">

            <input type="submit" value="Salvar alterações">
        </form>
    </section>
</main>

<script src="../API_endereço.js"></script>
</body>
</html>
