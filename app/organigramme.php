<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organigramme de Parrainage</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white p-10 flex flex-col items-center">

    <h1 class="text-center text-3xl font-bold mb-8">👥 Organigramme de Parrainage</h1>

    <div id="organigramme" class="flex flex-col items-center space-y-4"></div>

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

            // 📌 Marraine tout en haut
            const marraineDiv = document.createElement("div");
            marraineDiv.className = "bg-purple-700 text-white rounded-lg p-4 shadow-lg w-96 text-center font-bold";
            marraineDiv.innerHTML = `
                <h2 class="text-2xl">${data.marraine.nom} (Marraine)</h2>
                <p class="text-gray-300">${data.marraine.email}</p>
                <p class="text-green-400 font-bold">Solde: ${data.marraine.solde} $</p>
                <span class="text-xs px-2 py-1 rounded bg-green-500">${data.marraine.statut}</span>
            `;
            container.appendChild(marraineDiv);

            // 📌 Trait reliant la marraine aux filleuls
            const ligneVerticale = document.createElement("div");
            ligneVerticale.className = "w-1 h-10 bg-gray-400 mx-auto";
            container.appendChild(ligneVerticale);

            // 📌 Filleuls alignés horizontalement
            const filleulsDiv = document.createElement("div");
            filleulsDiv.className = "flex space-x-4";

            data.filleuls.forEach(filleul => {
                const card = document.createElement("div");
                card.className = "bg-gray-800 rounded-lg p-4 shadow-lg w-60 text-center relative";
                card.innerHTML = `
                    <h2 class="text-xl font-bold">${filleul.nom}</h2>
                    <p class="text-sm text-gray-400">${filleul.email}</p>
                    <p class="text-green-400 font-bold">Solde: ${filleul.solde} $</p>
                    <span class="text-xs px-2 py-1 rounded ${filleul.statut === 'Actif' ? 'bg-green-500' : 'bg-red-500'}">
                        ${filleul.statut}
                    </span>
                `;
                filleulsDiv.appendChild(card);
            });

            container.appendChild(filleulsDiv);
        }

        fetchFilleuls();
    </script>

</body>

</html>