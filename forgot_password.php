<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récupération de mot de passe</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body class="bg-gray-900 text-white flex items-center justify-center h-screen">

    <!-- Conteneur principal -->
    <div class="w-full max-w-md bg-gray-800 p-8 rounded-lg shadow-lg">
        <div class="flex justify-center mb-8">
            <!-- Logo Comodubo -->
            <img src="assets/img/logo.png" alt="Logo Comodubo" class="h-16">
        </div>

        <h2 class="text-2xl font-semibold text-center text-gray-200 mb-6">Récupération de mot de passe</h2>

        <!-- Message d'erreur ou succès -->
        <div id="message" class="hidden p-2 rounded mb-4 text-center"></div>

        <!-- Formulaire de réinitialisation -->
        <form id="passwordRecoveryForm" class="space-y-6">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-300">Entrez votre adresse e-mail</label>
                <input type="email" id="email" name="email" required
                    class="w-full px-4 py-3 mt-2 bg-gray-700 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <button type="submit"
                class="w-full py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Réinitialiser le mot de passe
            </button>
        </form>

        <!-- Lien vers la page de connexion -->
        <p class="mt-6 text-center text-sm text-gray-400">
            Vous avez déjà un compte ? <a href="login.php" class="text-blue-400 hover:text-blue-600">Se connecter</a>
        </p>
    </div>

    <script>
        // Gérer la soumission du formulaire
        document.getElementById("passwordRecoveryForm").addEventListener("submit", function(event) {
            event.preventDefault(); // Empêche le rechargement de la page

            // Récupérer l'email du formulaire
            const email = document.getElementById("email").value;

            // Réinitialiser les messages d'erreur/succès
            const messageDiv = document.getElementById("message");
            messageDiv.classList.add("hidden");
            messageDiv.classList.remove("bg-red-500", "bg-green-500");
            messageDiv.innerHTML = '';

            // Vérification basique de l'email (peut être améliorée)
            if (!email || !validateEmail(email)) {
                messageDiv.classList.remove("hidden");
                messageDiv.classList.add("bg-red-500");
                messageDiv.innerHTML = 'Veuillez entrer une adresse email valide.';
                return;
            }

            // Envoyer une requête AJAX pour vérifier l'email et envoyer l'email de réinitialisation
            $.ajax({
                url: 'request/process_recovery.php', // Fichier PHP où la logique se passe
                method: 'POST',
                data: {
                    email: email
                },
                success: function(response) {
                    const result = JSON.parse(response);
                    if (result.success) {
                        messageDiv.classList.remove("hidden");
                        messageDiv.classList.add("bg-green-500");
                        messageDiv.innerHTML = result.message;
                    } else {
                        messageDiv.classList.remove("hidden");
                        messageDiv.classList.add("bg-red-500");
                        messageDiv.innerHTML = result.message;
                    }
                },
                error: function() {
                    messageDiv.classList.remove("hidden");
                    messageDiv.classList.add("bg-red-500");
                    messageDiv.innerHTML = 'Une erreur est survenue. Veuillez réessayer plus tard.';
                }
            });
        });

        // Fonction de validation d'email
        function validateEmail(email) {
            const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            return regex.test(email);
        }
    </script>
</body>

</html>