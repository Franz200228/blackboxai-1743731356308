<?php require 'session_handler.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Waste Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-green-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-3xl font-bold">Waste Management System</h1>
            <nav>
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

    <!-- Hero Section -->
    <section class="py-20">
        <div class="container mx-auto text-center">
            <img src="https://images.pexels.com/photos/3160563/pexels-photo-3160563.jpeg?auto=compress&cs=tinysrgb&w=1200&h=768&dpr=1" 
                 alt="Recycling Bins" 
                 class="w-full h-96 object-cover rounded-lg shadow-lg mx-auto">
            <h2 class="text-4xl mt-8">Sustainable Waste Management</h2>
            <p class="text-lg mt-4">Join us in reducing waste and protecting the environment.</p>
            <a href="<?php echo isLoggedIn() ? 'dashboard.php' : 'register.php'; ?>" 
               class="inline-block bg-green-500 text-white px-6 py-3 mt-6 rounded-lg hover:bg-green-600">
                <?php echo isLoggedIn() ? 'Go to Dashboard' : 'Get Started'; ?>
            </a>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 px-4">
            <!-- Service Card 1 -->
            <div class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition-shadow">
                <div class="text-green-500 text-4xl mb-4">
                    <i class="fas fa-recycle"></i>
                </div>
                <h3 class="text-2xl mb-2">Recycling Tips</h3>
                <p>Learn how to properly sort recyclables and reduce contamination.</p>
            </div>
            <!-- Service Card 2 -->
            <div class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition-shadow">
                <div class="text-green-500 text-4xl mb-4">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h3 class="text-2xl mb-2">Trash Schedule</h3>
                <p>View your neighborhood collection dates and set reminders.</p>
            </div>
            <!-- Service Card 3 -->
            <div class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition-shadow">
                <div class="text-green-500 text-4xl mb-4">
                    <i class="fas fa-flag"></i>
                </div>
                <h3 class="text-2xl mb-2">Report Issues</h3>
                <p>Submit waste-related concerns and track their resolution.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto text-center">
            <p>&copy; <?php echo date('Y'); ?> Waste Management System. All rights reserved.</p>
            <div class="flex justify-center mt-4 space-x-4">
                <a href="#" class="hover:text-green-400"><i class="fab fa-facebook"></i></a>
                <a href="#" class="hover:text-green-400"><i class="fab fa-twitter"></i></a>
                <a href="#" class="hover:text-green-400"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </footer>
</body>
</html>