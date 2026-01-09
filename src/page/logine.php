<?php
/*
 * Page de connexion
*/
    require_once __DIR__ . '/../classes/autentification.php';

    $error = '' ;

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $logine = new Authentification() ; 

        $reponse = $logine -> login($_POST['email'] , $_POST['password']) ;
        
        if($reponse['status']){
            $_SESSION['success'] = 'Compte créé avec succès!';
            if($_SESSION['role'] === 'admin') {
                header('Location: admin/dhasbordadmin.php');
                exit();
            }
            if($_SESSION['role'] === 'organizer') { 
                header('Location: organizateur/dhasbordorganizateur.php');
                exit();
            }
            if($_SESSION['role'] === 'user') { 
                header('Location: accueil.php');
                exit();
            }

        }else {
            $error = $reponse['message'] ;
        }
    }

    require_once __DIR__ . '/../includes/header.php';
?>

<section class="py-16 bg-linear-to-r from-purple-50 to-purple-100 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="max-w-md mx-auto">
            <!-- En-tête -->
            <div class="text-center mb-8">
                <div class="bg-purple-600 text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <i class="fas fa-sign-in-alt text-2xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-800">Connexion</h1>
                <p class="text-gray-600 mt-2">Accédez à votre compte</p>
            </div>



            <?php if (isset($_SESSION['success'])): ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded my-2">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <?php echo htmlspecialchars($_SESSION['success']); ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if($error): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            
            <!-- Formulaire -->
            <div class="bg-white rounded-xl shadow-xl p-8">
                <form method="POST" action="">
                    <!-- Email -->
                    <div class="mb-6">
                        <label for="email" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-envelope mr-2"></i>
                            Adresse Email
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
                    
                    <!-- Mot de passe -->
                    <div class="mb-6">
                        <label for="password" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-lock mr-2"></i>
                            Mot de Passe
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                            placeholder="••••••••"
                        >
                    </div>
                    
                    <!-- Se souvenir de moi -->
                    <div class="flex items-center justify-between mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="mr-2">
                            <span class="text-sm text-gray-600">Se souvenir de moi</span>
                        </label>
                        <a href="#" class="text-sm text-purple-600 hover:text-purple-700">
                            Mot de passe oublié?
                        </a>
                    </div>
                    
                    <!-- Bouton de soumission -->
                    <button 
                        type="submit" 
                        class="w-full bg-linear-to-r from-purple-600 to-purple-700 text-white py-3 rounded-lg font-semibold hover:from-purple-700 hover:to-purple-800 transition"
                    >
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Se Connecter
                    </button>
                </form>
                
                <!-- Lien d'inscription -->
                <div class="mt-6 text-center">
                    <p class="text-gray-600">
                        Pas encore de compte?
                        <a href="/fan-seat/src/page/register.php" class="text-purple-600 hover:text-purple-700 font-semibold">
                            Inscrivez-vous
                        </a>
                    </p>
                </div>
                
            </div>
        </div>
    </div>
</section>


<?php include __DIR__ . '/../includes/footer.php'; ?>
