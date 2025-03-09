<?php
// Inclure la classe EmailLogger et établir la connexion PDO
require_once '../model/EmailLogger.php';
require_once '../model/Database.php';

$pdo = Database::getConnection();
$emailLogger = new EmailLogger($pdo);

// Récupérer les emails envoyés
$emailLogs = $emailLogger->getEmailLogs();

// Retourner les résultats au format JSON
echo json_encode($emailLogs);
