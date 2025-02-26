<?php
include '../headers/header_verif_payment.php';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification de Transaction BNB</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../css/style_verif_payment_mobile.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/progressbar.js/1.1.0/progressbar.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../css/style_verif_payment_countdown.css">
</head>

<body class="bg-dark text-light">

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
        <h1 class="text-3xl font-bold text-center">Vérification du Paiement <?php echo $_SESSION['secur'] ?? ''; ?></h1>
        <div class="mb-3">
            <label for="hash" class="form-label">Entrez le hash de la transaction :</label>
            <input type="text" id="hash" class="form-control" placeholder="Ex: 0x123abc..." required>
        </div>
        <button class="btn btn-primary w-100" onclick="verifierTransaction()"><i class="fas fa-search"></i> Vérifier</button>
        <div class="mt-4">
            <h4 class="text-center">Résultat de la Vérification</h4>
            <div id="resultat" class="d-none card shadow-lg border-0 card-custom">
                <div class="card-body">
                    <h5 class="card-title text-center" id="status"></h5>
                    <hr>
                    <div class="countdown-container">
                        <div class="progress-circle" id="progress-container"></div>
                        <div class="countdown" id="countdown"></div>
                        <div class="credit" id="credit"></div>
                    </div>
                    <div class="details">
                        <p><strong><i class="fas fa-coins"></i> Montant :</strong> <span id="montant"></span></p>
                        <p><strong><i class="fas fa-dollar-sign"></i> Valeur en USD :</strong> <span id="montant_usd"></span></p>
                        <p><strong><i class="far fa-calendar-alt"></i> Date :</strong> <span id="date_transaction"></span></p>
                        <p><strong><i class="fas fa-link"></i> Détails :</strong> <a href="#" id="bscscan_link" target="_blank">Voir sur BscScan</a></p>
                    </div>
                </div>
            </div>
            <div id="erreur" class="alert alert-danger d-none mt-3"></div>
        </div>
    </div>

    <script src="../js/script_verif_payment.js"></script>
</body>

</html>