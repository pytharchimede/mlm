<?php
class VisiteLogger
{
    private $pdo;

    // Le constructeur prend l'objet PDO directement
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function enregistrerVisite()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Inconnu';
        $urlPage = $_SERVER['REQUEST_URI'];
        $referer = $_SERVER['HTTP_REFERER'] ?? 'Direct';

        // 📌 Extraction de l'OS et du navigateur
        $os = $this->detecterOS($userAgent);
        $navigateur = $this->detecterNavigateur($userAgent);

        // 📍 Récupération de la géolocalisation via une API gratuite
        $geoData = $this->getGeolocation($ip);
        $latitude = $geoData['latitude'] ?? 'Inconnu';
        $longitude = $geoData['longitude'] ?? 'Inconnu';
        $pays = $geoData['country'] ?? 'Inconnu';
        $ville = $geoData['city'] ?? 'Inconnu';

        // 📥 Enregistrement en base
        $sql = "INSERT INTO visites (ip, user_agent, os, navigateur, latitude, longitude, pays, ville, url_page, referer) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$ip, $userAgent, $os, $navigateur, $latitude, $longitude, $pays, $ville, $urlPage, $referer]);
    }

    private function detecterOS($userAgent)
    {
        $osList = [
            'Windows' => 'Windows',
            'Mac' => 'Mac OS',
            'Linux' => 'Linux',
            'Android' => 'Android',
            'iPhone' => 'iOS'
        ];
        foreach ($osList as $key => $os) {
            if (stripos($userAgent, $key) !== false) return $os;
        }
        return 'Inconnu';
    }

    private function detecterNavigateur($userAgent)
    {
        $navigateurList = [
            'Chrome' => 'Google Chrome',
            'Firefox' => 'Mozilla Firefox',
            'Safari' => 'Safari',
            'Edge' => 'Microsoft Edge',
            'Opera' => 'Opera'
        ];
        foreach ($navigateurList as $key => $nav) {
            if (stripos($userAgent, $key) !== false) return $nav;
        }
        return 'Inconnu';
    }

    private function getGeolocation($ip)
    {
        $url = "http://ip-api.com/json/{$ip}";
        $response = file_get_contents($url);
        return json_decode($response, true) ?? [];
    }

    // Méthode pour lister toutes les visites
    public function listerVisites()
    {
        $sql = "SELECT * FROM visites ORDER BY date_visite DESC"; // Trie les visites par date décroissante
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Récupère les données sous forme de tableau associatif
    }
}
