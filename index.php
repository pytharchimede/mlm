<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement Crypto - Finova</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
        }

        body {
            background: #121212;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            max-width: 800px;
        }

        h1 {
            font-size: 2em;
            margin-bottom: 20px;
            color: #00FFD1;
        }

        .packs {
            display: flex;
            justify-content: space-around;
            gap: 20px;
        }

        .pack {
            background: #1E1E1E;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 255, 209, 0.2);
            width: 200px;
            text-align: center;
            transition: transform 0.3s;
        }

        .pack:hover {
            transform: scale(1.05);
        }

        .pack img {
            width: 100%;
            border-radius: 10px;
        }

        .pack h2 {
            font-size: 1.5em;
            margin: 10px 0;
        }

        .pack p {
            font-size: 1.2em;
            color: #00FFD1;
        }

        .btn {
            background: #00FFD1;
            color: black;
            border: none;
            padding: 10px 20px;
            font-size: 1em;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #00cca3;
        }

        #error-message {
            margin: 20px 0;
            padding: 10px;
            border-radius: 8px;
            background-color: #ff4d4d;
            color: white;
            font-size: 1.2em;
            text-align: center;
            display: none;
            transition: opacity 0.3s ease;
        }

        #success-message {
            background-color: #4CAF50;
        }

        #payment-info {
            margin-top: 30px;
            padding: 20px;
            background: #1E1E1E;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 255, 209, 0.2);
        }

        .address {
            font-size: 1.2em;
            color: #fff;
            font-weight: bold;
            margin-top: 10px;
        }

        .amount {
            font-size: 1.2em;
            color: #fff;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Choisissez votre pack</h1>
        <div id="error-message"></div>
        <div id="success-message" style="display:none;"></div>
        <div class="packs">
            <div class="pack">
                <img src="https://via.placeholder.com/200" alt="Pack Basic">
                <h2>Basic</h2>
                <p>10 000 FCFA / mois</p>
                <button class="btn" onclick="payer(10000, 'Basic')">Payer</button>
            </div>
            <div class="pack">
                <img src="https://via.placeholder.com/200" alt="Pack Pro">
                <h2>Pro</h2>
                <p>25 000 FCFA / mois</p>
                <button class="btn" onclick="payer(25000, 'Pro')">Payer</button>
            </div>
            <div class="pack">
                <img src="https://via.placeholder.com/200" alt="Pack Premium">
                <h2>Premium</h2>
                <p>50 000 FCFA / mois</p>
                <button class="btn" onclick="payer(50000, 'Premium')">Payer</button>
            </div>
        </div>

        <!-- Informations de paiement -->
        <div id="payment-info" style="display: none;">
            <h3>Effectuez votre paiement en crypto</h3>
            <p class="amount">Montant à payer : <span id="amount-to-pay"></span> USDT</p>
            <p>Envoyez à l'adresse suivante :</p>
            <p class="address" id="payment-address"></p>
            <button class="btn" onclick="verifier_paiement()">J'ai payé</button>
        </div>
    </div>

    <script>
        function payer(amount, packName) {
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
                    console.log(data);
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
    </script>

</body>

</html>