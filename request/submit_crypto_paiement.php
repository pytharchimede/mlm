<?php
require_once "../model/CryptoPayment.php";

// 🔹 Configurer tes identifiants NOWPayments
$apiKey = "TON_API_KEY";
$ipnSecret = "TON_SECRET_IPN";

// 🔹 Initialiser la classe
$payment = new CryptoPayment($apiKey, $ipnSecret);

// 🔹 Créer un paiement
$response = $payment->createPayment(10.00, "USD", "BTC", null, "https://tonsite.com/success.php", "https://tonsite.com/cancel.php");

if (isset($response['invoice_url'])) {
    header("Location: " . $response['invoice_url']); // Redirige vers la page de paiement
    exit;
} else {
    echo "Erreur : " . ($response['message'] ?? "Impossible de créer le paiement.");
}
