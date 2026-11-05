<?php
session_start();
require_once "../conexao.php";

$sql = "SELECT * FROM usuario
        WHERE id_usuario = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param('i', $_SESSION['dados']['id_usuario']);
$stmt->execute();
$resultado = $stmt->get_result();
$stmt->close();
$usuario = $resultado -> fetch_assoc();
  
echo "Nome: " . $usuario['nome'] . "<br>";
echo "CPF: " . $usuario['cpf'] . "<br>";
echo "Email: " . $usuario['email'] . "<br>";
echo "Senha: " . str_repeat("*", strlen($usuario['senha'])) . "<br>";
echo "Endereço: " . $usuario['endereco'] . "<br>";

$conexao->close();
?>

<a href="../index.php">
        <button type="button" class="btn-voltar">
        ← Voltar
        </button>
    </a>