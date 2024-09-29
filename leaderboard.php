<?php
include 'authentication/config.php';
include 'authentication/session.php';

$games_count = isset($_POST['games_count']) ? (int)$_POST['games_count'] : 10;

// Query to get user scores along with usernames
$query = "SELECT us.user_id, u.username, us.level, us.time_taken 
          FROM user_scores us
          JOIN maze_user u ON us.user_id = u.user_id
          ORDER BY us.level, us.time_taken ASC 
          LIMIT ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $games_count);
$stmt->execute();
$result = $stmt->get_result();

$leaderboard = [];

// Group results by level
while ($row = $result->fetch_assoc()) {
    $level = $row['level'];
    $leaderboard[$level][] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <link rel="stylesheet" href="css/leaderboard.css">
    <link rel="icon" href="Mazelogo.png" type="image/png">
<link rel="shortcut icon" href="Mazelogo.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    

</head>

<body>
    <div class="container">
    <aside id="sidebar">
            <?php include 'sidebar.php'; ?>
        </aside>

        <div class="main-content">
        <header>
                <!-- This is the icon that toggles the sidebar -->
                <i class="fa fa-bars fa-2xl" id="toggle-sidebar"></i>

                <h1>Leaderboard</h1>
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

            <div class="leaderboard">
    <?php 
    foreach ($leaderboard as $level => $users): 
    ?>
        <div class="card">
            <h2>Level: <?php echo htmlspecialchars($level); ?></h2>
            <hr><br>
            <table>
                <thead>
                    <tr>
                        <th>Rank</th> 
                        <th>Username</th>
                        <th>Time Taken</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $userCounter = 1; // Initialize user counter for each level
                    foreach ($users as $index => $user): 
                        if ($index >= 5) break; // Limit to top 5 users per level
                    ?>
                        <tr>
                            <td><?php echo $userCounter++; ?></td> <!-- Display the counter -->
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['time_taken']); ?> seconds</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; ?>
</div>



        </div>

    </div>

</body>
    <script src="js/dashboard.js"></script>
   

</html>

<?php
$stmt->close();
$conn->close();
?>
