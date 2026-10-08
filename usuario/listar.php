<?php

session_start();

require_once "../conexao.php";

$mensagem = "";
$tipoMensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT nome, senha, id_usuario, root
            FROM usuario
            WHERE email = ?";

    $stmt = $conexao->prepare($sql);

    $stmt->bind_param("s", $email);

    $stmt->execute();

    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1)
    {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($senha, $usuario['senha']))
        {
            session_regenerate_id(true);

            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['root'] = $usuario['root'];

            header("Location: ../index.php");
            exit;
        }
        else
        {
            $mensagem = "Senha incorreta.";
            $tipoMensagem = "danger";
        }
    }
    else
    {
        $mensagem = "Usuário não encontrado.";
        $tipoMensagem = "danger";
    }

    $stmt->close();
}

$conexao->close();

?>

