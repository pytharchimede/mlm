<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Réseau</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
    <!-- Swiper.js -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script defer src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <style>
        /* Animation et styles personnalisés */
        .cta-button {
            background: linear-gradient(135deg, #10b981, #047857);
            transition: transform 0.3s ease-in-out;
        }

        .cta-button:hover {
            transform: scale(1.05);
        }

        .cta-button:active {
            transform: scale(0.95);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }


        .swiper-slide img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }

        /* Fixer la barre en bas */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #1f2937;
            /* Gris foncé */
            display: flex;
            justify-content: space-around;
            padding: 10px 0;
            border-top: 2px solid #374151;
            /* Bordure légère */
        }

        .bottom-nav a {
            color: #9ca3af;
            /* Gris clair */
            text-align: center;
            flex-grow: 1;
            padding: 10px 0;
            transition: 0.3s;
        }

        .bottom-nav a i {
            display: block;
            font-size: 24px;
        }

        .bottom-nav a:hover,
        .bottom-nav a.active {
            color: #10b981;
            /* Vert */
        }

        .bottom-nav a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }


        #profileMenu {
            transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
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

    <!-- Slider -->
    <div class="swiper mySwiper w-full mt-4">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="../slide/slide_1.jpg" alt="Slide 1">
            </div>
            <div class="swiper-slide">
                <img src="../slide/slide_2.jpg" alt="Slide 2">
            </div>
            <div class="swiper-slide">
                <img src="../slide/slide_3.jpg" alt="Slide 3">
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="p-6">
        <div class="bg-gray-800 p-6 rounded-lg text-center mb-6">
            <p class="text-lg">Fonds disponibles</p>
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

    <!-- Contenu principal -->
    <div class="p-6">

        <!-- Icônes fonctionnalités -->
        <div class="container mx-auto p-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="miner_shop.php" class="flex flex-col items-center p-6 bg-gray-800 rounded-lg">
                    <i class="fas fa-shopping-cart text-5xl text-gray-300"></i>
                    <div class="mt-3 text-lg font-semibold">Acheter</div>
                </a>
                <a href="javascript:void();" class="flex flex-col items-center p-6 bg-gray-800 rounded-lg">
                    <i class="fas fa-headset text-5xl text-gray-300"></i>
                    <div class="mt-3 text-lg font-semibold">Service</div>
                </a>
                <a href="javascript:void();" class="flex flex-col items-center p-6 bg-gray-800 rounded-lg">
                    <i class="fas fa-users text-5xl text-gray-300"></i>
                    <div class="mt-3 text-lg font-semibold">Inviter</div>
                </a>
                <a href="javascript:void();" class="flex flex-col items-center p-6 bg-gray-800 rounded-lg">
                    <i class="fas fa-globe text-5xl text-gray-300"></i>
                    <div class="mt-3 text-lg font-semibold">Langues</div>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
            <a class="flex flex-col items-center p-6 bg-gray-700 rounded-lg opacity-50 cursor-not-allowed">
                <i class="fas fa-comments text-5xl text-gray-300"></i>
                <div class="mt-3 text-lg font-semibold">Forum</div>
            </a>
            <a href="javascript:void();" class="flex flex-col items-center p-6 bg-gray-800 rounded-lg">
                <i class="fas fa-user-friends text-5xl text-gray-300"></i>
                <div class="mt-3 text-lg font-semibold">Équipe</div>
            </a>
            <a href="javascript:void();" class="flex flex-col items-center p-6 bg-gray-800 rounded-lg">
                <i class="fas fa-university text-5xl text-gray-300"></i>
                <div class="mt-3 text-lg font-semibold">Banque</div>
            </a>
            <a href="javascript:void();" class="flex flex-col items-center p-6 bg-gray-800 rounded-lg">
                <i class="fas fa-dollar-sign text-5xl text-gray-300"></i>
                <div class="mt-3 text-lg font-semibold">Salaire</div>
            </a>
        </div>

    </div>

    <!-- Bottom Navigation -->
    <div class="bottom-nav">
        <a href="#" class="active">
            <i class="fas fa-home"></i>
            <span>Accueil</span>
        </a>
        <a href="#">
            <i class="fas fa-wallet"></i>
            <span>Portefeuille</span>
        </a>
        <a href="#">
            <i class="fas fa-chart-line"></i>
            <span>Statistiques</span>
        </a>
        <a href="#">
            <i class="fas fa-cog"></i>
            <span>Réglages</span>
        </a>
    </div>



    <!-- Script Swiper -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var swiper = new Swiper(".mySwiper", {
                loop: true,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false
                },
                effect: "fade"
            });
        });
        document.getElementById("menuToggle").addEventListener("click", function() {
            let menu = document.getElementById("profileMenu");
            menu.classList.toggle("hidden");
            menu.classList.toggle("opacity-100");
            menu.classList.toggle("scale-100");
        });
    </script>
</body>

</html>