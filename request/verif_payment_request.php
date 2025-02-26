<?php
require_once "../model/TransactionVerifier.php";

use Model\TransactionVerifier;

header("Content-Type: application/json");

// Vérification du hash en GET
if (!isset($_POST['hash']) || empty($_POST['hash'])) {
    echo json_encode(["error" => "Hash de transaction requis."]);
    exit;
}


//Hash valide  = 0x7600ccdf149fd01ccdcceeb01ffef8f3d0c7085bc7f8bf80d4a9cccd4c0f1b5c

// Initialisation avec l'API Key
$api_key = "82CD9BUSMRBYMDEA6UJE5BTFHPAIV23HJG";
$verificateur = new TransactionVerifier($api_key);

// Récupération des détails de la transaction
$tx_hash = $_POST['hash'];
$resultat = $verificateur->verifierTransaction($tx_hash);


// Retour en JSON
$resultat["status"] = isset($resultat["success"]) && $resultat["success"] ? "success" : "error";
echo json_encode($resultat, JSON_PRETTY_PRINT);
