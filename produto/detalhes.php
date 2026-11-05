
<?php
session_start();

if (!isset($_SESSION['dados']['id_usuario'])) {
    header("Location: ../index.php");
    exit();
}

require_once "../CLASSE/carrinho.php";
require_once "../conexao.php";

$id_produto = filter_input(INPUT_GET, 'id_produto', FILTER_VALIDATE_INT);

if (!$id_produto) {
    header("Location: catalogo.php");
    exit();
}

// Buscar produto
$sql = "SELECT * FROM produto WHERE id_produto = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_produto);
$stmt->execute();

$resultado = $stmt->get_result();
$produto = $resultado->fetch_assoc();

$stmt->close();

if (!$produto) {
    header("Location: catalogo.php");
    exit();
}

// Mensagens
$mensagem = "";
$tipo_mensagem = "";

// Adicionar ao carrinho
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $qtd = filter_input(INPUT_POST, 'qtd', FILTER_VALIDATE_INT);

    if ($produto['estoque'] <= 0) {

        $mensagem = "Produto fora de estoque!";
        $tipo_mensagem = "error";

    } elseif (!$qtd || $qtd < 1) {

        $mensagem = "Informe uma quantidade válida!";
        $tipo_mensagem = "error";

    } elseif ($qtd > $produto['estoque']) {

        $mensagem = "Quantidade solicitada maior que o estoque disponível!";
        $tipo_mensagem = "error";

    } else {

        Carrinho::adicionar_produto(
            $_SESSION['dados']['id_usuario'],
            $produto['id_produto'],
            $qtd
        );

        $mensagem = "Produto adicionado ao carrinho com sucesso!";
        $tipo_mensagem = "success";
    }
}

$disponibilidade = $produto['estoque'] > 0
    ? "Em estoque"
    : "Fora de estoque";

// Formatação dos dados
$nome = htmlspecialchars($produto['nome'], ENT_QUOTES, 'UTF-8');
$descricao = htmlspecialchars($produto['descricao'], ENT_QUOTES, 'UTF-8');
$tamanho = htmlspecialchars($produto['tamanho'], ENT_QUOTES, 'UTF-8');
$foto = htmlspecialchars($produto['foto'], ENT_QUOTES, 'UTF-8');

$preco = number_format(
    (float)$produto['preco'],
    2,
    ',',
    '.'
);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $nome; ?> | BURNOUT</title>

    <link rel="stylesheet" href="../CSS/produto/detalhes.css">
    <link rel="stylesheet" href="../CSS/header-loja.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    
<header class="header-home">

    <div class="header-superior">

        <div class="header-esquerda">
            <button class="botao-menu" type="button" aria-label="Abrir menu">
                <i class="bi bi-list"></i>
            </button>

            <a href="../index.php" aria-label="Página inicial BURNOUT">
                <img src="../img_site/logo.png" class="logo" alt="BURNOUT">
            </a>
        </div>

        <h1 class="titulo">BURNOUT</h1>

        <div class="header-direita">

            <a href="carrinho.php" class="icone-header">
                <i class="bi bi-cart3"></i>
            </a>

            <div class="usuario-menu">

                <button class="usuario-header" id="usuarioBtn" type="button">
                    <?php echo htmlspecialchars($_SESSION['dados']['nome'] ?? 'Minha conta'); ?>
                    <i class="bi bi-chevron-down"></i>
                </button>

                <div class="usuario-dropdown" id="usuarioDropdown">

                    <a href="../perfil.php">
                        <i class="bi bi-person"></i>
                        Minha conta
                    </a>

                    <a href="../historico.php">
                        <i class="bi bi-clock-history"></i>
                        Histórico de compras
                    </a>

                    <a href="../usuario/alterar.php">
                        <i class="bi bi-gear"></i>
                        Alterar meus dados
                    </a>

                    <hr>

                    <a href="../usuario/logout.php" class="sair">
                        <i class="bi bi-box-arrow-right"></i>
                        Sair da conta
                    </a>

                </div>

            </div>

        </div>

    </div>

    <nav class="nav">

        <a href="../index.php" class="nav-link">HOME</a>

        <a href="catalogo.php" class="nav-link active">CATALOGO</a>

        <a href="lancamentos.php" class="nav-link">LANÇAMENTOS</a>

        <a href="../sobre_nos.php" class="nav-link">SOBRE NÓS</a>

    </nav>

</header>

<script>
document.getElementById('usuarioBtn').addEventListener('click', function() {
    document.getElementById('usuarioDropdown').classList.toggle('aberto');
});

