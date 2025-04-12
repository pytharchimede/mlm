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
</head>

<body class="bg-gray-900 text-white">

    <div class="max-w-7xl mx-auto p-4">
        <!-- Search bar -->
        <div class="mb-4">
            <input type="text" id="search" placeholder="Rechercher un contact..." class="w-full p-3 bg-gray-700 text-white rounded-lg" onkeyup="filterContacts()" />
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-gray-800 rounded-lg">
                <thead>
                    <tr>
                        <th class="p-4 text-left">Nom</th>
                        <th class="p-4 text-left">Numéro Whatsapp</th>
                        <th class="p-4 text-left">Action</th>
                    </tr>
                </thead>
                <tbody id="contact-list">
                    <?php foreach ($contacts as $contact) : ?>
                        <tr class="hover:bg-gray-700">
                            <td class="p-4"><?= htmlspecialchars($contact['name']) ?></td>
                            <td class="p-4"><?= htmlspecialchars($contact['phone']) ?></td>
                            <td class="p-4">
                                <a href="invite_to_group.php?phone=<?= htmlspecialchars($contact['phone']) ?>" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Inviter</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function filterContacts() {
            let input = document.getElementById('search').value.toLowerCase();
            let rows = document.getElementById('contact-list').getElementsByTagName('tr');

            for (let i = 0; i < rows.length; i++) {
                let name = rows[i].getElementsByTagName('td')[0].textContent.toLowerCase();
                let phone = rows[i].getElementsByTagName('td')[1].textContent.toLowerCase();

                if (name.includes(input) || phone.includes(input)) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        }
    </script>

</body>

</html>