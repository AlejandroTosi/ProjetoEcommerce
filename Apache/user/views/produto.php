<?php
require_once "../includes/auth.php";
require_once '../includes/ApiClient.php';

$id = $_GET['id'] ?? null;
$apiUrl = "http://localhost:8080";

if (!$id) {
    header("Location: /user/index.php"); // Redireciona se não houver ID
    exit;
}

$api = new ApiClient($apiUrl);
$res = $api->get("/api/produtos/$id");

// Verifica se o backend retornou erro ou se o produto não existe
if ($res['status'] !== 200 || empty($res['data'])) {
    $produtoNaoEncontrado = true;
    $p = null;
} else {
    $p = $res['data'];
    $produtoNaoEncontrado = false;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($p['nome'] ?? 'Produto não encontrado') ?></title>
    <link rel="stylesheet" href="../css/css.css">
</head>

<body>
    <?php include '../includes/barratop.php'; ?>
    <?php include '../includes/barralateral.php'; ?>

    <main class="main-content">
        <?php if ($produtoNaoEncontrado): ?>
            <div class="error-msg">
                <h2>Ops! Produto não encontrado.</h2>
                <p>O produto que você procura não existe ou foi removido.</p>
                <a href="index.php">Voltar para a loja</a>
            </div>
        <?php else: ?>
            <div class="produto-container">
                <div class="produto-imagem">
                    <?php if (!empty($p['imagens'])): ?>
                        <img id="imagem-principal"
                            src="<?= htmlspecialchars($apiUrl . $p['imagens'][0]) ?>"
                            alt="<?= htmlspecialchars($p['nome']) ?>">

                        <div class="miniaturas">
                            <?php foreach ($p['imagens'] as $img): ?>
                                <img src="<?= htmlspecialchars($apiUrl . $img) ?>"
                                    onclick="trocarImagem(this.src)"
                                    alt="Miniatura"
                                    style="cursor:pointer;">
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="sem-imagem">Imagem não disponível</div>
                    <?php endif; ?>
                </div>

                <div class="produto-info">
                    <h1><?= htmlspecialchars($p['nome']) ?></h1>
                    <p class="preco">R$ <?= number_format($p['valor'] ?? 0, 2, ",", ".") ?></p>

                    <button class="botao-comprar"
                        data-id="<?= (int)$p['id'] ?>"
                        id="btn-carrinho">
                        Adicionar ao carrinho 🛒
                    </button>
                </div>
            </div>

            <div class="produto-descricao">
                <h2>Descrição</h2>
                <p><?= nl2br(htmlspecialchars($p['descricao'] ?? 'Sem descrição disponível.')) ?></p>
            </div>
        <?php endif; ?>
    </main>

    <script src="../js/getCookie.js"></script>
    <script>
        function trocarImagem(src) {
            document.getElementById('imagem-principal').src = src;
        }

        document.getElementById('btn-carrinho')?.addEventListener('click', async function() {
            const btn = this;
            const produtoId = Number(btn.dataset.id);
            const token = getCookie("jwt");

            btn.disabled = true;
            btn.innerText = "Adicionando...";

            try {
                const response = await fetch('/user/includes/adicionar_carrinho.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        produto_id: produtoId,
                        token: token
                    }),
                    credentials: 'same-origin'
                });

                const data = await response.json();

                if (data.status === 200) {
                    alert("Produto adicionado ao carrinho! 🛒");
                } else {
                    alert("Erro: " + (data.message || "Não foi possível adicionar."));
                }
            } catch (error) {
                console.error("Erro na requisição:", error);
                alert("Erro de conexão com o servidor.");
            } finally {

                btn.disabled = false;
                btn.innerText = "Adicionar ao carrinho 🛒";
            }
        });
    </script>
</body>

</html>