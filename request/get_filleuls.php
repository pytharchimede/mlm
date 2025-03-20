<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "Utilisateur non connecté"]);
    exit;
}

include '../model/Database.php';
include '../model/Utilisateur.php';

$databaseObj = new Database();
$pdo = $databaseObj->getConnection();
$utilisateurObj = new Utilisateur();

$secur = $_SESSION['secur'] ?? '';
$monProfil = $utilisateurObj->getUserBySecur($secur);
$filleuls = $utilisateurObj->getFilleulsByReferal($secur);

// Transformer les données pour JSON
$data = [
    "marraine" => [
        "id" => $monProfil["id_utilisateur"],
        "nom" => $monProfil["nom_utilisateur"],
        "email" => $monProfil["email_utilisateur"],
        "solde" => rand(500, 2000), // Solde aléatoire plus grand pour la marraine
        "statut" => $monProfil["valide_utilisateur"] == "1" ? "Actif" : "Inactif",
        "referal" => $monProfil["referal_utilisateur"],
        "secur" => $monProfil["secur_utilisateur"],
        "est_moi" => true
    ],
    "filleuls" => []
];

foreach ($filleuls as $filleul) {
    $data["filleuls"][] = [
        "id" => $filleul["id_utilisateur"],
        "nom" => $filleul["nom_utilisateur"],
        "email" => $filleul["email_utilisateur"],
        "solde" => rand(10, 500),
        "statut" => $filleul["valide_utilisateur"] == "1" ? "Actif" : "Inactif",
        "referal" => $filleul["referal_utilisateur"],
        "secur" => $filleul["secur_utilisateur"],
        "est_moi" => false
    ];
}

header("Content-Type: application/json");
echo json_encode($data);
