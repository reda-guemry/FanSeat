<?php
/**
 * Validation des Matchs - Administrateur
 */


include __DIR__ . '/../includes/header.php';
?>

<style>
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .animate-slide-down {
        animation: slideDown 0.6s ease-out;
    }

    .animate-scale-in {
        animation: scaleIn 0.5s ease-out;
    }

    .match-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .match-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 40px rgba(147, 51, 234, 0.25);
    }

    .status-badge {
        animation: scaleIn 0.3s ease-out;
    }
</style>

<!-- Hero Section -->
<section class="bg-gradient-to-r from-purple-700 via-purple-800 to-indigo-900 text-white py-16 animate-slide-down">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between">
            <div>
                <nav class="text-sm mb-4">
                    <a href="/sports-ticketing/admin/dashboard.php" class="text-purple-200 hover:text-white transition">
                        <i class="fas fa-home mr-2"></i>Dashboard
                    </a>
                    <span class="mx-2 text-purple-300">/</span>
                    <span class="text-white">Validation des Matchs</span>
                </nav>
                <h1 class="text-4xl font-bold mb-2">
                    <i class="fas fa-check-double mr-3"></i>
                    Validation des Matchs
                </h1>
                <p class="text-purple-200 text-lg">
                    Approuvez ou refusez les demandes d'événements sportifs
                </p>
            </div>
            <div class="hidden md:block">
                <div class="bg-white bg-opacity-20 backdrop-blur-lg rounded-2xl p-6 text-center">
                    <p class="text-sm text-purple-200 mb-1">En Attente</p>
                    <p class="text-4xl font-bold"><?php echo count($matchModel->getPendingMatches()); ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Filtres -->
<section class="py-8 bg-gradient-to-br from-purple-50 to-white">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap gap-3 justify-center animate-scale-in">
            <a href="?status=pending" class="px-6 py-3 rounded-xl font-semibold transition-all shadow-md hover:shadow-lg transform hover:scale-105 <?php echo $status_filter === 'pending' ? 'bg-gradient-to-r from-purple-600 to-purple-700 text-white' : 'bg-white text-purple-700 hover:bg-purple-50'; ?>">
                <i class="fas fa-clock mr-2"></i>
                En Attente
                <span class="ml-2 px-2 py-1 rounded-full text-xs <?php echo $status_filter === 'pending' ? 'bg-white bg-opacity-30' : 'bg-purple-100'; ?>">
                    <?php echo count($matchModel->getPendingMatches()); ?>
                </span>
            </a>
            <a href="?status=published" class="px-6 py-3 rounded-xl font-semibold transition-all shadow-md hover:shadow-lg transform hover:scale-105 <?php echo $status_filter === 'published' ? 'bg-gradient-to-r from-green-600 to-green-700 text-white' : 'bg-white text-green-700 hover:bg-green-50'; ?>">
                <i class="fas fa-check-circle mr-2"></i>
                Publiés
                <span class="ml-2 px-2 py-1 rounded-full text-xs <?php echo $status_filter === 'published' ? 'bg-white bg-opacity-30' : 'bg-green-100'; ?>">
                    <?php echo count($matchModel->getPublishedMatches()); ?>
                </span>
            </a>
            <a href="?status=rejected" class="px-6 py-3 rounded-xl font-semibold transition-all shadow-md hover:shadow-lg transform hover:scale-105 <?php echo $status_filter === 'rejected' ? 'bg-gradient-to-r from-red-600 to-red-700 text-white' : 'bg-white text-red-700 hover:bg-red-50'; ?>">
                <i class="fas fa-times-circle mr-2"></i>
                Refusés
            </a>
            <a href="?status=all" class="px-6 py-3 rounded-xl font-semibold transition-all shadow-md hover:shadow-lg transform hover:scale-105 <?php echo $status_filter === 'all' ? 'bg-gradient-to-r from-gray-700 to-gray-800 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'; ?>">
                <i class="fas fa-list mr-2"></i>
                Tous
                <span class="ml-2 px-2 py-1 rounded-full text-xs <?php echo $status_filter === 'all' ? 'bg-white bg-opacity-30' : 'bg-gray-100'; ?>">
                    <?php echo count($matchModel->getAll()); ?>
                </span>
            </a>
        </div>
    </div>
