 <!-- Importação do CSS do Bootstrap -->
    <link href="https://jsdelivr.net" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
 <script src="https://jsdelivr.net" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<?php
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "burnout";

$conexao = new mysqli($host, $usuario, $senha, $banco);

$sql = "SELECT * FROM usuario";
$resultado = ($conexao->query($sql));

echo "<div class='d-flex p-2 bg-light'>";

while($usuario = $resultado -> fetch_assoc())
{
    echo  "ID_usuario: ".htmlspecialchars($usuario['id_usuario'])."<br>";
    echo   "Nome: ".htmlspecialchars($usuario['nome'])."<br>"; 
    echo   "CPF: ".htmlspecialchars($usuario['cpf'])."<br>";
    echo   "Email: ".htmlspecialchars($usuario['email'])."<br>";
    echo   "Senha: ".htmlspecialchars($usuario['senha'])."<br>";
    echo   "Endereço: ".htmlspecialchars($usuario['endereco'])."<br>";
    if($usuario['root']) echo "Root: true";
    else echo "Root: false";
}
echo "</div>";
    echo "<hr>";

$conexao->close();
?>