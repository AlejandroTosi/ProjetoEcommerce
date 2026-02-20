<?php
class ApiUpload {

    private string $baseUrl;

    public function __construct(string $baseUrl = "http://localhost:8080") {
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    public function send(string $endpoint, array $fileField, string $tipo)
    {
        $url = $this->baseUrl . $endpoint;

        $ch = curl_init($url);

        $post = [
            'file' => new CURLFile(
                $fileField['tmp_name'],
                $fileField['type'],
                $fileField['name']
            ),
            'tipo' => $tipo
                ];

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if(curl_errno($ch)){
        throw new Exception(curl_error($ch));
    }

    curl_close($ch);

    return $response;
}

}
?>
