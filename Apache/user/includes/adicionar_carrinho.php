<?php
session_start();
header('Content-Type: application/json');


$usuarioId = $_SESSION['user']['id'] ?? null;
$token     = $_SESSION['user']['token'] ?? null;

require_once "auth.php";
require_once "ApiClient.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["erro" => "Método inválido"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$produtoId = $data['produto_id'] ?? null;

if (!$produtoId) {
    http_response_code(400);
    echo json_encode(["erro" => "Produto inválido"]);
    exit;
}

$api = new ApiClient("http://localhost:8080");

$response = $api->post(
    "/api/carrinho/itens",
    [
        "produtoId" => (int)$produtoId,
        "usuarioId" => (int)$usuarioId
    ],
    ["Authorization" => "Bearer $token"]
);

echo json_encode([
    "status" => $response['status']
]);
?>