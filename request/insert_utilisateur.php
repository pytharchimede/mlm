<?php
// Inclure les classes nécessaires
require_once '../model/Database.php';
require_once '../model/EmailManager.php';
require_once '../model/Utilisateur.php';


//Instanciation de la BDD
$databaseObj = new Database();
$pdo = $databaseObj->getConnection();

// Créer une instance de la classe Utilisateur
$utilisateurObj = new Utilisateur();

// Vérifier si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
    exit;
}

// Récupérer les données du formulaire
$nom = $_POST['nom'] ?? '';
$email = $_POST['email'] ?? '';
$mot_de_passe = $_POST['mot_de_passe'] ?? '';

// Effectuer une validation des données
if (empty($nom) || empty($email) || empty($mot_de_passe)) {
    echo json_encode(['success' => false, 'message' => 'Données manquantes']);
    exit;
}



// Vérifier si l'email existe déjà dans la base de données
if ($utilisateurObj->checkEmailExists($email)) {
    echo json_encode(['success' => false, 'message' => 'L\'email est déjà utilisé']);
    exit;
}

// Vérifier si le téléphone existe déjà dans la base de données (optionnel, si vous avez un champ téléphone dans le formulaire)
$telephone = $_POST['telephone'] ?? '';
if ($telephone && $utilisateurObj->checkPhoneExists($telephone)) {
    echo json_encode(['success' => false, 'message' => 'Le téléphone est déjà utilisé']);
    exit;
}

// Enregistrer l'utilisateur dans la base de données
$token = bin2hex(random_bytes(16)); // Générer un jeton unique pour la confirmation

// Enregistrer l'utilisateur dans la base de données
$token = bin2hex(random_bytes(16)); // Générer un jeton unique pour la confirmation

$registration_success = $utilisateurObj->register($nom, $email, $telephone, $mot_de_passe);

// Vérifier si l'enregistrement a réussi
if ($registration_success) {
    // Envoyer l'email de confirmation
    $emailManager = new EmailManager();
    $subject = "Confirmation de votre inscription";
    $body = "<p>Bonjour $nom,</p><p>Merci de vous etre inscrit sur notre plateforme. Veuillez confirmer votre inscription en cliquant sur le lien suivant :</p><a href='https://ifmap.ci/test/confirmation_email.php?email=$email&token=$token'>Confirmer mon inscription</a>";

    // Envoyer l'email
    $sent = $emailManager->sendEmail($subject, $body, [$email => $nom]);

    if ($sent) {
        // Utiliser la méthode updateConfirmationToken
        $update_success = $utilisateurObj->updateConfirmationToken($email, $token);

        if ($update_success) {
            echo json_encode(['success' => true, 'message' => 'Utilisateur enregistré et email de confirmation envoyé']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour du jeton de confirmation']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'envoi de l\'email']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'enregistrement de l\'utilisateur']);
}
