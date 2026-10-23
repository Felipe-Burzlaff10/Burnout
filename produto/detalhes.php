<?php 
session_start();

if (!isset($_SESSION['dados']['id_usuario']))
{
    echo "<script>window.location.href='../index.php';</script>";
    exit();
}

require_once "../conexao.php";

$sql = "SELECT * FROM produto
        WHERE id_produto = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param('i', $_GET['id_produto']);
$stmt->execute();
$resultado = $stmt->get_result();
$stmt->close();

if ($resultado->num_rows > 0)
{
    while($produto = $resultado -> fetch_assoc())
    {   
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
        
        echo "Nome: " . $produto['nome'] . "<br>";

        echo "Preço: R$" . $produto['preco'] . "<br>";

        echo "Descrição: " . $produto['descricao'] . "<br>";

        echo "Tamanho: " . $produto['tamanho'] . "<br>";
        
        echo "<br>";

    }
}
?>