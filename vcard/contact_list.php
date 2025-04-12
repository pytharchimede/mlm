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
    <!-- Ajout de FontAwesome pour les icônes -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 dark:bg-darkbg flex items-center justify-center min-h-screen transition-all duration-500">
    <div class="bg-white dark:bg-darkcard p-6 rounded-2xl shadow-lg w-full max-w-4xl transition-all duration-500">
        <h2 class="text-2xl font-semibold text-gray-700 dark:text-darktext mb-6 text-center">📜 Liste des Contacts</h2>

        <!-- Formulaire de recherche -->
        <form method="GET" action="" class="mb-6 text-center">
            <input type="text" name="search" class="w-1/2 p-2 border rounded-lg text-sm bg-gray-200 dark:bg-darktext dark:text-black" placeholder="Rechercher par nom ou téléphone" value="<?= htmlspecialchars($searchTerm) ?>">
            <button type="submit" class="bg-accent text-white py-2 px-4 rounded-lg hover:bg-accentHover transition-all duration-300">Rechercher</button>
        </form>

        <!-- Bouton d'exportation PDF -->
        <div class="mb-4 text-center">
            <a href="export_contacts.php" class="inline-block mt-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-400 transition-all duration-300">
                📥 Exporter en PDF
            </a>
        </div>

        <?php if (!empty($contacts)): ?>
            <ul class="list-none text-gray-600 dark:text-darktext" id="contactList">
                <?php foreach ($contacts as $contact): ?>
                    <li class="py-4 px-6 bg-gray-200 dark:bg-darkbg rounded-md my-4 transition-all duration-300 hover:scale-105 flex items-center">
                        <!-- Icône de contact en remplacement de la photo -->
                        <i class="fas fa-user-circle text-3xl text-gray-500 dark:text-gray-400 mr-4"></i>
                        <span class="flex-grow"><?= htmlspecialchars($contact['name']) ?></span>
                        <a href="https://wa.me/<?= $contact['phone'] ?>?text=Salut%20<?= urlencode($contact['name']) ?>,%20Rejoins%20la%20communauté%20mondiale%20du%20bonheur%20qui%20est%20une%20plateforme%20d'entraide%20financière%20👉%20<?= urlencode($whatsapp_link) ?>"
                            class="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-400 transition-all duration-300" target="_blank">
                            Inviter
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="text-red-500 text-center">Aucun contact trouvé.</p>
        <?php endif; ?>
    </div>
</body>

</html>