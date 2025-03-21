<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organigramme de Parrainage</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-gray-900 to-gray-800 text-white p-6 flex flex-col items-center">

    <!-- Bouton Retour -->
    <div class="w-full flex justify-start">
        <a href="dashboard.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 shadow-md transition-transform transform hover:scale-105">
            ⬅ Retour à l'accueil
        </a>
    </div>

    <h1 class="text-center text-4xl font-extrabold mb-6 text-green-400">👥 Organigramme de Parrainage</h1>

    <div id="organigramme" class="flex flex-col items-center space-y-6 w-full overflow-auto px-4"></div>

    <script>
        async function fetchFilleuls() {
            try {
                const response = await fetch('../request/get_filleuls.php');
                const data = await response.json();

                if (data.error) {
                    document.getElementById("organigramme").innerHTML = `<p class='text-red-500'>${data.error}</p>`;
                    return;
                }

                afficherOrganigramme(data);
            } catch (error) {
                console.error("Erreur de récupération des données:", error);
            }
        }

        function afficherOrganigramme(data) {
            const container = document.getElementById("organigramme");
            container.innerHTML = '';

            // Marraine principale
            const marraineDiv = document.createElement("div");
            marraineDiv.className = "bg-purple-700 text-white rounded-lg p-6 shadow-xl w-80 text-center font-bold border-4 border-purple-500 transform transition hover:scale-105";
            marraineDiv.innerHTML = `
                <h2 class="text-3xl">${data.marraine.nom} (Marraine)</h2>
                <p class="text-gray-300">${data.marraine.email}</p>
                <p class="text-green-300 font-bold">Solde: ${data.marraine.solde} $</p>
                <span class="text-xs px-3 py-1 rounded-full bg-green-500">${data.marraine.statut}</span>
            `;
            container.appendChild(marraineDiv);

            // Effectif total
            const effectifDiv = document.createElement("div");
            effectifDiv.className = "text-lg font-bold text-gray-300 mt-3";
            effectifDiv.innerHTML = `Effectif total du réseau : <span class="text-green-400">${data.effectif_reseau}</span>`;
            container.appendChild(effectifDiv);

            // Trait vertical
            const ligneVerticale = document.createElement("div");
            ligneVerticale.className = "w-1 h-8 bg-gray-400 mx-auto";
            container.appendChild(ligneVerticale);

            // Filleuls de niveau 2
            const filleulsDiv = document.createElement("div");
            filleulsDiv.className = "flex flex-wrap justify-center gap-6 max-w-full";

            data.filleuls_niveau2.forEach(filleul => {
                const card = document.createElement("div");
                const nbFilleuls = data.filleuls_niveau3.filter(f => f.referal === filleul.secur).length;
                card.className = "bg-gray-800 rounded-lg p-6 shadow-lg w-60 text-center border border-gray-600 transform transition hover:scale-105 hover:border-green-400";
                card.innerHTML = `
                    <h2 class="text-xl font-bold text-green-300">${filleul.nom}</h2>
                    <p class="text-sm text-gray-400">${filleul.email}</p>
                    <p class="text-green-400 font-bold">Solde: ${filleul.solde} $</p>
                    <p class="text-sm text-gray-400"><b>${nbFilleuls}</b> filleuls directs</p>
                    <span class="text-xs px-3 py-1 rounded-full ${filleul.statut === 'Actif' ? 'bg-green-500' : 'bg-red-500'}">
                        ${filleul.statut}
                    </span>
                `;

                // Ajouter les filleuls de niveau 3 de ce parrain
                const subFilleuls = data.filleuls_niveau3.filter(f => f.referal === filleul.secur);
                if (subFilleuls.length > 0) {
                    const subList = document.createElement("ul");
                    subList.className = "mt-3 text-sm text-gray-300";
                    subList.innerHTML = `<b>Filleuls directs :</b>`;
                    subFilleuls.forEach(sub => {
                        const nbFilleulsSub = data.filleuls_niveau4.filter(f => f.referal === sub.secur).length;
                        const li = document.createElement("li");
                        li.innerHTML = `${sub.nom} - ${nbFilleulsSub} Filleuls - <span class="text-green-400 font-bold">${sub.solde} $</span>`;
                        subList.appendChild(li);
                    });
                    card.appendChild(subList);
                }

                filleulsDiv.appendChild(card);
            });

            container.appendChild(filleulsDiv);
        }

        fetchFilleuls();
    </script>
</body>

</html>