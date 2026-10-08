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

<style>
    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        min-height: 100vh;
        padding: 40px 20px;

        background: linear-gradient(
            to bottom,
            #ffffff 0%,
            #ffffff 25%,
            #b3b3b3 100%
        );

        font-family: Georgia, "Times New Roman", serif;
        color: #000;
    }

    form {
        width: 90%;
        max-width: 650px;
        margin: 20px auto;

        padding: 35px 45px;

        background: #22c900;
        border-radius: 22px;
    }

    label {
        display: block;
        margin: 14px 0 7px;

        font-size: 19px;
        font-weight: bold;
    }

    input[type="nome"],
    input[type="text"],
    input[type="num"],
    input[type="file"] {
        width: 100%;
        height: 45px;

        padding: 8px 12px;

        border: 3px solid #000;
        border-radius: 10px;

        background: #fff;

        font-family: Georgia, "Times New Roman", serif;
        font-size: 17px;
        font-weight: bold;

        outline: none;
    }

    input[type="file"] {
        padding: 7px;
    }

    input:focus {
        background: #f1f1f1;
    }

    input[type="submit"] {
        display: block;

        width: 220px;
        height: 55px;

        margin: 30px auto 15px;

        border: none;
        border-radius: 15px;

        background: #000;
        color: #fff;

        font-family: Georgia, "Times New Roman", serif;
        font-size: 18px;
        font-weight: bold;

        cursor: pointer;
        transition: 0.2s;
    }

    input[type="submit"]:hover {
        background: #222;
        transform: scale(1.03);
    }

    a {
        text-decoration: none;
    }

    a button {
        display: block;

        width: 220px;
        height: 50px;

        margin: 0 auto;

        border: none;
        border-radius: 15px;

        background: #000;
        color: #fff;

        font-family: Georgia, "Times New Roman", serif;
        font-size: 17px;
        font-weight: bold;

        cursor: pointer;
        transition: 0.2s;
    }

    a button:hover {
        background: #222;
        transform: scale(1.03);
    }

    @media (max-width: 600px) {

        body {
            padding: 20px 10px;
        }

        form {
            width: 100%;
            padding: 25px 20px;
        }

        input[type="submit"],
        a button {
            width: 100%;
        }
    }
</style>


<form action="" method="POST" enctype="multipart/form-data"> 
 
    <label for="nome">Nome Produto: </label> 
    <input type="nome" name="nome"><br> 
 
    <label for="categoria">Categoria: </label> 
    <input type="text" name="categoria"><br> 
 
    <label for="preco">Preço: </label> 
    <input type="num" name="preco" id="preco"><br> 
 
    <label for="tam">Tamanho: </label> 
    <input type="text" name="tam" id="tam"><br> 
 
    <label for="imagem">Imagem: </label> 
    <input type="file" name="imagem"><br> 
 
    <input type="submit" value="Alterar"> 
 
</form> 
 
<a href="../index.php"> 
    <button>← Voltar</button> 
</a>