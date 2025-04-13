<?php
include 'connection.php';

$fid = $_GET['fid']; // Get donation ID dynamically
$query = "SELECT latitude, longitude FROM food_donations WHERE Fid = '$fid'";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);
$ngoLat = $row['latitude'];
$ngoLng = $row['longitude'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Track NGO Location</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>#map { height: 400px; }</style>
</head>
<body>

<h2>NGO Location and Your Live Location</h2>
<div id="map"></div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    const ngoLat = <?= $ngoLat ?>;
    const ngoLng = <?= $ngoLng ?>;

    const map = L.map('map').setView([ngoLat, ngoLng], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    // NGO Marker
    L.marker([ngoLat, ngoLng]).addTo(map).bindPopup("NGO Location").openPopup();

    // Delivery Person Live Location
    if (navigator.geolocation) {
        navigator.geolocation.watchPosition(function (position) {
            const delLat = position.coords.latitude;
            const delLng = position.coords.longitude;

            L.marker([delLat, delLng], {icon: L.icon({ iconUrl: 'https://cdn-icons-png.flaticon.com/512/684/684908.png', iconSize: [30, 30] })})
                .addTo(map)
                .bindPopup("Your Location");
        });
    }
</script>
</body>
</html>
