<?php 
require 'session_handler.php';
http_response_code(404);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Page Not Found - Waste Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .error-illustration {
            background-image: url('https://images.pexels.com/photos/3859986/pexels-photo-3859986.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1');
            background-size: cover;
            background-position: center;
            height: 300px;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-green-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-3xl font-bold">Waste Management</h1>
            <nav>
                <a href="index.php" class="px-4 text-white hover:underline">Home</a>
                <?php if (isLoggedIn()): ?>
                    <a href="dashboard.php" class="px-4 text-white hover:underline">Dashboard</a>
                    <a href="logout.php" class="px-4 text-white hover:underline">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="px-4 text-white hover:underline">Login</a>
                    <a href="register.php" class="px-4 text-white hover:underline">Register</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <!-- Error Content -->
    <main>
        <div class="error-illustration"></div>
        <div class="container mx-auto py-12 text-center">
            <div class="max-w-2xl mx-auto">
                <div class="bg-white p-8 rounded-lg shadow-lg">
                    <i class="fas fa-exclamation-triangle text-yellow-500 text-6xl mb-6"></i>
                    <h1 class="text-5xl font-bold mb-4">404</h1>
                    <h2 class="text-2xl mb-6">Page Not Found</h2>
                    <p class="text-gray-700 mb-8">
                        The page you're looking for doesn't exist or has been moved.
                        <br>Here are some helpful links instead:
                    </p>
                    <div class="flex flex-wrap justify-center gap-4 mb-8">
                        <a href="index.php" class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition-colors">
                            <i class="fas fa-home mr-2"></i> Home
                        </a>
                        <?php if (isLoggedIn()): ?>
                            <a href="dashboard.php" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition-colors">
                                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                            </a>
                        <?php else: ?>
                            <a href="login.php" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition-colors">
                                <i class="fas fa-sign-in-alt mr-2"></i> Login
                            </a>
                            <a href="register.php" class="bg-purple-500 text-white px-6 py-3 rounded-lg hover:bg-purple-600 transition-colors">
                                <i class="fas fa-user-plus mr-2"></i> Register
                            </a>
                        <?php endif; ?>
                    </div>
                    <form action="index.php" method="GET" class="max-w-md mx-auto">
                        <div class="flex">
                            <input type="text" name="search" placeholder="Search our site..." 
                                   class="flex-grow px-4 py-2 border rounded-l-lg focus:outline-none focus:border-green-500">
                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-r-lg hover:bg-green-600 transition-colors">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto text-center">
            <p>&copy; <?php echo date('Y'); ?> Waste Management System. All rights reserved.</p>
            <div class="flex justify-center mt-4 space-x-6">
                <a href="#" class="hover:text-green-400"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="hover:text-green-400"><i class="fab fa-twitter"></i></a>
                <a href="#" class="hover:text-green-400"><i class="fab fa-instagram"></i></a>
                <a href="#" class="hover:text-green-400"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
    </footer>
</body>
</html>