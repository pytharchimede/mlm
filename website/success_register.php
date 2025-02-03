<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription en Attente - Finova</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-900 text-white">
    <div class="bg-gray-800 p-8 rounded-lg shadow-lg text-center w-96">
        <i class="fa fa-envelope text-5xl text-yellow-400 mb-4"></i>
        <h1 class="text-2xl font-bold mb-2">Inscription en Attente</h1>
        <p class="text-gray-300 mb-4">
            Merci pour votre inscription ! Nous avons envoyé un e-mail de confirmation.
        </p>
        <p class="text-gray-400 mb-6">
            Vérifiez votre boîte de réception et cliquez sur le lien de confirmation pour finaliser votre inscription.
        </p>

        <!-- Box rondes pour accéder aux boîtes mail -->
        <div class="flex justify-center gap-4">
            <a href="https://mail.google.com" target="_blank"
                class="w-16 h-16 flex items-center justify-center bg-red-500 text-white text-3xl rounded-full shadow-lg hover:bg-red-400 transition">
                <i class="fab fa-google"></i>
            </a>
            <a href="https://outlook.live.com/mail/" target="_blank"
                class="w-16 h-16 flex items-center justify-center bg-blue-600 text-white text-3xl rounded-full shadow-lg hover:bg-blue-500 transition">
                <i class="fab fa-microsoft"></i>
            </a>
            <a href="https://mail.yahoo.com/" target="_blank"
                class="w-16 h-16 flex items-center justify-center bg-purple-600 text-white text-3xl rounded-full shadow-lg hover:bg-purple-500 transition">
                <i class="fab fa-yahoo"></i>
            </a>
            <a href="https://www.icloud.com/mail" target="_blank"
                class="w-16 h-16 flex items-center justify-center bg-gray-600 text-white text-3xl rounded-full shadow-lg hover:bg-gray-500 transition">
                <i class="fa fa-apple"></i>
            </a>
        </div>
    </div>
</body>

</html>