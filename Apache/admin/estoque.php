<?php
require_once "includes/auth.php";

// =============================
// Carrega Json com dados estaticos
// =============================

$json = file_get_contents(__DIR__ . '/data/filtros.json');
$dados = json_decode($json, true);

$categorias = $dados['categorias'];
$fornecedores = $dados['fornecedores'];


$categoriaId  = $_GET['categoria']  ?? '';
$fornecedorId = $_GET['fornecedor'] ?? '';
$ativo        = $_GET['ativo']      ?? '';
$busca        = $_GET['q']          ?? '';

$params = [];

if ($categoriaId !== '') {
    $params['categoriaId'] = $categoriaId;
}

if ($fornecedorId !== '') {
    $params['fornecedorId'] = $fornecedorId;
}

if ($ativo !== '') {
    $params['ativo'] = $ativo;
}

if (trim($busca) !== '') {
    $params['q'] = $busca;
}

// =============================
// Só busca se houver filtro
// =============================
$produtos = null;

if (!empty($params)) {

    $url = "http://localhost:8080/api/produtos/buscar";
    $url .= '?' . http_build_query($params);

    $options = [
        "http" => [
            "method" => "GET",
            "ignore_errors" => true
        ]
    ];
    $context = stream_context_create($options);

    $response = @file_get_contents($url, false, $context);

    if ($response === false) {
        die("Erro ao conectar com backend.");
    }

    $produtos = json_decode($response, true);
    if ($produtos === null) {
        die("Erro ao decodificar JSON.");
    }
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Pesquisa de Estoque</title>
    <link rel="stylesheet" href="css/css.css">
</head>

<body>

    <?php include 'includes/barratop_admin.php'; ?>


    <h2>Pesquisa de Estoque</h2>

    <form method="get" class="pesquisa">
        <select name="categoria">
            <option value="">Todas categorias</option>
            <?php foreach ($categorias as $cat): ?>
                <option value="<?= $cat['id'] ?>">
                    <?= $cat['nome'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="fornecedor">
            <option value="">Todos fornecedores</option>
            <?php foreach ($fornecedores as $forn): ?>
                <option value="<?= $forn['id'] ?>">
                    <?= $forn['nome'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="ativo">
            <option value="">Todos</option>
            <option value="true">Ativos</option>
            <option value="false">Inativos</option>
        </select>

        <input type="text" name="q" placeholder="Buscar por nome, descrição...">

        <button type="submit">Pesquisar</button>
    </form>

    <div class="resultados-busca">

        <?php if ($produtos === null): ?>

            <p>Use os filtros acima e clique em Pesquisar.</p>

        <?php elseif (empty($produtos)): ?>

            <p>Nenhum produto encontrado.</p>

        <?php else: ?>

            <table class="tabela-produtos">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Categoria</th>
                        <th>Valor</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($produtos as $p): ?>
                        <tr>
                            <td><?= htmlspecialchars($p['id']) ?></td>
                            <td><?= htmlspecialchars($p['nome']) ?></td>
                            <td><?= htmlspecialchars($p['descricao'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($p['categoria'] ?? 'N/A') ?></td>
                            <td>R$ <?= number_format($p['valor'], 2, ',', '.') ?></td>
                            <td><?= htmlspecialchars($p['quantidade'] ?? 'Não encontrado') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        <?php endif; ?>

    </div>

</body>

</html>