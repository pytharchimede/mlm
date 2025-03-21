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
$packObj = new Pack($pdo);

$secur = $_SESSION['secur'] ?? '';
$monProfil = $utilisateurObj->getUserBySecur($secur);
$filleuls = $utilisateurObj->getFilleulsByReferal($secur);

$effectif_reseau = 0;

if ($monProfil) {
    $effectif_reseau = 1;
}

$packParrainDetails = $packObj->getPackDetails($monProfil["secur_utilisateur"]);

$data = [
    "marraine" => [
        "id" => $monProfil["id_utilisateur"],
        "nom" => $monProfil["nom_utilisateur"],
        "email" => $monProfil["email_utilisateur"],
        "solde" => $packParrainDetails['solde'],
        "statut" => $monProfil["valide_utilisateur"] == "1" ? "Actif" : "Inactif",
        "referal" => $monProfil["referal_utilisateur"],
        "secur" => $monProfil["secur_utilisateur"],
        "est_moi" => true
    ],
    "filleuls_niveau2" => [],
    "filleuls_niveau3" => [],
    "filleuls_niveau4" => [],
    "filleuls_niveau5" => [],
    "effectif_reseau" => 0
];

foreach ($filleuls as $filleul) {
    $packFilleulDetails = $packObj->getPackDetails($filleul["secur_utilisateur"]);
    $filleulActif = $packObj->isPackActive($filleul["secur_utilisateur"]);

    // Ajouter le filleul de niveau 2
    $data["filleuls_niveau2"][] = [
        "id" => $filleul["id_utilisateur"],
        "nom" => $filleul["nom_utilisateur"],
        "email" => $filleul["email_utilisateur"],
        "solde" => $packFilleulDetails['solde'],
        "statut" => $filleulActif ? "Actif" : "Inactif",
        "referal" => $filleul["referal_utilisateur"],
        "secur" => $filleul["secur_utilisateur"],
        "est_moi" => false
    ];

    $effectif_reseau++;

    $filleulsNiveau3 = $utilisateurObj->getFilleulsByReferal($filleul["secur_utilisateur"]);
    foreach ($filleulsNiveau3 as $filleulniveau3) {
        $packFilleulNiveau3Details = $packObj->getPackDetails($filleulniveau3["secur_utilisateur"]);
        $filleulniveau3Actif = $packObj->isPackActive($filleulniveau3["secur_utilisateur"]);

        // Ajouter le filleul de niveau 3
        $data["filleuls_niveau3"][] = [
            "id" => $filleulniveau3["id_utilisateur"],
            "nom" => $filleulniveau3["nom_utilisateur"],
            "email" => $filleulniveau3["email_utilisateur"],
            "solde" => $packFilleulNiveau3Details['solde'],
            "statut" => $filleulniveau3Actif ? "Actif" : "Inactif",
            "referal" => $filleulniveau3["referal_utilisateur"],
            "secur" => $filleulniveau3["secur_utilisateur"],
            "est_moi" => false
        ];

        $effectif_reseau++;

        $filleulsNiveau4 = $utilisateurObj->getFilleulsByReferal($filleulniveau3["secur_utilisateur"]);
        foreach ($filleulsNiveau4 as $filleulniveau4) {
            $packFilleulNiveau4Details = $packObj->getPackDetails($filleulniveau4["secur_utilisateur"]);
            $filleulniveau4Actif = $packObj->isPackActive($filleulniveau4["secur_utilisateur"]);

            // Ajouter le filleul de niveau 4
            $data["filleuls_niveau4"][] = [
                "id" => $filleulniveau4["id_utilisateur"],
                "nom" => $filleulniveau4["nom_utilisateur"],
                "email" => $filleulniveau4["email_utilisateur"],
                "solde" => $packFilleulNiveau4Details['solde'],
                "statut" => $filleulniveau4Actif ? "Actif" : "Inactif",
                "referal" => $filleulniveau4["referal_utilisateur"],
                "secur" => $filleulniveau4["secur_utilisateur"],
                "est_moi" => false
            ];

            $effectif_reseau++;

            $filleulsNiveau5 = $utilisateurObj->getFilleulsByReferal($filleulniveau4["secur_utilisateur"]);
            foreach ($filleulsNiveau5 as $filleulniveau5) {
                $packFilleulNiveau5Details = $packObj->getPackDetails($filleulniveau5["secur_utilisateur"]);
                $filleulniveau5Actif = $packObj->isPackActive($filleulniveau5["secur_utilisateur"]);

                // Ajouter le filleul de niveau 5
                $data["filleuls_niveau5"][] = [
                    "id" => $filleulniveau5["id_utilisateur"],
                    "nom" => $filleulniveau5["nom_utilisateur"],
                    "email" => $filleulniveau5["email_utilisateur"],
                    "solde" => $packFilleulNiveau5Details['solde'],
                    "statut" => $filleulniveau5Actif ? "Actif" : "Inactif",
                    "referal" => $filleulniveau5["referal_utilisateur"],
                    "secur" => $filleulniveau5["secur_utilisateur"],
                    "est_moi" => false
                ];

                $effectif_reseau++;
            }
        }
    }
}

$data["effectif_reseau"] = $effectif_reseau;

header("Content-Type: application/json");
echo json_encode($data, JSON_PRETTY_PRINT);
