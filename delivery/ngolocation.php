<?php
include 'connection.php'; // Your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fid = $_POST['fid'];
    $lat = $_POST['latitude'];
    $lng = $_POST['longitude'];

    $sql = "UPDATE food_donations SET latitude = '$lat', longitude = '$lng' WHERE Fid = '$fid'";
    mysqli_query($connection, $sql);

    echo "Location updated successfully!";
}
?>

<!-- HTML Form -->
<form method="POST">
    <input type="hidden" name="fid" value="1"> <!-- Use real Fid -->
    <input type="text" name="latitude" placeholder="Latitude">
    <input type="text" name="longitude" placeholder="Longitude">
    <button type="submit">Share My Location</button>
</form>
