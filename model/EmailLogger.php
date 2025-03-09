<?php
require_once 'Database.php'; // Assurez-vous que Database.php est bien inclus pour la connexion à la base de données.

class EmailLogger
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Enregistrer un email dans la base de données
    public function logEmail($subject, $body, $recipientEmail, $recipientName)
    {
        $stmt = $this->pdo->prepare("INSERT INTO email_logs (email_subject, email_body, recipient_email, recipient_name) 
                                     VALUES (:subject, :body, :recipientEmail, :recipientName)");
        $stmt->execute([
            ':subject' => $subject,
            ':body' => $body,
            ':recipientEmail' => $recipientEmail,
            ':recipientName' => $recipientName
        ]);
    }

    // Lister les emails envoyés
    public function getEmailLogs()
    {
        $stmt = $this->pdo->query("SELECT email_subject, email_body, recipient_email, recipient_name, sent_at FROM email_logs ORDER BY sent_at DESC");

        // Récupérer tous les résultats sous forme de tableau associatif
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
