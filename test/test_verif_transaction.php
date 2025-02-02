<?php

require_once '../model/CryptoPayment.php';
require_once '../model/Config.php';

// Instanciation de la classe CryptoPayment
$cryptoPayment = new CryptoPayment("", "", ""); // Pas besoin des API keys NOWPayments ici

// 🔹 Hash de transaction TRC20 à vérifier
$txid = "a2c86aec44673a3282f9dbc12902aa4acb5ae5bb2cf6fec460bf9bfd7d3724e1";

// 🔹 Vérification de la transaction TRC20
$result = $cryptoPayment->verifyTrc20Transaction($txid);

// 🔹 Affichage des résultats sous forme lisible
echo "<pre>";
print_r($result);
echo "</pre>";
