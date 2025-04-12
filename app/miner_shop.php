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

        <h1 class="text-2xl font-semibold mt-6 text-center">Choisissez votre mode de paiement :</h1>

        <!-- Informations de paiement -->
        <div id="payment-info" class="text-center">

            <!-- Paiement Mobile Money -->
            <h2 class="text-2xl font-semibold mb-4">Paiement en Mobile Money</h2>

            <p class="text-3xl font-bold text-yellow-400">Montant à envoyer : 15$ soit <span id="xaf-equivalent">...</span></p>

            <div class="flex justify-center space-x-6 mt-4">
                <div class="text-center">
                    <img src="../assets/icon/payment/logo_om.png" alt="Orange Money" class="h-20 w-20 rounded-full mx-auto">
                    <p class="mt-2">+237659248084</p>
                    <a href="https://www.orange.ci" target="_blank" class="mt-2 text-yellow-400 hover:text-yellow-500">Payer via Orange Money</a>
                </div>
                <div class="text-center">
                    <img src="../assets/icon/payment/logo_momo.png" alt="MTN Money" class="h-20 w-20 rounded-full mx-auto">
                    <p class="mt-2">+237653749573</p>
                    <a href="https://www.mtn.ci" target="_blank" class="mt-2 text-yellow-400 hover:text-yellow-500">Payer via MTN Money</a>
                </div>
            </div>

            <!-- Paiement Cryptomonnaie -->
            <h2 class="text-2xl font-semibold mb-4 mt-8">Paiement en Cryptomonnaie (BNB)</h2>

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

            <!-- Bouton "J'ai payé" -->
            <button id="pay-button" class="mt-6 px-6 py-2 border border-yellow-400 text-yellow-400 rounded-lg text-lg font-semibold hover:bg-yellow-400 hover:text-gray-900 transition text-lg">
                J'ai payé
            </button>

        </div>
    </div>

    <!-- Fenêtre modale paiement -->
    <div id="payment-modal" class="hidden fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center">
        <div class="flex space-x-8">

            <!-- Crypto (BNB) -->
            <a href="verif_payment_bnb.php">
                <img src="../assets/icon/payment/bnb.png" alt="Crypto"
                    class="w-20 h-20 rounded-full shadow-lg hover:shadow-yellow-500 transition-all transform hover:scale-110">
            </a>

            <!-- Orange Money -->
            <a href="verif_payment_om.php">
                <img src="../assets/icon/payment/logo_om.png" alt="Orange Money"
                    class="w-20 h-20 rounded-full shadow-lg hover:shadow-orange-500 transition-all transform hover:scale-110">
            </a>

            <!-- MTN Money -->
            <a href="verif_payment_mtn.php">
                <img src="../assets/icon/payment/logo_momo.png" alt="MTN Money"
                    class="w-20 h-20 rounded-full shadow-lg hover:shadow-yellow-500 transition-all transform hover:scale-110">
            </a>

        </div>

        <!-- Bouton de fermeture -->
        <button id="close-modal" class="absolute top-10 right-10 text-white text-3xl font-bold hover:text-red-500 transition">
            ✖
        </button>
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

        function updateXAFPrice() {
            fetch('https://api.exchangerate-api.com/v4/latest/USD')
                .then(response => response.json())
                .then(data => {
                    let usdToXaf = data.rates.XAF; // Correct
                    let equivalentXAF = (15 * usdToXaf).toFixed(0); // Conversion 15$ → XAF

                    // Mise à jour de l'affichage
                    document.getElementById("xaf-equivalent").innerText = equivalentXAF + " XAF";
                })
                .catch(error => console.error("Erreur lors de la récupération du prix XAF:", error));
        }

        // Actualiser le prix toutes les 30 secondes
        setInterval(updateXAFPrice, 30000);
        updateXAFPrice();
        setInterval(updateBNBPrice, 30000);
        updateBNBPrice();

        // Gestion du bouton "J'ai payé"
        document.addEventListener("DOMContentLoaded", function() {
            const payButton = document.getElementById("pay-button");
            const modal = document.getElementById("payment-modal");
            const closeModal = document.getElementById("close-modal");

            if (payButton && modal && closeModal) {
                payButton.addEventListener("click", function() {
                    modal.classList.remove("hidden");
                });

                closeModal.addEventListener("click", function() {
                    modal.classList.add("hidden");
                });

                // Fermer la modale si l'utilisateur clique en dehors
                window.addEventListener("click", function(event) {
                    if (event.target === modal) {
                        modal.classList.add("hidden");
                    }
                });
            }
        });
    </script>

</body>

</html>