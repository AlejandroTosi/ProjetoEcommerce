<?php
session_start();

// Exemplo rápido de produtos (substituir depois pela API)
$produtos = [
    ["nome" => "Smartphone Galaxy M55", "preco" => 2399.90, "imagem" => "temporario/produto1.webp"],
    ["nome" => "Fone Headset Gamer", "preco" => 299.90, "imagem" => "temporario/produto2.webp"],
    ["nome" => "Cafeteira Expresso Automática", "preco" => 499.90, "imagem" => "temporario/produto3.webp"],
    ["nome" => "Miniatura Blood Ravens", "preco" => 149.90, "imagem" => "temporario/produto4.webp"],
    ["nome" => "Camisa Casual Masculina", "preco" => 89.90, "imagem" => "temporario/produto5.webp"],
    ["nome" => "Perfume Eau de Parfum", "preco" => 219.90, "imagem" => "temporario/produto6.webp"],
    ["nome" => "Notebook Gamer 16GB RAM", "preco" => 5299.00, "imagem" => "temporario/produto7.webp"],
    ["nome" => "Liquidificador 800W", "preco" => 199.90, "imagem" => "temporario/produto8.webp"],
];
?>
<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>
    <link rel="stylesheet" href="css/css.css">
</head>

<body>
    <?php include 'includes/barratop.php';?>
    <?php include 'includes/barralateral.php';?>

    <main class="main-content">
        <div class="ad">Banner de Anúncio aqui</div>

        <div class="promocoes">
            <?php foreach($produtos as $p): ?>
            <div class="produto">
                <img src="<?= htmlspecialchars($p['imagem']) ?>" alt="<?= htmlspecialchars($p['nome']) ?>" style="width:100%; height:120px; object-fit:cover; border-radius:4px; margin-bottom:10px;">
                <h3><?= htmlspecialchars($p['nome']) ?></h3>
                <p>R$ <?= number_format($p['preco'],2,",",".") ?></p>
                <button>Adicionar ao Carrinho</button>
            </div>
            <?php endforeach; ?>
        </div>
    </main>
</body> 
</html>
