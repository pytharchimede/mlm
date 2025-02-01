<?php
require_once "../model/CryptoPayment.php";
require_once "../model/Config.php";

// Activer le débogage pour afficher toutes les erreurs PHP pendant le développement
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Récupérer les clés API depuis la configuration
$apiKey = Config::get('API_KEY'); // À obtenir ou simuler
$ipnSecret = Config::get('IPN_SECRET'); // À obtenir ou simuler
$exchangeApiKey = Config::get('EXCHANGE_API_KEY');

$payment = new CryptoPayment($apiKey, $ipnSecret, $exchangeApiKey);

// Lire la requête JSON envoyée par JavaScript
$data = json_decode(file_get_contents("php://input"), true);

// Appeler la méthode pour créer un paiement
$response = $payment->createPayment(
    $data['price_amount'],
    $data['price_currency'],
    $data['pay_currency'],
    $data['order_id'],
    $data['success_url'],
    $data['cancel_url']
);

// Nettoyer toute sortie avant d'envoyer le JSON
ob_clean();

// Définir le type de contenu à JSON
header('Content-Type: application/json');

// Vérifier si une erreur a été renvoyée
if (isset($response['error'])) {
    echo json_encode([
        "success" => false,
        "error" => $response['error']
    ]);
    exit;
}

// Vérifier la réponse du code HTTP
if (isset($response['http_code']) && $response['http_code'] == 201) {
    // Décoder la réponse API
    $jsonResponse = $response['response'];

    // Vérification des informations retournées
    if (isset($jsonResponse['payment_id'])) {
        echo json_encode([
            "success" => true,
            "payment_id" => $jsonResponse["payment_id"],
            "payment_status" => $jsonResponse["payment_status"],
            "pay_address" => $jsonResponse["pay_address"],
            "price_amount" => $jsonResponse["price_amount"],
            "price_currency" => $jsonResponse["price_currency"],
            "pay_amount" => $jsonResponse["pay_amount"],
            "amount_received" => $jsonResponse["amount_received"],
            "pay_currency" => $jsonResponse["pay_currency"],
            "order_id" => $jsonResponse["order_id"],
            "order_description" => $jsonResponse["order_description"],
            "ipn_callback_url" => $jsonResponse["ipn_callback_url"],
            "created_at" => $jsonResponse["created_at"],
            "valid_until" => $jsonResponse["valid_until"],
            "type" => $jsonResponse["type"],
            "network" => $jsonResponse["network"]
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "error" => "Détails manquants dans la réponse de l'API."
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "error" => "Réponse inattendue de l'API ou code HTTP erroné.",
        "http_code" => isset($response['http_code']) ? $response['http_code'] : 'Non spécifié',
        "response" => $response['response'] ?? 'Aucune réponse'
    ]);
}

// Nettoyer la sortie avant de terminer
flush();
exit;
