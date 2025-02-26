<?php

namespace Model;

class TransactionVerifier
{
    private $api_key;
    private $base_url = "https://api.bscscan.com/api";
    private $adresse_attendue = "0x3EE6b70be3Ce35cb03403b64F960B72Df575573b"; // Adresse à vérifier

    public function __construct($api_key)
    {
        $this->api_key = $api_key;
    }

    /**
     * Vérifie si une transaction est valide en fonction du hash et de l'adresse destinataire
     * @param string $tx_hash - Hash de la transaction
     * @return array - Détails de la transaction ou message d'erreur
     */
    public function verifierTransaction($tx_hash)
    {
        if (empty($tx_hash)) {
            return ["error" => "Le hash de transaction est requis."];
        }

        // Vérifier les détails de la transaction
        $url = "$this->base_url?module=proxy&action=eth_getTransactionByHash&txhash=$tx_hash&apikey=$this->api_key";
        $details = $this->makeRequest($url);

        if (!isset($details['result']) || empty($details['result'])) {
            return ["error" => "Transaction introuvable ou invalide."];
        }

        $transaction = $details['result'];

        // Vérifier l'adresse de destination
        $to_address = strtolower($transaction['to']);
        if ($to_address !== strtolower($this->adresse_attendue)) {
            return ["error" => "L'adresse de destination ne correspond pas."];
        }

        // Vérifier le montant en BNB
        $montant_bnb = hexdec($transaction['value']) / 1e18;
        if ($montant_bnb <= 0) {
            return ["error" => "Montant de transaction invalide."];
        }

        // Convertir en USD
        $prix_bnb = $this->getPrixBNB();
        $montant_usd = $montant_bnb * $prix_bnb;

        if ($montant_usd < 15) {
            return ["error" => "Montant insuffisant (moins de 15 USDT)."];
        }

        // Récupérer la date de la transaction
        $timestamp = hexdec($transaction['timeStamp'] ?? "0");
        $date_transaction = $timestamp ? date("Y-m-d H:i:s", $timestamp) : "Inconnue";

        return [
            "success" => true,
            "message" => "Transaction validée !",
            "montant_bnb" => $montant_bnb,
            "montant_usd" => round($montant_usd, 2),
            "date_transaction" => $date_transaction,
            "adresse_destinataire" => $to_address,
            "details" => $transaction
        ];
    }

    /**
     * Récupère le prix actuel du BNB en USD
     * @return float - Prix du BNB en USD
     */
    private function getPrixBNB()
    {
        $url = "$this->base_url?module=stats&action=bnbprice&apikey=$this->api_key";
        $response = $this->makeRequest($url);
        return isset($response['result']['ethusd']) ? (float)$response['result']['ethusd'] : 0;
    }

    /**
     * Effectue une requête API et retourne les données sous forme de tableau associatif
     * @param string $url - URL de l'API
     * @return array - Réponse JSON décodée
     */
    private function makeRequest($url)
    {
        $response = file_get_contents($url);
        return json_decode($response, true);
    }
}
