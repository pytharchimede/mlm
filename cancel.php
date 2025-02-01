<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement Annulé - Abonnement</title>
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
            box-shadow: 0 4px 10px rgba(255, 0, 0, 0.2);
        }

        h1 {
            font-size: 2em;
            margin-bottom: 20px;
            color: #FF0000;
        }

        p {
            font-size: 1.2em;
            margin-bottom: 20px;
        }

        .btn {
            background: #FF0000;
            color: black;
            border: none;
            padding: 10px 20px;
            font-size: 1em;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #cc0000;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Paiement Annulé</h1>
        <p>Désolé, votre paiement a été annulé.</p>
        <p>Vous pouvez réessayer plus tard ou contacter notre support si vous avez besoin d'aide.</p>
        <a href="index.php"><button class="btn">Retour à l'accueil</button></a>
    </div>

</body>

</html>