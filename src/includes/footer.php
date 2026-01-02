<!-- Footer -->
<footer class="bg-gradient-to-t from-purple-700 to-purple-800 text-white mt-16">
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- À propos -->
            <div>
                <h3 class="text-xl font-bold mb-4">
                    <i class="fas fa-ticket-alt mr-2"></i>
                    Sports Ticketing
                </h3>
                <p class="text-purple-200">
                    Votre plateforme de billetterie sportive au Maroc.
                    Achetez vos billets en ligne facilement et en toute sécurité.
                </p>
            </div>

            <!-- Liens rapides -->
            <div>
                <h3 class="text-xl font-bold mb-4">Liens Rapides</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="/sports-ticketing/public/index.php"
                            class="text-purple-200 hover:text-white transition">
                            <i class="fas fa-angle-right mr-2"></i>Accueil
                        </a>
                    </li>
                    <li>
                        <a href="/sports-ticketing/public/matches.php"
                            class="text-purple-200 hover:text-white transition">
                            <i class="fas fa-angle-right mr-2"></i>Matchs
                        </a>
                    </li>
                    <li>
                        <a href="/sports-ticketing/public/about.php"
                            class="text-purple-200 hover:text-white transition">
                            <i class="fas fa-angle-right mr-2"></i>À propos
                        </a>
                    </li>
                    <li>
                        <a href="/sports-ticketing/public/contact.php"
                            class="text-purple-200 hover:text-white transition">
                            <i class="fas fa-angle-right mr-2"></i>Contact
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Support -->
            <div>
                <h3 class="text-xl font-bold mb-4">Support</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="/sports-ticketing/public/faq.php" class="text-purple-200 hover:text-white transition">
                            <i class="fas fa-angle-right mr-2"></i>FAQ
                        </a>
                    </li>
                    <li>
                        <a href="/sports-ticketing/public/terms.php"
                            class="text-purple-200 hover:text-white transition">
                            <i class="fas fa-angle-right mr-2"></i>Conditions d'utilisation
                        </a>
                    </li>
                    <li>
                        <a href="/sports-ticketing/public/privacy.php"
                            class="text-purple-200 hover:text-white transition">
                            <i class="fas fa-angle-right mr-2"></i>Politique de confidentialité
                        </a>
                    </li>
                    <li>
                        <a href="/sports-ticketing/public/help.php" class="text-purple-200 hover:text-white transition">
                            <i class="fas fa-angle-right mr-2"></i>Aide
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h3 class="text-xl font-bold mb-4">Contact</h3>
                <ul class="space-y-3 text-purple-200">
                    <li class="flex items-start">
                        <i class="fas fa-map-marker-alt mt-1 mr-3"></i>
                        <span>123 Avenue Mohammed V<br>Casablanca, Maroc</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-phone mr-3"></i>
                        <span>+212 5XX-XXXXXX</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-envelope mr-3"></i>
                        <span>contact@sportsticketing.ma</span>
                    </li>
                </ul>

                <!-- Réseaux sociaux -->
                <div class="flex space-x-4 mt-4">
                    <a href="#" class="text-purple-200 hover:text-white text-xl transition">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="#" class="text-purple-200 hover:text-white text-xl transition">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-purple-200 hover:text-white text-xl transition">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-purple-200 hover:text-white text-xl transition">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="border-t border-purple-600 mt-8 pt-8 text-center text-purple-200">
            <p>&copy; <?php echo date('Y'); ?> Sports Ticketing Platform. Tous droits réservés.</p>
            <p class="mt-2 text-sm">
                Développé avec <i class="fas fa-heart text-red-500"></i> au Maroc
            </p>
        </div>
    </div>
</footer>

<!-- Scripts JavaScript personnalisés -->
<script>
    // Fonction pour afficher les messages toast
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `fixed top-20 right-4 px-6 py-3 rounded-lg shadow-lg text-white z-50 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'
            }`;
        toast.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-${type === 'success' ? 'check' : 'times'}-circle mr-2"></i>
                    <span>${message}</span>
                </div>
            `;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transition = 'opacity 0.5s';
            setTimeout(() => toast.remove(), 500);
        }, 3000);
    }

    // Confirmation avant suppression
    function confirmDelete(message = 'Êtes-vous sûr de vouloir supprimer cet élément ?') {
        return confirm(message);
    }

    // Validation de formulaire basique
    function validateForm(formId) {
        const form = document.getElementById(formId);
        const inputs = form.querySelectorAll('[required]');
        let isValid = true;

        inputs.forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
                input.classList.add('border-red-500');
            } else {
                input.classList.remove('border-red-500');
            }
        });

        return isValid;
    }

    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
</script>
</body>

</html>