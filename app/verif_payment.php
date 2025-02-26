<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification du Paiement</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../css/style_verif_payment_mobile.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/progressbar.js/1.1.0/progressbar.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/circles.js/dist/circles.min.js"></script>
</head>

<body class="bg-gray-900 text-white">
    <header class="flex justify-between items-center p-4 bg-gray-800">
        <a href="dashboard.php">
            <img src="../assets/img/logo.png" alt="Logo" class="h-10">
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
            <div class="bg-gray-800 p-6 rounded-lg opacity-50 cursor-not-allowed">
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

    <!-- Jauge circulaire et compte à rebours -->
    <div class="text-center mt-8">
        <div id="progress-circle" style="width: 150px; height: 150px; margin: 0 auto;"></div>
        <div id="countdown-text" class="text-xl mt-4"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function showCryptoPopup() {
            document.getElementById('cryptoPopup').classList.remove('hidden');
        }

        function startCountdown(seconds) {
            // Crée la jauge circulaire
            var circle = new ProgressBar.Circle('#progress-circle', {
                strokeWidth: 6,
                color: '#FF0000',
                trailColor: '#eeeeee',
                trailWidth: 1,
                easing: 'easeInOut',
                duration: seconds * 1000, // Durée du compte à rebours en millisecondes
                text: {
                    autoStyleContainer: false,
                    value: seconds + 's' // Affiche les secondes restantes
                },
                from: {
                    color: '#FF0000',
                    width: 1
                },
                to: {
                    color: '#00FF00',
                    width: 6
                },
            });

            // Démarre le compte à rebours et la jauge circulaire
            circle.animate(1, function() {
                // Une fois le compte à rebours terminé, redirige
                window.location.href = 'redirection_page.php';
            });

            // Met à jour le texte du compte à rebours toutes les secondes
            var countdownText = document.getElementById('countdown-text');
            var interval = setInterval(function() {
                seconds--;
                countdownText.textContent = seconds + 's';
                if (seconds <= 0) {
                    clearInterval(interval); // Arrête le compte à rebours
                }
            }, 1000);
        }

        // Cette fonction sera appelée lorsque le paiement est validé
        $(document).ready(function() {
            $('#verifyButton').click(function() {
                var transactionHash = $('#transactionHash').val();

                $.ajax({
                    url: '../request/verif_payment_request.php',
                    method: 'POST',
                    data: {
                        hash: transactionHash
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#resultContainer').html('<h5 class="text-green-400">Paiement Confirmé</h5><p>' + response.message + '</p>');
                            $('#resultContainer').removeClass('hidden');

                            // Démarre le compte à rebours après la validation du paiement
                            startCountdown(30); // Exemple de compte à rebours de 30 secondes
                        } else {
                            $('#resultContainer').html('<h5 class="text-red-400">Paiement échoué</h5><p>' + response.error + '</p>');
                            $('#resultContainer').removeClass('hidden');
                        }
                    },
                    error: function() {
                        $('#resultContainer').html('<p>Une erreur est survenue.</p>');
                        $('#resultContainer').removeClass('hidden');
                    }
                });
            });
        });
    </script>
</body>

</html>