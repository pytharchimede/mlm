<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importer VCard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        darkbg: "#1E293B",
                        darkcard: "#334155",
                        darktext: "#F8FAFC",
                        accent: "#14b8a6",
                        accentHover: "#0d9488"
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-100 dark:bg-darkbg flex items-center justify-center h-screen transition-all duration-500">
    <div class="bg-white dark:bg-darkcard p-6 rounded-2xl shadow-lg w-96 transition-all duration-500">
        <h2 class="text-xl font-semibold text-gray-700 dark:text-darktext mb-4 text-center">Importer un fichier VCard</h2>

        <form id="uploadForm" action="upload.php" method="POST" enctype="multipart/form-data">
            <input type="file" id="fileInput" name="vcard" accept=".vcf" class="w-full p-2 border rounded-lg bg-gray-200 dark:bg-darktext dark:text-black mb-4">
            <button type="submit" class="w-full bg-accent text-white py-2 rounded-lg hover:bg-accentHover transition-all duration-300">
                Importer
            </button>
        </form>

        <p id="logMessage" class="text-center text-gray-600 dark:text-darktext mt-2"></p>
    </div>

    <script>
        document.getElementById("uploadForm").addEventListener("submit", function() {
            let fileInput = document.getElementById("fileInput");
            if (fileInput.files.length > 0) {
                console.log("✅ Fichier sélectionné : " + fileInput.files[0].name);
                document.getElementById("logMessage").innerText = "Importation en cours...";
            } else {
                console.log("❌ Aucun fichier sélectionné !");
            }
        });

        // Mode sombre automatique
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.documentElement.classList.add('dark');
        }
    </script>
</body>

</html>