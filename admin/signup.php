<?php
include '../connection.php';
$msg = 0;

if (isset($_POST['sign'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $location = $_POST['city']; // User-entered city
    $address = $_POST['address'];

    $pass = password_hash($password, PASSWORD_DEFAULT);
    $sql = "SELECT * FROM admin WHERE email='$email'";
    $result = mysqli_query($connection, $sql);
    $num = mysqli_num_rows($result);

    if ($num == 1) {
        echo "<h1><center>Account already exists</center></h1>";
    } else {
        $query = "INSERT INTO admin(name,email,password,location,address) VALUES('$username','$email','$pass','$location','$address')";
        $query_run = mysqli_query($connection, $query);
        if ($query_run) {
            header("Location: signin.php");
        } else {
            echo '<script>alert("Data not saved")</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-b from-green-50 to-green-100 flex items-center justify-center">
    <div class="w-full max-w-lg bg-white shadow-md rounded-xl p-6">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-green-600">Create an Account</h2>
            <p class="text-gray-500">Enter your details below to register</p>
        </div>

        <form method="post" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="username" placeholder="Enter your full name"
                       class="w-full mt-1 p-2 border rounded-lg focus:ring-green-500 focus:border-green-500" required>
            </div>

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

            <div>
                <label class="block text-sm font-medium text-gray-700">Address</label>
                <textarea name="address" placeholder="Enter your address"
                          class="w-full mt-1 p-2 border rounded-lg focus:ring-green-500 focus:border-green-500"
                          required></textarea>
            </div>

            <!-- Changed City Field to a Text Input -->
            <div>
                <label class="block text-sm font-medium text-gray-700">City</label>
                <input type="text" name="city" placeholder="Enter your city"
                       class="w-full mt-1 p-2 border rounded-lg focus:ring-green-500 focus:border-green-500" required>
            </div>

            <button type="submit" name="sign" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">
                Register
            </button>

            <div class="text-center text-sm">
                Already a member?
                <a href="signin.php" class="text-green-600 hover:text-green-700 font-medium">Login Now</a>
            </div>
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
