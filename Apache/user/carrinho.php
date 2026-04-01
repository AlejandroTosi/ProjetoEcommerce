<?php
include_once "includes/session.php";
include_once "includes/ApiClient.php";


// Try catch que permite renderizar a home mesmo que o backend esteja com problemas
$erroBackend = false;
try {
    $api = new ApiClient("http://localhost:8080");
    $res = $api->get("/api/carrinho");
} catch (Exception $e) {
    error_log("Erro ao buscar items do carrinho: " . $e->getMessage());
    $res = ['data' => []];
    $erroBackend = true;
}
$produtos = $res['data'] ?? [];

?>




<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <title>Carrinho</title>
    <link rel="stylesheet" href="css/css.css">
</head>

<body>

<?php include 'includes/barratop.php'; ?>
<?php include 'includes/barralateral.php'; ?>

<div class="main-content">

<?php include 'includes/backend_error.php'; ?>

<h2>🛒 Meu Carrinho</h2>

<?php if (empty($produtos)): ?>
    <div class="produto">
        <p>Seu carrinho está vazio.</p>
    </div>

<?php else: ?>

<div style="display: grid; grid-template-columns: 1fr 300px; gap: 20px;">

    <!-- LISTA DE PRODUTOS -->
    <div>

        <?php 
        $total = 0;
        foreach($produtos as $item): 
            $nome = $item['nome'];
            $preco = $item['preco'];
            $qtd = $item['quantidade'];
            $imagem = !empty($item['imagem']) 
                ? "http://localhost:8080" . $item['imagem'] 
                : "../imagens/default.png";

            $subtotal = $preco * $qtd;
            $total += $subtotal;
        ?>

        <div class="produto" style="display:flex; gap:20px; align-items:center;">

            <img src="<?= htmlspecialchars($imagem) ?>" style="width:120px; height:120px; object-fit:cover;">

            <div style="flex:1;">
                <h3><?= htmlspecialchars($nome) ?></h3>

                <p>Preço: R$ <?= number_format($preco, 2, ",", ".") ?></p>

                <p>Quantidade: <?= $qtd ?></p>

                <p><strong>Subtotal: R$ <?= number_format($subtotal, 2, ",", ".") ?></strong></p>

                <div style="margin-top:10px;">
                    <a href="remover_carrinho.php?id=<?= $item['id'] ?>">
                        <button style="background-color:#c43b1e; color:white;">
                            Remover
                        </button>
                    </a>
                </div>
            </div>

        </div>

        <?php endforeach; ?>

    </div>

    <!-- RESUMO -->
    <div class="produto">

        <h3>Resumo</h3>

        <p><strong>Total:</strong></p>
        <p style="font-size:22px; color:var(--amazon-orange);">
            R$ <?= number_format($total, 2, ",", ".") ?>
        </p>

        <br>

        <a href="checkout.php">
            <button class="botao-comprar" style="width:100%;">
                Finalizar Compra
            </button>
        </a>

    </div>

</div>

<?php endif; ?>

</div>

</body>
</html>