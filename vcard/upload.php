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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="css/contact_upload.css" rel="stylesheet">
</head>

<body class="flex items-center justify-center min-h-screen transition-all duration-500">

    <div class="bg-darkcard p-8 rounded-3xl shadow-xl w-full max-w-4xl transition-all duration-500">
        <h2 class="text-3xl font-semibold text-center text-darktext mb-6">📢 Inviter les contacts à WhatsApp</h2>

        <div class="mb-6 text-center">
            <p class="text-darktext">💬 **Lien du groupe WhatsApp** :</p>
            <a href="<?= $whatsapp_link ?>" target="_blank" class="inline-block mt-4 px-6 py-3 bg-accent text-white rounded-full hover:bg-accentHover transition-all duration-300">
                🔗 Rejoindre le groupe
            </a>
        </div>

        <?php if (!empty($allContacts)): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="contactList">
                <?php foreach ($allContacts as $contact): ?>
                    <div class="card-hover bg-darkbg p-6 rounded-xl shadow-lg hover:scale-105 transition-all duration-300">
                        <div class="flex justify-between items-center mb-4">
                            <div class="flex flex-col">
                                <span class="text-xl font-semibold text-darktext"><?= htmlspecialchars($contact['name']) ?></span>
                                <span class="text-sm text-gray-400"><?= $contact['phone'] ?></span>
                            </div>
                            <i class="fas fa-user-circle text-2xl text-gray-500 dark:text-gray-400 mr-4"></i>
                        </div>
                        <a href="https://wa.me/<?= $contact['phone'] ?>?text=Salut%20<?= urlencode($contact['name']) ?>,%20Rejoins%20la%20communauté%20mondiale%20du%20bonheur%20qui%20est%20une%20plateforme%20d'entraide%20financière%20👉%20<?= urlencode($whatsapp_link) ?>"
                            class="text-accent underline hover:text-accentHover transition-all duration-300">
                            📩 Envoyer l'invitation
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="mt-6">
                <textarea id="numbers" class="w-full p-4 border rounded-lg text-sm bg-gray-900 text-white" readonly>
                    <?= implode(", ", array_column($allContacts, 'phone')) ?>
                </textarea>
                <button id="copyButton" class="w-full bg-accent text-white py-3 rounded-lg mt-4 hover:bg-accentHover transition-all duration-300">
                    Copier les numéros
                </button>
            </div>

            <div class="mt-4 text-center">
                <a href="index.php" class="text-accent hover:underline">Importer un autre fichier</a>
            </div>

        <?php else: ?>
            <p class="text-red-500 text-center">Aucun contact trouvé.</p>
            <a href="index.php" class="block text-center mt-4 text-accent hover:underline">Retour</a>
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