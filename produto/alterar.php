<?php
session_start();

if (!isset($_SESSION['id_usuario']))
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

<form action="" method="POST" enctype="multipart/form-data">

    <label for="nome">Nome Produto: </label>
    <input type="nome" name="nome"  ><br>

    <label for="categoria">Categoria: </label>
    <input type="text" name="categoria"  ><br>

    <label for="preco">Preço: </label>
    <input type="num" name="preco" id="preco"  ><br>

    <label for="tam">Tamanho: </label>
    <input type="text" name="tam" id="tam"  ><br>

      <label for="imagem">Imagem: </label>
    <input type="file" name="imagem"><br>

    <input type="submit" value="Alterar">

</form>

<a href="../index.php">
    <button>Voltar</button>
</a>