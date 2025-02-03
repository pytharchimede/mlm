<?php

require_once '../model/CryptoPayment.php';
require_once '../model/Config.php';

$cryptoPayment = new CryptoPayment("", "", "");

$response = [];

if (isset($_POST['hash'])) {
    $txid = $_POST['hash'];
    $result = $cryptoPayment->verifyTrc20Transaction($txid);

    if ($result && isset($result['status']) && $result['status'] == 'Confirmed') {
        // Transaction validée avec succès
        $amount_xof = number_format($result['amount_xof'], 0, ',', ' ') . ' XOF'; // Format XOF
        $amount_usdt = number_format($result['amount'] / 1000000, 6) . ' USDT'; // Format USDT
        $response = [
            'status' => 'success',
            'message' => "Nous avons bien reçu un paiement de <strong>{$amount_xof}</strong> en XOF, soit <strong>{$amount_usdt}</strong> en USDT.",
            'details' => [
                'from' => $result['from'],
                'to' => $result['to'],
                'block_number' => $result['block_number'],
                'timestamp' => $result['timestamp'],
                'txid' => $result['txid'],
                'icon_url' => $result['icon_url'],
            ]
        ];
    } else {
        // Transaction échouée
        $response = [
            'status' => 'error',
            'message' => "La transaction TRC20 est introuvable. Veuillez contacter le service client",
        ];
    }
} else {
    $response = [
        'status' => 'error',
        'message' => "Aucun hash de transaction fourni.",
    ];
}

echo json_encode($response);  // Retourner la réponse en JSON
