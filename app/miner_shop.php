<?php
// Assurez-vous que l'utilisateur est connecté, sinon rediriger vers la page de connexion
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement Crypto - Finova</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../css/style_miner_shop.css">
</head>

<body class="bg-gray-900 text-white">
    <header class="flex justify-between items-center p-4 bg-gray-800 shadow-lg">
        <a href="dashboard.php">
            <img src="../assets/img/source_plan_clair_petit.png" alt="Logo" class="h-10">
        </a>
        <div class="flex space-x-4">
            <a href="https://wa.me/123456789" target="_blank" class="text-green-400 text-2xl">
                <i class="fab fa-whatsapp"></i>
            </a>
            <a href="https://t.me/yourusername" target="_blank" class="text-blue-400 text-2xl">
                <i class="fab fa-telegram"></i>
            </a>
        </div>
    </header>

    <div class="container mx-auto p-6">
        <h1 class="text-center text-3xl font-bold mb-6">Acheter un miner</h1>
        <div id="error-message" class="text-red-400 text-center"></div>
        <div id="success-message" class="text-green-400 text-center hidden"></div>

        <!-- Packs de paiement -->
        <div id="packs-container" class="grid grid-cols-1 md:grid-cols-3 gap-6"></div>

        <!-- Informations de paiement -->
        <div id="payment-info" style="display: none;">
            <!-- Choix du mode de paiement -->
            <div class="mb-3">
                <h1 class="text-center text-3xl font-bold mb-6">Choisissez un mode de paiement</h1>
                <div class="payment-options">
                    <div class="payment-card">
                        <input type="radio" id="orange_money" name="mode_paiement" value="Orange Money" required />
                        <label for="orange_money">
                            <img src="../payment_icon/logo_om.png" alt="Orange Money" />
                            <span>OM</span>
                        </label>
                    </div>

                    <div class="payment-card">
                        <input type="radio" id="mtn_money" name="mode_paiement" value="MTN Money" required />
                        <label for="mtn_money">
                            <img src="../payment_icon/logo_momo.png" alt="MTN Money" />
                            <span>Momo</span>
                        </label>
                    </div>

                    <div class="payment-card">
                        <input type="radio" id="moov_money" name="mode_paiement" value="Moov Money" required />
                        <label for="moov_money">
                            <img src="../payment_icon/logo_flooz.png" alt="Moov Money" />
                            <span>Flooz</span>
                        </label>
                    </div>

                    <div class="payment-card">
                        <input type="radio" id="wave" name="mode_paiement" value="Wave" required />
                        <label for="wave">
                            <img src="../payment_icon/logo_wave.png" alt="Wave" />
                            <span>Wave</span>
                        </label>
                    </div>
                </div>
            </div>

            <h1 class="text-center text-3xl font-bold mb-6">Effectuez votre paiement en crypto</h1>

            <p class="amount">Montant à payer : <span id="amount-to-pay"></span> USDT</p>
            <p>Envoyez à l'adresse suivante :</p>
            <p class="address" id="payment-address"></p>
            <button class="btn" onclick="window.location.href='verif_payment.php'">J'ai payé</button>
        </div>
    </div>

    <!-- Overlay -->
    <div class="overlay" id="overlay"></div>

    <!-- Pop-up -->
    <div class="popup-container hidden" id="popup">
        <div class="popup-header">
            <img id="payment-icon" src="" alt="Mode de paiement">
            <h2 id="payment-title"></h2>
        </div>
        <p>Montant : <strong id="amount"></strong></p>
        <p>Numéro de dépôt :</p>
        <div class="copy-container" onclick="copyDepositNumber()">
            <span id="deposit-number"></span>
            <img src="https://cdn-icons-png.flaticon.com/512/1621/1621635.png" alt="Copier">
        </div>
        <button class="popup-button" onclick="closePopup()">Fermer</button>
    </div>
    <script src="../js/script_miner_shop.js"></script>
</body>

</html>