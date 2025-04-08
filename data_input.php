<?php
require 'session_handler.php';
require 'config.php';

// Check if user is logged in and has permission
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$success = '';
$error = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $type = $_POST['waste_type'];
        $weight = (float)$_POST['weight'];
        $location = $_POST['location'];
        $date = $_POST['collection_date'] ?? date('Y-m-d');
        $notes = $_POST['notes'] ?? '';

        // Validate inputs
        if (empty($type) || $weight <= 0 || empty($location)) {
            throw new Exception('Please fill all required fields with valid data');
        }

        // Insert into database
        $stmt = $pdo->prepare("INSERT INTO waste_data (waste_type, weight, location, collection_date, notes) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$type, $weight, $location, $date, $notes]);

        $success = 'Data successfully recorded!';
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Input - Waste Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <?php include 'header.php'; ?>

    <div class="container mx-auto py-8 px-4">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-lg">
            <h1 class="text-2xl font-bold mb-6">Waste Data Input</h1>
            
            <?php if ($success): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <?= htmlspecialchars($success) ?>
            </div>
            <?php endif; ?>

            <?php if ($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <?= htmlspecialchars($error) ?>
            </div>
            <?php endif; ?>

            <form method="POST" class="space-y-4">
                <div>
                    <label class="block text-gray-700 mb-2">Waste Type *</label>
                    <select name="waste_type" class="w-full p-2 border rounded focus:border-green-500" required>
                        <option value="">Select Type</option>
                        <option value="General">General Waste</option>
                        <option value="Recyclable">Recyclable</option>
                        <option value="Hazardous">Hazardous</option>
                        <option value="Organic">Organic</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Weight (kg) *</label>
                    <input type="number" name="weight" step="0.01" min="0.1" 
                           class="w-full p-2 border rounded focus:border-green-500" required>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Location *</label>
                    <input type="text" name="location" 
                           class="w-full p-2 border rounded focus:border-green-500" required>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Collection Date</label>
                    <input type="date" name="collection_date" 
                           class="w-full p-2 border rounded focus:border-green-500"
                           value="<?= date('Y-m-d') ?>">
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Notes</label>
                    <textarea name="notes" rows="3" 
                              class="w-full p-2 border rounded focus:border-green-500"></textarea>
                </div>

                <div class="pt-4">
                    <button type="submit" 
                            class="w-full bg-green-500 text-white py-3 rounded-lg hover:bg-green-600 transition-colors">
                        Submit Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>