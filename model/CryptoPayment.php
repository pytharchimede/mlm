<?php
class CryptoPayment
{
    private $apiKey;
    private $ipnSecret;
    private $apiUrl = "https://api.nowpayments.io/v1/";

    public function __construct($apiKey, $ipnSecret)
    {
        $this->apiKey = $apiKey;
        $this->ipnSecret = $ipnSecret;
    }

    // 🔹 Créer une commande de paiement
    public function createPayment($amount, $currency = "XOF", $crypto = "BTC", $orderId = null, $successUrl = "", $cancelUrl = "")
    {
        // Convertir XOF en USD si nécessaire
        if ($currency === "XOF") {
            $rate = $this->getExchangeRate("XOF", "USD");
            if (!$rate) {
                return ["error" => "Impossible de récupérer le taux de change pour le XOF."];
            }
            $amount = $amount * $rate;

            $currency = "USD";
        }

        // Vérifier le montant minimal requis
        $minAmount = $this->getMinimalAmount($crypto, "XOF"); // XOF = Devise de réception

        if (isset($minAmount['error'])) {
            return $minAmount; // Retourne l'erreur
        }

        if ($amount < $minAmount['min_amount']) {
            return ["error" => "Le montant est trop bas. Montant minimum requis : " . $minAmount['min_amount'] . " $crypto"];
        }

        if ($minAmount && $amount < $minAmount['min_amount']) {
            return ["error" => "Le montant est trop bas. Montant minimum requis : " . $minAmount['min_amount'] . " $crypto"];
        }

        $orderId = $orderId ?? "CMD_" . time();
        $data = [
            "price_amount" => $amount,
            "price_currency" => $currency,
            "pay_currency" => $crypto,
            "ipn_callback_url" => "https://ifmap.ci/test/request/callback_crypto_paiement.php",
            "order_id" => $orderId,
            "success_url" => $successUrl,
            "cancel_url" => $cancelUrl,
        ];

        return $this->sendRequest("payment", $data);
    }

    // 🔹 Vérifier le statut d'un paiement
    public function checkPaymentStatus($paymentId)
    {
        return $this->sendRequest("payment/$paymentId", [], "GET");
    }

    // 🔹 Méthode interne pour envoyer des requêtes à l'API
    private function sendRequest($endpoint, $data = [], $method = "POST")
    {
        $url = $this->apiUrl . $endpoint;
        $ch = curl_init();

        // Configuration des options cURL
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "x-api-key: {$this->apiKey}",
                "Content-Type: application/json",
            ],
            CURLOPT_SSL_VERIFYPEER => false, // À activer en production
            CURLOPT_SSL_VERIFYHOST => false, // À activer en production
        ]);

        // Gérer les différentes méthodes HTTP
        switch (strtoupper($method)) {
            case "POST":
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                break;
            case "PUT":
            case "DELETE":
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                break;
        }

        // Exécution de la requête
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        // Gestion des erreurs cURL
        if ($curlError) {
            return ["error" => "cURL Error: " . $curlError];
        }

        // Décodage de la réponse JSON
        $decodedResponse = json_decode($response, true);

        // Vérification des erreurs API
        if (!$decodedResponse) {
            return ["error" => "Réponse invalide de l'API.", "http_code" => $httpCode, "raw_response" => $response];
        }

        if (isset($decodedResponse['error'])) {
            return ["error" => "Erreur API: " . json_encode($decodedResponse)];
        }

        // Sauvegarde de la réponse pour débogage
        file_put_contents("debug_api_response.txt", print_r(["http_code" => $httpCode, "response" => $decodedResponse], true));

        return $decodedResponse;
    }


    // 🔹 Vérifier la validité du callback
    public function validateIPN($payload, $receivedSignature)
    {
        $generatedSignature = hash_hmac('sha256', $payload, $this->ipnSecret);
        return $generatedSignature === $receivedSignature;
    }

    // 🔹 Obtenir le montant minimal pour une crypto
    private function getMinimalAmount($currency_from, $currency_to)
    {
        $url = "https://api.nowpayments.io/v1/min-amount?currency_from={$currency_from}&currency_to={$currency_to}";

        $options = [
            "http" => [
                "header" => "x-api-key: {$this->apiKey}\r\nContent-Type: application/json\r\n",
                "method" => "GET",
            ],
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        if (!$response) {
            return ["error" => "Impossible de récupérer le montant minimum requis."];
        }

        $data = json_decode($response, true);

        // 🚀 DEBUG : Enregistre la réponse pour comprendre l'erreur
        file_put_contents("debug_nowpayments.txt", print_r($data, true));

        if (!is_array($data) || !isset($data['min_amount'])) {
            return ["error" => "Donnée 'min_amount' non trouvée.", "api_response" => $data];
        }

        // error_log("NowPayments - Minimal amount: {$data['min_amount']}");

        return $data;
    }

    // 🔹 Obtenir le taux de change entre XOF et USD
    function getExchangeRate($from, $to)
    {
        $apiKey = "fda4059eaac38fee088d2eb5"; // Remplace par ta clé API
        $url = "https://v6.exchangerate-api.com/v6/$apiKey/latest/$from";

        // Récupération des données avec file_get_contents
        $response = @file_get_contents($url);

        // Vérifier si la réponse est valide
        if ($response === false) {
            error_log("Erreur : Impossible de récupérer les données via file_get_contents.");
            return null;
        }

        // Décodage du JSON
        $data = json_decode($response, true);

        // Vérification des données
        if (!isset($data["conversion_rates"][$to])) {
            error_log("Erreur : Données invalides ou taux de conversion non trouvé.");
            return null;
        }

        // error_log(print_r($data, true));

        return $data["conversion_rates"][$to];
    }
}
