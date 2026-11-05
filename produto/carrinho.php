
<?php
session_start();

if (!isset($_SESSION['dados']['id_usuario'])) {
    header("Location: ../index.php");
    exit();
}

require_once "../conexao.php";
require_once "../CLASSE/carrinho.php";

$id_usuario = $_SESSION['dados']['id_usuario'];

// =====================================
// PROCESSAR AÇÕES DO CARRINHO
// =====================================

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_produto = filter_input(INPUT_POST, 'id_produto', FILTER_VALIDATE_INT);

    // REMOVER PRODUTO
    if (isset($_POST['remover']) && $id_produto) {

        Carrinho::excluir_produto($id_usuario, $id_produto);

        $_SESSION['mensagem_carrinho'] = [
            'tipo' => 'success',
            'texto' => 'Produto removido do carrinho!'
        ];

    }

    // ALTERAR QUANTIDADE
    elseif ($id_produto && isset($_POST['qtd_carrinho'])) {

        $qtd = filter_input(INPUT_POST, 'qtd_carrinho', FILTER_VALIDATE_INT);
        $estoque = filter_input(INPUT_POST, 'produto_estoque', FILTER_VALIDATE_INT);

        if ($qtd !== false && $qtd !== null && $estoque !== false && $estoque !== null) {

            if ($qtd >= 1 && $qtd <= $estoque) {

                Carrinho::alterar_qtd(
                    $id_usuario,
                    $id_produto,
                    $qtd
                );

                $_SESSION['mensagem_carrinho'] = [
                    'tipo' => 'success',
                    'texto' => 'Quantidade atualizada!'
                ];

            } else {

                $_SESSION['mensagem_carrinho'] = [
                    'tipo' => 'error',
                    'texto' => 'Quantidade inválida ou estoque insuficiente!'
                ];
            }
        }
    }

    // EVITAR REENVIO DO FORMULÁRIO
    header("Location: " . strtok($_SERVER['REQUEST_URI'], '?'));
    exit();
}


// =====================================
// BUSCAR PRODUTOS DO CARRINHO
// =====================================

$sql = "SELECT p.*, cp.quantidade AS qtd_carrinho
        FROM produto p
        JOIN carrinho_possui_produto cp
        ON p.id_produto = cp.id_produto
        WHERE cp.id_usuario = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param('i', $id_usuario);
$stmt->execute();

$resultado = $stmt->get_result();

$produtos = [];

while ($linha = $resultado->fetch_assoc()) {
    $produtos[] = $linha;
}

$stmt->close();


// =====================================
// CALCULAR SUBTOTAL
// =====================================

$subtotal = 0;

foreach ($produtos as $p) {
    $subtotal += (float)$p['preco'] * (int)$p['qtd_carrinho'];
}


// =====================================
// CALCULAR FRETE
// =====================================

function calcular_frete($conexao, $id_usuario)
{
    $sql = "SELECT endereco FROM usuario WHERE id_usuario = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('i', $id_usuario);
    $stmt->execute();

    $resultado = $stmt->get_result();
    $linha = $resultado->fetch_assoc();

    $stmt->close();

    if (!$linha || empty($linha['endereco'])) {
        return null;
    }

    $endereco = strtoupper($linha['endereco']);

    // Identificar UF no endereço
    if (preg_match('/\/\s*([A-Z]{2})\b/', $endereco, $correspondencia)) {
        return $correspondencia[1];
    }

    return null;
}

$uf = calcular_frete($conexao, $id_usuario);

$estados_frete_gratis = ['RS', 'SC', 'PR'];

if (in_array($uf, $estados_frete_gratis)) {
    $frete = 0;
} else {
    $frete = 50;
}

$valor_total = $subtotal + $frete;


// =====================================
// FORMATAÇÃO
// =====================================

