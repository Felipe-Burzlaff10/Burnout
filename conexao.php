<?php
$host = "localhost";
$usuario = "root";
$senha = "m!gu3l0501";
$banco = "burnout";

$conexao = new mysqli($host, $usuario, $senha, $banco);

if ($conexao->connect_error)
    die("Erro na conexão.");
?>