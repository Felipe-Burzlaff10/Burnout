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
            
        <form method="POST">

            <label for="nome">Nome: </label>
            <input type="text" name="nome" required><br>

            <label for="cpf">CPF: </label>
            <input type="number" name="cpf" required><br>

            <label for="email">Email: </label>
            <input type="email" name="email" required><br>

            <label for="senha">Senha: </label>
            <input type="password" name="senha" required><br>

            <label for="cep">CEP: </label>
            <input type="num" name="cep" id="cep" required>
            <button type="button" onclick="buscarEndereco()">Buscar Endereço</button><br>

            <label for="uf">UF: </label>
            <input type="text" name="uf" id="uf" required><br>

            <label for="bairro">Bairro: </label>
            <input type="text" name="bairro" id="bairro" required><br>

            <label for="cidade">Cidade: </label>
            <input type="text" name="cidade" id="cidade" required><br>

            <label for="rua">Rua: </label>
            <input type="text" name="rua" id="rua" required><br>

            <label for="num">Nº: </label>
            <input type="num" name="num" required><br>

            <input type="submit" value="Cadastrar">

        </form>

    </body>


    <script>
        function buscarEndereco()
        {

            let cep = document.getElementById('cep').value;

            if(cep.length != 8)
            {
                alert("CEP inválido!");
                return;
            }

            let url = 'https://viacep.com.br/ws/' + cep + '/json/';



            fetch(url)
                .then(resposta => {return resposta.json()})
                .then(dados => {
                                    if (dados.erro)
                                    {
                                        alert("CEP não encontrado.");
                                        return;
                                    }

                                    document.getElementById("uf").value = dados.uf;
                                    document.getElementById("cidade").value = dados.localidade;
                                    document.getElementById("bairro").value = dados.bairro;
                                    document.getElementById("rua").value = dados.logradouro;
                
                                })


        }
    </script>

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
    foreach ($_POST as $key => $value)
    {
        if (!$value)
            echo "Preencha o campo {$key}!<br>";
    }

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

        echo "<br>Deu erro";
    }
    else
    {
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
    }
}

$conexao->close();
?>