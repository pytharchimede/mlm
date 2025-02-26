<?php
session_start(); // Démarre la session

// Inclure les fichiers nécessaires
include '../model/Database.php';
include '../model/Pack.php';

// Créer une instance de la base de données et de la classe Pack
$databaseObj = new Database();
$pdo = $databaseObj->getConnection();

$packObj = new Pack($pdo);

// Vérifier si l'utilisateur est connecté
$secur = isset($_SESSION['secur']) ? $_SESSION['secur'] : '';
$packDetails = null;
$is_active = false;
$solde = 0;

// Si l'utilisateur est connecté, vérifier l'abonnement actif
if ($secur) {
    $packDetails = $packObj->getPackDetails($secur);
    if ($packDetails) {
        // Pack actif trouvé, récupérer le solde
        $is_active = true;
        $solde = $packDetails['solde'];
    }
}
