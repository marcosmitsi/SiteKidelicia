<?php

function apiRequest($endpoint, $method = 'GET', $data = null)
{
    $url = 'http://localhost/kidelicia/public/api' . $endpoint;
    
    $ch = curl_init($url);

    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
 
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

    if($data !== null){
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

  
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    }
    
    $response = curl_exec($ch);

    
    curl_close($ch); 

    
    return json_decode($response, true);
}
