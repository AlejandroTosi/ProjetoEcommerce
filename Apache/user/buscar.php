<?php
include_once "includes/session.php";
include_once "includes/ApiClient.php";

$api = new ApiClient();
$erroBackend = false;

$categoriaId = $_GET['categoria'] ?? null;
$busca = trim($_GET['q'] ?? '');

$params = [];

if (!empty($categoriaId)) {
    $params['categoriaId'] = $categoriaId;
}

if ($busca !== '') {
    $params['q'] = $busca;
}

$query = $params ? "?" . http_build_query($params) : "";

try {
    $res = $api->get("/api/produtos/buscar" . $query);
} catch (Exception $e) {
    error_log("Erro ao buscar produtos: " . $e->getMessage());
    $produtos = [];
    $erroBackend = true;
}

$viewproduto = "http://localhost/user/views/produto.php?id=";
$produtos = $res['data'] ?? [];
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Resultados da busca</title>
    <link rel="stylesheet" href="../user/css/css.css">
</head>

<body>

    <?php include '../user/includes/barratop.php'; ?>
    <?php include '../user/includes/barralateral.php'; ?>

    <main class="main-content">

        <?php if ($erroBackend): ?>
            <?php include '../user/includes/backend_error.php'; ?>
        <?php endif; ?>

        <h2>Resultados da busca</h2>

        <div class="promocoes">

            <?php if (empty($produtos)): ?>

                <p>Nenhum produto encontrado.</p>

            <?php else: ?>

                <?php foreach ($produtos as $p): ?>

                    <?php
                    $nome = $p['nome'] ?? 'Produto sem nome';
                    $preco = $p['preco'] ?? 0;

                    $imagem = !empty($p['imagens'][0]['endereco'])
                        ? "http://localhost:8080" . $p['imagens'][0]['endereco']
                        : "../imagens/default.png";

                    $produto_endereco = $viewproduto . ($p['id'] ?? '');
                    ?>

                    <a href="<?= htmlspecialchars($produto_endereco) ?>" class="produto-link">
                        <div class="produto">

                            <img 
                                src="<?= htmlspecialchars($imagem) ?>" 
                                alt="<?= htmlspecialchars($nome) ?>"
                            >

                            <h3><?= htmlspecialchars($nome) ?></h3>

                            <p>R$ <?= number_format($preco, 2, ",", ".") ?></p>

                        </div>
                    </a>

                <?php endforeach; ?>

            <?php endif; ?>

        </div>

    </main>

</body>

</html>