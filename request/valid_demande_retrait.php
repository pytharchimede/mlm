<?php
session_start();

require_once '../model/Database.php';
require_once '../model/Utilisateur.php';
require_once '../model/DemandeRetrait.php';
require_once '../model/Pack.php';


//Gestion des erreurs après redirection
if (isset($_SESSION['success_message'])) {
    echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
    unset($_SESSION['success_message']); // Supprime le message après affichage
}

if (isset($_SESSION['error_message'])) {
    echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
    unset($_SESSION['error_message']);
}

try {
    // Vérifier si l'ID de la demande de retrait est bien présent et numérique
    if (!isset($_GET['id_demande_retrait']) || !is_numeric($_GET['id_demande_retrait'])) {
        throw new Exception("ID de la demande de retrait invalide.");
    }

    $id_demande_retrait = (int) $_GET['id_demande_retrait'];

    // Instanciation de la connexion à la BDD
    $databaseObj = new Database();
    $pdo = $databaseObj->getConnection();

    // Instanciation de l'objet demande de retrait
    $demandeRetraitobj = new DemandeRetrait($pdo);

    // Récupérer la demande de retrait concernée
    $demandeRetrait = $demandeRetraitobj->getDemandeById($id_demande_retrait);

    if (!$demandeRetrait) {
        throw new Exception("Demande de retrait introuvable.");
    }

    // Instanciation de l'objet pack 
    $packObj = new Pack($pdo);

    // Récupération du pack abonné concerné
    $packAbonne = $packObj->getPackAbonneById($demandeRetrait['pack_abonne_id']);

    if (!$packAbonne) {
        throw new Exception("Pack abonné introuvable.");
    }

    // Vérifier si le solde est suffisant
    $abonneBalance = (float) $packAbonne['solde'];
    $montant_retrait = (float) $demandeRetrait['montant_demande_retrait'];

    if ($abonneBalance < $montant_retrait) {
        throw new Exception("Solde insuffisant pour effectuer ce retrait.");
    }

    $new_balance = $abonneBalance - $montant_retrait;

    // Démarrer une transaction SQL
    $pdo->beginTransaction();

    // Mettre à jour le solde du pack_abonne
    $updatePack = $packObj->updatePackBalance($packAbonne['abonne_secur'], $demandeRetrait['pack_abonne_id'], $new_balance);
    if (!$updatePack) {
        throw new Exception("Échec de la mise à jour du solde du pack.");
    }

    // Mettre à jour le statut de la demande de retrait avec la date de traitement
    $new_status = 1; // Statut "Traité"
    $date_traitement = date('Y-m-d H:i:s'); // Date actuelle

    $updateDemandeRetraitStatus = $demandeRetraitobj->updateDemande($id_demande_retrait, $new_status, $date_traitement);
    if (!$updateDemandeRetraitStatus) {
        throw new Exception("Échec de la mise à jour du statut de la demande.");
    }

    // Valider la transaction
    $pdo->commit();

    // Redirection en cas de succès
    $_SESSION['success_message'] = "Demande de retrait traitée avec succès.";
    header('Location: ../admin/admin/details_montant_reverser.php');
    exit();
} catch (Exception $e) {
    // Annuler la transaction en cas d'erreur
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    // Stocker l'erreur dans la session et rediriger
    $_SESSION['error_message'] = "Erreur : " . $e->getMessage();
    header('Location: ../admin/admin/details_montant_reverser.php');
    exit();
}
