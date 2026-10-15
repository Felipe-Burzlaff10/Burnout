<form method="GET">
    <input type="text" name="pesquisa">

    <button type="submit">Pesquisar</button>
</form>


<?php
session_start();

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



echo "<div class='d-flex p-2 bg-light'>";

echo "<form method='post'>";
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
    
    echo "<div class='card' style='$estilo'>";
    
    echo "<img width='20%' src='" . "../img_produto/" . $produto['foto'] . "'><br>";
    
    echo "</div>";
    echo "Nome: " . $produto['nome'] . "<br>";
    
    echo "Preço: R$" . $produto['preco'];
    
    echo "<br>";
    
    echo "<details>";
    
    echo "<summary>Ver mais</summary>";
    
    echo " Estoque: ". $produto['estoque']. "<br>";
    
    echo " Tamanho: ". $produto['tamanho']. "<br>";
    
    echo "Descrição: " . $produto['descrição']. "<br>";

    
    echo "Disponibilidade: " . $disponibilidade. "<br>";
    

    echo "</details>";

}

echo "</form>";

echo "</div>";

$conexao->close();
?>