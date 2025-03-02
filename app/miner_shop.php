<?php
include '../headers/header_miner_shop.php';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adhésion CMDB - Paiement Crypto</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <link rel="stylesheet" href="../css/style_miner_shop.css">
</head>

<body class="bg-gray-900 text-white">
    <header class="flex justify-between items-center p-4 bg-gray-800 shadow-lg">
        <a href="dashboard.php">
            <img src="../assets/img/logo.png" alt="Logo" class="h-10">
        </a>
        <!-- <div class="flex space-x-4">
            <a href="https://wa.me/123456789" target="_blank" class="text-green-400 text-2xl">
                <i class="fab fa-whatsapp"></i>
            </a>
            <a href="https://t.me/yourusername" target="_blank" class="text-blue-400 text-2xl">
                <i class="fab fa-telegram"></i>
            </a>
        </div> -->
    </header>

    <div class="container mx-auto p-6">
        <h1 class="text-center text-3xl font-bold mb-6">Adhésion à CMDB</h1>
        <div id="error-message" class="text-red-400 text-center"></div>
        <div id="success-message" class="text-green-400 text-center hidden"></div>

        <!-- Montant fixe -->
        <div class="bg-gray-800 p-6 rounded-lg text-center mb-6">
            <p class="text-lg">Montant unique d'adhésion</p>
            <p class="text-3xl font-bold text-yellow-400">15$ soit <span id="bnb-equivalent">...</span></p>
        </div>


        <!-- Informations de paiement -->
        <div id="payment-info" class="text-center">
            <h2 class="text-2xl font-semibold mb-4">Effectuez votre paiement</h2>

            <p class="text-center">
                Envoyez le montant unique d'adhésion à l'adresse suivante :
            </p>


            <div class="flex items-center justify-center space-x-2 mt-2">
                <p class="text-yellow-400 font-mono text-lg break-all" id="payment-address">
                    0x1a071a31FeEcdF08AF50098C9fe03494EB23C8c6
                </p>
                <button class="bg-yellow-400 text-gray-900 px-2 py-1 rounded-lg text-sm font-semibold hover:bg-yellow-500 transition" onclick="copyAddress()">
                    <i class="fas fa-copy"></i>
                </button>
            </div>

            <!-- QR Code -->
            <div class="mt-6">
                <p class="text-lg font-semibold">Ou scannez ce QR Code :</p>
                <div id="qrcode" class="flex justify-center mt-3"></div>
            </div>

            <button class="mt-6 px-6 py-2 border border-yellow-400 text-yellow-400 rounded-lg text-lg font-semibold hover:bg-yellow-400 hover:text-gray-900 transition" onclick="window.location.href='verif_payment.php'">
                J'ai payé
            </button>
        </div>
    </div>

    <script>
        // Copier l'adresse dans le presse-papier
        function copyAddress() {
            const address = document.getElementById("payment-address").innerText;
            navigator.clipboard.writeText(address).then(() => {
                alert("Adresse copiée !");
            }).catch(err => {
                console.error("Erreur de copie : ", err);
            });
        }

        // Générer le QR Code
        new QRCode(document.getElementById("qrcode"), {
            text: "0x1a071a31FeEcdF08AF50098C9fe03494EB23C8c6",
            width: 150,
            height: 150
        });

        function updateBNBPrice() {
            fetch('https://api.coingecko.com/api/v3/simple/price?ids=binancecoin&vs_currencies=usd')
                .then(response => response.json())
                .then(data => {
                    let bnbPrice = data.binancecoin.usd; // Prix de 1 BNB en USD
                    let equivalentBNB = (15 / bnbPrice).toFixed(3); // Calcul de 15$ en BNB

                    // Mise à jour de l'affichage
                    document.getElementById("bnb-equivalent").innerText = equivalentBNB + " BNB";
                    console.log("Prix BNB mis à jour 15$ = " + equivalentBNB + " BNB");

                })
                .catch(error => console.error("Erreur lors de la récupération du prix BNB:", error));
        }

        // Actualiser le prix toutes les 60 secondes
        setInterval(updateBNBPrice, 30000);

        // Charger le prix immédiatement au chargement de la page
        updateBNBPrice();
    </script>

</body>

</html>