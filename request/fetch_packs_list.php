<?php
// Définir l'en-tête pour la réponse JSON
header('Content-Type: application/json');

// URL de l'API qui retourne la liste des packs
$api_url = '../api/api_get_pack.php'; // Remplace par l'URL réelle

// Récupérer les données depuis l'API
$response = file_get_contents($api_url);

// Vérifier si la récupération a réussi
if ($response === false) {
    echo json_encode(['status' => 'error', 'message' => 'Impossible de récupérer les packs']);
    exit;
}

// Décoder la réponse JSON en tableau PHP
$packs = json_decode($response, true);


// Vérifier si le JSON est valide
if (!is_array($packs)) {
    echo json_encode(['status' => 'error', 'message' => 'Réponse invalide']);
    exit;
}

// Reformater les données selon la structure demandée
$formatted_packs = array_map(function ($pack) {
    return [
        'name'   => $pack['name'],
        'price'  => $pack['price'],
        'rating' => $pack['rating']
    ];
}, $packs);


error_log(print_r($formatted_packs, true));

// Retourner le JSON formaté
echo json_encode($formatted_packs, JSON_PRETTY_PRINT);
