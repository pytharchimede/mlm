<?php
require_once 'Database.php';

class Paiement
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    // Enregistrer un paiement
    public function enregistrerPaiement($date_paiement, $montant_paiement, $pack_id, $secur_paie, $mode_paiement)
    {
        try {

            $valide_paiement = $mode_paiement == 'USDT TRC20' ? 1 : 0;
            $secur_valide = $mode_paiement == 'USDT TRC20' ? 'Robot' : '';
            $date_valide = $mode_paiement == 'USDT TRC20' ? date('Y-m-d H:i:s') : '';

            $stmt = $this->pdo->prepare("
                INSERT INTO paiement (date_paiement, montant_paiement, pack_id, secur_paie, valide_paiement, date_valide, secur_valide, secur_refuse, mode_paiement)
                VALUES (:date_paiement, :montant_paiement, :pack_id, :secur_paie, :valide_paiement, :date_valide, :secur_valide, '', :mode_paiement)
            ");

            $stmt->execute([
                ':date_paiement'   => $date_paiement,
                ':montant_paiement' => $montant_paiement,
                ':pack_id'         => $pack_id,
                ':secur_paie'      => $secur_paie,
                ':valide_paiement' => $valide_paiement,
                ':date_valide' => $date_valide,
                ':secur_valide' => $secur_valide,
                ':mode_paiement' => $mode_paiement
            ]);

            return $this->pdo->lastInsertId(); // Retourne l'ID du paiement inséré
        } catch (PDOException $e) {
            die("Erreur lors de l'enregistrement du paiement : " . $e->getMessage());
        }
    }

    // Valider un paiement
    public function validerPaiement($id_paiement, $secur_valide)
    {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE paiement 
                SET valide_paiement = 1, date_valide = NOW(), secur_valide = :secur_valide 
                WHERE id_paiement = :id_paiement
            ");

            return $stmt->execute([
                ':id_paiement'  => $id_paiement,
                ':secur_valide' => $secur_valide
            ]);
        } catch (PDOException $e) {
            die("Erreur lors de la validation du paiement : " . $e->getMessage());
        }
    }

    // Refuser un paiement
    public function refuserPaiement($id_paiement, $secur_refuse)
    {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE paiement 
                SET valide_paiement = -1, secur_refuse = :secur_refuse 
                WHERE id_paiement = :id_paiement
            ");

            return $stmt->execute([
                ':id_paiement'  => $id_paiement,
                ':secur_refuse' => $secur_refuse
            ]);
        } catch (PDOException $e) {
            die("Erreur lors du refus du paiement : " . $e->getMessage());
        }
    }

    // Récupérer un paiement par ID
    public function getPaiementById($id_paiement)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM paiement WHERE id_paiement = :id_paiement");
        $stmt->execute([':id_paiement' => $id_paiement]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lister tous les paiements
    public function getAllPaiements()
    {
        $stmt = $this->pdo->query("SELECT * FROM paiement ORDER BY date_paiement DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lister les paiements d'un utilisateur spécifique
    public function getPaiementsByUtilisateur($secur_paie)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM paiement WHERE secur_paie = :secur_paie ORDER BY date_paiement DESC");
        $stmt->execute([':secur_paie' => $secur_paie]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
