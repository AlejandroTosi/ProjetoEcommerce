<?php
$json = file_get_contents(__DIR__ . '/../../admin/data/filtros.json');
$dados = json_decode($json, true);
$categorias = $dados['categorias'];
$nomeCompleto = $_SESSION['user']['nome'];
$partes = explode(' ', trim($nomeCompleto));
$primeiroNome = $partes[0];
?>

<div class="barra-de-menu admin-theme">
    <div class="logo-admin">
        <!-- espaço para logo -->
        <a href="/user/index.php">📦 Loja</a>
    </div>

    <form class="pesquisa" action="/user/buscar.php" method="get">
        <select name="categoria" class="categoria-pesquisa">
            <option value="">Todos</option>
            <?php foreach ($categorias as $categoria): ?>
                <option value="<?= $categoria['id'] ?>"><?= $categoria['nome'] ?></option>
            <?php endforeach; ?>
        </select>
        <input type="text" name="q" class="campo-pesquisa" placeholder="Pesquisar...">
        <button type="submit" class="botao-pesquisa">Pesquisar</button>
    </form>

    <div class="usuario-admin">
        <?php if (isset($_SESSION['user'])): ?>
            Olá, <strong><?= htmlspecialchars($primeiroNome) ?></strong>
            <a href="/user/perfil/perfil.php">Perfil</a>
            <form action="/user/includes/logout.php" method="post" style="display:inline;">
                <button type="submit">Sair</button>
            </form>
        <?php else: ?>
            <a href="/user/login/login.php">Entrar / Cadastrar</a>
        <?php endif; ?>

        <a href="/user/carrinho/carrinho.php" class="sub_menu">🛒 Carrinho</a>
    </div>
</div>