<?php
session_start();
require_once '../model/Utilisateur.php';

$referal_utilisateur = $_SESSION['ref'] ?? '';

$utilisateurObj = new Utilisateur();
$filleulsCount = $utilisateurObj->countFilleulsByReferal($referal_utilisateur);

if ($filleulsCount !== false) {
    echo json_encode(['success' => true, 'filleulsCount' => $filleulsCount]);
    exit;
} else {
    echo json_encode(['success' => false]);
    exit;
}
