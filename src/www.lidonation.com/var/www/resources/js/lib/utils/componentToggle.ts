export function componentToggle() {
    return {
        showing: false,
        show() {
            this.showing = true;
        },
        hide() {
            return this.showing = false;
        },
        toggle() {
            return this.showing = !this.showing;
        }
    }
}
