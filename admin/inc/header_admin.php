<?php

// Vérifier si l'utilisateur est connecté et que la valeur de acces_admin est égale à 1
session_start();
if (!isset($_SESSION['acces_admin']) || $_SESSION['acces_admin'] != 1) {
    header("Location: ../app/dashboard.php");
    exit;
}
