<?php
abstract class Carrinho
{
    public static $valor_total;
    static function adicionar_produto($id_usuario, $id_produto, $qtd)
    {
        require "../conexao.php";

        $sql = "INSERT INTO carrinho_possui_produto(id_usuario, id_produto, quantidade)
                VALUES (?, ?, ?)";

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param('iii', $id_usuario, $id_produto, $qtd);
        try
        {
            $stmt->execute();
        }catch(mysqli_sql_exception $e)
        {
            Carrinho::alterar_qtd($id_usuario, $id_produto, $qtd);
        }

        $stmt->close();
        $conexao->close();
    }

    static function alterar_qtd($id_usuario, $id_produto, $qtd)
    {
        require "../conexao.php";

        $sql = "UPDATE carrinho_possui_produto 
                SET quantidade = quantidade + ? 
                WHERE id_usuario = ? AND id_produto = ?";


        $stmt = $conexao->prepare($sql);
        $stmt->bind_param('iii', $qtd, $id_usuario, $id_produto);
        $stmt->execute();

        $stmt->close();
        $conexao->close();
    }

    static function listar_produtos($id_cliente)
    {
        require "../conexao.php";

        $sql = "SELECT p.*, cp.quantidade AS qtd_carrinho
                FROM produto p
                JOIN carrinho_possui_produto cp  ON p.id_produto = cp.id_produto
                WHERE cp.id_usuario = ?";


        $stmt = $conexao->prepare($sql);
        $stmt->bind_param('i', $id_cliente);
        $stmt->execute();
        $resultado = $stmt->get_result();


        $valor_total = 0;
        echo "<form method='post'>";
        while($p = $resultado->fetch_assoc())
        {
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

            echo "<button type='submit' name='id_apagar' value='" . $p['id_produto'] . "'>Retirar do Carrinho</button><br>";
            
            self::$valor_total += $p['preco'] * $p['qtd_carrinho'];
        }
        
        echo "</form>";

        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            if (isset($_POST['id_apagar']))
            {
                $sql = "DELETE FROM carrinho_possui_produto
                        WHERE id_produto = ?";

                $stmt = $conexao->prepare($sql);
                $stmt->bind_param('i', $_POST['id_apagar']);
                $stmt->execute();

                echo "<script>window.location.href='carrinho.php';</script>";
            }
        }
        $stmt->close();
        $conexao->close();
    }
}
?>