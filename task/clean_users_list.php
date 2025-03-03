<?php
require_once '../model/Database.php';
require_once '../model/EmailManager.php'; // On utilise ta classe pour envoyer les mails
require_once '../model/Pack.php';
require_once '../model/Utilisateur.php';
require_once '../model/EmailLogger.php';


try {
    $databaseObj = new Database();
    $pdo = $databaseObj->getConnection();
    $emailManager = new EmailManager();
    $utilisateurObj = new Utilisateur();
    $packObj = new Pack($pdo);
    $emailLogger = new EmailLogger($pdo);


    // 1️⃣ Rappel après 24h
    $users24h = $utilisateurObj->getUsersAfter24h();

    foreach ($users24h as $user) {
        // Vérifier si l'utilisateur a un pack actif
        $isActif = $packObj->isPackActive($user['secur_utilisateur']);
        if (!$isActif) {
            $emailManager->sendEmail(
                "Rappel : Activez votre compte",
                "Bonjour {$user['nom_utilisateur']},<br><br>
                Vous n'avez pas encore activé votre compte. Vous pouvez le faire en contactant la CMDB.<br>https://comodubo.com/<br><br>
                Cordialement,<br>L'équipe CMDB.",
                [$user['email_utilisateur'] => $user['nom_utilisateur']]
            );
            $emailLogger->logEmail($subject, $body, $user['email_utilisateur'], $user['nom_utilisateur']);
        }
    }

    // 2️⃣ Dernier avertissement après 48h
    $users48h = $utilisateurObj->getUsersAfter48h();

    foreach ($users48h as $user) {
        $isActif = $packObj->isPackActive($user['secur_utilisateur']);
        if (!$isActif) {
            $emailManager->sendEmail(
                "⚠️ Dernier rappel : Activation de votre compte",
                "Bonjour {$user['nom_utilisateur']},<br><br>
                Il vous reste 24h pour activer votre compte, sans quoi il sera supprimé.<br><br>
                Contactez la CMDB maintenant ! <br>https://comodubo.com/<br><br>
                Cordialement,<br>L'équipe CMDB.",
                [$user['email_utilisateur'] => $user['nom_utilisateur']]
            );
            $emailLogger->logEmail($subject, $body, $user['email_utilisateur'], $user['nom_utilisateur']);
        }
    }

    // 3️⃣ Suppression après 72h + Email de notification
    $users72h = $utilisateurObj->getUsersAfter72h();

    foreach ($users72h as $user) {
        $isActif = $packObj->isPackActive($user['secur_utilisateur']);
        if (!$isActif) {
            // Supprimer l'utilisateur
            $utilisateurObj->deleteUser($user['id_utilisateur']);
            // Envoyer un email de suppression
            $emailManager->sendEmail(
                "Compte supprimé ❌",
                "Bonjour {$user['nom_utilisateur']},<br><br>
                Votre compte a été supprimé car vous ne l'avez pas activé sous 72h.<br><br>
                Vous pouvez revenir à tout moment en cliquant sur <a href='https://comodubo.com#inscription'>ce lien</a>.<br><br>
                Cordialement,<br>L'équipe CMDB.",
                [$user['email_utilisateur'] => $user['nom_utilisateur']]
            );
            $emailLogger->logEmail($subject, $body, $user['email_utilisateur'], $user['nom_utilisateur']);
        }
    }


    //Test envoie mail
    // $emailManager->sendEmail(
    //     "Rappel : Activez votre compte",
    //     "Bonjour {$user['nom_utilisateur']},<br><br>
    //     Vous n'avez pas encore activé votre compte. Vous pouvez le faire en contactant la CMDB.<br>https://comodubo.com/<br><br>
    //     Cordialement,<br>L'équipe CMDB.",
    //     [
    //         'amani_ulrich@outlook.fr' => 'Amani Ulrich',
    //         'pytharchimede1st@gmail.com' => 'Serge KANA',
    //         'gemecdiane84@gmail.com' => 'Diane Gémé'
    //     ]
    // );


    echo json_encode(['success' => true, 'message' => 'Vérification et traitement terminés.']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur : ' . $e->getMessage()]);
}
