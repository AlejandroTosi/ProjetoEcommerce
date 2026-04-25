<?php
require_once "includes/auth.php";
require_once "includes/ApiClient.php";

$apiUrl = "http://localhost:8080";
$api = new ApiClient($apiUrl);

// =============================
// Carrega dados estáticos
// =============================
$json = file_get_contents(__DIR__ . '/data/filtros.json');
$dados = json_decode($json, true);

$categorias   = $dados['categorias']   ?? [];
$fornecedores = $dados['fornecedores'] ?? [];

// =============================
// Entrada de dados
// =============================
$acao = $_REQUEST['acao'] ?? null;

$categoriaId  = $_GET['categoria']  ?? '';
$fornecedorId = $_GET['fornecedor'] ?? '';
$ativo        = $_GET['ativo']      ?? '';
$busca        = trim($_GET['q'] ?? '');

$erroBackend = false;
$mensagemErro = null;
$produtos = null;

// =============================
// Montagem dinâmica dos filtros
// =============================
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

if ($busca !== '') {
    $params['q'] = $busca;
}

$query = $params ? "?" . http_build_query($params) : "";

// =============================
// ALTERAR ESTOQUE
// =============================
if ($acao === "alterar") {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        die("Método inválido.");
    }

    if (empty($_POST['id']) || empty($_POST['quantidade'])) {
        die("Preencher todos os campos.");
    }

    try {
        $alteracao = $api->put(
            "/api/estoque",
            [
                "id" => $_POST['id'],
                "quantidade" => $_POST['quantidade']
            ]
        );

        if (!isset($alteracao['status']) || $alteracao['status'] !== 200) {
            $erroBackend = true;
            $mensagemErro = "Erro ao alterar estoque.";
        }

    } catch (Exception $e) {
        error_log("Erro ao alterar estoque: " . $e->getMessage());
        $erroBackend = true;
        $mensagemErro = "Erro ao conectar com backend.";
    }

}

// =============================
// PESQUISAR PRODUTOS
// =============================
elseif ($acao === "pesquisar") {

    if (!empty($params)) {

        try {
            $res = $api->get("/api/produtos/buscar" . $query);

            if (isset($res['status']) && $res['status'] === 200) {
                $produtos = $res['data'] ?? [];
            } else {
                $produtos = [];
                $erroBackend = true;
                $mensagemErro = "Erro ao buscar produtos.";
            }

        } catch (Exception $e) {
            error_log("Erro ao buscar produtos: " . $e->getMessage());
            $produtos = [];
            $erroBackend = true;
            $mensagemErro = "Erro ao conectar com backend.";
        }
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
                <option value="<?= $cat['id'] ?>" <?= $categoriaId === $cat['id'] ? 'selected' : '' ?>>
                    <?= $cat['nome'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="fornecedor">
            <option value="">Todos fornecedores</option>
            <?php foreach ($fornecedores as $forn): ?>
                <option value="<?= $forn['id'] ?>" <?= $fornecedorId === $forn['id'] ? 'selected' : '' ?>>
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
        <input type="hidden" name="acao" value="pesquisar">

    </form>

    <div class="resultados-busca">

        <?php if ($produtos === null): ?>
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
                        <th>Quantidade</th>
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

    <div>
        <h2> Gerenciamento de Estoque</h2>
        <form action="estoque.php" method="post">
            <input type="text" name="id" placeholder="ID do produto">
            <input type="text" name="quantidade" placeholder="Nova quantidade">
            <button type="submit">Alterar Estoque</button>
            <input type="hidden" name="acao" value="alterar">
        </form>
    </div>
    <p>Use os filtros acima e clique em Pesquisar ou Alterar Estoque.</p>

</body>

</html>