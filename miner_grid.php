<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement Crypto - Finova</title>
    <!-- Intégration de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style_pop_up_dark.css" rel="stylesheet">
    <link href="css/style_index_dark.css" rel="stylesheet">
</head>

<body>

    <!-- Barre fixe avec le logo et les boutons de contact -->
    <header class="header-fixed">
        <div class="logo-container">
            <a href="index.php">
                <img src="assets/img/source_plan_clair_petit.png" alt="Logo">
            </a>
        </div>
        <div class="contact-buttons">
            <!-- Remplacez les liens par vos liens réels -->
            <a href="https://wa.me/123456789" target="_blank" class="whatsapp-button">
                <img src="assets/icons_svg/whatsapp.svg" alt="WhatsApp" width="30">
            </a>
            <a href="https://t.me/yourusername" target="_blank" class="telegram-button">
                <img src="assets/icons_svg/telegram.svg" alt="Telegram" width="30">
            </a>
            <!-- Vous pouvez ajouter d'autres boutons ici -->
        </div>
    </header>


    <div class="container">
        <h1>Acheter un miner</h1>
        <div id="error-message"></div>
        <div id="success-message" style="display:none;"></div>
        <div class="packs">
            <div class="pack" data-pack="Pro 3">
                <!-- <div class="icon">🏆</div> -->
                <h2>Miner Pro 3</h2>
                <p>15 $</p>
                <div class="stars">
                    ★★★★★
                </div>
                <button class="btn" onclick="payer(100000, 'Pro 3')">Payer</button>
            </div>
        </div>

        <!-- Informations de paiement -->
        <div id="payment-info" style="display: none;">
            <!-- Choix du mode de paiement -->
            <div class="mb-3">
                <h3 for="mode_paiement" class="control-label">Choisissez un mode de paiement</h3>
                <div class="payment-options">
                    <div class="payment-card">
                        <input type="radio" id="orange_money" name="mode_paiement" value="Orange Money" required />
                        <label for="orange_money">
                            <img src="payment_icon/logo_om.png" alt="Orange Money" />
                            <span>OM</span>
                        </label>
                    </div>

                    <div class="payment-card">
                        <input type="radio" id="mtn_money" name="mode_paiement" value="MTN Money" required />
                        <label for="mtn_money">
                            <img src="payment_icon/logo_momo.png" alt="MTN Money" />
                            <span>Momo</span>
                        </label>
                    </div>

                    <div class="payment-card">
                        <input type="radio" id="moov_money" name="mode_paiement" value="Moov Money" required />
                        <label for="moov_money">
                            <img src="payment_icon/logo_flooz.png" alt="Moov Money" />
                            <span>Flooz</span>
                        </label>
                    </div>

                    <div class="payment-card">
                        <input type="radio" id="wave" name="mode_paiement" value="Wave" required />
                        <label for="wave">
                            <img src="payment_icon/logo_wave.png" alt="Wave" />
                            <span>Wave</span>
                        </label>
                    </div>
                </div>
            </div>

            <h3>Effectuez votre paiement en crypto</h3>
            <p class="amount">Montant à payer : <span id="amount-to-pay"></span> USDT</p>
            <p>Envoyez à l'adresse suivante :</p>
            <p class="address" id="payment-address"></p>
            <button class="btn" onclick="window.location.href='verif_payment.php'">J'ai payé</button>
        </div>
    </div>


    <!-- Overlay -->
    <div class="overlay" id="overlay"></div>

    <!-- Pop-up -->
    <div class="popup-container" id="popup">
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

    <script src="js\script_miner_grid.js"></script>
    <!-- Intégration de Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>