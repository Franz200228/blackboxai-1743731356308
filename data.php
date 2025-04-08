<?php
require 'session_handler.php';
require 'config.php';

// Verify user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Initialize variables
$data = [];
$error = '';

try {
    // Check if waste_data table exists
    $tableCheck = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='waste_data'");
    
    if ($tableCheck->rowCount() > 0) {
        // Fetch data with error handling
        $stmt = $pdo->query("SELECT * FROM waste_data ORDER BY collection_date DESC LIMIT 100");
        if ($stmt) {
            $data = $stmt->fetchAll();
        } else {
            $error = 'Error querying waste data.';
        }
    } else {
        $error = 'The waste_data table does not exist.';
    }
} catch (PDOException $e) {
    $error = 'Database error: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Waste Data</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .no-data {
            min-height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
    </style>
</head>
<body class="bg-gray-100">
    <header class="bg-green-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">Waste Management System</h1>
            <nav>
                <a href="dashboard.php" class="px-3 text-white hover:underline">Dashboard</a>
                <a href="data.php" class="px-3 text-white hover:underline font-bold">Data</a>
                <a href="logout.php" class="px-3 text-white hover:underline">Logout</a>
            </nav>
        </div>
    </header>

    <main class="container mx-auto py-6 px-4">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold mb-6">Waste Collection Records</h2>
            
            <?php if ($error): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">
                <p><?= htmlspecialchars($error) ?></p>
            </div>
            <?php endif; ?>

            <?php if (empty($data) && empty($error)): ?>
            <div class="no-data text-gray-500 text-center py-12">
                <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-lg">No waste data records found</p>
                <p class="text-sm mt-2">The system doesn't have any waste collection data yet</p>
            </div>
            <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Weight (kg)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($data as $row): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($row['collection_date'] ?? '') ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-sm rounded-full 
                                    <?= ($row['waste_type'] ?? '') === 'Recyclable' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' ?>">
                                    <?= htmlspecialchars($row['waste_type'] ?? 'Unknown') ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($row['weight'] ?? '0') ?> kg</td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($row['location'] ?? '') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </main>

    <footer class="bg-gray-800 text-white py-6 mt-8">
        <div class="container mx-auto text-center">
            <p>&copy; <?= date('Y') ?> Waste Management System</p>
        </div>
    </footer>
</body>
</html>