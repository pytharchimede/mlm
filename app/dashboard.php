<?php

session_start(); // Démarre la session

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

    <style>
        /* Animation et styles personnalisés */
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
            display: flex;
            justify-content: space-around;
            padding: 10px 0;
            border-top: 2px solid #374151;
        }

        .bottom-nav a {
            color: #9ca3af;
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
        }

        .bottom-nav a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        /* Styles pour le Pop-up */
        .popup-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 999;
        }

        .popup-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #2c2c2c;
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            max-width: 800px;
            text-align: center;
        }

        .popup-close {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #ff3b3b;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 50%;
            cursor: pointer;
        }

        body {
            background-color: #181818;
            color: #fff;
            font-family: 'Montserrat', sans-serif;
        }

        #network {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .member {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 10px;
            border-radius: 10px;
            background: #2c2c2c;
            width: 150px;
            text-align: center;
            position: relative;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }

        .member i {
            font-size: 40px;
            color: gray;
        }

        .avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: #4b4b4b;
            margin-bottom: 8px;
        }

        .line {
            width: 2px;
            height: 20px;
            background: #aaa;
            margin: auto;
        }

        .horizontal-line {
            width: 100px;
            height: 2px;
            background: #aaa;
            position: absolute;
            top: 50%;
        }

        .network-row {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            position: relative;
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background-color: #333;
            border-radius: 10px;
            margin-top: 8px;
        }

        .progress-bar {
            background: linear-gradient(to right, #4caf50, #f44336);
            transition: width 0.3s ease;
        }

        .text-xs {
            color: #ddd;
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
                <p class="font-bold"><?php echo $_SESSION['nom'] ?></p>
                <p class="text-sm text-gray-400"><?php echo $_SESSION['email'] ?></p>
                <button class="bg-red-500 px-4 py-2 rounded mt-2">Déconnexion</button>
            </div>
        </div>
    </nav>

    <!-- Slider -->
    <!-- <div class="swiper mySwiper w-full mt-4">
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
    </div> -->

    <!-- Contenu principal -->
    <div class="p-6">


        <div class="flex justify-between items-center bg-gray-800 p-6 rounded-lg mb-6">
            <!-- Affichage du solde -->
            <div class="text-left">
                <p class="text-lg">Fonds disponibles</p>
                <p id="balance" class="text-3xl font-bold text-green-400 opacity-50">0 XOF</p>
            </div>

            <!-- Bouton d'activation du profil -->
            <button id="activate-btn" class="px-6 py-2 border border-green-400 text-green-400 rounded-lg text-lg font-semibold hover:bg-green-400 hover:text-gray-900 transition">
                Activer
            </button>
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

                <input type="text" id="referral-link" value="https://cmdb.com/parrainage?code=123456" readonly class="w-full p-2 mb-4 text-center text-black rounded">

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


            // Ouvrir le pop-up
            document.getElementById("openPopupButton").addEventListener("click", function() {
                document.getElementById("organigrammePopup").style.display = "block";
            });

            // Fermer le pop-up
            document.getElementById("closePopupButton").addEventListener("click", function() {
                document.getElementById("organigrammePopup").style.display = "none";
            });

            // Fermer le pop-up si l'utilisateur clique en dehors
            document.getElementById("organigrammePopup").addEventListener("click", function(e) {
                if (e.target === document.getElementById("organigrammePopup")) {
                    document.getElementById("organigrammePopup").style.display = "none";
                }
            });

            function openInvitePopup() {
                document.getElementById("invitePopup").classList.remove("hidden");
            }

            function closeInvitePopup() {
                document.getElementById("invitePopup").classList.add("hidden");
            }

            function shareOnFacebook() {
                let url = encodeURIComponent(document.getElementById("referral-link").value);
                window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank');
            }

            function shareOnWhatsApp() {
                let text = encodeURIComponent("Rejoignez CMDB, la tontine en cryptomonnaie et commencez à gagner ! Voici mon lien de parrainage : " + document.getElementById("referral-link").value);
                window.open(`https://wa.me/?text=${text}`, '_blank');
            }

            function shareOnTelegram() {
                let text = encodeURIComponent("Rejoignez CMDB, la tontine en cryptomonnaie et commencez à gagner ! Voici mon lien de parrainage : " + document.getElementById("referral-link").value);
                window.open(`https://t.me/share/url?url=${text}`, '_blank');
            }

            function shareByEmail() {
                let subject = encodeURIComponent("Invitation à rejoindre CMDB");
                let body = encodeURIComponent("Bonjour,\n\nJe vous invite à rejoindre CMDB, la tontine en cryptomonnaie où vous pouvez investir et générer des revenus passifs. Inscrivez-vous ici : " + document.getElementById("referral-link").value);
                window.open(`mailto:?subject=${subject}&body=${body}`, '_blank');
            }
        </script>
</body>

</html>