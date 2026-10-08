<!DOCTYPE html> 
<html lang="pt-br"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Usuários</title> 

    <style> 
        * { 
            box-sizing: border-box; 
        } 

        body { 
            margin: 0; 
            padding: 0; 
            background: linear-gradient(to bottom, #ffffff 0%, #ffffff 25%, #b3b3b3 100%); 
            font-family: Georgia, "Times New Roman", serif; 
            color: #000; 
            min-height: 100vh; 
        } 

        /* PESQUISA */
        body > form { 
            width: 90%; 
            max-width: 1100px; 
            margin: 35px auto 25px; 
            display: flex; 
            align-items: center; 
            gap: 15px; 
        } 

        body > form input[type="text"] { 
            flex: 1; 
            height: 48px; 
            border: none; 
            border-bottom: 3px solid #000; 
            background: transparent; 
            outline: none; 
            font-family: Georgia, "Times New Roman", serif; 
            font-size: 22px; 
            font-weight: bold; 
            color: #000; 
        } 

        body > form input[type="text"]::placeholder { 
            color: #000; 
            opacity: 1; 
        } 

        body > form button { 
            height: 48px; 
            padding: 0 28px; 
            border: none; 
            border-radius: 12px; 
            background: #000; 
            color: #fff; 
            font-family: Georgia, "Times New Roman", serif; 
            font-size: 17px; 
            font-weight: bold; 
            cursor: pointer; 
            transition: 0.2s; 
        } 

        body > form button:hover { 
            background: #222; 
            transform: scale(1.03); 
        } 


        /* CONTAINER DA TABELA */
        .usuarios-container { 
            width: 90%; 
            max-width: 1100px; 
            margin: 0 auto; 
            background: #22c900; 
            border-radius: 22px; 
            padding: 25px; 
        } 

        .usuarios-container > form { 
            width: 100%; 
        }


        /* TABELA */
        .tabela-usuarios { 
            width: 100%; 
            border-collapse: collapse; 
            background: #fff; 
            border-radius: 15px; 
            overflow: hidden; 
        } 

        .tabela-usuarios th { 
            background: #000; 
            color: #fff; 
            padding: 16px 12px; 
            text-align: left; 
            font-size: 18px; 
        } 

        .tabela-usuarios td { 
            padding: 14px 12px; 
            border-bottom: 2px solid #000; 
            font-size: 16px; 
            font-weight: bold; 
        } 

        .tabela-usuarios tr:last-child td { 
            border-bottom: none; 
        } 

        .tabela-usuarios tr:hover td { 
            background: #eeeeee; 
        }


        /* BOTÃO APAGAR */
        .btn-apagar { 
            padding: 10px 20px; 
            border: none; 
            border-radius: 12px; 
            background: #000; 
            color: #fff; 
            font-family: Georgia, "Times New Roman", serif; 
            font-size: 15px; 
            font-weight: bold; 
            cursor: pointer; 
            transition: 0.2s; 
        } 

        .btn-apagar:hover { 
            background: #d00000; 
            transform: scale(1.03); 
        }


        hr { 
            width: 90%; 
            max-width: 1100px; 
            margin: 35px auto; 
            border: none; 
            border-top: 3px solid #000; 
        }


        /* RESPONSIVO */
        @media (max-width: 800px) { 

            body > form { 
                width: 90%; 
                flex-direction: column; 
                align-items: stretch; 
            } 

            body > form button { 
                width: 100%; 
            } 

            .usuarios-container { 
                width: 90%; 
                padding: 15px; 
                overflow-x: auto; 
            } 

            .tabela-usuarios { 
                min-width: 700px; 
            } 
        } 
    </style> 
</head> 

<body> 

<form method="GET"> 
    <input type="text" name="pesquisa" placeholder="Pesquisar usuário..."> 
    <button type="submit">Pesquisar</button> 
</form> 

</body> 
</html> 

<?php
session_start();

if ($_SESSION['root'] != 1)
{
    echo "<script>window.location.href='../index.php';</script>";
    exit();
}

require_once "../conexao.php";

$sql = "SELECT * FROM usuario";
$resultado = ($conexao->query($sql));  

if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    if (isset($_GET['pesquisa']))
    {
        $pesquisa = "%" . $_GET['pesquisa'] . "%";

        $sql = "SELECT * FROM usuario
                WHERE nome LIKE ?
                OR cpf LIKE ?";

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param('ss', $pesquisa, $pesquisa);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $stmt->close();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (isset($_POST['id_apagar']))
    {
        $sql = "DELETE FROM usuario
                WHERE id_usuario = ?";

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param('i', $_POST['id_apagar']);
        $stmt->execute();
        $stmt->close();

        echo "<script>window.location.href='listar.php';</script>";
    }
}

echo "<div class='d-flex p-2 bg-light'>";

echo "<form method='post'>";

while($usuario = $resultado -> fetch_assoc())
{
    echo "<br>";
    
    foreach ($usuario as $key => $value)
    {
        if ($key == "root")
        {
            if ($usuario[$key])
                echo $key . ": True<br>";
            else
                echo $key . ": False<br>";
            
            continue;
        }

        echo  $key . ": " . htmlspecialchars($usuario[$key]) . "<br>";

    }

    if ($usuario['root'])
        continue;

    echo "<button type='submit' name='id_apagar' value='" . $usuario['id_usuario'] . "'>Apagar</button>";
}

echo "</form>";

echo "</div>";
echo "<hr>";

$conexao->close();
?>