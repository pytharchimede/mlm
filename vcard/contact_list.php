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

// Lien d'invitation WhatsApp (général pour le groupe)
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
                        <!-- Invitation button with dynamic message -->
                        <a href="https://wa.me/<?= htmlspecialchars($contact['phone']) ?>?text=Salut%20<?= urlencode($contact['name']) ?>,%20Découvre%20une%20communauté%20d’entrepreneurs%20passionnés%20où%20la%20collaboration,%20le%20crowdfunding%20et%20l’accélération%20des%20revenus%20sont%20au%20cœur%20de%20l’action.%20Rejoins-nous%20et%20booste%20tes%20projets%20avec%20le%20soutien%20d’un%20réseau%20ambitieux%20!%20👉%20<?= urlencode($whatsapp_link) ?>%20On%20avance%20ensemble%20🚀🤝"
                            class="text-accent underline hover:text-accentHover transition-all duration-300 invite-btn"
                            data-contact-id="<?= $contact['id'] ?>">
                            📩 Envoyer l'invitation
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

        // Fonction pour enregistrer le clic
        function saveClick(contactId) {
            console.log("Enregistrement du clic pour le contact ID : " + contactId); // Débogage pour vérifier que la fonction est appelée

            // Crée une requête AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'save_click.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            // Définir les données à envoyer
            var data = 'contact_id=' + contactId;

            // Gérer la réponse du serveur
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        console.log('Clic enregistré avec succès');
                    } else {
                        console.log('Erreur lors de l\'enregistrement', response.message);
                    }
                } else {
                    console.log('Erreur AJAX : ' + xhr.status);
                }
            };

            // Gérer les erreurs de requête
            xhr.onerror = function() {
                console.log('Erreur de connexion');
            };

            // Envoyer la requête avec les données
            xhr.send(data);
        }

        // Ajouter un événement de clic sur chaque bouton d'invitation
        document.querySelectorAll('.invite-btn').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Empêche le lien de se suivre et d'ouvrir WhatsApp directement

                var contactId = this.getAttribute('data-contact-id'); // Récupérer l'ID du contact depuis un attribut data
                saveClick(contactId); // Enregistrer le clic via AJAX

                // Ouvrir WhatsApp après l'enregistrement
                var phone = this.href.split('?')[0]; // Récupérer le numéro de téléphone
                window.location.href = this.href; // Ouvrir le lien WhatsApp
            });
        });
    </script>

</body>

</html>