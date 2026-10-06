<?php
session_start();

if (!isset($_SESSION['id_usuario']))
{
    echo "<script>window.location.href='index.php';</script>";
    exit();
}

echo "<script src='../API_endereço.js'></script>";

require_once "../conexao.php";


if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    //verifica se senha foi enviada em branco ou não
   if (!empty($_POST['senha']))
    $senha_hash = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        else
            $senha_hash = '';
        
    $campos_endereco = ['rua', 'num', 'bairro', 'cidade', 'uf', 'cep'];
    $preenchido = [];

    foreach($campos_endereco as $key)
    {
        if(!empty($_POST[$key]))
         $preenchido[] = $key;
    }

    if(!empty($preenchido))
        $endereco_final = "{$_POST['rua']}, Nº: {$_POST['num']}, {$_POST['bairro']} - {$_POST['cidade']}/{$_POST['uf']} CEP: {$_POST['cep']}";
        else
            $endereco_final = '';

    if (!empty($_POST['email']))
        $email = $_POST['email'];
        else
            $email = '';

    $sql = "UPDATE usuario
            SET email = COALESCE(NULLIF(?, ''), email),
                senha = COALESCE(NULLIF(?, ''), senha),
                endereco = COALESCE(NULLIF(?, ''), endereco)
            WHERE id_usuario = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param('sssi', $email, $senha_hash, $endereco_final, $_SESSION['id_usuario']);
$stmt->execute();
$stmt->close();

    
}

?>

<form action="" method="POST" enctype="multipart/form-data">

    <label for="categoria">Nome Produto: </label>
    <input type="categoria" name="categoria"  ><br>

    <label for="categoria">Categoria: </label>
    <input type="text" name="categoria"  ><br>

    <label for="preco">Preço: </label>
    <input type="num" name="preco" id="preco"  ><br>

    <label for="tam">Tamanho: </label>
    <input type="text" name="tam" id="tam"  ><br>

      <label for="imagem">Imagem: </label>
    <input type="file" name="imagem"><br>

    <input type="submit" value="Alterar">

</form>

<a href="../index.php">
    <button>Voltar</button>
</a>