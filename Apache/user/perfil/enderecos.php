<?php
include_once "../includes/session.php";
include_once "../includes/ApiClient.php";

$api = new ApiClient();
$erroBackend = null;

try {
    $res = $api->get("/api/usuarios/perfil");
    $enderecos = $res['data']['enderecos'] ?? [];
} catch (Exception $e) {
    error_log("Erro ao buscar endereços: " . $e->getMessage());
    $enderecos = [];
    $erroBackend = true;
}
?>

<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <title>Meus Endereços</title>
    <link rel="stylesheet" href="../css/css.css">
</head>
<body>
    <?php include '../includes/barratop.php'; ?>
    <?php include '../includes/barralateral.php'; ?>

    <div class="main-content">
        <?php include '../../user/includes/backend_error.php'; ?>

        <div style="display:grid; grid-template-columns:250px 1fr; gap:20px;">
            <?php include "../includes/menu_perfil.php"; ?>

            <div class="produto">
                <h2>Meus Endereços</h2>
                
                <?php if (empty($enderecos)): ?>
                    <p>Nenhum endereço cadastrado.</p>
                <?php else: ?>
                    <?php foreach ($enderecos as $end): ?>
                        <div style="border-bottom: 1px solid #ccc; padding: 10px 0;">
                            <p><strong><?= htmlspecialchars($end['rua']) ?>, <?= htmlspecialchars($end['numero']) ?></strong></p>
                            <p><?= htmlspecialchars($end['cidade']) ?> - <?= htmlspecialchars($end['estado']) ?></p>
                            <p>CEP: <?= htmlspecialchars($end['cep']) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                
                <br>
                <button onclick="alert('Funcionalidade de adicionar em breve')">+ Adicionar Endereço</button>
            </div>
        </div>
    </div>
</body>
</html>