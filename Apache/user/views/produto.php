<?php
require_once "../includes/auth.php";

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID do produto não fornecido.";
    exit;
}


require_once '../includes/ApiClient.php';
$api = new ApiClient("http://localhost:8080");
$res = $api->get("/api/produtos/$id");
if ($res['status'] !== 200) {
    echo "Erro ao buscar produto: " . ($res['data']['message'] ?? 'Desconecido');
    exit;
}
$p = $res['data'] ?? null; /*p = produto*/

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($p['nome'] ?? 'Produto sem nome') ?></title>
    <link rel="stylesheet" href="../css/css.css">

</head>

<body>
    <?php include '../includes/barratop.php'; ?>
    <?php include '../includes/barralateral.php'; ?>


<main class="main-content">
    <div class="produto-container">
        <div class="produto-imagem">
            <?php if (!empty($p['imagens'])): ?>
                <img id="imagem-principal" src="http://localhost:8080<?= $p['imagens'][0] ?>" alt="<?= htmlspecialchars($p['nome']) ?>">
                <div class="miniaturas">
                    <?php foreach ($p['imagens'] as $img): ?>
                        <img src="http://localhost:8080<?= $img ?>" onclick="trocarImagem(this.src)" alt="Miniatura">
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="sem-imagem">Imagem não disponível</div>
            <?php endif; ?>
        </div>
        <div class="produto-info">
            <h1><?= htmlspecialchars($p['nome']) ?></h1>
                        <p class="preco">R$ <?= number_format($p['valor'] ?? 0, 2, ",", ".") ?></p>
            <button class="botao-comprar">Adicionar ao carrinho 🛒</button>
        </div>
    </div>
    <div class="produto-descricao">
        <h2>Descrição</h2>
        <p><?= nl2br(htmlspecialchars($p['descricao'] ?? 'Sem descrição disponível.')) ?></p>
</main>

<script>
function trocarImagem(src) {
    document.getElementById('imagem-principal').src = src;
}
</script>
</body>

</html>