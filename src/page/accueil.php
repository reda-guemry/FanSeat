<?php

require_once __DIR__ . '/../config/requirefichier.php';


$page_title = ' Dashboard Organisateur - Sports Ticketing';



if (isset($_SESSION['user_id'])) {
    $user = Authentification::checkuser();
}



$matches = MatchGame::getMatchesByStatus('approved');



include __DIR__ . '/../includes/header.php';
?>




<section class="bg-linear-to-r from-blue-600 to-blue-800 text-white py-20">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-5xl font-bold mb-6 animate-fade-in">
            <i class="fas fa-ticket-alt mr-3"></i>
            Bienvenue sur Sports Ticketing
        </h1>
        <p class="text-xl mb-8 max-w-2xl mx-auto">
            Réservez vos billets pour les plus grands matchs de football au Maroc.
            Simple, rapide et sécurisé.
        </p>
        <a href="#matches"
            class="bg-white text-blue-600 px-8 py-4 rounded-lg text-lg font-semibold hover:bg-blue-50 transition inline-block">
            <i class="fas fa-search mr-2"></i>
            Découvrir les Matchs
        </a>
    </div>
</section>

<!-- Statistiques -->
<section class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="text-center p-6 bg-linear-to-r from-blue-50 to-blue-100 rounded-lg">
                <i class="fas fa-futbol text-4xl text-blue-600 mb-4"></i>
                <h3 class="text-3xl font-bold text-gray-800"><?php echo count($matches); ?>+</h3>
                <p class="text-gray-600">Matchs Disponibles</p>
            </div>
            <div class="text-center p-6 bg-linear-to-r from-green-50 to-green-100 rounded-lg">
                <i class="fas fa-users text-4xl text-green-600 mb-4"></i>
                <h3 class="text-3xl font-bold text-gray-800">10K+</h3>
                <p class="text-gray-600">Utilisateurs Actifs</p>
            </div>
            <div class="text-center p-6 bg-linear-to-r from-purple-50 to-purple-100 rounded-lg">
                <i class="fas fa-ticket-alt text-4xl text-purple-600 mb-4"></i>
                <h3 class="text-3xl font-bold text-gray-800">50K+</h3>
                <p class="text-gray-600">Billets Vendus</p>
            </div>
            <div class="text-center p-6 bg-linear-to-r from-orange-50 to-orange-100 rounded-lg">
                <i class="fas fa-star text-4xl text-orange-600 mb-4"></i>
                <h3 class="text-3xl font-bold text-gray-800">4.8/5</h3>
                <p class="text-gray-600">Note Moyenne</p>
            </div>
        </div>
    </div>
</section>

<!-- Barre de recherche et filtres -->
<section id="matches" class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl font-bold text-center mb-8 text-gray-800">
            <i class="fas fa-calendar-alt mr-3"></i>
            Matchs à Venir
        </h2>

        <!-- Recherche et filtres -->
        <div class="max-w-4xl mx-auto mb-8">
            <form method="GET" action="" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" name="search" placeholder="Rechercher un match, équipe ou lieu..."
                        value="<?php //echo htmlspecialchars($search_query); ?>"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-search mr-2"></i>
                    Rechercher
                </button>
            </form>
        </div>

        <!-- Liste des matchs -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if (empty($matches)): ?>
                <div class="col-span-full text-center py-12">
                    <i class="fas fa-calendar-times text-6xl text-gray-400 mb-4"></i>
                    <p class="text-xl text-gray-600">Aucun match disponible pour le moment</p>
                </div>
            <?php else: ?>
                <?php foreach ($matches as $match): ?>
                    <div class="card-hover bg-white rounded-lg shadow-md overflow-hidden">
                        <!-- Badge de statut -->
                        <div class="bg-linear-to-r from-green-500 to-green-600 text-white px-4 py-2 text-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            Places Disponibles
                        </div>

                        <!-- Contenu de la carte -->
                        <div class="p-6">
                            <!-- Équipes -->
                            <div class="flex justify-between items-center mb-4">
                                <div class="text-center flex-1">
                                    <?php if ($match->getTeam1Logo()): ?>
                                        <img src="/fan-seat/src/img/teamlogo/<?php echo htmlspecialchars($match->getTeam1Logo()); ?>"
                                            alt="<?php echo htmlspecialchars($match->getTeam1Name()); ?>"
                                            class="w-16 h-16 object-contain mx-auto mb-2">
                                    <?php else: ?>
                                        <i class="fas fa-shield-alt text-4xl text-blue-600 mb-2"></i>
                                    <?php endif; ?>
                                    <h4 class="font-bold text-sm">
                                        <?php echo htmlspecialchars($match->getTeam1Name()); ?>
                                    </h4>
                                </div>

                                <div class="text-2xl font-bold text-gray-400 mx-4">VS</div>

                                <div class="text-center flex-1">
                                    <?php if ($match->getTeam2Logo()): ?>
                                        <img src="/fan-seat/src/img/teamlogo/<?php echo htmlspecialchars($match->getTeam2Logo()); ?>"
                                            alt="<?php echo htmlspecialchars($match->getTeam2Name()); ?>"
                                            class="w-16 h-16 object-contain mx-auto mb-2">
                                    <?php else: ?>
                                        <i class="fas fa-shield-alt text-4xl text-red-600 mb-2"></i>
                                    <?php endif; ?>
                                    <h4 class="font-bold text-sm">
                                        <?php echo htmlspecialchars($match->getTeam2Name()); ?>
                                    </h4>
                                </div>
                            </div>

                            <!-- Détails du match -->
                            <div class="border-t border-gray-200 pt-4 space-y-2">
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-calendar mr-3 text-blue-600"></i>
                                    <span><?php echo date('d/m/Y', strtotime($match->getMatchDatetime())); ?></span>
                                </div>

                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-clock mr-3 text-blue-600"></i>
                                    <span><?php echo date('H:i', strtotime($match->getMatchDatetime())); ?></span>
                                </div>

                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-map-marker-alt mr-3 text-blue-600"></i>
                                    <span>
                                        <?php echo htmlspecialchars($match->getStadiumName()); ?>,
                                        <?php echo htmlspecialchars($match->getCity()); ?>
                                    </span>
                                </div>
                            </div>

                            <!-- Bouton d'action -->
                            <div class="mt-6">
                                <a href="/fan-seat/src/page/match-details.php?id=<?php echo $match->getId(); ?>"
                                    class="block w-full bg-linear-to-r from-blue-600 to-blue-700 text-white text-center py-3 rounded-lg font-semibold hover:from-blue-700 hover:to-blue-800 transition">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    Voir les Détails
                                </a>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-16 bg-linear-to-r from-blue-600 to-blue-800 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-4xl font-bold mb-6">Prêt à Réserver Vos Billets?</h2>
        <p class="text-xl mb-8 max-w-2xl mx-auto">
            Inscrivez-vous maintenant et profitez d'une expérience de billetterie simple et sécurisée.
        </p>
        <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="/sports-ticketing/public/register.php"
                class="bg-white text-blue-600 px-8 py-4 rounded-lg text-lg font-semibold hover:bg-blue-50 transition inline-block">
                <i class="fas fa-user-plus mr-2"></i>
                Créer un Compte
            </a>
        <?php endif; ?>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>