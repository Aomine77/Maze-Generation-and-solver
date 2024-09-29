<?php
include 'Authentication/session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Controls</title>
    <link rel="stylesheet" href="css/controls.css">
    <link rel="icon" href="Mazelogo.png" type="image/png">
<link rel="shortcut icon" href="Mazelogo.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="nav">
        <button class="dashboard" onclick="window.location.href='dashboard.php'">Dashboard</button>
        <h1 >Game Controls</h1>

    </div>
    <div class="controls-container">
        <div class="controls-grid">
            <!-- Arrow Keys -->
            <div class="arrow-keys">
                <div class="arrow-key" id="up"><i class="fas fa-arrow-up"></i></div>
                <div class="arrow-key" id="left"><i class="fas fa-arrow-left"></i></div>
                <div class="arrow-key" id="down"><i class="fas fa-arrow-down"></i></div>
                <div class="arrow-key" id="right"><i class="fas fa-arrow-right"></i></div>
                <!-- Labels -->
                <div class="label up">Up</div>
                <div class="label left">Left</div>
                <div class="label down">Down</div>
                <div class="label right">Right</div>
            </div>

        </div>
    </div>

</body>
</html>
