<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement Crypto - Abonnement</title>
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
    </style>
</head>

<body>

    <div class="container">
        <h1>Choisissez votre pack</h1>
        <div class="packs">
            <div class="pack">
                <img src="https://via.placeholder.com/200" alt="Pack Basic">
                <h2>Basic</h2>
                <p>10 000 FCFA / mois</p>
                <button class="btn" onclick="payer(10, 'Basic')">Payer</button>
            </div>
            <div class="pack">
                <img src="https://via.placeholder.com/200" alt="Pack Pro">
                <h2>Pro</h2>
                <p>25 000 FCFA / mois</p>
                <button class="btn" onclick="payer(25, 'Pro')">Payer</button>
            </div>
            <div class="pack">
                <img src="https://via.placeholder.com/200" alt="Pack Premium">
                <h2>Premium</h2>
                <p>50 000 FCFA / mois</p>
                <button class="btn" onclick="payer(50, 'Premium')">Payer</button>
            </div>
        </div>
    </div>

    <script>
        function payer(amount, packName) {
            fetch('create_payment.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        price_amount: amount,
                        price_currency: "USD",
                        pay_currency: "BTC",
                        order_id: packName + "_" + Date.now(),
                        success_url: "https://tonsite.com/success.php",
                        cancel_url: "https://tonsite.com/cancel.php"
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.invoice_url) {
                        window.location.href = data.invoice_url;
                    } else {
                        alert("Erreur: " + (data.message || "Impossible de créer le paiement."));
                    }
                })
                .catch(error => console.error("Erreur:", error));
        }
    </script>

</body>

</html>