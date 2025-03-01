<?php

require_once '../model/Database.php';
require_once '../model/QuestionManager.php';

header('Content-Type: application/json');

$manager = new QuestionManager();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    if (isset($data['icon']) && isset($data['color']) && isset($data['title']) && isset($data['text'])) {
        $response = $manager->addQuestion($data['icon'], $data['color'], $data['title'], $data['text']);
    } else {
        $response = ["error" => "Données invalides"];
    }
} elseif (isset($_GET['id'])) {
    $response = ["question" => $manager->getQuestionById($_GET['id'])];
} else {
    $response = ["questions" => $manager->getQuestionsBloquantes()];
}

echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
