<?php
// Définir l'en-tête pour la réponse JSON
header('Content-Type: application/json');

// Inclure la classe Utilisateur et Tracabilite
require_once '../model/Utilisateur.php';
require_once '../model/Tracabilite.php';
require_once '../model/Database.php';

error_log(print_r($_POST, true));

// Récupérer les données de la requête POST
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Créer une instance de la classe Utilisateur
    $utilisateur = new Utilisateur();

    // Vérifier si l'utilisateur existe
    $user = $utilisateur->getUserByEmail($email);

    // Loguer les données de l'utilisateur récupérées pour débogage
    // error_log('Utilisateur récupéré: ' . print_r($user, true));

    if ($user) {
        // Loguer le mot de passe envoyé pour débogage
        // error_log('Mot de passe envoyé : ' . $password);

        // Vérifier si le mot de passe est correct
        if ($utilisateur->verifyPassword($email, $password)) {
            // Connexion réussie : on démarre une session et on redirige vers le tableau de bord
            session_start();

            // Stocker les informations de l'utilisateur dans la session
            $_SESSION['user_id'] = $user['id_utilisateur'];
            $_SESSION['email'] = $user['email_utilisateur'];
            $_SESSION['nom'] = $user['nom_utilisateur'];

            // Créer une instance de la classe Tracabilite
            $tracabilite = new Tracabilite(Database::getConnection());

            // Enregistrer l'action de connexion réussie
            $tracabilite->enregistrerAction("Connexion réussie pour l'utilisateur : " . $user['email_utilisateur']);

            // Vérifier si l'utilisateur veut être "souvenu"
            if (isset($_POST['remember'])) {
                setcookie('user_id', $user['id_utilisateur'], time() + 60 * 60 * 24 * 30, '/'); // Cookie de 30 jours
            }

            // Réponse de succès
            echo json_encode(['status' => 'success', 'message' => 'Connexion réussie.']);
            exit;
        } else {
            // Mot de passe incorrect
            error_log('Mot de passe incorrect pour l\'utilisateur: ' . $email);
            echo json_encode(['status' => 'error', 'message' => 'Mot de passe incorrect.']);
            exit;
        }
    } else {
        // L'utilisateur n'existe pas
        error_log('Utilisateur non trouvé pour l\'email: ' . $email);
        echo json_encode(['status' => 'error', 'message' => 'Utilisateur non trouvé.']);
        exit;
    }
} else {
    // Paramètres manquants dans la requête
    echo json_encode(['status' => 'error', 'message' => 'Veuillez remplir tous les champs.']);
    exit;
}
