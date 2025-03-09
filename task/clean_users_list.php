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

    // Style pour les mails
    $buttonStyle = "<style>
        .button {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
            border: none;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>";

    // 1️⃣ Rappel après 24h
    $users24h = $utilisateurObj->getUsersAfter24h();
    foreach ($users24h as $user) {
        $isActif = $packObj->isPackActive($user['secur_utilisateur']);
        if (!$isActif) {
            $emailContent = "
            <html>
            <head>$buttonStyle</head>
            <body>
                <p>Bonjour {$user['nom_utilisateur']},</p>
                <p>Vous n'avez pas encore activé votre compte. Vous pouvez le faire en contactant la CMDB.</p>
                <p><a href='https://comodubo.com/' class='button'>Activer mon compte</a></p>
                <p>Cordialement,<br>L'équipe CMDB</p>
            </body>
            </html>";

            $emailManager->sendEmail(
                "Rappel : Activez votre compte",
                $emailContent,
                [$user['email_utilisateur'] => $user['nom_utilisateur']]
            );
            $emailLogger->logEmail("Rappel : Activez votre compte", $emailContent, $user['email_utilisateur'], $user['nom_utilisateur']);
        }
    }

    // 2️⃣ Dernier avertissement après 48h
    $users48h = $utilisateurObj->getUsersAfter48h();
    foreach ($users48h as $user) {
        $isActif = $packObj->isPackActive($user['secur_utilisateur']);
        if (!$isActif) {
            $emailContent = "
            <html>
            <head>$buttonStyle</head>
            <body>
                <p>Bonjour {$user['nom_utilisateur']},</p>
                <p>Il vous reste 24h pour activer votre compte, sans quoi il sera supprimé.</p>
                <p>Contactez la CMDB maintenant !</p>
                <p><a href='https://comodubo.com/' class='button'>Activer mon compte</a></p>
                <p>Cordialement,<br>L'équipe CMDB</p>
            </body>
            </html>";

            $emailManager->sendEmail(
                "⚠️ Dernier rappel : Activation de votre compte",
                $emailContent,
                [$user['email_utilisateur'] => $user['nom_utilisateur']]
            );
            $emailLogger->logEmail("⚠️ Dernier rappel : Activation de votre compte", $emailContent, $user['email_utilisateur'], $user['nom_utilisateur']);
        }
    }

    // 3️⃣ Suppression après 72h + Email de notification
    $users72h = $utilisateurObj->getUsersAfter72h();
    foreach ($users72h as $user) {
        $isActif = $packObj->isPackActive($user['secur_utilisateur']);
        if (!$isActif) {

            //Archiver l'utilisateur
            $utilisateurObj->archiverUtilisateur($user);
            // Supprimer l'utilisateur
            $utilisateurObj->deleteUser($user['id_utilisateur']);
            // Envoyer un email de suppression
            $emailContent = "
            <html>
            <head>$buttonStyle</head>
            <body>
                <p>Bonjour {$user['nom_utilisateur']},</p>
                <p>Votre compte a été supprimé car vous ne l'avez pas activé sous 72h.</p>
                <p>Vous pouvez revenir à tout moment en cliquant sur <a href='https://comodubo.com#inscription' class='button'>S'inscrire à nouveau</a>.</p>
                <p>Cordialement,<br>L'équipe CMDB</p>
            </body>
            </html>";

            $emailManager->sendEmail(
                "Compte supprimé ❌",
                $emailContent,
                [$user['email_utilisateur'] => $user['nom_utilisateur']]
            );
            $emailLogger->logEmail("Compte supprimé ❌", $emailContent, $user['email_utilisateur'], $user['nom_utilisateur']);
        }
    }

    echo json_encode(['success' => true, 'message' => 'Vérification et traitement terminés.']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur : ' . $e->getMessage()]);
}
