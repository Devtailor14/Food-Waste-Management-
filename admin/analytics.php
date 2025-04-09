<?php
ob_start(); 
include("connect.php"); 
if($_SESSION['name']==''){
	header("location:signin.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <title>Admin Dashboard Panel</title> 
<?php
 $connection=mysqli_connect("localhost:3306","root","",
'demo');
?>
</head>
<body>
    <nav>
        <div class="logo-name">
            <span class="logo_name">ADMIN</span>
        </div>
        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="admin.php">
                    <i class="uil uil-estate"></i>
                    <span class="link-name">Dashboard</span>
                </a></li>
                <li><a href="#">
                    <i class="uil uil-chart"></i>
                    <span class="link-name">Analytics</span>
                </a></li>
                <li><a href="donate.php">
                    <i class="uil uil-heart"></i>
                    <span class="link-name">Donates</span>
                </a></li>
                <li><a href="feedback.php">
                    <i class="uil uil-comments"></i>
                    <span class="link-name">Feedbacks</span>
                </a></li>
                <li><a href="adminprofile.php">
                    <i class="uil uil-user"></i>
                    <span class="link-name">Profile</span>
                </a></li>
            </ul>
        </div>
    </nav>
    <section class="dashboard">
        <div class="dash-content">
            <div class="overview">
                <div class="title">
                    <i class="uil uil-chart"></i>
                    <span class="text">Analytics</span>
                </div>
                <div class="boxes">
                    <div class="box box1">
                        <i class="uil uil-user"></i>
                        <span class="text">Total users</span>
                        <?php
                           $query="SELECT count(*) as count FROM login";
                           $result=mysqli_query($connection, $query);
                           $row=mysqli_fetch_assoc($result);
                           echo "<span class=\"number\">".$row['count']."</span>";
                        ?>
                    </div>
                    <div class="box box2">
                        <i class="uil uil-comments"></i>
                        <span class="text">Feedbacks</span>
                        <?php
                           $query="SELECT count(*) as count FROM user_feedback";
                           $result=mysqli_query($connection, $query);
                           $row=mysqli_fetch_assoc($result);
                           echo "<span class=\"number\">".$row['count']."</span>";
                        ?>
                    </div>
                    <div class="box box3">
                        <i class="uil uil-heart"></i>
                        <span class="text">Total donates</span>
                        <?php
                           $query="SELECT count(*) as count FROM food_donations";
                           $result=mysqli_query($connection, $query);
                           $row=mysqli_fetch_assoc($result);
                           echo "<span class=\"number\">".$row['count']."</span>";
                        ?>
                    </div>
                </div>
                <br><br>
                <canvas id="donateChart" style="width:100%;max-width:600px"></canvas>
                <script>
                      <?php
                            $cities = ["delhi", "mumbai", "kolkata", "chennai", "bangalore", "hyderabad", "pune", "lucknow"];
                            $cityCounts = [];
                            foreach ($cities as $city) {
                                $query = "SELECT count(*) as count FROM food_donations WHERE location='$city'";
                                $result = mysqli_query($connection, $query);
                                $row = mysqli_fetch_assoc($result);
                                $cityCounts[] = $row['count'];
                            }
                      ?>
                var xplace = <?php echo json_encode($cities); ?>;
                var yplace = <?php echo json_encode($cityCounts); ?>;
                var bar = ["#06C167","blue","red","orange","purple","cyan","pink","brown"];
                new Chart("donateChart", {
                  type: "bar",
                  data: {
                    labels: xplace,
                    datasets: [{
                      backgroundColor: bar,
                      data: yplace
                    }]
                  },
                  options: {
                    legend: {display: false},
                    title: {
                      display: true,
                      text: "Food Donation Details"
                    }
                  }
                });
                </script>
            </div>
        </div>
    </section>
    <script src="admin.js"></script>
</body>
</html>
