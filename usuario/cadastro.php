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

    /* Área do cadastro */
    .area-cadastro {
        padding: 15px 0 30px 0;
    }

    /* Card verde */
    .card-cadastro {
        background-color: #39bf00;
        border-radius: 20px;
        width: 740px;
        max-width: 90%;
        margin: 0 auto;
        padding: 5px 70px 25px 70px;
    }

    /* Título */
    .titulo-cadastro {
        font-family: Arial, sans-serif;
        font-size: 60px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 10px;
        color: black;
    }

    /* Labels */
    .form-label {
        font-size: 30px;
        font-weight: bold;
        margin-bottom: 0;
        color: black;
    }

    /* Inputs */
    .form-control {
        background-color: transparent;
        border: none;
        border-bottom: 3px solid black;
        border-radius: 0;
        font-size: 22px;
        padding: 0 5px;
        height: 45px;
        color: black;
        box-shadow: none !important;
    }

    .form-control:focus {
        background-color: transparent;
        border-color: black;
        box-shadow: none;
    }

    /* Espaçamento entre os campos */
    .campo {
        margin-bottom: 20px;
    }

    /* Botão */
    .btn-cadastrar {
        display: block;
        margin: 15px auto 0 auto;
        background-color: black;
        color: white;
        border: none;
        border-radius: 20px;
        width: 245px;
        height: 80px;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 20px;
        font-weight: bold;
    }

    .btn-cadastrar:hover {
        background-color: #222;
        color: white;
    }

    /* Botão de buscar CEP */
    .btn-cep {
        background-color: black;
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: bold;
        height: 40px;
    }

    .btn-cep:hover {
        background-color: #222;
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
            
        <div class="container-fluid area-cadastro">

    <div class="card-cadastro">

        <h1 class="titulo-cadastro">
            CADASTRO
        </h1>

        <form method="POST">

            <!-- NOME -->
            <div class="campo">
                <label for="nome" class="form-label">
                    Nome
                </label>

                <input 
                    type="text" 
                    name="nome" 
                    id="nome"
                    class="form-control"
                    required
                >
            </div>


            <!-- CPF -->
            <div class="campo">
                <label for="cpf" class="form-label">
                    CPF
                </label>

                <input 
                    type="text" 
                    name="cpf" 
                    id="cpf"
                    class="form-control"
                    maxlength="11"
                    required
                >
            </div>


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


            <!-- CEP -->
            <div class="campo">
                <label for="cep" class="form-label">
                    CEP
                </label>

                <div class="d-flex gap-2">

                    <input 
                        type="text" 
                        name="cep" 
                        id="cep"
                        class="form-control"
                        maxlength="8"
                        required
                    >

                    <button 
                        type="button" 
                        class="btn btn-cep"
                        onclick="buscarEndereco()"
                    >
                        Buscar
                    </button>

                </div>
            </div>


            <!-- UF -->
            <div class="campo">
                <label for="uf" class="form-label">
                    UF
                </label>

                <input 
                    type="text" 
                    name="uf" 
                    id="uf"
                    class="form-control"
                    maxlength="2"
                    required
                >
            </div>


            <!-- BAIRRO -->
            <div class="campo">
                <label for="bairro" class="form-label">
                    Bairro
                </label>

                <input 
                    type="text" 
                    name="bairro" 
                    id="bairro"
                    class="form-control"
                    required
                >
            </div>


            <!-- CIDADE -->
            <div class="campo">
                <label for="cidade" class="form-label">
                    Cidade
                </label>

                <input 
                    type="text" 
                    name="cidade" 
                    id="cidade"
                    class="form-control"
                    required
                >
            </div>


            <!-- RUA -->
            <div class="campo">
                <label for="rua" class="form-label">
                    Rua
                </label>

                <input 
                    type="text" 
                    name="rua" 
                    id="rua"
                    class="form-control"
                    required
                >
            </div>


            <!-- NÚMERO -->
            <div class="campo">
                <label for="num" class="form-label">
                    Nº
                </label>

                <input 
                    type="text" 
                    name="num" 
                    id="num"
                    class="form-control"
                    required
                >
            </div>


            <!-- BOTÃO -->
            <button 
                type="submit" 
                class="btn btn-cadastrar"
            >
                CADASTRAR
            </button>

        </form>

    </div>

</div>

    </body>


   echo '<script src="../API_endereço.js"></script>';

</html>

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