<?php
session_start();

if (!$_SESSION['dados']['root'])
{
    echo "<script>window.location.href='../index.php';</script>";
    exit();
}

require_once "../conexao.php";
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Produto</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CSS da página (depois do Bootstrap para poder sobrescrevê-lo) -->
    <link rel="stylesheet" href="../CSS/produto/cadastro.css">
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

<form action="" method="POST" enctype="multipart/form-data">

    <label for="nome">Nome: </label>
    <input type="text" name="nome"><br>

    <label for="categoria">Categoria: </label>
    <select name="categoria" id="categoria">
        <option value="Camiseta">Camiseta</option>
        <option value="Calça">Calça</option>
        <option value="Tênis">Tênis</option>
    </select><br>

    <label for="preco">Preço: </label>
    <input type="number" step="0.01" name="preco"><br>

    <label for="tamanho">Tamanho: </label>
    <input type="text" name="tamanho"><br>

    <label for="estoque">Estoque: </label>
    <input type="number" name="estoque"><br>

    <label for="descricao">Descrição: </label>
    <textarea style="resize: none;"  rows="5" cols="40" id="descricao" name="descricao"></textarea>

    <label for="imagem">Imagem: </label>
    <input type="file" name="imagem"><br>

    <input type="submit" value="Cadastrar">

</form>

</body>
</html>

<?php
require_once "../conexao.php";
echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
echo "<script src='../mensagem_erro.js'></script>";

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

    try
    {
        if($_POST['estoque'] == 0)
            throw new Exception("Numero invalido para estoque!");

        $sql = "INSERT INTO produto(nome, categoria, preco, tamanho, estoque, descricao, foto)
        VALUES (?, ?, ?, ?, ?, ?, ?) ";

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param('ssdsiss', $_POST['nome'], $_POST['categoria'], $_POST['preco'], $_POST['tamanho'], $_POST['estoque'], $_POST['descricao'], $nome_final_imagem);
        $stmt->execute();
        $stmt->close();


    }catch(Exception $e)
    {
        echo "<script>erro_mensagem(" . json_encode($e->getMessage()) . ");</script>";
        exit;
    }
    finally
    {
        echo "<script>sucesso_mensagem('Sucesso ao Cadastrar!');</script>";
    }
   
}
 
$conexao->close();
?>
