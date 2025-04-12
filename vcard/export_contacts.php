<?php
require_once '../libs/tcpdf/tcpdf.php';  // Assure-toi d'inclure la bibliothèque TCPDF

// Connexion à la base de données
require_once '../model/Database.php';
$database = new Database();
$pdo = $database->getConnection();

// Récupérer les contacts depuis la base de données
$contacts = Contact::getAll($pdo);  // Récupère tous les contacts

// Création du document PDF
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

// Titre du PDF
$pdf->Cell(0, 10, 'Liste des Contacts', 0, 1, 'C');

// Ajouter les contacts
foreach ($contacts as $contact) {
    $pdf->Cell(0, 10, $contact['name'] . ' - ' . $contact['phone'], 0, 1);
}

// Générer le PDF
$pdf->Output('contacts.pdf', 'D');  // Envoie le fichier directement au navigateur
