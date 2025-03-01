<?php

class CitationManager
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getCitations()
    {
        try {
            $stmt = $this->db->prepare("SELECT content, copyText FROM citations");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ["error" => "Erreur lors de la récupération des citations: " . $e->getMessage()];
        }
    }

    public function getCitationById($id)
    {
        try {
            $stmt = $this->db->prepare("SELECT content, copyText FROM citations WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $citation = $stmt->fetch(PDO::FETCH_ASSOC);

            return $citation ?: ["error" => "Citation non trouvée"];
        } catch (PDOException $e) {
            return ["error" => "Erreur lors de la récupération de la citation: " . $e->getMessage()];
        }
    }
}
