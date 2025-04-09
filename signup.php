<?php
include 'connection.php';

if(isset($_POST['sign'])) {
    $username = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];
    
    $pass = password_hash($password, PASSWORD_DEFAULT);
    $sql = "SELECT * FROM login WHERE email='$email'";
    $result = mysqli_query($connection, $sql);
    $num = mysqli_num_rows($result);
    
    if($num == 1) {
        echo "<h1><center>Account already exists</center></h1>";
    } else {
        $query = "INSERT INTO login(name, email, password, gender) VALUES('$username', '$email', '$pass', '$gender')";
        $query_run = mysqli_query($connection, $query);
        if($query_run) {
            header("location:signin.php");
        } else {
            echo '<script type="text/javascript">alert("Data not saved")</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css"> 
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 bg-success">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4 shadow-lg">
                    <div class="text-center">
                        <h1 class="fw-bold">Food <span class="text-success">Donate</span></h1>
                        <h2 class="mb-4">Create your account</h2>
                    </div>
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="name" class="form-label">Username</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                            <i class="fas fa-eye position-absolute top-50 end-0 translate-middle-y pe-3" id="togglePassword"></i>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gender</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="male" value="male" required>
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                                    <label class="form-check-label" for="female">Female</label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="sign" class="btn btn-dark w-100">Continue</button>
                    </form>
                    <p class="mt-3 text-center">Already have an account? <a href="signin.php" class="text-primary">Sign in</a></p>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("togglePassword").addEventListener("click", function() {
            const passwordInput = document.getElementById("password");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                this.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                passwordInput.type = "password";
                this.classList.replace("fa-eye-slash", "fa-eye");
            }
        });
    </script>
</body>
</html>
