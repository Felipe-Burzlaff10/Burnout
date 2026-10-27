<?php
session_start();

if (isset($_SESSION['dados']['id_usuario']))
{
    echo "<script>window.location.href='../index.php';</script>";
    exit();
}

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


 <link rel="stylesheet" href="../CSS/usuario/cadastro.css">
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