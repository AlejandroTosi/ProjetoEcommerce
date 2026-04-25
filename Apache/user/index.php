<?php
include_once "includes/session.php";
include_once "includes/ApiClient.php";

$apiUrl = "http://localhost:8080";
$viewproduto = "http://localhost/user/views/produto.php?id=";
$erroBackend = false;
try {
    $api = new ApiClient($apiUrl);
    $res = $api->get("/api/home");
} catch (Exception $e) {
    error_log("Erro ao buscar produtos para a home: " . $e->getMessage());
    $res = ['data' => []];
    $erroBackend = true;
}
$produtos = $res['data'] ?? [];

usort($produtos, fn($a, $b) => ($a['posicao'] ?? 0) <=> ($b['posicao'] ?? 0));
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>
    <link rel="stylesheet" href="../user/css/css.css">
</head>

<body>

    <?php include '../user/includes/barratop.php'; ?>
    <?php include '../user/includes/barralateral.php'; ?>

    <main class="main-content">
        <?php include '../user/includes/backend_error.php'; ?>

        <div class="ad">Banner de Anúncio aqui</div>

        <div class="promocoes">
            <?php if (empty($produtos)): ?>
                <p>Nenhum produto disponível no momento.</p>
            <?php else: ?>
                <?php foreach ($produtos as $p):
                    $nome = $p['nome'] ?? 'Produto sem nome';
                    $preco = $p['preco'] ?? 0;
                    $imagem = !empty($p['imagem']) ? $apiUrl . $p['imagem'] : "../imagens/default.png";
                    $id = $p['id'] ?? '';
                ?>
                    <a href="<?= htmlspecialchars($viewproduto . $id) ?>" class="produto-link">
                        <div class="produto" data-posicao="<?= (int)($p['posicao'] ?? 0) ?>">
                            <img src="<?= htmlspecialchars($imagem) ?>" alt="<?= htmlspecialchars($nome) ?>" loading="lazy">

                            <div class="produto-info-home">
                                <h3><?= htmlspecialchars($nome) ?></h3>
                                <p>R$ <?= number_format($preco, 2, ",", ".") ?></p>
                            </div>

                            <div class="btn-adicionar">Adicionar ao Carrinho</div>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

    <script>
        console.log("Página carregada com sucesso.");
    </script>
</body>

</html>