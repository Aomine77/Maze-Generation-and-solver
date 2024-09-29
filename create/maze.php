<?php
include '../Authentication/session.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf8" />
    
    <link rel="stylesheet" href="maze.css">
    <link rel="icon" href="../Mazelogo.png" type="image/png">
<link rel="shortcut icon" href="Mazelogo.ico" type="image/x-icon">
</head>

<body>
    <header class="header">
        <button class="back" onclick="window.location.href='../dashboard.php'">Dashboard</button>
        <h1>Create Maze</h1>
    </header>
    <hr>
    <div class="nav">
            <label for="cols-input">Columns:</label>
            <input id="cols-input" type="number" value="10" min="5" max="50" />
            <label for="rows-input">Rows:</label>
            <input id="rows-input" type="number" value="10" min="5" max="50" />

            <button class="button" id="start-button" type="button" onclick="start_maze();">Generate</button>
            <button class="button" id="solve-button" type="button" onclick="start_solve();" disabled>Solve</button>
            <button class="button" id="reset-button" type="button" onclick="reset_grid();">Reset</button>
            <button class="button" id="download-button" type="button" onclick="downloadMaze();">Download</button>
    </div>
    <div id="sketch-holder" class="sketch-holder"></div>
    <script>
        function downloadMaze() {
            const canvas = document.querySelector('canvas');
            const dataURL = canvas.toDataURL('image/png');

            // Create a temporary link element
            const link = document.createElement('a');
            link.href = dataURL;
            link.download = 'maze.png'; // Set the name for the downloaded image
            link.click(); // Simulate a click to trigger the download
        }

        // Get the column and row input elements
const colsInput = document.getElementById('cols-input');
const rowsInput = document.getElementById('rows-input');

// Function to validate the input value
function validateInput(inputElement) {
    const value = inputElement.value;
    if (value < 5 || value > 50) {
        alert('Please enter a value between 5 and 50');
        inputElement.value = 5; // Reset the input value to the minimum allowed
    }
}

// Add event listeners to both input fields for validation on input change
colsInput.addEventListener('change', function() {
    validateInput(colsInput);
});

rowsInput.addEventListener('change', function() {
    validateInput(rowsInput);
});

    </script>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.9.0/p5.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.9.0/addons/p5.dom.js"></script>
    <script src="../js/GridSquare.js"></script>
    <script src="../js/MazeMaker.js"></script>
    <script src="../js/StarNode.js"></script>
    <script src="../js/AStar.js"></script>
    <script src="../js/sketch.js"></script>

</html>