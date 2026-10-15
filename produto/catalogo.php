<?php session_start(); ?>

<form method="GET">
    <input type="text" name="pesquisa">

    <button type="submit">Pesquisar</button>
</form>

  <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

<?php
require_once "../conexao.php";

$sql = "SELECT * FROM produto";
$resultado = ($conexao->query($sql));  

if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    if (isset($_GET['pesquisa']))
    {
        $pesquisa = "%" . $_GET['pesquisa'] . "%";

        $sql = "SELECT * FROM produto
                WHERE nome LIKE ?
                OR categoria LIKE ?";

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param('ss', $pesquisa, $pesquisa);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $stmt->close();
    }
}



echo "<form method='post' class='d-flex flex-wrap align-items-start p-2 bg-light'>";
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
    
    echo "Preço: R$" . $produto['preco'];
    
    echo "<br>";
    
    echo "<details>";
    
    echo "<summary>Ver mais</summary>";
    
    echo "Estoque: ". $produto['estoque']. "<br>";
    
    echo "Tamanho: ". $produto['tamanho']. "<br>";
    
    echo "Descrição: " . $produto['descrição']. "<br>";
    
    
    echo "Disponibilidade: " . $disponibilidade. "<br>";
    
    
    echo "</details>";
    
    echo "</div>";
}

echo "</form>";


$conexao->close();
?>