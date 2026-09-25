<?php
session_start();

if (!isset($_SESSION['id_usuario']))
{
    echo "<script>window.location.href='index.php';</script>";
    exit();
}

echo '<script src="API_endereço.js"></script>';
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "burnout";

$conexao = new mysqli($host, $usuario, $senha, $banco);

if ($conexao->connect_error)
    die("Erro na conexão.");


if ($_SERVER["REQUEST_METHOD"] == "POST")
{
        $sql = "UPDATE usuario
                SET email = ?, senha = ?, endereco = ?
                WHERE id_usuario = ?";

        $endereco_final = "{$_POST['rua']}, Nº: {$_POST['num']}, {$_POST['bairro']} - {$_POST['cidade']}/{$_POST['uf']} CEP: {$_POST['cep']}";

        $senha = $_POST["senha"];
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param('sssi', $_POST['email'], $senha_hash, $endereco_final, $_SESSION['id_usuario']);
        $stmt->execute();
        $stmt->close();

    
}

?>

<form method="POST">

    <label for="email">Email: </label>
    <input type="email" name="email" required><br>

    <label for="senha">Senha: </label>
    <input type="password" name="senha" required><br>

    <label for="cep">CEP: </label>
    <input type="num" name="cep" id="cep" required>
    <button type="button" onclick="buscarEndereco()">Buscar Endereço</button><br>

    <label for="uf">UF: </label>
    <input type="text" name="uf" id="uf" required><br>

    <label for="bairro">Bairro: </label>
    <input type="text" name="bairro" id="bairro" required><br>

    <label for="cidade">Cidade: </label>
    <input type="text" name="cidade" id="cidade" required><br>

    <label for="rua">Rua: </label>
    <input type="text" name="rua" id="rua" required><br>

    <label for="num">Nº: </label>
    <input type="num" name="num" required><br>

    <input type="submit" value="Cadastrar">

</form>