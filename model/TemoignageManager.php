<?php
class TemoignageManager
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    // Récupérer tous les témoignages
    public function getTemoignages()
    {
        try {
            $stmt = $this->db->prepare("SELECT content, author FROM temoignages");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ["error" => "Erreur lors de la récupération des témoignages: " . $e->getMessage()];
        }
    }

    // Récupérer un témoignage spécifique par ID
    public function getTemoignageById($id)
    {
        try {
            $stmt = $this->db->prepare("SELECT content, author FROM temoignages WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $temoignage = $stmt->fetch(PDO::FETCH_ASSOC);

            return $temoignage ?: ["error" => "Témoignage non trouvé"];
        } catch (PDOException $e) {
            return ["error" => "Erreur lors de la récupération du témoignage: " . $e->getMessage()];
        }
    }

    // Ajouter un témoignage
    public function addTemoignage($content, $author)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO temoignages (content, author) VALUES (:content, :author)");
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':author', $author);
            $stmt->execute();
            return ["success" => "Témoignage ajouté avec succès"];
        } catch (PDOException $e) {
            return ["error" => "Erreur lors de l'ajout du témoignage: " . $e->getMessage()];
        }
    }
}
