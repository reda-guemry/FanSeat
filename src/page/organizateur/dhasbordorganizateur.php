<?php
/**
 * Dashboard Organisateur
 */


require_once __DIR__ . '/../../config/requirefichier.php';

$resule = null;

$page_title = ' Dashboard Organisateur - Sports Ticketing';

$organizateur = Authentification::checkuser();

$pending_matches = MatchGame::getMatchesByStatus('pending');

$published_matches = MatchGame::getMatchesByStatus('approved');


include __DIR__ . '/../../includes/header.php';
?>

<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: .7;
        }
    }

    @keyframes shimmer {

        0%,
        100% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out;
    }

    .animate-slide-in-right {
        animation: slideInRight 0.6s ease-out;
    }

    .animate-pulse-slow {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    .card-hover {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .card-hover:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 40px rgba(147, 51, 234, 0.3);
    }

    .gradient-shimmer {
        background: linear-gradient(135deg, #7c3aed 0%, #a855f7 50%, #c084fc 100%);
        background-size: 200% 200%;
        animation: shimmer 3s ease infinite;
    }
</style>

<!-- Hero Section -->
<section class="bg-gradient-to-r from-purple-700 via-purple-800 to-indigo-900 text-white py-16 animate-fade-in-up">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row items-center justify-between">
            <div class="mb-6 lg:mb-0">
                <h1 class="text-5xl font-black mb-3 flex items-center">
                    <i class="fas fa-chart-line mr-4 text-yellow-300"></i>
                    Dashboard Organisateur
                </h1>
                <p class="text-purple-200 text-xl">
                    Bienvenue, <span
                        class="font-bold text-white"><?php echo htmlspecialchars($organizateur); ?></span> 
                </p>
                <p class="text-purple-300 mt-2">
                    <i class="fas fa-calendar mr-2"></i>
                    <?php echo date('l d F Y'); ?>
                </p>
            </div>

            <div class="flex gap-4">
                <a href="/fan-seat/src/page/organizateur/create-match.php"
                    class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-8 py-4 rounded-2xl font-bold transition-all shadow-2xl hover:shadow-green-500/50 transform hover:scale-105 flex items-center gap-3">
                    <i class="fas fa-plus-circle text-2xl"></i>
                    <div class="text-left">
                        <div class="text-sm opacity-90">Créer un</div>
                        <div class="text-lg">Nouveau Match</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Cards -->
<section class="py-12 bg-gradient-to-br from-purple-50 via-white to-pink-50">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">

            <!-- Total Matchs -->
            <div class="card-hover bg-white rounded-3xl shadow-xl p-8 border-t-4 border-purple-600 animate-fade-in-up"
                style="animation-delay: 0.1s">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-700 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-futbol text-3xl text-white"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-500 text-sm font-semibold">TOTAL</p>
                        <p class="text-4xl font-black text-gray-800"><?php echo $organizateur -> getCountMatch() ; ?></p>
                    </div>
                </div>
                <p class="text-purple-700 font-bold flex items-center">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    Événements créés
                </p>
            </div>

            <!-- Billets Vendus -->
            <div class="card-hover bg-white rounded-3xl shadow-xl p-8 border-t-4 border-green-600 animate-fade-in-up"
                style="animation-delay: 0.2s">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-700 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-ticket-alt text-3xl text-white"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-500 text-sm font-semibold">VENDUS</p>
                        <p class="text-4xl font-black text-gray-800"><?php //echo $stats['tickets_sold']; ?></p>
                    </div>
                </div>
                <p class="text-green-700 font-bold flex items-center">
                    <i class="fas fa-arrow-up mr-2"></i>
                    Billets écoulés
                </p>
            </div>

            <!-- Revenus -->
            <div class="card-hover bg-white rounded-3xl shadow-xl p-8 border-t-4 border-yellow-600 animate-fade-in-up"
                style="animation-delay: 0.3s">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-yellow-700 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-coins text-3xl text-white"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-500 text-sm font-semibold">REVENUS</p>
                        <p class="text-4xl font-black text-gray-800">
                            <?php //echo number_format($stats['revenue'], 0); ?></p>
                    </div>
                </div>
                <p class="text-yellow-700 font-bold flex items-center">
                    <i class="fas fa-money-bill-wave mr-2"></i>
                    MAD générés
                </p>
            </div>

            <!-- En Attente -->
            <div class="card-hover bg-white rounded-3xl shadow-xl p-8 border-t-4 border-orange-600 animate-fade-in-up"
                style="animation-delay: 0.4s">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-700 rounded-2xl flex items-center justify-center shadow-lg animate-pulse-slow">
                        <i class="fas fa-clock text-3xl text-white"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-500 text-sm font-semibold">ATTENTE</p>
                        <p class="text-4xl font-black text-gray-800"><?php echo $organizateur -> getCountMatchPending(); ?></p>
                    </div>
                </div>
                <p class="text-orange-700 font-bold flex items-center">
                    <i class="fas fa-hourglass-half mr-2"></i>
                    À valider
                </p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
            <a href="/fan-seat/src/page/organizateur/create-match.php"
                class="card-hover gradient-shimmer rounded-3xl p-8 text-white shadow-2xl animate-fade-in-up"
                style="animation-delay: 0.5s">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-2xl font-black">Créer un Match</h3>
                    <i class="fas fa-plus-circle text-5xl opacity-30"></i>
                </div>
                <p class="text-purple-100 mb-6">Organisez un nouveau événement sportif</p>
                <div class="flex items-center text-sm font-semibold">
                    <span>Commencer</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </a>

            <a href="/sports-ticketing/organizer/my-matches.php"
                class="card-hover bg-gradient-to-br from-pink-600 to-rose-700 rounded-3xl p-8 text-white shadow-2xl animate-fade-in-up"
                style="animation-delay: 0.6s">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-2xl font-black">Mes Matchs</h3>
                    <i class="fas fa-list text-5xl opacity-30"></i>
                </div>
                <p class="text-pink-100 mb-6">Gérez tous vos événements créés</p>
                <div class="flex items-center text-sm font-semibold">
                    <span>Voir tout</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </a>

        </div>

        <!-- Matches Lists -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            <!-- Pending Matches -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden animate-slide-in-right"
                style="animation-delay: 0.8s">
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white px-8 py-6">
                    <h2 class="text-2xl font-black flex items-center justify-between">
                        <span>
                            <i class="fas fa-clock mr-3"></i>
                            Matchs en Attente
                        </span>
                        <span class="bg-white text-orange-600 px-4 py-2 rounded-full font-bold text-lg">
                            <?php //echo count($pending_matches); ?>
                        </span>
                    </h2>
                </div>

                <div class="p-6 max-h-96 overflow-y-auto">
                    <?php if (empty($pending_matches)): ?>
                        <div class="text-center py-12">
                            <i class="fas fa-check-circle text-6xl text-green-300 mb-4"></i>
                            <p class="text-gray-500 text-lg">Aucun match en attente</p>
                        </div>
                    <?php else: ?>
                        <div class="space-y-4">
                            <?php foreach ($pending_matches as $match): ?>
                                <div
                                    class="bg-gradient-to-r from-orange-50 to-yellow-50 border-2 border-orange-200 rounded-2xl p-6 hover:shadow-lg transition-all">
                                    <div class="flex items-start justify-between mb-3">
                                        <h4 class="font-black text-gray-800 text-lg">
                                            <?php echo htmlspecialchars($match->getTeam1Name()); ?>
                                            <span class="text-purple-600 mx-2">VS</span>
                                            <?php echo htmlspecialchars($match->getTeam2Name()); ?>
                                        </h4>

                                        <span
                                            class="bg-yellow-400 text-yellow-900 px-3 py-1 rounded-full text-xs font-bold whitespace-nowrap">
                                            <i class="fas fa-hourglass-half mr-1"></i>
                                            Validation
                                        </span>
                                    </div>

                                    <div class="flex items-center gap-4 text-sm text-gray-600">
                                        <span>
                                            <i class="fas fa-calendar text-orange-600 mr-2"></i>
                                            <?php echo date('d/m/Y', strtotime($match->getMatchDatetime())); ?>
                                        </span>

                                        <span>
                                            <i class="fas fa-map-marker-alt text-orange-600 mr-2"></i>
                                            <?php echo htmlspecialchars($match->getStadiumName()); ?>,
                                            <?php echo htmlspecialchars($match->getCity()); ?>
                                        </span>
                                    </div>
                                </div>

                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Published Matches -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden animate-slide-in-right"
                style="animation-delay: 0.9s">
                <div class="bg-gradient-to-r from-green-500 to-green-600 text-white px-8 py-6">
                    <h2 class="text-2xl font-black flex items-center justify-between">
                        <span>
                            <i class="fas fa-check-circle mr-3"></i>
                            Matchs Publiés
                        </span>
                        <span class="bg-white text-green-600 px-4 py-2 rounded-full font-bold text-lg">
                            <?php //echo count($published_matches); ?>
                        </span>
                    </h2>
                </div>

                <div class="p-6 max-h-96 overflow-y-auto">
                    <?php if (empty($published_matches)): ?>
                        <div class="text-center py-12">
                            <i class="fas fa-calendar-plus text-6xl text-purple-300 mb-4"></i>
                            <p class="text-gray-500 text-lg">Aucun match publié</p>
                            <a href="/sports-ticketing/organizer/create-match.php"
                                class="inline-block mt-4 bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition-all">
                                Créer un match
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="space-y-4">
                            <?php foreach ($published_matches as $match): ?>
                                <?php
                                $categories = Category::getByMatch($match -> getId());
                                $minPrice = !empty($categories) ? min(array_column($categories, 'price')) : 0;
                                ?>
                                <div
                                    class="bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200 rounded-2xl p-6 hover:shadow-lg transition-all">
                                    <div class="flex items-start justify-between mb-3">
                                        <h4 class="font-black text-gray-800 text-lg">
                                            <?php echo htmlspecialchars($match -> getTeam1Name()); ?>
                                            <span class="text-purple-600 mx-2">VS</span>
                                            <?php echo htmlspecialchars($match -> getTeam2Name()); ?>
                                        </h4>
                                        <span
                                            class="bg-green-600 text-white px-3 py-1 rounded-full text-xs font-bold whitespace-nowrap">
                                            <i class="fas fa-check mr-1"></i>
                                            Publié
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-4 text-sm text-gray-600 mb-3">
                                        <span>
                                            <i class="fas fa-calendar text-green-600 mr-2"></i>
                                            <?php echo date('d/m/Y H:i', strtotime($match -> getMatchDatetime())); ?>
                                        </span>
                                        <span>
                                            <i class="fas fa-map-marker-alt text-green-600 mr-2"></i>
                                            <?php echo htmlspecialchars($match -> getCity()); ?>
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between pt-3 border-t border-green-200">
                                        <span class="font-bold text-green-700">
                                            À partir de <?php echo number_format($minPrice, 0); ?> MAD
                                        </span>
                                        <a href="/fan-seat/src/page/match-details.php?id=<?php echo $match -> getId(); ?>"
                                            class="text-purple-600 hover:text-purple-700 font-semibold text-sm">
                                            Voir <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Rejected Matches (if any) -->
        <?php if (!empty($rejected_matches)): ?>
            <div class="mt-8 bg-white rounded-3xl shadow-2xl overflow-hidden animate-fade-in-up">
                <div class="bg-gradient-to-r from-red-500 to-red-600 text-white px-8 py-6">
                    <h2 class="text-2xl font-black flex items-center justify-between">
                        <span>
                            <i class="fas fa-times-circle mr-3"></i>
                            Matchs Refusés
                        </span>
                        <span class="bg-white text-red-600 px-4 py-2 rounded-full font-bold text-lg">
                            <?php //echo count($rejected_matches); ?>
                        </span>
                    </h2>
                </div>

                <div class="p-6">
                    <div class="space-y-4">
                        <?php foreach ($rejected_matches as $match): ?>
                            <div class="bg-gradient-to-r from-red-50 to-pink-50 border-2 border-red-200 rounded-2xl p-6">
                                <div class="flex items-start justify-between mb-3">
                                    <h4 class="font-black text-gray-800 text-lg">
                                        <?php //echo htmlspecialchars($match['team1_name']); ?>
                                        <span class="text-purple-600 mx-2">VS</span>
                                        <?php //echo htmlspecialchars($match['team2_name']); ?>
                                    </h4>
                                    <span class="bg-red-600 text-white px-3 py-1 rounded-full text-xs font-bold">
                                        <i class="fas fa-ban mr-1"></i>
                                        Refusé
                                    </span>
                                </div>
                                <div class="flex items-center gap-4 text-sm text-gray-600">
                                    <span>
                                        <i class="fas fa-calendar text-red-600 mr-2"></i>
                                        <?php //echo date('d/m/Y', strtotime($match['match_date'])); ?>
                                    </span>
                                    <span>
                                        <i class="fas fa-map-marker-alt text-red-600 mr-2"></i>
                                        <?php //echo htmlspecialchars($match['location']); ?>
                                    </span>
                                </div>
                                <div class="mt-4 pt-4 border-t border-red-200">
                                    <p class="text-sm text-gray-600">
                                        <i class="fas fa-info-circle text-red-600 mr-2"></i>
                                        Contactez l'administration pour plus d'informations
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Tips Section -->
        <div class="mt-12 bg-gradient-to-r from-purple-100 to-pink-100 rounded-3xl p-8 animate-fade-in-up">
            <div class="flex items-start gap-6">
                <div
                    class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-700 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg">
                    <i class="fas fa-lightbulb text-3xl text-white"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-black text-purple-900 mb-3">💡 Conseils pour Organisateurs</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-white rounded-xl p-4 border-2 border-purple-200">
                            <h4 class="font-bold text-purple-800 mb-2">
                                <i class="fas fa-check-circle text-green-600 mr-2"></i>
                                Informations Complètes
                            </h4>
                            <p class="text-sm text-gray-600">
                                Fournissez tous les détails du match pour une validation rapide
                            </p>
                        </div>
                        <div class="bg-white rounded-xl p-4 border-2 border-purple-200">
                            <h4 class="font-bold text-purple-800 mb-2">
                                <i class="fas fa-image text-blue-600 mr-2"></i>
                                Logos de Qualité
                            </h4>
                            <p class="text-sm text-gray-600">
                                Utilisez des images haute résolution pour les logos d'équipes
                            </p>
                        </div>
                        <div class="bg-white rounded-xl p-4 border-2 border-purple-200">
                            <h4 class="font-bold text-purple-800 mb-2">
                                <i class="fas fa-dollar-sign text-yellow-600 mr-2"></i>
                                Prix Compétitifs
                            </h4>
                            <p class="text-sm text-gray-600">
                                Définissez des tarifs attractifs pour maximiser les ventes
                            </p>
                        </div>
                        <div class="bg-white rounded-xl p-4 border-2 border-purple-200">
                            <h4 class="font-bold text-purple-800 mb-2">
                                <i class="fas fa-calendar-check text-purple-600 mr-2"></i>
                                Anticipez les Délais
                            </h4>
                            <p class="text-sm text-gray-600">
                                Créez vos matchs à l'avance pour permettre la promotion
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<?php include __DIR__ . '/../../includes/footer.php'; ?>