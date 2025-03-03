<?php
require_once '../model/Utilisateur.php';
require_once '../model/Pack.php';

class UtilisateurArchiver
{
    private $pdo;
    private $utilisateurObj;
    private $packObj;


    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->utilisateurObj = new Utilisateur();
        $this->packObj = new Pack($pdo);
    }

    public function archiverUtilisateursInactifs()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateur WHERE acces_admin!=1 AND date_creat_utilisateur <= NOW() - INTERVAL 3 DAY");
        $stmt->execute();
        $utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $utilisateursArchives = [];

        foreach ($utilisateurs as $user) {
            $secur = $user['secur_utilisateur'];

            // Vérifier si l'utilisateur n'a pas de pack actif
            if (!$this->packObj->isPackActive($secur)) {
                // Archiver l'utilisateur
                $this->archiverUtilisateur($user);
                $this->supprimerUtilisateur($user['id_utilisateur']);

                // Ajouter l'utilisateur archivé à la liste de retour
                $utilisateursArchives[] = [
                    'id_utilisateur' => $user['id_utilisateur'],
                    'nom_utilisateur' => $user['nom_utilisateur'],
                    'email_utilisateur' => $user['email_utilisateur']
                ];
            }
        }

        return $utilisateursArchives;
    }


    private function archiverUtilisateur($user)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO archive_utilisateur 
            (id_utilisateur, secur_utilisateur, nom_utilisateur, email_utilisateur, telephone_utilisateur, motpass_utilisateur, date_creat_utilisateur, valide_utilisateur, valide_email_utilisateur, valide_telephone_utilisateur, confirmation_token, referal_utilisateur, whatsapp_utilisateur, telegram_utilisateur, bnb_wallet_address, acces_admin, reset_token) 
            VALUES 
            (:id_utilisateur, :secur_utilisateur, :nom_utilisateur, :email_utilisateur, :telephone_utilisateur, :motpass_utilisateur, :date_creat_utilisateur, :valide_utilisateur, :valide_email_utilisateur, :valide_telephone_utilisateur, :confirmation_token, :referal_utilisateur, :whatsapp_utilisateur, :telegram_utilisateur, :bnb_wallet_address, :acces_admin, :reset_token)
        ");

        $stmt->execute([
            ':id_utilisateur' => $user['id_utilisateur'],
            ':secur_utilisateur' => $user['secur_utilisateur'],
            ':nom_utilisateur' => $user['nom_utilisateur'],
            ':email_utilisateur' => $user['email_utilisateur'],
            ':telephone_utilisateur' => $user['telephone_utilisateur'],
            ':motpass_utilisateur' => $user['motpass_utilisateur'],
            ':date_creat_utilisateur' => $user['date_creat_utilisateur'],
            ':valide_utilisateur' => $user['valide_utilisateur'],
            ':valide_email_utilisateur' => $user['valide_email_utilisateur'],
            ':valide_telephone_utilisateur' => $user['valide_telephone_utilisateur'],
            ':confirmation_token' => $user['confirmation_token'],
            ':referal_utilisateur' => $user['referal_utilisateur'],
            ':whatsapp_utilisateur' => $user['whatsapp_utilisateur'],
            ':telegram_utilisateur' => $user['telegram_utilisateur'],
            ':bnb_wallet_address' => $user['bnb_wallet_address'],
            ':acces_admin' => $user['acces_admin'],
            ':reset_token' => $user['reset_token']
        ]);
    }

    private function supprimerUtilisateur($id_utilisateur)
    {
        $stmt = $this->pdo->prepare("DELETE FROM utilisateur WHERE id_utilisateur = :id_utilisateur");
        $stmt->execute([':id_utilisateur' => $id_utilisateur]);
    }
}
