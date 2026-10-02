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


if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    if (isset($_GET['pesquisa']))
    {
        $pesquisa = "%" . $_GET['pesquisa'] . "%";

        $sql = "SELECT * FROM usuario
                WHERE nome LIKE ?
                OR cpf LIKE ?";

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param('ss', $pesquisa, $pesquisa);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $stmt->close();
    }
    else
    {
        $sql = "SELECT * FROM usuario";
        $resultado = ($conexao->query($sql));  
    }

}

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (isset($_POST['id_apagar']))
    {
        $sql = "DELETE FROM usuario
                WHERE id_usuario = ?";

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param('i', $_POST['id_apagar']);
        $stmt->execute();
        $stmt->close();

        echo "<script>window.location.href='listar.php';</script>";
    }
}

echo "<div class='d-flex p-2 bg-light'>";

echo "<form method='post'>";

while($usuario = $resultado -> fetch_assoc())
{
    echo "<br>";
    
    foreach ($usuario as $key => $value)
    {
        if ($key == "root")
        {
            if ($usuario[$key])
                echo $key . ": True<br>";
            else
                echo $key . ": False<br>";
            
            continue;
        }

        echo  $key . ": " . htmlspecialchars($usuario[$key]) . "<br>";

    }

    if ($usuario['root'])
        continue;

    echo "<button type='submit' name='id_apagar' value='" . $usuario['id_usuario'] . "'>Apagar</button>";
}

echo "</form>";

echo "</div>";
echo "<hr>";

$conexao->close();
?>