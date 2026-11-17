<?php
class Usuario
{
    private int $id_usuario;
    private bool $isRoot;
    private string $nome;
    private string $cpf;
    private string $email;
    private string $senha_hash;
    private string  $endereco;

    public function __construct($nome, $cpf, $email, $senha_hash, $endereco)
    {
        $this->isRoot = false;
        $this->nome = $nome;
        $this->cpf = $cpf;
        $this->email = $email;
        $this->senha_hash = $senha_hash;
        $this->endereco = $endereco;
    }

    public function salvar_usuario()
    {
        $conexao = Conexao::criar_conexao();

        $sql = "INSERT INTO usuario(nome, cpf, email, senha, endereco, root)
        VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param('sssssi', $this->nome, $this->cpf, $this->email, $this->senha_hash, $this->endereco, $this->isRoot);
        $stmt->execute();

        $this->id_usuario = $conexao->insert_id;

        $stmt->close();
        $conexao->close();
    }
}

abstract class Conexao
{
    private static $host = "localhost";
    private static $usuario = "root";
    private static $senha = "";
    private static $banco = "burnout";

    public static function criar_conexao()
    {
        $conexao = new mysqli(self::$host, self::$usuario, self::$senha, self::$banco);

        if ($conexao->connect_error)
            die("Erro na conexão com o banco de dados: " . $conexao->connect_error);

        return $conexao;
    }
}
?>