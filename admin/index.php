<?php
// Vérifie si la connexion n'est pas en HTTPS
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    $https_url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location: $https_url", true, 301);
    exit();
}

// Redirection vers la page souhaitée
header('Location: dashboard.php');
exit();
