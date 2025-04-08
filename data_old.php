<?php
require 'session_handler.php';
require 'config.php';

// Verify user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch data from database
try {
    $stmt = $pdo->query("SELECT * FROM waste_data ORDER BY collection_date DESC");
    $data = $stmt->fetchAll();
} catch (PDOException $e) {
    $_SESSION['error'] = 'Error fetching data: ' . $e->getMessage();
    $data = [];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Waste Data - Waste Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <?php include 'header.php'; ?>

    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6">Waste Collection Data</h1>
        
        <!-- Data Filters -->
        <div class="bg-white p-4 rounded-lg shadow mb-6">
            <h2 class="text-xl font-semibold mb-4">Filters</h2>
            <form class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-gray-700 mb-2">Date From</label>
                    <input type="date" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Date To</label>
                    <input type="date" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Waste Type</label>
                    <select class="w-full p-2 border rounded">
                        <option>All Types</option>
                        <option>General Waste</option>
                        <option>Recyclables</option>
                        <option>Hazardous</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 w-full">
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>

        <!-- Data Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full">
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
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($row['collection_date']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($row['waste_type']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($row['weight']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($row['location']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>