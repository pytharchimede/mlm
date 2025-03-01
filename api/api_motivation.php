<?php

require_once '../model/Database.php';
require_once '../model/MotivationManager.php';
header('Content-Type: application/json');

$manager = new MotivationManager();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    if (isset($data['type']) && isset($data['media']) && isset($data['alt']) && isset($data['text']) && isset($data['button_text'])) {
        $response = $manager->addMotivation($data['type'], $data['media'], $data['alt'], $data['text'], $data['button_text']);
    } else {
        $response = ["error" => "Données invalides"];
    }
} elseif (isset($_GET['id'])) {
    $response = ["motivation" => $manager->getMotivationById($_GET['id'])];
} else {
    $response = ["motivations" => $manager->getMotivations()];
}

echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
