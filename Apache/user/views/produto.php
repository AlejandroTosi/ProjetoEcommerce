<?php
require_once "../includes/auth.php";

$id = $_GET['id'] ?? null;
$erroBackend = false;
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
        <?php if ($erroBackend): ?>

            <?php include '../user/includes/backend_error.php'; ?>

        <?php endif; ?>
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
                <button
                    class="botao-comprar"
                    data-id="<?= $p['id'] ?>"
                    id="btn-carrinho">
                    Adicionar ao carrinho 🛒
                </button>
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

        document.getElementById('btn-carrinho').addEventListener('click', async function() {

            const produtoId = this.dataset.id;

            try {
                const response = await fetch('/user/includes/adicionar_carrinho.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        produto_id: produtoId
                    }),
                    credentials: 'same-origin'
                });

                const data = await response.json();

                if (data.status === 200) {
                    alert("Produto adicionado ao carrinho 🛒");
                } else {
                    alert("Erro ao adicionar produto.");
                }

            } catch (error) {
                console.error(error);
                alert("Erro de conexão.");
            }
        });
    </script>
</body>

</html>