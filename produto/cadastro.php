<!DOCTYPE html>
<html>
<head>
    <title>Cadastro</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            padding: 40px 20px;

            background: linear-gradient(
                to bottom,
                #ffffff 0%,
                #ffffff 25%,
                #b3b3b3 100%
            );

            font-family: Georgia, "Times New Roman", serif;
            color: #000;
        }

        form {
            width: 90%;
            max-width: 650px;
            margin: 20px auto;

            padding: 35px 45px;

            background: #22c900;
            border-radius: 22px;
        }

        label {
            display: block;
            margin: 14px 0 7px;

            font-size: 19px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"],
        select {
            width: 100%;
            height: 45px;

            padding: 8px 12px;

            border: 3px solid #000;
            border-radius: 10px;

            background: #fff;

            font-family: Georgia, "Times New Roman", serif;
            font-size: 17px;
            font-weight: bold;

            outline: none;
        }

        input[type="file"] {
            padding: 7px;
        }

        input:focus,
        select:focus {
            background: #f1f1f1;
        }

        input[type="submit"] {
            display: block;

            width: 220px;
            height: 55px;

            margin: 30px auto 0;

            border: none;
            border-radius: 15px;

            background: #000;
            color: #fff;

            font-family: Georgia, "Times New Roman", serif;
            font-size: 18px;
            font-weight: bold;

            cursor: pointer;
            transition: 0.2s;
        }

        input[type="submit"]:hover {
            background: #222;
            transform: scale(1.03);
        }

        .btn-voltar {
            display: block;

            width: 220px;
            height: 50px;

            margin: 0 auto 20px;

            border: none;
            border-radius: 15px;

            background: #000;
            color: #fff;

            font-family: Georgia, "Times New Roman", serif;
            font-size: 17px;
            font-weight: bold;

            cursor: pointer;
            transition: 0.2s;
        }

        .btn-voltar:hover {
            background: #222;
            transform: scale(1.03);
        }

        @media (max-width: 600px) {

            body {
                padding: 20px 10px;
            }

            form {
                width: 100%;
                padding: 25px 20px;
            }

            input[type="submit"],
            .btn-voltar {
                width: 100%;
            }
        }
    </style>
</head>

<body>

<form action="" method="POST" enctype="multipart/form-data">

    <label for="nome">Nome: </label>
    <input type="text" name="nome"><br>

    <label for="categoria">Categoria: </label>
    <select name="categoria" id="categoria">
        <option value="Camiseta">Camiseta</option>
        <option value="Calça">Calça</option>
        <option value="Tênis">Têniss</option>
    </select><br>

    <label for="preco">Preço: </label>
    <input type="number" step="0.01" name="preco"><br>

    <label for="tamanho">Tamanho: </label>
    <input type="text" name="tamanho"><br>

    <label for="imagem">Imagem: </label>
    <input type="file" name="imagem"><br>

    <input type="submit" value="Cadastrar">

</form>

<button type="button" onclick="history.back()" class="btn-voltar">
    ← Voltar
</button>

</body>
</html>

<?php

require_once "../conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $nome_arquivo = $_FILES["imagem"]["name"];
    $nome_temporario = $_FILES['imagem']['tmp_name'];

    $extensao = strtolower(pathinfo($nome_arquivo, PATHINFO_EXTENSION));

    $extensoes_permitidas = ["jpg", "png", "jpeg"];

    if(!in_array($extensao, $extensoes_permitidas))
            die("a foto contem um tipo de extensao que não é permitida!.");
        
            $nome_final_imagem = uniqid() . "." . $extensao;

    $caminho_destino = "../img_produto/" . $nome_final_imagem;
    move_uploaded_file($nome_temporario, $caminho_destino);

    $sql = "INSERT INTO produto(nome, categoria, preco, tamanho, foto)
    VALUES (?, ?, ?, ?, ?) ";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('ssdss', $_POST['nome'], $_POST['categoria'], $_POST['preco'], $_POST['tamanho'], $nome_final_imagem);
    $stmt->execute();
    $stmt->close();

}
 
$conexao->close();