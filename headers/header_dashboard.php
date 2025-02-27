<?php
// Vérifier si l'utilisateur est connecté, sinon le déconnecter
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}


// Inclure les fichiers nécessaires
include '../model/Database.php';
include '../model/Pack.php';
include '../model/Utilisateur.php';

// Créer une instance de la base de données et de la classe Pack
$databaseObj = new Database();
$pdo = $databaseObj->getConnection();

$packObj = new Pack($pdo);
$utilisateurObj = new Utilisateur();

// Vérifier si l'utilisateur est connecté
$secur = isset($_SESSION['secur']) ? $_SESSION['secur'] : '';
$packDetails = null;
$is_active = false;
$solde = 0;


//Liste des filleuls
$filleuls = $utilisateurObj->getFilleulsByReferal($secur);

// Si l'utilisateur est connecté, vérifier l'abonnement actif
if ($secur) {
    $packDetails = $packObj->getPackDetails($secur);
    if ($packDetails) {
        // Pack actif trouvé, récupérer le solde
        $is_active = true;
        $solde = $packDetails['solde'];
    }
}

$hasWallet = $utilisateurObj->checkWalletAddress($secur); // true ou false

// Récupérer l'adresse du wallet existant si elle existe
$walletAddress = null;
if ($hasWallet) {
    $walletAddress = $utilisateurObj->getWalletAddress($secur); // Assure-toi d'avoir une méthode pour récupérer l'adresse
}
