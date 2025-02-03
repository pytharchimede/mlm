<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification du Paiement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style_index_dark.css">
    <link rel="stylesheet" href="css/style_verif_payment_dark.css">
    <style>
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

        .response-message {
            margin-top: 15px;
            font-size: 1.1em;
            color: #00A3FF;
        }
    </style>
</head>

<body>

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

    <div class="container">
        <h1>Vérification du Paiement</h1>
        <p class="lead">Sélectionnez votre mode de paiement :</p>

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
                        <div id="resultContainer" style="display: none;">
                            <div id="verificationResult" class="result-popup"></div>
                        </div>
                    </form>
                    <div class="response-message" id="responseMessage"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function showCryptoPopup() {
            var myModal = new bootstrap.Modal(document.getElementById('cryptoPopup'));
            myModal.show();
        }

        document.getElementById('cryptoForm').addEventListener('submit', function(event) {
            event.preventDefault();

            var verifyButton = document.getElementById('verifyButton');
            var transactionHashInput = document.getElementById('transactionHash');
            var transactionHash = transactionHashInput.value;

            // Désactiver le bouton pendant la vérification
            verifyButton.disabled = true;
            verifyButton.innerHTML = 'Vérification en cours... <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
            transactionHashInput.readOnly = true;

            $.ajax({
                url: 'request/verif_transaction_crypto.php',
                method: 'POST',
                data: {
                    hash: transactionHash
                },
                dataType: 'json', // Spécifier que la réponse est en JSON
                success: function(response) {
                    var resultHtml = '';

                    // Affichage du résultat
                    if (response.status === 'success') {

                        verifyButton.disabled = true;
                        verifyButton.innerHTML = 'Vérification terminée <i class="fa fa-checked"></i>';

                        // Affichage du paiement réussi
                        resultHtml = `
                    <h5 class="result-title">Paiement Confirmé</h5>
                    <p class="result-message">${response.message}</p>
                    <div class="result-details">
                        <label for="timestamp"><strong>Date:</strong></label>
                        <p class="result-message">${response.details.timestamp}</p>
                    </div>
                `;
                    } else {
                        // Affichage de l'erreur
                        resultHtml = `
                    <h5 class="result-title">Paiement échoué</h5>
                    <p class="result-message">${response.message}</p>
                `;
                    }

                    // Vérifier si l'élément existe avant d'ajouter du contenu
                    var resultContainer = document.getElementById('verificationResult');
                    if (resultContainer) {
                        resultContainer.innerHTML = resultHtml;
                        document.getElementById('resultContainer').style.display = 'block';
                    }

                    // Réactiver le bouton et rétablir le champ de saisie
                    verifyButton.disabled = false;
                    verifyButton.innerHTML = 'Vérifier';
                    transactionHashInput.readOnly = false;
                },
                error: function() {
                    // Erreur en cas d'échec de la requête AJAX
                    var resultContainer = document.getElementById('verificationResult');
                    if (resultContainer) {
                        resultContainer.innerHTML = 'Une erreur est survenue lors de la vérification.';
                        document.getElementById('resultContainer').style.display = 'block';
                    }

                    // Réactiver le bouton et rétablir le champ de saisie
                    verifyButton.disabled = false;
                    verifyButton.innerHTML = 'Vérifier';
                    transactionHashInput.readOnly = false;
                }
            });
        });
    </script>

</body>

</html>