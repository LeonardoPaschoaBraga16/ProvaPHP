<?php
header('Content-Type: application/json');

if (!isset($_GET['cep'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['erro' => 'CEP não informado']);
    exit;
}

$cep = preg_replace('/[^0-9]/', '', $_GET['cep']);

if (strlen($cep) !== 8) {
    http_response_code(400);
    echo json_encode(['erro' => 'CEP inválido. Deve conter 8 dígitos.']);
    exit;
}

$url = "https://viacep.com.br/ws/$cep/json/";

$response = file_get_contents($url);

if ($response === FALSE) {
    http_response_code(500);
    echo json_encode(['erro' => 'Erro ao consultar ViaCEP']);
    exit;
}

$data = json_decode($response, true);

if (isset($data['erro']) && $data['erro'] === true) {
    http_response_code(404);
    echo json_encode(['erro' => 'CEP não encontrado']);
    exit;
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);
