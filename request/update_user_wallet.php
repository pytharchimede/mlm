<?php
session_start();

require_once '../model/Utilisateur.php';

$utilisateurObj = new Utilisateur();
$secur = $_SESSION['secur'];

header('Content-Type: application/json');

$response = ["status" => "error", "message" => "Requête invalide."];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["wallet_address"])) {
    $walletAddress = trim($_POST["wallet_address"]);

    if ($utilisateurObj->updateBnbWalletAdress($secur, $walletAddress)) {
        $response = ["status" => "success", "message" => "Adresse enregistrée avec succès !"];
    } else {
        $response = ["status" => "error", "message" => "Erreur lors de la mise à jour de l'adresse."];
    }
}

echo json_encode($response);
exit;
