<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Cadastro</title>
    </head>
    <body>
            
        <form action="" method="POST">

            <label for="nome">Nome: </label>
            <input type="text" name="nome" required><br>

            <label for="cpf">CPF: </label>
            <input type="number" name="cpf" required><br>

            <label for="email">Email: </label>
            <input type="email" name="email" required><br>

            <label for="senha">Senha: </label>
            <input type="password" name="senha" required><br>

            <label for="cep">CEP: </label>
            <input type="num" name="cep" required><br>

            <label for="num">Nº: </label>
            <input type="num" name="num" required><br>

            <label for="logradouro">Logradouro: </label>
            <input type="text" name="logradouro" required><br>

            <label for="bairro">Bairro: </label>
            <input type="text" name="bairro" required><br>

            <input type="submit" value="Cadastrar">

        </form>

    </body>
</html>

<?php

$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "burnout";

$conexao = new mysqli($host, $usuario, $senha, $banco);

if ($conexao->connect_error)
    die("Erro na conexão.");

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $sql = "SELECT id_usuario
            FROM usuario
            WHERE email = ? OR cpf = ?";
    
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('ss', $_POST['email'],  $_POST['cpf']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0)
    {
        $stmt->close();

        echo "Deu erro pae!";
    }
    else
    {
        $stmt->close();

        $cep = $_POST['cep'];
        $url = "https://viacep.com.br/ws/" . $cep . "/json/";

        $endereco = file_get_contents($url);
        $endereco_decode = json_decode($endereco, true);

        if (!$endereco_decode['logradouro'])
            $endereco_decode['logradouro'] = $_POST['logradouro'];

        if (!$endereco_decode['bairro'])
            $endereco_decode['bairro'] = $_POST['bairro'];

        $endereco_final = "{$endereco_decode['logradouro']}, Nº: {$_POST['num']}, {$endereco_decode['bairro']} - {$endereco_decode['localidade']}/{$endereco_decode['uf']} CEP: {$endereco_decode['cep']}";

        $sql = "INSERT INTO usuario(cpf, nome, email, senha, endereco)
        VALUES (?, ?, ?, ?, ?)";

        $senha = $_POST["senha"];
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param('sssss', $_POST['cpf'], $_POST['nome'], $_POST['email'], $senha_hash, $endereco_final);
        $stmt->execute();
        $stmt->close();
    }
}

$conexao->close();
?>