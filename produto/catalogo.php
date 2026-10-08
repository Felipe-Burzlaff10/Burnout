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
    echo "<img width='20%' src='" . "../img_produto/" . $produto['foto'] . "'>";

    echo "Nome: " . $produto['nome'];

    echo "Preço: R$" . $produto['preco'];

    echo "<br>";
}

echo "</form>";

echo "</div>";
echo "<hr>";

$conexao->close();
?>