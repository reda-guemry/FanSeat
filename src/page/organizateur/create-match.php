<?php
/**
 * Créer un Match - Organisateur
 */


require_once __DIR__ . '/../../config/requirefichier.php';

$resule = null ;

$page_title = 'Créer un Match - Sports Ticketing';

$organizateur = new Organizer($_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'team1_name' => $_POST['team1_name'],
        'team1_short' => $_POST['team1_short'],
        'team1_logo' => $_FILES['team1_logo'],
        'team2_name' => $_POST['team2_name'],
        'team2_short' => $_POST['team2_short'],
        'team2_logo' => $_FILES['team2_logo'],
        'match_datetime' => $_POST['match_datetime'],
        'duration' => $_POST['duration'],
        'stadium_name' => $_POST['stadium_name'],
        'city' => $_POST['city'],
        'address' => $_POST['address'],
        'total_places' => $_POST['total_places'],
        'categories' => []
    ];
    $data['categories'] = [];

    for ($i = 1; $i <= 3; $i++) {
        if (!empty($_POST["category{$i}_name"]) && !empty($_POST["category{$i}_price"]) && !empty($_POST["category{$i}_places"])) {
            $data['categories'][] = [
                'name' => $_POST["category{$i}_name"],
                'price' => $_POST["category{$i}_price"],
                'total_places' => $_POST["category{$i}_places"],
                'description' => $_POST["category{$i}_desc"] ?? null
            ];
        }
    }

    $match = $organizateur->createMatch($data);
    $result = $match->insertmatch();
}



include __DIR__ . '/../../includes/header.php';
?>