</section>

<!-- Liste des Matchs -->
<section class="py-12 bg-gradient-to-br from-purple-50 to-white">
    <div class="container mx-auto px-4">
        <?php if (empty($matches)): ?>
            <div class="bg-white rounded-2xl shadow-lg p-12 text-center animate-scale-in">
                <i class="fas fa-calendar-times text-7xl text-purple-300 mb-6"></i>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Aucun match trouvé</h3>
                <p class="text-gray-600">Il n'y a aucun match avec ce statut pour le moment</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <?php foreach ($matches as $index => $match): ?>
                    <?php 
                        $organizer = $userModel->getById($match['organizer_id']);
                        $categories = $categoryModel->getByMatch($match['id']);
                    ?>
                    <div class="match-card bg-white rounded-2xl shadow-lg overflow-hidden animate-scale-in" style="animation-delay: <?php echo $index * 0.1; ?>s">
                        <!-- Header avec statut -->
                        <div class="p-6 <?php 
                            if ($match['status'] === 'pending') echo 'bg-gradient-to-r from-yellow-400 to-orange-500';
                            elseif ($match['status'] === 'published') echo 'bg-gradient-to-r from-green-500 to-green-600';
                            elseif ($match['status'] === 'rejected') echo 'bg-gradient-to-r from-red-500 to-red-600';
                            else echo 'bg-gradient-to-r from-gray-500 to-gray-600';
                        ?> text-white">
                            <div class="flex items-center justify-between mb-2">
                                <span class="status-badge px-4 py-2 bg-white bg-opacity-30 backdrop-blur-lg rounded-full text-sm font-bold">
                                    <?php 
                                        if ($match['status'] === 'pending') echo '<i class="fas fa-clock mr-2"></i>En Attente';
                                        elseif ($match['status'] === 'published') echo '<i class="fas fa-check-circle mr-2"></i>Publié';
                                        elseif ($match['status'] === 'rejected') echo '<i class="fas fa-times-circle mr-2"></i>Refusé';
                                        else echo ucfirst($match['status']);
                                    ?>
                                </span>
                                <span class="text-sm">
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                    <?php echo date('d/m/Y', strtotime($match['created_at'])); ?>
                                </span>
                            </div>
                        </div>

                        <!-- Corps de la carte -->
                        <div class="p-6">
                            <!-- Équipes -->
                            <div class="flex items-center justify-between mb-6">
                                <div class="text-center flex-1">
                                    <?php if ($match['team1_logo']): ?>
                                        <img src="/sports-ticketing/assets/uploads/<?php echo htmlspecialchars($match['team1_logo']); ?>" 
                                             alt="<?php echo htmlspecialchars($match['team1_name']); ?>"
                                             class="w-16 h-16 object-contain mx-auto mb-2">
                                    <?php else: ?>
                                        <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                            <i class="fas fa-shield-alt text-2xl text-purple-600"></i>
                                        </div>
                                    <?php endif; ?>
                                    <h4 class="font-bold text-gray-800"><?php echo htmlspecialchars($match['team1_name']); ?></h4>
                                </div>
                                
                                <div class="text-3xl font-bold text-purple-600 mx-4">VS</div>
                                
                                <div class="text-center flex-1">
                                    <?php if ($match['team2_logo']): ?>
                                        <img src="/sports-ticketing/assets/uploads/<?php echo htmlspecialchars($match['team2_logo']); ?>" 
                                             alt="<?php echo htmlspecialchars($match['team2_name']); ?>"
                                             class="w-16 h-16 object-contain mx-auto mb-2">
                                    <?php else: ?>
                                        <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                            <i class="fas fa-shield-alt text-2xl text-pink-600"></i>
                                        </div>
                                    <?php endif; ?>
                                    <h4 class="font-bold text-gray-800"><?php echo htmlspecialchars($match['team2_name']); ?></h4>
                                </div>
                            </div>

                            <!-- Détails -->
                            <div class="space-y-3 mb-6">
                                <div class="flex items-center text-gray-700 bg-purple-50 p-3 rounded-lg">
                                    <i class="fas fa-calendar text-purple-600 mr-3 w-5"></i>
                                    <span class="font-semibold mr-2">Date:</span>
                                    <span><?php echo date('d F Y à H:i', strtotime($match['match_date'])); ?></span>
                                </div>
                                <div class="flex items-center text-gray-700 bg-purple-50 p-3 rounded-lg">
                                    <i class="fas fa-map-marker-alt text-purple-600 mr-3 w-5"></i>
                                    <span class="font-semibold mr-2">Lieu:</span>
                                    <span><?php echo htmlspecialchars($match['location']); ?></span>
                                </div>
                                <div class="flex items-center text-gray-700 bg-purple-50 p-3 rounded-lg">
                                    <i class="fas fa-user-tie text-purple-600 mr-3 w-5"></i>
                                    <span class="font-semibold mr-2">Organisateur:</span>
                                    <span><?php echo htmlspecialchars($organizer['name']); ?></span>
                                </div>
                                <div class="flex items-center text-gray-700 bg-purple-50 p-3 rounded-lg">
                                    <i class="fas fa-chair text-purple-600 mr-3 w-5"></i>
                                    <span class="font-semibold mr-2">Capacité:</span>
                                    <span><?php echo $match['total_seats']; ?> places</span>
                                </div>
                            </div>

                            <!-- Catégories -->
                            <?php if (!empty($categories)): ?>
                                <div class="mb-6">
                                    <h5 class="font-bold text-gray-800 mb-3 flex items-center">
                                        <i class="fas fa-tags text-purple-600 mr-2"></i>
                                        Catégories de Places
                                    </h5>
                                    <div class="space-y-2">
                                        <?php foreach ($categories as $category): ?>
                                            <div class="flex items-center justify-between bg-gradient-to-r from-purple-50 to-pink-50 p-3 rounded-lg">
                                                <span class="font-semibold text-gray-800"><?php echo htmlspecialchars($category['name']); ?></span>
                                                <div class="text-right">
                                                    <span class="text-purple-700 font-bold"><?php echo number_format($category['price'], 2); ?> MAD</span>
                                                    <span class="text-xs text-gray-600 block"><?php echo $category['available_seats']; ?> places</span>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Actions -->
                            <?php if ($match['status'] === 'pending'): ?>
                                <div class="flex gap-3">
                                    <a href="?action=approve&id=<?php echo $match['id']; ?>&status=<?php echo $status_filter; ?>" 
                                       onclick="return confirm('Approuver ce match et le publier?')"
                                       class="flex-1 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white py-3 px-4 rounded-xl font-bold transition-all shadow-lg hover:shadow-xl transform hover:scale-105 text-center">
                                        <i class="fas fa-check-circle mr-2"></i>
                                        Approuver
                                    </a>
                                    <a href="?action=reject&id=<?php echo $match['id']; ?>&status=<?php echo $status_filter; ?>" 
                                       onclick="return confirm('Refuser ce match?')"
                                       class="flex-1 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white py-3 px-4 rounded-xl font-bold transition-all shadow-lg hover:shadow-xl transform hover:scale-105 text-center">
                                        <i class="fas fa-times-circle mr-2"></i>
                                        Refuser
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-3 bg-gray-100 rounded-xl">
                                    <span class="text-gray-600 font-semibold">
                                        <?php 
                                            if ($match['status'] === 'published') echo '<i class="fas fa-check-circle text-green-600 mr-2"></i>Match publié';
                                            elseif ($match['status'] === 'rejected') echo '<i class="fas fa-times-circle text-red-600 mr-2"></i>Match refusé';
                                        ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>