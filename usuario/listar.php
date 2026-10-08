<style>
    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        min-height: 100vh;
        padding: 30px 20px;

        background: linear-gradient(
            to bottom,
            #ffffff 0%,
            #ffffff 25%,
            #b3b3b3 100%
        );

        font-family: Georgia, "Times New Roman", serif;
        color: #000;
    }

    /* FORMULÁRIO DE PESQUISA */
    body > form {
        width: 90%;
        max-width: 1100px;
        margin: 0 auto 20px;

        display: flex;
        gap: 10px;
    }

    body > form input[type="text"] {
        flex: 1;
        height: 48px;

        padding: 10px 15px;

        border: 3px solid #000;
        border-radius: 12px;

        background: #fff;

        font-family: Georgia, "Times New Roman", serif;
        font-size: 17px;
        font-weight: bold;

        outline: none;
    }

    body > form input[type="text"]:focus {
        background: #f1f1f1;
    }

    body > form button {
        width: 160px;
        height: 48px;

        border: none;
        border-radius: 12px;

        background: #000;
        color: #fff;

        font-family: Georgia, "Times New Roman", serif;
        font-size: 16px;
        font-weight: bold;

        cursor: pointer;
        transition: 0.2s;
    }

    body > form button:hover {
        background: #222;
        transform: scale(1.03);
    }

    /* DIV QUE ENVOLVE O PHP */
    div {
        width: 90%;
        max-width: 1100px;
        margin: 30px auto;

<<<<<<< HEAD
=======
        border-radius: 22px;

>>>>>>> d6b96adb486a6aab524cc709e5c8b37e098d65c5
        font-family: Georgia, "Times New Roman", serif;
        color: #000;

        overflow-x: auto;
    }

    /* TABELA */
    table {
        width: 100%;
        border-collapse: collapse;

        background: #fff;

        border: 3px solid #000;
        border-radius: 12px;
        overflow: hidden;

        font-size: 15px;
    }

    /* CABEÇALHO */
    th {
        padding: 14px 10px;

        background: #000;
        color: #fff;

        border: 2px solid #000;

        font-size: 16px;
        font-weight: bold;
        text-align: center;
    }

    /* CÉLULAS */
    td {
        padding: 12px 10px;

        border: 1px solid #000;

        background: #fff;

        text-align: center;
        vertical-align: middle;

        font-weight: bold;
    }

    /* LINHAS ALTERNADAS */
    tr:nth-child(even) td {
        background: #eeeeee;
    }

    /* EFEITO AO PASSAR O MOUSE */
    tr:hover td {
        background: #d9ffd2;
    }

    /* FORM DOS BOTÕES DE APAGAR */
    div form {
        width: 100%;
        margin: 0;
        padding: 0;
    }

    /* BOTÃO APAGAR */
    div button {
        width: 110px;
        height: 40px;

        margin: 0;

        border: none;
        border-radius: 10px;

        background: #000;
        color: #fff;

        font-family: Georgia, "Times New Roman", serif;
        font-size: 14px;
        font-weight: bold;

        cursor: pointer;
        transition: 0.2s;
    }

    div button:hover {
        background: #b00000;
        transform: scale(1.03);
    }

    /* LINHA SEPARADORA */
    div hr {
        border: none;
        border-top: 3px solid #000;
        margin-top: 25px;
    }

    /* RESPONSIVO */
    @media (max-width: 700px) {

        body {
            padding: 20px 10px;
        }

        body > form {
            width: 100%;
        }

        body > form button {
            width: 120px;
        }

        div {
            width: 100%;
            padding: 15px;
        }

        table {
            min-width: 850px;
        }
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

echo "<form method='post'>";

echo "<table>";

echo "<tr>";

echo "<th>Id</th>";

echo "<th>Nome</th>";

echo "<th>CPF</th>";

echo "<th>Email</th>";

echo "<th>Senha</th>";

echo "<th>Endereço</th>";

echo "<th>Root</th>";

echo "</tr>";

while($usuario = $resultado -> fetch_assoc())
{
    echo "<tr>";
    
    foreach ($usuario as $key => $value)
    {
        echo "<td>" . htmlspecialchars($usuario[$key]) . "</td>";
    }

    if ($usuario['root'])
        continue;

    echo "<td><button type='submit' name='id_apagar' value='" . $usuario['id_usuario'] . "'>Apagar</button></td>";

    echo "</tr>";
}

echo "</table>";

echo "</form>";


$conexao->close();
?>

</div>