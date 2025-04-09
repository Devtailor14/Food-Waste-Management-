<?php
session_start();
include '../connection.php';

$msg = 0;

if (isset($_POST['sign'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sanitized_emailid = mysqli_real_escape_string($connection, $email);
    $sanitized_password = mysqli_real_escape_string($connection, $password);

    $sql = "SELECT * FROM admin WHERE email='$sanitized_emailid'";
    $result = mysqli_query($connection, $sql);
    $num = mysqli_num_rows($result);

    if ($num == 1) {
        while ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($sanitized_password, $row['password'])) {
                $_SESSION['email'] = $email;
                $_SESSION['name'] = $row['name'];
                $_SESSION['location'] = $row['location'];
                $_SESSION['Aid'] = $row['Aid'];
                header("location:admin.php");
                exit();
            } else {
                $msg = 1;
            }
        }
    } else {
        $msg = 2;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen grid place-items-center bg-gradient-to-br from-emerald-400 to-green-500">
    <div class="w-full max-w-md mx-4 bg-white shadow-xl rounded-xl p-6">
        <div class="text-center mb-6">
            <h2 class="text-3xl font-bold">
                Login
                
            </h2>
        </div>

        <?php if ($msg == 1): ?>
            <p class="text-red-600 text-center">Incorrect Password.</p>
        <?php elseif ($msg == 2): ?>
            <p class="text-red-600 text-center">Account does not exist.</p>
        <?php endif; ?>

        <form action="" method="POST" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" placeholder="Enter your email"
                       class="w-full mt-1 p-2 border rounded-lg focus:ring-green-500 focus:border-green-500" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="password" placeholder="Enter your password"
                           class="w-full mt-1 p-2 border rounded-lg focus:ring-green-500 focus:border-green-500" required>
                    <button type="button" class="absolute right-3 top-3" onclick="togglePassword()">
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                             stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-gray-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zm-11.578 0A9 9 0 0112 6.75a9 9 0 019.828 5.25 9 9 0 01-19.656 0z"/>
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" name="sign" class="w-full bg-black text-white py-2 rounded-lg hover:bg-gray-800">
                Login
            </button>

            <p class="text-center text-sm text-gray-600">
                Don't have an account?
                <a href="signup.php" class="text-green-500 hover:text-green-600 font-medium">Register</a>
            </p>
        </form>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById("password");
            const eyeIcon = document.getElementById("eyeIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round"
                                     d="M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zm-11.578 0A9 9 0 0112 6.75a9 9 0 019.828 5.25 9 9 0 01-19.656 0z"/>`;
            } else {
                passwordInput.type = "password";
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round"
                                     d="M4.5 12s1.5-3 7.5-3 7.5 3 7.5 3m-7.5 3s-1.5 3-7.5 3-7.5-3-7.5-3m3.75-3a3.75 3.75 0 107.5 0 3.75 3.75 0 00-7.5 0z"/>`;
            }
        }
    </script>
</body>
</html>
