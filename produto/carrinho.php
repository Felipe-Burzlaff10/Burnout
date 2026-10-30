<?php 
session_start();

require_once "../CLASSE/carrinho.php";
if (!isset($_SESSION['dados']['id_usuario']))
{
    echo "<script>window.location.href='../index.php';</script>";
    exit();
}

Carrinho::listar_produtos($_SESSION['dados']['id_usuario']);

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
        echo "<br>Valor Total: ". Carrinho::$valor_total;
    }
    else
    {
        echo "Para sua região o frete é R$50.00";
        Carrinho::$valor_total += 50;
        echo "<br>Valor Total: ".Carrinho::$valor_total;
    }


?>

<a
        href="../index.php"
        class="">

        <i class="bi bi-box-arrow-right"></i>
        Voltar

    </a>