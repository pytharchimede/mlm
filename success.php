<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement Réussi - Abonnement</title>
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
            text-align: center;
        }

        .container {
            max-width: 800px;
            padding: 20px;
            background: #1E1E1E;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 255, 209, 0.2);
        }

        h1 {
            font-size: 2em;
            margin-bottom: 20px;
            color: #00FFD1;
        }

        p {
            font-size: 1.2em;
            margin-bottom: 20px;
        }

        .btn {
            background: #00FFD1;
            color: black;
            border: none;
            padding: 10px 20px;
            font-size: 1em;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #00cca3;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Paiement Réussi</h1>
        <p>Félicitations, votre paiement a été effectué avec succès !</p>
        <p>Votre abonnement a été activé. Vous pouvez maintenant accéder à tous les avantages.</p>
        <a href="index.php"><button class="btn">Retour à l'accueil</button></a>
    </div>

</body>

</html>