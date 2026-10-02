<?php
require_once "../conexao.php";

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

            echo "<script>window.location.href='../index.php';</script>";
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

         body {
        margin: 0;
        min-height: 100vh;
        background: linear-gradient(to bottom, #ffffff, #a8a8a8);
        font-family: Georgia, 'Times New Roman', serif;
    }

    .area-login {
        padding: 40px 0;
    }

    .card-login {
        background-color: #39bf00;
        border-radius: 20px;
        width: 600px;
        max-width: 90%;
        margin: 0 auto;
        padding: 20px 70px 35px 70px;
    }

    .titulo-login {
        font-family: Arial, sans-serif;
        font-size: 60px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 30px;
        color: black;
    }

    .form-label {
        font-size: 30px;
        font-weight: bold;
        margin-bottom: 0;
        color: black;
    }

    .form-control {
        background-color: transparent;
        border: none;
        border-bottom: 3px solid black;
        border-radius: 0;
        font-size: 22px;
        height: 45px;
        padding: 0 5px;
        color: black;
        box-shadow: none !important;
    }

    .form-control:focus {
        background-color: transparent;
        border-color: black;
        box-shadow: none;
    }

    .campo {
        margin-bottom: 25px;
    }

    .btn-login {
        display: block;
        margin: 30px auto 15px auto;
        background-color: black;
        color: white;
        border: none;
        border-radius: 20px;
        width: 245px;
        height: 75px;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 20px;
        font-weight: bold;
    }

    .btn-login:hover {
        background-color: #222;
        color: white;
    }

    .btn-cadastrar {
        display: block;
        margin: 10px auto 0 auto;
        background-color: transparent;
        color: black;
        border: 2px solid black;
        border-radius: 15px;
        width: 150px;
        height: 45px;
        font-weight: bold;
    }

    .btn-cadastrar:hover {
        background-color: black;
        color: white;
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
                    <img src="../img_site/logo.png" alt="Logo Burnout" style="width: 170px;">
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
            
        <div class="container-fluid area-login">

    <div class="card-login">

        <h1 class="titulo-login">
            LOGIN
        </h1>

        <form action="" method="POST">

            <!-- EMAIL -->
            <div class="campo">

                <label for="email" class="form-label">
                    Email
                </label>

                <input 
                    type="email" 
                    name="email" 
                    id="email"
                    class="form-control"
                    required
                >

            </div>


            <!-- SENHA -->
            <div class="campo">

                <label for="senha" class="form-label">
                    Senha
                </label>

                <input 
                    type="password" 
                    name="senha" 
                    id="senha"
                    class="form-control"
                    required
                >

            </div>


            <!-- LOGIN -->
            <button 
                type="submit" 
                class="btn btn-login"
            >
                LOGAR
            </button>

        </form>


        <!-- CADASTRO -->
        <a href="cadastro.php" class="text-decoration-none">

            <button 
                type="button" 
                class="btn btn-cadastrar"
            >
                Cadastrar?
            </button>

        </a>

    </div>

</div>

    </body>
</html>