document.addEventListener('click', function(event) {
    const menu = document.querySelector('.usuario-menu');

    if (!menu.contains(event.target)) {
        document.getElementById('usuarioDropdown').classList.remove('aberto');
    }
});
</script>



    <!-- CONTEÚDO PRINCIPAL -->
    <main class="pagina-produto">

        <!-- CAMINHO DE NAVEGAÇÃO -->
        <div class="caminho">

            <a href="catalogo.php">Home</a>

            <span>/</span>

            <span>Catálogo</span>

            <span>/</span>

            <strong><?php echo $nome; ?></strong>

        </div>


        <!-- ÁREA DE DETALHES -->
        <section class="produto-container">


            <!-- IMAGEM DO PRODUTO -->
            <div class="produto-imagem-container">

                <div class="produto-imagem-fundo">

                    <img
                        class="produto-imagem"
                        src="../img_produto/<?php echo $foto; ?>"
                        alt="<?php echo $nome; ?>"
                        style="<?php echo $produto['estoque'] <= 0 ? 'filter: grayscale(100%);' : ''; ?>"
                    >

                </div>

                <?php if ($produto['estoque'] <= 0): ?>

                    <div class="produto-indisponivel">
                        PRODUTO ESGOTADO
                    </div>

                <?php endif; ?>

            </div>


            <!-- INFORMAÇÕES DO PRODUTO -->
            <div class="produto-informacoes">


                <!-- NOME -->
                <div class="produto-categoria">
                    BURNOUT | PRODUTO
                </div>

                <h1 class="produto-nome">
                    <?php echo $nome; ?>
                </h1>


                <!-- DISPONIBILIDADE -->
                <div class="produto-status">

                    <span class="status-indicador"
                        style="background-color: <?php echo $produto['estoque'] > 0 ? '#39bf00' : '#ed1c24'; ?>">
                    </span>

                    <?php echo $disponibilidade; ?>

                </div>


                <!-- PREÇO -->
                <div class="produto-preco-container">

                    <span class="preco-legenda">
                        PREÇO
                    </span>

                    <div class="produto-preco">
                        R$ <?php echo $preco; ?>
                    </div>

                </div>


                <!-- DETALHES -->
                <div class="produto-caracteristicas">

                    <div class="caracteristica">

                        <span class="caracteristica-titulo">
                            TAMANHO
                        </span>

                        <span class="caracteristica-valor">
                            <?php echo $tamanho; ?>
                        </span>

                    </div>


                    <div class="caracteristica">

                        <span class="caracteristica-titulo">
                            ESTOQUE DISPONÍVEL
                        </span>

                        <span class="caracteristica-valor">
                            <?php echo (int)$produto['estoque']; ?> unidades
                        </span>

                    </div>

                </div>


                <!-- ÁREA DE COMPRA -->
                <form method="POST" class="produto-compra">

                    <label for="qtd">
                        QUANTIDADE
                    </label>

                    <input
                        type="number"
                        id="qtd"
                        name="qtd"
                        value="1"
                        min="1"
                        max="<?php echo (int)$produto['estoque']; ?>"
                        required
                        <?php echo $produto['estoque'] <= 0 ? 'disabled' : ''; ?>
                    >

                    <button
                        type="submit"
                        class="botao-comprar"
                        <?php echo $produto['estoque'] <= 0 ? 'disabled' : ''; ?>
                    >

                        ADICIONAR AO CARRINHO

                    </button>

                </form>


                <!-- VOLTAR -->
                <a href="catalogo.php" class="botao-voltar">
                    ← VOLTAR AO CATÁLOGO
                </a>

            </div>

        </section>


        <!-- DESCRIÇÃO DO PRODUTO -->
        <section class="produto-descricao-container">

            <div class="descricao-titulo">

                <span>01</span>

                <h2>DESCRIÇÃO DO PRODUTO</h2>

            </div>

            <p class="descricao-texto">
                <?php echo nl2br($descricao); ?>
            </p>

        </section>


        <!-- INFORMAÇÕES ADICIONAIS -->
        <section class="produto-informacoes-adicionais">

            <h2>INFORMAÇÕES ADICIONAIS</h2>

            <div class="informacoes-grade">

                <div>
                    <span>Produto</span>
                    <strong><?php echo $nome; ?></strong>
                </div>

                <div>
                    <span>Tamanho</span>
                    <strong><?php echo $tamanho; ?></strong>
                </div>

                <div>
                    <span>Disponibilidade</span>
                    <strong><?php echo $disponibilidade; ?></strong>
                </div>

            </div>

        </section>

    </main>


    <!-- RODAPÉ -->
    <footer class="rodape">

        <span>BURNOUT</span>

        <p>ESTILO, QUALIDADE E ATITUDE.</p>

    </footer>


    <!-- MENSAGENS -->
    <?php if ($mensagem != ""): ?>

        <script>
            Swal.fire({
                icon: <?php echo json_encode($tipo_mensagem); ?>,
                title: <?php echo json_encode($mensagem); ?>,
                confirmButtonColor: '#39bf00',
                confirmButtonText: 'OK'
            });
        </script>

    <?php endif; ?>

</body>
</html>

<?php
$conexao->close();
?>
