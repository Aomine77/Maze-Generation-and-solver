let n_cols;
let n_rows;
let sq_width;
let maze_maker, solver;
let solve_maze = false;

function start_maze() {
    n_cols = parseInt(document.getElementById("cols-input").value);
    n_rows = parseInt(document.getElementById("rows-input").value);
    sq_width = Math.min(width / n_cols, height / n_rows); // Ensure squares fit within canvas
    maze_maker = new MazeMaker(n_cols, n_rows, sq_width);
    loop(); // Start the drawing loop
    reset_grid();
}

function start_solve() {
    if (maze_maker && maze_maker.n_unvisited <= 0 && !solve_maze) {
        solve_maze = true;
        solver = new AStar(maze_maker.grid, sq_width);
    }
}

function reset_grid() {
    // Reset solver and solving state
    solver = undefined;
    solve_maze = false;
    
    document.getElementById("solve-button").disabled = true;

    maze_maker = null; // Clear existing maze maker to reset state
    clear(); // Clear the canvas if needed

    start_maze(); // Start generating a new maze
}

function setup() {
    let canvas = createCanvas(600, 600); // Fixed size
    canvas.parent('sketch-holder'); // Set the parent to #sketch-holder
}

function draw() {
    background('#DCDCDC');
    console.log(`Canvas Size: ${width}x${height}`);
    console.log(`Cell Size: ${sq_width}`);
    

    
    if (maze_maker) {
        if (maze_maker.n_unvisited > 0) {
            maze_maker.get_next_move();
        } else {
            document.getElementById("solve-button").disabled = false;
        }
        
        maze_maker.show(); // Show the maze
    }

    if (solve_maze && solver) {
        solver.get_next_move(); // Solve the maze
    }
}
