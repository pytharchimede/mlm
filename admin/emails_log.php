<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emails envoyés</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-gray-900 text-white">

    <?php include 'inc/menu.php'; ?>

    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold text-center mb-4">📧 Emails Envoyés</h1>
        <div class="overflow-x-auto bg-gray-800 p-4 rounded-lg">
            <table class="w-full text-left text-sm" id="emailTable">
                <thead>
                    <tr class="border-b border-gray-700 text-gray-400">
                        <th class="p-2">Destinataire</th>
                        <th class="p-2">Email</th>
                        <th class="p-2">Sujet</th>
                        <th class="p-2">Date</th>
                        <th class="p-2">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    <!-- Les données seront injectées par AJAX -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal pour l'aperçu des emails -->
    <div id="emailModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-gray-800 p-6 rounded-lg max-w-lg w-full relative">
            <button class="absolute top-2 right-2 text-white text-xl" onclick="closeModal()">✖</button>
            <h2 class="text-xl font-bold mb-4">Aperçu du Mail</h2>
            <div id="emailContent" class="bg-white p-4 text-black rounded"></div>
        </div>
    </div>

    <script>
        // Fonction pour afficher l'email dans un modal
        function showEmail(content) {
            document.getElementById("emailContent").innerHTML = content;
            document.getElementById("emailModal").classList.remove("hidden");
        }

        // Fonction pour fermer le modal
        function closeModal() {
            document.getElementById("emailModal").classList.add("hidden");
        }

        // Fonction pour récupérer et afficher les emails envoyés
        function fetchEmails() {
            $.ajax({
                url: '../request/get_sent_emails.php', // Le fichier PHP qui récupère les emails
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log(data); // Vérifier les données reçues dans la console
                    // Vider le tableau actuel
                    $('#emailTable tbody').empty();

                    // Parcourir les données et ajouter les lignes au tableau
                    data.forEach(function(email) {
                        $('#emailTable tbody').append(
                            '<tr>' +
                            '<td class="p-2">' + email.recipient_name + '</td>' +
                            '<td class="p-2">' + email.recipient_email + '</td>' +
                            '<td class="p-2">' + email.email_subject + '</td>' +
                            '<td class="p-2">' + email.sent_at + '</td>' +
                            '<td class="p-2">' +
                            '<button class="bg-blue-500 hover:bg-blue-600 px-3 py-1 rounded" onclick="showEmail(\'' + email.email_body.replace(/'/g, "\\'") + '\')">👁 Voir</button>' +
                            '</td>' +
                            '</tr>'
                        );
                    });
                }
            });
        }

        // Appeler fetchEmails toutes les 5 secondes
        setInterval(fetchEmails, 300000);

        // Charger immédiatement les emails au chargement de la page
        fetchEmails();
    </script>
</body>

</html>