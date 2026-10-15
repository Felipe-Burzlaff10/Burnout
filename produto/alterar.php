<?php
session_start();

if (!isset($_SESSION['dados']['id_usuario']))
{
    echo "<script>window.location.href='index.php';</script>";
    exit();
}

echo "<script src='../API_endereço.js'></script>";

require_once "../conexao.php";


if ($_SERVER["REQUEST_METHOD"] == "POST")
{
     if(!empty($_POST['nome']))
        $nome = $_POST['nome'];
    else
        $nome = '';
    
    if(!empty($_POST['categoria']))
    $categoria = $_POST['categoria'];
    else
        $categoria = '';

    if(!empty($_POST['preco']))
        $preco = $_POST['preco'];
    else
        $preco = 0.0;

    if(!empty($_POST['tam']))
        $tamanho = $_POST['tam'];
    else
    {
        $tamanho = '';
        echo "Tamanho invalido";
    }

    if(isset($_FILES['imagem']))
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
    }
    else
        $nome_final_imagem = '';



     $sql = "UPDATE produto
            SET nome = COALESCE(NULLIF(?, ''), nome),
                categoria = COALESCE(NULLIF(?, ''), categoria),
                preco = COALESCE(NULLIF(?, ''), preco),
                tamanho = COALESCE(NULLIF(?, ''), tamanho),
                foto = COALESCE(NULLIF(?, ''), foto)
            WHERE id_produto = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param('ssdssi', $nome, $categoria, $preco, $tamanho, $nome_final_imagem ,$_GET['id_alterar']);
$stmt->execute();
$stmt->close();

    
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar produto - BURNOUT</title>
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
    <h1 class="admin-heading">Alterar produto</h1>
    <p class="admin-subheading">Preencha os campos que deseja atualizar.</p>

    <section class="admin-panel">
        <form class="admin-form" action="" method="POST" enctype="multipart/form-data">
            <label for="nome">Nome do produto</label>
            <input type="text" name="nome" id="nome">

            <label for="categoria">Categoria</label>
            <select name="categoria" id="categoria">
                <option value="Camiseta">Camiseta</option>
                <option value="Calça">Calça</option>
                <option value="Tênis">Tênis</option>
            </select>

            <label for="preco">Preço</label>
            <input type="number" step="0.01" name="preco" id="preco">

            <label for="tam">Tamanho</label>
            <input type="text" name="tam" id="tam">

            <label for="imagem">Imagem</label>
            <input type="file" name="imagem" id="imagem" accept=".jpg,.jpeg,.png">

            <input type="submit" value="Salvar alterações">
        </form>
    </section>
</main>
</body>
</html>