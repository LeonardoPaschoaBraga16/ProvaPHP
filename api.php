<?php
header('Content-Type: application/json');

// Verifica se o CEP foi enviado por GET
if (!isset($_GET['cep'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['erro' => 'CEP não informado']);
    exit;
}

$cep = preg_replace('/[^0-9]/', '', $_GET['cep']); // Limpa caracteres não numéricos

if (strlen($cep) !== 8) {
    http_response_code(400);
    echo json_encode(['erro' => 'CEP inválido. Deve conter 8 dígitos.']);
    exit;
}

// Faz a requisição para a API do ViaCEP
$url = "https://viacep.com.br/ws/$cep/json/";

$response = file_get_contents($url);

if ($response === FALSE) {
    http_response_code(500);
    echo json_encode(['erro' => 'Erro ao consultar ViaCEP']);
    exit;
}

// Converte a resposta em array associativo
$data = json_decode($response, true);

// Verifica se houve erro no retorno da API
if (isset($data['erro']) && $data['erro'] === true) {
    http_response_code(404);
    echo json_encode(['erro' => 'CEP não encontrado']);
    exit;
}

// Retorna os dados obtidos da API ViaCEP
echo json_encode($data, JSON_UNESCAPED_UNICODE);
