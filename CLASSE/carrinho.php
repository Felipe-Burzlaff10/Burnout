<?php
abstract class Carrinho
{
    static function adicionar_produto($id_usuario, $id_produto, $qtd)
    {
        require "../conexao.php";

        $sql = "SELECT quantidade FROM carrinho_possui_produto
                WHERE id_usuario = ? AND id_produto = ?";

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param('ii', $id_usuario, $id_produto);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $produto = $resultado -> fetch_assoc();
        $stmt->close();
        
        if ($resultado->num_rows)
            Carrinho::alterar_qtd($id_usuario, $id_produto, $produto['quantidade'] + $qtd);
        else
        {
            $sql = "INSERT INTO carrinho_possui_produto(id_usuario, id_produto, quantidade)
                    VALUES (?, ?, ?)";
    
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param('iii', $id_usuario, $id_produto, $qtd);
            $stmt->execute();
            $stmt->close();
        }

        $conexao->close();
    }

    static function alterar_qtd($id_usuario, $id_produto, $qtd)
    {
        require "../conexao.php";

        $sql = "UPDATE carrinho_possui_produto 
                SET quantidade = ? 
                WHERE id_usuario = ? AND id_produto = ?";


        $stmt = $conexao->prepare($sql);
        $stmt->bind_param('iii', $qtd, $id_usuario, $id_produto);
        $stmt->execute();
        $stmt->close();
        $conexao->close();

       if(!isset($_SESSION['confirma_add']))
        echo "<script>window.location.href='carrinho.php';</script>";
    }

    static function excluir_produto($id_usuario, $id_produto)
    {
        require "../conexao.php";

        $sql = "DELETE FROM carrinho_possui_produto
                WHERE id_usuario = ? AND id_produto = ?";

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param('ii', $id_usuario, $id_produto);
        $stmt->execute();
        $stmt->close();
        $conexao->close();
        
        echo "<script>window.location.href='carrinho.php';</script>";
    }

    static function comprar($id_usuario)
    {
        require "../conexao.php";
        $sql = "SELECT *
                FROM carrinho_possui_produto cp
                WHERE cp.id_usuario = ?";

                $stmt = $conexao->prepare($sql);
                $stmt->bind_param('i', $_SESSION['dados']['id_usuario']);
                $stmt->execute();
                $resultado = $stmt->get_result();
                $stmt->close();

       
        if (isset($_POST['comprar']))
        {
            //$resultado->num_rows > 0 confere se tem produtos no carrinho
            if($resultado->num_rows > 0)
            {
                $sql = "INSERT INTO pedido(id_usuario, data_compra)
                VALUES (?, NOW())";
    
                $stmt = $conexao->prepare($sql);
                $stmt->bind_param('i', $_SESSION['dados']['id_usuario']);
                $stmt->execute();
                //pegar o id_pedido recem gerado no insert
                $id_pedido = $stmt->insert_id;
                $stmt->close();
    
                 $sql = "INSERT INTO pedido_contem_produto (id_pedido, id_produto, quantidade, preco)
                    SELECT ?, p.id_produto, cp.quantidade, p.preco
                    FROM carrinho_possui_produto cp
                    JOIN produto p ON p.id_produto = cp.id_produto
                    WHERE cp.id_usuario = ?";
    
                    $stmt = $conexao->prepare($sql);
                    $stmt->bind_param('ii', $id_pedido, $_SESSION['dados']['id_usuario']);
                    $stmt->execute();
                    $stmt->close();
    
                     $sql = "UPDATE produto p
                     JOIN carrinho_possui_produto cp ON p.id_produto = cp.id_produto 
                     SET estoque = p.estoque - cp.quantidade 
                     WHERE cp.id_usuario = ?";
    
                    $stmt = $conexao->prepare($sql);
                    $stmt->bind_param('i', $_SESSION['dados']['id_usuario']);
                    $stmt->execute();
                    $stmt->close();
    
                     $sql = "DELETE FROM carrinho_possui_produto 
                     WHERE id_usuario = ?";
    
                    $stmt = $conexao->prepare($sql);
                    $stmt->bind_param('i', $_SESSION['dados']['id_usuario']);
                    $stmt->execute();
                    $stmt->close();
    
                    echo "<script>window.location.href='carrinho.php';</script>";
    
    
    
                $conexao->close();
            }
            else
            {
                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                echo "<script src='../mensagem_erro.js'></script>";
                echo "<script>erro_mensagem('Você não possui produtos no carrinho');</script>";
            }
    }
    }
}
?>