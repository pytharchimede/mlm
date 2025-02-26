<?php
session_start();

// Détruire toutes les variables de session
$_SESSION = [];

// Supprimer le cookie de session si existant
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Détruire complètement la session
session_destroy();

// Supprimer tous les cookies définis par le site
foreach ($_COOKIE as $key => $value) {
    setcookie($key, '', time() - 3600, "/");
}

// Redirection vers la page d'accueil
header("Location: website/index.php");
exit();
