<?php

require_once '../model/Database.php';
require_once '../model/TemoignageManager.php';
header('Content-Type: application/json');

$manager = new TemoignageManager();

// Gestion des requêtes API
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    if (isset($data['content']) && isset($data['author'])) {
        $response = $manager->addTemoignage($data['content'], $data['author']);
    } else {
        $response = ["error" => "Données invalides"];
    }
} elseif (isset($_GET['id'])) {
    $response = ["temoignage" => $manager->getTemoignageById($_GET['id'])];
} else {
    $response = ["temoignages" => $manager->getTemoignages()];
}

echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
