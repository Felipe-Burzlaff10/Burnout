<?php
function validaCPF($cpf)
{
    $cpf = preg_replace('/[^0-9]/is', '', $cpf);
     
    if (strlen($cpf) != 11)
        return false;
     
    if (preg_match('/(\d)\1{10}/', $cpf))
        return false;
     
    for ($t = 9; $t < 11; $t++) 
    {
        for ($d = 0, $c = 0; $c < $t; $c++) 
        {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d)
            return false;
    }
    
    return true;
}

require_once "../conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    foreach ($_POST as $key => $value)
    {
        if (!$value)
            echo "Preencha o campo {$key}!<br>";
    }

    if (!validaCPF($_POST['cpf']))
        die("CPF INVALIDO");

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
        die("Deu erro");
    }

    $stmt->close();

    $endereco_final = "{$_POST['rua']}, Nº: {$_POST['num']}, {$_POST['bairro']} - {$_POST['cidade']}/{$_POST['uf']} CEP: {$_POST['cep']}";

    $sql = "INSERT INTO usuario(cpf, nome, email, senha, endereco)
    VALUES (?, ?, ?, ?, ?)";

    $senha = $_POST["senha"];
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('sssss', $_POST['cpf'], $_POST['nome'], $_POST['email'], $senha_hash, $endereco_final);
    $stmt->execute();
    $stmt->close();

    echo "<script>window.location.href='login.php';</script>";
}

$conexao->close();
?>

