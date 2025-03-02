<?php
// Connexion à la base de données
require_once '../model/Database.php';
require_once '../model/VisiteLogger.php';


$databaseObj = new Database();
$pdo = $databaseObj->getConnection();

$visiteObj = new VisiteLogger($pdo);

// Lister les visites
$visites = $visiteObj->listerVisites();

// Calcul des statistiques
$total_visites = count($visites);

// Statistiques par pays
$statistiques_pays = [];
foreach ($visites as $visite) {
    $pays = $visite['pays'];
    if (!isset($statistiques_pays[$pays])) {
        $statistiques_pays[$pays] = 0;
    }
    $statistiques_pays[$pays]++;
}
arsort($statistiques_pays); // Trie par nombre de visites

// Statistiques par navigateur
$statistiques_navigateur = [];
foreach ($visites as $visite) {
    $navigateur = $visite['navigateur'];
    if (!isset($statistiques_navigateur[$navigateur])) {
        $statistiques_navigateur[$navigateur] = 0;
    }
    $statistiques_navigateur[$navigateur]++;
}
arsort($statistiques_navigateur); // Trie par nombre de visites