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
    <script defer src="../plugins/js/fontawesome-all.min.js"></script>
    <!-- Swiper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <link rel="stylesheet" href="../plugins/css/swiper-bundle.min.css" />
    <script defer src="../plugins/js/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="../css/style_dashboard.css" />
    <style>
        /* Ajout de la règle pour tronquer l'adresse si elle est trop longue */
        #wallet-address {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            width: 100%;
            max-width: 220px;
            /* Ajuste cette valeur selon la largeur de ton modal */
        }
    </style>
</head>

<body class="bg-gray-900 text-white pb-20">
    <!-- Navbar -->
    <nav class="bg-gray-800 p-4 flex justify-between items-center">
        <img id="logo" src="../assets/img/logo.png" class="w-32">
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
                    <a href="<?php echo (!$is_active) ? 'miner_shop.php' : 'javascript:void();';  ?>" class="flex flex-col items-center p-6 bg-gray-800 rounded-lg <?php echo (!$is_active) ? 'shadow-lg hover:bg-gray-700 transition' : 'opacity-50 cursor-not-allowed'; ?>">
                        <i class="fas fa-shopping-cart text-5xl text-gray-300"></i>
                        <div class="mt-3 text-lg font-semibold">Acheter</div>
                    </a>
                    <a href="<?php echo ($is_active) ? 'service.php' : 'javascript:void();';  ?>" class="flex flex-col items-center p-6 bg-gray-800 rounded-lg <?php echo ($is_active) ? 'shadow-lg hover:bg-gray-700 transition' : 'opacity-50 cursor-not-allowed'; ?>">
                        <i class="fas fa-headset text-5xl text-gray-300"></i>
                        <div class="mt-3 text-lg font-semibold">Service</div>
                    </a>
                    <a href="javascript:void(0);" <?php echo ($is_active) ? 'onclick="openInvitePopup()"' : ''; ?> class="flex flex-col items-center p-6 bg-gray-800 rounded-lg <?php echo ($is_active) ? 'shadow-lg hover:bg-gray-700 transition' : 'opacity-50 cursor-not-allowed'; ?>">
                        <i class="fas fa-users text-5xl text-gray-300"></i>
                        <div class="mt-3 text-lg font-semibold">Inviter</div>
                    </a>
                    <a href="<?php echo ($is_active) ? 'organigramme.php' : 'javascript:void();'; ?>" class="flex flex-col items-center p-6 bg-gray-800 rounded-lg <?php echo ($is_active) ? 'shadow-lg hover:bg-gray-700 transition' : 'opacity-50 cursor-not-allowed'; ?>">
                        <i class="fas fa-sitemap text-5xl text-gray-300"></i>
                        <div class="mt-3 text-lg font-semibold">Réseau</div>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                <a href="javascript:void(0);" onclick="openForumModal()" class="flex flex-col items-center p-6 bg-gray-800 rounded-lg shadow-lg hover:bg-gray-700 transition">
                    <i class="fas fa-comments text-5xl text-gray-300"></i>
                    <div class="mt-3 text-lg font-semibold">Forum</div>
                </a>
                <a href="javascript:void();" <?php echo ($is_active) ? 'id="openTeamModal"' : '';
                                                ?> class="flex flex-col items-center p-6 bg-gray-800 rounded-lg <?php echo ($is_active) ? 'shadow-lg hover:bg-gray-700 transition' : 'opacity-50 cursor-not-allowed'; ?>">
                    <i class="fas fa-user-friends text-5xl text-gray-300"></i>
                    <div class="mt-3 text-lg font-semibold text-white">Équipe</div>
                </a>
                <!-- <a href="javascript:void();" id="openTeamModal" class="flex flex-col items-center p-6 bg-gray-800 rounded-lg shadow-lg hover:bg-gray-700 transition">
                    <i class="fas fa-user-friends text-5xl text-gray-300"></i>
                    <div class="mt-3 text-lg font-semibold text-white">Équipe</div>
                </a> -->
                <a href="javascript:void(0);" <?php echo ($is_active) ? 'onclick="openModal()"' : ''; ?> class="flex flex-col items-center p-6 bg-gray-800 rounded-lg <?php echo ($is_active) ? 'shadow-lg hover:bg-gray-700 transition' : 'opacity-50 cursor-not-allowed'; ?>">
                    <i class="fas fa-university text-5xl text-gray-300"></i>
                    <div class="mt-3 text-lg font-semibold">Compte</div>
                </a>

                <a href="javascript:void(0);" <?php echo ($is_active) ? 'id="withdrawalButton"' : ''; ?> class="flex flex-col items-center p-6 bg-gray-800 rounded-lg <?php echo ($is_active) ? 'shadow-lg hover:bg-gray-700 transition' : 'opacity-50 cursor-not-allowed'; ?>">
                    <i class="fas fa-wallet text-5xl text-gray-300"></i>
                    <div class="mt-3 text-lg font-semibold">Retrait</div>
                </a>

            </div>

        </div>

        <!-- Pop-up Héritiers -->
        <div id="organigrammePopup" class="popup-overlay">
            <div class="popup-content">
                <button class="popup-close" id="closePopupButton">X</button>
                <h2 class="text-2xl font-bold text-white mb-4">Liste des Héritiers</h2>
                <div class="heir-list">

                    <?php
                    foreach ($filleuls as $index => $filleul) :
                    ?>
                        <div class="heir-item">
                            <div class="heir-avatar"></div>
                            <div class="heir-details">
                                <h3 class="heir-name"><?= htmlspecialchars($filleul['nom_utilisateur']) ?></h3>
                                <p class="heir-text">Filleuls Actifs : 0</p>
                                <p class="heir-text">Solde : 0 $</p>
                            </div>
                            <div class="contact-btn-container">
                                <a href="https://wa.me/<?= empty($filleul['whatsapp_utilisateur']) ? 'empty_number' : $filleul['telephone_utilisateur'] ?>" target="_blank" class="contact-btn">
                                    <i class="fab fa-whatsapp"></i> WhatsApp
                                </a>
                                <a href="https://t.me/<?= urlencode($filleul['telegram_utilisateur']) ?>" target="_blank" class="contact-btn">
                                    <i class="fab fa-telegram"></i> Telegram
                                </a>
                            </div>
                        </div>
                    <?php
                    endforeach;
                    ?>

                </div>
            </div>
        </div>


        <!-- Modal de soumission de demande de retrait-->
        <div id="modal-withdraw-request" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg w-96 text-center">
                <h2 class="text-xl font-bold mb-4">Soumettre une Demande de Retrait</h2>

                <!-- Formulaire de demande de retrait -->
                <form id="withdrawalForm" method="POST">
                    <div class="mb-4">
                        <label for="withdrawalAmount" class="text-lg font-semibold text-gray-300">Montant à Retirer :</label>
                        <input type="number" id="withdrawalAmount" name="withdrawalAmount" class="w-full p-2 rounded bg-gray-700 text-white text-center" placeholder="Entrez le montant" required>
                    </div>

                    <div class="flex justify-center gap-4 mt-4">
                        <button type="button" onclick="closeModalWithdrawRequest()" class="bg-red-500 px-4 py-2 rounded">Annuler</button>
                        <button type="submit" class="bg-blue-500 px-4 py-2 rounded">Soumettre</button>
                    </div>
                </form>

                <div id="confirmationMessage" class="mt-4 text-green-500 hidden">
                    <p>Votre demande de retrait a été soumise avec succès !</p>
                </div>
            </div>
        </div>

        <!-- Modal ajout de wallet BNB-->
        <div id="modal-add-wallet" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg w-96 text-center">
                <h2 class="text-xl font-bold mb-4">Entrer l'adresse du portefeuille</h2>
                <input type="text" id="walletAddress" class="w-full p-2 rounded bg-gray-700 text-white text-center" placeholder="Ex: 0x123...">

                <!-- QR Code affiché après validation -->
                <div id="qrResult" class="hidden mt-4">
                    <h3 class="text-lg font-semibold">QR Code de Paiement</h3>
                    <div id="qrcode-container" class="flex justify-center mt-2"></div>
                </div>

                <!-- Jauge de chargement -->
                <div id="progressContainer" class="hidden mt-4">
                    <p id="progressText" class="text-sm mb-2">Enregistrement en cours...</p>
                    <div class="w-full bg-gray-700 rounded-full h-2">
                        <div id="progressBar" class="bg-blue-500 h-2 rounded-full" style="width: 0%;"></div>
                    </div>
                </div>

                <!-- Boutons centrés -->
                <div class="flex justify-center gap-4 mt-4">
                    <button onclick="closeModalAdd()" class="bg-red-500 px-4 py-2 rounded">Annuler</button>
                    <button onclick="generateQRCode()" class="bg-blue-500 px-4 py-2 rounded">Valider</button>
                </div>
            </div>
        </div>

        <!-- Modal affichage de wallet BNB-->
        <div id="modal-existing-wallet" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg w-96 text-center">
                <h2 class="text-xl font-bold mb-4">Votre Adresse de Portefeuille BNB</h2>

                <div class="mb-4 flex items-center justify-center">
                    <p class="truncate w-3/4" id="wallet-address"><?php echo $walletAddress; ?></p>
                    <button onclick="copyWalletAddress()" class="ml-2 text-gray-300">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>

                <!-- QR Code container -->
                <div id="qrcode-container" class="flex justify-center mt-4"></div>

                <div class="flex justify-center gap-4 mt-4">
                    <button onclick="closeModalExisting()" class="bg-red-500 px-4 py-2 rounded">Fermer</button>
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

                <input type="text" id="referral-link" value="https://comodubo.com/website/index.php?ref=<?php echo isset($_SESSION['secur']) ? $_SESSION['secur'] : 'lol'; ?>" readonly class="w-full p-2 mb-4 text-center text-black rounded">

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

        <!-- Popup de communication -->
        <div id="forumModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg w-96 text-center relative">
                <!-- Bouton de fermeture -->
                <button onclick="closeForumModal()" class="absolute top-2 right-2 text-gray-400 hover:text-white text-2xl">&times;</button>

                <!-- Titre -->
                <h2 class="text-xl font-bold text-white mb-3">Nos canaux de communication</h2>

                <!-- Lien de partage dynamique -->
                <p class="text-gray-300 text-sm mb-2">Cliquez sur un canal et copiez le lien :</p>
                <div class="flex bg-gray-700 p-2 rounded-lg mb-4">
                    <input id="referralLink" type="text" value="" class="bg-transparent text-white text-sm flex-1 outline-none" readonly>
                    <button onclick="copyLink()" class="ml-2 bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">Copier</button>
                </div>

                <!-- Icônes des réseaux sociaux (Cliquables) -->
                <div class="grid grid-cols-4 gap-3 justify-center">
                    <img src="../assets/icon/social/whatsapp.png" onclick="updateLink('https://wa.me/971527959652')" class="social-icon" alt="WhatsApp">
                    <img src="../assets/icon/social/telegram.png" onclick="updateLink('https://t.me/+N_aPV8J8wwwzYzM8')" class="social-icon" alt="Telegram">
                    <img src="../assets/icon/social/email.png" onclick="updateLink('assistance@comodubo.com')" class="social-icon" alt="Email">
                    <img src="../assets/icon/social/facebook.png" onclick="updateLink('https://www.facebook.com/profile.php?id=61573796879697&mibextid=LQQJ4d')" class="social-icon" alt="Facebook">
                    <img src="../assets/icon/social/tiktok.png" onclick="updateLink('https://www.tiktok.com/@2025cmdb?lang=fr')" class="social-icon" alt="TikTok">
                    <img src="../assets/icon/social/youtube.png" onclick="updateLink('https://www.youtube.com/@revolutionfinanciere2025')" class="social-icon" alt="YouTube">
                    <img src="../assets/icon/social/instagram.png" onclick="updateLink('https://instagram.com/votre_compte')" class="social-icon" alt="Instagram">
                    <img src="../assets/icon/social/twitter.png" onclick="updateLink('https://twitter.com/votre_compte')" class="social-icon" alt="Twitter">
                </div>
            </div>
        </div>

        <!-- Modal (Popup) -->
        <div id="teamModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
            <div class="bg-gray-900 text-white p-6 rounded-lg shadow-lg w-96 relative">
                <!-- Bouton de fermeture -->
                <button id="closeTeamModal" class="absolute top-2 right-2 text-gray-400 hover:text-white text-2xl">
                    &times;
                </button>

                <!-- Titre -->
                <h2 class="text-2xl font-semibold mb-4 text-center">Choisissez un service</h2>

                <!-- Liste des options -->
                <div class="space-y-3">
                    <a href="#" class="flex items-center p-3 bg-gray-800 rounded-lg hover:bg-indigo-600 transition duration-300">
                        <i class="fas fa-tools text-xl mr-3"></i> Service Technique
                    </a>
                    <a href="#" class="flex items-center p-3 bg-gray-800 rounded-lg hover:bg-green-500 transition duration-300">
                        <i class="fas fa-handshake text-xl mr-3"></i> Service Commercial
                    </a>
                    <a href="#" class="flex items-center p-3 bg-gray-800 rounded-lg hover:bg-yellow-500 transition duration-300">
                        <i class="fas fa-wallet text-xl mr-3"></i> Service Financier
                    </a>
                    <a href="#" class="flex items-center p-3 bg-gray-800 rounded-lg hover:bg-blue-500 transition duration-300">
                        <i class="fas fa-user-tie text-xl mr-3"></i> Contacter mon Parrain
                    </a>
                    <a href="#" class="flex items-center p-3 bg-gray-800 rounded-lg hover:bg-pink-500 transition duration-300">
                        <i class="fas fa-users text-xl mr-3"></i> Contacter mes Filleuls
                    </a>
                </div>
            </div>
        </div>


        <!-- Bottom Navigation -->
        <?php include '../inc/bottom_navigation_bar.php'; ?>

        <!-- Script Swiper -->
        <script src="../js/script_dashboard.js"></script>

        <script>
            // Passer les variables PHP à JavaScript
            var hasWallet = <?php echo $hasWallet ? 'true' : 'false'; ?>;
            var walletAddress = "<?php echo $walletAddress; ?>";

            document.addEventListener("DOMContentLoaded", function() {
                initWithdrawalModal();
                initTeamModal();
            });

            /* ==========================
               GESTION DU MODAL DE RETRAIT
               ========================== */
            function initWithdrawalModal() {
                const withdrawalButton = document.getElementById("withdrawalButton");
                const withdrawalForm = document.getElementById("withdrawalForm");

                if (withdrawalButton && withdrawalForm) {
                    withdrawalButton.addEventListener("click", openWithdrawalModal);
                    withdrawalForm.addEventListener("submit", submitWithdrawalForm);
                }
            }

            function openWithdrawalModal() {
                document.getElementById("modal-withdraw-request").classList.remove("hidden");
            }

            function closeModalWithdrawRequest() {
                document.getElementById("modal-withdraw-request").classList.add("hidden");
            }

            function submitWithdrawalForm(event) {
                event.preventDefault();
                const withdrawalAmount = document.getElementById("withdrawalAmount").value;
                const formData = new FormData();
                formData.append("withdrawalAmount", withdrawalAmount);

                fetch("../request/insert_demande_retrait.php", {
                        method: "POST",
                        body: formData,
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById("confirmationMessage").classList.remove("hidden");
                            document.getElementById("withdrawalForm").reset();
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error("Erreur:", error);
                        alert("Une erreur est survenue lors de la soumission de la demande.");
                    });
            }

            /* ==========================
               GESTION DU MODAL ÉQUIPE
               ========================== */
            function initTeamModal() {
                const openTeamModalBtn = document.getElementById("openTeamModal");
                const closeTeamModalBtn = document.getElementById("closeTeamModal");
                const teamModal = document.getElementById("teamModal");

                if (openTeamModalBtn && closeTeamModalBtn && teamModal) {
                    openTeamModalBtn.addEventListener("click", () => {
                        teamModal.style.display = "flex";
                    });

                    closeTeamModalBtn.addEventListener("click", () => {
                        teamModal.style.display = "none";
                    });

                    window.addEventListener("click", (event) => {
                        if (event.target === teamModal) {
                            teamModal.style.display = "none";
                        }
                    });
                }
            }

            /* ==========================
               GESTION DU WALLET UTILISATEUR
               ========================== */
            function openModal() {
                hasWallet ? showExistingWalletModal() : showAddWalletModal();
            }

            function showExistingWalletModal() {
                document.getElementById("modal-existing-wallet").classList.remove("hidden");
                var qrcode = new QRCode(document.getElementById("qrcode-container"));
                qrcode.makeCode(walletAddress);
            }

            function showAddWalletModal() {
                document.getElementById("modal-add-wallet").classList.remove("hidden");
            }

            function closeModalExisting() {
                document.getElementById("modal-existing-wallet").classList.add("hidden");
            }

            function closeModalAdd() {
                document.getElementById("modal-add-wallet").classList.add("hidden");
            }

            function generateQRCode() {
                const address = document.getElementById("walletAddress").value;
                if (address.trim() === "") {
                    alert("Veuillez entrer une adresse de portefeuille BNB.");
                    return;
                }

                document.getElementById("qrcode-container").innerHTML = "";
                new QRCode(document.getElementById("qrcode-container"), {
                    text: `bnb:${address}`,
                    width: 200,
                    height: 200
                });

                document.getElementById("qrResult").classList.remove("hidden");
                startProgressBar(address);
            }

            function startProgressBar(address) {
                document.getElementById("progressContainer").classList.remove("hidden");
                document.getElementById("progressText").textContent = "Enregistrement en cours...";
                let progress = 0;
                const interval = setInterval(() => {
                    progress += 10;
                    document.getElementById("progressBar").style.width = progress + "%";
                    if (progress >= 100) {
                        clearInterval(interval);
                        saveToDatabase(address);
                    }
                }, 500);
            }

            function saveToDatabase(address) {
                fetch("../request/update_user_wallet.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        },
                        body: `wallet_address=${encodeURIComponent(address)}`
                    })
                    .then(response => response.text())
                    .then(() => {
                        document.getElementById("progressText").textContent = "Adresse enregistrée avec succès !";
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    })
                    .catch(error => {
                        document.getElementById("progressText").textContent = "Erreur lors de l'enregistrement.";
                        console.error("Erreur:", error);
                    });
            }

            function copyWalletAddress() {
                const walletAddress = document.getElementById("wallet-address").innerText;
                const tempInput = document.createElement("input");
                document.body.appendChild(tempInput);
                tempInput.value = walletAddress;
                tempInput.select();
                document.execCommand("copy");
                document.body.removeChild(tempInput);
                alert("Adresse copiée dans le presse-papiers !");
            }

            /* ==========================
               GESTION DES CANAUX DE COMMUNICATION
               ========================== */
            function openForumModal() {
                document.getElementById("forumModal").classList.remove("hidden");
            }

            function closeForumModal() {
                document.getElementById("forumModal").classList.add("hidden");
            }

            function updateLink(link) {
                document.getElementById("referralLink").value = link;
            }

            function copyLink() {
                var copyText = document.getElementById("referralLink");
                if (copyText.value === "") {
                    alert("Sélectionnez d'abord un canal !");
                    return;
                }
                copyText.select();
                document.execCommand("copy");
                alert("Lien copié : " + copyText.value);
            }
        </script>

</body>

</html>