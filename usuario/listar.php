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
        padding: 0;
        background: linear-gradient(to bottom, #ffffff 0%, #ffffff 25%, #b3b3b3 100%);
        font-family: Georgia, "Times New Roman", serif;
        color: #000;
        min-height: 100vh;
    }

    /* ÁREA DA PESQUISA */
    body > form {
        width: 740px;
        margin: 35px auto 25px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    body > form input[type="text"] {
        flex: 1;
        height: 48px;
        border: none;
        border-bottom: 3px solid #000;
        background: transparent;
        outline: none;
        font-family: Georgia, "Times New Roman", serif;
        font-size: 22px;
        font-weight: bold;
        color: #000;
    }

    body > form input[type="text"]::placeholder {
        color: #000;
        opacity: 1;
    }

    body > form button {
        height: 48px;
        padding: 0 28px;
        border: none;
        border-radius: 12px;
        background: #000;
        color: #fff;
        font-family: Georgia, "Times New Roman", serif;
        font-size: 17px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.2s;
    }

    body > form button:hover {
        background: #222;
        transform: scale(1.03);
    }

    /* CONTAINER DOS USUÁRIOS */
    .usuarios-container {
        width: 740px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    /* FORM DO BOTÃO APAGAR */
    .usuarios-container > form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    /* CARD DO USUÁRIO */
    .usuario-card {
        background: #22c900;
        border-radius: 22px;
        padding: 25px 45px 30px;
        box-shadow: none;
        border: none;
    }

    .usuario-card .campo {
        font-size: 20px;
        font-weight: bold;
        padding: 9px 0;
        border-bottom: 3px solid #000;
        width: 100%;
    }

    .usuario-card .campo strong {
        font-weight: bold;
    }

    /* BOTÃO APAGAR */
    .btn-apagar {
        display: block;
        width: 245px;
        height: 65px;
        margin: 25px auto 0;

        border: none;
        border-radius: 20px;

        background: #000;
        color: #fff;

        font-family: Georgia, "Times New Roman", serif;
        font-size: 19px;
        font-weight: bold;

        cursor: pointer;
        transition: 0.2s;
    }

    .btn-apagar:hover {
        background: #222;
        transform: scale(1.03);
    }

    /* REMOVE A LINHA FINAL */
    hr {
        width: 740px;
        margin: 35px auto;
        border: none;
        border-top: 3px solid #000;
    }

    /* RESPONSIVO */
    @media (max-width: 800px) {

        body > form {
            width: 90%;
            flex-direction: column;
            align-items: stretch;
        }

        body > form button {
            width: 100%;
        }

        .usuarios-container {
            width: 90%;
        }

        .usuario-card {
            padding: 22px 25px 28px;
        }

        hr {
            width: 90%;
        }
    }

    @media (max-width: 500px) {

        body {
            padding-bottom: 30px;
        }

        .usuario-card .campo {
            font-size: 16px;
        }

        .btn-apagar {
            width: 100%;
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