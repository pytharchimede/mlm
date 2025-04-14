<?php
require_once '../model/Database.php';
require_once '../model/Contact.php';

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
    echo json_encode(['success' => $deleted, 'deleted' => count($ids)]);
} else {
    echo json_encode(['success' => false, 'deleted' => 0]);
}

echo json_encode(['success' => true, 'deleted' => count($ids)]);
