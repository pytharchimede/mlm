<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Finova</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body class="bg-gray-900 text-white">

    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg text-center w-96">
            <img src="assets/img/source_plan_clair_petit.png" alt="Logo Finova" class="mx-auto mb-4 max-w-full h-auto">

            <h1 class="text-2xl font-bold mb-4 flex items-center justify-center">
                <i class="fa fa-sign-in-alt text-2xl text-green-400 mr-2"></i>
                Connexion
            </h1>

            <form id="loginForm">
                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-300 text-lg">Email</label>
                    <input type="email" id="email" name="email" required class="w-full p-2 bg-gray-700 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400">
                </div>

                <!-- Mot de passe -->
                <div class="mb-4">
                    <label for="password" class="block text-gray-300 text-lg">Mot de passe</label>
                    <input type="password" id="password" name="password" required class="w-full p-2 bg-gray-700 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400">
                </div>

                <!-- Se souvenir de moi -->
                <div class="flex items-center mb-4">
                    <input type="checkbox" id="remember" name="remember" class="text-green-400 focus:ring-green-400">
                    <label for="remember" class="text-gray-300 ml-2">Se souvenir de moi</label>
                </div>

                <!-- Boutons -->
                <div class="mb-4">
                    <button type="submit" class="w-full py-2 bg-green-500 text-white text-xl rounded-lg shadow-lg hover:bg-green-400 transition">
                        Se connecter
                    </button>
                </div>

                <!-- Mot de passe oublié -->
                <div class="text-gray-400 text-sm">
                    <a href="forgot_password.php" class="hover:text-green-400">Mot de passe oublié ?</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#loginForm').submit(function(event) {
                event.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: 'api/api_login.php',
                    data: formData,
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.status === 'success') {
                            window.location.href = 'app/dashboard.php'; // Rediriger vers le tableau de bord
                        } else {
                            alert(data.message); // Afficher l'erreur si la connexion échoue
                        }
                    },
                    error: function() {
                        alert('Une erreur est survenue. Veuillez réessayer.');
                    }
                });
            });
        });
    </script>

</body>

</html>