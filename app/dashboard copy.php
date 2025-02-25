<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Réseau</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>

    <style>
        /* Animation et styles personnalisés */
        .cta-button {
            background: linear-gradient(135deg, #10b981, #047857);
            transition: transform 0.3s ease-in-out;
        }

        .cta-button:hover {
            transform: scale(1.05);
        }
    </style>
</head>

<body class="bg-gray-900 text-white pb-20">
    <!-- Navbar -->
    <nav class="bg-gray-800 p-4 flex justify-between items-center">
        <h1 class="text-xl font-bold">CMDB</h1>
        <div class="relative">
            <button id="menuToggle" class="text-xl"><i class="fas fa-bars"></i></button>
            <div id="profileMenu" class="hidden absolute right-0 bg-gray-700 p-4 rounded-lg mt-2 w-48">
                <p class="font-bold">Ulrich AMANI</p>
                <p class="text-sm text-gray-400">Membre depuis 2024</p>
                <button class="bg-red-500 px-4 py-2 rounded mt-2">Déconnexion</button>
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <div class="p-6">
        <div class="bg-gray-800 p-6 rounded-lg text-center mb-6">
            <p class="text-lg">Solde disponible</p>
            <p class="text-3xl font-bold text-green-400">0 XOF</p>
        </div>

        <!-- Bouton d'activation du profil -->
        <div class="text-center mb-6">
            <button class="cta-button px-6 py-3 rounded-lg text-lg font-semibold">Activer mon profil</button>
        </div>

        <!-- Informations du réseau -->
        <div class="bg-gray-800 p-6 rounded-lg text-center mb-6">
            <h2 class="text-lg">Filleuls et Réseau</h2>
            <p class="text-gray-400">Vous avez <strong>5</strong> filleuls actifs</p>
        </div>
    </div>

    <!-- Script pour le menu déroulant -->
    <script>
        document.getElementById("menuToggle").addEventListener("click", function() {
            document.getElementById("profileMenu").classList.toggle("hidden");
        });
    </script>
</body>

</html>