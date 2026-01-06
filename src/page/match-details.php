<?php
/**
 * Page de détails d'un match
 */

require_once __DIR__ . '/../config/requirefichier.php';


$user = Authentification::checkrole($_SESSION['role']);

$average_rating = null;

if (isset($_GET['id'])) {
    $match_id = $_GET['id'];
    $match = MatchGame::getMatchesById($_GET['id']);
    $match->getcategoriebyId();
}

if (isset($_GET['action'])) {
    $ticket = new Ticket($_SESSION['user_id'], $_GET['match_id'] ,$_GET['category_id'] );
    $reponse = $ticket -> save() ; 
    if ($reponse['message']) { 
        header ("Location: match-details.php?id={$_GET['match_id']}");
    }else {
        die ($reponse['message']);
    } 
}


include __DIR__ . '/../includes/header.php';
?>

<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <!-- Retour -->
        <div class="mb-6">
            <a href="/fan-seat/src/page/accueil.php" class="text-blue-600 hover:text-blue-700 transition">
                <i class="fas fa-arrow-left mr-2"></i>
                Retour aux matchs
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Colonne principale -->
            <div class="lg:col-span-2">
                <!-- Carte du match -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
                    <!-- En-tête -->
                    <div class="bg-linear-to-r from-blue-600 to-blue-800 text-white p-6">
                        <h1 class="text-3xl font-bold text-center mb-4">
                            <?= htmlspecialchars($match->getTeam1Name()) ?>
                            <span class="mx-4">VS</span>
                            <?= htmlspecialchars($match->getTeam2Name()) ?>
                        </h1>

                        <!-- Équipes avec logos -->
                        <div class="flex justify-around items-center mt-6">
                            <div class="text-center">
                                <?php if ($match->getTeam1Logo()): ?>
                                    <img src="/fan-seat/src/img/teamlogo/<?= htmlspecialchars($match->getTeam1Logo()) ?>"
                                        alt="<?= htmlspecialchars($match->getTeam1Name()) ?>"
                                        class="w-24 h-24 object-contain mx-auto mb-3 bg-white rounded-full p-2">
                                <?php else: ?>
                                    <div
                                        class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-3">
                                        <i class="fas fa-shield-alt text-4xl text-blue-600"></i>
                                    </div>
                                <?php endif; ?>
                                <h3 class="font-bold text-lg"><?= htmlspecialchars($match->getTeam1Name()) ?></h3>
                            </div>

                            <div class="text-5xl font-bold">VS</div>

                            <div class="text-center">
                                <?php if ($match->getTeam2Logo()): ?>
                                    <img src="/fan-seat/src/img/teamlogo/<?= htmlspecialchars($match->getTeam2Logo()) ?>"
                                        alt="<?= htmlspecialchars($match->getTeam2Name()) ?>"
                                        class="w-24 h-24 object-contain mx-auto mb-3 bg-white rounded-full p-2">
                                <?php else: ?>
                                    <div
                                        class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-3">
                                        <i class="fas fa-shield-alt text-4xl text-red-600"></i>
                                    </div>
                                <?php endif; ?>
                                <h3 class="font-bold text-lg"><?= htmlspecialchars($match->getTeam2Name()) ?></h3>
                            </div>
                        </div>
                    </div>

                    <!-- Informations du match -->
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                                <i class="fas fa-calendar-alt text-2xl text-blue-600 mr-4"></i>
                                <div>
                                    <p class="text-sm text-gray-600">Date</p>
                                    <p class="font-semibold"><?= date('d F Y', strtotime($match->getMatchDatetime())) ?>
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                                <i class="fas fa-clock text-2xl text-blue-600 mr-4"></i>
                                <div>
                                    <p class="text-sm text-gray-600">Heure</p>
                                    <p class="font-semibold"><?= date('H:i', strtotime($match->getMatchDatetime())) ?>
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                                <i class="fas fa-map-marker-alt text-2xl text-blue-600 mr-4"></i>
                                <div>
                                    <p class="text-sm text-gray-600">Lieu</p>
                                    <p class="font-semibold"><?= htmlspecialchars($match->getStadiumName()) ?></p>
                                </div>
                            </div>

                            <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                                <i class="fas fa-hourglass-half text-2xl text-blue-600 mr-4"></i>
                                <div>
                                    <p class="text-sm text-gray-600">Durée</p>
                                    <p class="font-semibold"><?= $match->getDuration() ?> minutes</p>
                                </div>
                            </div>
                        </div>

                        <!-- Note moyenne -->
                        <?php if ($average_rating > 0): ?>
                            <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-gray-600 mb-1">Note Moyenne</p>
                                        <div class="flex items-center">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <?php if ($i <= floor($average_rating)): ?>
                                                    <i class="fas fa-star text-yellow-500"></i>
                                                <?php elseif ($i <= ceil($average_rating)): ?>
                                                    <i class="fas fa-star-half-alt text-yellow-500"></i>
                                                <?php else: ?>
                                                    <i class="far fa-star text-yellow-500"></i>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                            <span class="ml-2 font-semibold text-gray-800">
                                                <?= number_format($average_rating, 1) ?> / 5
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-600"><?= count($comments) ?> avis</p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>


                <!-- Commentaires -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-2xl font-bold mb-6 text-gray-800">
                        <i class="fas fa-comments mr-2"></i>
                        Commentaires et Avis
                    </h2>

                    <?php if (empty($comments)): ?>
                        <p class="text-gray-600 text-center py-8">
                            <i class="fas fa-comment-slash text-4xl mb-4 block text-gray-400"></i>
                            Aucun commentaire pour le moment
                        </p>
                    <?php else: ?>
                        <div class="space-y-4">
                            <?php foreach ($comments as $comment): ?>
                                <div class="border-b border-gray-200 pb-4 last:border-0">
                                    <div class="flex items-start justify-between mb-2">
                                        <div class="flex items-center">
                                            <div
                                                class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold mr-3">
                                                <?php //echo strtoupper(substr($comment['user_name'], 0, 1)); ?>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-800">
                                                    <?php //echo htmlspecialchars($comment['user_name']); ?>
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    <?php //echo date('d/m/Y H:i', strtotime($comment['created_at'])); ?>
                                                </p>
                                            </div>
                                        </div>

                                        <?php if ($comment['rating']): ?>
                                            <div class="flex items-center">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <i
                                                        class="fas fa-star <?php //echo $i <= $comment['rating'] ? 'text-yellow-500' : 'text-gray-300'; ?>"></i>
                                                <?php endfor; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <p class="text-gray-700 ml-13"><?php //echo htmlspecialchars($comment['comment']); ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Colonne latérale - Réservation -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-lg p-6 sticky top-20">
                    <h2 class="text-2xl font-bold mb-6 text-gray-800">
                        <i class="fas fa-ticket-alt mr-2"></i>
                        Réserver des Billets
                    </h2>

                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <!-- Message pour les visiteurs non connectés -->
                        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-6">
                            <p class="text-sm text-yellow-800">
                                <i class="fas fa-info-circle mr-2"></i>
                                Vous devez être connecté pour acheter des billets
                            </p>
                        </div>
                        <a href="/sports-ticketing/public/login.php"
                            class="block w-full bg-blue-600 text-white text-center py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Se Connecter
                        </a>
                        <a href="/sports-ticketing/public/register.php"
                            class="block w-full mt-3 bg-white border-2 border-blue-600 text-blue-600 text-center py-3 rounded-lg font-semibold hover:bg-blue-50 transition">
                            <i class="fas fa-user-plus mr-2"></i>
                            Créer un Compte
                        </a>
                    <?php else: ?>
                        <!-- Formulaire de réservation pour les utilisateurs connectés -->
                        <?php if ($user->getRole() === 'user'): ?>
                            <div class="space-y-4">
                                <?php foreach ($match->getCategories() as $category): ?>
                                    <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-500 transition">
                                        <div class="flex justify-between items-center mb-2">
                                            <h3 class="font-bold text-lg text-gray-800">
                                                <?php echo htmlspecialchars($category['name']); ?>
                                            </h3>
                                            <span
                                                class="text-2xl font-bold text-blue-600"><?php echo number_format($category['price'], 2); ?>
                                                MAD</span>
                                        </div>
                                        <p class="text-sm text-gray-600 mb-3">
                                            <i class="fas fa-chair mr-2"></i>
                                            <?php echo $category['total_places']; ?> places disponibles
                                        </p>
                                        <?php if ($category['total_places'] > 0): ?>
                                            <a href="/fan-seat/src/page/match-details.php?match_id=<?php echo $match_id; ?>&category_id=<?php echo $category['id']; ?>&action=resrver"
                                                class="block w-full bg-linear-to-r from-blue-600 to-blue-700 text-white text-center py-2 rounded-lg font-semibold hover:from-blue-700 hover:to-blue-800 transition">
                                                <i class="fas fa-shopping-cart mr-2"></i>
                                                Réserver
                                            </a>
                                        <?php else: ?>
                                            <button disabled
                                                class="block w-full bg-gray-300 text-gray-600 text-center py-2 rounded-lg font-semibold cursor-not-allowed">
                                                <i class="fas fa-ban mr-2"></i>
                                                Complet
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- Informations importantes -->
                            <div class="mt-6 p-4 bg-blue-50 rounded-lg text-sm">
                                <p class="font-semibold mb-2 text-blue-900">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    Informations Importantes
                                </p>
                                <ul class="space-y-1 text-blue-800">
                                    <li><i class="fas fa-check mr-2"></i>Maximum 4 billets par match</li>
                                    <li><i class="fas fa-check mr-2"></i>Billet envoyé par email</li>
                                    <li><i class="fas fa-check mr-2"></i>Place numérotée</li>
                                </ul>
                            </div>
                        <?php else: ?>
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-center">
                                <p class="text-gray-600">
                                    Seuls les utilisateurs peuvent acheter des billets
                                </p>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>