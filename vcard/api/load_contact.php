<?php
require_once '../../model/Database.php';
require_once '../../model/Contact.php';

$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$limit = 50;

$databaseObj = new Database();
$pdo = $databaseObj->getConnection();

$contactObj = new Contact($pdo);
$contactsDispos = $contactObj->getAllAvailableWithLimit($offset, $limit);

foreach ($contactsDispos as $contactsDispo): ?>
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