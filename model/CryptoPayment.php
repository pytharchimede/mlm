<?php
include_once 'Config.php';

class CryptoPayment
{
    private $apiKey;
    private $ipnSecret;
    private $apiUrl = "https://api.nowpayments.io/v1/";

    private $exchangeApiKey; // Propriété correctement déclarée

    public function __construct($apiKey, $ipnSecret, $exchangeApiKey)
    {
        $this->apiKey = $apiKey ? $apiKey : Config::get("API_KEY");
        $this->exchangeApiKey = $exchangeApiKey ? $exchangeApiKey : Config::get("EXCHANGE_API_KEY"); // Affectation correcte
        $this->ipnSecret = $ipnSecret;
    }

    // 🔹 Créer une commande de paiement
    public function createPayment($amount, $currency = "XOF", $crypto = "usdttrc20", $orderId = null, $successUrl = "", $cancelUrl = "")
    {
        // 🔹 Conversion XOF → USD si nécessaire
        if ($currency === "XOF") {
            $rate = $this->getExchangeRate("XOF", "USD");
            if (!$rate) {
                return ["error" => "Impossible de récupérer le taux de change XOF -> USD."];
            }
            $amount = $amount * $rate;
            $currency = "USD";
        }

        // 🔹 Vérifier montant minimal pour la crypto choisie
        $minAmount = $this->getMinimalAmount($crypto, "XOF");

        if (isset($minAmount['error'])) {
            return $minAmount;
        }

        if ($amount < $minAmount['min_amount']) {
            return ["error" => "Le montant est trop bas. Min requis : " . $minAmount['min_amount'] . " $crypto"];
        }

        // 🔹 Génération de l'ID de commande
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
        $url = "https://api.nowpayments.io/v1/min-amount?currency_from={$currency_from}&currency_to={$currency_to}&fiat_equivalent=usd&is_fixed_rate=False&is_fee_paid_by_user=False";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "x-api-key: {$this->apiKey}",
            "Content-Type: application/json"
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Vérifier si la requête cURL a échoué
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            return ["error" => "Erreur cURL: " . $error_msg];
        }

        curl_close($ch);

        // Vérifier la réponse HTTP
        if ($httpCode != 200) {
            return ["error" => "Erreur HTTP : $httpCode. Impossible de récupérer le montant minimum requis."];
        }

        // Vérifier si la réponse est vide
        if (!$response) {
            return ["error" => "Aucune réponse reçue de l'API."];
        }

        $data = json_decode($response, true);

        // Vérifier si les données contiennent la clé 'min_amount'
        if (!is_array($data) || !isset($data['min_amount'])) {
            return ["error" => "Donnée 'min_amount' non trouvée.", "api_response" => $data];
        }

        return $data;
    }

    // 🔹 Obtenir le taux de change entre XOF et USD
    function getExchangeRate($from, $to)
    {
        $apiKey = $this->exchangeApiKey; // Remplace par ta clé API
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
