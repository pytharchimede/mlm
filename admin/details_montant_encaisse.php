<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Montants Encaissés</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../plugins/js/fontawesome-all.min.js" crossorigin="anonymous"></script>
</head>

<body class="bg-gray-900 text-white p-5">

    <?php include 'inc/menu.php'; ?>

    <h1 class="text-3xl font-bold mb-5">Liste des Montants Encaissés</h1>

    <table class="min-w-full bg-gray-800 border border-gray-700 rounded-lg">
        <thead>
            <tr class="bg-gray-700">
                <th class="p-3 border border-gray-600">Nom du Membre</th>
                <th class="p-3 border border-gray-600">Montant</th>
                <th class="p-3 border border-gray-600">Date</th>
                <th class="p-3 border border-gray-600">Hash Transaction</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            <!-- Les données seront injectées ici -->
        </tbody>
    </table>

    <script>
        function fetchTransactions() {
            fetch('../api/api_finance.php')
                .then(response => response.json())
                .then(data => {
                    console.log(data); // Vérifier les données reçues

                    // Sélectionner le corps du tableau
                    const tableBody = document.getElementById("tableBody");
                    tableBody.innerHTML = ""; // Vider le tableau avant de recharger les données

                    // Récupérer les packs abonnés et les utilisateurs actifs
                    const packsAbonnes = data.listePacksAbonne;
                    const utilisateursActifs = data.listeUtilisateursActifs;

                    packsAbonnes.forEach(pack => {
                        // Trouver l'utilisateur correspondant
                        const utilisateur = utilisateursActifs.find(user => user.secur_utilisateur === pack.abonne_secur);

                        // Vérifier si on a trouvé l'utilisateur
                        if (utilisateur) {
                            const row = `
                        <tr class="border border-gray-700">
                            <td class="p-3 text-center">${utilisateur.nom_utilisateur}</td>
                            <td class="p-3 text-center text-yellow-500 font-bold">15 $</td>
                            <td class="p-3 text-center">${pack.date_souscription}</td>
                            <td class="p-3 text-center text-blue-400">${pack.transaction_hash}</td>
                        </tr>
                    `;
                            tableBody.innerHTML += row;
                        }
                    });
                })
                .catch(error => console.error('Erreur de chargement des données:', error));
        }

        // Charger les transactions toutes les 5 secondes
        fetchTransactions(); // Lancer au chargement de la page
        setInterval(fetchTransactions, 5000);
    </script>

</body>

</html>