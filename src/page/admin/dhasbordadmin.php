<?php
/**
 * Dashboard Administrateur
 */





include __DIR__ . '/../includes/header.php';
?>



<!-- Hero Section -->
<section class="bg-linear-to-r from-purple-700 to-purple-900 text-white py-12 animate-fade-in-up">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-bold mb-2">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard Administrateur
                </h1>
                <p class="text-purple-200 text-lg">
                    Bienvenue, <?php echo htmlspecialchars($_SESSION['user_name']); ?> 
                    <span class="ml-3">📊</span>
                </p>
            </div>
            <div class="hidden md:block">
                <div class="text-right">
                    <p class="text-sm text-purple-200">Dernière connexion</p>
                    <p class="text-lg font-semibold"><?php echo date('d/m/Y H:i'); ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistiques Cards -->
<section class="py-12 bg-linear-to-br from-purple-50 to-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Utilisateurs -->
            <div class="card-smooth bg-white rounded-2xl shadow-lg p-6 border-l-4 border-purple-600 animate-fade-in-up" style="animation-delay: 0.1s">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-2">Total Utilisateurs</p>
                        <h3 class="text-4xl font-bold text-gray-800"><?php echo $stats['total_users']; ?></h3>
                        <p class="text-purple-600 text-sm mt-2">
                            <i class="fas fa-arrow-up mr-1"></i>
                            Actifs
                        </p>
                    </div>
                    <div class="bg-linear-to-br from-purple-500 to-purple-700 w-16 h-16 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-users text-2xl text-white"></i>
                    </div>
                </div>
            </div>

            <!-- Total Organisateurs -->
            <div class="card-smooth bg-white rounded-2xl shadow-lg p-6 border-l-4 border-pink-600 animate-fade-in-up" style="animation-delay: 0.2s">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-2">Organisateurs</p>
                        <h3 class="text-4xl font-bold text-gray-800"><?php echo $stats['total_organizers']; ?></h3>
                        <p class="text-pink-600 text-sm mt-2">
                            <i class="fas fa-briefcase mr-1"></i>
                            Professionnels
                        </p>
                    </div>
                    <div class="bg-linear-to-br from-pink-500 to-pink-700 w-16 h-16 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-user-tie text-2xl text-white"></i>
                    </div>
                </div>
            </div>

            <!-- Total Matchs -->
            <div class="card-smooth bg-white rounded-2xl shadow-lg p-6 border-l-4 border-indigo-600 animate-fade-in-up" style="animation-delay: 0.3s">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-2">Total Matchs</p>
                        <h3 class="text-4xl font-bold text-gray-800"><?php echo $stats['total_matches']; ?></h3>
                        <p class="text-indigo-600 text-sm mt-2">
                            <i class="fas fa-calendar-check mr-1"></i>
                            <?php echo $stats['pending_matches']; ?> en attente
                        </p>
                    </div>
                    <div class="bg-linear-to-br from-indigo-500 to-indigo-700 w-16 h-16 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-futbol text-2xl text-white"></i>
                    </div>
                </div>
            </div>

            <!-- Revenus Totaux -->
            <div class="card-smooth bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-600 animate-fade-in-up" style="animation-delay: 0.4s">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-2">Revenus Totaux</p>
                        <h3 class="text-4xl font-bold text-gray-800"><?php echo number_format($stats['total_revenue'], 0); ?></h3>
                        <p class="text-green-600 text-sm mt-2">
                            <i class="fas fa-coins mr-1"></i>
                            MAD
                        </p>
                    </div>
                    <div class="bg-linear-to-br from-green-500 to-green-700 w-16 h-16 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-dollar-sign text-2xl text-white"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Rapide -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <a href="/sports-ticketing/admin/users.php" class="card-smooth gradient-purple gradient-purple-hover rounded-2xl p-6 text-white shadow-lg transform transition-all animate-fade-in-up" style="animation-delay: 0.5s">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold">Gérer les Utilisateurs</h3>
                    <i class="fas fa-users-cog text-3xl"></i>
                </div>
                <p class="text-purple-100 mb-4">Activer, désactiver et gérer tous les comptes utilisateurs</p>
                <div class="flex items-center text-sm">
                    <span>Accéder</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </a>

            <a href="/sports-ticketing/admin/matches.php" class="card-smooth gradient-purple gradient-purple-hover rounded-2xl p-6 text-white shadow-lg transform transition-all animate-fade-in-up" style="animation-delay: 0.6s">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold">Valider les Matchs</h3>
                    <i class="fas fa-check-circle text-3xl"></i>
                </div>
                <p class="text-purple-100 mb-4">Approuver ou refuser les demandes d'événements</p>
                <div class="flex items-center text-sm">
                    <span>Accéder</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </a>

            <a href="/sports-ticketing/admin/statistics.php" class="card-smooth gradient-purple gradient-purple-hover rounded-2xl p-6 text-white shadow-lg transform transition-all animate-fade-in-up" style="animation-delay: 0.7s">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold">Statistiques Avancées</h3>
                    <i class="fas fa-chart-line text-3xl"></i>
                </div>
                <p class="text-purple-100 mb-4">Consultez les rapports et analyses détaillées</p>
                <div class="flex items-center text-sm">
                    <span>Accéder</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Matchs en Attente -->
            <div class="bg-white rounded-2xl shadow-lg p-6 animate-slide-in-right" style="animation-delay: 0.8s">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">
                        <i class="fas fa-clock text-purple-600 mr-2"></i>
                        Matchs en Attente
                    </h2>
                    <span class="bg-purple-100 text-purple-700 px-4 py-2 rounded-full font-semibold">
                        <?php echo count($pending_matches); ?>
                    </span>
                </div>

                <div class="space-y-4 max-h-96 overflow-y-auto">
                    <?php if (empty($pending_matches)): ?>
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-check-circle text-6xl mb-4 text-purple-300"></i>
                            <p>Aucun match en attente de validation</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($pending_matches as $match): ?>
                            <div class="border border-purple-100 rounded-xl p-4 hover:shadow-md transition-all hover:border-purple-300">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-bold text-gray-800">
                                        <?php echo htmlspecialchars($match['team1_name']); ?> 
                                        <span class="text-purple-600 mx-2">VS</span>
                                        <?php echo htmlspecialchars($match['team2_name']); ?>
                                    </h4>
                                </div>
                                <p class="text-sm text-gray-600 mb-3">
                                    <i class="fas fa-calendar mr-2"></i>
                                    <?php echo date('d/m/Y H:i', strtotime($match['match_date'])); ?>
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                    <?php echo htmlspecialchars($match['location']); ?>
                                </p>
                                <div class="flex gap-2">
                                    <a href="/sports-ticketing/admin/validate-match.php?id=<?php echo $match['id']; ?>&action=approve" 
                                       class="flex-1 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-center transition-all text-sm font-semibold">
                                        <i class="fas fa-check mr-2"></i>Approuver
                                    </a>
                                    <a href="/sports-ticketing/admin/validate-match.php?id=<?php echo $match['id']; ?>&action=reject" 
                                       class="flex-1 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-center transition-all text-sm font-semibold">
                                        <i class="fas fa-times mr-2"></i>Refuser
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Utilisateurs Récents -->
            <div class="bg-white rounded-2xl shadow-lg p-6 animate-slide-in-right" style="animation-delay: 0.9s">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">
                        <i class="fas fa-user-plus text-purple-600 mr-2"></i>
                        Utilisateurs Récents
                    </h2>
                    <a href="/sports-ticketing/admin/users.php" class="text-purple-600 hover:text-purple-700 font-semibold text-sm">
                        Voir tout <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>

                <div class="space-y-4">
                    <?php foreach ($recent_users as $user): ?>
                        <div class="flex items-center justify-between p-4 bg-purple-50 rounded-xl hover:bg-purple-100 transition-all">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-linear-to-br from-purple-500 to-purple-700 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4 shadow-md">
                                    <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800"><?php echo htmlspecialchars($user['name']); ?></h4>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($user['email']); ?></p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                    <?php 
                                        if ($user['role'] === 'admin') echo 'bg-red-100 text-red-700';
                                        elseif ($user['role'] === 'organizer') echo 'bg-blue-100 text-blue-700';
                                        else echo 'bg-green-100 text-green-700';
                                    ?>">
                                    <?php echo ucfirst($user['role']); ?>
                                </span>
                                <p class="text-xs text-gray-500 mt-1">
                                    <?php echo date('d/m/Y', strtotime($user['created_at'])); ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tickets Vendus Chart -->
