<?php
session_start();

if (!isset($_SESSION['id_usuario']))
{
    echo "<script>window.location.href='index.php';</script>";
    exit();
}

echo '<script src="API_endereço.js"></script>';
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "burnout";

$conexao = new mysqli($host, $usuario, $senha, $banco);

if ($conexao->connect_error)
    die("Erro na conexão.");


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

<form method="POST">

    <label for="email">Email: </label>
    <input type="email" name="email"  ><br>

    <label for="senha">Senha: </label>
    <input type="password" name="senha"  ><br>

    <label for="cep">CEP: </label>
    <input type="num" name="cep" id="cep"  >
    <button type="button" onclick="buscarEndereco()">Buscar Endereço</button><br>

    <label for="uf">UF: </label>
    <input type="text" name="uf" id="uf"  ><br>

    <label for="bairro">Bairro: </label>
    <input type="text" name="bairro" id="bairro"  ><br>

    <label for="cidade">Cidade: </label>
    <input type="text" name="cidade" id="cidade"  ><br>

    <label for="rua">Rua: </label>
    <input type="text" name="rua" id="rua"  ><br>

    <label for="num">Nº: </label>
    <input type="num" name="num"  ><br>

    <input type="submit" value="Cadastrar">

</form>