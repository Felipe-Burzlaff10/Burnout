<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>

<?php 
session_start();

if (!isset($_SESSION['dados']['id_usuario']))
{
    echo "<script>window.location.href='../index.php';</script>";
    exit();
}

require_once "../CLASSE/carrinho.php";
require_once "../conexao.php";

$sql = "SELECT * FROM produto
        WHERE id_produto = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param('i', $_GET['id_produto']);
$stmt->execute();
$resultado = $stmt->get_result();
$stmt->close();

$produto = $resultado -> fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script src='../mensagem_erro.js'></script>";
    
    if($produto['estoque'] == 0)
    {
         echo "<script>erro_mensagem('Não foi possivel adicionar ao carrinho, produto fora de estoque!');</script>";
         die("<script>window.location.href='catalogo.php';</script>");
    }
    Carrinho::adicionar_produto($_SESSION['dados']['id_usuario'], $produto['id_produto'], $_POST['qtd']);

    echo "<script>a('O produto adicionado ao carrinho com sucesso!');</script>";
}



if($produto['estoque'] > 0)
{
    $disponibilidade = "Em estoque";
    $estilo = "";
}
else
{
    $disponibilidade = "Fora de estoque";
    $estilo = "filter: blur(2px);";
}

echo "<div class='card m-2 p-2' style='white-space: nowrap;'>";

echo "<img style='width: 100%; height: 150px; object-fit: cover; $estilo' src='../img_produto/" . $produto['foto'] . "'><br>";

echo $produto['nome'] . "<br>";

echo "R$" . $produto['preco'] . "<br>";

echo "Descrição: " . $produto['descricao'] . "<br>";

echo "Tamanho: " . $produto['tamanho'] . "<br>";

echo "Estoque: " . $produto['estoque'] . "<br>";

echo "<form method='post'>";

echo "<input type='number' value='1' min='1' name='qtd'>";

echo "<input type='submit' value='Adicionar ao carrinho'>";


echo "</form>";

echo "<a href='catalogo.php'><button>Voltar</button></a>";
echo "<br>";

$conexao->close();
?>