<?php
require_once '../model/Database.php';
require_once '../model/Utilisateur.php';
require_once '../model/Contact.php';

//Instanciation de la bdd
$databaseObj = new Database();
$pdo = $databaseObj->getConnection();

//instanciation de la class Utilisateur 
$utilisateurObj = new Utilisateur();

//Instanciation de la class Contact
$contactObj = new Contact($pdo);

//Récupérer la liste des contacts pas encore vendus
$contactsDispos = $contactObj->getAllAvailableWithLimit(0, 50);


// var_dump($listeContactsDispos);
