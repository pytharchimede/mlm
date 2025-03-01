<?php
require_once 'Database.php';
require_once 'Pack.php';

class Utilisateur
{
    private $pdo;
    private $packObj;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
        $this->packObj = new Pack($this->pdo);
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

    // Récupérer les informations de l'utilisateur par id
    public function getUserById($id_utilisateur)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM utilisateur WHERE id_utilisateur = :id_utilisateur');
        $stmt->execute([':id_utilisateur' => $id_utilisateur]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupérer les informations de l'utilisateur par secur
    public function getUserBySecur($secur_utilisateur)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM utilisateur WHERE secur_utilisateur = :secur_utilisateur');
        $stmt->execute([':secur_utilisateur' => $secur_utilisateur]);

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

    // Mettre à jour ladresse du wallet BNB
    public function updateBnbWalletAdress($user_secur, $new_address)
    {
        $stmt = $this->pdo->prepare('UPDATE utilisateur SET bnb_wallet_address = :new_address WHERE secur_utilisateur = :user_secur');
        return $stmt->execute([':new_address' => $new_address, ':user_secur' => $user_secur]);
    }

    // Vérifier si l'utilisateur a déjà une adresse de portefeuille BNB
    public function checkWalletAddress($user_secur)
    {
        // Préparer la requête SQL pour récupérer l'adresse BNB de l'utilisateur
        $stmt = $this->pdo->prepare('SELECT bnb_wallet_address FROM utilisateur WHERE secur_utilisateur = :user_secur');
        $stmt->execute([':user_secur' => $user_secur]);

        // Récupérer le résultat
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si l'adresse existe et n'est pas vide, retourner vrai
        return !empty($result['bnb_wallet_address']);
    }

    // Récupérer l'adresse du portefeuille BNB de l'utilisateur par sécur
    public function getWalletAddress($secur_utilisateur)
    {
        $stmt = $this->pdo->prepare('SELECT bnb_wallet_address FROM utilisateur WHERE secur_utilisateur = :secur_utilisateur');
        $stmt->execute([':secur_utilisateur' => $secur_utilisateur]);

        // Récupérer l'adresse si elle existe
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si l'adresse existe, la retourner, sinon retourner null
        return $result ? $result['bnb_wallet_address'] : null;
    }



    // Récupérer la liste des filleuls d'un utilisateur
    public function getFilleulsByReferal($referal_utilisateur)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM utilisateur WHERE referal_utilisateur = :referal_utilisateur');
        $stmt->execute([':referal_utilisateur' => $referal_utilisateur]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer le nombre de filleuls d'un utilisateur
    public function countFilleulsByReferal($referal_utilisateur)
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM utilisateur WHERE referal_utilisateur = :referal_utilisateur');
        $stmt->execute([':referal_utilisateur' => $referal_utilisateur]);

        return $stmt->fetchColumn(); // Retourne le nombre de filleuls
    }


    public function getActifsFilleulsByReferal($referal_utilisateur)
    {
        // Vérification du type de donnée
        if (!is_scalar($referal_utilisateur)) {
            error_log("Erreur: referal_utilisateur est un tableau au lieu d'une valeur unique: " . print_r($referal_utilisateur, true));
            return [];
        }

        $stmt = $this->pdo->prepare(
            'SELECT utilisateur.* 
            FROM utilisateur 
            LEFT JOIN pack_abonne ON utilisateur.secur_utilisateur = pack_abonne.abonne_secur 
            WHERE referal_utilisateur = :referal_utilisateur AND actif = 1'
        );

        $stmt->execute([':referal_utilisateur' => $referal_utilisateur]);
        $filleuls = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Supprimer les doublons basés sur l'id_utilisateur
        $uniqueFilleuls = [];
        foreach ($filleuls as $filleul) {
            $uniqueFilleuls[$filleul['id_utilisateur']] = $filleul;
        }

        return array_values($uniqueFilleuls);
    }



    public function mettreAJourSolde($secur_utilisateur)
    {
        $filleuls = [$secur_utilisateur]; // Commencer avec l'utilisateur lui-même
        $niveauParrain = 0;
        $soldeAdittionnel = 0;

        // Tableau des gains par niveau
        $gains_par_niveau = [
            1 => 25,
            2 => 100,
            3 => 500,
            4 => 3000,
            5 => 30000
        ];

        for ($niveau = 1; $niveau <= 5; $niveau++) {
            $nouveaux_filleuls = [];

            foreach ($filleuls as $filleul) {
                if (!is_scalar($filleul)) {
                    error_log("Erreur: Filleul est un tableau au lieu d'une valeur unique: " . print_r($filleul, true));
                    continue; // On ignore ce filleul
                }

                $filleuls_niveau_suivant = $this->getActifsFilleulsByReferal($filleul);

                // Vérifier si le nombre de filleuls est suffisant pour passer au niveau suivant
                if (count($filleuls_niveau_suivant) < 5) {
                    break 2; // On arrête si les conditions ne sont pas remplies
                }

                // Ajouter les filleuls trouvés pour le prochain niveau
                $nouveaux_filleuls = array_merge($nouveaux_filleuls, array_column($filleuls_niveau_suivant, 'secur_utilisateur'));
            }

            // Si le niveau est validé, on l'incrémente et on ajoute les gains correspondants
            $niveauParrain++;
            $soldeAdittionnel += $gains_par_niveau[$niveauParrain];
            $filleuls = $nouveaux_filleuls;
        }

        // Vérifier que les détails du pack existent
        $detailCompteParrain = $this->packObj->getPackDetails($secur_utilisateur);
        if (!$detailCompteParrain) {
            error_log("Erreur: Impossible de récupérer les détails du pack pour l'utilisateur " . $secur_utilisateur);
            return false;
        }

        // Calcul du nouveau solde
        $soldeParrain = $detailCompteParrain['solde'];
        $solde_total = $soldeParrain + $soldeAdittionnel;

        error_log("Mise à jour du solde pour $secur_utilisateur : Nouveau solde = $solde_total");

        // Mise à jour du solde
        return $this->packObj->updatePackBalance($secur_utilisateur, $detailCompteParrain['id_pack_abonne'], $solde_total);
    }
}
