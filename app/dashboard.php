<?php
include '../headers/header_dashboard.php';
?>
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
    <link rel="stylesheet" href="../css/style_dashboard.css" />
</head>

<body class="bg-gray-900 text-white pb-20">
    <!-- Navbar -->
    <nav class="bg-gray-800 p-4 flex justify-between items-center">
        <h1 class="text-xl font-bold">CMDB</h1>
        <div class="relative">
            <button id="menuToggle" class="text-xl"><i class="fas fa-bars"></i></button>
            <div id="profileMenu" class="hidden absolute right-0 bg-gray-700 p-4 rounded-lg mt-2 w-48">
                <p class="font-bold"><?php echo $_SESSION['nom'] ?></p>
                <p class="text-sm text-gray-400">Membre</p>
                <button onclick="window.location.href='../logout.php'" class="bg-red-500 px-4 py-2 rounded mt-2">Déconnexion</button>
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


        <!-- HTML pour afficher les informations -->
        <div class="bg-gray-900 p-8 rounded-xl shadow-lg relative">

            <!-- Affichage du solde -->
            <div class="text-center">
                <p class="text-lg font-semibold text-gray-400">Fonds disponibles</p>
                <p id="balance" class="text-5xl font-extrabold text-green-400 mt-2">
                    <?php echo number_format($solde, 2, '.', ' ') . ' $'; ?>
                </p>
            </div>

            <!-- Bouton d'activation du profil -->
            <?php if (!$is_active): ?>
                <div class="mt-6 text-center">
                    <button id="activate-btn" class="px-8 py-3 border border-green-400 text-green-400 rounded-full text-lg font-semibold hover:bg-green-400 hover:text-gray-900 transition shadow-md">
                        Activer mon Pack
                    </button>
                </div>
            <?php endif; ?>
        </div>

        <!-- Contenu principal -->
        <div class="p-6">

            <!-- Icônes fonctionnalités -->
            <div class="container mx-auto p-4">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="<?php echo (!$is_active) ? 'miner_shop.php' : 'javascript:void();';  ?>" class="flex flex-col items-center p-6 bg-gray-800 rounded-lg <?php echo (!$is_active) ? '' : 'opacity-50 cursor-not-allowed'; ?>">
                        <i class="fas fa-shopping-cart text-5xl text-gray-300"></i>
                        <div class="mt-3 text-lg font-semibold">Acheter</div>
                    </a>
                    <a href="javascript:void();" class="flex flex-col items-center p-6 bg-gray-800 rounded-lg">
                        <i class="fas fa-headset text-5xl text-gray-300"></i>
                        <div class="mt-3 text-lg font-semibold">Service</div>
                    </a>
                    <a href="javascript:void(0);" onclick="openInvitePopup()" class="flex flex-col items-center p-6 bg-gray-800 rounded-lg shadow-lg hover:bg-gray-700 transition">
                        <i class="fas fa-users text-5xl text-gray-300"></i>
                        <div class="mt-3 text-lg font-semibold">Inviter</div>
                    </a>
                    <a href="javascript:void();" id="openPopupButton" class="flex flex-col items-center p-6 bg-gray-800 rounded-lg shadow-lg hover:bg-gray-700 transition">
                        <i class="fas fa-sitemap text-5xl text-gray-300"></i>
                        <div class="mt-3 text-lg font-semibold">Réseau</div>
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


        <!-- Pop-up Organigramme -->
        <div id="organigrammePopup" class="popup-overlay">
            <div class="popup-content">
                <button class="popup-close" id="closePopupButton">X</button>
                <h2 class="text-2xl font-bold text-white mb-4">Mon Organigramme</h2>
                <div id="network">
                    <!-- Informations du réseau -->
                    <div id="network" class="mt-6">
                        <div class="member">
                            <div class="avatar"></div>
                            <p>Moi</p>
                            <p class="text-xs text-gray-400">Héritiers actifs: 3</p>
                            <div class="progress-bar" style="width: 60%;"></div>
                        </div>
                        <div class="line"></div>
                        <div class="network-row">
                            <div class="member">
                                <div class="avatar"></div>
                                <p>Héritier 1</p>
                                <p class="text-xs text-gray-400">Actifs: 2</p>
                                <div class="progress-bar" style="width: 40%;"></div>
                            </div>
                            <div class="horizontal-line"></div>
                            <div class="member">
                                <div class="avatar"></div>
                                <p>Héritier 2</p>
                                <p class="text-xs text-gray-400">Actifs: 1</p>
                                <div class="progress-bar" style="width: 20%;"></div>
                            </div>
                            <div class="horizontal-line"></div>
                            <div class="member">
                                <div class="avatar"></div>
                                <p>Héritier 3</p>
                                <p class="text-xs text-gray-400">Actifs: 4</p>
                                <div class="progress-bar" style="width: 80%;"></div>
                            </div>
                            <div class="horizontal-line"></div>
                            <div class="member">
                                <div class="avatar"></div>
                                <p>Héritier 4</p>
                                <p class="text-xs text-gray-400">Actifs: 0</p>
                                <div class="progress-bar" style="width: 0%;"></div>
                            </div>
                            <div class="horizontal-line"></div>
                            <div class="member">
                                <div class="avatar"></div>
                                <p>Héritier 5</p>
                                <p class="text-xs text-gray-400">Actifs: 3</p>
                                <div class="progress-bar" style="width: 60%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Popup inviter -->
        <div id="invitePopup" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg w-96 text-center relative">
                <button onclick="closeInvitePopup()" class="absolute top-2 right-2 text-gray-400 hover:text-white text-2xl">&times;</button>
                <h2 class="text-xl font-bold mb-3">Invitez vos amis !</h2>
                <p class="text-gray-300 text-sm mb-4">
                    Partagez ce lien de parrainage avec vos amis pour leur faire découvrir **CMDB**, la tontine en cryptomonnaie !
                </p>

                <input type="text" id="referral-link" value="https://ifmap.ci/test/website/index.php?ref=<?php echo isset($_SESSION['secur']) ? $_SESSION['secur'] : 'lol'; ?>" readonly class="w-full p-2 mb-4 text-center text-black rounded">

                <div class="flex justify-around">
                    <a href="#" onclick="shareOnFacebook()" class="bg-blue-600 p-3 rounded-full text-white text-lg">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" onclick="shareOnWhatsApp()" class="bg-green-500 p-3 rounded-full text-white text-lg">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="#" onclick="shareOnTelegram()" class="bg-blue-400 p-3 rounded-full text-white text-lg">
                        <i class="fab fa-telegram-plane"></i>
                    </a>
                    <a href="#" onclick="shareByEmail()" class="bg-red-500 p-3 rounded-full text-white text-lg">
                        <i class="fas fa-envelope"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Bottom Navigation -->
        <?php include '../inc/bottom_navigation_bar.php'; ?>

        <!-- Script Swiper -->
        <script src="../js/script_dashboard.js"></script>
</body>

</html>