<?php
include 'inc/header_admin.php';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Montants à Reverser</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../plugins/js/fontawesome-all.min.js" crossorigin="anonymous"></script>
</head>

<body class="bg-gray-900 text-white p-5">

    <?php include 'inc/menu.php'; ?>

    <h1 class="text-3xl font-bold mb-5">Liste des Montants à Reverser</h1>

    <table class="min-w-full bg-gray-800 border border-gray-700 rounded-lg">
        <thead>
            <tr class="bg-gray-700">
                <th class="p-3 border border-gray-600">Nom du Membre</th>
                <th class="p-3 border border-gray-600">Montant</th>
                <th class="p-3 border border-gray-600">Date</th>
                <th class="p-3 border border-gray-600">Transaction ID</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            <!-- Les données seront injectées ici -->
        </tbody>
    </table>

    <script>
        function fetchWithdrawals() {
            fetch('../api/api_finance.php')
                .then(response => response.json())
                .then(data => {
                    console.log(data); // Vérifier les données reçues

                    const tableBody = document.getElementById("tableBody");
                    tableBody.innerHTML = ""; // Vider le tableau avant de recharger les données

                    const demandesRetrait = data.demandesRetrait;
                    const utilisateursActifs = data.listeUtilisateursActifs;

                    demandesRetrait.forEach(demande => {
                        // Trouver l'utilisateur correspondant
                        const utilisateur = utilisateursActifs.find(user => user.secur_utilisateur === demande.abonne_secur);

                        if (utilisateur) {
                            const row = `
                                <tr class="border border-gray-700">
                                    <td class="p-3 text-center">${utilisateur.nom_utilisateur}</td>
                                    <td class="p-3 text-center text-red-500 font-bold">${demande.montant} FCFA</td>
                                    <td class="p-3 text-center">${demande.date_demande}</td>
                                    <td class="p-3 text-center text-blue-400">${demande.transaction_id}</td>
                                </tr>
                            `;
                            tableBody.innerHTML += row;
                        }
                    });
                })
                .catch(error => console.error('Erreur de chargement des données:', error));
        }

        // Charger les retraits toutes les 5 secondes
        fetchWithdrawals(); // Lancer au chargement de la page
        setInterval(fetchWithdrawals, 5000);
    </script>

</body>

</html>