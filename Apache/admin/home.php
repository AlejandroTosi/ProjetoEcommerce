<?php
require_once "includes/auth.php";

include_once "../user/includes/ApiClient.php";

$api = new ApiClient();
$res = $api->get("/api/home");


$produtos = $res['data'] ?? [];

// Ordena por posição, evita warnings se faltar a chave 'posicao'
usort($produtos, fn($a, $b) => ($a['posicao'] ?? 0) <=> ($b['posicao'] ?? 0));



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'adicionar') {
        $idProduto = (int) $_POST['id'];
        $posicao = (int) $_POST['posicao'];

        // Chamar API para adicionar produto
        $api->post("/api/home", ['produtoId' => $idProduto, 'posicao' => $posicao]);

    } elseif ($action === 'deletar') {
        $posicao = (int) $_POST['posicao'];

        $api->delete("/api/home/{$posicao}");
    }

    // Redireciona para evitar resubmissão
    header("Location: home.php");
    exit;
}


?>
<!DOCTYPE html>
<html lang="PT-BR">
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
        <div class="ad">Banner de Anúncio aqui</div>

<div class="promocoes">
<?php foreach($produtos as $p): ?>
    <?php
        $nome = $p['nome'] ?? 'Produto sem nome';
        $preco = $p['preco'] ?? 0;
        $imagem = !empty($p['imagem']) ? "http://localhost:8080" . $p['imagem'] : "../imagens/default.png";
        $posicao = $p['posicao'] ?? 0;
    ?>
    <div class="produto" data-posicao="<?= $posicao ?>">
        <img src="<?= htmlspecialchars($imagem) ?>" alt="<?= htmlspecialchars($nome) ?>">
        <h3><?= htmlspecialchars($nome) ?></h3>
        <p>R$ <?= number_format($preco, 2, ",", ".") ?></p>
        
        <!-- Botão deletar -->
        <form method="post">
            <input type="hidden" name="posicao" value="<?= $posicao ?>">
            <button type="submit">Deletar</button>
            <input type="hidden" name="action" value="deletar">
            <input type="hidden" name="id" value="<?= $posicao ?>">
        </form>
    </div>
<?php endforeach; ?>
</div>


<!-- Adicionar Produtos -->
<h2>Adicionar Produto ao Home</h2>
<form method="post" action="home.php">
        <input type="number" name="id" placeholder="ID do Produto" required>
        <input type="number" name="posicao" placeholder="Posição" required>
        <button type="submit">Adicionar</button>
        <input type="hidden" name="action" value="adicionar">
</form>

    </main>

    <script> 
    document.querySelectorAll('.btn-editar').forEach(btn => {
    btn.addEventListener('click', function() {
        const produtoDiv = this.closest('.produto');
        const form = produtoDiv.querySelector('.form-editar');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    });
});
    </script>
</body> 
</html>