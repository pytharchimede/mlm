<?php
include 'inc/header_admin.php';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Pour les graphiques -->
    <script src="../plugins/js/fontawesome-all.min.js" crossorigin="anonymous"></script>
</head>

<body class="bg-gray-800">

    <?php include 'inc/menu.php'; ?>
    <!-- Contenu principal -->
    <div class="p-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-5">

            <a href="details_montant_encaisse.php" class="block">
                <div class="bg-gray-700 p-6 rounded-lg shadow-lg text-center hover:bg-gray-600 transition">
                    <h3 class="text-xl text-white">Montant Encaissé</h3>
                    <p class="text-3xl text-yellow-500 font-bold" id="montant_encaisse"></p>
                </div>
            </a>

            <a href="details_montant_reverser.php" class="block">
                <div class="bg-gray-700 p-6 rounded-lg shadow-lg text-center hover:bg-gray-600 transition">
                    <h3 class="text-xl text-white">Montant à Reverser</h3>
                    <p class="text-3xl text-yellow-500 font-bold" id="montant_reverser"></p>
                </div>
            </a>

            <a href="javascript:void();" class="block">
                <div class="bg-gray-700 p-6 rounded-lg shadow-lg opacity-50 cursor-not-allowed">
                    <h3 class="text-xl text-white">Chiffre d'Affaires</h3>
                    <p class="text-3xl text-yellow-500 font-bold" id="chiffre_affaire"></p>
                </div>
            </a>

            <a href="javascript:void();" class="block">
                <div class="bg-gray-700 p-6 rounded-lg shadow-lg opacity-50 cursor-not-allowed">
                    <h3 class="text-xl text-white">Demandes de retrait</h3>
                    <p class="text-3xl text-yellow-500 font-bold" id="demande_retrait"></p>
                </div>
            </a>

            <a href="details_cadeaux_a_distribuer.php" class="block">
                <div class="bg-gray-700 p-6 rounded-lg shadow-lg text-center hover:bg-gray-600 transition">
                    <h3 class="text-xl text-white">Cadeaux à distribuer</h3>
                    <p class="text-3xl text-yellow-500 font-bold" id="cadeau_a_distribuer">0</p>
                </div>
            </a>

            <a href="details_cadeaux_distribues.php" class="block">
                <div class="bg-gray-700 p-6 rounded-lg shadow-lg text-center hover:bg-gray-600 transition">
                    <h3 class="text-xl text-white">Cadeaux distribués</h3>
                    <p class="text-3xl text-yellow-500 font-bold" id="cadeaux_distribues">0</p>
                </div>
            </a>

            <a href="details_membres.php" class="block">
                <div class="bg-gray-700 p-6 rounded-lg shadow-lg text-center hover:bg-gray-600 transition">
                    <h3 class="text-xl text-white">Membres</h3>
                    <p class="text-3xl text-yellow-500 font-bold" id="membres_total"></p>
                </div>
            </a>

            <a href="details_membres_actifs.php" class="block">
                <div class="bg-gray-700 p-6 rounded-lg shadow-lg text-center hover:bg-gray-600 transition">
                    <h3 class="text-xl text-white">Membres actifs</h3>
                    <p class="text-3xl text-yellow-500 font-bold" id="membres_actifs"></p>
                </div>
            </a>

            <a href="javascript:void();" class="block">
                <div class="bg-gray-700 p-6 rounded-lg shadow-lg opacity-50 cursor-not-allowed">
                    <h3 class="text-xl text-white">Taux de conversion</h3>
                    <p class="text-3xl text-yellow-500 font-bold" id="taux_conversion"></p>
                </div>
            </a>

        </div>

        <div class="mt-10">
            <canvas id="montantsChart"></canvas>
        </div>
    </div>


    <script>
        async function fetchData() {
            try {
                let response = await fetch('../api/api_finance.php');
                let data = await response.json();

                console.log("Données récupérées :", data);

                // Vérification et assignation des valeurs par défaut si null ou NaN
                let montantEncaisses = isNaN(data.montantEncaisses) ? 0 : data.montantEncaisses;
                let montantReverser = isNaN(data.montantTotalAReverser) ? 0 : data.montantTotalAReverser;
                let chiffreAffaire = montantEncaisses - montantReverser;

                let demandesRetraitCount = Array.isArray(data.demandesRetrait) ? data.demandesRetrait.length : 0;
                let nombreTotalDeMembres = Array.isArray(data.listeUtilisateurs) ? data.listeUtilisateurs.length : 0;
                let nombreDeMembresActifs = Array.isArray(data.listeUtilisateursActifs) ? data.listeUtilisateursActifs.length : 0;
                let tauxDeConversion = nombreTotalDeMembres > 0 ? ((nombreDeMembresActifs / nombreTotalDeMembres) * 100).toFixed(2) : 0;

                // Mise à jour des valeurs dans l'interface
                document.getElementById('montant_encaisse').innerText = montantEncaisses + " $";
                document.getElementById('montant_reverser').innerText = montantReverser + " $";
                document.getElementById('chiffre_affaire').innerText = chiffreAffaire + " $";
                document.getElementById('demande_retrait').innerText = demandesRetraitCount;
                document.getElementById('membres_total').innerText = nombreTotalDeMembres;
                document.getElementById('membres_actifs').innerText = nombreDeMembresActifs;
                document.getElementById('taux_conversion').innerText = tauxDeConversion + " %";

                // Mise à jour des cartes
                let cards = document.querySelectorAll('.grid div p.font-bold');
                if (cards.length >= 3) {
                    cards[0].innerText = montantEncaisses + " $"; // Montant Encaissé
                    cards[1].innerText = montantReverser + " $"; // Montant à Reverser
                    cards[2].innerText = chiffreAffaire + " $"; // Chiffre d'Affaires
                }

                // Création des dailyMontants si absents
                let dailyMontants = generateDailyMontants(data.listePacksAbonne);

                // Mise à jour du graphe
                updateChart(dailyMontants);

            } catch (error) {
                console.error("Erreur lors de la récupération des données :", error);
            }
        }

        // Fonction pour générer les dailyMontants en fonction des abonnements
        function generateDailyMontants(listePacksAbonne) {
            let dailyMontants = [];
            let now = new Date();
            let today = now.toLocaleDateString('fr-FR');

            // Regarde combien de jours se sont écoulés depuis la première souscription
            let firstSubscriptionDate = new Date(listePacksAbonne[0]?.date_souscription);
            let daysSinceFirstSubscription = Math.floor((now - firstSubscriptionDate) / (1000 * 3600 * 24));

            // Parcours chaque jour depuis la première souscription jusqu'à aujourd'hui
            for (let i = 0; i <= daysSinceFirstSubscription; i++) {
                let currentDate = new Date(firstSubscriptionDate);
                currentDate.setDate(currentDate.getDate() + i);
                let formattedDate = currentDate.toLocaleDateString('fr-FR');

                // Cherche si un abonnement a eu lieu ce jour-là
                let montantDuJour = 0;
                listePacksAbonne.forEach(pack => {
                    let subscriptionDate = new Date(pack.date_souscription);
                    if (subscriptionDate.toLocaleDateString('fr-FR') === formattedDate) {
                        montantDuJour = parseFloat(montantDuJour) + 15; // Assurez-vous d'utiliser le montant du pack pour ce jour
                    }
                });

                dailyMontants.push({
                    date: formattedDate,
                    montant: montantDuJour
                });
            }

            return dailyMontants;
        }

        function updateChart(dailyData) {
            let formattedDates = [];
            let montants = [];

            // Si dailyData est un tableau de montants par jour
            dailyData.forEach(item => {
                formattedDates.push(item.date); // Format de la date
                montants.push(item.montant); // Montant pour chaque jour
            });

            if (montantsChart.data.labels.length >= 30) { // Limitez à 30 jours si nécessaire
                montantsChart.data.labels.shift();
                montantsChart.data.datasets[0].data.shift();
            }

            // Ajoutez les nouvelles dates et montants
            montantsChart.data.labels = [...formattedDates];
            montantsChart.data.datasets[0].data = [...montants];
            montantsChart.update();
        }

        // Initialisation du graphe
        const ctx = document.getElementById('montantsChart').getContext('2d');
        const montantsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [], // Les dates seront insérées ici
                datasets: [{
                    label: 'Montants Encaissés',
                    data: [], // Les montants seront insérés ici
                    borderColor: 'rgba(255, 159, 64, 1)',
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Chargement initial et mise à jour toutes les 5 secondes
        fetchData();
        setInterval(fetchData, 5000);
    </script>


</body>

</html>