<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service de Recrutement</title>
    <script defer src="../plugins/js/fontawesome-all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style_service.css" rel="stylesheet">
</head>

<body class="bg-gray-900 text-white">

    <header class="relative w-full h-96 flex items-center justify-center text-center bg-cover bg-center" style="background-image: url('https://source.unsplash.com/1600x900/?team,success');">
        <div class="absolute inset-0 bg-black bg-opacity-60"></div>
        <div class="relative z-10">
            <h1 class="text-4xl md:text-5xl font-extrabold">🎯 Aide tes amis à réussir !</h1>
            <p class="mt-2 text-lg md:text-xl text-gray-300">Utilise ces supports pour les convaincre et agrandir ton réseau.</p>
        </div>
    </header>

    <section class="py-12 px-6">
        <div class="container mx-auto text-center">
            <h2 class="text-4xl font-bold mb-6">Recrutez Facilement Vos Filleuls</h2>
            <p class="text-lg mb-8">Utilisez ces supports pour partager notre vision et agrandir votre réseau.</p>
        </div>
    </section>

    <section id="media-section" class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    </section>

    <section class="container mx-auto px-6 mt-12">
        <h2 class="text-3xl font-bold text-center mb-6">Pourquoi nous faire confiance ?</h2>

        <p class="text-lg text-center mb-8 text-gray-300">
            Nous sommes une ONG active depuis plusieurs années, avec des milliers de membres satisfaits.
            Découvrez pourquoi vous pouvez nous faire confiance !
        </p>

        <!-- Cards section -->
        <div id="cards-section" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            <!-- Cards will be injected here by JavaScript -->
        </div>
    </section>

    <!-- 📝 SECTION TEXTES INSPIRANTS À PARTAGER -->
    <section class="py-16 px-6 bg-gray-800 text-center" id="inspirational-text-section">
        <h2 class="text-3xl font-bold mb-4 text-white">✍️ Textes Inspirants</h2>
        <div class="max-w-3xl mx-auto">
            <div id="inspirational-text-carousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner" id="carousel-text-container">
                    <!-- Les éléments de texte seront ajoutés ici dynamiquement -->
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#inspirational-text-carousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#inspirational-text-carousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>
        </div>
    </section>



    <!-- 🎥 SECTION VIDÉO PROMOTIONNELLE -->
    <section class="py-16 px-6 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-8">🎬 Vidéo pour Motiver Tes Amis</h2>
        <div class="flex justify-center">
            <iframe class="w-full md:w-2/3 h-64 md:h-96 rounded-lg shadow-xl" src="../assets/video/explication_video.mp4" frameborder="0" allowfullscreen></iframe>
        </div>
    </section>

    <!-- 📣 SECTION TÉMOIGNAGES -->
    <section class="py-16 px-6 bg-gray-800 text-center">
        <h2 class="text-3xl font-bold mb-6 text-white">💬 Témoignages de Réussite</h2>
        <div id="testimonials-container" class="max-w-3xl mx-auto space-y-6">
            <!-- Les témoignages seront insérés ici dynamiquement -->
        </div>
    </section>

    <!-- 📣 SECTION OBJECTIONS -->
    <section class="py-16 px-6 bg-gray-800 text-center">
        <h2 class="text-3xl font-bold mb-6">❓ Réponses aux objections</h2>
        <div class="container mx-auto space-y-6">
            <div class="bg-gray-700 p-6 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold mb-4">"Et si c'était une arnaque ?"</h3>
                <p>Nous sommes une ONG reconnue, avec des milliers de témoignages de succès. Vous pouvez vérifier notre historique et voir que nos membres bénéficient réellement de notre programme.</p>
            </div>
            <div class="bg-gray-700 p-6 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold mb-4">"Est-ce que ça marche vraiment ?"</h3>
                <p>Oui, nous avons des milliers de membres qui ont déjà atteint leurs objectifs grâce à ce programme. Vous pouvez lire leurs histoires pour voir les résultats concrets.</p>
            </div>
            <div class="bg-gray-700 p-6 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold mb-4">"J'ai peur de l'échec, et si je ne réussis pas ?"</h3>
                <p>Notre programme est conçu pour vous accompagner étape par étape. Vous ne serez jamais seul dans ce processus. Rejoignez une communauté active qui vous soutiendra à chaque étape.</p>
            </div>
            <div class="bg-gray-700 p-6 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold mb-4">"Est-ce que je dois investir beaucoup d'argent pour commencer ?"</h3>
                <p>Non, notre programme est accessible à tous. Nous croyons que chaque personne mérite une chance de réussir, c'est pourquoi nous offrons une entrée en douceur avec des options abordables.</p>
            </div>
        </div>
    </section>

    <!-- 📣 FOOTER -->
    <footer class="bg-gray-900 py-6 text-center text-gray-400">
        <p>&copy; <?php echo gmdate('Y'); ?> Tous droits réservés | <strong>CMDB</strong></p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/script_service.js"></script>
</body>

</html>