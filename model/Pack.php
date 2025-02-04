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
}
