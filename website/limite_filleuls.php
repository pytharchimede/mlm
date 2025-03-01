<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Limite de Filleuls</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-900 text-white">

    <?php include 'include/header.php'; ?>

    <div class="container mx-auto p-8">
        <div id="message" class="text-center text-xl my-4"></div>
        <div id="loader" class="text-center hidden">
            <p>Chargement...</p>
        </div>
        <div id="countdown" class="text-center text-lg my-4 hidden">
            <p>Nous allons vous trouver un parrain, veuillez patienter <span id="timer">10</span> secondes...</p>
        </div>
        <div id="filleuls-list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6 hidden">
            <!-- Liste des filleuls libres -->
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Afficher le message d'attente et lancer la vérification AJAX
            document.getElementById("message").innerHTML = "Vérification de la limite des filleuls...";
            document.getElementById("loader").classList.remove("hidden");

            // Appeler AJAX pour vérifier le nombre de filleuls du parrain
            fetch('verifier_filleuls.php')
                .then(response => response.json())
                .then(data => {
                    document.getElementById("loader").classList.add("hidden");

                    if (data.success) {
                        if (data.filleulsCount >= 5) {
                            document.getElementById("message").innerHTML = "Votre parrain a atteint la limite de 5 filleuls.";

                            // Si le parrain a atteint la limite de 5 filleuls, chercher ses filleuls n'ayant pas atteint 5 filleuls
                            fetch('filleuls_libres_de_parrain.php')
                                .then(response => response.json())
                                .then(filleulsData => {
                                    const filleulsList = document.getElementById("filleuls-list");
                                    filleulsList.innerHTML = "";

                                    if (filleulsData.success && filleulsData.filleuls.length > 0) {
                                        filleulsData.filleuls.forEach(filleul => {
                                            console.log(filleul);
                                            const div = document.createElement("div");
                                            div.classList.add("bg-gray-800", "p-6", "rounded-lg", "text-center", "shadow-lg", "hover:bg-gray-700", "transition", "duration-300");

                                            div.innerHTML = `
                                                <div class="flex flex-col items-center">
                                                    <img src="../assets/icon/user.png" alt="Profil" class="w-20 h-20 rounded-full border-2 border-gray-600">
                                                    <h3 class="text-lg font-bold mt-3">${filleul.nom_utilisateur}</h3>
                                                    <p class="text-gray-400 text-sm">${filleul.email_utilisateur}</p>
                                                    <a href="https://ifmap.ci/test/website/index.php?ref=${filleul.secur_utilisateur}" 
                                                    class="mt-4 bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-6 rounded-full shadow-md transition duration-300">
                                                        Choisir ce parrain
                                                    </a>
                                                </div>
                                            `;
                                            filleulsList.appendChild(div);
                                        });
                                        filleulsList.classList.remove("hidden");
                                    } else {
                                        document.getElementById("message").innerHTML = "Aucun filleul libre n'a été trouvé.";
                                    }
                                });
                        } else {
                            document.getElementById("message").innerHTML = "Votre parrain n'a pas encore atteint la limite de 5 filleuls.";
                        }
                    } else {
                        document.getElementById("message").innerHTML = "Une erreur est survenue lors de la vérification.";
                    }
                })
                .catch(error => {
                    console.error("Erreur:", error);
                    document.getElementById("loader").classList.add("hidden");
                    document.getElementById("message").innerHTML = "Une erreur est survenue, veuillez réessayer.";
                });
        });
    </script>

</body>

</html>