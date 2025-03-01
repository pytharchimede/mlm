<?php
session_start();
$referal_utilisateur = isset($_GET['ref']) ? $_GET['ref'] : 'REF-UNDEFINED';
$_SESSION['ref'] = $referal_utilisateur;
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMDB | L'union fait la force</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="site_css/accueil.css">
    <style>
        /* Fixer le header en haut de la page */
        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        /* Ajouter un espace sous le header pour éviter que le contenu ne soit caché */
        body {
            padding-top: 100px;
        }

        #inscription {
            background-color: #1a202c;
            /* Couleur de fond sombre */
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.3);
            /* Ombre plus douce */
            border-radius: 20px;
        }

        input,
        button {
            transition: all 0.3s ease;
        }

        input:focus,
        button:hover {
            transform: scale(1.05);
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.4);
        }

        button:active {
            transform: scale(1);
            box-shadow: none;
        }
    </style>
</head>

<body class="bg-gray-900 text-white">
    <?php include 'include/header.php'; ?>

    <section class="relative text-center py-20 px-5 bg-cover bg-center" style="background-image: url('../assets/img/community_1.jpg');">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div> <!-- Overlay sombre pour améliorer la lisibilité -->

        <div class="relative z-10">
            <h2 class="text-4xl font-bold text-white mb-4">Rejoignez la Révolution Financière</h2>
            <p class="text-lg text-gray-200 mb-6">Commencez avec seulement 15$</p>
            <a href="#inscription" class="bg-green-500 px-6 py-3 text-xl font-semibold rounded-lg">Rejoindre Maintenant</a>
        </div>
    </section>


    <section id="comment-ca-marche" class="bg-gray-800 p-10 text-center relative">
        <h2 class="text-3xl font-bold mb-4">Comment ça marche ?</h2>
        <p class="text-lg text-gray-300 mb-6">
            Découvrez les étapes simples pour commencer à investir et gagner des revenus passifs.
        </p>

        <div class="flex flex-col md:flex-row justify-center items-center space-y-4 md:space-x-10 relative z-10">
            <div class="bg-gray-700 p-6 rounded-lg w-64">
                <h3 class="text-xl font-semibold">1. Inscrivez-vous</h3>
                <p>Créez votre compte gratuitement en remplissant le formulaire.</p>
            </div>
            <div class="bg-gray-700 p-6 rounded-lg w-64">
                <h3 class="text-xl font-semibold">2. Souscrivez</h3>
                <p>Avec seulement 15$, activez vos gains.</p>
            </div>
            <div class="bg-gray-700 p-6 rounded-lg w-64">
                <h3 class="text-xl font-semibold">3. Parrainez et Gagnez</h3>
                <p>Invitez des amis pour maximiser vos gains avec notre système MLM.</p>
            </div>
            <div class="bg-gray-700 p-6 rounded-lg w-64">
                <h3 class="text-xl font-semibold">4. Profitez</h3>
                <p>Recevez vos gains et faites fructifier votre investissement.</p>
            </div>
        </div>
        <!-- <img src="assets/img/diagramme_how_it_works.png" alt="Diagramme explicatif" class="mt-6 mx-auto w-2/3"> -->
    </section>


    <section class="bg-gray-900 py-12">
        <div class="container mx-auto px-6">
            <!-- Explication du tableau -->
            <div class="mb-8 text-center text-white">
                <h2 class="text-3xl font-bold mb-4">🔢 Comment Fonctionne le Tableau des Gains ?</h2>
                <p class="text-lg text-gray-300">
                    Chaque niveau correspond au nombre de personnes dans votre réseau.
                    Plus vos filleuls recrutent, plus vous gagnez des récompenses et des cadeaux !
                </p>
            </div>

            <!-- Tableau des gains -->
            <div class="overflow-x-auto">
                <table class="w-full bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                    <thead class="bg-blue-500 text-white">
                        <tr>
                            <th class="py-4 px-6 text-lg">Niveau</th>
                            <th class="py-4 px-6 text-lg">Participants </th>
                            <th class="py-4 px-6 text-lg">Gains du Niveau </th>
                            <th class="py-4 px-6 text-lg">Gains Cumulés </th>
                            <th class="py-4 px-6 text-lg">Bonus </th>
                            <th class="py-4 px-6 text-lg">Explication</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-300 text-center">
                        <!-- Niveau 1 -->
                        <tr class="border-b border-gray-700 bg-gray-700">
                            <td class="py-4 px-6 font-bold">1️⃣</td>
                            <td class="py-4 px-6">5</td>
                            <td class="py-4 px-6">$25</td>
                            <td class="py-4 px-6">$25</td>
                            <td class="py-4 px-6">Montre + Sardines</td>
                            <td class="py-4 px-6 text-left">Dès que vous recrutez 5 personnes directement, vous recevez $25 et un cadeau.</td>
                        </tr>

                        <!-- Niveau 2 -->
                        <tr class="border-b border-gray-700">
                            <td class="py-4 px-6 font-bold">2️⃣</td>
                            <td class="py-4 px-6">25</td>
                            <td class="py-4 px-6">$100</td>
                            <td class="py-4 px-6">$125</td>
                            <td class="py-4 px-6">Sac de riz + Huile</td>
                            <td class="py-4 px-6 text-left">Si vos 5 filleuls recrutent chacun 5 personnes, vous passez au niveau 2 et recevez $100 supplémentaires.</td>
                        </tr>

                        <!-- Niveau 3 -->
                        <tr class="border-b border-gray-700 bg-gray-700">
                            <td class="py-4 px-6 font-bold">3️⃣</td>
                            <td class="py-4 px-6">125</td>
                            <td class="py-4 px-6">$500</td>
                            <td class="py-4 px-6">$625</td>
                            <td class="py-4 px-6"> Palette d'eau + Poisson</td>
                            <td class="py-4 px-6 text-left">Vos 25 filleuls du niveau 2 recrutent 5 personnes chacun, vous obtenez $500 supplémentaires.</td>
                        </tr>

                        <!-- Niveau 4 -->
                        <tr class="border-b border-gray-700">
                            <td class="py-4 px-6 font-bold">4️⃣</td>
                            <td class="py-4 px-6">625</td>
                            <td class="py-4 px-6">$3,000</td>
                            <td class="py-4 px-6">$3,625</td>
                            <td class="py-4 px-6">Pomme de terre + Poulet</td>
                            <td class="py-4 px-6 text-left">625 personnes dans votre réseau ? Bravo, vous recevez $3,000 supplémentaires !</td>
                        </tr>

                        <!-- Niveau 5 -->
                        <tr class="border-b border-gray-700 bg-gray-700">
                            <td class="py-4 px-6 font-bold">5️⃣</td>
                            <td class="py-4 px-6">3,125</td>
                            <td class="py-4 px-6">$30,000</td>
                            <td class="py-4 px-6">$33,625</td>
                            <td class="py-4 px-6"> Voyage en Tanzanie</td>
                            <td class="py-4 px-6 text-left">Si vos filleuls continuent de recruter, vous atteignez 3,125 membres et remportez $30,000 supplémentaires !</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Message d'encouragement -->
            <div class="mt-6 text-center text-white">
                <p class="text-lg font-semibold">💡 Plus vous aidez votre équipe à recruter, plus vos gains augmentent !</p>
            </div>
        </div>
    </section>



    <section class="bg-gray-900 p-10 text-center rounded-lg shadow-lg">
        <h2 class="text-4xl font-bold text-white mb-6 transform transition-transform duration-300 hover:scale-105">Investissement Unique</h2>
        <div class="packs grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-6">
            <div class="pack bg-gray-800 p-8 rounded-lg shadow-xl transform transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:cursor-pointer">
                <h3 class="text-2xl font-semibold text-white mb-4 uppercase tracking-wider">Pack Unique</h3>
                <p class="text-xl text-yellow-500 font-semibold mb-6">$15</p>
                <div class="stars flex justify-center items-center text-yellow-500">
                    ★★★★★
                </div>
                <div class="mt-4 flex justify-center">
                    <a href="#inscription">
                        <button class="bg-gray-900 text-white px-6 py-3 rounded-lg font-bold transition-all duration-300 hover:bg-gray-700 transform hover:scale-105">
                            Investir maintenant
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="inscription" class="bg-gray-900 p-12 text-center rounded-lg shadow-lg">
        <h3 class="text-3xl font-bold text-white mb-8">Créez votre compte dès aujourd'hui</h3>
        <form id="inscriptionForm" class="max-w-lg mx-auto space-y-6">
            <!-- Champ Référent Utilisateur -->
            <div class="flex items-center space-x-4">
                <label for="referal_utilisateur" class="w-40 text-left text-gray-300">Référent :</label>
                <input type="text" id="referal_utilisateur" value="<?php echo $referal_utilisateur ?>" class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white" readonly>
            </div>

            <!-- Champ Nom Complet -->
            <div class="flex items-center space-x-4">
                <label for="nom" class="w-40 text-left text-gray-300">Nom complet :</label>
                <input type="text" name="nom" id="nom" placeholder="Nom complet" class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white" required>
            </div>

            <!-- Champ Email -->
            <div class="flex items-center space-x-4">
                <label for="email" class="w-40 text-left text-gray-300">Email :</label>
                <input type="email" name="email" id="email" placeholder="Email" class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white" required>
            </div>

            <!-- Champ Mot de Passe -->
            <div class="flex items-center space-x-4">
                <label for="mot_de_passe" class="w-40 text-left text-gray-300">Mot de passe :</label>
                <input type="password" name="mot_de_passe" id="mot_de_passe" placeholder="Mot de passe" class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white" required>
            </div>

            <!-- Champ Confirmer Mot de Passe -->
            <div class="flex items-center space-x-4">
                <label for="confirmer_mot_de_passe" class="w-40 text-left text-gray-300">Confirmer mot de passe :</label>
                <input type="password" name="confirmer_mot_de_passe" id="confirmer_mot_de_passe" placeholder="Confirmer le mot de passe" class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white" required>
            </div>

            <!-- Bouton d'inscription -->
            <button type="submit" class="w-full py-3 rounded-lg text-lg bg-indigo-600 hover:bg-indigo-700 text-white transition">S'inscrire</button>

            <!-- Lien vers la page de connexion -->
            <p class="mt-4 text-gray-400">Déjà un compte ? <a href="../login.php" class="text-blue-400 hover:underline">Connectez-vous</a></p>
        </form>
    </section>

    <footer class="bg-gray-800 p-5 text-center mt-10">
        <p class="text-gray-400">&copy; 2025 CMDB. Tous droits réservés.</p>
    </footer>
    <script>
        document.getElementById("inscriptionForm").addEventListener("submit", function(event) {
            event.preventDefault(); // Empêche le formulaire de se soumettre de manière traditionnelle

            var formData = new FormData(this); // Récupère les données du formulaire

            // Vérifier que les mots de passe correspondent
            if (formData.get("mot_de_passe") !== formData.get("confirmer_mot_de_passe")) {
                alert("Les mots de passe ne correspondent pas.");
                return;
            }

            console.log('Données soumises : ' + formData);

            // Envoyer la requête AJAX
            fetch("../request/insert_utilisateur.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Inscription réussie. Un email de confirmation a été envoyé.");
                        console.log(data);
                        window.location.href = "success_register.php"; // Redirige vers la page de succès
                    } else {
                        if (data.message && data.message.includes("Vous avez atteint la limite de 5 filleuls")) {
                            // Si le message d'erreur indique que le parrain a atteint la limite de filleuls
                            alert(data.message); // Affiche l'erreur
                            window.location.href = "limite_filleuls.php"; // Redirige vers la page où il est informé de la limite
                        } else {
                            console.log(data); // Affiche l'erreur dans la console
                            alert("Erreur lors de l'inscription. Essayez à nouveau.");
                        }
                    }
                })
                .catch(error => {
                    console.error("Erreur:", error);
                    alert("Une erreur est survenue. Veuillez réessayer.");
                });
        });
    </script>

</body>

</html>