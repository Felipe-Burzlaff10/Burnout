<!DOCTYPE html>
<html>
<head>
    <title>Cadastro</title>
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
    <input type="number" name="preco"><br>

     <label for="tamanho">Tamanho: </label>
    <input type="text" name="tamanho"><br>

     <label for="imagem">Imagem: </label>
    <input type="file" name="imagem"><br>

    <input type="submit" value="Cadastrar">

</form>

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
        $stmt->bind_param('ssiss', $_POST['nome'], $_POST['categoria'], $_POST['preco'], $_POST['tamanho'], $nome_final_imagem);
        $stmt->execute();
        $stmt->close();
    
    }
 
$conexao->close();