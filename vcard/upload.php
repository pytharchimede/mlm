<?php
// Inclure les classes nécessaires
require_once '../model/Database.php';
require_once '../model/Contact.php';

// Créer une instance de la classe Database pour obtenir l'objet PDO
$database = new Database();
$pdo = $database->getConnection();

$contacts = [];
$whatsapp_link = "https://chat.whatsapp.com/CxKCksOoPwFBJ4zT0hYjx2"; // Ton lien d'invitation

// Vérifier si un fichier a été téléchargé
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["vcard"])) {
    $file = $_FILES["vcard"]["tmp_name"];

    if (file_exists($file)) {
        // Lire le contenu du fichier VCard
        $content = file_get_contents($file);

        // Extraire les noms et numéros de téléphone
        preg_match_all('/FN;CHARSET=UTF-8:(.*?)\n.*?TEL;TYPE=CELL:(\+?\d+)/s', $content, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $name = trim($match[1]);
            $phone = trim($match[2]);

            // Nettoyer le numéro en retirant les caractères non numériques
            $phone = preg_replace('/\D/', '', $phone);

            // Retirer le suffixe "SBC" si présent à la fin du numéro
            if (substr($name, -3) === "SBC") {
                $name = substr($name, 0, -3); // Retirer "SBC"
            }

            // Ajouter le contact à la base de données
            $contact = new Contact($pdo);
            $contact->setName($name);  // Utiliser le setter pour le nom
            $contact->setPhone($phone);  // Utiliser le setter pour le téléphone

            if ($contact->save()) {
                $contacts[] = ['name' => $name, 'phone' => $phone]; // Ajouter le contact à la liste
            }
        }

        if (!empty($contacts)) {
            echo "<script>console.log('✅ " . count($contacts) . " contacts extraits et enregistrés en base de données !');</script>";
        } else {
            echo "<script>console.log('❌ Aucun contact trouvé. Vérifie ton fichier VCard.');</script>";
        }

        // Supprimer le fichier temporaire après traitement
        unlink($file);
        echo "<script>console.log('🗑️ Fichier supprimé après lecture.');</script>";
    } else {
        echo "<script>console.log('❌ Erreur : fichier introuvable.');</script>";
    }
}

// Récupérer la liste de tous les contacts dans la base de données
$allContacts = Contact::getAll($pdo);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inviter à WhatsApp</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 dark:bg-darkbg flex items-center justify-center min-h-screen transition-all duration-500">
    <div class="bg-white dark:bg-darkcard p-6 rounded-2xl shadow-lg w-full max-w-lg transition-all duration-500">
        <h2 class="text-xl font-semibold text-gray-700 dark:text-darktext mb-4 text-center">📢 Inviter les contacts</h2>

        <div class="mb-4 text-center">
            <p class="text-gray-700 dark:text-darktext">💬 **Lien du groupe WhatsApp** :</p>
            <a href="<?= $whatsapp_link ?>" target="_blank" class="inline-block mt-2 px-4 py-2 bg-accent text-white rounded-lg hover:bg-accentHover transition-all duration-300">
                🔗 Rejoindre le groupe
            </a>
        </div>

        <?php if (!empty($allContacts)): ?>
            <ul class="list-none text-gray-600 dark:text-darktext" id="contactList">
                <?php foreach ($allContacts as $contact): ?>
                    <li class="py-2 px-4 bg-gray-200 dark:bg-darkbg rounded-md my-1 transition-all duration-300 hover:scale-105">
                        <?= htmlspecialchars($contact['name']) ?> -
                        <a href="https://wa.me/<?= $contact['phone'] ?>?text=Salut%20<?= urlencode($contact['name']) ?>,%20Rejoins%20la%20communauté%20mondiale%20du%20bonheur%20qui%20est%20une%20plateforme%20d'entraide%20financière%20👉%20<?= urlencode($whatsapp_link) ?>"
                            class="text-blue-500 underline" target="_blank">
                            📩 Envoyer l'invitation
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="mt-4">
                <textarea id="numbers" class="w-full p-2 border rounded-lg text-sm bg-gray-200 dark:bg-darktext dark:text-black" readonly>
                    <?= implode(", ", array_column($allContacts, 'phone')) ?>
                </textarea>
                <button id="copyButton" class="w-full bg-accent text-white py-2 rounded-lg mt-2 hover:bg-accentHover transition-all duration-300">
                    Copier les numéros
                </button>
            </div>

            <div class="mt-4">
                <a href="index.php" class="block text-center text-blue-500 hover:underline">Importer un autre fichier</a>
            </div>

        <?php else: ?>
            <p class="text-red-500 text-center">Aucun contact trouvé.</p>
            <a href="index.php" class="block text-center mt-4 text-blue-500 hover:underline">Retour</a>
        <?php endif; ?>
    </div>

    <script>
        document.getElementById("copyButton").addEventListener("click", function() {
            let textarea = document.getElementById("numbers");
            textarea.select();
            document.execCommand("copy");

            alert("Numéros copiés !");
        });
    </script>
</body>

</html>