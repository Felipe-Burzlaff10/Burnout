<link rel="stylesheet" href="../CSS/usuario/alterar.css">

<script>
    function preencher_input(endereco, email)
    {
        const regex = /^(?<logradouro>.*?),\s*Nº:\s*(?<numero>\d+),\s*(?<bairro>.*?)\s*-\s*(?<cidade>.*?)\/(?<uf>[A-Z]{2})\s*CEP:\s*(?<cep>\d{8})/;

        
        const resultado = endereco.match(regex);
        
        if (resultado)
        {   
            const { logradouro, numero, bairro, cidade, uf, cep } = resultado.groups;
        
            document.getElementById("rua").value = logradouro;
            document.getElementById("num").value = numero;
            document.getElementById("bairro").value = bairro;
            document.getElementById("cidade").value = cidade;
            document.getElementById("uf").value = uf;
            document.getElementById("cep").value = cep;
            document.getElementById("email").value = email;
        }
    }
</script>

<?php
session_start();

if ($_SESSION['dados']['root'] != 1)
{
    echo "<script>window.location.href='../index.php';</script>";
    exit();
}

echo '<script src="../API_endereço.js"></script>';

require_once "../conexao.php";

$sql = "SELECT * FROM usuario
        WHERE id_usuario = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param('i', $_SESSION['dados']['id_usuario']);
$stmt->execute();
$resultado = $stmt->get_result();
$stmt->close();

$usuario = $resultado -> fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
   if (!empty($_POST['senha']))
        $senha_hash = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    else
        $senha_hash = '';

    $campos_endereco = ['rua', 'num', 'bairro', 'cidade', 'uf', 'cep'];
    $preenchido = [];

    foreach ($campos_endereco as $key)
    {
        if (!empty($_POST[$key]))
            $preenchido[] = $key;
    }

    if (!empty($preenchido))
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
    $stmt->bind_param('sssi', $email, $senha_hash, $endereco_final, $_SESSION['dados']['id_usuario']);
    $stmt->execute();
    $stmt->close();
    
}

?>

<form method="POST">

    <a href="../index.php">
        <button type="button" class="btn-voltar">
        ← Voltar
        </button>
    </a>

    <label for="email">Email: </label>
    <input type="email" name="email" id="email"  ><br>

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
    <input type="number" name="num" id="num" ><br>

    <input type="submit" value="Alterar">

</form>

<?php 
echo "<script>preencher_input('" . $usuario['endereco'] . "', '" . $usuario['email'] . "')</script>";
?>