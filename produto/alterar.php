<script>
    function preencher_input(produto)
    {
        document.getElementById("nome").value = produto.nome;
        document.getElementById("categoria").value = produto.categoria;
        document.getElementById("preco").value = produto.preco;
        document.getElementById("tam").value = produto.tamanho;
        document.getElementById("estoque").value = produto.estoque;
        document.getElementById("descricao").value = produto.descricao;
    }
</script>

<?php
session_start();

if (!isset($_SESSION['dados']['id_usuario']))
{
    echo "<script>window.location.href='../index.php';</script>";
    exit();
}

echo "<script src='../API_endereço.js'></script>";

require_once "../conexao.php";

$sql = "SELECT * FROM produto
        WHERE id_produto = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param('i', $_GET['id_alterar']);
$stmt->execute();
$resultado = $stmt->get_result();
$stmt->close();

$produto = $resultado -> fetch_assoc();


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

    if(isset($_POST['preco']) && $_POST['preco'] !== '')
        $preco = $_POST['preco'];
    else
        $preco = 0.0;

    if(!empty($_POST['tam']))
        $tamanho = $_POST['tam'];
    else
    {
        $tamanho = '';
    }

     if(isset($_POST['estoque']) && $_POST['estoque'] !== '')
        $estoque = $_POST['estoque'];
    else
    {
        $estoque = '';
    }

     if(!empty($_POST['descricao']))
        $descricao = $_POST['descricao'];
    else
    {
        $descricao = '';
    }

    // a segunda condição do if é para caso eu não envie nenhuma img ele não criar um nome errado e o produto acabar ficando sem img
    if(isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK)
    {
        $nome_arquivo = $_FILES["imagem"]["name"];
        $nome_temporario = $_FILES['imagem']['tmp_name'];

        $extensao = strtolower(pathinfo($nome_arquivo, PATHINFO_EXTENSION));

        $extensoes_permitidas = ["jpg", "png", "jpeg", ""];

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
            preco = COALESCE(?, preco),
            tamanho = COALESCE(NULLIF(?, ''), tamanho),
            estoque = COALESCE(?, estoque),
            descricao = COALESCE(NULLIF(?, ''), descricao),
            foto = COALESCE(NULLIF(?, ''), foto)
        WHERE id_produto = ?";


$stmt = $conexao->prepare($sql);
$stmt->bind_param('ssdsissi', $nome, $categoria, $preco, $tamanho, $estoque, $descricao, $nome_final_imagem ,$_GET['id_alterar']);
$stmt->execute();
$stmt->close();

$id_redirecionar = (int) $_GET['id_alterar'];
echo "<script>window.location.href = 'alterar.php?id_alterar={$id_redirecionar}';</script>";
exit();

}  

?>

<link rel="stylesheet" href="../CSS/produto/alterar.css">

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
 
    <label for="nome">Nome Produto: </label> 
    <input type="nome" name="nome" id="nome"><br> 
 
   <label for="categoria">Categoria: </label>
    <select name="categoria" id="categoria">
        <option value="Camiseta">Camiseta</option>
        <option value="Calça">Calça</option>
        <option value="Tênis">Têniss</option>
    </select><br>
    
    <label for="preco">Preço: </label> 
    <input type="number" name="preco" id="preco"><br>
    
    
    <label for="tam">Tamanho: </label> 
    <input type="text" name="tam" id="tam"><br> 
    
    <label for="estoque">Estoque: </label> 
    <input type="number" name="estoque" id="estoque"><br>

    <label for="descricao">Descrição: </label>
    <textarea style="resize: none;"  rows="5" cols="40" id="descricao" name="descricao" id="descricao"></textarea>

    <label for="imagem">Imagem: </label> 
    <input type="file" name="imagem"><br> 
 
    <input type="submit" value="Alterar"> 
 
</form> 


<script>
    const produto = <?= json_encode($produto) ?>;
    preencher_input(produto);
</script>
