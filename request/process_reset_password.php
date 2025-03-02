<?php
session_start();

// Inclure la classe Utilisateur et la base de données
require_once '../model/Utilisateur.php';
require_once '../model/Database.php';

// Récupérer les données de la requête POST
if (isset($_POST['token']) && isset($_POST['password'])) {
    $token = $_POST['token'];
    $password = $_POST['password'];

    // Créer une instance de la classe Utilisateur
    $utilisateur = new Utilisateur();

    // Vérifier si le token existe dans la base de données
    $user = $utilisateur->getUserByResetToken($token);

    if ($user) {
        // Hacher le nouveau mot de passe
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Mettre à jour le mot de passe dans la base de données
        $utilisateur->updatePassword($user['email_utilisateur'], $hashed_password);

        // Réinitialiser le token de réinitialisation pour éviter qu'il ne soit utilisé à nouveau
        $utilisateur->clearResetToken($user['email_utilisateur']);

        // Stocker les informations de l'utilisateur dans la session
        $_SESSION['user_id'] = $user['id_utilisateur'];
        $_SESSION['email'] = $user['email_utilisateur'];
        $_SESSION['nom'] = $user['nom_utilisateur'];
        $_SESSION['secur'] = $user['secur_utilisateur'];
        $_SESSION['acces_admin'] = $user['acces_admin'];

        // Rediriger l'utilisateur vers le tableau de bord
        header('Location: /app/dashboard.php');
        exit;
    } else {
        // Si le token n'est pas valide
        echo json_encode(['status' => 'error', 'message' => 'Le lien de réinitialisation est invalide ou expiré.']);
        exit;
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Veuillez remplir tous les champs.']);
    exit;
}
