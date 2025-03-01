<?php
// Vérifier si l'utilisateur est connecté, sinon le déconnecter
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}
