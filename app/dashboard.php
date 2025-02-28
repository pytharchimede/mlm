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
                <a href="javascript:void();" class="flex flex-col items-center p-6 bg-gray-800 rounded-lg opacity-50 cursor-not-allowed">
                    <i class="fas fa-user-friends text-5xl text-gray-300"></i>
                    <div class="mt-3 text-lg font-semibold">Équipe</div>
                </a>
                <a href="javascript:void(0);" onclick="openModal()" class="flex flex-col items-center p-6 bg-gray-800 rounded-lg shadow-lg hover:bg-gray-700 transition">
                    <i class="fas fa-university text-5xl text-gray-300"></i>
                    <div class="mt-3 text-lg font-semibold">Compte</div>
                </a>

                <a href="javascript:void(0);" id="withdrawalButton" class="flex flex-col items-center p-6 bg-gray-800 rounded-lg shadow-lg hover:bg-gray-700 transition">
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
                                <p class="heir-text">Filleuls Actifs : 2</p>
                                <p class="heir-text">Solde : 5000 $</p>
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

        <script>
            // Passer la variable PHP à JavaScript
            var hasWallet = <?php echo $hasWallet ? 'true' : 'false'; ?>;
            var walletAddress = "<?php echo $walletAddress; ?>";

            function openModal() {
                if (hasWallet) {
                    // Si l'utilisateur a un wallet, afficher le modal avec l'adresse et le QR code
                    showExistingWalletModal();
                } else {
                    // Si l'utilisateur n'a pas de wallet, afficher le modal d'ajout de wallet
                    showAddWalletModal();
                }
            }

            function showExistingWalletModal() {
                // Affiche le modal pour le wallet existant
                document.getElementById("modal-existing-wallet").classList.remove("hidden");

                // Générer le QR Code avec l'adresse du wallet existant
                var qrcode = new QRCode(document.getElementById("qrcode-container"));
                qrcode.makeCode(walletAddress); // Utiliser l'adresse existante pour générer le QR Code
            }

            function showAddWalletModal() {
                // Affiche le modal pour ajouter un wallet
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
                // Simulation de requête AJAX pour mettre à jour l'adresse BNB dans la base de données
                fetch("../request/update_user_wallet.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        },
                        body: `wallet_address=${encodeURIComponent(address)}`
                    })
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById("progressText").textContent = "Adresse enregistrée avec succès !";
                        setTimeout(() => {
                            location.reload(); // Actualiser la page après enregistrement
                        }, 1000);
                    })
                    .catch(error => {
                        document.getElementById("progressText").textContent = "Erreur lors de l'enregistrement.";
                        console.error("Erreur:", error);
                    });
            }

            function copyWalletAddress() {
                // Récupérer l'adresse du portefeuille
                const walletAddress = document.getElementById("wallet-address").innerText;

                // Créer un champ de texte temporaire pour copier l'adresse
                const tempInput = document.createElement("input");
                document.body.appendChild(tempInput);
                tempInput.value = walletAddress;
                tempInput.select();
                tempInput.setSelectionRange(0, 99999); // Pour les appareils mobiles

                // Copier l'adresse dans le presse-papiers
                document.execCommand("copy");

                // Supprimer le champ temporaire
                document.body.removeChild(tempInput);

                // Optionnel: Afficher une notification ou un message de succès
                alert("Adresse copiée dans le presse-papiers !");
            }

            //demande de retrait

            // Ouvrir le modal de demande de retrait
            document.getElementById("withdrawalButton").addEventListener("click", function() {
                openWithdrawalModal();
            });

            // Ouvrir le modal de retrait
            function openWithdrawalModal() {
                document.getElementById('modal-withdraw-request').classList.remove('hidden');
            }

            // Fermer le modal de retrait
            function closeModalWithdrawRequest() {
                document.getElementById('modal-withdraw-request').classList.add('hidden');
            }

            // Gérer la soumission du formulaire
            document.getElementById('withdrawalForm').addEventListener('submit', function(event) {
                event.preventDefault(); // Empêcher l'envoi normal du formulaire

                // Récupérer le montant de retrait
                const withdrawalAmount = document.getElementById('withdrawalAmount').value;

                // Effectuer une requête AJAX pour envoyer la demande de retrait au serveur
                const formData = new FormData();
                formData.append('withdrawalAmount', withdrawalAmount);

                fetch('../request/insert_demande_retrait.php', {
                        method: 'POST',
                        body: formData,
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Afficher le message de confirmation
                            document.getElementById('confirmationMessage').classList.remove('hidden');
                            document.getElementById('withdrawalForm').reset(); // Réinitialiser le formulaire
                        } else {
                            alert(data.message); // Afficher l'erreur
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        alert('Une erreur est survenue lors de la soumission de la demande.');
                    });
            });
        </script>
</body>

</html>