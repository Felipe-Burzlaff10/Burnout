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
                echo $key . ": True<br>";
            else
                echo $key . ": False<br>";
            
            continue;
        }

        echo  $key . ": " . htmlspecialchars($usuario[$key]) . "<br>";

    }

    echo "<input type='submit' value='" . $usuario['id_usuario'] . "'>";
}

echo "</form>";

echo "</div>";
echo "<hr>";

$conexao->close();
?>

 <!-- Importação do CSS do Bootstrap -->
    <link href="https://jsdelivr.net" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
 <script src="https://jsdelivr.net" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>