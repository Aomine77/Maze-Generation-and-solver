<?php 
include 'Authentication/session.php';
include 'Authentication/config.php';


$user_id = $_SESSION['user_id'];
$query = "SELECT COUNT(*) AS total_games FROM user_scores WHERE user_id = ?";

$stmt = $conn->prepare($query);

$stmt->bind_param('i', $user_id);

$stmt->execute();

$stmt->bind_result($total_games);

$stmt->fetch();




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maze Game Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="icon" href="Mazelogo.png" type="image/png">
<link rel="shortcut icon" href="Mazelogo.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        #total-played{
            font-size: 1.6rem;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <aside class="navbar">
            <?php
            include "sidebar.php";
            ?>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <header>
            <i class="fa fa-bars fa-2xl " id="toggle-sidebar"></i>
                <h1>Dashboard</h1>
                <div class="user-profile">
                    <i class="fa-regular fa-circle-user fa-2xl" id="user-icon"></i>

                    <div class="popup-menu" id="popup-menu">
                        <ul>
                            <li><a href="view_profile.php"><i class="fa fa-user"></i>
                            View Profile</a></li>
                            <li><a href="view_profile.php"><i class="fa fa-key"></i>
                            Change Password</a></li>
                            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i><span> Logout</span></a></li>
                        </ul>
                    </div>
                </div>
            </header>
            <div class="cards-container">
                <a href="play.php" class="card-link">
                    <div class="card play">
                        <h3>Play Game</h3>
                        <i class="fa-regular fa-circle-play  create-icon"></i>
                    </div>
                </a>
                <a href="create/maze.php" class="card-link">
                    <div class="card create">
                        <h3>Create Maze</h3>
                        <i class="fa-regular fa-plus  create-icon"></i>
                    </div>
                </a>
                <div class="card total-played">
                    <h3>Total Games Played : <?php echo $total_games ?></h3>
                    <i class="fa-solid fa-gamepad create-icon"></i>
                </div>
                
                <a href="history.php" class="card-link">
                <div class="card history">
                    <h3>History</h3>
                    <i class="fa-solid fa-clock-rotate-left  create-icon"></i>
                </div>
                </a>
                 
                <a href="leaderboard.php" class="card-link">
                <div class="card history">
                    <h3>Leaderboard</h3>
                    <i class="fa-solid fa-ranking-star create-icon"></i>
                </div>
                </a>
            </div>
            
        </div>
    </div>

    <script src="js/dashboard.js"></script>
    
</body>

</html>