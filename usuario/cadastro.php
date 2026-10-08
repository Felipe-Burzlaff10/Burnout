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


        /* =========================
           BODY
        ========================= */

        body {
            margin: 0;
            min-height: 100vh;

            background: linear-gradient(
                135deg,
                #ffffff 0%,
                #eeeeee 50%,
                #cfcfcf 100%
            );

            font-family: Georgia, 'Times New Roman', serif;
            color: black;
        }


        /* =========================
           HEADER
        ========================= */

        .header-auth {
            width: 100%;
            height: 100px;

            background-color: #39bf00;

            border-bottom: 2px solid black;

            display: flex;
            align-items: center;

            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
        }


        .header-auth-conteudo {
            width: 100%;

            display: grid;
            grid-template-columns: 1fr 1fr 1fr;

            align-items: center;

            padding: 0 35px;
        }


        /* LOGO */

        .logo-link {
            display: flex;
            align-items: center;

            width: fit-content;

            text-decoration: none;
        }


        .logo-auth {
            width: 115px;

            display: block;
        }


        /* NOME BURNOUT */

        .marca-auth {
            text-align: center;

            font-family: Georgia, 'Times New Roman', serif;

            font-size: 48px;

            font-weight: bold;

            letter-spacing: 2px;

            color: black;
        }


        /* LADO DIREITO */

        .header-auth-direita {
            min-height: 1px;
        }


        /* =========================
           ÁREA DO CADASTRO
        ========================= */

        .area-cadastro {
            padding: 40px 20px 60px;
        }


        /* =========================
           CARD
        ========================= */

        .card-cadastro {
            width: 850px;
            max-width: 100%;

            margin: auto;

            background-color: #39bf00;

            padding: 35px 55px 40px;

            border-radius: 22px;

            border: 2px solid rgba(0, 0, 0, 0.15);

            box-shadow:
                0 15px 35px rgba(0, 0, 0, 0.22);
        }


        /* =========================
           CABEÇALHO
        ========================= */

        .cabecalho-cadastro {
            text-align: center;

            margin-bottom: 30px;
        }


        .icone-cadastro {
            font-size: 48px;

            margin-bottom: 8px;
        }


        .titulo-cadastro {
            font-family: Arial, sans-serif;

            font-size: 48px;

            font-weight: 900;

            margin: 0;

            letter-spacing: 1px;
        }


        .linha-titulo {
            width: 65px;
            height: 5px;

            background-color: black;

            margin: 13px auto;

            border-radius: 10px;
        }


        .subtitulo-cadastro {
            font-family: Arial, sans-serif;

            font-size: 15px;

            font-weight: bold;

            opacity: 0.7;

            margin: 0;
        }


        /* =========================
           CAMPOS
        ========================= */

        .campo {
            margin-bottom: 20px;
        }


        .form-label {
            display: block;

            font-family: Arial, sans-serif;

            font-size: 18px;

            font-weight: bold;

            margin-bottom: 7px;
        }


        .form-control {
            width: 100%;

            height: 50px;

            background-color: rgba(255, 255, 255, 0.4);

            border: 2px solid transparent;

            border-radius: 10px;

            font-family: Arial, sans-serif;

            font-size: 16px;

            padding: 10px 15px;

            color: black;

            box-shadow: none !important;

            transition: 0.2s;
        }


        .form-control:hover {
            background-color: rgba(255, 255, 255, 0.6);
        }


        .form-control:focus {
            background-color: white;

            border-color: black;

            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.10) !important;
        }


        /* =========================
           ENDEREÇO
        ========================= */

        .titulo-endereco {
            display: flex;
            align-items: center;

            gap: 8px;

            font-family: Arial, sans-serif;

            font-size: 20px;

            font-weight: 900;

            margin: 10px 0 20px;
        }


        .divisor {
            border: 0;

            border-top: 2px solid rgba(0, 0, 0, 0.25);

            margin: 10px 0 25px;
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

            padding: 0 18px;

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

            color: white;

            transform: translateY(-1px);
        }


        /* =========================
           BOTÃO CADASTRAR
        ========================= */

        .btn-cadastrar {
            display: flex;

            align-items: center;
            justify-content: center;

            gap: 10px;

            width: 280px;

            height: 60px;

            margin: 20px auto 0;

            background-color: black;

            color: white;

            border: none;

            border-radius: 12px;

            font-family: Arial, sans-serif;

            font-size: 18px;

            font-weight: 900;

            letter-spacing: 1px;

            transition: 0.2s;
        }


        .btn-cadastrar:hover {
            background-color: #222;

            color: white;

            transform: translateY(-2px);

            box-shadow: 0 7px 15px rgba(0, 0, 0, 0.25);
        }


        /* =========================
           LINK PARA LOGIN
        ========================= */

        .link-auth {
            text-align: center;

            margin-top: 23px;

            font-family: Arial, sans-serif;

            font-size: 15px;
        }


        .link-auth a {
            color: black;

            font-weight: bold;

            text-decoration: none;

            margin-left: 5px;
        }


        .link-auth a:hover {
            text-decoration: underline;
        }


        /* =========================
           RESPONSIVO
        ========================= */

        @media (max-width: 768px) {

            .header-auth {
                height: 80px;
            }


            .header-auth-conteudo {
                padding: 0 20px;
            }


            .logo-auth {
                width: 85px;
            }


            .marca-auth {
                font-size: 30px;
            }


            .area-cadastro {
                padding: 30px 15px 40px;
            }


            .card-cadastro {
                padding: 30px 25px 35px;
            }


            .titulo-cadastro {
                font-size: 38px;
            }

        }


        @media (max-width: 576px) {

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
         CADASTRO
    ========================= -->

    <main class="area-cadastro">

        <div class="card-cadastro">


            <!-- CABEÇALHO -->

            <div class="cabecalho-cadastro">

                <div class="icone-cadastro">

                    <i class="bi bi-person-plus-fill"></i>

                </div>


                <h1 class="titulo-cadastro">
                    CADASTRO
                </h1>


                <div class="linha-titulo"></div>


                <p class="subtitulo-cadastro">
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



                <!-- CADASTRAR -->

                <button
                    type="submit"
                    class="btn-cadastrar"
                >

                    <i class="bi bi-person-plus-fill"></i>

                    CADASTRAR

                </button>

            </form>



            <!-- LINK PARA LOGIN -->

            <div class="link-auth">

                <span>
                    Já possui uma conta?
                </span>

                <a href="login.php">
                    Fazer login
                </a>

            </div>

        </div>

    </main>



    <!-- API DE ENDEREÇO -->

    <script src="../API_endereço.js"></script>


</body>

</html>