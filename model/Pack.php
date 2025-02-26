<?php
class Pack
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Récupérer tous les packs
    public function getAllPacks()
    {
        $stmt = $this->pdo->query("SELECT * FROM packs");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer un pack par son ID
    public function getPackById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM packs WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Ajouter un nouveau pack
    public function addPack($name, $price, $rating)
    {
        $stmt = $this->pdo->prepare("INSERT INTO packs (name, price, rating) VALUES (:name, :price, :rating)");
        return $stmt->execute([
            ':name' => $name,
            ':price' => $price,
            ':rating' => $rating
        ]);
    }

    // Supprimer un pack
    public function deletePack($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM packs WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    //Souscrire à un pack
    public function subscribeToPack($abonne_secur, $pack_id, $solde, $date_souscription, $date_fin, $actif = 1)
    {
        // Préparer la requête pour insérer un abonnement dans la table pack_abonne
        $stmt = $this->pdo->prepare("INSERT INTO pack_abonne (abonne_secur, pack_id, solde, actif, date_souscription, date_fin) 
                                 VALUES (:abonne_secur, :pack_id, :solde, :actif, :date_souscription, :date_fin)");

        // Exécuter la requête avec les paramètres
        return $stmt->execute([
            ':abonne_secur' => $abonne_secur,
            ':pack_id' => $pack_id,
            ':solde' => $solde,
            ':actif' => $actif,
            ':date_souscription' => $date_souscription,
            ':date_fin' => $date_fin
        ]);
    }

    //Vérifier si l'abonné est actif
    public function isPackActive($secur)
    {
        // Préparer la requête pour vérifier si l'utilisateur a un pack actif
        $stmt = $this->pdo->prepare("SELECT * FROM pack_abonne WHERE abonne_secur = :abonne_secur AND actif = 1");
        $stmt->execute([':abonne_secur' => $secur]);

        // Si une ligne est trouvée, retourner true, sinon false
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    //Détails du pack abonné actif
    public function getPackDetails($secur)
    {
        // Préparer la requête pour récupérer les détails du pack pour un abonné sécurisé
        $stmt = $this->pdo->prepare("SELECT * FROM pack_abonne WHERE abonne_secur = :abonne_secur AND actif = 1");
        $stmt->execute([':abonne_secur' => $secur]);

        // Si un abonnement actif est trouvé, retourner les détails
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
