<?php

class AutoTransaction
{
    private $apiKey;
    private $apiKeyToken;
    private $apiUrl = "https://api.nowpayments.io/v1/payout"; // URL pour les retraits
    private $authUrl = "https://api.nowpayments.io/v1/auth"; // URL pour l'authentification (si nécessaire)

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
        $this->apiKeyToken = $apiKey; // Assurez-vous que l'API_KEY est définie correctement
    }

    // Fonction pour obtenir un token Bearer, si nécessaire
    private function getBearerToken()
    {
        // Exemple de requête pour obtenir un token si nécessaire
        $ch = curl_init($this->authUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "x-api-key: " . $this->apiKeyToken,  // Utilisation de la clé API pour l'authentification
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_POST, true);

        // Exécution de la requête cURL
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Affichage des détails de la réponse et du code HTTP
        if (curl_errno($ch)) {
            echo 'Erreur cURL : ' . curl_error($ch);
        }
        curl_close($ch);

        // Vérification du code de réponse et gestion des erreurs
        if ($httpCode == 200) {
            $responseData = json_decode($response, true);
            return $responseData['token'];  // Retour du token Bearer
        } else {
            // Affichage du code de réponse HTTP et du message d'erreur
            return ["error" => "Code de réponse HTTP: $httpCode", "response" => $response];
        }
    }


    // Fonction pour envoyer un paiement
    public function sendPayment($amount, $currency, $receiverWallet, $note = "Transaction automatique", $recipientEmail)
    {
        // Si un token Bearer est nécessaire, obtenez-le
        $bearerToken = $this->getBearerToken();

        if (!$bearerToken) {
            return ["error" => "Impossible d'obtenir un token Bearer."];
        }

        // Paramètres pour la requête API
        $data = [
            "amount" => $amount, // Montant en devise demandée
            "currency" => $currency, // Devise à envoyer (ex : USDT)
            "receiver_wallet" => $receiverWallet, // Adresse du portefeuille destinataire
            "recipient_email" => $recipientEmail, // Email du destinataire
            "ipn_callback_url" => "https://ifmap.ci/test/call_back_ipn.php", // URL de notification de paiement
            "note" => $note // Description de la transaction
        ];

        // URL pour lancer la transaction
        $ch = curl_init($this->apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $bearerToken", // Utilisation du token Bearer
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // Exécution de la requête cURL
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Si la requête réussit, traitement de la réponse
        if ($httpCode == 200) {
            return json_decode($response, true);
        } else {
            // Erreur lors de la transaction
            return ["error" => "Erreur lors de la transaction", "response" => $response];
        }
    }
}
