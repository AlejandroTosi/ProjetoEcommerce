<?php
$url = "http://localhost:8080/api/categoria";


$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);


$categoria = json_decode($response, true);


if ($categoria === null) {
    echo "Falha ao carregar categoria";
    $categoria = []; // evita erro no foreach
}
?>