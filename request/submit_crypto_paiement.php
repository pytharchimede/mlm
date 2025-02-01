<?php
require_once "../model/CryptoPayment.php";

// 🔹 Configurer tes identifiants NOWPayments
$apiKey = Config::get('API_KEY');
$ipnSecret = Config::get('IPN_SECRET');

// 🔹 Initialiser la classe
$payment = new CryptoPayment($apiKey, $ipnSecret);

// 🔹 Créer un paiement
$response = $payment->createPayment(10000, "XOF", "BTC", null, "../success.php", "../cancel.php");

if (isset($response['invoice_url'])) {
    header("Location: " . $response['invoice_url']); // Redirige vers la page de paiement
    exit;
} else {
    echo "Erreur : " . ($response['message'] ?? "Impossible de créer le paiement.");
}
