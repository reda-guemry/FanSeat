<?php
session_start();

require_once __DIR__ . '/../config/requirefichier.php';

$user = Authentification::checkuser();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = [
        'first_name' => trim($_POST['first_name'] ?? ''),
        'last_name' => trim($_POST['last_name'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'phone' => trim($_POST['phone'] ?? ''),
        'current_password' => trim($_POST['current_password'] ?? ''),
        'new_password' => trim($_POST['new_password'] ?? ''),
        'confirm_password' => trim($_POST['confirm_password'] ?? '')
    ];

    $_SESSION['success_message'] = $user -> modifierprofile($data);
    header('Location: profile.php');
    exit();

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - <?= $user ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gradient-to-br from-purple-500 via-purple-600 to-indigo-700 min-h-screen py-8 px-4">

    <div class="max-w-4xl mx-auto">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="dashboard.php" class="inline-flex items-center text-white hover:text-purple-200 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Dashboard
            </a>
        </div>

        <!-- Profile Card -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">

            <!-- Header Section -->
            <div class="bg-gradient-to-r from-blue-900 to-blue-800 px-8 py-12 text-center relative overflow-hidden">
                <!-- Decorative Background -->
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-0 left-1/4 w-96 h-96 bg-white rounded-full filter blur-3xl"></div>
                    <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-white rounded-full filter blur-3xl"></div>
                </div>

                <h1 class="text-3xl font-bold text-white mb-2">
                    <?= htmlspecialchars($user) ?>
                </h1>
                <p class="text-blue-200 uppercase tracking-wider text-sm font-semibold">
                    <?= ucfirst($user->getRole()) ?>
                </p>
            </div>

            <!-- Form Section -->
            <form method="POST" action="" class="p-8">

                <!-- Success/Error Messages -->
                <?php if (isset($_SESSION['success_message']) && $_SESSION['success_message']['success']): ?>
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            <p class="text-green-800 font-medium"><?= $_SESSION['success_message']['message'] ?></p>
                        </div>
                    </div>
                     <?php unset($_SESSION['success_message']); ?>
                <?php elseif(isset($_SESSION['success_message'])) : ?>
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-circle text-red-500 mr-3 mt-0.5"></i>
                            <div class="text-red-800"><?= $$_SESSION['success_message']['message'] ?></div>
                        </div>
                    </div>
                     <?php unset($_SESSION['success_message']); ?>
                <?php endif; ?>

                <!-- Personal Information Section -->
                <div class="mb-8">
                    <div class="flex items-center mb-6 pb-3 border-b-2 border-gray-200">
                        <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800">Personal Information</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- First Name -->
                        <div>
                            <label for="first_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                First Name <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input type="text" id="first_name" name="first_name"
                                    value="<?= htmlspecialchars($user->getFirstName()) ?>" required
                                    class="w-full pl-10 pr-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition-colors"
                                    placeholder="Enter first name">
                            </div>
                        </div>

                        <!-- Last Name -->
                        <div>
                            <label for="last_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Last Name <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input type="text" id="last_name" name="last_name"
                                    value="<?= htmlspecialchars($user->getLastName()) ?>" required
                                    class="w-full pl-10 pr-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition-colors"
                                    placeholder="Enter last name">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information Section -->
                <div class="mb-8">
                    <div class="flex items-center mb-6 pb-3 border-b-2 border-gray-200">
                        <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-envelope text-white"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800">Contact Information</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input type="email" id="email" name="email"
                                    value="<?= htmlspecialchars($user->getEmail()) ?>" required
                                    class="w-full pl-10 pr-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition-colors"
                                    placeholder="your.email@example.com">
                            </div>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                Phone Number <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-phone text-gray-400"></i>
                                </div>
                                <input type="tel" id="phone" name="phone"
                                    value="<?= htmlspecialchars($user->getPhone()) ?>" required
                                    class="w-full pl-10 pr-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition-colors"
                                    placeholder="+1 (555) 000-0000">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Change Password Section (Optional) -->
                <div class="mb-8">
                    <div class="flex items-center mb-6 pb-3 border-b-2 border-gray-200">
                        <div class="w-10 h-10 bg-red-600 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-lock text-white"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800">Change Password</h2>
                    </div>

                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 rounded-r-lg">
                        <div class="flex">
                            <i class="fas fa-info-circle text-yellow-600 mr-3 mt-0.5"></i>
                            <p class="text-sm text-yellow-800">
                                Leave password fields empty if you don't want to change your password.
                            </p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <!-- Current Password -->
                        <div>
                            <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2">
                                Current Password
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input type="password" id="current_password" name="current_password"
                                    class="w-full pl-10 pr-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition-colors"
                                    placeholder="Enter current password">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- New Password -->
                            <div>
                                <label for="new_password" class="block text-sm font-semibold text-gray-700 mb-2">
                                    New Password
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-key text-gray-400"></i>
                                    </div>
                                    <input type="password" id="new_password" name="new_password"
                                        class="w-full pl-10 pr-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition-colors"
                                        placeholder="Minimum 8 characters">
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="confirm_password" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Confirm New Password
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-key text-gray-400"></i>
                                    </div>
                                    <input type="password" id="confirm_password" name="confirm_password"
                                        class="w-full pl-10 pr-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition-colors"
                                        placeholder="Re-enter new password">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account Information (Read-Only) -->
                <div class="mb-8">
                    <div class="flex items-center mb-6 pb-3 border-b-2 border-gray-200">
                        <div class="w-10 h-10 bg-gray-600 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-info-circle text-white"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800">Account Information</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Role -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <p class="text-xs text-gray-500 uppercase tracking-wider mb-2">Role</p>
                            <p class="text-lg font-semibold text-gray-800 capitalize">
                                <?= htmlspecialchars($user->getRole()) ?>
                            </p>
                        </div>

                        <!-- Status -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <p class="text-xs text-gray-500 uppercase tracking-wider mb-2">Status</p>
                            <div class="flex items-center">
                                <?php if ($user->getStatus() == 1): ?>
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
                                        <i class="fas fa-check-circle mr-1"></i> Active
                                    </span>
                                <?php else: ?>
                                    <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-semibold">
                                        <i class="fas fa-times-circle mr-1"></i> Inactive
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t-2 border-gray-200">
                    <button type="submit"
                        class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold py-4 px-6 rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <i class="fas fa-save mr-2"></i>
                        Save Changes
                    </button>

                    <a href="/fan-seat/src/page/profile.php" type="reset"
                        class="flex-1 bg-gray-200 text-gray-700 font-bold py-4 px-6 rounded-lg hover:bg-gray-300 transition-colors">
                        <i class="fas fa-undo mr-2"></i>
                        Reset Form
                    </a>

                    <a href="/fan-seat/src/page/accueil.php"
                        class="flex-1 text-center bg-white border-2 border-gray-300 text-gray-700 font-bold py-4 px-6 rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fas fa-times mr-2"></i>
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Additional Info Card -->
        <div class="mt-6 bg-white bg-opacity-20 backdrop-blur-sm rounded-xl p-6 text-white">
            <div class="flex items-start">
                <i class="fas fa-shield-alt text-2xl mr-4 mt-1"></i>
                <div>
                    <h3 class="font-bold text-lg mb-2">Privacy & Security</h3>
                    <p class="text-sm text-white text-opacity-90">
                        Your information is secure and encrypted. We never share your personal data with third parties.
                        Make sure to use a strong password and enable two-factor authentication for enhanced security.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
         Form validation
        document.querySelector('form').addEventListener('submit', function (e) {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;

            if (newPassword || confirmPassword) {
                if (newPassword !== confirmPassword) {
                    e.preventDefault();
                    alert('New passwords do not match!');
                    return false;
                }

                if (newPassword.length < 8) {
                    e.preventDefault();
                    alert('New password must be at least 8 characters long!');
                    return false;
                }
            }
        });

        Auto - hide success message after 5 seconds
        const successAlert = document.querySelector('.bg-green-50');
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.transition = 'opacity 0.5s';
                successAlert.style.opacity = '0';
                setTimeout(() => successAlert.remove(), 500);
            }, 5000);
        }
    </script>
</body>

</html>