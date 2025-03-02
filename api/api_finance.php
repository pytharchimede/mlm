<?php

require_once '../model/Database.php';
require_once '../model/FinanceManager.php';

header('Content-Type: application/json');

$databaseObj = new Database();
$pdo = $databaseObj->getConnection();

$financeObj = new FinanceManager($pdo);

$nbrePacksActifs = $financeObj->countSubscribedPacksWithTransaction();
$montantEncaisses = 15 * $nbrePacksActifs;
$demandesRetrait = $financeObj->getWithdrawalRequests();
$listePacksAbonne = $financeObj->getAllSubscribedPacks();
$listeUtilisateurs = $financeObj->getAllUsers();
$listeUtilisateursActifs = $financeObj->getActiveUsers();
$pourcentageUtilisateursActifs = $financeObj->getActiveUsersPercentage();
$montantTotalAReverser = $financeObj->getTotalReversibleAmount();

$response = [
    "nbrePacksActifs" => $nbrePacksActifs,
    "montantEncaisses" => $montantEncaisses,
    "demandesRetrait" => $demandesRetrait,
    "listePacksAbonne" => $listePacksAbonne,
    "listeUtilisateurs" => $listeUtilisateurs,
    "listeUtilisateursActifs" => $listeUtilisateursActifs,
    "pourcentageUtilisateursActifs" => $pourcentageUtilisateursActifs,
    "montantTotalAReverser" => $montantTotalAReverser
];

echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
