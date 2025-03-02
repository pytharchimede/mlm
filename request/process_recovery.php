<?php
include '../model/Database.php';
include '../model/Utilisateur.php';
include '../model/EmailManager.php';

$databaseObj =  new Database();
$pdo = $databaseObj->getConnection();
$utilisateurObj = new Utilisateur();
$emailManager = new EmailManager();

// Récupérer l'email envoyé via la requête AJAX
$email = $_POST['email'];

$mailExist = $utilisateurObj->checkEmailExists($email);

if ($mailExist) {
    // Générer un token de réinitialisation unique
    $token = bin2hex(random_bytes(50));

    // Sauvegarder le token dans la base de données
    $updateToken = $utilisateurObj->updateResetToken($email, $token);
    if (!$updateToken) {
        echo json_encode(['success' => false, 'message' => 'Impossible de générer un token de réinitialisation.']);
        exit;
    }

    // Générer le lien de réinitialisation
    $resetLink = "http://comodubo.com/reset_password.php?token=" . $token;
    $subject = "Réinitialisation de votre mot de passe";
    $message = "Bonjour, veuillez cliquer sur le lien suivant pour réinitialiser votre mot de passe : " . $resetLink;

    // Envoyer l'email de réinitialisation
    $recipients = [$email => 'Utilisateur'];
    $cc = [];  // Ajouter des CC si nécessaire
    $bcc = [];  // Ajouter des BCC si nécessaire

    if ($emailManager->sendEmail($subject, $message, $recipients, $cc, $bcc)) {
        echo json_encode(['success' => true, 'message' => 'Un email de réinitialisation a été envoyé.']);
        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'Impossible d\'envoyer l\'email.']);
        exit;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Cet email n\'est pas enregistré dans notre système.']);
    exit;
}
