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



$valor_total = 0;

while($p = $resultado->fetch_assoc())
{
    echo "<form method='post'>";

    echo htmlspecialchars($p['nome']) . "<br>";
    echo "R$" . htmlspecialchars($p['preco']) . "<br>";
    echo "Tamanho: " . htmlspecialchars($p['tamanho']) . "<br>";
    echo "Estoque: " . htmlspecialchars($p['estoque']) . "<br>";
    echo "Quantidade: " . htmlspecialchars($p['qtd_carrinho']) . "<br>";
    echo "Subtotal do Produto: R$" . htmlspecialchars($p['preco'] * $p['qtd_carrinho']) . "<br>";

    if($p['estoque'] > 0)
        $estilo = "";
    else
        $estilo = "filter: blur(2px);";
    echo "<img style='width: 100%; height: 150px; object-fit: cover; $estilo' src='../img_produto/" . $p['foto'] . "'><br>";

    echo "<input type='hidden' name='id_produto' value='" . $p['id_produto'] . "'>";

    echo "<input type='hidden' name='produto_estoque' value='" . $p['estoque'] . "'>";

    echo "<button type='button' onclick=\"var i = document.getElementById('qtd'); i.stepUp(); i.dispatchEvent(new Event('change'));\">+</button>";

    echo "<input type='number' id='qtd' onchange='this.form.submit()' min='0' name='qtd_carrinho' value='" . $p['qtd_carrinho'] . "'>";

    echo "<button type='button' onclick=\"var i = document.getElementById('qtd'); i.stepDown(); i.dispatchEvent(new Event('change'));\">-</button>";

    echo "<button type='submit' name='id_apagar' value='" . $p['id_produto'] . "'>Retirar do Carrinho</button><br>";
    
    $valor_total += $p['preco'] * $p['qtd_carrinho'];

    echo "</form>";
}


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

        if(preg_match('/\/([A-Z]{2})\s+CEP/', $endereco, $correspondencia))
        {
            $uf = $correspondencia[1];
        }
        return $uf;
}
$uf = calcular_frete($_SESSION['dados']['id_usuario']);
$estados_frete_gratis = ['RS', 'SC', 'PR'];

if(in_array($uf, $estados_frete_gratis))
{
    echo "Para sua região o frete é grátis";
    echo "<br>Valor Total: ". $valor_total;
}
else
{
    echo "Para sua região o frete é R$50.00";
    $valor_total += 50;
    echo "<br>Valor Total: ".$valor_total;
}

$conexao->close();
?>

<a
        href="../index.php"
        class="">

        <i class="bi bi-box-arrow-right"></i>
        Voltar

</a>