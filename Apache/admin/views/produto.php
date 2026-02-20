<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once "../includes/ApiClient.php";
require_once "../includes/ApiUpload.php";

$api = new ApiClient();
$apiUpload = new ApiUpload();

$id = $_GET['id'] ?? null;
/*Carregar detalhes do produto*/
if (!$id) {
    die("Produto não informado");
}

/*Carregar categorias e fornecedores para dropdowns*/
$resCat = $api->get("/api/categoria");
$categorias = $resCat["data"] ?? [];
$categoria = $categorias;
$produto_categoria_id = $produto['categoria']['id'] ?? null;


$resFor = $api->get("/api/fornecedor");
$fornecedores = $resFor["data"] ?? [];
$res = $api->get("/api/produtos/" . $id);
if ($res["status"] !== 200 || !$res["data"]) {
    die("Produto não encontrado");
}
$produto = $res["data"];

/*Carregar imagem do produto*/
$resImg= $api->get("/api/imagem/produtos/$id/imagem");
$url = $resImg['data']['url'] ?? null;
$imagem = !empty($resImg['data']['url'])
    ? "http://localhost:8080" . $resImg['data']['url']
    : "../imagens/default.png";

/*Descrição do produto*/
$descricao = 'Sem descrição disponível.';
if (!empty($produto['descricao']) && is_string($produto['descricao'])) {
    $descricao = $produto['descricao'];
}

/*Salvar alterações do produto*/
if(isset($_POST['acao']) && $_POST['acao'] === 'salvar') {
    $nome = $_POST['nome'] ?? '';
    $valor = $_POST['valor'] ?? '';
    $categoria_id = $_POST['categoria_id'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $fornecedor_id = $_POST['fornecedor_id'] ?? '';

    $produtoAtualizado = [
        'id' => (int)$id,
        'nome' => $nome,
        'valor' => $valor,
        "categoria" => ["id" => (int)$categoria_id],
        'descricao' => ["descricao" => $descricao],
        'fornecedor' => ["id" => (int)$fornecedor_id],
        'ativo' => true
    ];

    $res = $api->put("/api/produtos", $produtoAtualizado);

    if (!empty($res['status']) && $res['status'] === 200) {
        header("Location: produto.php?id=" . $id);
        echo "Produto atualizado com sucesso!";
        exit;
    } else {
        $mensagemErro = $res['data']['message'] ?? 'Desconecido';
            echo "Erro ao atualizar produto: " . $mensagemErro;
    }
}
?>


<!DOCTYPE html>
<html lang="PT-BR">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($produto['nome']) ?></title>
<link rel="stylesheet" href="../css/css.css">
</head>
<body>
    <?php include "../includes/barratop_admin.php"; ?>
    <main>
<!-- Detalhes do produto -->
<div class="view">
    <h1><?= htmlspecialchars($produto['nome']) ?></h1>
    <p><b>ID:</b> <?= htmlspecialchars($produto['id']) ?></p>
    <p><b>Valor:</b> R$ <?= htmlspecialchars($produto['valor']) ?></p>
    <p><b>Categoria:</b>
      <?= htmlspecialchars($produto['categoria']['tipo'] ?? 'N/A') ?>
    </p>
    <p><b>Fornecedor:</b>
    <?= htmlspecialchars($produto['fornecedor']['razaoSocial'] ?? 'N/A') ?>
    </p>
    <p><b>Status:</b>
    <?= $produto['ativo'] ? 'Ativo' : 'Inativo' ?>
    </p>
    <div class="produto-imagem">
        <img src="<?= htmlspecialchars($imagem) ?>">
    </div>
    <div class="produto-descricao">
        <h2>Descrição</h2>
        <p><?= nl2br(htmlspecialchars($descricao)) ?></p>
    </div>


    <button type="button" id="alterarProdutoBtn" class="botao">Alterar produto</button>
</div>


<!-- Tela de alteração -->
<div class="tela-alterar" style="display:none;" id="telaAlterarProduto">
    <h2>Alterar Produto</h2>
    <form action="produto.php?id=<?= htmlspecialchars($produto['id']) ?>" method="post">
     <input type="hidden" name="acao" value="salvar">
     <input type="hidden" name="id" value="<?= htmlspecialchars($produto['id']) ?>">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($produto['nome']) ?>" required>

        <label for="valor">Valor:</label>
        <input type="number" id="valor" name="valor" value="<?= htmlspecialchars($produto['valor']) ?>" step="0.01" required>

         <div>
         <?php include "../includes/categorias.php"; ?>
         </div>

         <div>
         <?php include "../includes/fornecedores.php"; ?>
         </div>

        <button type="submit">Salvar Alterações</button>
    </form>
    <form action="../upload/produto_imagem.php" method="post" enctype="multipart/form-data">

<input type="file" name="file">
<input type="hidden" name="produto_id" value="<?= $produto['id'] ?>">
<input type="hidden" name="tipo" value="PRINCIPAL">

<button type="submit">Enviar imagem</button>

</form>


</div>


</main>
<script>
const abrirTelaBtn = document.getElementById('alterarProdutoBtn');
const telaalterar = document.getElementById('telaAlterarProduto');


abrirTelaBtn.addEventListener("click", function(){
    telaalterar.style.display = "block";
    });
</script>
</body>

    
</html>
