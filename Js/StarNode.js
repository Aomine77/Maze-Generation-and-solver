class StarNode {
    constructor(x, y) {
        this.x = x;
        this.y = y;

        this.f = 0;
        this.g = 0;
        this.h = 0;

        this.neighbors = [];
        
        this.previous = undefined;
    }
    set_g(new_g) {
        this.g = new_g;
        this.reset_f();
    }
    set_h(new_h) {
        this.h = new_h;
        this.reset_f();
    }
    reset_f() {
        this.f = this.g + this.h;
    }
}