<?php
// Assurez-vous que l'utilisateur est connecté, sinon rediriger vers la page de connexion
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

// Simuler des données d'utilisateur récupérées de la base de données (exemple)
$user = [
    'nom_utilisateur' => 'Ulrich Amani',
    'email_utilisateur' => 'pytharchimede1st@gmail.com',
    'solde_compte' => 1500.50,
    'miners' => [
        [
            'nom' => 'Miner Basic 1',
            'prix' => 6000.00,
            'solde_retirable' => 2000.00,
            'duree_vie_restante' => 2, // durée en minutes
        ],
        [
            'nom' => 'Miner Pro 2',
            'prix' => 12000.00,
            'solde_retirable' => 5000.00,
            'duree_vie_restante' => 100,
        ],
    ]
];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Finova</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body class="bg-gray-900 text-white">

    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg text-center w-96">
            <!-- <img src="../assets/img/source_plan_clair_petit.png" alt="Logo Finova" class="mx-auto mb-4 max-w-full h-auto"> -->

            <!-- Affichage des informations utilisateur -->
            <h1 class="text-2xl font-bold mb-4 text-green-400">Bienvenue, <?= $user['nom_utilisateur']; ?>!</h1>
            <p class="text-lg mb-4">Email : <?= $user['email_utilisateur']; ?></p>

            <!-- Section du solde du compte -->
            <div class="bg-gray-700 p-4 rounded-lg mb-6">
                <h2 class="text-xl font-semibold">Solde du compte</h2>
                <p class="text-3xl text-green-500"><?= number_format($user['solde_compte'], 2, ',', ' ') ?> FCFA</p>

                <!-- Faire un retrait -->
                <div class="mb-4">
                    <button class="w-full py-1.5 bg-red-500 text-white text-lg rounded-lg shadow-lg hover:bg-red-400 transition flex items-center justify-center">
                        <i class="fa fa-money-bill-wave mr-2"></i> Faire un retrait
                    </button>
                </div>
            </div>

            <!-- Espace entre le solde et le bouton acheter -->
            <div class="mb-6"></div>

            <!-- Souscrire à un produit avec icône -->
            <div class="bg-gray-700 p-4 rounded-lg mb-6">
                <h2 class="text-xl font-semibold mb-2">Miner</h2>
                <form action="miner_shop.php" method="GET">
                    <button type="submit" class="w-full py-1.5 bg-green-500 text-white text-lg rounded-lg shadow-lg hover:bg-green-400 transition flex items-center justify-center">
                        <i class="fa fa-cart-plus mr-2"></i> Acheter un miner
                    </button>
                </form>
            </div>

            <!-- Liste des miners -->
            <div class="bg-gray-700 p-4 rounded-lg mb-6">
                <h2 class="text-xl font-semibold mb-2">Vos miners</h2>
                <ul class="space-y-4">
                    <?php foreach ($user['miners'] as $miner): ?>
                        <li class="bg-gray-800 p-6 rounded-lg shadow-lg">
                            <h3 class="text-xl font-semibold mb-4"><?= $miner['nom']; ?></h3>
                            <p class="text-lg mb-4"><?= number_format($miner['prix'], 2, ',', ' ') ?> FCFA</p>
                            <div class="text-yellow-400 mb-4">★★★★☆</div>
                            <p class="mb-4">Solde Retirable : <?= number_format($miner['solde_retirable'], 2, ',', ' ') ?> FCFA</p>
                            <p class="mb-4">Durée de vie restante
                                <br>
                                <span id="badge_<?= $miner['nom']; ?>" class="inline-block ml-2 px-3 py-1 rounded-full text-white bg-green-500">
                                    <span id="compte_a_rebours_<?= $miner['nom']; ?>"><?= gmdate("i:s", $miner['duree_vie_restante'] * 60); ?></span> min
                                </span>
                            </p>
                        </li>
                    <?php endforeach; ?>
                </ul>

            </div>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <script>
                $(document).ready(function() {
                    // Initialiser un tableau pour gérer les timers
                    var miners = [
                        <?php foreach ($user['miners'] as $miner): ?> {
                                "nom": "<?= str_replace(' ', '_', $miner['nom']); ?>", // Nom du miner sans espaces
                                "dureeVieRestante": <?= $miner['duree_vie_restante']; ?> * 60, // durée en secondes
                                "badgeId": "badge_<?= $miner['nom']; ?>",
                                "compteARetoursId": "compte_a_rebours_<?= $miner['nom']; ?>",
                            },
                        <?php endforeach; ?>
                    ];

                    // Fonction pour mettre à jour le compte à rebours
                    function updateTimer(miner) {
                        var compteARetoursElement = document.getElementById(miner.compteARetoursId);
                        var badgeElement = document.getElementById(miner.badgeId);
                        var dureeVieRestante = miner.dureeVieRestante;

                        // Timer pour la durée de vie restante
                        var timer = setInterval(function() {
                            if (dureeVieRestante > 0) {
                                dureeVieRestante--; // Décrémenter chaque seconde
                                var minutes = Math.floor(dureeVieRestante / 60); // Calculer les minutes restantes
                                var secondes = dureeVieRestante % 60; // Calculer les secondes restantes
                                compteARetoursElement.textContent = minutes + " min " + (secondes < 10 ? "0" : "") + secondes + " s"; // Affichage du compte à rebours

                                // Changer la couleur du badge en fonction du temps restant
                                if (dureeVieRestante <= 30) {
                                    badgeElement.classList.remove("bg-yellow-500", "bg-green-500");
                                    badgeElement.classList.add("bg-red-500");
                                } else if (dureeVieRestante <= 120) {
                                    badgeElement.classList.remove("bg-red-500", "bg-green-500");
                                    badgeElement.classList.add("bg-yellow-500");
                                } else {
                                    badgeElement.classList.remove("bg-red-500", "bg-yellow-500");
                                    badgeElement.classList.add("bg-green-500");
                                }
                            } else {
                                clearInterval(timer);
                                compteARetoursElement.textContent = "Expiré"; // Afficher "Expiré" lorsque le temps est écoulé
                                badgeElement.classList.remove("bg-red-500", "bg-yellow-500", "bg-green-500");
                                badgeElement.classList.add("bg-gray-500"); // Badge gris quand le miner est expiré
                            }
                        }, 1000); // Mise à jour toutes les secondes
                    }

                    // Initialiser tous les timers de miner
                    miners.forEach(function(miner) {
                        updateTimer(miner);
                    });
                });
            </script>




        </div>
    </div>

</body>

</html>