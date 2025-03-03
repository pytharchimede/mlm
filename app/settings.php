<?php
// Vous pouvez ajouter ici votre code PHP pour traiter le formulaire et enregistrer les informations en base de données.
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réglages du Profil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white">

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

    <div class="max-w-4xl mx-auto p-8">
        <h2 class="text-3xl font-bold text-center mb-8">Modifier votre Profil</h2>

        <!-- Formulaire de profil -->
        <form method="POST" action="" enctype="multipart/form-data" class="space-y-6">

            <!-- Photo de profil -->
            <div class="flex justify-center items-center flex-col">
                <label for="profile_picture" class="cursor-pointer w-32 h-32 rounded-full bg-gray-800 flex justify-center items-center hover:bg-gray-700 transition duration-300">
                    <input type="file" name="profile_picture" id="profile_picture" class="hidden">
                    <img src="https://via.placeholder.com/150" id="profile_image" class="w-32 h-32 rounded-full object-cover">
                </label>
                <p class="mt-2 text-center">Cliquez pour changer la photo de profil</p>
            </div>

            <!-- Numéro de téléphone -->
            <div>
                <label for="phone_number" class="block text-lg font-medium">Numéro de téléphone</label>
                <input type="text" id="phone_number" name="phone_number" class="mt-2 block w-full px-4 py-2 bg-gray-800 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-white" placeholder="Ex: +225 0123456789" required>
            </div>

            <!-- Numéro WhatsApp -->
            <div>
                <label for="whatsapp_number" class="block text-lg font-medium">Numéro WhatsApp</label>
                <input type="text" id="whatsapp_number" name="whatsapp_number" class="mt-2 block w-full px-4 py-2 bg-gray-800 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-white" placeholder="Ex: +225 0123456789" required>
            </div>

            <!-- Numéro Telegram -->
            <div>
                <label for="telegram_number" class="block text-lg font-medium">Numéro Telegram</label>
                <input type="text" id="telegram_number" name="telegram_number" class="mt-2 block w-full px-4 py-2 bg-gray-800 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-white" placeholder="Ex: +225 0123456789" required>
            </div>

            <!-- Bouton soumettre -->
            <div class="flex justify-center">
                <button type="submit" class="px-6 py-3 bg-blue-600 rounded-lg text-white hover:bg-blue-500 transition duration-300">Enregistrer</button>
            </div>
        </form>
    </div>

    <!-- JavaScript pour prévisualiser l'image de profil -->
    <script>
        const fileInput = document.getElementById("profile_picture");
        const profileImage = document.getElementById("profile_image");

        fileInput.addEventListener("change", function() {
            const reader = new FileReader();
            reader.onload = function(e) {
                profileImage.src = e.target.result;
            };
            reader.readAsDataURL(fileInput.files[0]);
        });
    </script>

</body>

</html>