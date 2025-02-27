<?php
class DemandeRetrait
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Récupérer toutes les demandes de retrait
    public function getAllDemandes()
    {
        $stmt = $this->pdo->query("SELECT * FROM demande_retrait");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer une demande de retrait par son ID
    public function getDemandeById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM demande_retrait WHERE id_demande_retrait = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Ajouter une demande de retrait
    public function addDemande($pack_abonne_id, $montant_demande_retrait, $statut_demande_retrait, $commentaire_demande_retrait)
    {
        $stmt = $this->pdo->prepare("INSERT INTO demande_retrait (pack_abonne_id, montant_demande_retrait, statut_demande_retrait, commentaire_demande_retrait) 
                                     VALUES (:pack_abonne_id, :montant_demande_retrait, :statut_demande_retrait, :commentaire_demande_retrait)");

        return $stmt->execute([
            ':pack_abonne_id' => $pack_abonne_id,
            ':montant_demande_retrait' => $montant_demande_retrait,
            ':statut_demande_retrait' => $statut_demande_retrait,
            ':commentaire_demande_retrait' => $commentaire_demande_retrait
        ]);
    }

    // Mettre à jour une demande de retrait (par exemple, changer son statut ou ajouter une date de traitement)
    public function updateDemande($id, $statut, $date_traitement = null)
    {
        $stmt = $this->pdo->prepare("UPDATE demande_retrait 
                                     SET statut_demande_retrait = :statut, date_traitement_demande_retrait = :date_traitement 
                                     WHERE id_demande_retrait = :id");

        return $stmt->execute([
            ':id' => $id,
            ':statut' => $statut,
            ':date_traitement' => $date_traitement
        ]);
    }

    // Supprimer une demande de retrait
    public function deleteDemande($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM demande_retrait WHERE id_demande_retrait = :id");
        return $stmt->execute([':id' => $id]);
    }

    // Récupérer les demandes de retrait pour un abonné spécifique
    public function getDemandesByAbonne($pack_abonne_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM demande_retrait WHERE pack_abonne_id = :pack_abonne_id");
        $stmt->execute([':pack_abonne_id' => $pack_abonne_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
