<form method="GET">
    <input type="text" name="pesquisa">

    <button type="submit">Pesquisar</button>
</form>

<?php
session_start();

if ($_SESSION['root'] != 1)
{
    echo "<script>window.location.href='../index.php';</script>";
    exit();
}

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

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (isset($_POST['id_apagar']))
    {
        $sql = "DELETE FROM produto
                WHERE id_produto = ?";

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param('i', $_POST['id_apagar']);
        $stmt->execute();
        $stmt->close();

        echo "<script>window.location.href='listar.php';</script>";
    }
}

echo "<div class='d-flex p-2 bg-light'>";

echo "<form method='post'>";

while($produto = $resultado -> fetch_assoc())
{
    echo "<br>";
    
    foreach ($produto as $key => $value)
    {
        echo  $key . ": " . htmlspecialchars($produto[$key]) . "<br>";
    }

    echo "<button type='submit' name='id_apagar' value='" . $produto['id_produto'] . "'>Apagar</button>";
}

echo "</form>";

echo "</div>";
echo "<hr>";

$conexao->close();
?>