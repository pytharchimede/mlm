<?php

session_start();

include 'header_site_index.php';

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/7.0.1/introjs.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/7.0.1/intro.min.js"></script>
    <link rel="stylesheet" href="site_css/accueil.css">
    <style>
        .introjs-tooltip {
            background-color: #1f2937 !important;
            /* Fond sombre */
            color: #f3f4f6 !important;
            /* Texte clair */
            border-radius: 8px !important;
            padding: 12px !important;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3) !important;
        }

        .introjs-tooltiptext {
            color: #f3f4f6 !important;
        }

        .introjs-helperLayer {
            background: rgba(31, 41, 55, 0.8) !important;
            /* Assombrir la zone en surbrillance */
        }

        .introjs-button {
            background-color: #4f46e5 !important;
            /* Couleur primaire */
            color: white !important;
            border-radius: 6px !important;
            padding: 6px 12px !important;
        }

        .introjs-prevbutton {
            background-color: #374151 !important;
            /* Gris foncé */
        }

        .introjs-disabled {
            opacity: 0.5 !important;
        }
    </style>
</head>

<body class="bg-gray-900 text-white">
    <?php include 'include/header.php'; ?>

    <!-- Bouton d'aide flottant -->
    <button id="startIntro" class="fixed bottom-6 right-6 bg-indigo-600 text-white p-3 rounded-full shadow-lg">
        ?
    </button>

    <section class="relative text-center py-20 px-5 bg-cover bg-center" style="background-image: url('../assets/img/community_1.jpg');">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>

        <div class="relative z-10">
            <h2 class="text-4xl font-bold text-white mb-4">Rejoignez la Révolution Financière</h2>
            <p class="text-lg text-gray-200 mb-6">Commencez avec seulement 15$</p>
            <a href="#inscription" class="bg-green-500 px-6 py-3 text-xl font-semibold rounded-lg">Rejoindre Maintenant</a>
        </div>
    </section>

    <section id="qui-sommes-nous" class="bg-gray-800 p-10 text-center text-gray-300" data-intro="Découvrez qui nous sommes et comment nous aidons à améliorer vos finances." data-step="1">
        <h2 class="text-3xl font-bold mb-6 text-white">Qui sommes-nous ?</h2>

        <p class="text-lg text-justify mb-6">
            <strong class="text-white">CMDB</strong> est bien plus qu'une simple plateforme : c'est une communauté internationale de <strong>solidarité financière</strong>.
            Peu importe ton pays d’origine, ici, chacun a l’opportunité de <strong>transformer ses ambitions en réalité</strong>.
            Avec une contribution unique de <strong>15$ (10 000 F CFA)</strong>, tu rejoins un réseau dynamique où l’entraide est la clé du succès.
        </p>

        <div class="mb-6">
            <h3 class="text-2xl font-semibold text-white flex items-center justify-center">
                <i class="fas fa-handshake mr-2"></i> Une avancée collective et équitable
            </h3>
            <p class="text-lg text-justify mt-2">
                Nous partageons tous les mêmes <strong>défis financiers</strong>. C’est pourquoi la CMDB fonctionne comme une <strong>tontine évolutive</strong>,
                mais avec un atout majeur : <strong>une seule participation suffit</strong> pour accéder à un système de progression permettant
                de débloquer des niveaux et d’augmenter tes gains.
            </p>
        </div>

        <div class="mb-6">
            <h3 class="text-2xl font-semibold text-white flex items-center justify-center">
                <i class="fas fa-shield-alt mr-2"></i> Sécurité et autonomie
            </h3>
            <p class="text-lg text-justify mt-2">
                <strong>Tu es le seul à gérer ton compte</strong>, et chaque transaction est transparente et sécurisée.
                Ici, pas d’intermédiaires : <strong>tu donnes et tu reçois</strong>, dans un cycle vertueux d’abondance et de prospérité.
            </p>
        </div>

        <div class="mb-6">
            <h3 class="text-2xl font-semibold text-white flex items-center justify-center">
                <i class="fas fa-calendar-alt mr-2"></i> Des rencontres stratégiques pour avancer
            </h3>
            <p class="text-lg text-justify mt-2">
                Pour t’accompagner, nous organisons des <strong>rencontres en ligne</strong> chaque soir, du lundi au vendredi, à <strong>20h GMT</strong>.
                Un lien d’accès te sera envoyé quotidiennement pour découvrir nos <strong>stratégies gagnantes</strong>.
                Notre objectif ? <strong>Te propulser rapidement vers un gain de 3 000$</strong> et t’offrir des opportunités exceptionnelles.
            </p>
        </div>

        <div class="mb-6">
            <h3 class="text-2xl font-semibold text-white flex items-center justify-center">
                <i class="fas fa-plane mr-2"></i> Un voyage à Dubaï pour les plus engagés
            </h3>
            <p class="text-lg text-justify mt-2">
                Ce mois de mars, nous offrons un <strong>voyage promotionnel à Dubaï</strong> aux membres les plus actifs. Une occasion unique de
                célébrer nos réussites et d’échanger avec d’autres participants du monde entier.
            </p>
        </div>

        <p class="text-lg text-center font-semibold text-white mt-8">
            Il est temps de <strong>reprendre le contrôle de tes finances</strong> et de dire adieu aux difficultés économiques.
            <strong>Rejoins-nous dès aujourd’hui</strong> et ensemble, <span class="text-yellow-400">révolutionnons notre avenir</span> !
        </p>
    </section>

    <section id="comment-ca-marche" class="bg-gray-800 p-10 text-center relative" data-intro="Découvrez comment nous vous accompagnons chaque jour dans votre évolution." data-step="2">
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
            <?php include 'include/rsi_tab.php'; ?>

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

    <section id="inscription" class="bg-gray-900 p-12 text-center rounded-lg shadow-lg" data-intro="Remplissez vos informations pour créer votre compte." data-step="3">
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

    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/971527959652" target="_blank" class="fixed bottom-6 right-6 bg-green-500 p-4 rounded-full shadow-lg hover:bg-green-600">
        <img src="../assets/icon/social/whatsapp.png" alt="WhatsApp" class="w-10 h-10">
    </a>

    <?php include 'include/footer.php'; ?>

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

        document.addEventListener("DOMContentLoaded", function() {
            // introJs().setOptions({
            //     showProgress: true,
            //     showBullets: true,
            //     nextLabel: 'Suivant →',
            //     prevLabel: '← Précédent',
            //     doneLabel: 'Terminer',
            //     tooltipClass: 'bg-gray-900 text-white p-4 rounded-lg shadow-lg'
            // }).start();
        });
    </script>


</body>

</html>