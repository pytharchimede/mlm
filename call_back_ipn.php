<?php
require_once 'model/Config.php';

// Vérifier que la requête est une notification IPN de NowPayments
if (!isset($_SERVER['HTTP_X_SIGNATURE'])) {
    die('Invalid request');
}

// Récupérer les données de la notification IPN envoyée par NowPayments
$input = file_get_contents("php://input");
$data = json_decode($input, true);

// Vérifier l'authenticité de l'IPN via l'API de NowPayments
$apiKey = Config::get('API_KEY'); // Remplacez par votre clé API NowPayments
$signature = $_SERVER['HTTP_X_SIGNATURE']; // Récupérer la signature dans les en-têtes HTTP

// Vérifier que la signature est valide
$calculatedSignature = hash_hmac('sha512', $input, $apiKey);
if ($signature !== $calculatedSignature) {
    // Signature invalide
    die('Invalid signature');
}

// Traitement de la notification
if ($data['status'] == 'success') {
    // Le paiement a été effectué avec succès
    $orderId = $data['order_id'];
    $amount = $data['price_amount'];
    $currency = $data['price_currency'];
    $receiverWallet = $data['receiver_wallet'];

    // Effectuer des actions, comme enregistrer la transaction dans la base de données
    // Exemple : mettre à jour l'état de la commande en "payée"
    // updateOrderStatus($orderId, 'paid');
    echo 'Payment successful for order: ' . $orderId;
} else {
    // Le paiement a échoué ou est en attente
    echo 'Payment failed or pending for order: ' . $data['order_id'];
}
