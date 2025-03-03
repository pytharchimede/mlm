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
}
