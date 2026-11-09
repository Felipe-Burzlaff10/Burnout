<?php 
session_start();

if (!isset($_SESSION['dados']['id_usuario']))
{
    echo "<script>window.location.href='../index.php';</script>";
    exit();
}

require "../conexao.php";
require_once "../CLASSE/carrinho.php";


$sql = "SELECT p.*, cp.quantidade AS qtd_carrinho
        FROM produto p
        JOIN carrinho_possui_produto cp  ON p.id_produto = cp.id_produto
        WHERE cp.id_usuario = ?";


$stmt = $conexao->prepare($sql);
$stmt->bind_param('i', $_SESSION['dados']['id_usuario']);
$stmt->execute();
$resultado = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BURNOUT - Carrinho</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CSS da página (depois do Bootstrap para poder sobrescrevê-lo) -->
    <link rel="stylesheet" href="../CSS/produto/carrinho.css">
</head>
<body>

<header class="header-carrinho">
    <div class="container-fluid">
        <img src="../img_site/logo.png" alt="Logo BURNOUT" class="logo">
        <h1 class="titulo">BURNOUT</h1>
        <div></div>
    </div>
</header>

<main class="pagina-carrinho">

<h2 class="pagina-titulo">Meu carrinho</h2>

<?php
echo "<div class='carrinho-layout'>";

echo "<div class='carrinho-itens'>";

$valor_total = 0;

while($p = $resultado->fetch_assoc())
{
    echo "<form method='post'>";

    echo "<div class='item-info'>";

    echo "<span class='item-nome'>";
    echo htmlspecialchars($p['nome']) . "<br>";
    echo "</span>";

    echo "<span class='item-preco'>";
    echo "R$" . htmlspecialchars($p['preco']) . "<br>";
    echo "</span>";

    echo "<span class='item-dado'>";
    echo "Tamanho: " . htmlspecialchars($p['tamanho']) . "<br>";
    echo "</span>";

    echo "<span class='item-dado'>";
    echo "Estoque: " . htmlspecialchars($p['estoque']) . "<br>";
    echo "</span>";

    echo "<span class='item-dado'>";
    echo "Quantidade: " . htmlspecialchars($p['qtd_carrinho']) . "<br>";
    echo "</span>";

    echo "<span class='item-subtotal'>";
    echo "Subtotal do Produto: R$" . htmlspecialchars($p['preco'] * $p['qtd_carrinho']) . "<br>";
    echo "</span>";

    echo "</div>";

    if($p['estoque'] > 0)
        $estilo = "";
    else
        $estilo = "filter: blur(2px);";

    echo "<img style='width: 100%; height: 150px; object-fit: cover; $estilo' src='../img_produto/" . $p['foto'] . "'><br>";

    echo "<input type='hidden' name='id_produto' value='" . $p['id_produto'] . "'>";

    echo "<input type='hidden' name='produto_estoque' value='" . $p['estoque'] . "'>";

    echo "<div class='item-controles'>";

    echo "<div class='qtd-controle'>";

    echo "<button type='button' onclick=\"var i = this.parentNode.querySelector('input[type=number]'); i.stepUp(); i.dispatchEvent(new Event('change'));\">+</button>";

    echo "<input type='number' id='qtd' onchange='this.form.submit()' min='0' name='qtd_carrinho' value='" . $p['qtd_carrinho'] . "'>";

    echo "<button type='button' onclick=\"var i = this.parentNode.querySelector('input[type=number]'); i.stepDown(); i.dispatchEvent(new Event('change'));\">-</button>";

    echo "</div>";

    echo "<button type='submit' name='id_apagar' value='" . $p['id_produto'] . "'>Retirar do Carrinho</button><br>";

    echo "</div>";
    
    $valor_total += $p['preco'] * $p['qtd_carrinho'];

    echo "</form>";
}

echo "</div>";


if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (isset($_POST['id_apagar']))
    {
        Carrinho::excluir_produto($_SESSION['dados']['id_usuario'], $_POST['id_apagar']);
    }


    if ($_POST['produto_estoque'] >= $_POST['qtd_carrinho'] && $_POST['qtd_carrinho'] > 0)
        Carrinho::alterar_qtd($_SESSION['dados']['id_usuario'], $_POST['id_produto'], $_POST['qtd_carrinho']);

}


function calcular_frete($id_usuario)
{
    require "../conexao.php";
     
      $sql = "SELECT endereco
              FROM usuario
              WHERE id_usuario = ?";


        $stmt = $conexao->prepare($sql);
        $stmt->bind_param('i', $id_usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $linha = $resultado->fetch_assoc();
        $stmt->close();
        $endereco = $linha['endereco'];
        echo "Endereço atual: " . $linha['endereco'] . "<br>";
       
       
       echo "<form method='post' action='../usuario/alterar.php'>
        <button type='submit' name='acao' value='alterar_endereco'>Alterar Endereço</button>
      </form>";
      
        if(preg_match('/\/([A-Z]{2})\s+CEP/', $endereco, $correspondencia))
        {
            $uf = $correspondencia[1];
        }
        return $uf;
}

echo "<aside class='carrinho-resumo'>";

echo "<h2 class='resumo-titulo'>Resumo do pedido</h2>";

echo "<div class='resumo-endereco'>";
$uf = calcular_frete($_SESSION['dados']['id_usuario']);
echo "</div>";

$estados_frete_gratis = ['RS', 'SC', 'PR'];

if(in_array($uf, $estados_frete_gratis))
{
    echo "<div class='resumo-frete frete-gratis'>";
    echo "Para sua região o frete é grátis";
    echo "</div>";

    echo "<div class='resumo-total'>";
    echo "<br>Valor Total: ". $valor_total;
    echo "</div>";
}
else
{
    echo "<div class='resumo-frete frete-pago'>";
    echo "Para sua região o frete é R$50.00";
    echo "</div>";

    $valor_total += 50;

    echo "<div class='resumo-total'>";
    echo "<br>Valor Total: ".$valor_total;
    echo "</div>";
}

$conexao->close();
?>

<a
        href="../index.php"
        class="">

        <i class="bi bi-box-arrow-right"></i>
        Voltar

</a>

</aside>

</div>

</main>

</body>
</html>