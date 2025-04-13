<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include("connect.php");

// Fetch delivery person ID from session
$deliveryId = $_SESSION['Did'] ?? null;

if (!$deliveryId) {
    echo "<p>Please login to access location sharing.</p>";
    exit();
}

// Fetch delivery person's location (latitude & longitude)
$deliveryQuery = "SELECT latitude AS delivery_lat, longitude AS delivery_lng FROM admin WHERE Aid = $deliveryId LIMIT 1";
$deliveryResult = mysqli_query($connection, $deliveryQuery);
$deliveryData = mysqli_fetch_assoc($deliveryResult);

// Fetch NGO/user location from assigned order
$orderQuery = "SELECT fd.latitude AS ngo_lat, fd.longitude AS ngo_lng 
               FROM food_donations fd
               WHERE fd.assigned_to = $deliveryId AND fd.delivery_by = $deliveryId
               ORDER BY fd.date DESC LIMIT 1";
$orderResult = mysqli_query($connection, $orderQuery);
$orderData = mysqli_fetch_assoc($orderResult);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Live Location Map</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        h2 {
            text-align: center;
            margin-top: 20px;
        }
        #map {
            height: 500px;
            margin: 20px auto;
            width: 90%;
            max-width: 1000px;
            border: 2px solid #06C167;
            border-radius: 10px;
        }
    </style>
</head>
<body>

<h2>Live Delivery Tracking</h2>
<div id="map"></div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const deliveryLat = <?= json_encode($deliveryData['delivery_lat']) ?>;
    const deliveryLng = <?= json_encode($deliveryData['delivery_lng']) ?>;
    const ngoLat = <?= json_encode($orderData['ngo_lat']) ?>;
    const ngoLng = <?= json_encode($orderData['ngo_lng']) ?>;

    const map = L.map('map').setView([deliveryLat, deliveryLng], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const deliveryMarker = L.marker([deliveryLat, deliveryLng]).addTo(map)
        .bindPopup("Delivery Person").openPopup();

    const ngoMarker = L.marker([ngoLat, ngoLng]).addTo(map)
        .bindPopup("NGO/User Location");

    // Optional: Fit both markers
    const group = new L.featureGroup([deliveryMarker, ngoMarker]);
    map.fitBounds(group.getBounds());
</script>

</body>
</html>
