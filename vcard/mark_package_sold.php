<?php
require_once '../model/Database.php';
require_once '../model/Contact.php';

header('Content-Type: application/json');

if (!isset($_POST['pack'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Package ID manquant']);
    exit;
}

$pack = (int)$_POST['pack'];
$limit = 30;
$offset = ($pack - 1) * $limit;

$databaseObj = new Database();
$pdo = $databaseObj->getConnection();

$contactObj = new Contact($pdo);
$contacts = $contactObj->getAllAvailableWithLimit($offset, $limit);
$ids = array_column($contacts, 'id');

if (!empty($ids)) {
    $deleted = $contactObj->deleteByIds($ids);

    // Enregistrement de la vente du package
    $contactObj->registerPackageSale($pack, count($ids));

    echo json_encode([
        'success' => $deleted,
        'deleted' => count($ids),
        'message' => "Package #$pack supprimé et enregistré comme vendu"
    ]);
} else {
    echo json_encode([
        'success' => false,
        'deleted' => 0,
        'message' => "Aucun contact trouvé pour le package #$pack"
    ]);
}
