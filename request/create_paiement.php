<?php
include_once '../model/Config.php';
include_once '../model/CryptoPayment.php';

header("Content-Type: application/json");

$input = json_decode(file_get_contents("php://input"), true);

if (!isset($input['price_amount'], $input['price_currency'], $input['pay_currency'], $input['order_id'])) {
    echo json_encode(["error" => "Données incomplètes"]);
    exit;
}

$amount = (float) $input['price_amount'];
$currency = $input['price_currency'];
$crypto = $input['pay_currency'];
$orderId = $input['order_id'];
$successUrl = $input['success_url'] ?? "";
$cancelUrl = $input['cancel_url'] ?? "";

$cryptoPayment = new CryptoPayment(Config::get("API_KEY"), Config::get("IPN_SECRET"), Config::get("EXCHANGE_API_KEY"));

$response = $cryptoPayment->createPayment($amount, $currency, $crypto, $orderId, $successUrl, $cancelUrl);

echo json_encode($response);
exit;
