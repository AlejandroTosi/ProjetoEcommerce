<?php
$url = "http://localhost:8080/api/fornecedor";

// Inicializa cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

// Converte JSON em array associativo
$fornecedores = json_decode($response, true);

// Checa se deu certo
if ($fornecedores === null) {
    echo "Falha ao carregar fornecedores";
    $fornecedores = []; // evita erro no foreach
}
?>