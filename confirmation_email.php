<?php
// Inclure les fichiers nécessaires
require_once 'model/Database.php'; // Connexion à la base de données
require_once 'model/Utilisateur.php'; // Votre classe Utilisateur

// Vérifier que le jeton et l'email sont passés en paramètre dans l'URL
if (isset($_GET['token']) && isset($_GET['email'])) {
    $token = $_GET['token'];
    $email = $_GET['email'];

    // Créer une instance de la classe Utilisateur
    $utilisateurObj = new Utilisateur();

    // Vérifier si l'utilisateur avec ce jeton et email existe
    $user = $utilisateurObj->getUserByEmail($email);

    if ($user) {
        // Vérifier si le jeton correspond
        if ($user['confirmation_token'] === $token) {
            // Vérifier si l'utilisateur est déjà validé
            if ($user['valide_utilisateur'] == 1) {
                echo "<div class='flex items-center justify-center min-h-screen bg-gray-900 text-white'>
                        <div class='bg-gray-800 p-8 rounded-lg shadow-lg text-center w-96'>
                            <i class='fa fa-check-circle text-5xl text-green-400 mb-4'></i>
                            <h1 class='text-2xl font-bold mb-2'>Votre compte est déjà activé.</h1>
                            <p class='text-gray-300 mb-4'>Vous pouvez vous connecter directement.</p>
                            <p class='text-gray-400 mb-6'>Redirection dans <span id='countdown'>5</span> secondes...</p>
                        </div>
                    </div>
                    <script>
                        var countdown = 5;
                        var countdownElement = document.getElementById('countdown');
                        var interval = setInterval(function() {
                            countdown--;
                            countdownElement.innerText = countdown;
                            if (countdown === 0) {
                                clearInterval(interval);
                                window.location.href = 'website/success_valide_email.php'; // Redirection vers la page de connexion
                            }
                        }, 1000);
                    </script>";
            } else {
                // Le jeton est valide, activer l'utilisateur
                if ($utilisateurObj->activateUser($email)) {
                    // Optionnel: Supprimer ou mettre à jour le jeton après activation
                    $utilisateurObj->updateConfirmationToken($email, null);
                    echo "<div class='flex items-center justify-center min-h-screen bg-gray-900 text-white'>
                            <div class='bg-gray-800 p-8 rounded-lg shadow-lg text-center w-96'>
                                <i class='fa fa-check-circle text-5xl text-green-400 mb-4'></i>
                                <h1 class='text-2xl font-bold mb-2'>Votre compte a été activé avec succès !</h1>
                                <p class='text-gray-300 mb-4'>Vous pouvez maintenant vous connecter à votre compte.</p>
                                <p class='text-gray-400 mb-6'>Redirection dans <span id='countdown'>5</span> secondes...</p>
                            </div>
                        </div>
                        <script>
                            var countdown = 5;
                            var countdownElement = document.getElementById('countdown');
                            var interval = setInterval(function() {
                                countdown--;
                                countdownElement.innerText = countdown;
                                if (countdown === 0) {
                                    clearInterval(interval);
                                    window.location.href = 'website/success_valide_email.php'; // Redirection vers la page de connexion
                                }
                            }, 1000);
                        </script>";
                } else {
                    echo "<div class='flex items-center justify-center min-h-screen bg-gray-900 text-white'>
                            <div class='bg-gray-800 p-8 rounded-lg shadow-lg text-center w-96'>
                                <i class='fa fa-exclamation-circle text-5xl text-red-400 mb-4'></i>
                                <h1 class='text-2xl font-bold mb-2'>Erreur lors de l'activation du compte</h1>
                                <p class='text-gray-300 mb-4'>Une erreur est survenue, veuillez réessayer.</p>
                            </div>
                        </div>";
                }
            }
        } else {
            // Le jeton ne correspond pas
            echo "<div class='flex items-center justify-center min-h-screen bg-gray-900 text-white'>
                    <div class='bg-gray-800 p-8 rounded-lg shadow-lg text-center w-96'>
                        <i class='fa fa-exclamation-circle text-5xl text-red-400 mb-4'></i>
                        <h1 class='text-2xl font-bold mb-2'>Erreur de confirmation</h1>
                        <p class='text-gray-300 mb-4'>Le lien de confirmation est invalide ou expiré.</p>
                    </div>
                </div>";
        }
    } else {
        // Aucun utilisateur correspondant à cet email
        echo "<div class='flex items-center justify-center min-h-screen bg-gray-900 text-white'>
                <div class='bg-gray-800 p-8 rounded-lg shadow-lg text-center w-96'>
                    <i class='fa fa-exclamation-circle text-5xl text-red-400 mb-4'></i>
                    <h1 class='text-2xl font-bold mb-2'>Erreur de confirmation</h1>
                    <p class='text-gray-300 mb-4'>Aucun utilisateur trouvé avec cet email.</p>
                </div>
            </div>";
    }
} else {
    echo "<div class='flex items-center justify-center min-h-screen bg-gray-900 text-white'>
            <div class='bg-gray-800 p-8 rounded-lg shadow-lg text-center w-96'>
                <i class='fa fa-exclamation-circle text-5xl text-red-400 mb-4'></i>
                <h1 class='text-2xl font-bold mb-2'>Erreur</h1>
                <p class='text-gray-300 mb-4'>Le lien de confirmation est incomplet. Veuillez vérifier votre email.</p>
            </div>
        </div>";
}
