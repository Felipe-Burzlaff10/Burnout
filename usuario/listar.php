<style>
    /* DIV QUE ENVOLVE O PHP */
    div {
        width: 90%;
        max-width: 1100px;
        margin: 30px auto;
        padding: 25px;

        background: #22c900;
        border-radius: 22px;

        font-family: Georgia, "Times New Roman", serif;
        color: #000;

        box-shadow: none;
    }

    /* FORM DOS BOTÕES DE APAGAR */
    div form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    /* INFORMAÇÕES DOS USUÁRIOS */
    div br {
        line-height: 10px;
    }

    /* BOTÃO APAGAR */
    div button {
        width: 180px;
        height: 50px;

        margin: 10px auto 20px;

        border: none;
        border-radius: 15px;

        background: #000;
        color: #fff;

        font-family: Georgia, "Times New Roman", serif;
        font-size: 17px;
        font-weight: bold;

        cursor: pointer;
        transition: 0.2s;
    }

    div button:hover {
        background: #222;
        transform: scale(1.03);
    }

    /* LINHA SEPARADORA */
    div hr {
        border: none;
        border-top: 3px solid #000;
        margin-top: 25px;
    }
</style>

<form method="GET">
    <input type="text" name="pesquisa">

    <button type="submit">Pesquisar</button>
</form>

<div>
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

</div>