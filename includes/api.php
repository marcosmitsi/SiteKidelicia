<?php

function apiRequest($endpoint, $method = 'GET', $data = null)
{
    $url = 'http://localhost/kidelicia/public/api' . $endpoint;
    //cURL Handle  =  Inicializa uma nova sessão cURL para a URL especificada
    $ch = curl_init($url);

    // Configura a opção para retornar a resposta como string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    // Configura o método HTTP para GET
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

    if($data !== null){
        // Define o corpo da requisição como um JSON
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // Define o cabeçalho para JSON
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    }
    
    $response = curl_exec($ch); // Executa a requisição

    
    curl_close($ch); // Fecha a sessão cURL

    
    return json_decode($response, true); // Decodifica a resposta JSON para um array associativo
}