<section class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <div class="bg-linear-to-r from-purple-700 to-purple-900 rounded-2xl shadow-2xl p-8 text-white">
            <h2 class="text-3xl font-bold mb-6">
                <i class="fas fa-ticket-alt mr-3"></i>
                Aperçu des Ventes
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-xl p-6">
                    <p class="text-purple-200 mb-2">Billets Vendus</p>
                    <h3 class="text-4xl font-bold"><?php echo $stats['total_tickets']; ?></h3>
                    <p class="text-sm text-purple-300 mt-2">
                        <i class="fas fa-arrow-up mr-1"></i> Total
                    </p>
                </div>
                <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-xl p-6">
                    <p class="text-purple-200 mb-2">Revenus</p>
                    <h3 class="text-4xl font-bold"><?php echo number_format($stats['total_revenue'], 2); ?> MAD</h3>
                    <p class="text-sm text-purple-300 mt-2">
                        <i class="fas fa-coins mr-1"></i> Cumulé
                    </p>
                </div>
                <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-xl p-6">
                    <p class="text-purple-200 mb-2">Taux de Remplissage</p>
                    <h3 class="text-4xl font-bold">
                        <?php 
                            $total_capacity = $stats['total_matches'] * 2000; // Assuming avg 2000 seats
                            $fill_rate = $total_capacity > 0 ? ($stats['total_tickets'] / $total_capacity * 100) : 0;
                            echo number_format($fill_rate, 1); 
                        ?>%
                    </h3>
                    <p class="text-sm text-purple-300 mt-2">
                        <i class="fas fa-chart-pie mr-1"></i> Moyen
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>