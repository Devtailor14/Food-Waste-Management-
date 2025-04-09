<?php
session_start();
ob_start();

include("connect.php"); 
include '../connection.php';

if (empty($_SESSION['name']) || empty($_SESSION['city']) || empty($_SESSION['Did'])) {
    header("location:deliverylogin.php");
    exit();
}

$name = $_SESSION['name'];
$city = $_SESSION['city'];
$id = $_SESSION['Did'];



// Fetch orders
$sql = "SELECT 
            fd.Fid AS Fid,
            fd.location as cure,
            fd.name,
            fd.phoneno,
            fd.date,
            fd.delivery_by,
            fd.address as From_address, 
            ad.name AS delivery_person_name,
            ad.address AS To_address
        FROM food_donations fd
        LEFT JOIN admin ad ON fd.assigned_to = ad.Aid
        WHERE assigned_to IS NOT NULL 
        AND delivery_by IS NULL 
        AND fd.location = '$city'";

$result = mysqli_query($connection, $sql);

if (!$result) {
    die("Error executing query: " . mysqli_error($connection));
}

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Assign order
if (isset($_POST['food']) && isset($_POST['order_id']) && isset($_POST['delivery_person_id'])) {
    $order_id = $_POST['order_id'];
    $delivery_person_id = $_POST['delivery_person_id'];

    // Check if order is already taken
    $check_sql = "SELECT * FROM food_donations WHERE Fid = $order_id AND delivery_by IS NOT NULL";
    $check_result = mysqli_query($connection, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        die("Sorry, this order has already been assigned.");
    }

    // Assign the order
    $assign_sql = "UPDATE food_donations SET delivery_by = $delivery_person_id WHERE Fid = $order_id";
    if (!mysqli_query($connection, $assign_sql)) {
        die("Error assigning order: " . mysqli_error($connection));
    }

    header("Location: " . $_SERVER['REQUEST_URI']);
    ob_end_flush();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delivery Dashboard</title>
    <link rel="stylesheet" href="../home.css">
    <link rel="stylesheet" href="delivery.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .itm {
            background-color: white;
            display: grid;
        }
        .itm img {
            width: 400px;
            height: 400px;
            margin: auto;
        }
        p {
            text-align: center;
            font-size: 30px;
            color: black;
            margin-top: 50px;
        }
        .log {
            text-align: center;
            margin: 20px;
        }
        .log a {
            background-color: #06C167;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
        }
        .log a:hover {
            background-color: #05985b;
        }
        .table-container {
            padding: 20px;
        }
        .table-wrapper {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #06C167;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
        }
        button:hover {
            background-color: #05985b;
        }

        @media (max-width: 767px) {
            .itm img {
                width: 350px;
                height: 350px;
            }
        }
    </style>
</head>
<body>
<header>
    <div class="logo">Food <b style="color: #06C167;">Donate</b></div>
    <div class="hamburger">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
    </div>
    <nav class="nav-bar">
        <ul>
            <li><a href="#home" class="active">Home</a></li>
            <li><a href="openmap.php">Map</a></li>
            <li><a href="deliverymyord.php">My Orders</a></li>
        </ul>
    </nav>
</header>
<script>
    const hamburger = document.querySelector(".hamburger");
    hamburger.onclick = function () {
        document.querySelector(".nav-bar").classList.toggle("active");
    };
</script>

<h2><center>Welcome, <?= htmlspecialchars($name) ?></center></h2>

<div class="itm">
    <img src="../img/delivery.gif" alt="Delivery">
</div>

<div class="log">
    <a href="deliverymyord.php">My Orders</a>
</div>

<div class="table-container">
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone No</th>
                    <th>Date/Time</th>
                    <th>Pickup Address</th>
                    <th>Delivery Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($data as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['phoneno']) ?></td>
                    <td><?= htmlspecialchars($row['date']) ?></td>
                    <td><?= htmlspecialchars($row['From_address']) ?></td>
                    <td><?= htmlspecialchars($row['To_address']) ?></td>
                    <td>
                        <?php if ($row['delivery_by'] == null): ?>
                            <form method="post">
                                <input type="hidden" name="order_id" value="<?= $row['Fid'] ?>">
                                <input type="hidden" name="delivery_person_id" value="<?= $id ?>">
                                <button type="submit" name="food">Take Order</button>
                            </form>
                        <?php elseif ($row['delivery_by'] == $id): ?>
                            Order assigned to you
                        <?php else: ?>
                            Assigned to another delivery person
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
