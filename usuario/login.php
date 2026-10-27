<?php
session_start();

if (isset($_SESSION['dados']['id_usuario']))
{
    echo "<script>window.location.href='../index.php';</script>";
    exit();
}

require_once "../conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $sql = "SELECT id_usuario, cpf, nome, senha, root
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
            $_SESSION['dados'] = [
                'cpf' => $usuario['cpf'],
                'email' => $_POST['email'],
                'nome' => $usuario['nome'],
                'id_usuario' => $usuario['id_usuario'],
                'root' => $usuario['root']
            ];
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

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - BURNOUT</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    

</head>

<link rel="stylesheet" href="../CSS/usuario/login.css">
<body>


    <!-- =========================
         HEADER
    ========================= -->

    <header class="header-auth">

        <div class="header-auth-conteudo">


            <!-- LOGO -->

            <a
                href="login.php"
                class="logo-link"
            >

                <img
                    src="../img_site/logo.png"
                    alt="Logo BURNOUT"
                    class="logo-auth"
                >

            </a>


            <!-- BURNOUT -->

            <div class="marca-auth">
                BURNOUT
            </div>


            <!-- ESPAÇO -->

            <div class="header-auth-direita"></div>

        </div>

    </header>



    <!-- =========================
         LOGIN
    ========================= -->

    <main class="area-login">

        <div class="card-login">


            <!-- CABEÇALHO -->

            <div class="cabecalho-login">

                <div class="icone-login">

                    <i class="bi bi-person-circle"></i>

                </div>


                <h1 class="titulo-login">
                    LOGIN
                </h1>


                <div class="linha-titulo"></div>


                <p class="subtitulo-login">
                    Entre na sua conta BURNOUT
                </p>

            </div>



            <!-- FORMULÁRIO -->

            <form action="" method="POST">


                <!-- EMAIL -->

                <div class="campo">

                    <label
                        for="email"
                        class="form-label"
                    >
                        E-mail
                    </label>

                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="form-control"
                        placeholder="Digite seu e-mail"
                        required
                    >

                </div>



                <!-- SENHA -->

                <div class="campo">

                    <label
                        for="senha"
                        class="form-label"
                    >
                        Senha
                    </label>

                    <input
                        type="password"
                        name="senha"
                        id="senha"
                        class="form-control"
                        placeholder="Digite sua senha"
                        required
                    >

                </div>



                <!-- BOTÃO -->

                <button
                    type="submit"
                    class="btn-login"
                >

                    <i class="bi bi-box-arrow-in-right"></i>

                    ENTRAR

                </button>

            </form>



            <!-- CADASTRO -->

            <div class="link-auth">

                <span>
                    Ainda não possui uma conta?
                </span>

                <a href="cadastro.php">
                    Cadastre-se
                </a>

            </div>

        </div>

    </main>


</body>

</html>