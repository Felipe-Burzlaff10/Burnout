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

    form label {
        display: block;
        margin: 14px 0 7px;

        font-size: 19px;
        font-weight: bold;
    }

    form input[type="email"],
    form input[type="password"],
    form input[type="text"],
    form input[type="num"] {
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

    form input:focus {
        background: #f1f1f1;
    }

    /* CEP + botão */
    #cep {
        width: calc(100% - 180px);
    }

    form button {
        height: 45px;
        padding: 0 18px;

        margin-left: 8px;

        border: none;
        border-radius: 10px;

        background: #000;
        color: #fff;

        font-family: Georgia, "Times New Roman", serif;
        font-size: 15px;
        font-weight: bold;

        cursor: pointer;
        transition: 0.2s;
    }

    form button:hover {
        background: #222;
        transform: scale(1.02);
    }

    /* Botão cadastrar */
    form input[type="submit"] {
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

    form input[type="submit"]:hover {
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

        #cep {
            width: 100%;
        }

        form button {
            width: 100%;
            margin: 8px 0 0;
        }

        form input[type="submit"] {
            width: 100%;
        }
    }
</style>

<?php
session_start();

if (!isset($_SESSION['id_usuario']))
{
    echo "<script>window.location.href='index.php';</script>";
    exit();
}

echo '<script src="../API_endereço.js"></script>';

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