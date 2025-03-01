<?php
class TexteInspirantManager
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getTextesInspirants()
    {
        try {
            $stmt = $this->db->prepare("SELECT content, copyText FROM textes_inspirants");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ["error" => "Erreur lors de la récupération des textes inspirants: " . $e->getMessage()];
        }
    }

    public function getTexteInspirantById($id)
    {
        try {
            $stmt = $this->db->prepare("SELECT content, copyText FROM textes_inspirants WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $texte = $stmt->fetch(PDO::FETCH_ASSOC);

            return $texte ?: ["error" => "Texte inspirant non trouvé"];
        } catch (PDOException $e) {
            return ["error" => "Erreur lors de la récupération du texte inspirant: " . $e->getMessage()];
        }
    }

    public function addTexteInspirant($content, $copyText)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO textes_inspirants (content, copyText) VALUES (:content, :copyText)");
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':copyText', $copyText);
            $stmt->execute();
            return ["success" => "Texte inspirant ajouté avec succès"];
        } catch (PDOException $e) {
            return ["error" => "Erreur lors de l'ajout du texte inspirant: " . $e->getMessage()];
        }
    }
}
