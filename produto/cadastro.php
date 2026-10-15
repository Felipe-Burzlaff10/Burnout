<?php
session_start();

if (!$_SESSION['dados']['root'])
{
    echo "<script>window.location.href='../index.php';</script>";
    exit();
}


require_once "../conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $nome_arquivo = $_FILES["imagem"]["name"];
    $nome_temporario = $_FILES['imagem']['tmp_name'];

    $extensao = strtolower(pathinfo($nome_arquivo, PATHINFO_EXTENSION));

    $extensoes_permitidas = ["jpg", "png", "jpeg"];

    if(!in_array($extensao, $extensoes_permitidas))
            die("a foto contem um tipo de extensao que não é permitida!.");
        
            $nome_final_imagem = uniqid() . "." . $extensao;

    $caminho_destino = "../img_produto/" . $nome_final_imagem;
    move_uploaded_file($nome_temporario, $caminho_destino);

    $sql = "INSERT INTO produto(nome, categoria, preco, tamanho, foto)
    VALUES (?, ?, ?, ?, ?) ";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('ssdss', $_POST['nome'], $_POST['categoria'], $_POST['preco'], $_POST['tamanho'], $nome_final_imagem);
    $stmt->execute();
    $stmt->close();

}
 
$conexao->close();
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar produto - BURNOUT</title>
    <link rel="stylesheet" href="../assets/css/burnout-admin.css">
</head>

<body class="admin-page">
<header class="admin-header">
    <a class="admin-brand" href="../index.php">
        <img src="../img_site/logo.png" alt="">
        <span>BURNOUT</span>
    </a>
    <a class="admin-back" href="listar.php">Voltar à lista</a>
</header>

<main class="admin-main">
    <h1 class="admin-heading">Cadastrar produto</h1>
    <p class="admin-subheading">Adicione um novo item ao catálogo da loja.</p>

    <section class="admin-panel">
        <form class="admin-form" action="" method="POST" enctype="multipart/form-data">
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome">

            <label for="categoria">Categoria</label>
            <select name="categoria" id="categoria">
                <option value="Camiseta">Camiseta</option>
                <option value="Calça">Calça</option>
                <option value="Tênis">Tênis</option>
            </select>

            <label for="preco">Preço</label>
            <input type="number" step="0.01" name="preco" id="preco">

            <label for="tamanho">Tamanho</label>
            <input type="text" name="tamanho" id="tamanho">

            <label for="imagem">Imagem</label>
            <input type="file" name="imagem" id="imagem" accept=".jpg,.jpeg,.png">

            <input type="submit" value="Cadastrar produto">
        </form>
    </section>
</main>

</body>
</html>