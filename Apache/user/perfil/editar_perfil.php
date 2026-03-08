<?php
include_once "../includes/session.php";
include_once "../includes/ApiClient.php";

$api = new ApiClient();

$res = $api->get("/api/usuarios/perfil");
$usuario = $res['data'] ?? [];

$nome = $usuario['nome'] ?? "";
$email = $usuario['email'] ?? "";

$mensagem = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = $_POST["nome"] ?? "";
    $email = $_POST["email"] ?? "";

    $update = $api->put("/api/usuarios", [
        "nome" => $nome,
        "email" => $email
    ]);

    if ($update["status"] === 200) {
        header("Location: perfil.php");
        exit;
    } else {
        $mensagem = "Erro ao atualizar perfil.";
    }
}
?>

<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="../css/css.css">
</head>

<body>

<?php include '../includes/barratop.php'; ?>
<?php include '../includes/barralateral.php'; ?>

<div class="main-content">

    <div class="produto">

        <h2>Editar Perfil</h2>

        <?php if ($mensagem): ?>
            <p style="color:red;">
                <?= htmlspecialchars($mensagem) ?>
            </p>
        <?php endif; ?>

        <form method="POST">

            <p>
                <label>Nome</label><br>
                <input type="text" name="nome" value="<?= htmlspecialchars($nome) ?>" required>
            </p>

            <p>
                <label>Email</label><br>
                <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
            </p>

            <br>

            <button type="submit">Salvar</button>

        </form>

    </div>

</div>

</body>
</html>