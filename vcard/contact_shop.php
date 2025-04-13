<?php include 'header/header_contact_shop.php'; ?>
<!DOCTYPE html>
<html lang="fr" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Boutique de Contacts</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Montserrat', 'sans-serif']
                    },
                    colors: {
                        primary: '#10b981', // vert émeraude
                        secondary: '#0f172a' // bleu foncé
                    }
                }
            }
        };
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-secondary text-white font-sans">

    <div class="max-w-7xl mx-auto px-4 py-10">
        <h1 class="text-4xl font-extrabold text-center mb-10 text-primary flex items-center justify-center gap-2">
            <i data-lucide="shopping-bag" class="w-8 h-8"></i>
            Boutique de Contacts WhatsApp
        </h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($contactsDispos as $contactsDispo): ?>
                <!-- Carte contact -->
                <div class="bg-gray-800 rounded-2xl shadow-lg hover:shadow-primary transition p-6">
                    <h2 class="text-xl font-semibold mb-2 flex items-center gap-2">
                        <i data-lucide="user" class="w-5 h-5 text-primary"></i>
                        Nom : <span class="text-gray-300">Contact Mystère</span>
                    </h2>
                    <p class="mb-2 text-gray-400 flex items-center gap-2">
                        <i data-lucide="phone" class="w-5 h-5 text-primary"></i>
                        Téléphone : <span class="blur-sm select-none">+225 07 XX XX XX</span>
                    </p>
                    <p class="mb-4 text-green-400 font-bold flex items-center gap-2">
                        <i data-lucide="dollar-sign" class="w-5 h-5 text-green-400"></i>
                        50 FCFA
                    </p>
                    <button class="w-full bg-primary hover:bg-green-600 text-white font-semibold py-2 rounded-xl transition flex items-center justify-center gap-2">
                        <i data-lucide="shopping-cart" class="w-5 h-5"></i> Acheter
                    </button>
                </div>
            <?php endforeach; ?>
        </div>

    </div>

    <script>
        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
        }
        lucide.createIcons();
    </script>
</body>

</html>