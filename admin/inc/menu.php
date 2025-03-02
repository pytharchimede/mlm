    <!-- Navbar -->
    <nav class="bg-gray-900 text-white px-4 py-3 shadow-lg flex justify-between items-center">
        <h1 class="text-2xl font-bold">Dashboard Admin</h1>
        <button class="md:hidden" id="hamburgerBtn">
            <i class="fas fa-bars"></i>
        </button>
    </nav>

    <!-- Menu horizontal -->
    <div id="sidebar" class="md:flex hidden justify-center space-x-8 bg-gray-900 py-3 text-white">
        <a href="#" class="hover:bg-gray-700 p-2 rounded-md"><i class="fas fa-wallet mr-2"></i>Retrait</a>
        <a href="#" class="hover:bg-gray-700 p-2 rounded-md"><i class="fas fa-chart-line mr-2"></i>Statistiques</a>
        <a href="#" class="hover:bg-gray-700 p-2 rounded-md"><i class="fas fa-users mr-2"></i>Utilisateurs</a>
        <a href="#" class="hover:bg-gray-700 p-2 rounded-md"><i class="fas fa-gift mr-2"></i>Cadeaux</a>

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