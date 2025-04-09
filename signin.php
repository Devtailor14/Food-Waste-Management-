<?php
session_start();
include 'connection.php';
$msg = 0;
if (isset($_POST['sign'])) {
  $email = mysqli_real_escape_string($connection, $_POST['email']);
  $password = mysqli_real_escape_string($connection, $_POST['password']);

  $sql = "SELECT * FROM login WHERE email='$email'";
  $result = mysqli_query($connection, $sql);
  $num = mysqli_num_rows($result);

  if ($num == 1) {
    while ($row = mysqli_fetch_assoc($result)) {
      if (password_verify($password, $row['password'])) {
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $row['name'];
        $_SESSION['gender'] = $row['gender'];
        header("location:home.html");
      } else {
        $msg = 1;
      }
    }
  } else {
    echo "<h1><center>Account does not exist</center></h1>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Food Donate</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-96">
        <h2 class="text-2xl font-bold text-center text-green-600">Food Donate</h2>
        <p class="text-gray-600 text-center mb-4">Welcome back!</p>
        <form action="" method="post">
            <div class="mb-4">
                <label class="block text-gray-700">Email Address</label>
                <input type="email" name="email" class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400" required>
            </div>
            <div class="mb-4 relative">
                <label class="block text-gray-700">Password</label>
                <input type="password" name="password" id="password" class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400" required>
                <i class="absolute right-3 top-10 cursor-pointer text-gray-600" id="togglePassword">👁️</i>
                <?php if($msg == 1) echo '<p class="text-red-500 text-sm mt-2">Password does not match.</p>'; ?>
            </div>
            <button type="submit" name="sign" class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-600">Sign in</button>
            <p class="text-center text-gray-600 mt-4">Don't have an account? <a href="signup.php" class="text-green-500">Register</a></p>
        </form>
    </div>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            let passwordField = document.getElementById('password');
            passwordField.type = passwordField.type === 'password' ? 'text' : 'password';
        });
    </script>
</body>
</html>
