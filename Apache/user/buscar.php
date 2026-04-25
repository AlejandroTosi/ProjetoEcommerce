<?php
include_once "includes/session.php";
include_once "includes/ApiClient.php";

$apiUrl = "http://localhost:8080";
$viewproduto = "http://localhost/user/views/produto.php?id=";
$api = new ApiClient($apiUrl);

$erroBackend = false;
$categoriaId = $_GET['categoria'] ?? null;
$busca = trim($_GET['q'] ?? '');

// Montagem dinâmica dos parâmetros
$params = [];
if (!empty($categoriaId)) $params['categoriaId'] = $categoriaId;
if ($busca !== '') $params['q'] = $busca;

$query = $params ? "?" . http_build_query($params) : "";

try {
    $res = $api->get("/api/produtos/buscar" . $query);

    // Verifica se a resposta foi bem-sucedida
    if (isset($res['status']) && $res['status'] === 200) {
        $produtos = $res['data'] ?? [];
    } else {
        $produtos = [];
        $erroBackend = true;
    }
} catch (Exception $e) {
    error_log("Erro ao buscar produtos: " . $e->getMessage());
    $produtos = [];
    $erroBackend = true;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Resultados da busca - <?= htmlspecialchars($busca ?: 'Todos os produtos') ?></title>
    <link rel="stylesheet" href="../user/css/css.css">
</head>

<body>

    <?php include '../user/includes/barratop.php'; ?>
    <?php include '../user/includes/barralateral.php'; ?>

    <main class="main-content">

        <?php if ($erroBackend): ?>
            <?php include '../user/includes/backend_error.php'; ?>
        <?php endif; ?>

        <h2>
            <?= $busca !== '' ? "Resultados para: '" . htmlspecialchars($busca) . "'" : "Todos os produtos" ?>
        </h2>

        <div class="promocoes">
            <?php if (empty($produtos)): ?>
                <div class="no-results">
                    <p>Nenhum produto encontrado para sua busca ou categoria.</p>
                    <a href="index.php" class="btn-voltar">Ver todos os produtos</a>
                </div>
            <?php else: ?>
                <?php foreach ($produtos as $p):
                    $nome = $p['nome'] ?? 'Produto sem nome';
                    $preco = $p['preco'] ?? 0;
                    $imagem = !empty($p['imagens'][0])
                        ? $apiUrl . $p['imagens'][0]
                        : "../imagens/default.png";
                    $link = $viewproduto . ($p['id'] ?? '');
                ?>
                    <div class="produto">
                        <a href="<?= htmlspecialchars($link) ?>" class="produto-link">
                            <img src="<?= htmlspecialchars($imagem) ?>" alt="<?= htmlspecialchars($nome) ?>" loading="lazy">
                            <h3><?= htmlspecialchars($nome) ?></h3>
                            <p class="preco">R$ <?= number_format($preco, 2, ",", ".") ?></p>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
</body>

</html>