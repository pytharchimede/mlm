<?php
// Inclure les fichiers nécessaires pour la base de données et la classe Contact
require_once '../model/Database.php';
require_once '../model/Contact.php';

// Appeler la méthode qui retourne les statistiques des invitations
$statisticsData = Contact::getStatistics(); // Utilisez la méthode appropriée dans votre classe Contact

// Préparer les données pour le graphique
$labels = $statisticsData['labels']; // Labels dynamiques récupérés depuis la méthode getStatistics
$data = $statisticsData['invites_per_day']; // Données dynamiques récupérées depuis la méthode getStatistics

// Préparer la réponse en JSON
$response = [
    'total_invited' => $statisticsData['total_invited'],
    'invited_today' => $statisticsData['invited_today'],
    'labels' => $labels,
    'data' => $data
];

// Envoyer la réponse JSON
echo json_encode($response);
