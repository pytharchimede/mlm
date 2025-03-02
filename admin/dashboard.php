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

                console.log(data); // Ajoutez cette ligne pour vérifier les données reçues

                // Vérification et assignation des valeurs par défaut si null ou NaN
                let montantEncaisses = data.montantEncaisses ?? 0;
                let montantReverser = data.montantTotalAReverser ?? 0;
                let chiffreAffaire = montantEncaisses - montantReverser;

                let demandesRetraitCount = data.demandesRetrait?.length ?? 0;
                let nombreTotalDeMembres = data.listeUtilisateurs?.length ?? 0;
                let nombreDeMembresActifs = data.listeUtilisateursActifs?.length ?? 0;
                let tauxDeConversion = nombreTotalDeMembres > 0 ?
                    ((nombreDeMembresActifs / nombreTotalDeMembres) * 100).toFixed(2) :
                    0;

                // Mise à jour des valeurs dans l'interface
                document.getElementById('montant_encaisse').innerText = montantEncaisses + " $";
                document.getElementById('montant_reverser').innerText = montantReverser + " $";
                document.getElementById('chiffre_affaire').innerText = (montantEncaisses - montantReverser) + " $";
                document.getElementById('demande_retrait').innerText = demandesRetraitCount;
                document.getElementById('membres_total').innerText = nombreTotalDeMembres;
                document.getElementById('membres_actifs').innerText = nombreDeMembresActifs;
                document.getElementById('taux_conversion').innerText = tauxDeConversion + " %";

                // Mise à jour des trois premières cartes
                let cards = document.querySelectorAll('.grid div p.font-bold');
                cards[0].innerText = montantEncaisses + " $"; // Montant Encaissé
                cards[1].innerText = montantReverser + " $"; // Montant à Reverser
                cards[2].innerText = (montantEncaisses - montantReverser) + " $"; // Chiffre d'Affaires

                updateChart(data.montantEncaisses);

            } catch (error) {
                console.error("Erreur lors de la récupération des données :", error);
            }
        }

        function updateChart(montant) {
            montantsChart.data.datasets[0].data.push(montant);
            if (montantsChart.data.datasets[0].data.length > 12) {
                montantsChart.data.datasets[0].data.shift();
            }
            montantsChart.update();
        }

        const ctx = document.getElementById('montantsChart').getContext('2d');
        const montantsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
                datasets: [{
                    label: 'Montants Encaissés',
                    data: [],
                    borderColor: 'rgba(255, 159, 64, 1)',
                    fill: false,
                }]
            },
        });

        fetchData();
        setInterval(fetchData, 5000);

        // Menu mobile
        document.getElementById('hamburgerBtn').addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('hidden');
        });
    </script>
</body>

</html>