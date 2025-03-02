<?php
include 'inc/header_admin.php';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utilisateurs Actifs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../plugins/js/fontawesome-all.min.js" crossorigin="anonymous"></script>
</head>

<body class="bg-gray-900 text-white p-5">

    <?php include 'inc/menu.php'; ?>

    <h1 class="text-3xl font-bold mb-5">Liste des Utilisateurs Actifs</h1>

    <table class="min-w-full bg-gray-800 border border-gray-700 rounded-lg">
        <thead>
            <tr class="bg-gray-700">
                <th class="p-3 border border-gray-600">Nom du Membre</th>
                <th class="p-3 border border-gray-600">Date d'Adhésion</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            <!-- Les données seront injectées ici -->
        </tbody>
    </table>

    <script>
        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('fr-FR', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
        }

        function fetchActiveMembers() {
            fetch('../api/api_finance.php')
                .then(response => response.json())
                .then(data => {
                    console.log(data); // Vérifier les données reçues

                    const tableBody = document.getElementById("tableBody");
                    tableBody.innerHTML = ""; // Vider le tableau avant de recharger les données

                    const utilisateursActifs = data.listeUtilisateursActifs;

                    utilisateursActifs.forEach(utilisateur => {
                        const formattedDate = formatDate(utilisateur.date_creat_utilisateur);

                        const row = `
                            <tr class="border border-gray-700">
                                <td class="p-3 text-center">${utilisateur.nom_utilisateur}</td>
                                <td class="p-3 text-center">${formattedDate}</td>
                            </tr>
                        `;
                        tableBody.innerHTML += row;
                    });
                })
                .catch(error => console.error('Erreur de chargement des données:', error));
        }

        // Charger la liste immédiatement
        fetchActiveMembers();

        // Rafraîchir toutes les 5 secondes
        setInterval(fetchActiveMembers, 5000);
    </script>

</body>

</html>