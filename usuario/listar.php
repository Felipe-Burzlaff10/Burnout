<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        padding: 40px 20px;
        background: #f4f6f9;
        font-family: Arial, Helvetica, sans-serif;
        color: #2d3748;
    }

    /* Área de pesquisa */
    .pesquisa-container {
        max-width: 1100px;
        margin: 0 auto 25px auto;
        background: #ffffff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .pesquisa-container h1 {
        margin: 0 0 18px 0;
        font-size: 24px;
        color: #1a202c;
    }

    .pesquisa-form {
        display: flex;
        gap: 10px;
    }

    .pesquisa-form input {
        flex: 1;
        padding: 12px 15px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 15px;
        outline: none;
        transition: 0.2s;
    }

    .pesquisa-form input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    .pesquisa-form button {
        padding: 12px 22px;
        border: none;
        border-radius: 8px;
        background: #2563eb;
        color: white;
        font-size: 15px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.2s;
    }

    .pesquisa-form button:hover {
        background: #1d4ed8;
    }

    /* Lista */
    .usuarios-container {
        max-width: 1100px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .usuario-card {
        background: white;
        border-radius: 12px;
        padding: 22px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.07);
        border: 1px solid #e5e7eb;
        transition: 0.2s;
    }

    .usuario-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 20px rgba(0, 0, 0, 0.10);
    }

    .usuario-card .campo {
        padding: 8px 0;
        border-bottom: 1px solid #edf0f3;
        font-size: 14px;
    }

    .usuario-card .campo:last-of-type {
        border-bottom: none;
    }

    .usuario-card .campo strong {
        color: #374151;
    }

    .btn-apagar {
        width: 100%;
        margin-top: 18px;
        padding: 11px;
        border: none;
        border-radius: 8px;
        background: #dc2626;
        color: white;
        font-size: 14px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-apagar:hover {
        background: #b91c1c;
    }

    /* Responsividade */
    @media (max-width: 600px) {
        body {
            padding: 20px 12px;
        }

        .pesquisa-form {
            flex-direction: column;
        }

        .pesquisa-form button {
            width: 100%;
        }

        .usuarios-container {
            grid-template-columns: 1fr;
        }
    }
</style>
</head>
<body>

<form method="GET">
    <input type="text" name="pesquisa">

    <button type="submit">Pesquisar</button>
</form>
    
</body>
</html>

<?php
session_start();

if ($_SESSION['root'] != 1)
{
    echo "<script>window.location.href='../index.php';</script>";
    exit();
}

require_once "../conexao.php";

$sql = "SELECT * FROM usuario";
$resultado = ($conexao->query($sql));  

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