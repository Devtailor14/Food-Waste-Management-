<?php
session_start();
include '../connection.php'; 
$msg = '';

if (isset($_POST['sign'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Sanitize inputs
    $sanitized_email = mysqli_real_escape_string($connection, $email);
    $sanitized_password = mysqli_real_escape_string($connection, $password);

    // Fetch user
    $sql = "SELECT * FROM users WHERE email='$sanitized_email'";
    $result = mysqli_query($connection, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($sanitized_password, $row['password'])) {
            // ✅ Set required session variables used in delivery.php
            $_SESSION['email'] = $row['email'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['location'] = $row['location'];

            $_SESSION['name'] = $row['username']; // 👈 Needed by delivery.php
            $_SESSION['city'] = $row['location']; // 👈 Needed by delivery.php
            $_SESSION['Did'] = $row['id'];        // 👈 Needed by delivery.php — make sure `id` is your delivery ID column

            header("Location: delivery.php");
            exit();
        } else {
            $msg = "Incorrect password!";
        }
    } else {
        $msg = "Account does not exist!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gradient-to-br from-green-50 to-emerald-50 p-4">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
        <div class="text-center">
            <div class="mx-auto bg-green-100 w-12 h-12 rounded-full flex items-center justify-center mb-2">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 2l2.09 6.26L20 9l-5 3.91L16.18 20 12 17l-4.18 3L9 12.91 4 9l5.91-.74L12 2z"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-green-800">Delivery Login</h1>
            <p class="text-green-600">Join us in reducing food waste, one delivery at a time.</p>
        </div>

        <form method="post" class="mt-6 space-y-4">
            <div class="relative">
                <svg class="absolute left-3 top-3 h-5 w-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14v2m0 4h.01m-6-6a8 8 0 1112 0"></path>
                </svg>
                <input type="email" name="email" placeholder="Enter your email" required
                    class="w-full pl-10 p-2 border border-green-300 rounded-md focus:ring-green-500 focus:border-green-500">
            </div>

            <div class="relative">
                <svg class="absolute left-3 top-3 h-5 w-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 17v.01"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 9a4 4 0 018 0v3a4 4 0 01-8 0V9z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 13h4"></path>
                </svg>
                <input type="password" name="password" placeholder="Enter your password" required
                    class="w-full pl-10 p-2 border border-green-300 rounded-md focus:ring-green-500 focus:border-green-500">
            </div>

            <?php if ($msg): ?>
                <p class="text-red-600 text-sm text-center"><?= $msg ?></p>
            <?php endif; ?>

            <button type="submit" name="sign" class="w-full bg-green-600 hover:bg-green-700 text-white p-2 rounded-md">
                Login
            </button>

            <div class="text-center mt-4">
                <p class="text-sm text-green-600">
                    Not a member? <a href="deliverysignup.php" class="font-semibold hover:text-green-700">Sign up</a>
                </p>
                
            </div>
        </form>
    </div>
</body>
</html>