function dinheiro($valor)
{
    return number_format((float)$valor, 2, ',', '.');
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Meu Carrinho | BURNOUT</title>

    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="../CSS/produto/carrinho.css">
    <link rel="stylesheet" href="../CSS/header-loja.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>


<!-- =================================
     CABEÇALHO
================================= -->


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

        <a href="catalogo.php" class="nav-link">CATALOGO</a>

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



<!-- =================================
     CONTEÚDO PRINCIPAL
================================= -->

<main class="pagina-carrinho">


    <!-- TÍTULO -->

    <div class="titulo-pagina">

        <span>SEU ESTILO COMEÇA AQUI</span>

        <h1>MEU CARRINHO</h1>

        <p>
            Confira seus produtos antes de finalizar seu pedido.
        </p>

    </div>


    <!-- ÁREA DO CARRINHO -->

    <div class="carrinho-container">


        <!-- =================================
             LISTA DE PRODUTOS
        ================================= -->

        <section class="lista-produtos">


            <?php if (count($produtos) > 0): ?>

                <div class="lista-cabecalho">

                    <h2>SEUS PRODUTOS</h2>

                    <span>
                        <?php echo count($produtos); ?>
                        produto(s)
                    </span>

                </div>


                <?php foreach ($produtos as $p): ?>

                    <?php

                    $nome = htmlspecialchars($p['nome'], ENT_QUOTES, 'UTF-8');

                    $tamanho = htmlspecialchars($p['tamanho'], ENT_QUOTES, 'UTF-8');

                    $foto = htmlspecialchars($p['foto'], ENT_QUOTES, 'UTF-8');

                    $estoque = (int)$p['estoque'];

                    $quantidade = (int)$p['qtd_carrinho'];

                    $preco = (float)$p['preco'];

                    $subtotal_produto = $preco * $quantidade;

                    ?>

                    <article class="produto-card">


                        <!-- IMAGEM -->

                        <div class="produto-foto">

                            <img
                                src="../img_produto/<?php echo $foto; ?>"
                                alt="<?php echo $nome; ?>"
                                style="<?php echo $estoque <= 0 ? 'filter: grayscale(100%);' : ''; ?>"
                            >

                        </div>


                        <!-- INFORMAÇÕES -->

                        <div class="produto-dados">


                            <div class="produto-topo">

                                <div>

                                    <span class="produto-etiqueta">
                                        BURNOUT
                                    </span>

                                    <h3>
                                        <?php echo $nome; ?>
                                    </h3>

                                </div>


                                <!-- REMOVER -->

                                <form method="POST" class="form-remover">

                                    <input
                                        type="hidden"
                                        name="id_produto"
                                        value="<?php echo (int)$p['id_produto']; ?>"
                                    >

                                    <button
                                        type="submit"
                                        name="remover"
                                        value="1"
                                        class="botao-remover"
                                        title="Remover produto"
                                    >

                                        <i class="bi bi-trash3"></i>

                                        <span>Remover</span>

                                    </button>

                                </form>

                            </div>


                            <!-- CARACTERÍSTICAS -->

                            <div class="produto-caracteristicas">

                                <div>

                                    <span>TAMANHO</span>

                                    <strong>
                                        <?php echo $tamanho; ?>
                                    </strong>

                                </div>


                                <div>

                                    <span>ESTOQUE</span>

                                    <strong>
                                        <?php echo $estoque; ?> unidades
                                    </strong>

                                </div>

                            </div>


                            <!-- PREÇO -->

                            <div class="produto-preco">

                                <div>

                                    <span>Preço unitário</span>

                                    <strong>
                                        R$ <?php echo dinheiro($preco); ?>
                                    </strong>

                                </div>

                                <div>

                                    <span>Subtotal</span>

                                    <strong class="subtotal-produto">
                                        R$ <?php echo dinheiro($subtotal_produto); ?>
                                    </strong>

                                </div>

                            </div>


                            <!-- QUANTIDADE -->

                            <form method="POST" class="form-quantidade">

                                <input
                                    type="hidden"
                                    name="id_produto"
                                    value="<?php echo (int)$p['id_produto']; ?>"
                                >

                                <input
                                    type="hidden"
                                    name="produto_estoque"
                                    value="<?php echo $estoque; ?>"
                                >

                                <label>
                                    QUANTIDADE
                                </label>


                                <div class="controle-quantidade">

                                    <button
                                        type="button"
                                        onclick="alterarQuantidade(this, -1)"
                                        <?php echo $quantidade <= 1 ? 'disabled' : ''; ?>
                                    >
                                        −
                                    </button>

                                    <input
                                        type="number"
                                        name="qtd_carrinho"
                                        value="<?php echo $quantidade; ?>"
                                        min="1"
                                        max="<?php echo $estoque; ?>"
                                        required
                                        onchange="this.form.submit()"
                                        <?php echo $estoque <= 0 ? 'disabled' : ''; ?>
                                    >

                                    <button
                                        type="button"
                                        onclick="alterarQuantidade(this, 1)"
                                        <?php echo $quantidade >= $estoque ? 'disabled' : ''; ?>
                                    >
                                        +
                                    </button>

                                </div>

                            </form>


                            <?php if ($estoque <= 0): ?>

                                <div class="aviso-estoque">
                                    <i class="bi bi-exclamation-triangle"></i>
                                    Produto fora de estoque. Remova-o do carrinho.
                                </div>

                            <?php endif; ?>


                        </div>

                    </article>

                <?php endforeach; ?>


            <?php else: ?>


                <!-- CARRINHO VAZIO -->

                <div class="carrinho-vazio">

                    <i class="bi bi-bag-x"></i>

                    <h2>SEU CARRINHO ESTÁ VAZIO</h2>

                    <p>
                        Parece que você ainda não escolheu seus produtos.
                    </p>

                    <a href="catalogo.php">
                        EXPLORAR PRODUTOS
                    </a>

                </div>


            <?php endif; ?>


        </section>



        <!-- =================================
             RESUMO DO PEDIDO
        ================================= -->

        <?php if (count($produtos) > 0): ?>

            <aside class="resumo-pedido">

                <div class="resumo-titulo">

                    <h2>RESUMO DO PEDIDO</h2>

                    <span>BURNOUT</span>

                </div>


                <!-- SUBTOTAL -->

                <div class="resumo-linha">

                    <span>Subtotal dos produtos</span>

                    <strong>
                        R$ <?php echo dinheiro($subtotal); ?>
                    </strong>

                </div>


                <!-- FRETE -->

                <div class="resumo-linha">

                    <span>Frete</span>

                    <strong class="<?php echo $frete == 0 ? 'frete-gratis' : ''; ?>">

                        <?php if ($frete == 0): ?>

                            GRÁTIS

                        <?php else: ?>

                            R$ <?php echo dinheiro($frete); ?>

                        <?php endif; ?>

                    </strong>

                </div>


                <!-- ESTADO -->

                <div class="informacao-frete">

                    <i class="bi bi-truck"></i>

                    <?php if ($frete == 0): ?>

                        Frete grátis para sua região!

                    <?php elseif ($uf === null): ?>

                        Não foi possível identificar seu estado. Consulte seu endereço cadastrado.

                    <?php else: ?>

                        Frete de R$ 50,00 para sua região.

                    <?php endif; ?>

                </div>


                <!-- TOTAL -->

                <div class="resumo-total">

                    <span>VALOR TOTAL</span>

                    <strong>
                        R$ <?php echo dinheiro($valor_total); ?>
                    </strong>

                </div>


                <!-- CONTINUAR COMPRANDO -->

                <a href="catalogo.php" class="botao-continuar">

                    <i class="bi bi-arrow-left"></i>

                    CONTINUAR COMPRANDO

                </a>


                <div class="resumo-seguranca">

                    <i class="bi bi-shield-check"></i>

                    COMPRA COM SEGURANÇA

                </div>

            </aside>

        <?php endif; ?>


    </div>

</main>


<!-- =================================
     RODAPÉ
================================= -->

<footer class="rodape">

    <span>BURNOUT</span>

    <p>ESTILO, QUALIDADE E ATITUDE.</p>

</footer>


<!-- =================================
     JAVASCRIPT
================================= -->

<script>

function alterarQuantidade(botao, valor) {

    const formulario = botao.closest('form');

    const campo = formulario.querySelector('input[name="qtd_carrinho"]');

    const quantidadeAtual = parseInt(campo.value);

    const minimo = parseInt(campo.min);

    const maximo = parseInt(campo.max);

    const novaQuantidade = quantidadeAtual + valor;

    if (novaQuantidade >= minimo && novaQuantidade <= maximo) {

        campo.value = novaQuantidade;

        formulario.submit();

    }

}

</script>


<!-- MENSAGENS -->

<?php if (isset($_SESSION['mensagem_carrinho'])): ?>

    <script>

        Swal.fire({

            icon: <?php echo json_encode($_SESSION['mensagem_carrinho']['tipo']); ?>,

            title: <?php echo json_encode($_SESSION['mensagem_carrinho']['texto']); ?>,

            confirmButtonColor: '#39bf00',

            confirmButtonText: 'OK'

        });

    </script>

    <?php unset($_SESSION['mensagem_carrinho']); ?>

<?php endif; ?>


</body>
</html>

<?php
$conexao->close();
?>
