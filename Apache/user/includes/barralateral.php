<?php
$jsonPath = dirname(__DIR__, 2) . "/admin/data/filtros.json";
$json = file_get_contents($jsonPath);
$categorias = json_decode($json, true);
?>

<div class="barra-lateral">
    <nav class="nav-lateral">
        <?php foreach ($categorias as $categoria): ?>
            <a href="categoria.php?id=<?= $categoria['id'] ?>" class="sub_menu"><?= $categoria['nome'] ?></a>
        <?php endforeach; ?>
    </nav>
</div>
