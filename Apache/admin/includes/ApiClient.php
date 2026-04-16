<?php

class ApiClient
{
    
    private string $baseUrl;

    public function __construct(string $baseUrl = "http://localhost:8080")
    {
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    private function request(string $method, string $endpoint, $data = null, array $extraHeaders = [])
    {
        $token = $_COOKIE['jwt'] ?? '';
        $url = $this->baseUrl . $endpoint;

        // GET com query string
        if ($method === "GET" && !empty($data)) {
            $url .= '?' . http_build_query($data);
        }

        $ch = curl_init($url);

        $headers = ["Content-Type: application/json"];
        foreach ($extraHeaders as $key => $value) {
            $headers[] = "$key: $value";
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $token
]);

        // Métodos com body
        if (in_array($method, ["POST", "PUT", "PATCH", "DELETE"]) && $data !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new Exception("Erro cURL: " . $error);
        }

        curl_close($ch);

        return [
            "status" => $status,
            "data" => json_decode($response, true),
            "raw" => $response
        ];
    }

    public function get(string $endpoint, $params = [], array $extraHeaders = [])
    {
        return $this->request("GET", $endpoint, $params, $extraHeaders);
    }

    public function post(string $endpoint, $data = [], array $extraHeaders = [])
    {
        return $this->request("POST", $endpoint, $data, $extraHeaders);
    }
    public function put(string $endpoint, $data = [], array $extraHeaders = [])
    {
        return $this->request("PUT", $endpoint, $data, $extraHeaders);
    }

    public function delete(string $endpoint, $data = [], array $extraHeaders = [])
    {
        return $this->request("DELETE", $endpoint, $data, $extraHeaders);
    }
}
