<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Cadastro</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <style>
        /* Estilo para o menu de navegação */
        .nav {
            background-color: #39bf00;
            padding: 10px 0;
        }

        .nav-link {
            color: black;
            font-weight: bold;
            font-size: 18px;
            text-transform: uppercase;
            margin: 0 15px;
        }

        .nav-link:hover {
            color: #ffffff;
        }

        .nav-link.active {
            border-bottom: 2px solid black;
        }
        </style>
    
    </head>
    <body>

    <!-- Bootstrap js -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    
    
     <header style="background-color: #39bf00; padding: 10px 20px 0;">

    <!-- Parte superior -->
    <div class="container-fluid">
        <div class="row align-items-center">

            <!-- Logo -->
            <div class="col-3">
                <img src="logo.png" alt="Logo Burnout" style="width: 170px;">
            </div>

            <!-- Título -->
            <div class="col-6 text-center">
                <h1 style="
                    font-family: Georgia, 'Times New Roman', serif;
                    font-size: 70px;
                    font-weight: bold;
                    margin: 0;
                    color: black;">
                    BURNOUT
                </h1>
            </div>

            <!-- Ícones e login -->
            <div class="col-3 d-flex justify-content-end align-items-center gap-3">

                <!-- Pesquisa -->
                <a href="pesquisa.php" style="color: black; font-size: 32px;">
                    <i class="bi bi-search"></i>
                </a>

                <!-- Carrinho -->
                <a href="carrinho.php" style="color: black; font-size: 32px;">
                    <i class="bi bi-cart3"></i>
                </a>

                <!-- Entrar -->
                <a href="login.php" style="color: black; text-decoration: none; display: flex; align-items: center; gap: 8px;">
            <i class="bi bi-person-circle" style="font-size: 38px;"></i>
                </a>
                <span style="font-weight: bold; font-size: 18px; line-height: 1.1;">
                    <a href="login.php" style="color: black;">entrar ou<br> cadastrar</a>  
                </span>

            </div>

        </div>
    </div>


    <!-- Menu de navegação -->
    <ul class="nav justify-content-center">
  <li class="nav-item">
    <a class="nav-link" aria-current="page" href="home.php">HOME</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="catalogo.php">CATALOGO</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="lancamentos.php">LANÇAMENTOS</a>
  </li>
  <li class="nav-item">
    <a class="nav-link disabled" aria-disabled="true">PINTO</a>
  </li>
</ul>

</header>
            
        <form action="" method="POST">

            <label for="email">Email: </label>
            <input type="email" name="email" required><br>

            <label for="senha">Senha: </label>
            <input type="password" name="senha" required><br>

            <input type="submit" value="Logar">

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
$banco = "burnout";

$conexao = new mysqli($host, $usuario, $senha, $banco);

if ($conexao->connect_error)
    die("Erro na conexão.");

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $sql = "SELECT nome, senha, id_usuario, root
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
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['root'] = $usuario['root'];

            header("Location: index.php");
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

$conexao->close();
?>