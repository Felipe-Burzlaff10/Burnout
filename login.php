<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Cadastro</title>
    </head>
    <body>
            
        <form action="" method="POST">

            <label for="email">Email: </label>
            <input type="email" name="email" required><br>

            <label for="senha">Senha: </label>
            <input type="password" name="senha" required><br>

            <input type="submit" value="Cadastrar">

        </form>

        <a href="logout.php">
            <button>Logout</button>
        </a>

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
    $sql = "SELECT nome, senha
            FROM usuario
            WHERE email = ?";
    
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('s', $_POST['email']);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $stmt->close();

    if ($resultado->num_rows == 1)
    {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($_POST['senha'], $usuario['senha']))
        {
            echo "Login efetuado com sucesso";

            session_start();
            $_SESSION['nome'] = $usuario['nome'];
        }
        else
        {
            echo "Senha incorreta";
        }
    }
    else
    {
        echo "Usuário não encontrado";
    }
}

print_r($_SESSION);

$conexao->close();
?>