<?php
$jsonPath = dirname(__DIR__, 2) . "/admin/data/filtros.json";
$json = file_get_contents($jsonPath);
$filtros = json_decode($json, true);
$categorias = $filtros['categorias'];
?>

<div class="barra-lateral">
    <nav class="nav-lateral">
        <?php foreach ($categorias as $categoria): ?>
            <a class="sub_menu" href="buscar.php?categoria=<?= $categoria['id'] ?>&q=">
                <?= htmlspecialchars($categoria['nome']) ?>
            </a>
        <?php endforeach; ?>
    </nav>
</div>