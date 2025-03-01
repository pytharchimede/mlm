<?php

require_once '../model/Database.php';
require_once '../model/TexteInspirantManager.php';
header('Content-Type: application/json');


$manager = new TexteInspirantManager();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    if (isset($data['content']) && isset($data['copyText'])) {
        $response = $manager->addTexteInspirant($data['content'], $data['copyText']);
    } else {
        $response = ["error" => "Données invalides"];
    }
} elseif (isset($_GET['id'])) {
    $response = ["text" => $manager->getTexteInspirantById($_GET['id'])];
} else {
    $response = ["texts" => $manager->getTextesInspirants()];
}

echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
