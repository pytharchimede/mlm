<?php
require_once "../model/CryptoPayment.php";
require_once "../model/Config.php";

// Activer le débogage pour afficher toutes les erreurs PHP pendant le développement
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Récupérer les clés API depuis la configuration
$apiKey = Config::get('API_KEY'); // À obtenir ou simuler
$ipnSecret = Config::get('IPN_SECRET'); // À obtenir ou simuler

$payment = new CryptoPayment($apiKey, $ipnSecret);

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

// Si la création du paiement est réussie, renvoyer l'URL de la facture
if (isset($response['invoice_url'])) {
    echo json_encode([
        "success" => true,
        "invoice_url" => $response['invoice_url']
    ]);
    exit;
}

// Si la réponse contient un message d'erreur avec HTTP 201
if (isset($response['error']) && strpos($response['error'], 'HTTP 201 -') !== false) {
    // Décoder la partie JSON du message d'erreur
    preg_match('/HTTP 201 - (.*)/', $response['error'], $matches);
    $jsonResponse = json_decode($matches[1], true);
    // Réponse structurée
    if (isset($jsonResponse['payment_id'])) {
        echo json_encode([
            "success" => true,
            "payment_id" => $jsonResponse["payment_id"],
            "payment_status" => $jsonResponse["payment_status"],
            "pay_address" => $jsonResponse["pay_address"],
            "pay_amount" => $jsonResponse["pay_amount"],
            "pay_currency" => $jsonResponse["pay_currency"],
            "valid_until" => $jsonResponse["valid_until"]
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
        "error" => "Réponse inattendue de l'API."
    ]);
}

// Nettoyer la sortie avant de terminer
flush();
exit;
