<?php
require_once "../model/CryptoPayment.php";
require_once "../model/Config.php";


$apiKey = Config::get('API_KEY');
$ipnSecret = Config::get('IPN_SECRET');
$exchangeApiKey = Config::get('EXCHANGE_API_KEY');

$payment = new CryptoPayment($apiKey, $ipnSecret, $exchangeApiKey);

// 🔹 Lire le JSON envoyé par NOWPayments
$payload = file_get_contents("php://input");
$data = json_decode($payload, true);
$signature = $_SERVER['HTTP_X_NOWPAYMENTS_SIGNATURE'] ?? "";

// 🔹 Vérifier l'authenticité du message
if ($payment->validateIPN($payload, $signature)) {
    if ($data['payment_status'] === 'finished') {
        file_put_contents("paiement_log.txt", "Paiement confirmé : " . $data['order_id'] . "\n", FILE_APPEND);
        echo "Paiement validé";
    } else {
        echo "Paiement en attente ou échoué";
    }
} else {
    echo "Signature invalide";
}
