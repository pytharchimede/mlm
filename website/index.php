<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finova | Investissez en ligne</title>
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
    </style>
</head>

<body class="bg-gray-900 text-white">
    <header class="bg-gray-800 p-5 flex justify-between items-center">
        <img id="logo" src="../assets/img/source_plan_clair_petit.png" class="w-32">
        <a href="#inscription" class="bg-blue-500 px-4 py-2 rounded-lg">S'inscrire</a>
    </header>

    <section class="text-center py-20 px-5">
        <h2 class="text-4xl font-bold mb-4">Investissez dans la Crypto & Développez Votre Réseau</h2>
        <p class="text-lg text-gray-300 mb-6">Gagnez des revenus passifs grâce à notre plateforme de trading avec MLM. Rejoignez-nous et maximisez vos gains !</p>
        <a href="#inscription" class="bg-green-500 px-6 py-3 text-xl font-semibold rounded-lg">Rejoindre Maintenant</a>
    </section>

    <section id="comment-ca-marche" class="bg-gray-800 p-10 text-center relative">
        <h2 class="text-3xl font-bold mb-4">Comment ça marche ?</h2>
        <p class="text-lg text-gray-300 mb-6">Découvrez les étapes simples pour commencer à investir et gagner des revenus passifs.</p>

        <!-- Vidéo avec effet Parallax -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden">
            <video autoplay muted loop class="w-full h-full object-cover parallax-video">
                <source src="../assets/video/explication_video.mp4" type="video/mp4">
                Votre navigateur ne supporte pas la balise vidéo.
            </video>
        </div>

        <div class="flex flex-col md:flex-row justify-center items-center space-y-4 md:space-x-10 relative z-10">
            <div class="bg-gray-700 p-6 rounded-lg w-64">
                <h3 class="text-xl font-semibold">1. Inscrivez-vous</h3>
                <p>Créez votre compte gratuitement en remplissant le formulaire.</p>
            </div>
            <div class="bg-gray-700 p-6 rounded-lg w-64">
                <h3 class="text-xl font-semibold">2. Choisissez un Pack</h3>
                <p>Investissez dans l'un de nos packs selon vos objectifs financiers.</p>
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

    <section class="bg-gray-900 p-10 text-center">
        <h2 class="text-3xl font-bold mb-4">Nos packs d'investissement</h2>
        <div class="packs grid grid-cols-2 md:grid-cols-3 gap-6">
            <div class="pack bg-gray-700 p-4 rounded" data-pack="Basic 1">
                <!-- <div class="icon">✨</div> -->
                <h2>Miner Basic 1</h2>
                <p>6 000 FCFA</p>
                <div class="stars">
                    ★★★☆☆
                </div>
            </div>
            <div class="pack bg-gray-700 p-4 rounded" data-pack="Basic 2">
                <!-- <div class="icon">🚀</div> -->
                <h2>Miner Basic 2</h2>
                <p>8 000 FCFA</p>
                <div class="stars">
                    ★★★★☆
                </div>
            </div>
            <div class="pack bg-gray-700 p-4 rounded" data-pack="Basic 3">
                <!-- <div class="icon">🔥</div> -->
                <h2>Miner Basic 3</h2>
                <p>10 000 FCFA</p>
                <div class="stars">
                    ★★★★★
                </div>
            </div>
            <div class="pack bg-gray-700 p-4 rounded" data-pack="Basic 4">
                <!-- <div class="icon">💎</div> -->
                <h2>Miner Basic 4</h2>
                <p>15 000 FCFA</p>
                <div class="stars">
                    ★★★★★
                </div>
            </div>
            <div class="pack bg-gray-700 p-4 rounded" data-pack="Pro 1">
                <!-- <div class="icon">🌟</div> -->
                <h2>Miner Pro 1</h2>
                <p>30 000 FCFA</p>
                <div class="stars">
                    ★★★★★
                </div>
            </div>
            <div class="pack bg-gray-700 p-4 rounded" data-pack="Pro 2">
                <!-- <div class="icon">💼</div> -->
                <h2>Miner Pro 2</h2>
                <p>60 000 FCFA</p>
                <div class="stars">
                    ★★★★★
                </div>
            </div>
            <div class="pack bg-gray-700 p-4 rounded" data-pack="Pro 3">
                <!-- <div class="icon">🏆</div> -->
                <h2>Miner Pro 3</h2>
                <p>100 000 FCFA</p>
                <div class="stars">
                    ★★★★★
                </div>
            </div>
        </div>
    </section>

    <section id="inscription" class="bg-gray-800 p-10 text-center">
        <h3 class="text-2xl font-bold mb-4">Créez votre compte dès aujourd'hui</h3>
        <form id="inscriptionForm" class="max-w-md mx-auto">
            <input type="text" name="nom" placeholder="Nom complet" class="w-full mb-4 px-4 py-2 rounded bg-gray-700 text-white" required>
            <input type="email" name="email" placeholder="Email" class="w-full mb-4 px-4 py-2 rounded bg-gray-700 text-white" required>
            <input type="password" name="mot_de_passe" placeholder="Mot de passe" class="w-full mb-4 px-4 py-2 rounded bg-gray-700 text-white" required>
            <input type="password" name="confirmer_mot_de_passe" placeholder="Confirmer le mot de passe" class="w-full mb-4 px-4 py-2 rounded bg-gray-700 text-white" required>
            <button type="submit" class="bg-blue-500 w-full py-3 rounded text-lg">S'inscrire</button>
        </form>
    </section>


    <footer class="bg-gray-800 p-5 text-center mt-10">
        <p class="text-gray-400">&copy; 2025 Finova. Tous droits réservés.</p>
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
                        alert("Erreur lors de l'inscription. Essayez à nouveau.");
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