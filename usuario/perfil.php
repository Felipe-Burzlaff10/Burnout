<?php
session_start();
require_once "../conexao.php";

$sql = "SELECT * FROM usuario
        WHERE id_usuario = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param('i', $_SESSION['dados']['id_usuario']);
$stmt->execute();
$resultado = $stmt->get_result();
$stmt->close();
$usuario = $resultado -> fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>BURNOUT - Minha conta</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CSS da página -->
    <link rel="stylesheet" href="../CSS/usuario/perfil.css">
</head>

<body>

<header class="header-perfil">
    <div class="container-fluid">
        <img src="../img_site/logo.png" alt="Logo BURNOUT" class="logo">
        <h1 class="titulo">BURNOUT</h1>
        <div></div>
    </div>
</header>

<main class="pagina-perfil">

<section class="perfil-card">

    <div class="perfil-topo">
        <i class="bi bi-person-circle"></i>
        <h2>Minha conta</h2>
    </div>

    <div class="perfil-dados">
<?php
echo "<div class='perfil-item'><i class='bi bi-person'></i><div><span class='rotulo'>Nome</span><span class='valor'>" . $usuario['nome'] . "</span></div></div>";
echo "<div class='perfil-item'><i class='bi bi-person-vcard'></i><div><span class='rotulo'>CPF</span><span class='valor'>" . $usuario['cpf'] . "</span></div></div>";
echo "<div class='perfil-item'><i class='bi bi-envelope'></i><div><span class='rotulo'>Email</span><span class='valor'>" . $usuario['email'] . "</span></div></div>";
echo "<div class='perfil-item'><i class='bi bi-lock'></i><div><span class='rotulo'>Senha</span><span class='valor'>" . str_repeat("*", strlen($usuario['senha'])) . "</span></div></div>";
echo "<div class='perfil-item'><i class='bi bi-geo-alt'></i><div><span class='rotulo'>Endereço</span><span class='valor'>" . $usuario['endereco'] . "</span></div></div>";

$conexao->close();
?>
    </div>

    <div class="perfil-acoes">

<a href="../index.php">
        <button type="button" class="btn-voltar">
        ← Voltar
        </button>
    </a>

        <a href="alterar.php" class="btn-alterar-dados">
            <i class="bi bi-gear"></i> Alterar meus dados
        </a>

    </div>

</section>

</main>

</body>

</html>