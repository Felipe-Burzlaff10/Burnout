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

    public function salvar_usuario(Usuario $usuario)
    {
        $conexao = new Conexao;
        
    }
}

class Conexao
{
    private $host = "localhost";
    private $usuario = "root";
    private $senha = "";
    private $banco = "burnout";

    function __construct()
    {
        $conexao = new mysqli(self::$host, self::$usuario, self::$senha, self::$banco);

        if ($conexao->connect_error)
            return false;
    }
}
?>