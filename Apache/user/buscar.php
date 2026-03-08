<?php


// ======================================================
// Captura os parâmetros enviados via GET
// ======================================================
$categoriaId = $_GET['categoria'] ?? null;  // ID da categoria selecionada (opcional)
$busca = $_GET['q'] ?? null;               // Termo de busca (opcional)

// ======================================================
// Prepara os parâmetros para consulta no backend Java
// ======================================================
$params = [];

// Adiciona categoria apenas se houver valor numérico válido
if (isset($categoriaId) && $categoriaId !== "") {
    $params['categoriaId'] = $categoriaId;
}

// Adiciona termo de busca apenas se houver conteúdo não vazio
if (isset($busca) && trim($busca) !== "") {
    $params['q'] = $busca;
}

// ======================================================
// Monta a URL completa da API, incluindo query string
// ======================================================
$url = "http://localhost:8080/api/produtos/buscar";
if (!empty($params)) {
    $url .= '?' . http_build_query($params);
}

// ======================================================
// Configuração do contexto HTTP
// - ignore_errors: permite capturar respostas mesmo com códigos de erro HTTP
// ======================================================
$options = [
    "http" => [
        "method" => "GET",
        "ignore_errors" => true
    ]
];
$context = stream_context_create($options);

// ======================================================
// Executa a requisição HTTP para o backend
// ======================================================
$response = @file_get_contents($url, false, $context);

// ======================================================
// Depuração: exibe a URL final e status HTTP retornado pelo backend
// ======================================================
if (isset($http_response_header)) {
    echo "<p>URL final: " . htmlspecialchars($url) . "</p>";
    echo "<p>Status HTTP: " . $http_response_header[0] . "</p>";
}

// ======================================================
// Valida se a requisição foi bem-sucedida
// ======================================================
if ($response === false) {
    die("<p>Erro ao conectar com o backend Java. Verifique se o serviço está ativo e se a URL está correta.</p>");
}

// ======================================================
// Decodifica a resposta JSON do backend
// ======================================================
$produtos = json_decode($response, true);
if ($produtos === null) {
    die("<p>Erro ao decodificar resposta JSON do backend. Verifique o formato retornado.</p>");
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Resultados da busca</title>
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/menus.css">
</head>
<body>
    <?php include 'includes/barratop.php'; ?>
    <?php include 'includes/barralateral.php'; ?>

    <main class="main-content">
        <h2>Resultados da busca</h2>

        <div class="resultados-busca">
        <?php if (empty($produtos)): ?>
            <p>Nenhum produto encontrado.</p>
        <?php else: ?>
            <?php foreach ($produtos as $p): ?>
                <div class="produto">
                    <h3><?= htmlspecialchars($p['nome']) ?></h3>
                    <p>R$ <?= number_format($p['valor'], 2, ',', '.') ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        </div>
    </main>
</body>
</html>