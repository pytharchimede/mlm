<?php
// Inclure les fichiers nécessaires pour la base de données et la classe Contact
require_once '../model/Database.php';
require_once '../model/Contact.php';

// Vous pouvez personnaliser la requête PHP ici pour obtenir les données nécessaires.
$statisticsData = Contact::getStatistics(); // Exécuter la méthode pour obtenir les statistiques
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page des Statistiques</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-900 text-white">

    <!-- Navigation -->
    <nav class="bg-gray-800 p-4">
        <div class="max-w-7xl mx-auto">
            <a href="#" class="text-2xl font-semibold text-white">Statistiques d'Invitations</a>
        </div>
    </nav>

    <!-- Statistiques -->
    <div class="max-w-7xl mx-auto p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- Nombre de contacts invités -->
            <div class="bg-gray-800 p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold">Contacts invités</h2>
                <p class="text-3xl font-semibold mt-2 invited-count"><?= $statisticsData['total_invited']; ?></p>
            </div>


            <!-- Statistiques par date -->
            <div class="bg-gray-800 p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold">Invitations aujourd'hui</h2>
                <p class="text-2xl mt-2"><?= $statisticsData['invited_today']; ?> invités aujourd'hui</p>
            </div>
        </div>

        <!-- Graphique des invitations -->
        <div class="bg-gray-800 p-6 mt-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold">Graphique des invitations</h2>
            <canvas id="invitationChart"></canvas>
        </div>

    </div>

    <!-- Script pour le graphique dynamique -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Initialiser le graphique avec les données PHP initiales
            var ctx = document.getElementById('invitationChart').getContext('2d');
            var invitationChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?= json_encode($statisticsData['labels']); ?>, // Labels dynamiques (ex: jours de la semaine)
                    datasets: [{
                        label: 'Invitations par jour',
                        data: <?= json_encode($statisticsData['data']); ?>, // Données dynamiques récupérées de PHP
                        borderColor: 'rgba(75, 192, 192, 1)',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Requête AJAX pour mettre à jour les statistiques
            function updateStatistics() {
                axios.post('get_statistics.php')
                    .then(function(response) {
                        // Log des données reçues pour débogage
                        console.log('Réponse reçue de l\'API :', response.data);

                        // Vérifier que les données sont valides avant de les utiliser
                        if (response.data && response.data.total_invited !== undefined && response.data.labels && response.data.data) {

                            // Log des objets de labels et de données pour vérifier leur structure
                            console.log('Labels reçus:', response.data.labels);
                            console.log('Données reçues:', response.data.data);

                            // Mettre à jour le nombre total d'invités
                            var invitedCountElement = document.querySelector('.invited-count');
                            if (invitedCountElement) {
                                invitedCountElement.textContent = response.data.total_invited;
                            }

                            // Mettre à jour le graphique avec les nouvelles données
                            invitationChart.data.labels = response.data.labels; // Mettre à jour les labels (ex: jours de la semaine)
                            invitationChart.data.datasets[0].data = response.data.data; // Mettre à jour les données du graphique
                            invitationChart.update(); // Rafraîchir le graphique

                        } else {
                            console.error('Données invalides reçues de l\'API', response.data);
                        }
                    })
                    .catch(function(error) {
                        console.log('Erreur lors de la mise à jour des statistiques:', error);
                    });
            }

            // Mettre à jour les statistiques toutes les 3 secondes (3000 ms)
            setInterval(updateStatistics, 3000);
        });
    </script>





</body>

</html>