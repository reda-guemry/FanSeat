<?php
/**
 * Dashboard Utilisateur/Acheteur
 */

require_once __DIR__ . '/../../config/requirefichier.php';


$user = Authentification::checkuser();

$upcoming_tickets = Ticket::getTicketsByUserId($user->getUserId());

$available_matches = MatchGame::getMatchesByStatus('approved');

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'gettickete') {
        Ticket::showTicketInBrowser($_GET['id']);
    } else if ($_GET['action'] == 'ticketparmail') {
        Ticket::sendTicketByMail($_GET['id'] , $user -> getEmail());   
    }
}

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

    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out;
    }

    .animate-slide-in-right {
        animation: slideInRight 0.6s ease-out;
    }

    .ticket-card-hover {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .ticket-card-hover:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 40px rgba(147, 51, 234, 0.3);
    }

    .gradient-shine {
        background: linear-gradient(135deg, #7c3aed 0%, #a855f7 50%, #c084fc 100%);
        background-size: 200% 200%;
        animation: shine 3s ease infinite;
    }

    @keyframes shine {

        0%,
        100% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }
    }
</style>

<!-- Hero Section -->
<section class="bg-gradient-to-r from-purple-700 via-purple-800 to-indigo-900 text-white py-16 animate-fade-in-up">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row items-center justify-between">
            <div class="mb-6 lg:mb-0">
                <h1 class="text-5xl font-black mb-3 flex items-center">
                    <i class="fas fa-user-circle mr-4 text-yellow-300"></i>
                    Mon Dashboard
                </h1>
                <p class="text-purple-200 text-xl">
                    Bienvenue, <span class="font-bold text-white"><?php echo htmlspecialchars($user); ?></span>
                </p>
                <p class="text-purple-300 mt-2">
                    <i class="fas fa-calendar mr-2"></i>
                    <?php echo date('l d F Y'); ?>
                </p>
            </div>

            <div class="flex gap-4">
                <a href="/sports-ticketing/public/index.php#matches"
                    class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-8 py-4 rounded-2xl font-bold transition-all shadow-2xl hover:shadow-green-500/50 transform hover:scale-105">
                    <i class="fas fa-ticket-alt mr-2"></i>
                    Acheter des Billets
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Cards -->
<section class="py-12 bg-gradient-to-br from-purple-50 via-white to-pink-50">
    <div class="container mx-auto px-4">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">

            <!-- Total Billets -->
            <div class="ticket-card-hover bg-white rounded-3xl shadow-xl p-8 border-t-4 border-purple-600 animate-fade-in-up"
                style="animation-delay: 0.1s">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-700 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-ticket-alt text-3xl text-white"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-500 text-sm font-semibold">MES BILLETS</p>
                        <p class="text-4xl font-black text-gray-800"><?php //echo $total_tickets; ?></p>
                    </div>
                </div>
                <p class="text-purple-700 font-bold flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    Billets achetés
                </p>
            </div>

            <!-- À Venir -->
            <div class="ticket-card-hover bg-white rounded-3xl shadow-xl p-8 border-t-4 border-green-600 animate-fade-in-up"
                style="animation-delay: 0.2s">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-700 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-calendar-check text-3xl text-white"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-500 text-sm font-semibold">À VENIR</p>
                        <p class="text-4xl font-black text-gray-800"><?php //echo count($upcoming_tickets); ?></p>
                    </div>
                </div>
                <p class="text-green-700 font-bold flex items-center">
                    <i class="fas fa-clock mr-2"></i>
                    Matchs prochains
                </p>
            </div>

            <!-- Montant Dépensé -->
            <div class="ticket-card-hover bg-white rounded-3xl shadow-xl p-8 border-t-4 border-yellow-600 animate-fade-in-up"
                style="animation-delay: 0.3s">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-yellow-700 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-coins text-3xl text-white"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-500 text-sm font-semibold">DÉPENSÉ</p>
                        <p class="text-4xl font-black text-gray-800"><?php //echo number_format($total_spent, 0); ?></p>
                    </div>
                </div>
                <p class="text-yellow-700 font-bold flex items-center">
                    <i class="fas fa-money-bill-wave mr-2"></i>
                    MAD
                </p>
            </div>

            <!-- Historique -->
            <div class="ticket-card-hover bg-white rounded-3xl shadow-xl p-8 border-t-4 border-blue-600 animate-fade-in-up"
                style="animation-delay: 0.4s">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-history text-3xl text-white"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-500 text-sm font-semibold">PASSÉS</p>
                        <p class="text-4xl font-black text-gray-800"><?php //echo count($past_tickets); ?></p>
                    </div>
                </div>
                <p class="text-blue-700 font-bold flex items-center">
                    <i class="fas fa-calendar-times mr-2"></i>
                    Matchs terminés
                </p>
            </div>
        </div>

        <!-- Upcoming Tickets -->
        <div class="mb-12">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-black text-gray-800 flex items-center">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-700 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-ticket-alt text-white text-xl"></i>
                    </div>
                    Mes Billets à Venir
                </h2>
                <span class="bg-purple-100 text-purple-700 px-6 py-3 rounded-full font-bold text-lg">
                    <?php //echo count($upcoming_tickets); ?> billet(s)
                </span>
            </div>

            <?php if (empty($upcoming_tickets)): ?>
                <div class="bg-white rounded-3xl shadow-xl p-16 text-center">
                    <i class="fas fa-ticket-alt text-8xl text-purple-300 mb-6"></i>
                    <h3 class="text-3xl font-bold text-gray-800 mb-4">Aucun billet à venir</h3>
                    <p class="text-gray-600 text-lg mb-8">
                        Explorez nos matchs disponibles et réservez vos places!
                    </p>
                    <a href="/sports-ticketing/public/index.php#matches"
                        class="inline-block bg-gradient-to-r from-purple-600 to-purple-700 text-white px-8 py-4 rounded-xl font-bold hover:from-purple-700 hover:to-purple-800 transition-all shadow-lg">
                        <i class="fas fa-search mr-2"></i>
                        Explorer les Matchs
                    </a>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <?php foreach ($upcoming_tickets as $index => $ticket): ?>
                        <div class="ticket-card-hover bg-white rounded-3xl shadow-2xl overflow-hidden animate-slide-in-right"
                            style="animation-delay: <?php echo $index * 0.1; ?>s">

                            <!-- Header -->
                            <div class="bg-gradient-to-r from-purple-600 to-indigo-700 p-6 text-white relative overflow-hidden">
                                <div class="relative z-10 flex items-start justify-between">
                                    <div class="flex-1">
                                        <p class="text-purple-200 text-sm font-semibold mb-2">
                                            BILLET #<?php echo $ticket['id']; ?>
                                        </p>

                                        <h3 class="text-2xl font-black mb-1">
                                            <?php echo htmlspecialchars($ticket['team1_name']); ?>
                                            <span class="mx-2">VS</span>
                                            <?php echo htmlspecialchars($ticket['team2_name']); ?>
                                        </h3>

                                        <p class="text-purple-200">
                                            <i class="fas fa-tag mr-2"></i>
                                            <?php echo htmlspecialchars($ticket['name']); ?>
                                        </p>
                                    </div>

                                    <div class="w-24 h-24 bg-white rounded-xl flex items-center justify-center ml-4">
                                        <i class="fas fa-qrcode text-5xl text-purple-700"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Body -->
                            <div class="p-6">
                                <!-- Match info -->
                                <div class="space-y-3 mb-6">
                                    <div class="flex items-center text-gray-700 bg-purple-50 p-3 rounded-xl">
                                        <i class="fas fa-calendar text-purple-600 mr-3 w-5 text-center"></i>
                                        <span class="font-semibold">
                                            <?php echo date('d F Y à H:i', strtotime($ticket['match_datetime'])); ?>
                                        </span>
                                    </div>

                                    <div class="flex items-center text-gray-700 bg-purple-50 p-3 rounded-xl">
                                        <i class="fas fa-map-marker-alt text-purple-600 mr-3 w-5 text-center"></i>
                                        <span>
                                            <?php echo htmlspecialchars($ticket['stadium_name']); ?>
                                            -
                                            <?php echo htmlspecialchars($ticket['city']); ?>
                                        </span>
                                    </div>
                                </div>

                                <!-- Price & Code -->
                                <div
                                    class="flex items-center justify-between bg-gradient-to-r from-purple-100 to-pink-100 rounded-2xl p-4 mb-6">
                                    <div>
                                        <p class="text-sm text-gray-600 mb-1">Prix payé</p>
                                        <p class="text-3xl font-black text-purple-700">
                                            <?php echo number_format($ticket['price'], 2); ?> MAD
                                        </p>
                                    </div>

                                    <div class="text-right">
                                        <p class="text-sm text-gray-600 mb-1">Code billet</p>
                                        <p
                                            class="text-xs font-mono bg-white px-3 py-2 rounded-lg border-2 border-purple-300 font-bold">
                                            <?php echo htmlspecialchars($ticket['ticket_code']); ?>
                                        </p>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex gap-3">
                                    <a href="/fan-seat/src/page/user/dhashborduser.php?id=<?php echo $ticket['tickets_id']; ?>&action=ticketparmail"
                                        class="flex-1 bg-gradient-to-r from-purple-600 to-purple-700 text-white py-3 px-4 rounded-xl font-bold text-center transition-all">
                                        <i class="fas fa-eye mr-2"></i>
                                        Envoyer le ticket par email
                                    </a>

                                    <a href="/fan-seat/src/page/user/dhashborduser.php?id=<?php echo $ticket['tickets_id']; ?>&action=gettickete"
                                        class="flex-1 bg-white border-2 border-purple-600 text-purple-600 py-3 px-4 rounded-xl font-bold text-center transition-all">
                                        <i class="fas fa-download mr-2"></i>
                                        Télécharger PDF
                                    </a>
                                </div>

                                <!-- Purchase date -->
                                <p class="text-center text-xs text-gray-500 mt-4">
                                    <i class="fas fa-clock mr-1"></i>
                                    Acheté le
                                    <?php echo date('d/m/Y à H:i', strtotime($ticket['tickets_creat_at'])); ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>


                </div>
            <?php endif; ?>
        </div>

        <!-- Matchs Recommandés -->
        <div class="mb-12">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-black text-gray-800 flex items-center">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-700 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-star text-white text-xl"></i>
                    </div>
                    Matchs Disponibles
                </h2>
                <a href="/fan-seat/src/page/accueil.php" class="text-purple-600 hover:text-purple-700 font-semibold">
                    Voir tout <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($available_matches as $index => $matchObj): ?>
                    <?php
                    $categories = Category::getByMatch($matchObj->getId());
                    $minPrice = !empty($categories) ? min(array_column($categories, 'price')) : 0;
                    ?>
                    <div class="ticket-card-hover bg-white rounded-2xl shadow-xl overflow-hidden animate-fade-in-up"
                        style="animation-delay: <?php echo $index * 0.1; ?>s">
                        <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-4 text-white">
                            <p class="text-sm font-semibold text-green-100">
                                <i class="fas fa-calendar mr-2"></i>
                                <?php echo date('d M Y', strtotime($matchObj->getMatchDatetime())); ?>
                            </p>
                        </div>

                        <div class="p-6">
                            <h4 class="text-xl font-bold text-gray-800 mb-4 text-center">
                                <?php echo htmlspecialchars($matchObj->getTeam1Name()); ?>
                                <span class="text-purple-600 mx-2">VS</span>
                                <?php echo htmlspecialchars($matchObj->getTeam2Name()); ?>
                            </h4>

                            <div class="space-y-2 mb-4">
                                <p class="text-sm text-gray-600 flex items-center">
                                    <i class="fas fa-clock text-purple-600 mr-2 w-4"></i>
                                    <?php echo date('H:i', strtotime($matchObj->getMatchDatetime())); ?>
                                </p>
                                <p class="text-sm text-gray-600 flex items-center">
                                    <i class="fas fa-map-marker-alt text-purple-600 mr-2 w-4"></i>
                                    <?php echo htmlspecialchars($matchObj->getStadiumName()); ?>
                                </p>
                            </div>

                            <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                                <div>
                                    <p class="text-xs text-gray-500">À partir de</p>
                                    <p class="text-2xl font-black text-green-600">
                                        <?php echo number_format($minPrice, 0); ?> MAD
                                    </p>
                                </div>
                                <a href="/fan-seat/src/page/match-details.php?id=<?php echo $matchObj->getId(); ?>"
                                    class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-bold transition-all">
                                    Réserver
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>

        <!-- Historique -->
        <?php if (!empty($past_tickets)): ?>
            <div class="bg-white rounded-3xl shadow-2xl p-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-history text-white"></i>
                        </div>
                        Historique des Matchs
                    </h2>
                    <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full font-bold">
                        <?php echo count($past_tickets); ?> match(s)
                    </span>
                </div>

                <div class="space-y-4">
                    <?php foreach (array_slice($past_tickets, 0, 5) as $ticket): ?>
                        <?php
                        $match = $ticket['match_data'];
                        $category = $categoryModel->getById($ticket['category_id']);
                        ?>
                        <div
                            class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl hover:shadow-md transition-all">
                            <div class="flex items-center flex-1">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center text-white font-bold mr-4">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-800">
                                        <?php echo htmlspecialchars($match['team1_name']); ?>
                                        <span class="text-purple-600 mx-2">vs</span>
                                        <?php echo htmlspecialchars($match['team2_name']); ?>
                                    </h4>
                                    <p class="text-sm text-gray-600">
                                        <i class="fas fa-calendar mr-2"></i>
                                        <?php echo date('d/m/Y', strtotime($match['match_date'])); ?>
                                        <span class="mx-2">•</span>
                                        <?php echo htmlspecialchars($category['name']); ?>
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-gray-800"><?php echo number_format($ticket['price'], 2); ?> MAD</p>
                                <a href="/sports-ticketing/user/ticket-details.php?id=<?php echo $ticket['id']; ?>"
                                    class="text-purple-600 hover:text-purple-700 text-sm font-semibold">
                                    Voir <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
</section>

<?php include __DIR__ . '/../../includes/footer.php'; ?>