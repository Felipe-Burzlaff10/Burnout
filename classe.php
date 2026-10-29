<?php
abstract class Carrinho
{
    static function adicionar_produto($id_usuario, $id_produto, $qtd)
    {
        require "conexao.php";

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
        require "conexao.php";

        $sql = "UPDATE carrinho_possui_produto 
                SET quantidade = quantidade + ? 
                WHERE id_usuario = ? AND id_produto = ?";


        $stmt = $conexao->prepare($sql);
        $stmt->bind_param('iii', $qtd, $id_usuario, $id_produto);
        $stmt->execute();

        $stmt->close();
        $conexao->close();
    }
}
?>