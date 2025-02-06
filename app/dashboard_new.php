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
    <div class="min-h-screen flex flex-col items-center justify-center p-6">
        <div class="bg-gray-800 p-6 rounded-2xl shadow-xl w-full max-w-lg">
            <div class="flex justify-center mb-4">
                <img src="../assets/img/source_plan_clair_petit.png" alt="Logo Finova" class="h-16">
            </div>
            <h1 class="text-2xl font-bold text-green-400 text-center">Bienvenue, <?= $user['nom_utilisateur']; ?>!</h1>
            <p class="text-center text-gray-300 mt-2">Email : <?= $user['email_utilisateur']; ?></p>

            <div class="bg-gray-700 p-4 rounded-lg mt-6">
                <h2 class="text-lg font-semibold text-center">Solde du compte</h2>
                <p class="text-3xl text-green-500 text-center font-bold"><?= number_format($user['solde_compte'], 2, ',', ' ') ?> FCFA</p>
                <button class="w-full mt-4 py-2 bg-red-500 text-white text-lg rounded-lg shadow-md hover:bg-red-400 transition flex items-center justify-center">
                    <i class="fa fa-money-bill-wave mr-2"></i> Faire un retrait
                </button>
            </div>

            <div class="mt-6 bg-gray-700 p-4 rounded-lg">
                <h2 class="text-lg font-semibold text-center">Acheter un miner</h2>
                <form action="miner_shop.php" method="GET" class="mt-2">
                    <button type="submit" class="w-full py-2 bg-green-500 text-white text-lg rounded-lg shadow-md hover:bg-green-400 transition flex items-center justify-center">
                        <i class="fa fa-cart-plus mr-2"></i> Acheter un miner
                    </button>
                </form>
            </div>

            <div class="mt-6 bg-gray-700 p-4 rounded-lg">
                <h2 class="text-lg font-semibold text-center">Vos miners</h2>
                <ul class="mt-4 space-y-4">
                    <?php foreach ($user['miners'] as $miner): ?>
                        <li class="bg-gray-800 p-4 rounded-lg shadow-md">
                            <h3 class="text-xl font-semibold text-center text-yellow-300"><?= $miner['nom']; ?></h3>
                            <p class="text-lg text-center text-gray-300"><?= number_format($miner['prix'], 2, ',', ' ') ?> FCFA</p>
                            <p class="text-center text-gray-300">Solde Retirable : <span class="text-green-400 font-semibold"><?= number_format($miner['solde_retirable'], 2, ',', ' ') ?> FCFA</span></p>
                            <p class="text-center mt-2">Durée de vie restante :
                                <span id="badge_<?= $miner['nom']; ?>" class="inline-block px-3 py-1 rounded-full text-white bg-green-500">
                                    <span id="compte_a_rebours_<?= $miner['nom']; ?>"><?= gmdate("i:s", $miner['duree_vie_restante'] * 60); ?></span> min
                                </span>
                            </p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            var miners = [
                <?php foreach ($user['miners'] as $miner): ?> {
                        "nom": "<?= str_replace(' ', '_', $miner['nom']); ?>",
                        "dureeVieRestante": <?= $miner['duree_vie_restante']; ?> * 60,
                        "badgeId": "badge_<?= $miner['nom']; ?>",
                        "compteARetoursId": "compte_a_rebours_<?= $miner['nom']; ?>",
                    },
                <?php endforeach; ?>
            ];

            function updateTimer(miner) {
                var compteARetoursElement = document.getElementById(miner.compteARetoursId);
                var badgeElement = document.getElementById(miner.badgeId);
                var dureeVieRestante = miner.dureeVieRestante;
                var timer = setInterval(function() {
                    if (dureeVieRestante > 0) {
                        dureeVieRestante--;
                        var minutes = Math.floor(dureeVieRestante / 60);
                        var secondes = dureeVieRestante % 60;
                        compteARetoursElement.textContent = minutes + " min " + (secondes < 10 ? "0" : "") + secondes + " s";

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
                        compteARetoursElement.textContent = "Expiré";
                        badgeElement.classList.remove("bg-red-500", "bg-yellow-500", "bg-green-500");
                        badgeElement.classList.add("bg-gray-500");
                    }
                }, 1000);
            }
            miners.forEach(function(miner) {
                updateTimer(miner);
            });
        });
    </script>
</body>

</html>