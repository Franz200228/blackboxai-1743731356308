<?php require 'session_handler.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Register - Waste Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
        function togglePassword(fieldId, iconId) {
            const passwordField = document.getElementById(fieldId);
            const toggleIcon = document.getElementById(iconId);
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.className = 'fas fa-eye-slash';
            } else {
                passwordField.type = 'password';
                toggleIcon.className = 'fas fa-eye';
            }
        }

        function validatePassword() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const errorElement = document.getElementById('password-error');

            if (password !== confirmPassword) {
                errorElement.textContent = 'Passwords do not match';
                return false;
            } else if (password.length < 6) {
                errorElement.textContent = 'Password must be at least 6 characters';
                return false;
            } else {
                errorElement.textContent = '';
                return true;
            }
        }
    </script>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-green-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-3xl font-bold">Waste Management</h1>
            <nav>
                <a href="index.php" class="px-4 text-white hover:underline">Home</a>
                <a href="login.php" class="px-4 text-white hover:underline">Login</a>
            </nav>
        </div>
    </header>

    <!-- Registration Form -->
    <div class="container mx-auto py-12">
        <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg">
            <h2 class="text-2xl mb-6 text-center">Create Your Account</h2>
            <?php displayMessages(); ?>
            <form action="register_process.php" method="POST" onsubmit="return validatePassword()">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Full Name</label>
                    <input type="text" name="name" 
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-green-500"
                           placeholder="John Doe" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" 
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-green-500"
                           placeholder="example@example.com" required>
                </div>
                <div class="mb-4 relative">
                    <label class="block text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" id="password"
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-green-500"
                           placeholder="••••••••" required>
                    <button type="button" onclick="togglePassword('password', 'toggle-icon')"
                            class="absolute right-3 top-10 text-gray-500 hover:text-green-500">
                        <i id="toggle-icon" class="fas fa-eye"></i>
                    </button>
                </div>
                <div class="mb-4 relative">
                    <label class="block text-gray-700 mb-2">Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password"
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-green-500"
                           placeholder="••••••••" required>
                    <button type="button" onclick="togglePassword('confirm_password', 'toggle-icon-confirm')"
                            class="absolute right-3 top-10 text-gray-500 hover:text-green-500">
                        <i id="toggle-icon-confirm" class="fas fa-eye"></i>
                    </button>
                </div>
                <div id="password-error" class="text-red-500 text-sm mb-4"></div>
                <button type="submit" 
                        class="w-full bg-green-500 text-white py-3 rounded-lg hover:bg-green-600 transition-colors">
                    Register
                </button>
                <p class="text-center mt-4">
                    Already have an account? <a href="login.php" class="text-green-500 hover:underline">Login here</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>