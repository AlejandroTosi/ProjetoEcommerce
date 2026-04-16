<?php
require_once "includes/auth.php";
include_once "includes/ApiClient.php";
$resultado_busca = null;
try {
    $apiClient = new ApiClient("http://localhost:8080/api/usuarios");
} catch (Exception $e) {
    die("Erro ao conectar à API: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $metodo = $_GET['acao'] ?? null;

    if ($metodo === 'pesquisar_nome') {
        $nome = $_GET['nome'] ?? '';

        if (trim($nome) === '') {
            $resultado_busca = [];
        } else {
            try {
                $res = $apiClient->get("/pesquisar?nome=" . urlencode($nome));
                $resultado_busca = $res['data'] ?? [];
            } catch (Exception $e) {
                die("Erro ao buscar usuários: " . $e->getMessage());
            }
        }
    }

    if ($metodo === 'pesquisar_tipo_de_conta') {
        $tipo = $_GET['tipoDeConta'] ?? '';

        if (trim($tipo) === '') {
            $resultado_busca = [];
        } else {
            try {
                $res = $apiClient->get("/pesquisar?tipoDeConta=" . urlencode($tipo));
                $resultado_busca = $res['data'] ?? [];
            } catch (Exception $e) {
                die("Erro ao buscar usuários: " . $e->getMessage());
            }
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? null;

    if ($acao === 'adicionar') {
        $novo_usuario = [
            'nome' => $_POST['nome'] ?? '',
            'username' => $_POST['username'] ?? '',
            'email' => $_POST['email'] ?? '',
            'senha' => $_POST['senha'] ?? '',
            'tipoDeConta' => $_POST['tipoDeConta'] ?? ''
        ];

        try {
            $res = $apiClient->post("/registrar", $novo_usuario);
            if (!empty($res['status']) && $res['status'] === 200) {
                header("Location: usuarios.php");
                exit;
            } else {
                die("Erro ao adicionar usuário: " . ($res['data']['message'] ?? 'Desconecido'));
            }
        } catch (Exception $e) {
            die("Erro ao adicionar usuário: " . $e->getMessage());
        }
    } elseif ($acao === 'alterar') {
        // Implementar lógica de alteração de usuário
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Implementar lógica de atualização de usuário


}

?>

<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <title>Painel Fornecedores</title>
    <link rel="stylesheet" href="css/css.css">
</head>

<body>
    <?php include 'includes/barratop_admin.php'; ?>

    <main style="padding: 40px; margin-top: 20px;">

        <h1>Painel de Usuários</h1>
        <p>Escolha uma opção no menu abaixo.</p>

        <div class="container">
            <select name="categoria" class="categoria-pesquisa">
                <option value="1">Pesquisar por Nome</option>
                <option value="2">Pesquisar por Função</option>
                <option value="3">Adicionar</option>
                <option value="4">Alterar</option>
            </select>

            <!-- PESQUISAR POR NOME -->
            <form action="usuarios.php" method="get" class="pesquisa-usuarios" id="formPesquisarUsuarios">
                <input type="text" name="nome" placeholder="Buscar usuário por nome">
                <button type="submit">Pesquisar</button>
                <input type="hidden" name="acao" value="pesquisar_nome">
            </form>

            <!-- PESQUISAR POR FUNÇÃO -->
            <form action="usuarios.php" method="get" class="pesquisa-tipo-de-conta" id="formPesquisarFuncao">
                <input type="text" name="tipoDeConta" placeholder="Buscar por função (ex: ADMIN)">
                <button type="submit">Pesquisar</button>
                <input type="hidden" name="acao" value="pesquisar_tipo_de_conta">
            </form>

            <!-- ADICIONAR USUÁRIO -->
            <form action="usuarios.php" method="post" class="adicionar-usuarios" id="formAdicionarUsuarios">
                <input type="text" name="nome" placeholder="Nome do usuário">
                <input type="text" name="username" placeholder="Username">
                <input type="text" name="email" placeholder="Email">
                <input type="password" name="senha" placeholder="Senha">
                <input type="text" name="tipoDeConta" placeholder="Função (ex: ADMIN)">
                <button type="submit">Criar Usuário</button>
                <input type="hidden" name="acao" value="adicionar">
            </form>

            <!-- ALTERAR USUÁRIO -->
            <form action="usuarios.php" method="post" class="alterar-usuarios" id="formAlterarUsuarios">
                <input type="text" name="nome" placeholder="Novo nome">
                <input type="text" name="username" placeholder="Novo username">
                <input type="text" name="email" placeholder="Novo email">
                <input type="password" name="senha" placeholder="Nova senha">
                <input type="text" name="tipoDeConta" placeholder="Nova função">
                <button type="submit">Alterar Usuário</button>
                <input type="hidden" name="acao" value="alterar">
            </form>
        </div>

        <?php if ($resultado_busca !== null): ?>
            <h2>Resultados da Busca</h2>

            <?php if (empty($resultado_busca)): ?>
                <p>Nenhum usuário encontrado.</p>
            <?php else: ?>
                <table class="tabela-usuarios">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Função</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultado_busca as $usuario): ?>
                            <tr>
                                <td><?= $usuario['nome'] ?></td>
                                <td><?= $usuario['email'] ?></td>
                                <td><?= $usuario['tipoDeConta'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        <?php endif; ?>

    </main>
</body>

<script src="js/usuarios.js"></script>

</html>