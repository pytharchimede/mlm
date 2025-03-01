<?php
class MotivationManager
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    // Récupère tous les textes de motivation
    public function getMotivations()
    {
        try {
            $stmt = $this->db->prepare("SELECT type, media, alt, text, button_text FROM textes_motivation");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ["error" => "Erreur lors de la récupération des textes de motivation: " . $e->getMessage()];
        }
    }

    // Récupère un texte de motivation par son ID
    public function getMotivationById($id)
    {
        try {
            $stmt = $this->db->prepare("SELECT type, media, alt, text, button_text FROM textes_motivation WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $motivation = $stmt->fetch(PDO::FETCH_ASSOC);

            return $motivation ?: ["error" => "Texte de motivation non trouvé"];
        } catch (PDOException $e) {
            return ["error" => "Erreur lors de la récupération du texte de motivation: " . $e->getMessage()];
        }
    }

    // Ajoute un nouveau texte de motivation
    public function addMotivation($type, $media, $alt, $text, $buttonText)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO textes_motivation (type, media, alt, text, button_text) VALUES (:type, :media, :alt, :text, :buttonText)");
            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':media', $media);
            $stmt->bindParam(':alt', $alt);
            $stmt->bindParam(':text', $text);
            $stmt->bindParam(':buttonText', $buttonText);
            $stmt->execute();
            return ["success" => "Texte de motivation ajouté avec succès"];
        } catch (PDOException $e) {
            return ["error" => "Erreur lors de l'ajout du texte de motivation: " . $e->getMessage()];
        }
    }
}
