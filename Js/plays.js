// -------------------------------------
// Global Variables
// -------------------------------------
let cols, rows;
let w = 20; // Width of each cell
let grid = [];
let stack = [];
let current;
let player;
let playerSize = 15;
let mazeEnd;
let difficulty = 'veryeasy';
let canvas;
let gameStarted = false;

let timerInterval;
let elapsedTime = 0;
let totalSeconds = 0;

// -------------------------------------
// Setup and Game Initialization
// -------------------------------------
function setup() {
    canvas = createCanvas(600, 600);
    canvas.parent('game-container'); // Attach canvas to the game container
    noLoop(); // Stop draw loop until maze is generated
}

function startGame(level) {
    difficulty = level;
    setupGame();
}

function resetGame() {
    resetTimer();  // Reset the timer when the game is reset
    startTimer();  // Start the timer when the Play button is pressed
    setupGame();
}

function setupGame() {
    // Clear existing grid and stack
    grid = [];
    stack = [];
    // Set grid and player size based on difficulty
    if (difficulty === 'veryeasy') {
        w = 60;
        playerSize = 30;
    } else if (difficulty === 'easy') {
        w = 40;
        playerSize = 20;
    } else if (difficulty === 'medium') {
        w = 20;
        playerSize = 10;
    } else if (difficulty === 'hard') {
        w = 15;
        playerSize = 7;
    } else if (difficulty === 'extreme') {
        w = 10;
        playerSize = 5;
    }

    cols = floor(width / w);
    rows = floor(height / w);
    
    // Create a grid of cells
    for (let y = 0; y < rows; y++) {
        for (let x = 0; x < cols; x++) {
            let cell = new Cell(x, y);
            grid.push(cell);
        }
    }
    
    // Initialize current and end cells
    current = grid[0];
    mazeEnd = grid[grid.length - 1];
    player = { x: 0, y: 0 };
    // Generate the maze
    generateMaze();
    gameStarted = true; // Set game started to true
    loop();
}

// -------------------------------------
// Game Loop (Rendering)
// -------------------------------------
function draw() {
    background(220);
    // Show the maze
    for (let cell of grid) {
        cell.show();
    }
    // Draw the player
    fill(255, 0, 0);
    noStroke();
    rect(player.x * w + w / 4, player.y * w + w / 4, playerSize, playerSize);
    // Draw the end point
    fill(0, 255, 0);
    rect(mazeEnd.x * w + w / 4, mazeEnd.y * w + w / 4, playerSize, playerSize);
}

// -------------------------------------
// Maze Generation
// -------------------------------------
function generateMaze() {
    current.visited = true;
    let next = current.checkNeighbors();
    
    if (next) {
        next.visited = true;
        stack.push(current);
        removeWalls(current, next);
        current = next;
        generateMaze(); // Recursively generate the maze
    } else if (stack.length > 0) {
        current = stack.pop(); // Backtrack
        generateMaze(); // Continue maze generation
    } else {
        loop(); // Resume the draw loop when maze generation is complete
    }
}

// -------------------------------------
// Player Movement and Key Handling
// -------------------------------------
function keyPressed() {
    // Prevent default behavior for arrow keys
    if ([LEFT_ARROW, RIGHT_ARROW, UP_ARROW, DOWN_ARROW].includes(keyCode)) {
        event.preventDefault();
    }

    // Player movement logic
    if (keyCode === LEFT_ARROW && player.x > 0) {
        if (!grid[player.y * cols + (player.x - 1)].walls[1]) {
            player.x--;
        }
    } else if (keyCode === RIGHT_ARROW && player.x < cols - 1) {
        if (!grid[player.y * cols + (player.x + 1)].walls[3]) {
            player.x++;
        }
    } else if (keyCode === UP_ARROW && player.y > 0) {
        if (!grid[(player.y - 1) * cols + player.x].walls[2]) {
            player.y--;
        }
    } else if (keyCode === DOWN_ARROW && player.y < rows - 1) {
        if (!grid[(player.y + 1) * cols + player.x].walls[0]) {
            player.y++;
        }
    }
    
    // Check if player reached the end
    if (player.x === mazeEnd.i && player.y === mazeEnd.j) {
        noLoop();  // Stop the draw loop
        stopTimer();  // Stop the timer
        
        const timeTaken = document.getElementById('timer-display').textContent;
        
        document.getElementById('timeTakenMessage').textContent = `Time Taken: ${timeTaken}`;
        
        saveScore(difficulty, timeTaken);
        
        document.getElementById('endGameModal').style.display = 'flex';
        
        document.getElementById('playAgainButton').onclick = function() {
            document.getElementById('endGameModal').style.display = 'none';
            resetGame();
        };
    }
    
}

