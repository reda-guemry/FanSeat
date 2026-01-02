<?php
/**
 * Page d'inscription
 */

    require_once __DIR__ . '/../classes/autentification.php';

    session_start() ;

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $autentification = new Authentification() ;

        $data = [
            'first_name' => $_POST['first_name'] ,
            'last_name' => $_POST['last_name'] ,
            'email' => $_POST['email'] , 
            'phone' => $_POST['phone'] ,
            'role' => $_POST['role'] ,
            'password' => $_POST['password'] ,
            'confirm_password' => $_POST['confirm_password']
        ];

        $action = $autentification -> register($data) ;

        if($action['status']) {
            $_SESSION['success'] = $action['message'] ;
            header('Location: logine.php') ;
            exit; 
        }else{
            $error = $action['message'] ;
        }
    }
    

    require_once __DIR__ . '/../includes/header.php';
?>

<section class="py-16 bg-linear-to-r from-gray-100 to-gray-200 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">
            <!-- En-tête -->
            <div class="text-center mb-8">
                <div class="bg-purple-600 text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <i class="fas fa-user-plus text-2xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-800">Créer un Compte</h1>
                <p class="text-gray-600 mt-2">Rejoignez notre plateforme de billetterie sportive</p>
            </div>
            
            <!-- Messages -->
            <?php if ($error): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            

            <!-- Formulaire -->
            <div class="bg-white rounded-xl shadow-xl p-8">
                <form method="POST" action="">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Prénom -->
                        <div>
                            <label for="first_name" class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-user mr-2"></i>
                                Prénom <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="first_name" 
                                name="first_name" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                                placeholder="Mohammed"
                                value="<?php echo htmlspecialchars($_POST['first_name'] ?? ''); ?>"
                            >
                        </div>

                        <!-- Nom -->
                        <div>
                            <label for="last_name" class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-user mr-2"></i>
                                Nom <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="last_name" 
                                name="last_name" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                                placeholder="Alami"
                                value="<?php echo htmlspecialchars($_POST['last_name'] ?? ''); ?>"
                            >
                        </div>
                        
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-envelope mr-2"></i>
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                                placeholder="votre@email.com"
                                value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                            >
                        </div>
                        
                        <!-- Téléphone -->
                        <div>
                            <label for="phone" class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-phone mr-2"></i>
                                Téléphone
                            </label>
                            <input 
                                type="tel" 
                                id="phone" 
                                name="phone"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                                placeholder="+212 6XX-XXXXXX"
                                value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>"
                            >
                        </div>
                        
                        <!-- Type de compte -->
                        <div class="col-start-1 col-end-3">
                            <label for="role" class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-user-tag mr-2"></i>
                                Type de Compte
                            </label>
                            <select 
                                id="role" 
                                name="role"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                            >
                                <option value="user" <?php echo ($_POST['role'] ?? 'user') === 'user' ? 'selected' : ''; ?>>
                                    Utilisateur (Acheteur)
                                </option>
                                <option value="organizer" <?php echo ($_POST['role'] ?? '') === 'organizer' ? 'selected' : ''; ?>>
                                    Organisateur d'Événements
                                </option>
                            </select>
                        </div>
                        
                        <!-- Mot de passe -->
                        <div>
                            <label for="password" class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-lock mr-2"></i>
                                Mot de Passe <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                required
                                minlength="6"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                                placeholder="••••••••"
                            >
                            <p class="text-xs text-gray-500 mt-1">Minimum 6 caractères</p>
                        </div>
                        
                        <!-- Confirmer le mot de passe -->
                        <div>
                            <label for="confirm_password" class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-lock mr-2"></i>
                                Confirmer le Mot de Passe <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="password" 
                                id="confirm_password" 
                                name="confirm_password" 
                                required
                                minlength="6"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                                placeholder="••••••••"
                            >
                        </div>
                    </div>
                    
                    <!-- Conditions d'utilisation -->
                    <div class="mt-6">
                        <label class="flex items-start">
                            <input type="checkbox" required class="mt-1 mr-3">
                            <span class="text-sm text-gray-600">
                                J'accepte les 
                                <a href="#" class="text-purple-600 hover:text-purple-700">conditions d'utilisation</a>
                                et la 
                                <a href="#" class="text-purple-600 hover:text-purple-700">politique de confidentialité</a>
                            </span>
                        </label>
                    </div>
                    
                    <!-- Bouton de soumission -->
                    <button 
                        type="submit" 
                        class="w-full mt-6 bg-linear-to-r from-purple-600 to-purple-700 text-white py-3 rounded-lg font-semibold hover:from-purple-700 hover:to-purple-800 transition">
                        <i class="fas fa-user-plus mr-2"></i>
                        Créer Mon Compte
                    </button>
                </form>
                
                <!-- Lien de connexion -->
                <div class="mt-6 text-center">
                    <p class="text-gray-600">
                        Vous avez déjà un compte?
                        <a href="/sports-ticketing/public/login.php" class="text-purple-600 hover:text-purple-700 font-semibold">
                            Connectez-vous
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Validation en temps réel du mot de passe
document.getElementById('confirm_password').addEventListener('input', function() {
    const password = document.getElementById('password').value;
    const confirmPassword = this.value;
    
    if (password !== confirmPassword) {
        this.classList.add('border-red-500');
    } else {
        this.classList.remove('border-red-500');
    }
});
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
