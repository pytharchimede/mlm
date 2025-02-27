<?php
session_start();

include '../model/Database.php';
include '../model/DemandeRetrait.php';
include '../model/Pack.php';

header('Content-Type: application/json');


// Créer une instance de la base de données et de la classe DemandeRetrait
$databaseObj = new Database();
$pdo = $databaseObj->getConnection();
$demandeRetraitObj = new DemandeRetrait($pdo);
$packObj = new Pack($pdo);

$secur = $_SESSION['secur'];

//Vérifier si l'utilisateur a un pack actif 
$actif = $packObj->isPackActive($secur);

if (!$actif) {
    echo json_encode(['success' => false, 'message' => 'Aucun pack actif']);
    exit;
} else {
    $packDetails = $packObj->getPackDetails($secur);

    // Récupérer les données envoyées par AJAX
    $withdrawalAmount = isset($_POST['withdrawalAmount']) ? $_POST['withdrawalAmount'] : null;
    $packAbonneId = $packDetails['id_pack_abonne']; // À adapter selon l'utilisateur ou les informations nécessaires
    $statutDemandeRetrait = 0; // Statut par défaut, par exemple "En attente"
    $commentaireDemandeRetrait = 'Aucun commentaire'; // Commentaire par défaut
    $soldePack = $packDetails['solde'];

    if ($soldePack < $withdrawalAmount) {
        echo json_encode(['success' => false, 'message' => 'Dépassement du montant disponible']);
        exit;
    }
}

// Vérifier si le montant est valide
if ($withdrawalAmount && is_numeric($withdrawalAmount)) {
    try {

        // Ajouter la demande de retrait
        $success = $demandeRetraitObj->addDemande($packAbonneId, $withdrawalAmount, $statutDemandeRetrait, $commentaireDemandeRetrait);

        // Retourner une réponse JSON
        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Votre demande de retrait a été soumise avec succès !']);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Une erreur est survenue lors de la soumission de la demande.']);
            exit;
        }
    } catch (Exception $e) {
        // En cas d'erreur, renvoyer un message d'erreur
        echo json_encode(['success' => false, 'message' => 'Erreur serveur : ' . $e->getMessage()]);
        exit;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Le montant du retrait est invalide.']);
    exit;
}
