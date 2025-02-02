<?php

// Informations d'authentification API
$api_key = "VWE4S3C-2R84KGN-H1TR9R3-W514NC5";
$ipn_secret = "6BCdJPz74ShyIlH3rSbaHvnJVYXfVg5G";
$wallet_address = "TXy1PXC1xvgvGcfsc2zy6y6krooYUUhJcT";

// Montant du paiement
$amount = 25000; // en FCFA
$currency = "XOF"; // Devise

// URL de l'API (À remplacer par l'URL correcte)
$api_url = "https://api.paymentprovider.com/initiate-payment";

// Préparation des données à envoyer
$data = [
    "api_key" => $api_key,
    "amount" => $amount,
    "currency" => $currency,
    "wallet_address" => $wallet_address,
    "ipn_secret" => $ipn_secret,
    "description" => "Paiement de 25000 FCFA",
];

// Initialisation de cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer " . $api_key
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Exécution de la requête et récupération de la réponse
$response = curl_exec($ch);
curl_close($ch);

// Décode la réponse JSON
$result = json_decode($response, true);

// Affichage pour débogage
echo "<h2>Réponse de l'API :</h2>";
echo "<pre>";
print_r($result); // On affiche la réponse complète pour voir ce qu'elle contient
echo "</pre>";
