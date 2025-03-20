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
                <th class="p-3 border border-gray-600">Adresse du portefeuille BNB</th>
                <th class="p-3 border border-gray-600">Actions</th>
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
                    // console.log(data); // Vérifier les données reçues

                    const tableBody = document.getElementById("tableBody");
                    tableBody.innerHTML = ""; // Vider le tableau avant de recharger les données

                    const demandesRetrait = data.demandesRetrait;
                    const listePackAbonne = data.listePacksAbonne;
                    const listeUtilisateursActifs = data.listeUtilisateursActifs;

                    if (!demandesRetrait || demandesRetrait.length === 0) {
                        tableBody.innerHTML = `<tr><td colspan="4" class="p-3 text-center text-gray-400">Aucune demande de retrait trouvée.</td></tr>`;
                        return;
                    }

                    demandesRetrait.forEach(demande => {

                        // Trouver le pack correspondant
                        const pack = listePackAbonne.find(p => p.id_pack_abonne === demande.pack_abonne_id);


                        if (pack) {
                            // Trouver l'utilisateur correspondant
                            const utilisateur = listeUtilisateursActifs.find(user => user.secur_utilisateur === pack.abonne_secur);

                            if (utilisateur) {
                                const row = `
                                <tr class="border border-gray-700">
                                    <td class="p-3 text-center">${utilisateur.nom_utilisateur}</td>
                                    <td class="p-3 text-center text-red-500 font-bold">${demande.montant_demande_retrait} FCFA</td>
                                    <td class="p-3 text-center">${demande.date_demande_retrait || 'Non spécifié'}</td>
                                    <td class="p-3 text-center text-blue-400">${utilisateur.bnb_wallet_address || 'Non disponible'}</td>
                                    <td class="p-3 text-center flex space-x-2 justify-center">
                                            <!-- Bouton Décaisser -->
                                            <a href="../request/valid_demande_retrait.php?id_demande_retrait=${demande.id_demande_retrait}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-3 rounded flex items-center">
                                                <i class="fas fa-check-circle mr-2"></i> Décaisser
                                            </a>
                                                &nbsp;
                                            <!-- Bouton Refuser -->
                                            <a href="../request/refuse_demande_retrait.php?id_demande_retrait=${demande.id_demande_retrait}" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-3 rounded flex items-center">
                                                <i class="fas fa-times-circle mr-2"></i> Refuser
                                            </a>
                                    </td>
                                </tr>
                            `;
                                tableBody.innerHTML += row;
                            }
                        }
                    });
                })
                .catch(error => console.error('Erreur de chargement des données:', error));
        }

        // Charger les retraits au chargement de la page
        fetchWithdrawals();
    </script>



</body>

</html>