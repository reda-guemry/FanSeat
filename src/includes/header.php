<?php
/**
 * Header du site - Inclus dans toutes les pages
 */

// Démarrer la session si elle n'est pas déjà démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Définir les variables pour l'utilisateur connecté
$is_logged_in = isset($_SESSION['user_id']);
$user_name = $_SESSION['user_name'] ?? '';
$user_role = $_SESSION['user_role'] ?? '';
?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Plateforme de billetterie sportive - Achetez vos billets pour les matchs de football">

    <title><?php echo $page_title ?? 'Sports Ticketing Platform'; ?></title>

    <link rel="stylesheet" href="../css/output.css">

    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>

<body class="bg-gray-50">

    <!-- Navigation -->
    <nav class="bg-gradient-to-r from-purple-700 to-purple-800 shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <a href="/sports-ticketing/public/index.php"
                    class="flex items-center space-x-2 text-white text-2xl font-bold">
                    <i class="fas fa-ticket-alt"></i>
                    <span>Fan Seat</span>
                </a>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="/sports-ticketing/public/index.php" class="nav-link text-white hover:text-purple-200">
                        <i class="fas fa-home mr-1"></i> Accueil
                    </a>
                    <a href="/sports-ticketing/public/matches.php" class="nav-link text-white hover:text-purple-200">
                        <i class="fas fa-futbol mr-1"></i> Matchs
                    </a>

                    <?php if ($is_logged_in): ?>
                        <!-- Menu utilisateur connecté -->
                        <?php if ($user_role === 'admin'): ?>
                            <a href="/sports-ticketing/admin/dashboard.php" class="nav-link text-white hover:text-purple-200">
                                <i class="fas fa-tachometer-alt mr-1"></i> Dashboard Admin
                            </a>
                        <?php elseif ($user_role === 'organizer'): ?>
                            <a href="/sports-ticketing/organizer/dashboard.php"
                                class="nav-link text-white hover:text-purple-200">
                                <i class="fas fa-calendar-plus mr-1"></i> Dashboard Organisateur
                            </a>
                        <?php else: ?>
                            <a href="/sports-ticketing/user/dashboard.php" class="nav-link text-white hover:text-purple-200">
                                <i class="fas fa-user mr-1"></i> Mes Billets
                            </a>
                        <?php endif; ?>

                        <!-- Dropdown utilisateur -->
                        <div class="relative group">
                            <button class="flex items-center text-white hover:text-purple-200">
                                <i class="fas fa-user-circle text-2xl mr-2"></i>
                                <span><?php echo htmlspecialchars($user_name); ?></span>
                                <i class="fas fa-chevron-down ml-2"></i>
                            </button>
                            <div
                                class="hidden group-hover:block absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-2">
                                <a href="/sports-ticketing/user/profile.php"
                                    class="block px-4 py-2 text-gray-800 hover:bg-purple-50">
                                    <i class="fas fa-user-edit mr-2"></i> Mon Profil
                                </a>
                                <a href="/sports-ticketing/public/logout.php"
                                    class="block px-4 py-2 text-red-600 hover:bg-red-50">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Menu visiteur non connecté -->
                        <a href="/sports-ticketing/public/login.php" class="nav-link text-white hover:text-purple-200">
                            <i class="fas fa-sign-in-alt mr-1"></i> Connexion
                        </a>
                        <a href="/sports-ticketing/public/register.php"
                            class="btn-primary bg-white text-purple-700 px-4 py-2 rounded-lg font-semibold hover:bg-purple-100 hover:text-purple-900 transition">
                            <i class="fas fa-user-plus mr-1"></i> Inscription
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="md:hidden text-white text-2xl">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden pb-4">
                <a href="/sports-ticketing/public/index.php" class="block text-white py-2 hover:text-purple-200">
                    <i class="fas fa-home mr-2"></i> Accueil
                </a>
                <a href="/sports-ticketing/public/matches.php" class="block text-white py-2 hover:text-purple-200">
                    <i class="fas fa-futbol mr-2"></i> Matchs
                </a>
                <?php if ($is_logged_in): ?>
                    <?php if ($user_role === 'admin'): ?>
                        <a href="/sports-ticketing/admin/dashboard.php" class="block text-white py-2 hover:text-purple-200">
                            <i class="fas fa-tachometer-alt mr-2"></i> Dashboard Admin
                        </a>
                    <?php elseif ($user_role === 'organizer'): ?>
                        <a href="/sports-ticketing/organizer/dashboard.php" class="block text-white py-2 hover:text-purple-200">
                            <i class="fas fa-calendar-plus mr-2"></i> Dashboard Organisateur
                        </a>
                    <?php else: ?>
                        <a href="/sports-ticketing/user/dashboard.php" class="block text-white py-2 hover:text-purple-200">
                            <i class="fas fa-user mr-2"></i> Mes Billets
                        </a>
                    <?php endif; ?>
                    <a href="/sports-ticketing/user/profile.php" class="block text-white py-2 hover:text-purple-200">
                        <i class="fas fa-user-edit mr-2"></i> Mon Profil
                    </a>
                    <a href="/sports-ticketing/public/logout.php" class="block text-red-300 py-2 hover:text-red-100">
                        <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                    </a>
                <?php else: ?>
                    <a href="/sports-ticketing/public/login.php" class="block text-white py-2 hover:text-purple-200">
                        <i class="fas fa-sign-in-alt mr-2"></i> Connexion
                    </a>
                    <a href="/sports-ticketing/public/register.php" class="block text-white py-2 hover:text-purple-200">
                        <i class="fas fa-user-plus mr-2"></i> Inscription
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>


    <!-- Messages Flash -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="container mx-auto px-4 mt-4">
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <p><?php echo htmlspecialchars($_SESSION['success']); ?></p>
                </div>
            </div>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="container mx-auto px-4 mt-4">
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <p><?php echo htmlspecialchars($_SESSION['error']); ?></p>
                </div>
            </div>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <script>
        // Toggle mobile menu
        document.getElementById('mobile-menu-btn').addEventListener('click', function () {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });
    </script>