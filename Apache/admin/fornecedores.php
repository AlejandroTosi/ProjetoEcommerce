<?php
require_once "includes/auth.php";



$acao = $_REQUEST['acao'] ?? null;
$msg = "";
$resposta = "";
$resultado_busca = null;


if($acao === "pesquisar"){
    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        if(empty($_GET['nome'])) {
            $msg = "Campo de busca vazio.";
        } else {
            $nome = $_GET['nome'];
            $url = "http://localhost:8080/api/fornecedor/buscar?nome=" . urlencode($nome);

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $resposta = curl_exec($ch);
            curl_close($ch);
            $resultado_busca = json_decode($resposta, true);



}

}

}elseif($acao === "adicionar"){
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(empty($_POST['razao_social']) || empty($_POST['contato']) || empty($_POST['email']) || empty($_POST['cnpj'])) {
            $msg = "Preencher os campos corretamente.";
        } else {
            $dados = json_encode([
                "razaoSocial" => $_POST['razao_social'],
                "numeroContato" => $_POST['contato'],
                "emailContato" => $_POST['email'],
                "cnpj" => $_POST['cnpj']
            ]);

            $ch = curl_init("http://localhost:8080/api/fornecedor/adicionar");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dados);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $resposta = curl_exec($ch);
            curl_close($ch);
            $resultado_busca = json_decode($resposta, true);



        }
    }

} elseif($acao === "alterar"){
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(empty($_POST['id']) || empty($_POST['razao_social']) || empty($_POST['contato']) || empty($_POST['email'])) {
            $msg = "Preencher os campos corretamente.";
        } else {
            $id = $_POST['id'];
            $dados = json_encode([
                "razaoSocial" => $_POST['razao_social'],
                "numeroContato" => $_POST['contato'],
                "emailContato" => $_POST['email'],
                "cnpj" => $_POST['cnpj']
            ]);

            $ch = curl_init("http://localhost:8080/api/fornecedor/" . $id);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dados);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $resposta = curl_exec($ch);
            curl_close($ch);
            $resultado_busca = json_decode($resposta, true);



}
        }
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

        <h1>Painel de Fornecedores</h1>
        <p>Escolha uma opção no menu abaixo.</p>

        <div class="container">
            <select name="categoria" class="categoria-pesquisa">
                <option value="1">Pesquisar</option>
                <option value="2">Adicionar</option>
                <option value="3">Alterar</option>
            </select>

            <form action="fornecedores.php" method="get" class="pesquisa-fornecedores" id="formPesquisafornecedores">
                <input type="text" name="nome" placeholder="Buscar por nome, contato...">
                <button type="submit">Pesquisar Fornecedor</button>
                <input type="hidden" name="acao" value="pesquisar">
            </form>

            <form action="fornecedores.php" method="post" class="adicionar-fornecedores" id="formAdicionarfornecedores">
                <input type="text" name="razao_social" placeholder="Nome do fornecedor">
                <input type="text" name="contato" placeholder="Contato">
                <input type="text" name="email" placeholder="Email">
                <input type="text" name="cnpj" placeholder="CNPJ">
                <button type="submit">Adicionar Fornecedor</button>
                <input type="hidden" name="acao" value="adicionar">
            </form>

            <form action="fornecedores.php" method="post" class="alterar-fornecedores" id="formAlterarfornecedores">
                <input type="text" name="id" placeholder="ID do fornecedor">
                <input type="text" name="razao_social" placeholder="Novo nome do fornecedor">
                <input type="text" name="contato" placeholder="Novo contato">
                <input type="text" name="email" placeholder="Novo email">
                <input type="text" name="cnpj" placeholder="CNPJ">
                <button type="submit">Alterar Fornecedor</button>
                <input type="hidden" name="acao" value="alterar">
            </form>
        </div>

        <?php if($resultado_busca !== null): ?>
            <h2>Resultados da Busca</h2>
            <?php if(empty($resultado_busca)): ?>
                <p>Nenhum fornecedor encontrado.</p>
            <?php else: ?>
                <table class="tabela-fornecedores">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Razão Social</th>
                            <th>Contato</th>
                            <th>Email</th>
                            <th>CNPJ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($resultado_busca as $fornecedor): ?>
                            <tr>
                                <td><?= $fornecedor['id'] ?></td>
                                <td><?= $fornecedor['razaoSocial'] ?></td>
                                <td><?= $fornecedor['numeroContato'] ?></td>
                                <td><?= $fornecedor['emailContato'] ?></td>
                                <td><?= $fornecedor['cnpj'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        <?php endif; ?>

    </main>

</body>

<script src="js/fornecedores.js"></script>
</html>
