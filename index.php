<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement Crypto - Finova</title>
    <!-- Intégration de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style_pop_up.css" rel="stylesheet">
    <link href="css/style_index.css" rel="stylesheet">
</head>

<body>

    <!-- Barre fixe avec le logo et les boutons de contact -->
    <header class="header-fixed">
        <div class="logo-container">
            <img src="assets/img/source_plan_clair_petit.png" alt="Logo">
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
            <div class="pack" data-pack="Basic 1">
                <!-- <div class="icon">✨</div> -->
                <h2>Miner Basic 1</h2>
                <p>6 000 FCFA</p>
                <div class="stars">
                    ★★★☆☆
                </div>
                <button class="btn" onclick="payer(6000, 'Basic 1')">Payer</button>
            </div>
            <div class="pack" data-pack="Basic 2">
                <!-- <div class="icon">🚀</div> -->
                <h2>Miner Basic 2</h2>
                <p>8 000 FCFA</p>
                <div class="stars">
                    ★★★★☆
                </div>
                <button class="btn" onclick="payer(8000, 'Basic 2')">Payer</button>
            </div>
            <div class="pack" data-pack="Basic 3">
                <!-- <div class="icon">🔥</div> -->
                <h2>Miner Basic 3</h2>
                <p>10 000 FCFA</p>
                <div class="stars">
                    ★★★★★
                </div>
                <button class="btn" onclick="payer(10000, 'Basic 3')">Payer</button>
            </div>
            <div class="pack" data-pack="Basic 4">
                <!-- <div class="icon">💎</div> -->
                <h2>Miner Basic 4</h2>
                <p>15 000 FCFA</p>
                <div class="stars">
                    ★★★★★
                </div>
                <button class="btn" onclick="payer(15000, 'Basic 4')">Payer</button>
            </div>
            <div class="pack" data-pack="Pro 1">
                <!-- <div class="icon">🌟</div> -->
                <h2>Miner Pro 1</h2>
                <p>30 000 FCFA</p>
                <div class="stars">
                    ★★★★★
                </div>
                <button class="btn" onclick="payer(30000, 'Pro 1')">Payer</button>
            </div>
            <div class="pack" data-pack="Pro 2">
                <!-- <div class="icon">💼</div> -->
                <h2>Miner Pro 2</h2>
                <p>60 000 FCFA</p>
                <div class="stars">
                    ★★★★★
                </div>
                <button class="btn" onclick="payer(60000, 'Pro 2')">Payer</button>
            </div>
            <div class="pack" data-pack="Pro 3">
                <!-- <div class="icon">🏆</div> -->
                <h2>Miner Pro 3</h2>
                <p>100 000 FCFA</p>
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
            <button class="btn" onclick="verifier_paiement()">J'ai payé</button>
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

    <script>
        function payer(amount, packName) {
            // Masquer tous les packs
            const packs = document.querySelectorAll('.pack');
            packs.forEach(pack => {
                pack.style.display = 'none';
            });

            // Afficher uniquement le pack sélectionné
            const selectedPack = document.querySelector(`.pack[data-pack="${packName}"]`);
            if (selectedPack) {
                selectedPack.style.display = 'block';
            }

            // Désactiver le bouton et afficher un indicateur de chargement
            const btn = selectedPack.querySelector('button');
            btn.disabled = true;
            btn.innerHTML = 'Chargement... <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

            // Faire l'appel pour la création du paiement
            fetch('request/create_paiement.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        price_amount: amount,
                        price_currency: "XOF",
                        pay_currency: "usdttrc20",
                        order_id: packName + "_" + Date.now(),
                        success_url: "https://ifmap.ci/test/success.php",
                        cancel_url: "https://ifmap.ci/test/cancel.php"
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.pay_address && data.pay_amount) {
                        // Affichage des informations de paiement
                        document.getElementById('payment-info').style.display = 'block';
                        document.getElementById('amount-to-pay').innerText = data.pay_amount;
                        document.getElementById('payment-address').innerText = data.pay_address;
                    } else {
                        document.getElementById('error-message').innerText = data.error || "Erreur inconnue.";
                        document.getElementById('error-message').style.display = 'block';
                        document.getElementById('success-message').style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error("Erreur:", error);
                    document.getElementById('error-message').innerText = "Une erreur s'est produite.";
                    document.getElementById('error-message').style.display = 'block';
                })
                .finally(() => {
                    // Réactiver le bouton et enlever l'indicateur de chargement
                    btn.disabled = false;
                    btn.innerHTML = 'Regénérer lien de paiement';
                });
        }

        function verifier_paiement(order_id, payment_id, payment_status, amount_received, pay_amount) {
            // Appel de l'API de vérification du paiement
            fetch('request/verif_paiement.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        order_id: order_id,
                        payment_id: payment_id,
                        payment_status: payment_status,
                        amount_received: amount_received,
                        amount_expected: pay_amount // Montant attendu
                    })
                })
                .then(response => response.json()) // Décodage de la réponse JSON
                .then(data => {
                    if (data.status === 'success') {
                        // Affichage du message de succès
                        document.getElementById('success-message').innerText = data.message;
                        document.getElementById('success-message').style.display = 'block';
                        document.getElementById('error-message').style.display = 'none';

                        // Redirection vers success.php
                        window.location.href = 'success.php';
                    } else {
                        // Affichage du message d'erreur
                        document.getElementById('error-message').innerText = data.message;
                        document.getElementById('error-message').style.display = 'block';
                        document.getElementById('success-message').style.display = 'none';

                        // Redirection vers cancel.php
                        window.location.href = 'cancel.php';
                    }
                })
                .catch(error => {
                    console.error("Erreur lors de la vérification du paiement:", error);
                    document.getElementById('error-message').innerText = "Une erreur s'est produite lors de la vérification du paiement.";
                    document.getElementById('error-message').style.display = 'block';
                });
        }

        function openPopup(mode, amount, depositNumber) {
            const paymentDetails = {
                "Orange Money": {
                    "icon": "payment_icon/logo_om.png",
                    "phone": "+225 07 00 00 00"
                },
                "MTN Money": {
                    "icon": "payment_icon/logo_momo.png",
                    "phone": "+225 05 00 00 00"
                },
                "Moov Money": {
                    "icon": "payment_icon/logo_flooz.png",
                    "phone": "+225 01 00 00 00"
                },
                "Wave": {
                    "icon": "payment_icon/logo_wave.png",
                    "phone": "+225 08 00 00 00"
                }
            };

            // Vérifie si le mode de paiement existe dans les détails
            if (paymentDetails[mode]) {
                document.getElementById("payment-icon").src = paymentDetails[mode].icon || "https://cdn-icons-png.flaticon.com/512/1781/1781106.png";
                document.getElementById("payment-title").textContent = mode;
                document.getElementById("amount").textContent = amount + " FCFA";
                // document.getElementById("deposit-number").textContent = depositNumber;
                document.getElementById("deposit-number").textContent = paymentDetails[mode].phone; // Valeur statique de test

                // Affichage du pop-up
                document.getElementById("popup").style.display = "block";
                document.getElementById("overlay").style.display = "block";

                // Log des détails du paiement dans la console
                console.log("Mode de paiement : " + mode);
                console.log("Montant : " + amount + " FCFA");
                console.log("Numéro de dépôt : " + depositNumber);
                console.log("Icône : " + paymentDetails[mode].icon);
                console.log("Numéro téléphone : " + paymentDetails[mode].phone);
            }
        }

        function closePopup() {
            document.getElementById("popup").style.display = "none";
            document.getElementById("overlay").style.display = "none";
        }

        function copyDepositNumber() {
            const text = document.getElementById("deposit-number").textContent;
            navigator.clipboard.writeText(text).then(() => {
                alert("Numéro copié : " + text);
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            const paymentOptions = document.querySelectorAll(".payment-card input");

            paymentOptions.forEach(option => {
                option.addEventListener("change", function() {
                    if (this.checked) {
                        const mode = this.value;
                        const amount = 5000; // Exemples de montant
                        const depositNumber = "123456789"; // Exemple de numéro de dépôt
                        openPopup(mode, amount, depositNumber);
                    }
                });
            });

            // Fermer le popup lorsqu'on clique sur l'overlay
            document.getElementById("overlay").addEventListener("click", function() {
                closePopup();
            });
        });
    </script>

    <!-- Intégration de Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>