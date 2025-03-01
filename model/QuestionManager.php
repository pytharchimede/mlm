<?php
class QuestionManager
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getQuestionsBloquantes()
    {
        try {
            $stmt = $this->db->prepare("SELECT icon, color, title, text FROM questions_bloquantes");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ["error" => "Erreur lors de la récupération des questions: " . $e->getMessage()];
        }
    }

    public function getQuestionById($id)
    {
        try {
            $stmt = $this->db->prepare("SELECT icon, color, title, text FROM questions_bloquantes WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $question = $stmt->fetch(PDO::FETCH_ASSOC);

            return $question ?: ["error" => "Question non trouvée"];
        } catch (PDOException $e) {
            return ["error" => "Erreur lors de la récupération de la question: " . $e->getMessage()];
        }
    }

    public function addQuestion($icon, $color, $title, $text)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO questions_bloquantes (icon, color, title, text) VALUES (:icon, :color, :title, :text)");
            $stmt->bindParam(':icon', $icon);
            $stmt->bindParam(':color', $color);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':text', $text);
            $stmt->execute();
            return ["success" => "Question ajoutée avec succès"];
        } catch (PDOException $e) {
            return ["error" => "Erreur lors de l'ajout de la question: " . $e->getMessage()];
        }
    }
}
