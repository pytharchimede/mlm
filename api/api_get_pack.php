<?php
// Définir l'en-tête pour la réponse JSON
header('Content-Type: application/json');

// Inclure les classes nécessaires
require_once '../model/Pack.php';
require_once '../model/Database.php';

// Connexion à la base de données
$pdo = Database::getConnection();

// Créer une instance de Pack
$pack = new Pack($pdo);

// Récupérer tous les packs
$packs = $pack->getAllPacks();

// Retourner la réponse en JSON
echo json_encode($packs);
