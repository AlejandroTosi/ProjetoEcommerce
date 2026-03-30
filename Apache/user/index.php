<?php
include_once "includes/session.php";
include_once "includes/ApiClient.php";


// Try catch que permite renderizar a home mesmo que o backend esteja com problemas
try {
    $api = new ApiClient("http://localhost:8080");
    $res = $api->get("/api/home");
} catch (Exception $e) {
    error_log("Erro ao buscar produtos para a home: " . $e->getMessage());
    $res = ['data' => []];
    $erroBackend = true;
}
$produtos = $res['data'] ?? [];
$viewproduto = "http://localhost/user/views/produto.php?id=";


// Ordena por posição, evita warnings se faltar a chave 'posicao'
usort($produtos, fn($a, $b) => ($a['posicao'] ?? 0) <=> ($b['posicao'] ?? 0));


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

    <?php include '../user/includes/backend_error.php'; ?>


        <div class="ad">Banner de Anúncio aqui</div>

<div class="promocoes">
<?php foreach($produtos as $p): ?>
    <?php
        $nome = $p['nome'] ?? 'Produto sem nome';
        $preco = $p['preco'] ?? 0;
        $imagem = !empty($p['imagem']) ? "http://localhost:8080" . $p['imagem'] : "../imagens/default.png";
        $posicao = $p['posicao'] ?? 0;
        $produto_endereco = $viewproduto . ($p['id'] ?? '');
    ?>
        <a href="<?= htmlspecialchars($produto_endereco) ?>" class="produto-link">
            <div class="produto" data-posicao="<?= $posicao ?>">
            <img src="<?= htmlspecialchars($imagem) ?>" alt="<?= htmlspecialchars($nome) ?>">
            <h3><?= htmlspecialchars($nome) ?></h3>
            <p>R$ <?= number_format($preco, 2, ",", ".") ?></p>
        
        </div>
        </a>
<?php endforeach; ?>
</div>

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