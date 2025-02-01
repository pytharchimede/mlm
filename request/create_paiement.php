<?php
require_once "../model/CryptoPayment.php";

$apiKey = "TON_API_KEY";
$ipnSecret = "TON_SECRET_IPN";

$payment = new CryptoPayment($apiKey, $ipnSecret);

// Lire la requête JSON envoyée par JavaScript
$data = json_decode(file_get_contents("php://input"), true);

$response = $payment->createPayment(
    $data['price_amount'],
    $data['price_currency'],
    $data['pay_currency'],
    $data['order_id'],
    $data['success_url'],
    $data['cancel_url']
);

header("Content-Type: application/json");
echo json_encode($response);
