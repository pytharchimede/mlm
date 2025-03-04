<?php
include 'inc/header_admin.php';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails des Membres</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../plugins/js/fontawesome-all.min.js" crossorigin="anonymous"></script>
</head>

<body class="bg-gray-900 text-white p-5">

    <?php include 'inc/menu.php'; ?>

    <h1 class="text-3xl font-bold mb-5">Détails des Membres</h1>

    <table class="min-w-full bg-gray-800 border border-gray-700 rounded-lg">
        <thead>
            <tr class="bg-gray-700">
                <th class="p-3 border border-gray-600">Nom du Membre</th>
                <th class="p-3 border border-gray-600">Statut</th>
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

        function fetchMembers() {
            fetch('../api/api_finance.php')
                .then(response => response.json())
                .then(data => {
                    console.log(data); // Vérifier les données reçues

                    const tableBody = document.getElementById("tableBody");
                    tableBody.innerHTML = ""; // Vider le tableau avant de recharger les données

                    const utilisateursComplets = data.listeUtilisateurs; // Liste totale
                    const utilisateursActifs = data.listeUtilisateursActifs.map(user => user.secur_utilisateur); // Liste active

                    utilisateursComplets.forEach(utilisateur => {
                        const isActive = utilisateursActifs.includes(utilisateur.secur_utilisateur);
                        const statutClass = isActive ? "text-green-400" : "text-red-400";
                        const statutText = isActive ? "Actif" : "Inactif";

                        const formattedDate = formatDate(utilisateur.date_creat_utilisateur); // Formater la date

                        const row = `
                    <tr class="border border-gray-700">
                        <td class="p-3 text-center">${utilisateur.nom_utilisateur}</td>
                        <td class="p-3 text-center ${statutClass} font-bold">${statutText}</td>
                        <td class="p-3 text-center">${formattedDate}</td>
                    </tr>
                `;
                        tableBody.innerHTML += row;
                    });
                })
                .catch(error => console.error('Erreur de chargement des données:', error));
        }
        // Rafraîchir toutes les 5 secondes
        setInterval(fetchMembers, 5000);
    </script>

</body>

</html>