```html
<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastro - BURNOUT</title>

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

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #ffffff 0%, #eeeeee 50%, #cfcfcf 100%);
            font-family: Georgia, 'Times New Roman', serif;
            color: black;
        }


        /* =========================
           HEADER
        ========================= */

        header {
            background-color: #39bf00;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.20);
            position: relative;
            z-index: 10;
        }


        .header-top {
            min-height: 120px;
            padding: 15px 35px;
        }


        .logo {
            width: 150px;
            max-width: 100%;
        }


        .logo-area {
            display: flex;
            align-items: center;
        }


        .titulo-site {
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 65px;
            font-weight: bold;
            margin: 0;
            letter-spacing: 2px;
        }


        /* =========================
           ÍCONES DO HEADER
        ========================= */

        .acoes-header {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 22px;
        }


        .icone-header {
            color: black;
            text-decoration: none;
            font-size: 30px;
            transition: 0.2s;
        }


        .icone-header:hover {
            transform: translateY(-2px);
            color: white;
        }


        .login-header {
            display: flex;
            align-items: center;
            gap: 8px;
            color: black;
            text-decoration: none;
            font-weight: bold;
            font-size: 16px;
            line-height: 1.1;
            transition: 0.2s;
        }


        .login-header i {
            font-size: 38px;
        }


        .login-header:hover {
            color: white;
        }


        /* =========================
           MENU
        ========================= */

        .menu {
            background-color: #000000;
            padding: 0;
        }


        .menu .nav-link {
            color: white;
            font-size: 17px;
            font-weight: bold;
            letter-spacing: 1px;
            padding: 14px 28px;
            transition: 0.2s;
        }


        .menu .nav-link:hover {
            background-color: #39bf00;
            color: black;
        }


        .menu .nav-link.active {
            background-color: #39bf00;
            color: black;
        }


        /* =========================
           ÁREA PRINCIPAL
        ========================= */

        .area-cadastro {
            padding: 45px 20px 60px;
        }


        /* =========================
           CARD
        ========================= */

        .card-cadastro {
            background-color: #39bf00;
            width: 900px;
            max-width: 100%;
            margin: auto;
            padding: 35px 55px 45px;
            border-radius: 25px;

            box-shadow:
                0 15px 35px rgba(0, 0, 0, 0.25);

            border: 2px solid rgba(0, 0, 0, 0.15);
        }


        /* =========================
           CABEÇALHO DO FORMULÁRIO
        ========================= */

        .cabecalho-cadastro {
            text-align: center;
            margin-bottom: 35px;
        }


        .titulo-cadastro {
            font-family: Arial, sans-serif;
            font-size: 52px;
            font-weight: 900;
            margin: 0;
            letter-spacing: 1px;
        }


        .subtitulo {
            font-family: Arial, sans-serif;
            font-size: 16px;
            margin-top: 5px;
            opacity: 0.75;
            font-weight: bold;
        }


        .linha-titulo {
            width: 80px;
            height: 5px;
            background-color: black;
            margin: 15px auto 0;
            border-radius: 10px;
        }


        /* =========================
           CAMPOS
        ========================= */

        .campo {
            margin-bottom: 22px;
        }


        .form-label {
            display: block;
            font-family: Arial, sans-serif;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 7px;
        }


        .form-control {
            height: 50px;
            background-color: rgba(255, 255, 255, 0.35);
            border: 2px solid transparent;
            border-radius: 10px;
            font-family: Arial, sans-serif;
            font-size: 17px;
            padding: 10px 15px;
            color: black;
            transition: 0.2s;
        }


        .form-control::placeholder {
            color: #444;
        }


        .form-control:hover {
            background-color: rgba(255, 255, 255, 0.5);
        }


        .form-control:focus {
            background-color: white;
            border-color: black;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.10);
        }


        /* =========================
           CEP
        ========================= */

        .cep-area {
            display: flex;
            gap: 10px;
        }


        .cep-area .form-control {
            flex: 1;
        }


        .btn-cep {
            height: 50px;
            padding: 0 20px;
            background-color: black;
            color: white;
            border: none;
            border-radius: 10px;
            font-family: Arial, sans-serif;
            font-weight: bold;
            transition: 0.2s;
        }


        .btn-cep:hover {
            background-color: #222;
            transform: translateY(-1px);
        }


        /* =========================
           DIVISOR
        ========================= */

        .divisor {
            border: 0;
            border-top: 2px solid rgba(0, 0, 0, 0.25);
            margin: 10px 0 25px;
        }


        .titulo-endereco {
            font-family: Arial, sans-serif;
            font-size: 21px;
            font-weight: 900;
            margin-bottom: 20px;
        }


        .titulo-endereco i {
            margin-right: 7px;
        }


        /* =========================
           BOTÃO CADASTRAR
        ========================= */

        .btn-cadastrar {
            display: block;
            width: 280px;
            height: 60px;
            margin: 25px auto 0;

            background-color: black;
            color: white;

            border: none;
            border-radius: 12px;

            font-family: Arial, sans-serif;
            font-size: 18px;
            font-weight: 900;
            letter-spacing: 1px;

            transition: 0.25s;
        }


        .btn-cadastrar i {
            margin-right: 8px;
        }


        .btn-cadastrar:hover {
            background-color: #222;
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.25);
        }


        /* =========================
           RODAPÉ DO FORMULÁRIO
        ========================= */

        .aviso {
            text-align: center;
            font-family: Arial, sans-serif;
            font-size: 13px;
            margin-top: 18px;
            opacity: 0.7;
        }


        /* =========================
           RESPONSIVIDADE
        ========================= */

        @media (max-width: 992px) {

            .titulo-site {
                font-size: 48px;
            }

            .logo {
                width: 120px;
            }

            .acoes-header {
                gap: 12px;
            }

            .icone-header {
                font-size: 25px;
            }

            .login-header i {
                font-size: 32px;
            }

        }


        @media (max-width: 768px) {

            .header-top {
                padding: 15px;
            }

            .logo-area {
                justify-content: center;
                margin-bottom: 10px;
            }

            .titulo-site {
                font-size: 42px;
                text-align: center;
            }

            .acoes-header {
                justify-content: center;
                margin-top: 10px;
            }

            .menu .nav-link {
                padding: 12px 10px;
                font-size: 14px;
            }

            .card-cadastro {
                padding: 30px 25px 35px;
            }

            .titulo-cadastro {
                font-size: 40px;
            }

        }


        @media (max-width: 500px) {

            .titulo-site {
                font-size: 34px;
            }

            .logo {
                width: 100px;
            }

            .menu .nav {
                flex-wrap: wrap;
            }

            .menu .nav-link {
                font-size: 12px;
                padding: 10px 8px;
            }

            .titulo-cadastro {
                font-size: 34px;
            }

            .form-label {
                font-size: 16px;
            }

            .cep-area {
                flex-direction: column;
            }

            .btn-cep {
                width: 100%;
            }

            .btn-cadastrar {
                width: 100%;
            }

        }

    </style>

</head>


<body>


    <!-- =========================
         HEADER
    ========================= -->

    <header>

        <div class="header-top">

            <div class="container-fluid">

                <div class="row align-items-center">

                    <!-- LOGO -->

                    <div class="col-lg-3 col-md-3 col-12">

                        <div class="logo-area">

                            <img
                                src="logo.png"
                                alt="Logo BURNOUT"
                                class="logo"
                            >

                        </div>

                    </div>


                    <!-- TÍTULO -->

                    <div class="col-lg-6 col-md-6 col-12">

                        <h1 class="titulo-site">
                            BURNOUT
                        </h1>

                    </div>


                    <!-- AÇÕES -->

                    <div class="col-lg-3 col-md-3 col-12">

                        <div class="acoes-header">

                            <a
                                href="pesquisa.php"
                                class="icone-header"
                                title="Pesquisar"
                            >
                                <i class="bi bi-search"></i>
                            </a>


                            <a
                                href="carrinho.php"
                                class="icone-header"
                                title="Carrinho"
                            >
                                <i class="bi bi-cart3"></i>
                            </a>


                            <a
                                href="login.php"
                                class="login-header"
                            >

                                <i class="bi bi-person-circle"></i>

                                <span>
                                    entrar ou<br>
                                    cadastrar
                                </span>

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- MENU -->

        <nav class="menu">

            <ul class="nav justify-content-center">

                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="home.php"
                    >
                        HOME
                    </a>

                </li>


                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="catalogo.php"
                    >
                        CATÁLOGO
                    </a>

                </li>


                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="lancamentos.php"
                    >
                        LANÇAMENTOS
                    </a>

                </li>


                <li class="nav-item">

                    <a
                        class="nav-link disabled"
                        aria-disabled="true"
                    >
                        PINTO
                    </a>

                </li>

            </ul>

        </nav>

    </header>



    <!-- =========================
         CADASTRO
    ========================= -->

    <main class="area-cadastro">

        <div class="card-cadastro">


            <!-- CABEÇALHO -->

            <div class="cabecalho-cadastro">

                <h1 class="titulo-cadastro">
                    CADASTRO
                </h1>

                <div class="linha-titulo"></div>

                <p class="subtitulo">
                    Crie sua conta BURNOUT
                </p>

            </div>



            <!-- FORMULÁRIO -->

            <form method="POST">


                <!-- DADOS PESSOAIS -->

                <div class="row">

                    <!-- NOME -->

                    <div class="col-md-6">

                        <div class="campo">

                            <label
                                for="nome"
                                class="form-label"
                            >
                                Nome
                            </label>

                            <input
                                type="text"
                                name="nome"
                                id="nome"
                                class="form-control"
                                placeholder="Digite seu nome"
                                required
                            >

                        </div>

                    </div>


                    <!-- CPF -->

                    <div class="col-md-6">

                        <div class="campo">

                            <label
                                for="cpf"
                                class="form-label"
                            >
                                CPF
                            </label>

                            <input
                                type="text"
                                name="cpf"
                                id="cpf"
                                class="form-control"
                                maxlength="11"
                                placeholder="Digite seu CPF"
                                required
                            >

                        </div>

                    </div>


                    <!-- EMAIL -->

                    <div class="col-md-6">

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
                                placeholder="seuemail@email.com"
                                required
                            >

                        </div>

                    </div>


                    <!-- SENHA -->

                    <div class="col-md-6">

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

                    </div>

                </div>



                <!-- DIVISOR -->

                <hr class="divisor">


                <!-- ENDEREÇO -->

                <div class="titulo-endereco">

                    <i class="bi bi-geo-alt-fill"></i>

                    Endereço

                </div>



                <div class="row">


                    <!-- CEP -->

                    <div class="col-md-6">

                        <div class="campo">

                            <label
                                for="cep"
                                class="form-label"
                            >
                                CEP
                            </label>

                            <div class="cep-area">

                                <input
                                    type="text"
                                    name="cep"
                                    id="cep"
                                    class="form-control"
                                    maxlength="8"
                                    placeholder="00000000"
                                    required
                                >

                                <button
                                    type="button"
                                    class="btn-cep"
                                    onclick="buscarEndereco()"
                                >
                                    <i class="bi bi-search"></i>
                                    Buscar
                                </button>

                            </div>

                        </div>

                    </div>


                    <!-- UF -->

                    <div class="col-md-6">

                        <div class="campo">

                            <label
                                for="uf"
                                class="form-label"
                            >
                                UF
                            </label>

                            <input
                                type="text"
                                name="uf"
                                id="uf"
                                class="form-control"
                                maxlength="2"
                                placeholder="RS"
                                required
                            >

                        </div>

                    </div>


                    <!-- BAIRRO -->

                    <div class="col-md-6">

                        <div class="campo">

                            <label
                                for="bairro"
                                class="form-label"
                            >
                                Bairro
                            </label>

                            <input
                                type="text"
                                name="bairro"
                                id="bairro"
                                class="form-control"
                                placeholder="Digite seu bairro"
                                required
                            >

                        </div>

                    </div>


                    <!-- CIDADE -->

                    <div class="col-md-6">

                        <div class="campo">

                            <label
                                for="cidade"
                                class="form-label"
                            >
                                Cidade
                            </label>

                            <input
                                type="text"
                                name="cidade"
                                id="cidade"
                                class="form-control"
                                placeholder="Digite sua cidade"
                                required
                            >

                        </div>

                    </div>


                    <!-- RUA -->

                    <div class="col-md-8">

                        <div class="campo">

                            <label
                                for="rua"
                                class="form-label"
                            >
                                Rua
                            </label>

                            <input
                                type="text"
                                name="rua"
                                id="rua"
                                class="form-control"
                                placeholder="Digite sua rua"
                                required
                            >

                        </div>

                    </div>


                    <!-- NÚMERO -->

                    <div class="col-md-4">

                        <div class="campo">

                            <label
                                for="num"
                                class="form-label"
                            >
                                Número
                            </label>

                            <input
                                type="text"
                                name="num"
                                id="num"
                                class="form-control"
                                placeholder="Nº"
                                required
                            >

                        </div>

                    </div>

                </div>



                <!-- BOTÃO -->

                <button
                    type="submit"
                    class="btn-cadastrar"
                >

                    <i class="bi bi-person-plus-fill"></i>

                    CADASTRAR

                </button>


                <p class="aviso">
                    Ao cadastrar, você poderá acessar sua conta e realizar compras na BURNOUT.
                </p>

            </form>

        </div>

    </main>



    <!-- Bootstrap JS -->

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    ></script>


    <!-- API de endereço -->

    <script src="../API_endereço.js"></script>


</body>

</html>