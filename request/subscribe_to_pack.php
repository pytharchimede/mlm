<?php
session_start();
// Inclure le fichier de connexion à la base de données
require_once '../model/Database.php';
require_once '../model/Pack.php';

$databaseObj = new Database();
$pdo = $databaseObj->getConnection();

header('Content-Type: application/json');


// Vérifier que les données sont envoyées via POST
if (isset($_POST['abonne_secur'], $_POST['pack_id'], $_POST['date_souscription'])) {
    // Récupérer les données envoyées par AJAX
    $abonne_secur = $_POST['abonne_secur'];
    $pack_id = $_POST['pack_id'];
    $solde = $_POST['solde'];
    $date_souscription = $_POST['date_souscription'];
    $date_fin = isset($_POST['date_fin']) ? $_POST['date_fin'] : null;  // Si la date_fin n'est pas définie, la mettre à null

    // Créer une instance de la classe Pack
    $packObj = new Pack($pdo);

    // Appeler la méthode pour souscrire l'abonné au pack
    $success = $packObj->subscribeToPack($abonne_secur, $pack_id, $solde, $date_souscription, $date_fin, $actif = 1);

    // Retourner la réponse en JSON
    if ($success) {
        echo json_encode(['success' => true]);
        exit;
    } else {
        echo json_encode(['success' => false, 'error' => 'Impossible de souscrire au pack']);
        exit;
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Données manquantes']);
    exit;
}
