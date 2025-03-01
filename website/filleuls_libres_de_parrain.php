<?php
session_start();
require_once '../model/Utilisateur.php';

// Vérifiez si la session 'ref' existe, sinon définissez-la comme vide
$referal_utilisateur = $_SESSION['ref'] ?? '';

// Créez une instance de la classe Utilisateur
$utilisateurObj = new Utilisateur();

// Récupérez les filleuls du parrain à partir de la session
$filleulsDuParrain = $utilisateurObj->getFilleulsByReferal($referal_utilisateur);

// Tableau pour stocker les filleuls libres
$filleulsLibres = [];

foreach ($filleulsDuParrain as $filleul) {
    // Comptez le nombre de filleuls associés à chaque filleul
    $nb_filleul = $utilisateurObj->countFilleulsByReferal($filleul['secur_utilisateur']);

    // Si le nombre de filleuls est inférieur à 5, on l'ajoute à la liste
    if ($nb_filleul < 5) {
        $filleulsLibres[] = $filleul;  // Ajoutez directement sans utiliser l'indice $i
    }
}

// Retournez les données au format JSON si des filleuls libres ont été trouvés
if (!empty($filleulsLibres)) {
    echo json_encode(['success' => true, 'filleuls' => $filleulsLibres]);
    exit;
} else {
    // Sinon, indiquez qu'aucun filleul libre n'a été trouvé
    echo json_encode(['success' => false]);
    exit;
}
