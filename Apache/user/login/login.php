<?php

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Login e Cadastro</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>

    <div class="container">
        <div class="toggle-buttons">
        <button type="button" class="login-button">Login</button>
        <button type="button"  class="register-button">Cadastre-se</button>
        </div>
        <div class="login-form">
            <form action="pontelogin.php" method="post">
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome" placeholder="Digite seu nome" required>
                
                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="senha" placeholder="Digite sua senha" required>
                
                <button type="submit">Entrar</button>
            </form>
        </div>

        <div class="register-form">
                <form action="ponteregistro.php" method="post">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" placeholder="Digite seu email" required>

                <label for="usuario">Usuário:</label>
                <input type="text" name="usuario" id="usuario" placeholder="Digite seu usuário" required>

                <label for="nome_cad">Nome:</label>
                <input type="text" name="nome" id="nome_cad" placeholder="Digite seu nome completo" required>

                <label for="senha_cad">Senha:</label>
                <input type="password" name="senha" id="senha_cad" placeholder="Crie uma senha" required>

                <label for="idade">Idade:</label>
                <input type="number" name="idade" id="idade" placeholder="Sua idade">

                <button type="submit">Cadastrar</button>
            </form>
        </div>

    </div>

    <script src="login.js"></script>
</body>
</html>