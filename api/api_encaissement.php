<?php
// Exemple d'API en PHP pour retourner les données statistiques

// On récupère les données de la base de données ou d'un autre service
$data = [
    'montant_encaisse' => 50000, // Montants encaissés
    'montant_reverser' => 20000, // Montants à reverser
    'chiffre_affaire' => 70000,  // Chiffre d'affaires
    'demandes' => [              // Liste des demandes de retrait
        ['nom' => 'John Doe', 'montant' => '100', 'statut' => 'En attente', 'date' => '2025-03-01'],
        ['nom' => 'Jane Doe', 'montant' => '150', 'statut' => 'Approuvé', 'date' => '2025-03-02'],
    ]
];

header('Content-Type: application/json');
echo json_encode($data);
