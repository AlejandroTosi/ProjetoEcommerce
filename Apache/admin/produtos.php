<?php
require_once "includes/auth.php";

require_once "includes/ApiClient.php";
require 'includes/buscar_categorias.php';
require 'includes/buscar_fornecedores.php';
$api = new ApiClient();
$params = [];
$resultado_busca = null;


/*-- Pesquisar produto*/

if (isset($_GET['acao']) && $_GET['acao'] === 'pesquisar') {

    $nome = $_GET['nome'] ?? ''; {
        $params['q'] = $nome;
    }
    $codigo = $_GET['codigo'] ?? '';

    if ($nome !== '') $params['nome'] = $nome;
    if ($codigo !== '') $params['codigo'] = $codigo;

    $res = $api->get("/api/produtos/buscar", $params);
    $resultado_busca = $res["data"];
}


/*-- Adicionar produto*/

if (isset($_POST['acao']) && $_POST['acao'] === 'adicionar') {
    $nome = $_POST['nome'] ?? '';
    $valor = $_POST['valor'] ?? '';
    $categoria_id = $_POST['categoria_id'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $fornecedor_id = $_POST['fornecedor_id'] ?? '';
    $ativo = true;

    $novo_produto = [
        'nome' => $nome,
        'valor' => $valor,
        'categoria' => ["id" => (int)$categoria_id],
        'descricao' => ["texto" => $descricao],
        'fornecedor' => ["id" => (int)$fornecedor_id],
        'ativo' => true
    ];

    $res = $api->post("/api/produtos", $novo_produto);

    if (!empty($res['status']) && $res['status'] === 200) {
        header("Location: views/produto.php?id=" . $res["data"]["id"]);
        echo "Produto adicionado com sucesso!";
        exit;
    } else {
        $mensagemErro = $res['data']['message'] ?? 'Desconhecido';
        echo "Erro ao adicionar produto: " . $mensagemErro;
    }
}


?>

<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <title>Painel de Produtos</title>
    <link rel="stylesheet" href="css/css.css">
</head>

<body>
    <?php include 'includes/barratop_admin.php'; ?>

    <main style="padding: 40px; margin-top: 20px;">
        <div class="container">
            <h1>Painel de Produtos</h1>
            <p>Escolha uma opção no menu abaixo.</p>

            <div class="container" id="telaPesquisaProduto">

                <form action="produtos.php" method="get" class="pesquisa-produtos" id="formPesquisaprodutos">
                    <input type="text" name="nome" placeholder="Buscar por nome">
                    <input type="text" name="codigo" placeholder="Buscar por código">
                    <input type="hidden" name="acao" value="pesquisar">
                    <button type="submit">Pesquisar produto</button>
                </form>

            </div>

            <?php if ($resultado_busca !== null): ?>
                <h2>Resultados da Busca</h2>
                <?php if (empty($resultado_busca)): ?>
                    <p>Nenhum produto encontrado.</p>
                <?php else: ?>
                    <table class="tabela-resultados">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Categoria</th>
                                <th>Valor</th>
                                <th>Fornecedor</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resultado_busca as $produto): ?>
                                <tr onclick="window.location='views/produto.php?id=<?= $produto['id'] ?>'" style="cursor:pointer;">
                                    <td><?= htmlspecialchars($produto['id']) ?></td>
                                    <td><?= htmlspecialchars($produto['nome']) ?></td>
                                    <td><?= htmlspecialchars($produto['categoria']['tipo'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($produto['valor']) ?></td>
                                    <td><?= htmlspecialchars($produto['fornecedor']['razaoSocial'] ?? 'N/A') ?></td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            <?php endif; ?>
        </div>


        <!-- Adicionar novo produto -->
        <button type="button" id="abrirTelaAdicionarProduto" class="botao">Adicionar novo produto</button>


        <div class="container_adicionar" id="telaAdicionarProduto" style="display:none;">
            <h2>Adicionar Produto</h2>
            <form action="produtos.php" method="post">
                <input type="hidden" name="acao" value="adicionar">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>

                <label for="valor">Valor:</label>
                <input type="number" id="valor" name="valor" step="0.01" required>

                <label for="descricao">Descrição:</label>
                <input type="text" id="descricao" name="descricao" required>

                <div>
                    <?php include "includes/categorias.php"; ?>
                </div>

                <div>
                    <?php include "includes/fornecedores.php"; ?>
                </div>

                <button type="submit">Adicionar Produto</button>
            </form>


            <button type="button" id="fecharTelaAdicionarProduto" class="botao">Fechar</button>





        </div>



    </main>

</body>

<script src="js/produtos.js"></script>

</html>