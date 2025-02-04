<?php // Assurez-vous que l'utilisateur est connecté, sinon rediriger vers la page de connexion
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
    <title>Vérification du Paiement</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../css/style_verif_payment_mobile.css">
</head>

<body class="bg-gray-900 text-white">
    <header class="flex justify-between items-center p-4 bg-gray-800">
        <a href="dashboard.php">
            <img src="../assets/img/source_plan_clair_petit.png" alt="Logo" class="h-10">
        </a>
        <div class="flex gap-4">
            <a href="https://wa.me/123456789" target="_blank">
                <img src="../assets/icons_svg/whatsapp.svg" alt="WhatsApp" class="w-8">
            </a>
            <a href="https://t.me/yourusername" target="_blank">
                <img src="../assets/icons_svg/telegram.svg" alt="Telegram" class="w-8">
            </a>
        </div>
    </header>

    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold text-center">Vérification du Paiement</h1>
        <p class="text-lg text-center mt-2">Sélectionnez votre mode de paiement :</p>

        <div class="flex justify-center gap-6 mt-6">
            <div class="bg-gray-800 p-6 rounded-lg cursor-pointer" onclick="showCryptoPopup()">
                <img src="../payment_icon/crypto_monnaie.png" alt="Crypto" class="w-20 mx-auto">
                <h2 class="text-xl text-center mt-4">Payé par Crypto</h2>
            </div>
            <div class="bg-gray-800 p-6 rounded-lg cursor-pointer" onclick="showMobilePopup()">
                <img src="../payment_icon/mobile_money.png" alt="Mobile Money" class="w-20 mx-auto">
                <h2 class="text-xl text-center mt-4">Payé par Mobile</h2>
            </div>
        </div>
    </div>

    <!-- Modal Crypto -->
    <div class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50" id="cryptoPopup">
        <div class="bg-gray-800 p-6 rounded-lg w-96">
            <h5 class="text-xl mb-4">Saisir le Hash de la Transaction</h5>
            <input type="text" id="transactionHash" placeholder="Entrez le hash ici" class="w-full p-2 rounded bg-gray-700">
            <button id="verifyButton" class="mt-4 w-full bg-blue-600 p-2 rounded">Vérifier</button>
            <div id="resultContainer" class="hidden mt-4 p-3 bg-gray-700 rounded"></div>
        </div>
    </div>

    <!-- Modal Mobile Money -->
    <div class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50" id="mobilePopup">
        <div class="bg-gray-800 p-6 rounded-lg w-96">
            <h1 class="text-center text-3xl font-bold mb-6">Saisir les Détails du Paiement</h1>


            <!-- Choix du mode de paiement -->
            <div class="mb-3">
                <h5 class="text-xl mb-4">Choisissez un mode de paiement</h5>
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

            <input type="text" id="mobileNumber" placeholder="Numéro de paiement" class="w-full p-2 rounded bg-gray-700 mb-2">
            <input type="text" id="transactionReference" placeholder="Référence de la transaction" class="w-full p-2 rounded bg-gray-700">
            <button id="confirmMobileButton" class="mt-4 w-full bg-blue-600 p-2 rounded">Confirmer</button>
            <div id="mobileResultContainer" class="hidden mt-4 p-3 bg-gray-700 rounded"></div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function showCryptoPopup() {
            document.getElementById('cryptoPopup').classList.remove('hidden');
        }

        function showMobilePopup() {
            document.getElementById('mobilePopup').classList.remove('hidden');
        }

        document.getElementById('verifyButton').addEventListener('click', function() {
            let verifyButton = document.getElementById('verifyButton');
            let transactionHashInput = document.getElementById('transactionHash');
            let transactionHash = transactionHashInput.value;

            verifyButton.disabled = true;
            verifyButton.innerHTML = 'Vérification en cours...';
            transactionHashInput.readOnly = true;

            $.ajax({
                url: '../request/verif_transaction_crypto.php',
                method: 'POST',
                data: {
                    hash: transactionHash
                },
                dataType: 'json',
                success: function(response) {
                    let resultHtml = response.status === 'success' ?
                        `<h5 class='text-green-400'>Paiement Confirmé</h5><p>${response.message}</p>` :
                        `<h5 class='text-red-400'>Paiement échoué</h5><p>${response.message}</p>`;

                    document.getElementById('resultContainer').innerHTML = resultHtml;
                    document.getElementById('resultContainer').classList.remove('hidden');

                    verifyButton.disabled = false;
                    verifyButton.innerHTML = 'Vérifier';
                    transactionHashInput.readOnly = false;
                },
                error: function() {
                    document.getElementById('resultContainer').innerHTML = 'Une erreur est survenue.';
                    document.getElementById('resultContainer').classList.remove('hidden');
                    verifyButton.disabled = false;
                    verifyButton.innerHTML = 'Vérifier';
                    transactionHashInput.readOnly = false;
                }
            });
        });

        document.getElementById('confirmMobileButton').addEventListener('click', function() {
            let mobileNumber = document.getElementById('mobileNumber').value;
            let transactionReference = document.getElementById('transactionReference').value;

            $.ajax({
                url: '../request/insert_transaction_mobile.php',
                method: 'POST',
                data: {
                    number: mobileNumber,
                    reference: transactionReference
                },
                dataType: 'json',
                success: function(response) {
                    let resultHtml = response.status === 'success' ?
                        `<h5 class='text-green-400'>Paiement Confirmé</h5><p>${response.message}</p>` :
                        `<h5 class='text-red-400'>Paiement échoué</h5><p>${response.message}</p>`;

                    document.getElementById('mobileResultContainer').innerHTML = resultHtml;
                    document.getElementById('mobileResultContainer').classList.remove('hidden');
                },
                error: function() {
                    document.getElementById('mobileResultContainer').innerHTML = 'Une erreur est survenue.';
                    document.getElementById('mobileResultContainer').classList.remove('hidden');
                }
            });
        });
    </script>
</body>

</html>