<?php
include 'inc/header_admin.php';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques des Visites</title>

    <!-- Inclure Tailwind CSS et Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Arial', sans-serif;
        }

        canvas {
            max-width: 100%;
            height: 400px;
        }

        /* Conteneur du tableau avec défilement horizontal */
        .table-container {
            overflow-x: auto;
            max-width: 100%;
        }

        /* Limitation de la largeur des colonnes pour le tableau */
        #visites-table {
            table-layout: fixed;
        }

        #visites-table th,
        #visites-table td {
            max-width: 150px;
            /* Ajuste la largeur des cellules */
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Adaptation de la taille du tableau aux petits écrans */
        @media (max-width: 768px) {
            #visites-table {
                font-size: 12px;
                /* Réduit la taille de la police */
            }
        }
    </style>

</head>

<body class="bg-gray-900 text-white">
    <?php include 'inc/menu.php'; ?>

    <!-- Conteneur principal -->
    <div class="container mx-auto p-8 space-y-8 bg-gray-800 rounded-lg shadow-lg">

        <!-- Titre principal -->
        <div class="text-center">
            <h1 class="text-5xl font-semibold text-indigo-500 mb-4">Statistiques des Visites</h1>
            <p class="text-lg text-gray-300">Analyse détaillée des visites sur votre site</p>
        </div>

        <!-- Statistiques générales -->
        <div class="bg-gray-700 p-6 rounded-lg shadow-md">
            <h2 class="text-2xl text-center mb-6">Résumé des Visites</h2>
            <div class="flex justify-between items-center">
                <div class="text-center">
                    <h3 class="text-xl text-gray-300">Total des Visites</h3>
                    <p class="text-3xl font-semibold text-green-400" id="total_visites">0</p>
                </div>
                <div class="text-center">
                    <h3 class="text-xl text-gray-300">Visites par Pays</h3>
                    <p class="text-3xl font-semibold text-blue-400" id="pays_count">0 Pays</p>
                </div>
            </div>
        </div>

        <!-- Graphiques -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-gray-700 p-6 rounded-lg shadow-md">
                <h3 class="text-2xl mb-4">Visites par Pays</h3>
                <canvas id="graph-pays"></canvas>
            </div>
            <div class="bg-gray-700 p-6 rounded-lg shadow-md">
                <h3 class="text-2xl mb-4">Visites par Navigateur</h3>
                <canvas id="graph-navigateur"></canvas>
            </div>
        </div>

        <!-- Tableau des visites -->
        <div class="table-container">
            <h3 class="text-2xl mb-4">Tableau des Visites</h3>
            <table id="visites-table" class="display table-auto w-full text-sm text-left text-gray-300">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">IP</th>
                        <th class="px-4 py-2">User Agent</th>
                        <th class="px-4 py-2">Système</th>
                        <th class="px-4 py-2">Navigateur</th>
                        <th class="px-4 py-2">Latitude</th>
                        <th class="px-4 py-2">Longitude</th>
                        <th class="px-4 py-2">Pays</th>
                        <th class="px-4 py-2">Ville</th>
                        <th class="px-4 py-2">Page Visité</th>
                        <th class="px-4 py-2">Referer</th>
                        <th class="px-4 py-2">Date Visite</th>
                    </tr>
                </thead>
                <tbody id="visites-tbody">
                    <!-- Les données seront ajoutées dynamiquement ici -->
                </tbody>
            </table>
        </div>

    </div>

    <!-- Script pour graphiques et DataTables -->
    <script>
        function updateData() {
            $.ajax({
                url: '../api/api_visites.php', // L'URL de l'API
                method: 'GET',
                success: function(data) {
                    console.log(data); // Afficher les données dans la console pour le débogage
                    // Mettre à jour les statistiques générales
                    $('#total_visites').text(data.total_visites);
                    $('#pays_count').text(Object.keys(data.statistiques_pays).length + ' Pays');

                    // Mettre à jour les graphiques
                    updateCharts(data.statistiques_pays, data.statistiques_navigateur);

                    // Mettre à jour le tableau
                    updateTable(data.visites);
                }
            });
        }

        function updateCharts(statistiques_pays, statistiques_navigateur) {
            // Mettre à jour le graphique des visites par pays
            if (window.graphPays) {
                window.graphPays.data.labels = Object.keys(statistiques_pays); // Mise à jour des labels
                window.graphPays.data.datasets[0].data = Object.values(statistiques_pays); // Mise à jour des données
                window.graphPays.update(); // Appliquer les changements sans reconstruire
            } else {
                // Si le graphique n'existe pas encore, on le crée
                var ctx1 = document.getElementById('graph-pays').getContext('2d');
                window.graphPays = new Chart(ctx1, {
                    type: 'pie',
                    data: {
                        labels: Object.keys(statistiques_pays),
                        datasets: [{
                            label: 'Visites par Pays',
                            data: Object.values(statistiques_pays),
                            backgroundColor: ['#FF5733', '#33FF57', '#3357FF', '#FF33A8', '#F4D03F'],
                            borderColor: '#fff',
                            borderWidth: 1
                        }]
                    }
                });
            }

            // Mettre à jour le graphique des visites par navigateur
            if (window.graphNavigateur) {
                window.graphNavigateur.data.labels = Object.keys(statistiques_navigateur); // Mise à jour des labels
                window.graphNavigateur.data.datasets[0].data = Object.values(statistiques_navigateur); // Mise à jour des données
                window.graphNavigateur.update(); // Appliquer les changements sans reconstruire
            } else {
                // Si le graphique n'existe pas encore, on le crée
                var ctx2 = document.getElementById('graph-navigateur').getContext('2d');
                window.graphNavigateur = new Chart(ctx2, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(statistiques_navigateur),
                        datasets: [{
                            label: 'Visites par Navigateur',
                            data: Object.values(statistiques_navigateur),
                            backgroundColor: '#4CAF50',
                            borderColor: '#fff',
                            borderWidth: 1
                        }]
                    }
                });
            }
        }

        function updateTable(visites) {
            var tbody = $('#visites-tbody');
            tbody.empty();
            visites.forEach(function(visite) {
                tbody.append('<tr class="bg-gray-700 hover:bg-gray-600">' +
                    '<td class="px-4 py-2">' + visite.id + '</td>' +
                    '<td class="px-4 py-2">' + visite.ip + '</td>' +
                    '<td class="px-4 py-2">' + visite.user_agent + '</td>' +
                    '<td class="px-4 py-2">' + visite.os + '</td>' +
                    '<td class="px-4 py-2">' + visite.navigateur + '</td>' +
                    '<td class="px-4 py-2">' + visite.latitude + '</td>' +
                    '<td class="px-4 py-2">' + visite.longitude + '</td>' +
                    '<td class="px-4 py-2">' + visite.pays + '</td>' +
                    '<td class="px-4 py-2">' + visite.ville + '</td>' +
                    '<td class="px-4 py-2">' + visite.url_page + '</td>' +
                    '<td class="px-4 py-2">' + visite.referer + '</td>' +
                    '<td class="px-4 py-2">' + visite.date_visite + '</td>' +
                    '</tr>');
            });
        }

        // Actualiser toutes les 3 secondes
        setInterval(updateData, 3000);

        // Charger initialement les données
        updateData();
    </script>
</body>

</html>