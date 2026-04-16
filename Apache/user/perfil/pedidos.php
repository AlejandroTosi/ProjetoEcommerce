<?php
include_once "../includes/session.php";
?>

<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <title>Pedidos</title>
    <link rel="stylesheet" href="../css/css.css">
</head>

<body>

    <?php include '../includes/barratop.php'; ?>
    <?php include '../includes/barralateral.php'; ?>

    <div class="main-content">

        <div style="display:grid; grid-template-columns:250px 1fr; gap:20px;">

            <?php include "../includes/menu_perfil.php"; ?>

            <div class="produto">

                <h2>Meus Pedidos</h2>

                <p>Devido a falta de conhecimento em relação a pagamentos, pedido.php e checkout.php ainda não estão implementados.</p>

            </div>

        </div>

    </div>

</body>

</html>