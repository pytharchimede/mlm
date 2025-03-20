<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "Utilisateur non connecté"]);
    exit;
}

include_once '../model/Database.php';
include_once '../model/Utilisateur.php';
include_once '../model/Pack.php';

$databaseObj = new Database();
$pdo = $databaseObj->getConnection();
$utilisateurObj = new Utilisateur();


//nstanciation de l'objet pack
$packObj = new Pack($pdo);

$secur = $_SESSION['secur'] ?? '';
$monProfil = $utilisateurObj->getUserBySecur($secur);
$filleuls = $utilisateurObj->getFilleulsByReferal($secur);

//Details pack parrain/Marraine
$packParrainDetails = $packObj->getPackDetails($monProfil["secur_utilisateur"]);

// Transformer les données pour JSON
$data = [
    "marraine" => [
        "id" => $monProfil["id_utilisateur"],
        "nom" => $monProfil["nom_utilisateur"],
        "email" => $monProfil["email_utilisateur"],
        "solde" => $packParrainDetails['solde'], // Solde aléatoire plus grand pour la marraine
        "statut" => $monProfil["valide_utilisateur"] == "1" ? "Actif" : "Inactif",
        "referal" => $monProfil["referal_utilisateur"],
        "secur" => $monProfil["secur_utilisateur"],
        "est_moi" => true
    ],
    "filleuls" => []
];

foreach ($filleuls as $filleul) {

    //Vérfier si l filleul est actif
    $filleulActif = $packObj->isPackActive($filleul["secur_utilisateur"]);
    $packFilleulDetails = $packObj->getPackDetails($filleul["secur_utilisateur"]);

    $data["filleuls"][] = [
        "id" => $filleul["id_utilisateur"],
        "nom" => $filleul["nom_utilisateur"],
        "email" => $filleul["email_utilisateur"],
        "solde" => $packFilleulDetails['solde'],
        "statut" => $filleulActif == true ? "Actif" : "Inactif",
        "referal" => $filleul["referal_utilisateur"],
        "secur" => $filleul["secur_utilisateur"],
        "est_moi" => false
    ];
}

header("Content-Type: application/json");
echo json_encode($data);
