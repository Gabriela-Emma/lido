export function contrastColor(hex) {

    // If a leading # is provided, remove it
    if (hex.slice(0, 1) === '#') {
        hex = hex.slice(1);
    }

    // If a three-character hexcode, make six-character
    if (hex.length === 3) {
        hex = hex.split('').map(function (hex) {
            return hex + hex;
        }).join('');
    }

    // Convert to RGB value
    let r = parseInt(hex.substr(0, 2), 16);
    let g = parseInt(hex.substr(2, 2), 16);
    let b = parseInt(hex.substr(4, 2), 16);

    // Get YIQ ratio
    let yiq = ((r * 299) + (g * 587) + (b * 114)) / 1000;

    // Check contrast
    return (yiq >= 128) ? 'dark' : 'light';
}
