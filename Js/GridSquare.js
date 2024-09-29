class GridSquare {
    constructor(x,y,width) {
        this.x = x;
        this.y = y;
        this.width = width;

        this.visited = false;
        this.n = true;
        this.s = true;
        this.e = true;
        this.w = true;
    }
    show() {

        
        push();
        translate(
            this.x * this.width,
            this.y * this.width
        );
        noStroke();
        if (this.visited) fill('#DCDCDC');
        else fill('#DCDCDC');
        rect(0,0,this.width,this.width);
        noFill();
        stroke(1);
        strokeWeight(2);
        strokeCap(SQUARE);
        if (this.n) line(
            0,         0,
            this.width,0
        );
        if (this.e) line(
            this.width,0,
            this.width,this.width
        );
        pop();
    }
}

