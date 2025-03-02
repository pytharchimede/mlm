<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
    <script src="https://cdn.jsdelivr.net/npm/tailwindcss@3.1.0/dist/tailwind.min.js"></script>
</head>

<body class="bg-gray-900 text-white flex items-center justify-center h-screen">
    <div class="w-full max-w-md bg-gray-800 p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-6">Réinitialiser votre mot de passe</h2>

        <form action="process_reset_password.php" method="POST" class="space-y-4">
            <input type="hidden" name="token" value="PUT-YOUR-TOKEN-HERE">

            <div>
                <label for="password" class="block text-sm">Nouveau mot de passe</label>
                <input type="password" id="password" name="password" required
                    class="w-full px-4 py-2 mt-2 bg-gray-700 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <button type="submit"
                class="w-full py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Réinitialiser le mot de passe</button>
        </form>

        <p class="mt-4 text-center text-sm">
            Vous vous souvenez de votre mot de passe ? <a href="login.php" class="text-blue-500">Se connecter</a>
        </p>
    </div>
</body>

</html>