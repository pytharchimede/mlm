<header class="bg-gray-800 p-5 flex justify-between items-center">
    <!-- Logo cliquable -->
    <a href="../index.php">
        <img id="logo" src="../assets/img/logo.png" class="w-32">
    </a>

    <!-- Menu normal sur grand écran -->
    <nav class="hidden md:flex items-center space-x-4">
        <a href="../login.php" class="bg-blue-500 px-4 py-2 rounded-lg flex items-center space-x-2 text-white">
            <i class="fas fa-sign-in-alt"></i>
            <span>Connexion</span>
        </a>
        <a href="#inscription" class="bg-green-500 px-4 py-2 rounded-lg flex items-center space-x-2 text-white">
            <i class="fas fa-user-plus"></i>
            <span>Inscription</span>
        </a>
    </nav>

    <!-- Bouton hamburger -->
    <button id="menu-toggle" class="md:hidden text-white text-2xl focus:outline-none">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Menu mobile -->
    <div id="mobile-menu" class="hidden absolute top-16 right-5 bg-gray-800 w-48 rounded-lg shadow-lg">
        <a href="../login.php" class="block px-4 py-2 text-white hover:bg-gray-700">
            <i class="fas fa-sign-in-alt"></i> Connexion
        </a>
        <a href="#inscription" class="block px-4 py-2 text-white hover:bg-gray-700">
            <i class="fas fa-user-plus"></i> Inscription
        </a>
    </div>
</header>

<script>
    // Script pour afficher/cacher le menu mobile
    document.getElementById("menu-toggle").addEventListener("click", function() {
        document.getElementById("mobile-menu").classList.toggle("hidden");
    });
</script>