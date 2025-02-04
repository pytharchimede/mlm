<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
</head>

<body class="bg-gray-900 text-white">

    <!-- Navbar -->
    <nav class="bg-gray-800 p-4 flex justify-between items-center">
        <h1 class="text-xl font-bold">Finova</h1>
        <div class="flex items-center gap-4">
            <span class="text-sm">Utilisateur: <strong>Ulrich AMANI</strong></span>
            <button class="bg-red-500 px-4 py-2 rounded">Déconnexion</button>
        </div>
    </nav>

    <!-- Slider (Placeholder) -->
    <div class="w-full h-48 bg-gray-700 flex justify-center items-center text-gray-300">
        <span>Slider d'images</span>
    </div>

    <!-- Contenu principal -->
    <div class="p-6">
        <!-- Section des fonds -->
        <div class="bg-gray-800 p-4 rounded-lg text-center mb-4">
            <p class="text-lg">Fonds disponibles</p>
            <p class="text-2xl font-bold text-green-400">50,000 XOF</p>
        </div>

        <!-- Icônes fonctionnalités -->
        <div class="container mx-auto p-4">
            <div class="grid grid-cols-4 gap-4">
                <a href="javascript:void();" class="text-center p-4 bg-gray-800 rounded-lg">
                    <i class="fas fa-shopping-cart text-4xl text-gray-300"></i>
                    <div class="mt-2">Acheter</div>
                </a>
                <a href="javascript:void();" class="text-center p-4 bg-gray-800 rounded-lg">
                    <i class="fas fa-headset text-4xl text-gray-300"></i>
                    <div class="mt-2">Service</div>
                </a>
                <a href="javascript:void();" class="text-center p-4 bg-gray-800 rounded-lg">
                    <i class="fas fa-users text-4xl text-gray-300"></i>
                    <div class="mt-2">Inviter</div>
                </a>
                <a href="javascript:void();" class="text-center p-4 bg-gray-800 rounded-lg">
                    <i class="fas fa-globe text-4xl text-gray-300"></i>
                    <div class="mt-2">Langues</div>
                </a>
            </div>
            <div class="grid grid-cols-4 gap-4 mt-4">
                <a class="text-center p-4 bg-gray-700 rounded-lg opacity-50 cursor-not-allowed">
                    <i class="fas fa-comments text-4xl text-gray-300"></i>
                    <div class="mt-2">Forum</div>
                </a>
                <a href="javascript:void();" class="text-center p-4 bg-gray-800 rounded-lg">
                    <i class="fas fa-user-friends text-4xl text-gray-300"></i>
                    <div class="mt-2">Équipe</div>
                </a>
                <a href="javascript:void();" class="text-center p-4 bg-gray-800 rounded-lg">
                    <i class="fas fa-university text-4xl text-gray-300"></i>
                    <div class="mt-2">Banque</div>
                </a>
                <a href="javascript:void();" class="text-center p-4 bg-gray-800 rounded-lg">
                    <i class="fas fa-dollar-sign text-4xl text-gray-300"></i>
                    <div class="mt-2">Salaire</div>
                </a>
            </div>
        </div>
    </div>

</body>

</html>