<?php

include_once "../includes/session.php";
include_once "../includes/ApiClient.php";

$api = new ApiClient();
try {
    $res = $api->get("/api/usuarios/perfil");
    $usuario = $res['data'] ?? [];
} catch (Exception $e) {
    error_log("Erro ao buscar perfil do usuário: " . $e->getMessage());
    $usuario = [];
    $erroBackend = true;
}

$nome = $usuario['nome'] ?? "Não informado";
$username = $usuario['username'] ?? "Não informado";
$email = $usuario['email'] ?? "Não informado";
$tipo = $usuario['tipoDeConta'] ?? "Não informado";
?>

<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <title>Perfil</title>
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

                <h2>Perfil</h2>

                <p><strong>Nome:</strong> <?= htmlspecialchars($nome) ?></p>

                <p><strong>Username:</strong> <?= htmlspecialchars($username) ?></p>

                <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>

                <p><strong>Tipo de conta:</strong> <?= htmlspecialchars($tipo) ?></p>

                <br>

                <a href="editar_perfil.php">
                    <button>✏ Editar Perfil</button>
                </a>

            </div>

        </div>

    </div>

</body>

</html>