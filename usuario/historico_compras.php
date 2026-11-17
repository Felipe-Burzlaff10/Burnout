<?php 
session_start();

if (!isset($_SESSION['dados']['id_usuario']))
{
    echo "<script>window.location.href='../index.php';</script>";
    exit();
}

require_once "../conexao.php";

 $sql = "SELECT * FROM pedido 
        WHERE id_usuario = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('i', $_SESSION['dados']['id_usuario']);
    $stmt->execute();
    $resultado = $stmt->get_result();

$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['data']))
{
    if($_GET['data'] == 'Data_todos')
    {
        $sql = "SELECT * FROM pedido 
                WHERE id_usuario = ?";
    
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param('i', $_SESSION['dados']['id_usuario']);
        $stmt->execute();
        $resultado = $stmt->get_result();
    
        $stmt->close();
    }
    elseif($_GET['data'] == 'Data_recentes')
    {
         $sql = "SELECT * FROM pedido 
                WHERE id_usuario = ?
                ORDER BY id_pedido DESC";
    
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param('i', $_SESSION['dados']['id_usuario']);
        $stmt->execute();
        $resultado = $stmt->get_result();
    
        $stmt->close();
    }

}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>BURNOUT - Histórico de compras</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CSS da página (depois do Bootstrap para poder sobrescrevê-lo) -->
    <link rel="stylesheet" href="../CSS/usuario/historico_compras.css">
</head>

<body>

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
 <header class="header-listar">
    <div class="container-fluid">
        <img src="../img_site/logo.png" alt="Logo BURNOUT" class="logo">
        <h1 class="titulo">BURNOUT</h1>
        <a href="../index.php" class="link-voltar">
            <i class="bi bi-arrow-left"></i> <span>Voltar ao início</span>
        </a>
    </div>
</header>


<div class="catalogo-area">

    <!-- PESQUISA -->

    <div class="pesquisa-container">

        <form method="GET">

            
            <label for="data">Data: </label>
            <select name="data" id="data">
                 <option value="Data_todos">Todos</option>
                <option value="Data_recentes">Recentes</option>
            </select><br>
            
            <button type="submit">
                Pesquisar
            </button>
        </form>


    </div>


    <!-- PRODUTOS -->

    <div class="catalogo">

<?php
if ($resultado->num_rows > 0)
{
    while($pedidos = $resultado -> fetch_assoc())
    {   
        
        echo "<div class='card m-2 p-2' style='white-space: nowrap;'>";
        
        echo "<div class='produto-nome'><span class='rotulo'></span>Id Pedido: " . $pedidos['id_pedido'] . "</div>";
        
        echo "<div class='produto-preco'><span class='rotulo'></span>Data da Compra: " . $pedidos['data_compra'] . "</div>";
        
        echo "<br>";
        
        echo "<a class='btn-detalhes' href='detalhes_pedido.php?id_pedido=" . $pedidos['id_pedido'] . "'>Ver detalhes</a>";
        
        echo "</div>";
    }

    

    }

?>

</div>

</div>


<?php
echo "<script src='../usuario_menu.js'></script>";
echo "<script>usuario_menu_suspenso();</script>";
$conexao->close();
?>

</body>

</html>