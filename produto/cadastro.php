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
<html>
<head>
    <title>Cadastro</title>
   <link rel="stylesheet" href="../CSS/produto/cadastro.css">
</head>

<body>

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

<button type="button" onclick="history.back()" class="btn-voltar">
    ← Voltar
</button>

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
