<?php
require_once "../includes/ApiUpload.php";
$produtoId = $_POST['produto_id'];
$apiUpload = new ApiUpload();
$res = $apiUpload->send(
    "/api/imagem/produtos/$produtoId/imagem",
    $_FILES['file'],
    $_POST['tipo']
);

header("Location: ../views/produto.php?id=".$produtoId);
?>
