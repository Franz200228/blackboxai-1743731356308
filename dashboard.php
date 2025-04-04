<?php
require 'session_handler.php';
requireLogin();

// Sample data for the dashboard
$collectionSchedule = [
    'next_general' => 'Friday, October 27',
    'next_recycling' => 'Tuesday, October 24',
    'calendar' => [
        20 => 'General Waste',
        24 => 'Recycling',
        27 => 'General Waste'
    ]
];

$recyclingStats = [
    'monthly_total' => '14.5 kg',
    'yearly_total' => '132.7 kg',
    'equivalent' => 'Saved 3 trees'
];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Waste Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .collection-day {
            background-color: #d1fae5;
            font-weight: bold;
            border-radius: 9999px;
        }
        .recycling-day {
            background-color: #bfdbfe;
            font-weight: bold;
            border-radius: 9999px;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-green-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-3xl font-bold">Waste Management</h1>
            <nav>
                <span class="px-4">Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?></span>
                <a href="index.php" class="px-4 text-white hover:underline">Home</a>
                <a href="logout.php" class="px-4 text-white hover:underline">Logout</a>
            </nav>
        </div>
    </header>

    <!-- Dashboard Content -->
    <div class="container mx-auto py-8 px-4">
        <?php displayMessages(); ?>
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Collection Card -->
            <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="bg-green-100 p-3 rounded-full mr-4">
                        <i class="fas fa-trash-alt text-green-500 text-xl"></i>
                    </div>
                    <h2 class="text-xl font-bold">Next Collection</h2>
                </div>
                <p class="text-gray-700 mb-2">General Waste: <span class="font-semibold"><?php echo $collectionSchedule['next_general']; ?></span></p>
                <p class="text-gray-700 mb-2">Recycling: <span class="font-semibold"><?php echo $collectionSchedule['next_recycling']; ?></span></p>
                <div class="mt-4 pt-4 border-t">
                    <a href="#" class="text-green-500 hover:underline flex items-center">
                        View full schedule <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>

            <!-- Recycling Stats Card -->
            <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="bg-blue-100 p-3 rounded-full mr-4">
                        <i class="fas fa-recycle text-blue-500 text-xl"></i>
                    </div>
                    <h2 class="text-xl font-bold">Recycling Impact</h2>
                </div>
                <p class="text-gray-700 mb-1">This month: <span class="font-semibold"><?php echo $recyclingStats['monthly_total']; ?></span></p>
                <p class="text-gray-700 mb-1">This year: <span class="font-semibold"><?php echo $recyclingStats['yearly_total']; ?></span></p>
                <p class="text-gray-700"><?php echo $recyclingStats['equivalent']; ?></p>
                <div class="mt-4 pt-4 border-t">
                    <a href="#" class="text-blue-500 hover:underline flex items-center">
                        View details <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="bg-purple-100 p-3 rounded-full mr-4">
                        <i class="fas fa-bolt text-purple-500 text-xl"></i>
                    </div>
                    <h2 class="text-xl font-bold">Quick Actions</h2>
                </div>
                <button class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-600 transition-colors mb-2">
                    <i class="fas fa-calendar-plus mr-2"></i> Schedule Pickup
                </button>
                <button class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition-colors mb-2">
                    <i class="fas fa-binoculars mr-2"></i> Check Recycling Guidelines
                </button>
                <button class="w-full bg-red-500 text-white py-2 rounded-lg hover:bg-red-600 transition-colors">
                    <i class="fas fa-exclamation-triangle mr-2"></i> Report Issue
                </button>
            </div>
        </div>

        <!-- Collection Calendar -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
            <h2 class="text-2xl font-bold mb-4">October Collection Schedule</h2>
            <div class="grid grid-cols-7 gap-2 text-center">
                <!-- Calendar Header -->
                <div class="font-bold py-2">Sun</div>
                <div class="font-bold py-2">Mon</div>
                <div class="font-bold py-2">Tue</div>
                <div class="font-bold py-2">Wed</div>
                <div class="font-bold py-2">Thu</div>
                <div class="font-bold py-2">Fri</div>
                <div class="font-bold py-2">Sat</div>
                
                <!-- Calendar Days -->
                <?php
                // Generate calendar days
                $firstDayOfWeek = 0; // October 1st is Sunday
                $daysInMonth = 31;
                
                // Empty cells for days before the 1st
                for ($i = 0; $i < $firstDayOfWeek; $i++) {
                    echo '<div class="py-2 text-gray-400">' . (30 - $firstDayOfWeek + $i + 1) . '</div>';
                }
                
                // Days of the month
                for ($day = 1; $day <= $daysInMonth; $day++) {
                    $class = 'py-2';
                    if (isset($collectionSchedule['calendar'][$day])) {
                        $class .= $collectionSchedule['calendar'][$day] === 'General Waste' 
                            ? ' collection-day' 
                            : ' recycling-day';
                    }
                    echo "<div class='$class'>$day</div>";
                }
                ?>
            </div>
            <div class="mt-4 flex items-center justify-center space-x-4">
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-green-100 rounded-full mr-2"></div>
                    <span class="text-sm">General Waste</span>
                </div>
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-blue-100 rounded-full mr-2"></div>
                    <span class="text-sm">Recycling</span>
                </div>
            </div>
        </div>

        <!-- Recycling Tips Section -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold mb-4">Recycling Tips</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tip 1 -->
                <div class="flex items-start bg-green-50 p-4 rounded-lg">
                    <div class="bg-green-100 p-3 rounded-full mr-4">
                        <i class="fas fa-check text-green-500"></i>
                    </div>
                    <div>
                        <h3 class="font-bold mb-1">Clean Before Recycling</h3>
                        <p class="text-gray-700">Rinse containers to remove food residue. This prevents contamination and improves recycling quality.</p>
                    </div>
                </div>
                
                <!-- Tip 2 -->
                <div class="flex items-start bg-green-50 p-4 rounded-lg">
                    <div class="bg-green-100 p-3 rounded-full mr-4">
                        <i class="fas fa-check text-green-500"></i>
                    </div>
                    <div>
                        <h3 class="font-bold mb-1">Flatten Cardboard</h3>
                        <p class="text-gray-700">Break down boxes to save space in your bin and make collection more efficient.</p>
                    </div>
                </div>
                
                <!-- Tip 3 -->
                <div class="flex items-start bg-green-50 p-4 rounded-lg">
                    <div class="bg-green-100 p-3 rounded-full mr-4">
                        <i class="fas fa-check text-green-500"></i>
                    </div>
                    <div>
                        <h3 class="font-bold mb-1">Know Your Plastics</h3>
                        <p class="text-gray-700">Check resin codes (1-7). Most programs accept #1 (PET) and #2 (HDPE) plastics.</p>
                    </div>
                </div>
                
                <!-- Tip 4 -->
                <div class="flex items-start bg-green-50 p-4 rounded-lg">
                    <div class="bg-green-100 p-3 rounded-full mr-4">
                        <i class="fas fa-check text-green-500"></i>
                    </div>
                    <div>
                        <h3 class="font-bold mb-1">No Plastic Bags</h3>
                        <p class="text-gray-700">Don't bag recyclables. Loose items are easier to sort at recycling facilities.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
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