// -------------------------------------
// Wall Removal
// -------------------------------------
function removeWalls(a, b) {
    let x = a.i - b.i;
    if (x === 1) {
        a.walls[3] = false;
        b.walls[1] = false;
    } else if (x === -1) {
        a.walls[1] = false;
        b.walls[3] = false;
    }
    let y = a.j - b.j;
    if (y === 1) {
        a.walls[0] = false;
        b.walls[2] = false;
    } else if (y === -1) {
        a.walls[2] = false;
        b.walls[0] = false;
    }
}

// -------------------------------------
// Cell Class Definition
// -------------------------------------
class Cell {
    constructor(i, j) {
        this.i = i;
        this.j = j;
        this.walls = [true, true, true, true]; // Top, Right, Bottom, Left
        this.visited = false;
        this.x = i * w;
        this.y = j * w;
    }

    show() {
        stroke(0);
        
        // Draw the end cell in green
        if (this === mazeEnd) {
            fill(0, 255, 0);
            noStroke();
            rect(this.x + w / 4, this.y + w / 4, playerSize, playerSize);
        } else {
            noFill();
        }

        // Draw walls of the cell
        if (this.walls[0]) line(this.x, this.y, this.x + w, this.y);         // Top
        if (this.walls[1]) line(this.x + w, this.y, this.x + w, this.y + w); // Right
        if (this.walls[2]) line(this.x + w, this.y + w, this.x, this.y + w); // Bottom
        if (this.walls[3]) line(this.x, this.y + w, this.x, this.y);         // Left
    }

    checkNeighbors() {
        let neighbors = [];
        let top = grid[index(this.i, this.j - 1)];
        let right = grid[index(this.i + 1, this.j)];
        let bottom = grid[index(this.i, this.j + 1)];
        let left = grid[index(this.i - 1, this.j)];

        // Check unvisited neighbors
        if (top && !top.visited) neighbors.push(top);
        if (right && !right.visited) neighbors.push(right);
        if (bottom && !bottom.visited) neighbors.push(bottom);
        if (left && !left.visited) neighbors.push(left);

        if (neighbors.length > 0) {
            let r = floor(random(neighbors.length));
            return neighbors[r];
        }
        return undefined;
    }
}

// -------------------------------------
// Helper Functions
// -------------------------------------
function index(i, j) {
    if (i < 0 || j < 0 || i > cols - 1 || j > rows - 1) {
        return -1;
    }
    return i + j * cols;
}

// -------------------------------------
// Timer Functions
// -------------------------------------
function startTimer() {
    const startTime = Date.now() - elapsedTime;

    timerInterval = setInterval(() => {
        elapsedTime = Date.now() - startTime;
        
        const minutes = Math.floor(elapsedTime / 60000);
        const seconds = Math.floor((elapsedTime % 60000) / 1000);
        const milliseconds = Math.floor((elapsedTime % 1000) / 10); // Two digits for milliseconds

        document.getElementById('timer-display').textContent = 
            `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}:${String(milliseconds).padStart(2, '0')}`;
    }, 10); // Update every 10 milliseconds
}

function resetTimer() {
    clearInterval(timerInterval);
    elapsedTime = 0;
    document.getElementById('timer-display').textContent = "00:00:00"; // Reset to 00:00:00 (mm:ss:ms)
}

function stopTimer() {
    clearInterval(timerInterval);
}

// -------------------------------------
// Score Saving
// -------------------------------------
function saveScore(level, time) {
    fetch('save_score.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            level: level,
            time_taken: time,
            created_at: new Date().toISOString()  // Send current timestamp
        })
    })
    .then(response => response.json())
    .then(data => { 
        if (data.success) {
            console.log('Score saved successfully');
        } else {
            console.error('Error saving score:', data.error);
        }
    })
    .catch(error => console.error('Error:', error));
}
document.getElementById('closeModal').addEventListener('click', function() {
    document.getElementById('controls-modal').style.display = 'none';
});
