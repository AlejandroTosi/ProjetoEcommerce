<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../includes/ApiClient.php";

$api = new ApiClient("http://localhost:8080");
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action = $_POST['action'] ?? '';

    try {

        if ($action === 'login') {

            $res = $api->post("/api/usuarios/login", [
                'username' => $_POST['nome'] ?? '',
                'senha'    => $_POST['senha'] ?? ''
            ]);

            if ($res['status'] === 200 && isset($res['data']['id'])) {

                session_regenerate_id(true);

                $_SESSION['user'] = [
                    'id'    => $res['data']['id'],
                    'nome'  => $res['data']['nome'],
                    'token' => $res['data']['token']
                ];

                setcookie("jwt", $res['data']['token'], [
                    'expires' => time() + 3600,
                    'path' => '/',
                    'secure' => false,      
                    'httponly' => false,    
                    'samesite' => 'Lax'
                ]);

                header("Location: /user/index.php");
                exit;
            } else {
                $error = $res['data']['message'] ?? "Erro no login";
            }
        }

        if ($action === 'register') {

            $res = $api->post("/api/usuarios/registrar", [
                'nome'     => $_POST['nome'] ?? '',
                'username' => $_POST['usuario'] ?? '',
                'email'    => $_POST['email'] ?? '',
                'senha'    => $_POST['senha'] ?? ''

            ]);

            if ($res['status'] === 200 && isset($res['data']['id'])) {

                $_SESSION['user'] = [
                    'id'   => $res['data']['id'],
                    'nome' => $res['data']['nome']
                ];

                header("Location: /user/index.php");
                exit;
            } else {
                $error = $res['data']['message'] ?? "Erro no registro";
            }
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Ecommerce</title>
    <link rel="stylesheet" href="login.css">
</head>

<body>

    <div class="container">

        <div class="toggle-buttons">
            <button type="button" class="login-button active">Login</button>
            <button type="button" class="register-button">Cadastre-se</button>
        </div>

        <div class="login-form">
            <form action="login.php" method="post">
                <h2>Entrar</h2>

                <input type="text" name="nome" id="nome" placeholder="Usuário" required>
                <input type="password" name="senha" id="senha" placeholder="Senha" required>
                <input type="hidden" name="action" value="login">

                <button type="submit" class="btn-primary">Entrar</button>
            </form>
        </div>

        <div class="register-form">
            <form action="login.php" method="post">
                <h2>Criar Conta</h2>

                <input type="email" name="email" id="email" placeholder="Email" required>
                <input type="text" name="usuario" id="usuario" placeholder="Usuário" required>
                <input type="text" name="nome" id="nome_cad" placeholder="Nome completo" required>
                <input type="password" name="senha" id="senha_cad" placeholder="Senha" required>
                <input type="number" name="idade" id="idade" placeholder="Idade">
                <input type="hidden" name="action" value="register">

                <button type="submit" class="btn-primary">Cadastrar</button>
            </form>
        </div>

    </div>

    <script src="login.js"></script>
</body>

</html>