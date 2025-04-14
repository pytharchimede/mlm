<?php
require_once '../model/Database.php';
require_once '../model/Contact.php';

$databaseObj = new Database();
$pdo = $databaseObj->getConnection();

$pack = isset($_GET['pack']) ? (int)$_GET['pack'] : 1;
$limit = 30;
$offset = ($pack - 1) * $limit;

$contactModel = new Contact($pdo);
$contacts = $contactModel->getAllAvailableWithLimit($offset, $limit);

// Définir l'en-tête pour le téléchargement
header('Content-Type: text/vcard; charset=utf-8');
header('Content-Disposition: attachment; filename="package_' . $pack . '.vcf"');

foreach ($contacts as $contact) {
    $name = htmlspecialchars($contact['name']);
    $phone = preg_replace('/[^0-9+]/', '', $contact['phone']); // Nettoyer numéro

    echo "BEGIN:VCARD\n";
    echo "VERSION:3.0\n";
    echo "FN:$name\n";
    echo "TEL;TYPE=CELL;TYPE=VOICE;waid=$phone:$phone\n";
    echo "END:VCARD\n";
}
exit;
