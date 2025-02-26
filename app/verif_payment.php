<?php
session_start();
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
    <style>
        .countdown-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            margin-top: 20px;
        }

        .countdown {
            font-size: 3rem;
            font-weight: bold;
            position: absolute;
        }

        .credit {
            font-size: 3rem;
            font-weight: bold;
            position: absolute;
        }

        .progress-circle {
            width: 150px;
            height: 150px;
            position: relative;
        }

        .details {
            text-align: center;
            margin-top: 20px;
        }

        .card-custom {
            max-width: 500px;
            margin: auto;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
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

    <script>
        function verifierTransaction() {
            let hash = $("#hash").val().trim();
            if (hash === "") {
                alert("Veuillez entrer un hash de transaction.");
                return;
            }

            $.ajax({
                url: "../request/verif_payment_request.php",
                type: "POST",
                data: {
                    hash: hash
                },
                success: function(response) {
                    $("#resultat").addClass("d-none");
                    $("#erreur").addClass("d-none");

                    if (response.success) {
                        console.log(response);
                        $("#status").html('<i class="fas fa-check-circle text-success"></i> Transaction validée');
                        $("#montant").text(response.montant_bnb + " BNB");
                        $("#montant_usd").text("~ $" + response.montant_usd);
                        $("#date_transaction").text(response.date_transaction);
                        $("#bscscan_link").attr("href", "https://bscscan.com/tx/" + hash);

                        $("#resultat").removeClass("d-none");
                        startCountdown();
                    } else {
                        $("#erreur").text(response.error).removeClass("d-none");
                    }
                },
                error: function() {
                    $("#erreur").text("Erreur lors de la vérification.").removeClass("d-none");
                }
            });
        }

        function startCountdown() {
            let seconds = 5;
            $("#countdown").text(seconds);
            let progressBar = new ProgressBar.Circle("#progress-container", {
                strokeWidth: 6,
                easing: 'linear',
                duration: 5000,
                color: '#28a745',
                trailColor: '#ddd',
                trailWidth: 6,
                svgStyle: null
            });
            progressBar.animate(1);

            let interval = setInterval(() => {
                seconds--;
                $("#countdown").text(seconds);
                if (seconds <= 0) {
                    clearInterval(interval);
                    // Masquer les détails et le compte à rebours
                    $("#resultat").addClass("d-none");
                    $("#countdown").addClass("d-none");
                    // Effectuer la redirection après un petit délai
                    setTimeout(() => {
                        console.log('Souscription au pack en cours...');

                        // Récupérer les informations nécessaires pour la souscription
                        let abonne_secur = "<?php echo $_SESSION['secur'] ?? ''; ?>"; // Si $_SESSION['secur'] est défini, il sera injecté dans la variable abonne_secur, sinon ce sera une chaîne vide
                        let pack_id = 1; // ID du pack auquel l'abonné souhaite souscrire
                        let solde = 15;
                        let date_souscription = new Date().toISOString().slice(0, 19).replace('T', ' '); // Date actuelle
                        let date_fin = null;

                        // Appel AJAX pour souscrire l'abonné au pack
                        $.ajax({
                            url: '../request/subscribe_to_pack.php', // Fichier PHP qui gère l'abonnement
                            type: 'POST',
                            data: {
                                abonne_secur: abonne_secur,
                                pack_id: pack_id,
                                solde: solde,
                                date_souscription: date_souscription,
                                date_fin: date_fin
                            },
                            success: function(response) {
                                console.log('Réponse complète reçue:', response);

                                // Vérifiez que response est bien un objet
                                if (response && typeof response === 'object') {
                                    console.log('Response.success =', response.success);

                                    if (response.success === true) {
                                        console.log('Souscription réussie!');

                                        setTimeout(() => {
                                            console.log('Redirection en cours...');
                                            window.location.href = 'dashboard.php';
                                        }, 1000);
                                    } else {
                                        console.log('Échec de l\'abonnement: ', response.error || 'Erreur inconnue');
                                    }
                                } else {
                                    console.log('La réponse est mal formée :', response);
                                }
                            },
                            error: function() {
                                console.log('Erreur lors de l\'appel AJAX.');
                            }
                        });
                    }, 1000);


                }
            }, 1000);
        }
    </script>
</body>

</html>