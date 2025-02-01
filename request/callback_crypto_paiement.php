<?php
require_once "../model/CryptoPayment.php";

$apiKey = "TON_API_KEY";
$ipnSecret = "TON_SECRET_IPN";

$payment = new CryptoPayment($apiKey, $ipnSecret);

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
