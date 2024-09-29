<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maze Explorer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="icon" href="Mazelogo.png" type="image/png">
<link rel="shortcut icon" href="Mazelogo.ico" type="image/x-icon">
</head>
<body>

    <div class="side-container">
        <aside class="sidebar" id="sidebar">
            <div class="side-header">
                <img src="mazelogo.png" alt="" class="logo" >
                <!-- <h1 id="title">Maze</h1> -->
            </div>
            <nav class="side-nav">
                <hr>
                <ul class="side-lists">
                <li><a href="dashboard.php"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>
                    <li><a href="create/maze.php"><i class="fas fa-cogs"></i> <span>Create Maze</span></a></li>
                    <li><a href="play.php" id="play-maze-link"><i class="fas fa-play"></i><span> Play Maze</span></a></li>
                    <li><a href="leaderboard.php"><i class="fas fa-ranking-star"></i><span>Leaderboard</span></a></li>

                    <li><a href="controls.php"><i class="fas fa-gamepad"></i><span>Controls</span></a></li>
                        
                    <!-- <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i><span> Logout</span></a></li> -->
                </ul>
            </nav>
        </aside>
    </div>
</body>
</html>
