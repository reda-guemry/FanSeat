<?php
/**
 * Page 404 - Page non trouvée
 */

$page_title = 'Page Non Trouvée - Sports Ticketing';
http_response_code(404);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/output.css">
</head>

<body>

    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4 text-center">
            <div class="max-w-2xl mx-auto">
                <!-- Icône 404 -->
                <div class="mb-8">
                    <i class="fas fa-exclamation-triangle text-9xl text-blue-600 mb-4"></i>
                </div>

                <!-- Titre -->
                <h1 class="text-6xl font-bold text-gray-800 mb-4">404</h1>
                <h2 class="text-3xl font-semibold text-gray-700 mb-6">Page Non Trouvée</h2>

                <!-- Message -->
                <p class="text-xl text-gray-600 mb-8">
                    Désolé, la page que vous recherchez n'existe pas ou a été déplacée.
                </p>

                <!-- Animation -->
                <div class="mb-8">
                    <svg class="mx-auto" width="200" height="200" viewBox="0 0 200 200">
                        <circle cx="100" cy="100" r="80" fill="none" stroke="#3b82f6" stroke-width="4"
                            stroke-dasharray="502" stroke-dashoffset="502" opacity="0.3">
                            <animate attributeName="stroke-dashoffset" from="502" to="0" dur="2s"
                                repeatCount="indefinite" />
                        </circle>
                    </svg>
                </div>

                <!-- Boutons d'action -->
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="/fan-seat/src/page/accueil.php"
                        class="bg-linear-to-r from-blue-600 to-blue-700 text-white px-8 py-3 rounded-lg font-semibold hover:from-blue-700 hover:to-blue-800 transition inline-block">
                        <i class="fas fa-home mr-2"></i>
                        Retour à l'Accueil
                    </a>
                    <a href="/fan-seat/src/page/matches.php"
                        class="bg-white border-2 border-blue-600 text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition inline-block">
                        <i class="fas fa-futbol mr-2"></i>
                        Voir les Matchs
                    </a>
                </div>

                <!-- Liens utiles -->
                <div class="mt-12 p-6 bg-white rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold mb-4 text-gray-800">Liens Utiles</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="/fan-seat/src/page/accueil.php"
                            class="text-blue-600 hover:text-blue-700 transition">
                            <i class="fas fa-home block text-2xl mb-2"></i>
                            Accueil
                        </a>
                        <a href="/fan-seat/src/page/matches.php"
                            class="text-blue-600 hover:text-blue-700 transition">
                            <i class="fas fa-calendar block text-2xl mb-2"></i>
                            Matchs
                        </a>
                        <a href="/fan-seat/src/page/contact.php"
                            class="text-blue-600 hover:text-blue-700 transition">
                            <i class="fas fa-envelope block text-2xl mb-2"></i>
                            Contact
                        </a>
                        <a href="/fan-seat/src/page/help.php"
                            class="text-blue-600 hover:text-blue-700 transition">
                            <i class="fas fa-question-circle block text-2xl mb-2"></i>
                            Aide
                        </a>
                    </div>
                </div>

                <!-- Message d'erreur technique (optionnel) -->
                <?php if (isset($_SERVER['REQUEST_URI'])): ?>
                    <div class="mt-6 text-sm text-gray-500">
                        <p>URL demandée: <code
                                class="bg-gray-200 px-2 py-1 rounded"><?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?></code>
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        section>div>div {
            animation: fadeIn 0.6s ease-out;
        }
    </style>


</body>

</html>
