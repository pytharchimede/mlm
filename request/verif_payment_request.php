<?php
session_start();
require_once "../model/Database.php";
require_once "../model/TransactionVerifier.php";
require_once "../model/Pack.php";


use Model\TransactionVerifier;

header("Content-Type: application/json");

// Vérification du hash en GET
if (!isset($_POST['hash']) || empty($_POST['hash'])) {
    echo json_encode(["error" => "Hash de transaction requis."]);
    exit;
}


$databaseObj = new Database();
$pdo =  $databaseObj->getConnection();

$packObj = new Pack($pdo);

$hashExist = $packObj->packExisteDeja($_POST['hash']);

// Vérification de l'existence du hash
if ($hashExist) {
    echo json_encode(["error" => "Hash de transaction déjà utilisé."]);
    exit;
}

//Hash valide  = 0x7600ccdf149fd01ccdcceeb01ffef8f3d0c7085bc7f8bf80d4a9cccd4c0f1b5c

// Initialisation avec l'API Key
$api_key = "82CD9BUSMRBYMDEA6UJE5BTFHPAIV23HJG";
$verificateur = new TransactionVerifier($api_key);

// Récupération des détails de la transaction
$tx_hash = $_POST['hash'];
$_SESSION['transaction_hash'] = $tx_hash;

$resultat = $verificateur->verifierTransaction($tx_hash);


// Retour en JSON
$resultat["status"] = isset($resultat["success"]) && $resultat["success"] ? "success" : "error";
echo json_encode($resultat, JSON_PRETTY_PRINT);
