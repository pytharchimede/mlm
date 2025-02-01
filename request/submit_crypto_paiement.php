<?php
require_once "../model/CryptoPayment.php";
require_once "../model/Config.php";


// 🔹 Configurer tes identifiants NOWPayments
$apiKey = Config::get('API_KEY');
$ipnSecret = Config::get('IPN_SECRET');
$exchangeApiKey = Config::get('EXCHANGE_API_KEY');


// 🔹 Initialiser la classe
$payment = new CryptoPayment($apiKey, $ipnSecret, $exchangeApiKey);

// 🔹 Créer un paiement
$response = $payment->createPayment(10000, "XOF", "usdttrc20", null, "../success.php", "../cancel.php");

if (isset($response['invoice_url'])) {
    header("Location: " . $response['invoice_url']); // Redirige vers la page de paiement
    exit;
} else {
    echo "Erreur : " . ($response['message'] ?? "Impossible de créer le paiement.");
}
