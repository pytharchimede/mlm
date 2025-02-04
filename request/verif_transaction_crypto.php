<?php

// Assurez-vous que l'utilisateur est connecté, sinon rediriger vers la page de connexion
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}


require_once '../model/CryptoPayment.php';
require_once '../model/Config.php';
require_once '../model/Utilisateur.php';
require_once '../model/Paiement.php';


$utilisateurObj = new Utilisateur();
$utilisateur = $utilisateurObj->getUserById($_SESSION['user_id']);


$paiementObj = new Paiement();

$secur_paie = $utilisateur['secur_utilisateur'];
$pack_id = isset($_SESSION['packId']) ? $_SESSION['packId'] : '0';
$mode_paiement = 'USDT TRC20';

// Initialiser l'objet CryptoPayment
$cryptoPayment = new CryptoPayment("", "", "");

$response = [];

if (isset($_POST['hash'])) {
    $txid = $_POST['hash'];
    $result = $cryptoPayment->verifyTrc20Transaction($txid);

    $dateObj = DateTime::createFromFormat('Y-m-d H:i:s', $result['timestamp']);
    if (!$dateObj) {
        die('Erreur : Format de date invalide !');
    }
    $date_paiement = $dateObj->format('Y-m-d H:i:s');

    if ($result && isset($result['status']) && $result['status'] == 'Confirmed') {


        $data = [];


        //Enregistrement de la transaction en BDD
        $data = [
            'date_paiement'   => $date_paiement,
            'montant_paiement' => $result['amount_xof'],
            'pack_id'         => $pack_id,
            'secur_paie'      => $secur_paie,
            'mode_paiement'   => $mode_paiement
        ];

        // Debug pour vérifier les valeurs
        error_log(print_r($data, true));

        // Enregistrement de la transaction en BDD
        $save_payment_result = $paiementObj->enregistrerPaiement(
            $data['date_paiement'],
            $data['montant_paiement'],
            $data['pack_id'],
            $data['secur_paie'],
            $data['mode_paiement']
        );

        error_log(print_r($save_payment_result, true));

        error_log(print_r($utilisateur, true));


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
