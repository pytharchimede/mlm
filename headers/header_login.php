<?php
require_once 'model/Database.php';
require_once 'model/VisiteLogger.php';

$databaseObj = new Database();
$pdo = $databaseObj->getConnection();

$loggerObj = new VisiteLogger($pdo);

$loggerObj->enregistrerVisite();
