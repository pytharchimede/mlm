<?php
// Récupérer les données JSON envoyées par la requête
$data = json_decode(file_get_contents('php://input'), true);

// Vérification des paramètres envoyés dans le corps JSON
if (isset($data['order_id']) && isset($data['payment_status'])) {
    $order_id = $data['order_id']; // Identifiant de la commande
    $payment_status = $data['payment_status']; // Statut du paiement
    $payment_id = $data['payment_id']; // Identifiant du paiement
    $amount_received = $data['amount_received']; // Montant reçu
    $amount_expected = $data['amount_expected']; // Montant attendu

    // Vérification du paiement
    if ($payment_status === 'success' && $amount_received >= $amount_expected) {
        // Le paiement est valide
        $response = [
            'status' => 'success',
            'message' => 'Le paiement a été confirmé.',
            'order_id' => $order_id,
            'payment_id' => $payment_id,
        ];
    } else {
        // Le paiement est invalide ou échoué
        $response = [
            'status' => 'failure',
            'message' => 'Le paiement a échoué ou le montant reçu est incorrect.',
            'order_id' => $order_id,
        ];
    }

    // Répondre au client avec l'état du paiement
    echo json_encode($response);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Données manquantes.']);
}
