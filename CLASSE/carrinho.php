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
}
?>