<?php
// Vérification des paramètres envoyés
if (isset($_POST['order_id']) && isset($_POST['payment_status'])) {
    $order_id = $_POST['order_id']; // Identifiant de la commande
    $payment_status = $_POST['payment_status']; // Statut du paiement
    $payment_id = $_POST['payment_id']; // Identifiant du paiement
    $amount_received = $_POST['amount_received']; // Montant reçu
    $amount_expected = $_POST['amount_expected']; // Montant attendu

    // Vérification du paiement (cette logique est à adapter selon l'API que tu utilises)
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
