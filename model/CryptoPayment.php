<?php
class CryptoPayment {
    private $apiKey;
    private $ipnSecret;
    private $apiUrl = "https://api.nowpayments.io/v1/";

    public function __construct($apiKey, $ipnSecret) {
        $this->apiKey = $apiKey;
        $this->ipnSecret = $ipnSecret;
    }

    // 🔹 Créer une commande de paiement
    public function createPayment($amount, $currency = "USD", $crypto = "BTC", $orderId = null, $successUrl = "", $cancelUrl = "") {
        $orderId = $orderId ?? "CMD_" . time();
        $data = [
            "price_amount" => $amount,
            "price_currency" => $currency,
            "pay_currency" => $crypto,
            "ipn_callback_url" => "https://tonsite.com/callback.php",
            "order_id" => $orderId,
            "success_url" => $successUrl,
            "cancel_url" => $cancelUrl,
        ];

        return $this->sendRequest("payment", $data);
    }

    // 🔹 Vérifier le statut d'un paiement
    public function checkPaymentStatus($paymentId) {
        return $this->sendRequest("payment/$paymentId", [], "GET");
    }

    // 🔹 Méthode interne pour envoyer des requêtes à l'API
    private function sendRequest($endpoint, $data = [], $method = "POST") {
        $url = $this->apiUrl . $endpoint;
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "x-api-key: {$this->apiKey}",
            "Content-Type: application/json",
        ]);

        if ($method === "POST") {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    // 🔹 Vérifier la validité du callback
    public function validateIPN($payload, $receivedSignature) {
        $generatedSignature = hash_hmac('sha256', $payload, $this->ipnSecret);
        return $generatedSignature === $receivedSignature;
    }
}
?>
