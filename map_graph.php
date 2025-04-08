<?php
require 'session_handler.php';
requireLogin();
require 'config.php';

// Fetch waste collection data from database
$collectionPoints = [];
$statsData = [];

try {
    $stmt = $pdo->query("SELECT location_name, latitude, longitude FROM collection_points");
    $collectionPoints = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->query("SELECT 
        DATE_FORMAT(collection_date, '%Y-%m') AS month,
        SUM(general_waste) AS general_waste,
        SUM(recyclables) AS recyclables
        FROM collections
        GROUP BY month
        ORDER BY month DESC
        LIMIT 12");
    $statsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle error
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Waste Collection Analytics</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        #map { 
            height: 500px;
            border-radius: 0.5rem;
        }
        .leaflet-popup-content {
            font-family: sans-serif;
        }
        .chart-container {
            position: relative;
            height: 400px;
        }
    </style>
</head>
<body class="bg-gray-100">
    <?php include 'header.php'; ?>

    <div class="container mx-auto py-8 px-4">
        <h1 class="text-3xl font-bold mb-8 text-green-700">Waste Collection Analytics</h1>
        
        <!-- Map Section -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
            <div class="flex items-center mb-4">
                <div class="bg-green-100 p-3 rounded-full mr-4">
                    <i class="fas fa-map-marked-alt text-green-500 text-xl"></i>
                </div>
                <h2 class="text-xl font-bold">Collection Points Map</h2>
            </div>
            <div id="map"></div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Waste Collection Trends -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex items-center mb-4">
                    <div class="bg-blue-100 p-3 rounded-full mr-4">
                        <i class="fas fa-chart-line text-blue-500 text-xl"></i>
                    </div>
                    <h2 class="text-xl font-bold">Monthly Collection Trends</h2>
                </div>
                <div class="chart-container">
                    <canvas id="trendsChart"></canvas>
                </div>
            </div>

            <!-- Waste Composition -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex items-center mb-4">
                    <div class="bg-purple-100 p-3 rounded-full mr-4">
                        <i class="fas fa-chart-pie text-purple-500 text-xl"></i>
                    </div>
                    <h2 class="text-xl font-bold">Waste Composition</h2>
                </div>
                <div class="chart-container">
                    <canvas id="compositionChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Initialize Map
        const map = L.map('map').setView([51.505, -0.09], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Add collection points to map
        <?php foreach ($collectionPoints as $point): ?>
            L.marker([<?= $point['latitude'] ?>, <?= $point['longitude'] ?>])
                .addTo(map)
                .bindPopup("<b><?= htmlspecialchars($point['location_name']) ?></b>");
        <?php endforeach; ?>

        // Initialize Trends Chart
        const trendsCtx = document.getElementById('trendsChart').getContext('2d');
        const trendsChart = new Chart(trendsCtx, {
            type: 'line',
            data: {
                labels: <?= json_encode(array_column($statsData, 'month')) ?>,
                datasets: [
                    {
                        label: 'General Waste (kg)',
                        data: <?= json_encode(array_column($statsData, 'general_waste')) ?>,
                        borderColor: 'rgb(239, 68, 68)',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        tension: 0.1,
                        fill: true
                    },
                    {
                        label: 'Recyclables (kg)',
                        data: <?= json_encode(array_column($statsData, 'recyclables')) ?>,
                        borderColor: 'rgb(16, 185, 129)',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.1,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Kilograms'
                        }
                    }
                }
            }
        });

        // Initialize Composition Chart
        const compositionCtx = document.getElementById('compositionChart').getContext('2d');
        const compositionChart = new Chart(compositionCtx, {
            type: 'doughnut',
            data: {
                labels: ['General Waste', 'Recyclables'],
                datasets: [{
                    data: [
                        <?= array_sum(array_column($statsData, 'general_waste')) ?>,
                        <?= array_sum(array_column($statsData, 'recyclables')) ?>
                    ],
                    backgroundColor: [
                        'rgba(239, 68, 68, 0.7)',
                        'rgba(16, 185, 129, 0.7)'
                    ],
                    borderColor: [
                        'rgba(239, 68, 68, 1)',
                        'rgba(16, 185, 129, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const value = context.raw;
                                const percentage = Math.round((value / total) * 100);
                                return `${context.label}: ${value}kg (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>