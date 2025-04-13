<?php

require_once '../model/Database.php';
require_once '../model/Contact.php';

if (isset($_POST['contact_id'])) {
    $contact_id = $_POST['contact_id'];
    $invited_by = 'user123'; // Vous pouvez adapter cela pour utiliser l'ID de l'utilisateur actuel
    $ip_address = $_SERVER['REMOTE_ADDR'];  // Adresse IP de l'utilisateur
    $port = $_SERVER['REMOTE_PORT'];        // Port de la requête
    $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'Inconnu';

    // Connexion à la base de données
    $database = new Database();
    $pdo = $database->getConnection();

    $date = gmdate('Y-m-d H:i:s'); // Exemple de date spécifique pour l'invitation

    // Mettre à jour l'invitation pour le contact
    if (Contact::updateInvitation($pdo, $contact_id, $invited_by, $date)) {
        // Sauvegarder le clic dans la table des invitations (optionnel)
        $stmt = $pdo->prepare("INSERT INTO clicks_invitation (contact_id, ip_address, port, user_agent, click_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$contact_id, $ip_address, $port, $user_agent, $date]);

        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update invitation']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Missing required parameters']);
}
