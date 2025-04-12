<?php

// Fonction pour obtenir le token d'accès
function getAccessToken($client_id, $client_secret)
{
    $token_url = 'https://api.orange.com/oauth/v3/token';

    $headers = [
        "Authorization: Basic MEk0R2dGMUZCbnZKdUI5TWhLb2VtSjVkV21BQWc0Wjc6S0lGWFc1RnR1bmxZd0ZaNw==" // L'Authorization header
    ];

    // Données à envoyer pour récupérer le token
    $data = [
        'grant_type' => 'client_credentials',
        'client_id' => $client_id,
        'client_secret' => $client_secret
    ];

    // Créer un contexte pour la requête HTTP
    $options = [
        'http' => [
            'header'  => "Content-Type: application/x-www-form-urlencoded\r\n" . implode("\r\n", $headers),
            'method'  => 'POST',
            'content' => http_build_query($data)
        ]
    ];

    // Créer le contexte et envoyer la requête
    $context  = stream_context_create($options);
    $result = file_get_contents($token_url, false, $context);

    if ($result === FALSE) {
        die('Error fetching access token');
    }

    $response = json_decode($result, true);
    return $response['access_token'] ?? null;
}

// Fonction pour appeler l'API avec le token d'accès
function callApi($access_token)
{
    $api_url = 'https://api.orange.com/camara/location-retrieval/orange-lab/v0/retrieve'; // URL correcte

    $headers = [
        'Authorization: Bearer ' . $access_token,
        'x-correlator: your_correlator' // Remplacez par un identifiant unique
    ];

    // Données à envoyer pour récupérer la localisation
    $data = [
        'device' => [
            'phoneNumber' => '+33699901032' // Numéro de téléphone valide
        ],
        'maxAge' => 60
    ];

    $ch = curl_init();

    // Configuration cURL
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    // Exécuter la requête
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }

    curl_close($ch);

    // Retourner la réponse JSON
    return json_decode($response, true);
}

// Remplacez par vos informations
$client_id = '0EW6WJF5uVJRdsDo'; // Client ID
$client_secret = 'KIFXW5FtunlYwFZ7'; // Client Secret

// Obtenir le token d'accès
$access_token = getAccessToken($client_id, $client_secret);

if ($access_token) {
    echo "Access token: " . $access_token . "\n";

    // Appeler l'API
    $response = callApi($access_token);

    // Afficher la réponse de l'API
    echo json_encode($response, JSON_PRETTY_PRINT);
} else {
    echo "Failed to get access token.\n";
}
