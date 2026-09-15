<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Cadastro</title>
    </head>
    <body>

        <form action="" method="POST">

            <label for="nome">Nome: </label>
            <input type="text" name="nome"><br>

            <label for="cpf">CPF: </label>
            <input type="number" name="cpf"><br>

            <label for="email">Email: </label>
            <input type="email" name="email"><br>

            <label for="senha">Senha: </label>
            <input type="password" name="senha"><br>

            <label for="cep">CEP: </label>
            <input type="text" name="cep"><br>

            <input type="submit" value="Cadastrar">

        </form>

    </body>
</html>

<?php
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "trabalho";

$conexao = new mysqli($host, $usuario, $senha, $banco);

if ($conexao->connect_error)
    die("Erro na conexão.");

if ($_SERVER["REQUEST_METHOD"] == "POST")
{

    $cep = $_POST['cep'];
    $url = "https://viacep.com.br/ws/" . $cep . "/json/";

    $endereco = file_get_contents($url);
    $endereco_decode = json_decode($endereco, true);

    echo $endereco_decode['cep'];

    $endereco_final = $endereco_decode['logradouro'] . $endereco_decode['bairro'] . $endereco_decode['localidade'] . $endereco_decode['uf'] . $endereco_decode['cep'];


    $sql = "INSERT INTO usuario(nome, cpf, email, senha, endereco)
    VALUES (?, ?, ?, ?, ?) ";


    $senha = $_POST["senha"];
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    //consulta com segurança
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('sisss', $_POST['nome'], $_POST['cpf'], $_POST['email'], $senha_hash, $endereco_final);
    $stmt->execute();
    $stmt->close();
}

$conexao->close();

?>