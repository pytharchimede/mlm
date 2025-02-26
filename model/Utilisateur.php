<?php
require_once 'Database.php';

class Utilisateur
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    // Enregistrer un nouvel utilisateur
    public function register($nom_utilisateur, $email_utilisateur, $telephone_utilisateur, $motpass_utilisateur, $referal_utilisateur)
    {
        try {
            // Hacher le mot de passe
            $hashed_password = password_hash($motpass_utilisateur, PASSWORD_BCRYPT);

            // Générer un code unique pour le champ secur_utilisateur
            $secur_utilisateur = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, 5);

            // Préparer la requête pour l'insertion de l'utilisateur
            $stmt = $this->pdo->prepare('
                INSERT INTO utilisateur 
                    (nom_utilisateur, email_utilisateur, telephone_utilisateur, motpass_utilisateur, referal_utilisateur, secur_utilisateur, date_creat_utilisateur, valide_utilisateur, valide_email_utilisateur, valide_telephone_utilisateur)
                VALUES 
                    (:nom_utilisateur, :email_utilisateur, :telephone_utilisateur, :motpass_utilisateur, :referal_utilisateur, :secur_utilisateur, NOW(), 0, 0, 0)
            ');

            // Exécuter la requête avec les valeurs appropriées
            $stmt->execute([
                ':nom_utilisateur' => $nom_utilisateur,
                ':email_utilisateur' => $email_utilisateur,
                ':telephone_utilisateur' => $telephone_utilisateur,
                ':motpass_utilisateur' => $hashed_password,
                ':referal_utilisateur' => $referal_utilisateur,
                ':secur_utilisateur' => $secur_utilisateur,
            ]);

            return true;  // Retourner true si l'inscription réussit
        } catch (PDOException $e) {
            die('Error registering user: ' . $e->getMessage());
        }
    }


    // Vérifier si l'email existe déjà
    public function checkEmailExists($email_utilisateur)
    {
        $stmt = $this->pdo->prepare('SELECT id_utilisateur FROM utilisateur WHERE email_utilisateur = :email_utilisateur');
        $stmt->execute([':email_utilisateur' => $email_utilisateur]);

        return $stmt->fetchColumn();
    }

    // Vérifier si le numéro de téléphone existe déjà
    public function checkPhoneExists($telephone_utilisateur)
    {
        $stmt = $this->pdo->prepare('SELECT id_utilisateur FROM utilisateur WHERE telephone_utilisateur = :telephone_utilisateur');
        $stmt->execute([':telephone_utilisateur' => $telephone_utilisateur]);

        return $stmt->fetchColumn();
    }

    // Valider l'email de l'utilisateur
    public function validateEmail($email_utilisateur)
    {
        $stmt = $this->pdo->prepare('UPDATE utilisateur SET valide_email_utilisateur = 1 WHERE email_utilisateur = :email_utilisateur');
        return $stmt->execute([':email_utilisateur' => $email_utilisateur]);
    }

    // Valider le téléphone de l'utilisateur
    public function validatePhone($telephone_utilisateur)
    {
        $stmt = $this->pdo->prepare('UPDATE utilisateur SET valide_telephone_utilisateur = 1 WHERE telephone_utilisateur = :telephone_utilisateur');
        return $stmt->execute([':telephone_utilisateur' => $telephone_utilisateur]);
    }

    // Vérifier si le mot de passe correspond à l'utilisateur
    public function verifyPassword($email_utilisateur, $password)
    {
        $stmt = $this->pdo->prepare('SELECT motpass_utilisateur FROM utilisateur WHERE email_utilisateur = :email_utilisateur');
        $stmt->execute([':email_utilisateur' => $email_utilisateur]);

        $hashed_password = $stmt->fetchColumn();
        return password_verify($password, $hashed_password);
    }

    // Récupérer les informations de l'utilisateur par l'email
    public function getUserByEmail($email_utilisateur)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM utilisateur WHERE email_utilisateur = :email_utilisateur');
        $stmt->execute([':email_utilisateur' => $email_utilisateur]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupérer les informations de l'utilisateur par l'email
    public function getUserById($id_utilisateur)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM utilisateur WHERE id_utilisateur = :id_utilisateur');
        $stmt->execute([':id_utilisateur' => $id_utilisateur]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Activer un utilisateur (valider l'inscription)
    public function activateUser($email_utilisateur)
    {
        $stmt = $this->pdo->prepare('UPDATE utilisateur SET valide_utilisateur = 1, valide_email_utilisateur = 1 WHERE email_utilisateur = :email_utilisateur');
        return $stmt->execute([':email_utilisateur' => $email_utilisateur]);
    }

    // Mettre à jour le jeton de confirmation pour un utilisateur
    public function updateConfirmationToken($email_utilisateur, $token)
    {
        $stmt = $this->pdo->prepare('UPDATE utilisateur SET confirmation_token = :token WHERE email_utilisateur = :email_utilisateur');
        return $stmt->execute([':token' => $token, ':email_utilisateur' => $email_utilisateur]);
    }
}
