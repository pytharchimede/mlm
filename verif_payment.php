<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification du Paiement</title>
    <!-- Lien vers Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style_index_dark.css">
    <!-- Lien vers le CSS personnalisé -->
    <link rel="stylesheet" href="css/style_verif_payment_dark.css">
    <style>
        /* Ajoutez le style sombre ici */
        .modal-content {
            background-color: #2c2c2c;
            color: #e1e1e1;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            border-bottom: none;
            background-color: #333333;
            color: #fff;
        }

        .modal-title {
            font-weight: bold;
            font-size: 1.5em;
        }

        .modal-body {
            background-color: #2c2c2c;
        }

        .modal-footer {
            background-color: #333333;
        }

        .modal-footer .btn {
            background-color: #00A3FF;
            border: none;
            color: white;
            border-radius: 5px;
        }

        .modal-footer .btn:hover {
            background-color: #0090cc;
        }

        /* Boutons de fermeture */
        .btn-close {
            background-color: transparent;
            border: none;
            color: #fff;
            font-size: 1.5em;
        }

        .spinner-border {
            width: 1.5rem;
            height: 1.5rem;
            border-width: 0.2em;
        }
    </style>
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
            <a href="https://wa.me/123456789" target="_blank" class="whatsapp-button">
                <img src="assets/icons_svg/whatsapp.svg" alt="WhatsApp" width="30">
            </a>
            <a href="https://t.me/yourusername" target="_blank" class="telegram-button">
                <img src="assets/icons_svg/telegram.svg" alt="Telegram" width="30">
            </a>
        </div>
    </header>

    <!-- Contenu principal de la page -->
    <div class="container">
        <h1>Vérification du Paiement</h1>
        <p class="lead">Sélectionnez votre mode de paiement :</p>

        <!-- Options de paiement -->
        <div class="packs">
            <div class="pack" onclick="showCryptoPopup()">
                <div class="icon">
                    <img src="payment_icon/crypto_monnaie.png" alt="Crypto" class="img-fluid">
                </div>
                <h2>Payé par Crypto</h2>
            </div>

            <div class="pack" onclick="window.location.href='mobile_money_payment_details.php'">
                <div class="icon">
                    <img src="payment_icon/mobile_money.png" alt="Mobile Money" class="img-fluid">
                </div>
                <h2>Payé par Mobile</h2>
            </div>
        </div>
    </div>

    <!-- Popup pour saisir le hash de la transaction -->
    <div class="modal" tabindex="-1" id="cryptoPopup">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Saisir le Hash de la Transaction</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="cryptoForm">
                        <div class="mb-3">
                            <label for="transactionHash" class="form-label">Hash de la transaction</label>
                            <input type="text" class="form-control" id="transactionHash" placeholder="Entrez le hash ici" required>
                        </div>
                        <button type="submit" class="btn btn-primary" id="verifyButton">
                            Vérifier
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Inclusion de Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Fonction pour afficher le popup
        function showCryptoPopup() {
            var myModal = new bootstrap.Modal(document.getElementById('cryptoPopup'));
            myModal.show();
        }

        // Gérer la soumission du formulaire
        document.getElementById('cryptoForm').addEventListener('submit', function(event) {
            event.preventDefault();

            var verifyButton = document.getElementById('verifyButton');
            var transactionHashInput = document.getElementById('transactionHash');
            var transactionHash = transactionHashInput.value;

            // Désactiver le bouton de vérification et changer le texte
            verifyButton.disabled = true;
            verifyButton.innerHTML = 'Vérification en cours... <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

            // Mettre l'input en readonly
            transactionHashInput.readOnly = true;

            // Simulation d'un délai de vérification
            setTimeout(function() {
                // Réactiver le bouton et afficher le texte original après la simulation
                verifyButton.disabled = false;
                verifyButton.innerHTML = 'Vérifier';
                transactionHashInput.readOnly = false;

                // Afficher un message ou effectuer une autre action ici
                alert("Vérification terminée pour le hash : " + transactionHash);
            }, 3000); // Simuler 3 secondes de vérification
        });
    </script>

</body>

</html>