<?php
echo '<script src="API_endereço.js"></script>';
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "burnout";

$conexao = new mysqli($host, $usuario, $senha, $banco);

if ($conexao->connect_error)
    die("Erro na conexão.");


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