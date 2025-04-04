<?php require 'session_handler.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Waste Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('toggle-icon');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.className = 'fas fa-eye-slash';
            } else {
                passwordField.type = 'password';
                toggleIcon.className = 'fas fa-eye';
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
                <a href="register.php" class="px-4 text-white hover:underline">Register</a>
            </nav>
        </div>
    </header>

    <!-- Login Form -->
    <div class="container mx-auto py-12">
        <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg">
            <h2 class="text-2xl mb-6 text-center">Login to Your Account</h2>
            <?php displayMessages(); ?>
            <form action="login_process.php" method="POST">
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
                    <button type="button" onclick="togglePassword()"
                            class="absolute right-3 top-10 text-gray-500 hover:text-green-500">
                        <i id="toggle-icon" class="fas fa-eye"></i>
                    </button>
                </div>
                <div class="mb-6">
                    <a href="#" class="text-sm text-green-500 hover:underline">Forgot Password?</a>
                </div>
                <button type="submit" 
                        class="w-full bg-green-500 text-white py-3 rounded-lg hover:bg-green-600 transition-colors">
                    Login
                </button>
                <p class="text-center mt-4">
                    Don't have an account? <a href="register.php" class="text-green-500 hover:underline">Register here</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>