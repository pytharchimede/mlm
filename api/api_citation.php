<?php

require_once '../model/Database.php';
require_once '../model/CitationManager.php';

header('Content-Type: application/json');

$manager = new CitationManager();

if (isset($_GET['id'])) {
    $response = ["text" => $manager->getCitationById($_GET['id'])];
} else {
    $response = ["texts" => $manager->getCitations()];
}

echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
