<?php
// ../model/Contact.php
class Contact
{
    private $pdo;
    private $name;
    private $phone;

    // Constructeur qui prend un objet PDO pour la connexion à la base de données
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Setters pour le nom et le téléphone
    public function setName($name)
    {
        $this->name = $name;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    // Vérifier si le contact existe déjà
    public function exists()
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM contacts WHERE phone = :phone");
        $stmt->bindParam(':phone', $this->phone);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Méthode pour sauvegarder le contact dans la base de données
    public function save()
    {

        // Vérifier si le contact existe déjà
        if ($this->exists()) {
            return false; // Le contact existe déjà, ne pas l'ajouter
        }

        try {
            $stmt = $this->pdo->prepare("INSERT INTO contacts (name, phone) VALUES (:name, :phone)");
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':phone', $this->phone);
            $stmt->execute();
            return true;  // Retourne vrai si l'enregistrement réussit
        } catch (PDOException $e) {
            return false; // Retourne faux en cas d'erreur
        }
    }

    // Méthode statique pour récupérer tous les contacts
    public static function getAll($pdo)
    {
        $stmt = $pdo->query("SELECT * FROM contacts");
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Récupère tous les contacts
    }

    // Méthode statique pour récupérer un contact par son téléphone (si besoin)
    public static function getByPhone($pdo, $phone)
    {
        $stmt = $pdo->prepare("SELECT * FROM contacts WHERE phone = :phone");
        $stmt->bindParam(':phone', $phone);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Récupère un contact par son numéro de téléphone
    }
}
