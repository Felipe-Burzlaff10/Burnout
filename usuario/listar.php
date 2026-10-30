<link rel="stylesheet" href="../CSS/usuario/listar.css">

<form method="GET">
    <input type="text" name="pesquisa">

    <button type="submit">Pesquisar</button>
</form>

<div>
<?php
session_start();

if ($_SESSION['dados']['root'] != 1)
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

echo "<th>Apagar</th>";

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


    <a
        href="../index.php"
        class="logout">

        <i class="bi bi-box-arrow-right"></i>
        Voltar

    </a>