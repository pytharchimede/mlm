<?php
// Inclure les classes nécessaires
require_once '../model/Database.php';
require_once '../model/Contact.php';

// Créer une instance de la classe Database pour obtenir l'objet PDO
$database = new Database();
$pdo = $database->getConnection();

// Récupérer les contacts en fonction de la recherche
$searchTerm = '';
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
}

// Récupérer les contacts depuis la base de données avec recherche
$contacts = Contact::getBySearch($pdo, $searchTerm);  // Méthode de recherche dans la base de données

// Lien d'invitation WhatsApp
$whatsapp_link = "https://chat.whatsapp.com/CxKCksOoPwFBJ4zT0hYjx2";
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Contacts</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script> <!-- FontAwesome -->
</head>

<body class="bg-gray-900 text-white">

    <div class="max-w-7xl mx-auto p-4">

        <!-- Search bar -->
        <div class="mb-4">
            <input type="text" id="search" placeholder="Rechercher un contact..." class="w-full p-3 bg-gray-700 text-white rounded-lg" onkeyup="filterContacts()" />
        </div>

        <!-- Cards for each contact -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($contacts as $contact) : ?>
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg hover:bg-gray-700">
                    <div class="flex items-center mb-4">
                        <!-- WhatsApp icon with phone number -->
                        <a href="https://wa.me/<?= htmlspecialchars($contact['phone']) ?>" target="_blank" class="text-green-400 text-3xl mr-4">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <div>
                            <p class="text-xl font-semibold"><?= htmlspecialchars($contact['name']) ?></p>
                            <p class="text-sm text-gray-400"><?= htmlspecialchars($contact['phone']) ?></p>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mt-4">
                        <!-- Invitation button with message -->
                        <a href="<?= $whatsapp_link ?>" target="_blank" class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-600">
                            Inviter au groupe
                        </a>

                        <!-- Invite message -->
                        <div class="text-sm text-gray-300 ml-4">
                            <p>Rejoignez notre groupe WhatsApp pour plus d'infos !</p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        // Filtre les contacts en fonction de la recherche
        function filterContacts() {
            let input = document.getElementById('search').value.toLowerCase();
            let cards = document.querySelectorAll('.bg-gray-800');

            cards.forEach(card => {
                let name = card.querySelector('.text-xl').textContent.toLowerCase();
                let phone = card.querySelector('.text-sm.text-gray-400').textContent.toLowerCase();

                if (name.includes(input) || phone.includes(input)) {
                    card.style.display = "";
                } else {
                    card.style.display = "none";
                }
            });
        }
    </script>

</body>

</html>