<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Pour les graphiques -->
    <script src="../plugins/js/fontawesome-all.min.js" crossorigin="anonymous"></script>
</head>

<body class="bg-gray-800">

    <!-- Navbar -->
    <nav class="bg-gray-900 text-white px-4 py-3 shadow-lg flex justify-between items-center">
        <h1 class="text-2xl font-bold">Dashboard Admin</h1>
        <button class="md:hidden" id="hamburgerBtn">
            <i class="fas fa-bars"></i>
        </button>
    </nav>

    <!-- Menu horizontal -->
    <div id="sidebar" class="md:flex hidden justify-center space-x-8 bg-gray-900 py-3 text-white">
        <a href="#" class="hover:bg-gray-700 p-2 rounded-md"><i class="fas fa-wallet mr-2"></i>Demandes de Retrait</a>
        <a href="#" class="hover:bg-gray-700 p-2 rounded-md"><i class="fas fa-chart-line mr-2"></i>Statistiques</a>
        <a href="#" class="hover:bg-gray-700 p-2 rounded-md"><i class="fas fa-users mr-2"></i>Utilisateurs</a>
        <a href="#" class="hover:bg-gray-700 p-2 rounded-md"><i class="fas fa-gift mr-2"></i>Cadeaux Distribués</a>

        <!-- Profil utilisateur -->
        <div class="relative group">
            <button class="flex items-center p-2 rounded-md hover:bg-gray-700">
                <img src="https://via.placeholder.com/30" alt="Profil" class="rounded-full mr-2">
                <span>Jean Dupont</span>
                <i class="fas fa-chevron-down ml-2"></i>
            </button>
            <!-- Menu déroulant -->
            <div class="absolute right-0 mt-2 w-48 bg-gray-900 text-white rounded-md shadow-lg hidden group-hover:block">
                <a href="#" class="block px-4 py-2 hover:bg-gray-700">Mon Profil</a>
                <a href="#" class="block px-4 py-2 hover:bg-gray-700">Paramètres</a>
                <a href="#" class="block px-4 py-2 hover:bg-gray-700">Déconnexion</a>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="p-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-5">
            <div class="bg-gray-700 p-6 rounded-lg shadow-lg text-center">
                <h3 class="text-xl text-white">Montant Encaissé</h3>
                <p class="text-3xl text-yellow-500 font-bold">10,000 $</p>
            </div>
            <div class="bg-gray-700 p-6 rounded-lg shadow-lg text-center">
                <h3 class="text-xl text-white">Montant à Reverser</h3>
                <p class="text-3xl text-yellow-500 font-bold">5,000 $</p>
            </div>
            <div class="bg-gray-700 p-6 rounded-lg shadow-lg text-center">
                <h3 class="text-xl text-white">Chiffre d'Affaires</h3>
                <p class="text-3xl text-yellow-500 font-bold">50,000 $</p>
            </div>
            <div class="bg-gray-700 p-6 rounded-lg shadow-lg text-center">
                <h3 class="text-xl text-white">Demandes de retrait</h3>
                <p class="text-3xl text-yellow-500 font-bold" id="montant_encaisse">0</p>
            </div>
            <div class="bg-gray-700 p-6 rounded-lg shadow-lg text-center">
                <h3 class="text-xl text-white">Cadeaux à distribuer</h3>
                <p class="text-3xl text-yellow-500 font-bold" id="montant_reverser">0</p>
            </div>
            <div class="bg-gray-700 p-6 rounded-lg shadow-lg text-center">
                <h3 class="text-xl text-white">Cadeaux distribués</h3>
                <p class="text-3xl text-yellow-500 font-bold" id="chiffre_affaire">0</p>
            </div>
        </div>
        <div class="mt-10">
            <canvas id="montantsChart"></canvas>
        </div>
    </div>

    <script>
        // Graphique
        const ctx = document.getElementById('montantsChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
                datasets: [{
                    label: 'Montants Encaissés',
                    data: [1000, 2000, 1500, 2500, 3000, 3500],
                    borderColor: 'rgba(255, 159, 64, 1)',
                    fill: false,
                }]
            },
        });

        // Menu mobile
        document.getElementById('hamburgerBtn').addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('hidden');
        });
    </script>
</body>

</html>