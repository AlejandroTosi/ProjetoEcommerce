<div class="barra-de-menu admin-theme">
    <div class="logo-admin">
        <a href="/user/index.php">📦 Loja</a>
    </div>

    <form class="pesquisa" action="/user/buscar.php" method="get">
        <select name="categoria" class="categoria-pesquisa">
            <option value="">Todos</option>
            <option value="1">Categoria 1</option>
            <option value="2">Categoria 2</option>
            <option value="3">Categoria 3</option>
        </select>
        <input type="text" name="q" class="campo-pesquisa" placeholder="Pesquisar...">
        <button type="submit" class="botao-pesquisa">Pesquisar</button>
    </form>

    <div class="usuario-admin">
        <?php if (isset($_SESSION['user'])): ?>
            Olá, <?= htmlspecialchars($_SESSION['user']['nome']) ?>
            <a href="/user/perfil/perfil.php">Perfil</a>
            <form action="/user/includes/logout.php" method="post" style="display:inline;">
                <button type="submit">Sair</button>
            </form>
        <?php else: ?>
            <a href="/user/login/login.php">Entrar / Cadastrar</a>
        <?php endif; ?>

        <a href="/user/carrinho.php" class="sub_menu">🛒 Carrinho</a>
    </div>
</div>