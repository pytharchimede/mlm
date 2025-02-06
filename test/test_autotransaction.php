<?php
// Inclure la classe AutoTransaction
include '../model/AutoTransaction.php';
include '../model/Config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $amount = $_POST['amount'];
    $currency = $_POST['currency'];
    $wallet = $_POST['wallet'];
    $email = $_POST['email']; // Récupérer l'email du destinataire

    // Remplacer par votre clé API NowPayments
    $apiKey = Config::get('API_KEY');

    // Créer une instance de la classe AutoTransaction
    $transaction = new AutoTransaction($apiKey);

    // Effectuer le paiement
    $response = $transaction->sendPayment($amount, $currency, $wallet, "Transaction automatique", $email);

    // Vérifier la réponse
    if (isset($response['error'])) {
        // Si erreur, afficher l'erreur
        echo '<h2 class="text-center text-2xl font-bold mb-4 text-white">Erreur :</h2>';
        echo '<pre class="bg-red-500 p-4 rounded-lg shadow-md text-white">';
        print_r($response);
        echo '</pre>';
    } else {
        // Afficher la réponse de la transaction
        echo '<h2 class="text-center text-2xl font-bold mb-4 text-white">Réponse de l\'API NowPayments :</h2>';
        echo '<pre class="bg-green-500 p-4 rounded-lg shadow-md text-white">';
        print_r($response);
        echo '</pre>';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test de Paiement NowPayments</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-gray-100 flex justify-center items-center min-h-screen">

    <div class="bg-gray-800 p-8 rounded-xl shadow-xl max-w-lg w-full">
        <h1 class="text-3xl font-semibold text-center text-white mb-6">Test de Paiement</h1>

        <form method="POST" action="" class="space-y-6">
            <div>
                <label for="amount" class="block text-sm font-medium text-gray-300">Montant (en USD):</label>
                <input type="number" name="amount" id="amount" class="mt-1 block w-full p-3 border border-gray-600 rounded-md shadow-sm bg-gray-700 text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>

            <div>
                <label for="currency" class="block text-sm font-medium text-gray-300">Devise (USDT):</label>
                <input type="text" name="currency" id="currency" value="USDT" readonly class="mt-1 block w-full p-3 border border-gray-600 rounded-md shadow-sm bg-gray-700 text-gray-500">
            </div>

            <div>
                <label for="wallet" class="block text-sm font-medium text-gray-300">Adresse du portefeuille destinataire (TRC20):</label>
                <input type="text" name="wallet" id="wallet" class="mt-1 block w-full p-3 border border-gray-600 rounded-md shadow-sm bg-gray-700 text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-300">Email du destinataire :</label>
                <input type="email" name="email" id="email" class="mt-1 block w-full p-3 border border-gray-600 rounded-md shadow-sm bg-gray-700 text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white py-3 px-4 rounded-md shadow-md hover:bg-indigo-700 transition duration-300">Envoyer le paiement</button>
        </form>
    </div>

</body>

</html>