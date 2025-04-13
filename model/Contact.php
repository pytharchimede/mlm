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

    // Nouvelle méthode statique pour rechercher les contacts
    public static function getBySearch($pdo, $searchTerm)
    {
        // Utilisation de LIKE pour rechercher par nom ou téléphone
        $stmt = $pdo->prepare("SELECT * FROM contacts WHERE name LIKE :searchTerm OR phone LIKE :searchTerm");
        $searchTerm = "%" . $searchTerm . "%"; // Ajout des jokers pour la recherche partielle
        $stmt->bindParam(':searchTerm', $searchTerm);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourne les contacts correspondants
    }


    //sauvegarde du click sur un contact
    public static function saveClick($pdo, $contact_id, $ip_address, $port, $user_agent, $date)
    {
        $stmt = $pdo->prepare("INSERT INTO clicks_invitation (contact_id, ip_address, port, user_agent, click_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$contact_id, $ip_address, $port, $user_agent, $date]);
    }

    // Méthode pour mettre à jour les informations d'invitation d'un contact
    public static function updateInvitation($pdo, $contact_id, $invited_by, $invited_at)
    {
        try {
            // Préparation de la requête SQL pour mettre à jour les informations d'invitation
            $stmt = $pdo->prepare("UPDATE contacts SET invited_by = :invited_by, invited_at = :invited_at WHERE id = :contact_id");
            $stmt->bindParam(':contact_id', $contact_id, PDO::PARAM_INT);
            $stmt->bindParam(':invited_by', $invited_by);
            $stmt->bindParam(':invited_at', $invited_at);
            $stmt->execute();
            return true; // Retourne true si la mise à jour est réussie
        } catch (PDOException $e) {
            return false; // Retourne false en cas d'erreur
        }
    }

    public static function getStatistics()
    {
        $database = new Database();
        $pdo = $database->getConnection();

        // Nombre total d'invités
        $stmt = $pdo->prepare("SELECT COUNT(*) as total_invited FROM contacts WHERE invited_at IS NOT NULL");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Nombre d'invités aujourd'hui
        $stmt_today = $pdo->prepare("SELECT COUNT(*) as invited_today FROM contacts WHERE invited_at IS NOT NULL AND DATE(created_at) = CURDATE()");
        $stmt_today->execute();
        $today = $stmt_today->fetch(PDO::FETCH_ASSOC);

        // Nombre d'invités par jour de la semaine (du lundi à aujourd'hui)
        $invites_per_day = [];
        $days_of_week = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];

        // Récupérer les invitations pour chaque jour de la semaine
        foreach ($days_of_week as $index => $day) {
            $stmt_day = $pdo->prepare("SELECT COUNT(*) as day_invites FROM contacts WHERE invited_at IS NOT NULL AND DAYOFWEEK(created_at) = :day_of_week");
            $stmt_day->bindValue(':day_of_week', $index + 1, PDO::PARAM_INT); // Utilisation de bindValue() au lieu de bindParam()
            $stmt_day->execute();
            $invites_per_day[] = $stmt_day->fetch(PDO::FETCH_ASSOC)['day_invites'];
        }

        return [
            'total_invited' => $result['total_invited'],
            'invited_today' => $today['invited_today'],
            'invites_per_day' => $invites_per_day,  // Données par jour
            'labels' => $days_of_week // Labels pour le graphique
        ];
    }

    public function getAllAvailable()
    {
        $stmt = $this->pdo->query("SELECT * FROM contacts WHERE invited_by IS NULL AND buyer_id=0 ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buyContact($pdo, $contactId, $buyerId)
    {
        $stmt = $this->pdo->prepare("UPDATE contacts SET buyer_id = :buyer_id, sold_at = NOW() WHERE id = :id AND invited_by IS NULL AND buyer_id IS NULL");
        $stmt->bindParam(':buyer_id', $buyerId);
        $stmt->bindParam(':id', $contactId);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function getUserContacts($pdo, $userId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM contacts WHERE buyer_id = :user_id");
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getContact($pdo, $contactId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM contacts WHERE id = :id");
        $stmt->bindParam(':id', $contactId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
