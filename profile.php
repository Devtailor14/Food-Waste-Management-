<?php
include("login.php"); 

if($_SESSION['name']==''){
    header("location: signup.php");
}
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Donate - Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }

        /* Header Styles (Matching home.html) */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
            padding: 15px 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-sizing: border-box;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .hamburger {
            display: none;
            cursor: pointer;
        }

        .hamburger .line {
            width: 25px;
            height: 3px;
            background: #333;
            margin: 5px;
        }

        .nav-bar ul {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nav-bar ul li {
            margin: 0 15px;
        }

        .nav-bar ul li a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .nav-bar ul li a:hover, .nav-bar ul li a.active {
            color: #06C167;
        }

        /* Profile Container */
        .profile-container {
            max-width: 900px;
            margin: 100px auto 40px;
            padding: 0 20px;
        }

        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-header h1 {
            color: #333;
            font-size: 32px;
            margin-bottom: 10px;
        }

        .heading {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
            border-bottom: 3px solid #06C167;
            padding-bottom: 8px;
            display: inline-block;
        }

        /* Profile Card */
        .profile-card, .donations-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 25px;
            margin-bottom: 30px;
        }

        .profile-info {
            padding: 10px 0;
        }

        .info-item {
            display: flex;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .info-label {
            font-weight: bold;
            width: 120px;
            color: #555;
        }

        .info-value {
            color: #333;
        }

        .logout-btn {
            display: inline-block;
            background: linear-gradient(45deg, #06C167, #28a745);
            color: white;
            padding: 10px 20px;
            border-radius: 50px;
            text-decoration: none;
            margin-top: 15px;
            transition: all 0.3s ease;
            font-weight: bold;
        }

        .logout-btn:hover {
            background: linear-gradient(45deg, #28a745, #06C167);
            transform: scale(1.05);
            box-shadow: 0 0 10px rgba(6, 193, 103, 0.5);
        }

        /* Donations Table */
        .table-container {
            margin: 20px 0;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .table-wrapper {
            max-height: 300px;
            overflow-y: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            position: sticky;
            top: 0;
            background-color: #06C167;
            color: white;
            padding: 12px 15px;
            text-align: left;
        }

        .table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }

        .table tbody tr:hover {
            background-color: #f5f5f5;
        }

        /* Donate More Section */
        .donate-more {
            text-align: center;
            margin-top: 30px;
        }

        .donate-more p {
            font-size: 18px;
            margin-bottom: 15px;
        }

        .donate-more-btn {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(45deg, #06C167, #28a745);
            color: white;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 0 10px rgba(6, 193, 103, 0.4);
        }

        .donate-more-btn i {
            margin-right: 8px;
        }

        .donate-more-btn:hover {
            background: linear-gradient(45deg, #28a745, #06C167);
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(6, 193, 103, 0.7);
        }

        /* Footer Styles (Matching home.html) */
        .footer {
            background: #333;
            color: white;
            padding: 30px 20px;
            text-align: center;
        }

        .sociallist {
            margin-top: 10px;
        }

        .sociallist a {
            color: white;
            margin: 0 10px;
            font-size: 20px;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .sociallist a:hover {
            color: #06C167;
        }

        .footer a {
            color: #06C167;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .profile-container {
                margin-top: 80px;
            }
            
            .nav-bar ul {
                display: none;
                flex-direction: column;
                background: white;
                position: absolute;
                top: 60px;
                left: 0;
                width: 100%;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }
            
            .nav-bar.active ul {
                display: flex;
            }
            
            .nav-bar ul li {
                margin: 10px 0;
                text-align: center;
            }
            
            .hamburger {
                display: block;
            }
            
            .info-item {
                flex-direction: column;
            }
            
            .info-label {
                width: 100%;
                margin-bottom: 5px;
            }
            
            .profile-header h1 {
                font-size: 24px;
            }
            
            .heading {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">Food <b style="color: #06C167;">Donate</b></div>
        <div class="hamburger" onclick="toggleMenu()">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>
        <nav class="nav-bar">
            <ul>
                <li><a href="home.html">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li><a href="profile.php" class="active">Profile</a></li>
            </ul>
        </nav>
    </header>
    <script>
        function toggleMenu() {
            document.querySelector(".nav-bar").classList.toggle("active");
        }
    </script>
  
    <div class="profile-container">
        <div class="profile-header">
            <h1>Welcome, <?php echo $_SESSION['name']; ?>!</h1>
        </div>
        
        <div class="profile-card">
            <div class="profile-info">
                <h2 class="heading">Personal Information</h2>
                <div class="info-item">
                    <span class="info-label"><i class="fa fa-user"></i> Name:</span>
                    <span class="info-value"><?php echo $_SESSION['name']; ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label"><i class="fa fa-envelope"></i> Email:</span>
                    <span class="info-value"><?php echo $_SESSION['email']; ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label"><i class="fa fa-venus-mars"></i> Gender:</span>
                    <span class="info-value"><?php echo $_SESSION['gender']; ?></span>
                </div>
                
                <a href="logout.php" class="logout-btn">
                    <i class="fa fa-sign-out"></i> Logout
                </a>
            </div>
        </div>
        
        <div class="donations-card">
            <h2 class="heading">Your Donations</h2>
            <div class="table-container">
                <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Food</th>
                                <th>Type</th>
                                <th>Category</th>
                                <th>Date/Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $email = $_SESSION['email'];
                            $query = "select * from food_donations where email='$email'";
                            $result = mysqli_query($connection, $query);
                            if($result == true){
                                while($row = mysqli_fetch_assoc($result)){
                                    echo "<tr><td>".$row['food']."</td><td>".$row['type']."</td><td>".$row['category']."</td><td>".$row['date']."</td></tr>";
                                }
                            }
                            ?> 
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="donate-more">
                <p>Want to make another donation?</p>
                <a href="fooddonateform.php" class="donate-more-btn">
                    <i class="fa fa-cutlery"></i> Donate Food
                </a>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 Food Donate | Designed with ❤️</p>
        <div class="sociallist">
            <a href="https://www.facebook.com/TheAkshayaPatraFoundation/"><i class="fa fa-facebook"></i></a>
            <a href="https://twitter.com/globalgiving"><i class="fa fa-twitter"></i></a>
            <a href="https://www.instagram.com/charitism/"><i class="fa fa-instagram"></i></a>
            <a href="https://web.whatsapp.com/"><i class="fa fa-whatsapp"></i></a>
        </div>
        <p>Contact: (+91) 9702251090 | Email: <a href="mailto:Fooddonate@gmail.com" style="color: #06C167;">Fooddonate@gmail.com</a></p>
    </footer>
</body>
</html>