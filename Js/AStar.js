class AStar {
    constructor(maze, sq_width) {
        this.maze = maze;
        this.rows = maze.length;
        this.cols = maze[0].length;
        this.sq_width = sq_width;
        this.grid = [];
        // Create the grid of A* points
        for (let i = 0; i < this.rows; i++) {
            this.grid.push([]);
            for (let j = 0; j < this.cols; j++) {
                this.grid[i].push(new StarNode(j,i));
            }
        }
        // Add the neighbors to each point
        for (let i = 0; i < this.rows; i++) {
            for (let j = 0; j < this.cols; j++) {
                // north
                if (i > 0 && maze[i][j].n == false) {
                    this.grid[i][j].neighbors.push(this.grid[i-1][j]);
                }
                // east
                if (j < this.cols-1 && maze[i][j].e == false) {
                    this.grid[i][j].neighbors.push(this.grid[i][j+1]);
                }
                // south
                if (i < this.rows-1 && maze[i][j].s == false) {
                    this.grid[i][j].neighbors.push(this.grid[i+1][j]);
                }
                // west
                if (j > 0 && maze[i][j].w == false) {
                    this.grid[i][j].neighbors.push(this.grid[i][j-1]);
                }
            }
        }
        // Keep track of start / end / sets
        this.open_set = [];
        this.closed_set = [];
        this.start = this.grid[0][0];
        this.end = this.grid[this.rows-1][this.cols-1];
        this.open_set.push(this.start);
    }
    heuristic(sq) {
        return dist(sq.x, sq.y, this.cols, this.rows);
    }


    get_next_move() {
        let current;
        if (this.open_set.length > 0) {
            let winner = 0;
            for (let i = 1; i < this.open_set.length; i++) {
                if (this.open_set[i].f < this.open_set[winner].f) {
                    winner = i;
                }
            }
            // Pop the winner off the open set
            current = this.open_set.splice(winner,1)[0];
            this.closed_set.push(current);
            // console.log(this.open_set);

            // Did you reach the end?
            if (current == this.end) {
                noLoop();
                console.log("Done!");
            }

            // Check all the current node's neighbors
            for (let n of current.neighbors) {
                if (!this.closed_set.includes(n)) {
                    let temp_g = current.g + 1;
                    let new_path = false;
                    if (this.open_set.includes(n)) {
                        if (temp_g < n.g) {
                            n.g = temp_g;
                            new_path = true;
                        }
                    } else {
                        n.g = temp_g;
                        new_path = true;
                        this.open_set.push(n);
                    }

                    if (new_path) {
                        n.h = this.heuristic(n);
                        n.f = n.g + n.h;
                        n.previous = current;
                    }
                }
            }

        } else {
            console.log("No solution...");
            noLoop();
            return;
        }
        
        this.draw_path(current);
    }
    draw_path(c) {
        // Create the path
        let path = [];
        let tmp = c;
        path.push(tmp);
        while (tmp.previous) {
            path.push(tmp.previous);
            tmp = tmp.previous;
        }
        // Display the path
        let w = this.sq_width;
        noFill();
        stroke(255, 0, 200);
        strokeWeight(5);
        strokeCap(ROUND);
        beginShape();
        for (let n of path) {
            vertex(
                n.x * w + w / 2, 
                n.y * w + w / 2
            );
        }
        endShape();
    }
}
