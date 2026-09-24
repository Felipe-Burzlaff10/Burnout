<?php
session_start();

if ($_SESSION['root'] != 1)
{
    echo "<script>window.location.href='index.php';</script>";
    exit();
}

$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "burnout";

$conexao = new mysqli($host, $usuario, $senha, $banco);

$sql = "SELECT * FROM usuario";
$resultado = ($conexao->query($sql));

echo "<div class='d-flex p-2 bg-light'>";

echo "<form method='post'>";

while($usuario = $resultado -> fetch_assoc())
{
    foreach ($usuario as $key => $value)
    {
        if ($key == "root")
        {
            if ($usuario[$key] == 1)
                echo $key . ": True ";
            else
                echo $key . ": False ";
            
            continue;
        }

        echo  $key . ": " . htmlspecialchars($usuario[$key]) . " ";

    }

    if ($value)
    {
        echo "<br>";
        continue;
    }

    echo "<button type='submit' name='id_deletar' value='" . $usuario['id_usuario'] . "'>apagar</button><br>";
}

echo "</form>";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $sql = "DELETE FROM usuario
            WHERE id_usuario = ?;";
    
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('i', $_POST['id_deletar']);
    $stmt->execute();

    echo "<script>window.location.href='listar_users.php';</script>";
}

echo "</div>";
echo "<hr>";

$conexao->close();
?>