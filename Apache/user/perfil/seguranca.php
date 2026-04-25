<?php
include_once "../includes/session.php";
?>

<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <title>Segurança</title>
    <link rel="stylesheet" href="../css/css.css">
</head>
<body>
    <?php include '../includes/barratop.php'; ?>
    <?php include '../includes/barralateral.php'; ?>

    <div class="main-content">
        <div style="display:grid; grid-template-columns:250px 1fr; gap:20px;">
            <?php include "../includes/menu_perfil.php"; ?>

            <div class="produto">
                <h2>Segurança</h2>
                <form action="processar_senha.php" method="POST">
                    <label>Nova Senha:</label><br>
                    <input type="password" name="nova_senha" required><br><br>
                    
                    <label>Confirmar Nova Senha:</label><br>
                    <input type="password" name="confirmar_senha" required><br><br>
                    
                    <button type="submit">Atualizar Senha</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>