<style>
    .animate-fade-in {
        animation: fadeIn 0.6s ease-out;
    }

    .animate-slide-in {
        animation: slideIn 0.6s ease-out;
    }

    .animate-scale-in {
        animation: scaleIn 0.5s ease-out;
    }

    .step-line {
        position: absolute;
        top: 20px;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(to right, #7c3aed 0%, #7c3aed var(--progress), #e5e7eb var(--progress), #e5e7eb 100%);
        transition: all 0.5s ease;
    }

    .logo-preview-hover {
        transition: all 0.3s ease;
    }
</style>

<!-- Hero Section -->
<section class="bg-gradient-to-r from-purple-700 via-purple-800 to-indigo-900 text-white py-12 animate-fade-in">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between">
            <div>
                <nav class="text-sm mb-4">
                    <a href="/sports-ticketing/organizer/dashboard.php"
                        class="text-purple-200 hover:text-white transition">
                        <i class="fas fa-home mr-2"></i>Dashboard
                    </a>
                    <span class="mx-2 text-purple-300">/</span>
                    <span class="text-white">Créer un Match</span>
                </nav>
                <h1 class="text-4xl font-bold mb-2">
                    <i class="fas fa-calendar-plus mr-3"></i>
                    Créer un Nouveau Match
                </h1>
                <p class="text-purple-200 text-lg">
                    Créez votre événement sportif en quelques étapes
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="py-12 bg-gradient-to-br from-purple-50 to-white min-h-screen">
    <div class="container mx-auto px-4 max-w-6xl">

        <!-- Alert Info -->
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg mb-8 animate-slide-in">
            <div class="flex items-center">
                <i class="fas fa-info-circle text-blue-500 text-2xl mr-4"></i>
                <p class="text-blue-800">
                    Votre demande de match sera soumise à validation par l'administrateur avant publication.
                </p>
            </div>
        </div>

        <?php if (!empty($result) && $result['status'] === false ): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <?= $result['message'] ?>
            </div>
        <?php elseif(!empty($result) && $result['status'] === true): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded my-2">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <?= $result['message'] ?>
            </div>
        <?php endif; ?>


        <!-- Form Container -->
        <div class="bg-white rounded-3xl shadow-2xl p-8 animate-scale-in">
            <form id="createMatchForm" method="POST" enctype="multipart/form-data">
                <!-- Step Indicator -->
                <div class="relative mb-12">
                    <div class="step-line" id="stepLine"></div>
                    <div class="grid grid-cols-4 gap-4 relative z-10">
                        <!-- Step 1 -->
                        <div class="flex flex-col items-center step-item" data-step="1">
                            <div
                                class="w-12 h-12 rounded-full bg-purple-600 text-white flex items-center justify-center font-bold mb-2 shadow-lg transition-all duration-300 step-circle">
                                1
                            </div>
                            <span class="text-sm font-semibold text-purple-600 step-label">Équipes</span>
                        </div>
                        <!-- Step 2 -->
                        <div class="flex flex-col items-center step-item" data-step="2">
                            <div
                                class="w-12 h-12 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-bold mb-2 shadow-lg transition-all duration-300 step-circle">
                                2
                            </div>
                            <span class="text-sm font-semibold text-gray-500 step-label">Date & Lieu</span>
                        </div>
                        <!-- Step 3 -->
                        <div class="flex flex-col items-center step-item" data-step="3">
                            <div
                                class="w-12 h-12 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-bold mb-2 shadow-lg transition-all duration-300 step-circle">
                                3
                            </div>
                            <span class="text-sm font-semibold text-gray-500 step-label">Catégories</span>
                        </div>
                        <!-- Step 4 -->
                        <div class="flex flex-col items-center step-item" data-step="4">
                            <div
                                class="w-12 h-12 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-bold mb-2 shadow-lg transition-all duration-300 step-circle">
                                4
                            </div>
                            <span class="text-sm font-semibold text-gray-500 step-label">Confirmation</span>
                        </div>
                    </div>
                </div>

                <!-- Step 1: Teams -->
                <div class="form-step" id="step1">
                    <h2 class="text-3xl font-bold text-purple-800 mb-6 flex items-center">
                        <i class="fas fa-trophy text-yellow-500 mr-3"></i>
                        Informations des Équipes
                    </h2>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Team 1 -->
                        <div
                            class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl p-6 border-2 border-purple-200">
                            <h3 class="text-xl font-bold text-purple-800 mb-6 flex items-center">
                                <i class="fas fa-home text-purple-600 mr-2"></i>
                                Équipe Domicile
                            </h3>

                            <div class="flex flex-col items-center mb-6">
                                <div class="w-32 h-32 rounded-full bg-white border-4 border-purple-300 flex items-center justify-center mb-4 transition overflow-hidden"
                                    id="logo1Preview">
                                    <i class="fas fa-shield-alt text-6xl text-purple-400"></i>
                                </div>
                                <input type="file" id="team1Logo" name="team1_logo" accept="image/*" class="hidden">
                                <button type="button" onclick="document.getElementById('team1Logo').click()"
                                    class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-semibold transition-all shadow-md hover:shadow-lg transform hover:scale-105">
                                    <i class="fas fa-upload mr-2"></i>
                                    Télécharger Logo
                                </button>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">
                                        Nom de l'équipe <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="team1_name" id="team1Name" required
                                        class="w-full px-4 py-3 border-2 border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition-all"
                                        placeholder="Ex: Paris Saint-Germain">
                                </div>

                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">
                                        Abréviation
                                    </label>
                                    <input type="text" name="team1_short" id="team1Short" maxlength="5"
                                        class="w-full px-4 py-3 border-2 border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition-all"
                                        placeholder="Ex: PSG">
                                </div>
                            </div>
                        </div>

                        <!-- VS Separator -->
                        <div
                            class="hidden lg:flex absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10">
                            <div
                                class="bg-gradient-to-r from-purple-600 to-pink-600 text-white font-black text-4xl px-8 py-4 rounded-2xl shadow-2xl">
                                VS
                            </div>
                        </div>

                        <!-- Team 2 -->
                        <div
                            class="bg-gradient-to-br from-pink-50 to-pink-100 rounded-2xl p-6 border-2 border-pink-200">
                            <h3 class="text-xl font-bold text-pink-800 mb-6 flex items-center">
                                <i class="fas fa-plane text-pink-600 mr-2"></i>
                                Équipe Visiteur
                            </h3>

                            <div class="flex flex-col items-center mb-6">
                                <div class="w-32 h-32 rounded-full bg-white border-4 border-pink-300 flex items-center justify-center mb-4 transition overflow-hidden"
                                    id="logo2Preview">
                                    <i class="fas fa-shield-alt text-6xl text-pink-400"></i>
                                </div>
                                <input type="file" id="team2Logo" name="team2_logo" accept="image/*" class="hidden">
                                <button type="button" onclick="document.getElementById('team2Logo').click()"
                                    class="bg-pink-600 hover:bg-pink-700 text-white px-6 py-2 rounded-lg font-semibold transition-all shadow-md hover:shadow-lg transform hover:scale-105">
                                    <i class="fas fa-upload mr-2"></i>
                                    Télécharger Logo
                                </button>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">
                                        Nom de l'équipe <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="team2_name" id="team2Name" required
                                        class="w-full px-4 py-3 border-2 border-pink-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 transition-all"
                                        placeholder="Ex: Olympique de Marseille">
                                </div>

                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">
                                        Abréviation
                                    </label>
                                    <input type="text" name="team2_short" id="team2Short" maxlength="5"
                                        class="w-full px-4 py-3 border-2 border-pink-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 transition-all"
                                        placeholder="Ex: OM">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Date & Location -->
                <div class="form-step hidden" id="step2">
                    <h2 class="text-3xl font-bold text-purple-800 mb-6 flex items-center">
                        <i class="fas fa-calendar-alt text-purple-600 mr-3"></i>
                        Date, Heure & Lieu
                    </h2>

                    <div class="bg-gradient-to-br from-purple-50 to-white rounded-2xl p-8 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">
                                    <i class="fas fa-calendar text-purple-600 mr-2"></i>
                                    Date du match <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="match_datetime" id="matchDate" required
                                    class="w-full px-4 py-3 border-2 border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition-all">
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">
                                    <i class="fas fa-clock text-purple-600 mr-2"></i>
                                    Heure de coup d'envoi <span class="text-red-500">*</span>
                                </label>
                                <input type="time" name="match_time" id="matchTime" required
                                    class="w-full px-4 py-3 border-2 border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition-all">
                            </div>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-stadium text-purple-600 mr-2"></i>
                                Nom du stade <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="stadium_name" id="stadiumName" required
                                class="w-full px-4 py-3 border-2 border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition-all"
                                placeholder="Ex: Stade Mohammed V">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">
                                    <i class="fas fa-map-marker-alt text-purple-600 mr-2"></i>
                                    Ville <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="city" id="city" required
                                    class="w-full px-4 py-3 border-2 border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition-all"
                                    placeholder="Ex: Casablanca">
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">
                                    <i class="fas fa-location-arrow text-purple-600 mr-2"></i>
                                    Adresse
                                </label>
                                <input type="text" name="address" id="address"
                                    class="w-full px-4 py-3 border-2 border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition-all"
                                    placeholder="Ex: Avenue Mohammed V">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">
                                    <i class="fas fa-users text-purple-600 mr-2"></i>
                                    Nombre total de places <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="total_places" id="totalPlaces" min="100" max="2000"
                                    value="2000" required
                                    class="w-full px-4 py-3 border-2 border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition-all">
                                <p class="text-sm text-gray-500 mt-1">Maximum: 2000 places</p>
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">
                                    <i class="fas fa-hourglass-half text-purple-600 mr-2"></i>
                                    Durée du match (minutes)
                                </label>
                                <input type="number" name="duration" id="duration" value="90" readonly
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg bg-gray-100 cursor-not-allowed">
                                <p class="text-sm text-gray-500 mt-1">Durée standard de 90 minutes</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Categories & Prices -->
                <div class="form-step hidden" id="step3">
                    <h2 class="text-3xl font-bold text-purple-800 mb-6 flex items-center">
                        <i class="fas fa-tags text-purple-600 mr-3"></i>
                        Catégories & Tarification
                    </h2>
                    <p class="text-gray-600 mb-8">Définissez jusqu'à 3 catégories de places avec leurs prix respectifs.
                    </p>

                    <div class="space-y-6" id="categoriesContainer">
                        <!-- Category 1: VIP -->
                        <div class="bg-gradient-to-r from-red-50 to-pink-50 rounded-2xl p-6 border-2 border-red-200"
                            data-category="1">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center">
                                    <div
                                        class="w-10 h-10 bg-red-600 text-white rounded-lg flex items-center justify-center font-bold mr-3">
                                        1
                                    </div>
                                    <span class="bg-red-100 text-red-700 px-4 py-2 rounded-full font-bold">
                                        Catégorie VIP
                                    </span>
                                </div>
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" name="category1_enabled" value="1" checked disabled
                                        class="sr-only">
                                    <div class="w-14 h-8 bg-red-600 rounded-full relative">
                                        <div
                                            class="w-6 h-6 bg-white rounded-full absolute top-1 right-1 transition-all">
                                        </div>
                                    </div>
                                    <span class="ml-3 font-semibold text-gray-700">Obligatoire</span>
                                </label>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Nom <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="category1_name"
                                        class="category-name w-full px-4 py-3 border-2 border-red-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
                                        value="VIP" required>
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Prix (MAD) <span
                                            class="text-red-500">*</span></label>
                                    <input type="number" name="category1_price"
                                        class="category-price w-full px-4 py-3 border-2 border-red-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
                                        min="1" placeholder="500" required>
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Places <span
                                            class="text-red-500">*</span></label>
                                    <input type="number" name="category1_places"
                                        class="category-places w-full px-4 py-3 border-2 border-red-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
                                        min="1" placeholder="200" required>
                                </div>
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Description</label>
                                <input type="text" name="category1_desc"
                                    class="w-full px-4 py-3 border-2 border-red-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
                                    placeholder="Ex: Accès lounge, sièges premium, restauration incluse">
                            </div>
                        </div>

                        <!-- Category 2: Tribune -->
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl p-6 border-2 border-green-200 category-card"
                            data-category="2">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center">
                                    <div
                                        class="w-10 h-10 bg-green-600 text-white rounded-lg flex items-center justify-center font-bold mr-3">
                                        2
                                    </div>
                                    <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full font-bold">
                                        Catégorie Tribune
                                    </span>
                                </div>
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" name="category2_enabled" value="1" checked
                                        class="category-toggle sr-only">
                                    <div class="toggle-bg w-14 h-8 bg-green-600 rounded-full relative">
                                        <div
                                            class="toggle-dot w-6 h-6 bg-white rounded-full absolute top-1 right-1 transition-all">
                                        </div>
                                    </div>
                                    <span class="ml-3 font-semibold text-gray-700">Active</span>
                                </label>
                            </div>

                            <div class="category-content">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <div>
                                        <label class="block text-gray-700 font-semibold mb-2">Nom</label>
                                        <input type="text" name="category2_name"
                                            class="category-name w-full px-4 py-3 border-2 border-green-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                                            value="Tribune">
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 font-semibold mb-2">Prix (MAD)</label>
                                        <input type="number" name="category2_price"
                                            class="category-price w-full px-4 py-3 border-2 border-green-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                                            min="1" placeholder="200">
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 font-semibold mb-2">Places</label>
                                        <input type="number" name="category2_places"
                                            class="category-places w-full px-4 py-3 border-2 border-green-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                                            min="1" placeholder="800">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Description</label>
                                    <input type="text" name="category2_desc"
                                        class="w-full px-4 py-3 border-2 border-green-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                                        placeholder="Ex: Vue dégagée sur le terrain">
                                </div>
                            </div>
                        </div>

                        <!-- Category 3: Pelouse -->
                        <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-2xl p-6 border-2 border-yellow-200 category-card"
                            data-category="3">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center">
                                    <div
                                        class="w-10 h-10 bg-yellow-600 text-white rounded-lg flex items-center justify-center font-bold mr-3">
                                        3
                                    </div>
                                    <span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full font-bold">
                                        Catégorie Pelouse
                                    </span>
                                </div>
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" name="category3_enabled" value="1" checked
                                        class="category-toggle sr-only">
                                    <div class="toggle-bg w-14 h-8 bg-yellow-600 rounded-full relative">
                                        <div
                                            class="toggle-dot w-6 h-6 bg-white rounded-full absolute top-1 right-1 transition-all">
                                        </div>
                                    </div>
                                    <span class="ml-3 font-semibold text-gray-700">Active</span>
                                </label>
                            </div>

                            <div class="category-content">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <div>
                                        <label class="block text-gray-700 font-semibold mb-2">Nom</label>
                                        <input type="text" name="category3_name"
                                            class="category-name w-full px-4 py-3 border-2 border-yellow-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"
                                            value="Pelouse">
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 font-semibold mb-2">Prix (MAD)</label>
                                        <input type="number" name="category3_price"
                                            class="category-price w-full px-4 py-3 border-2 border-yellow-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"
                                            min="1" placeholder="100">
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 font-semibold mb-2">Places</label>
                                        <input type="number" name="category3_places"
                                            class="category-places w-full px-4 py-3 border-2 border-yellow-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"
                                            min="1" placeholder="1000">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Description</label>
                                    <input type="text" name="category3_desc"
                                        class="w-full px-4 py-3 border-2 border-yellow-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"
                                        placeholder="Ex: Places économiques">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Places Summary -->
                    <div class="bg-gradient-to-r from-purple-100 to-pink-100 rounded-2xl p-6 mt-8">
                        <div class="flex items-center justify-between mb-4">
                            <span class="font-semibold text-gray-700">Total des places configurées:</span>
                            <span class="text-2xl font-bold text-purple-700" id="configuredPlaces">0</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="font-semibold text-gray-700">Places restantes à attribuer:</span>
                            <span class="text-2xl font-bold text-pink-700" id="remainingPlaces">2000</span>
                        </div>
                    </div>
                </div>

                <!-- Step 4: Confirmation -->
                <div class="form-step hidden" id="step4">
                    <h2 class="text-3xl font-bold text-purple-800 mb-6 flex items-center">
                        <i class="fas fa-check-circle text-green-600 mr-3"></i>
                        Confirmation
                    </h2>
                    <p class="text-gray-600 mb-8">Vérifiez les informations avant de soumettre votre demande.</p>

                    <!-- Match Preview -->
                    <div
                        class="bg-gradient-to-br from-purple-600 to-indigo-700 rounded-3xl p-8 text-white mb-8 shadow-2xl">
                        <div class="flex items-center justify-between mb-6">
                            <span class="text-purple-200" id="previewDate">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                -- --- ---- - --:--
                            </span>
                            <span class="bg-yellow-400 text-yellow-900 px-4 py-2 rounded-full font-bold text-sm">
                                <i class="fas fa-clock mr-2"></i>
                                En attente
                            </span>
                        </div>

                        <div class="grid grid-cols-3 gap-8 items-center mb-6">
                            <div class="text-center">
                                <div class="w-24 h-24 bg-white rounded-full mx-auto mb-4 flex items-center justify-center overflow-hidden"
                                    id="previewLogo1">
                                    <i class="fas fa-shield-alt text-4xl text-purple-600"></i>
                                </div>
                                <h3 class="font-bold text-xl" id="previewTeam1">Équipe 1</h3>
                            </div>

                            <div class="text-center">
                                <div class="text-6xl font-black">VS</div>
                            </div>

                            <div class="text-center">
                                <div class="w-24 h-24 bg-white rounded-full mx-auto mb-4 flex items-center justify-center overflow-hidden"
                                    id="previewLogo2">
                                    <i class="fas fa-shield-alt text-4xl text-pink-600"></i>
                                </div>
                                <h3 class="font-bold text-xl" id="previewTeam2">Équipe 2</h3>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 bg-white bg-opacity-20 rounded-2xl p-6 backdrop-blur-lg">
                            <div class="flex items-center">
                                <i class="fas fa-map-marker-alt text-2xl mr-3"></i>
                                <span id="previewLocation">Stade, Ville</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-users text-2xl mr-3"></i>
                                <span id="previewPlaces">0 places</span>
                            </div>
                        </div>

                        <div class="text-center mt-6">
                            <div class="text-4xl font-black" id="previewPrice">À partir de -- MAD</div>
                        </div>
                    </div>

                    <!-- Categories Summary Table -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
                        <div class="bg-gradient-to-r from-purple-600 to-purple-700 text-white px-6 py-4">
                            <h3 class="text-xl font-bold">Récapitulatif des Catégories</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-purple-50">
                                    <tr>
                                        <th class="px-6 py-4 text-left font-semibold text-purple-900">Catégorie</th>
                                        <th class="px-6 py-4 text-left font-semibold text-purple-900">Places</th>
                                        <th class="px-6 py-4 text-left font-semibold text-purple-900">Prix</th>
                                        <th class="px-6 py-4 text-left font-semibold text-purple-900">Revenus potentiels
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="categoriesSummaryBody">
                                </tbody>
                                <tfoot class="bg-purple-800 text-white font-bold">
                                    <tr>
                                        <td class="px-6 py-4">TOTAL</td>
                                        <td class="px-6 py-4" id="totalPlacesSummary">0</td>
                                        <td class="px-6 py-4">-</td>
                                        <td class="px-6 py-4" id="totalRevenueSummary">0 MAD</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Terms Acceptance -->
                    <div class="bg-purple-50 border-2 border-purple-200 rounded-2xl p-6">
                        <label class="flex items-start cursor-pointer">
                            <input type="checkbox" id="termsAccept" required
                                class="mt-1 mr-3 w-5 h-5 text-purple-600 border-2 border-purple-300 rounded focus:ring-purple-500">
                            <span class="text-gray-700">
                                J'accepte les <a href="#"
                                    class="text-purple-600 font-semibold hover:underline">conditions générales</a> et
                                confirme que les informations sont exactes.
                            </span>
                        </label>
                    </div>
                </div>

                <!-- Form Navigation -->
                <div class="flex items-center justify-between mt-12 pt-8 border-t-2 border-purple-200">
                    <button type="button" id="prevBtn"
                        class="hidden bg-gray-500 hover:bg-gray-600 text-white px-8 py-3 rounded-xl font-bold transition-all shadow-lg hover:shadow-xl transform hover:scale-105">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Précédent
                    </button>

                    <button type="button" id="nextBtn"
                        class="ml-auto bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white px-8 py-3 rounded-xl font-bold transition-all shadow-lg hover:shadow-xl transform hover:scale-105">
                        Suivant
                        <i class="fas fa-arrow-right ml-2"></i>
                    </button>

                    <button type="submit" id="submitBtn"
                        class="hidden ml-auto bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-8 py-3 rounded-xl font-bold transition-all shadow-lg hover:shadow-xl transform hover:scale-105">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Soumettre la demande
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Success Modal -->
<div id="successModal"
    class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm hidden items-center justify-center z-50">
    <div class="bg-white rounded-3xl shadow-2xl p-12 max-w-2xl mx-4 animate-scale-in">
        <div class="text-center">
            <div class="text-8xl mb-6">🎉</div>
            <h2 class="text-4xl font-black text-purple-800 mb-4">DEMANDE ENVOYÉE!</h2>
            <p class="text-gray-600 text-lg mb-6">
                Votre demande de création de match a été soumise avec succès.<br>
                Elle sera examinée par notre équipe dans les plus brefs délais.
            </p>
            <div class="bg-yellow-100 border-2 border-yellow-400 rounded-2xl py-4 px-8 inline-block mb-8">
                <span class="text-yellow-800 font-bold text-lg">
                    <i class="fas fa-clock mr-2"></i>
                    En attente de validation
                </span>
            </div>
            <div class="flex gap-4 justify-center">
                <a href="/sports-ticketing/organizer/dashboard.php"
                    class="bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white px-8 py-3 rounded-xl font-bold transition-all shadow-lg hover:shadow-xl">
                    <i class="fas fa-home mr-2"></i>
                    Tableau de bord
                </a>
                <a href="/sports-ticketing/organizer/my-matches.php"
                    class="bg-white border-2 border-purple-600 text-purple-600 hover:bg-purple-50 px-8 py-3 rounded-xl font-bold transition-all shadow-lg hover:shadow-xl">
                    <i class="fas fa-futbol mr-2"></i>
                    Mes matchs
                </a>
            </div>
        </div>
    </div>
</div>

<script src="../../js/create-match.js"></script>

<?php include __DIR__ . '/../../includes/footer.php'; ?>