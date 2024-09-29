<?php
include 'Authentication/session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maze Game</title>
    <link rel="stylesheet" href="css/play.css">

    <link rel="icon" href="Mazelogo.png" type="image/png">
<link rel="shortcut icon" href="Mazelogo.ico" type="image/x-icon">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.4.0/p5.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>
    <div class="Levels">
        <button class="dashboard" onclick="window.location.href='dashboard.php'">Dashboard</button>
        <div class="center-container">
            <select id="difficulty-select" onchange="startGame(this.value)" style="font-size: 16px; padding: 10px;">
            <option value="veryeasy">Very Easy</option>
                <option value="easy">Easy</option>
                <option value="medium">Medium</option>
                <option value="hard">Hard</option>
                <option value="extreme">Extreme</option>
            </select>
            <button class="play" onclick="resetGame()">Play</button>
        </div>
        <div class="timer">
                <i class="fas fa-stopwatch"></i>
                <span id="timer-display">00:00:00</span>
            </div>
        <div>
            <button class="dashboard" onclick="showControls()">Controls</button>
        </div>
    </div>

    <div id="game-container">
        <!-- The game canvas will be placed here -->
    </div>

    <!-- Modal for Controls -->
    <div id="controls-modal" class="modal2">
        <div class="modal-content2">
        <span class="close" id="closeModal">&times;</span>
            <h2>Controls</h2>
            <hr>
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
    </div>

   <!-- Custom Popup Modal -->
<div id="endGameModal" class="modal">
    <div class="modal-content">
        <h2 style="color: black;">Congratulations!</h2>
        <p id="timeTakenMessage"></p> <!-- Placeholder for time taken -->
        <p>What would you like to do next?</p>
        <button id="playAgainButton" class="modal-button">Play Again</button>
        <!-- <button id="changeLevelButton" class="modal-button">Change Level</button> -->
    </div>
</div>


<!-- Popup for selecting difficulty level
<div id="difficultyPopup" style="display:none;">
    <div class="popup-content2">
        <h3>Select Difficulty Level</h3>
        <button class="levelButton2" data-level="veryeasy">Very Easy</button>
        <button class="levelButton2" data-level="easy">Easy</button>
        <button class="levelButton2" data-level="medium">Medium</button>
        <button class="levelButton2" data-level="hard">Hard</button>
        <button class="levelButton2" data-level="extreme">Extreme</button>
    </div>
</div> -->



    <script src="js/plays.js"></script>
    <script>
 function showControls() {
    document.getElementById('controls-modal').style.display = 'block';
}

function closeControls() {
    document.getElementById('controls-modal').style.display = 'none';
}

// Add event listeners to all difficulty level buttons
document.querySelectorAll('.levelButton').forEach(function(button) {
    button.addEventListener('click', function() {
        let selectedLevel = this.getAttribute('data-level');
        if (selectedLevel) {
            // Update the dropdown to display the new selected level
            let selectElement = document.getElementById('difficulty-select');
            selectElement.value = selectedLevel;

            document.getElementById('difficultyPopup').style.display = 'none';
            document.getElementById('endGameModal').style.display = 'none';
            startGame(selectedLevel.trim().toLowerCase());
        }
    });
});



    </script>
</body>
</html>
