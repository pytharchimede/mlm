<?php
require_once '../model/Database.php';
require_once '../model/Contact.php';

$databaseObj = new Database();
$pdo = $databaseObj->getConnection();

$contactObj = new Contact($pdo);

$totalContacts = count($contactObj->getAllAvailable());

$contactsPerPackage = 30;
$totalPackages = ceil($totalContacts / $contactsPerPackage);
?>

<!DOCTYPE html>
<html lang="fr" class="dark">

<head>
    <meta charset="UTF-8">
    <title>Packages WhatsApp</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Dark mode config -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#4ADE80',
                        secondary: '#1E293B',
                        card: '#1F2937',
                        muted: '#9CA3AF',
                    },
                },
            }
        };
    </script>
</head>

<body class="bg-secondary text-white min-h-screen p-6">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-4xl font-bold mb-10 text-primary">🎯 Packages de contacts WhatsApp</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php for ($i = 1; $i <= $totalPackages; $i++): ?>
                <div id="pack<?= $i ?>" class="bg-card rounded-xl p-6 shadow-lg border border-gray-700 transition transform hover:scale-105">
                    <h2 class="text-2xl font-semibold mb-4">Package #<?= $i ?></h2>

                    <div class="flex items-center gap-4">
                        <a href="generate_package.php?pack=<?= $i ?>"
                            class="flex items-center gap-2 bg-primary text-black font-medium px-4 py-2 rounded-lg hover:bg-green-500 transition">
                            <i data-lucide="download" class="w-5 h-5"></i> Télécharger
                        </a>

                        <button onclick="markAsSold(<?= $i ?>)"
                            class="flex items-center gap-2 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                            <i data-lucide="x-circle" class="w-5 h-5"></i> Vendu
                        </button>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>

    <script>
        // Supprimer visuellement un package
        function markAsSold(id) {
            const el = document.getElementById("pack" + id);
            if (el) el.remove();
            // Ici tu peux faire un fetch AJAX si tu veux sauvegarder cette info côté serveur
        }

        // Activer les icônes Lucide
        lucide.createIcons();
    </script>
</body>

</html>