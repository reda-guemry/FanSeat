<?php
/**
 * Gestion des Utilisateurs - Administrateur
 */




include __DIR__ . '/../includes/header.php';
?>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .animate-fade-in {
        animation: fadeIn 0.5s ease-out;
    }

    .animate-slide-in {
        animation: slideIn 0.5s ease-out;
    }

    .card-smooth {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .card-smooth:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 30px rgba(147, 51, 234, 0.2);
    }

    .table-row-hover {
        transition: all 0.3s ease;
    }

    .table-row-hover:hover {
        background: linear-gradient(90deg, #f3e8ff 0%, #faf5ff 100%);
        transform: scale(1.01);
    }
</style>

<!-- Hero Section -->
<section class="bg-gradient-to-r from-purple-700 via-purple-800 to-purple-900 text-white py-16 animate-fade-in">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between">
            <div>
                <nav class="text-sm mb-4">
                    <a href="/sports-ticketing/admin/dashboard.php" class="text-purple-200 hover:text-white transition">
                        <i class="fas fa-home mr-2"></i>Dashboard
                    </a>
                    <span class="mx-2 text-purple-300">/</span>
                    <span class="text-white">Gestion des Utilisateurs</span>
                </nav>
                <h1 class="text-4xl font-bold mb-2">
                    <i class="fas fa-users-cog mr-3"></i>
                    Gestion des Utilisateurs
                </h1>
                <p class="text-purple-200 text-lg">
                    Gérez tous les comptes utilisateurs de la plateforme
                </p>
            </div>
            <div class="hidden md:block">
                <div class="bg-white bg-opacity-20 backdrop-blur-lg rounded-2xl p-6 text-center">
                    <p class="text-sm text-purple-200 mb-1">Total Utilisateurs</p>
                    <p class="text-4xl font-bold"><?php echo count($all_users); ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Filtres et Recherche -->
<section class="py-8 bg-gradient-to-br from-purple-50 to-white">
    <div class="container mx-auto px-4">
        <div class="bg-white rounded-2xl shadow-lg p-6 animate-slide-in">
            <form method="GET" action="" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Recherche -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-search mr-2 text-purple-600"></i>
                        Rechercher
                    </label>
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Nom, email..."
                        value="<?php echo htmlspecialchars($search); ?>"
                        class="w-full px-4 py-3 border border-purple-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 transition-all"
                    >
                </div>

                <!-- Filtre par rôle -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-user-tag mr-2 text-purple-600"></i>
                        Rôle
                    </label>
                    <select 
                        name="role"
                        class="w-full px-4 py-3 border border-purple-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 transition-all"
                    >
                        <option value="">Tous les rôles</option>
                        <option value="admin" <?php echo $role_filter === 'admin' ? 'selected' : ''; ?>>Admin</option>
                        <option value="organizer" <?php echo $role_filter === 'organizer' ? 'selected' : ''; ?>>Organisateur</option>
                        <option value="user" <?php echo $role_filter === 'user' ? 'selected' : ''; ?>>Utilisateur</option>
                    </select>
                </div>

                <!-- Filtre par statut -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-toggle-on mr-2 text-purple-600"></i>
                        Statut
                    </label>
                    <select 
                        name="status"
                        class="w-full px-4 py-3 border border-purple-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 transition-all"
                    >
                        <option value="">Tous les statuts</option>
                        <option value="1" <?php echo $status_filter === '1' ? 'selected' : ''; ?>>Actif</option>
                        <option value="0" <?php echo $status_filter === '0' ? 'selected' : ''; ?>>Inactif</option>
                    </select>
                </div>

                <!-- Bouton de recherche -->
                <div class="md:col-span-4 flex gap-3">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white py-3 rounded-xl font-semibold transition-all shadow-lg hover:shadow-xl transform hover:scale-105">
                        <i class="fas fa-search mr-2"></i>
                        Rechercher
                    </button>
                    <a href="/sports-ticketing/admin/users.php" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 rounded-xl font-semibold transition-all">
                        <i class="fas fa-redo mr-2"></i>
                        Réinitialiser
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Liste des Utilisateurs -->
<section class="py-8 bg-gradient-to-br from-purple-50 to-white">
    <div class="container mx-auto px-4">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <!-- En-tête du tableau -->
            <div class="bg-gradient-to-r from-purple-700 to-purple-900 text-white px-6 py-4">
                <h2 class="text-xl font-bold">
                    <i class="fas fa-list mr-2"></i>
                    Liste des Utilisateurs (<?php echo count($users); ?>)
                </h2>
            </div>

            <!-- Tableau -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-purple-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-purple-900">
                                <i class="fas fa-user mr-2"></i>Utilisateur
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-purple-900">
                                <i class="fas fa-envelope mr-2"></i>Email
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-purple-900">
                                <i class="fas fa-phone mr-2"></i>Téléphone
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-purple-900">
                                <i class="fas fa-user-tag mr-2"></i>Rôle
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-purple-900">
                                <i class="fas fa-toggle-on mr-2"></i>Statut
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-purple-900">
                                <i class="fas fa-calendar mr-2"></i>Inscription
                            </th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-purple-900">
                                <i class="fas fa-cog mr-2"></i>Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($users)): ?>
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fas fa-users-slash text-6xl mb-4 block text-gray-300"></i>
                                    <p class="text-lg">Aucun utilisateur trouvé</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($users as $user): ?>
                                <tr class="table-row-hover border-b border-purple-100">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-700 rounded-full flex items-center justify-center text-white font-bold mr-3 shadow-md">
                                                <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
                                            </div>
                                            <span class="font-semibold text-gray-800">
                                                <?php echo htmlspecialchars($user['name']); ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-700">
                                        <?php echo htmlspecialchars($user['email']); ?>
                                    </td>
                                    <td class="px-6 py-4 text-gray-700">
                                        <?php echo htmlspecialchars($user['phone'] ?? 'N/A'); ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                            <?php 
                                                if ($user['role'] === 'admin') echo 'bg-red-100 text-red-700';
                                                elseif ($user['role'] === 'organizer') echo 'bg-blue-100 text-blue-700';
                                                else echo 'bg-green-100 text-green-700';
                                            ?>">
                                            <?php echo ucfirst($user['role']); ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php if ($user['status'] == 1): ?>
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                                <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                                                Actif
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                                <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                                                Inactif
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        <?php echo date('d/m/Y', strtotime($user['created_at'])); ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                                <?php if ($user['status'] == 1): ?>
                                                    <a href="?action=deactivate&id=<?php echo $user['id']; ?>" 
                                                       onclick="return confirm('Désactiver cet utilisateur?')"
                                                       class="bg-orange-500 hover:bg-orange-600 text-white px-3 py-2 rounded-lg transition-all text-xs font-semibold shadow-md hover:shadow-lg transform hover:scale-105"
                                                       title="Désactiver">
                                                        <i class="fas fa-ban"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <a href="?action=activate&id=<?php echo $user['id']; ?>" 
                                                       onclick="return confirm('Activer cet utilisateur?')"
                                                       class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-lg transition-all text-xs font-semibold shadow-md hover:shadow-lg transform hover:scale-105"
                                                       title="Activer">
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                <?php endif; ?>
                                                
                                                <a href="?action=delete&id=<?php echo $user['id']; ?>" 
                                                   onclick="return confirm('Supprimer définitivement cet utilisateur?')"
                                                   class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg transition-all text-xs font-semibold shadow-md hover:shadow-lg transform hover:scale-105"
                                                   title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            <?php else: ?>
                                                <span class="text-purple-600 font-semibold text-xs">
                                                    <i class="fas fa-user-shield mr-1"></i>Vous
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>