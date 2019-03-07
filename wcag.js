class WCAG
{
    /**
     * Convert a hex colour string into an rgb array.
     *
     * Handles colour string in the following formats:
     *
     *     o #44FF55
     *     o 44FF55
     *     o #4F5
     *     o 4F5
     *
     * @param string hex
     * @return array<int>
     */
    hex2rgb(hex) {
        hex = hex.replace(/^#/, '');
        return hex.replace(/^([a-f\d])([a-f\d])([a-f\d])$/i, (m, r, g, b) => r + r + g + g + b + b)
            .match(/.{2}/g).map(x => parseInt(x, 16))
    }

    /**
     * Relative luminance of a colour.
     *
     * This calculates the relative luminance of a colour according to the
     * WCAG 2.0 specifications.
     *
     * Value returned is from 0 (no luminance/black) to 1 (full luminance/white).
     *
     * @param  string|array rgb
     * @return float
     * @see    https://www.w3.org/TR/WCAG20/#relativeluminancedef
     */
    luminance(rgb) {
        if (!Array.isArray(rgb)) {
            rgb = this.hex2rgb(rgb);
        }
        if (rgb.length != 3) {
            throw 'Colour value must be a hex string or an array of RGB values';
        }
        for (let c = 0; c < 3; c++) {
            if (rgb[c] < 0 || rgb[c] > 255) {
                throw 'RGB array values must range between 0 and 255, inclusive';
            }
            rgb[c] /= 255;
            rgb[c] = (rgb[c] <= 0.03928
                    ? rgb[c] / 12.92
                    : Math.pow(((rgb[c] + 0.055) / 1.055), 2.4)
            );
        }
        return ((0.2126 * rgb[0]) + (0.7152 * rgb[1]) + (0.0722 * rgb[2]));
    }


    /**
     * Calculate contrast ratio between two colours.
     *
     * @param string|array rgb1
     * @param string|array rgb2
     * @return float
     */
    contrastRatio(rgb1, rgb2) {
        if (!Array.isArray(rgb1)) {
            rgb1 = this.hex2rgb(rgb1);
        }
        if (!Array.isArray(rgb2)) {
            rgb2 = this.hex2rgb(rgb2);
        }
        if (rgb1.length != 3 || rgb2.length != 3) {
            throw 'Colour value must be a hex string or an array of RGB values';
        }
        for (let c = 0; c < 3; c++) {
            if ((rgb1[c] < 0 || rgb1[c] > 255) || (rgb2[c] < 0 || rgb2[c] > 255)) {
                throw 'RGB array values must range between 0 and 255, inclusive';
            }
        }

        let l1 = this.luminance(rgb1);
        let l2 = this.luminance(rgb2);
        return (l1 >= l2
                ? (l1 + .05) / (l2 + .05)
                : (l2 + .05) / (l1 + .05)
        );
    }

    /**
     * Get WCAG compliance information for the colours.
     *
     * Currently this will return the contrast ratio and the WCAG 2.0 pass/fail
     * states.
     *
     * @param  string|array fg
     * @param  string|array bg
     * @return {*}
     */
    compatibility(fg, bg) {
        let ratio = this.contrastRatio(fg, bg);
        return {
            ratio,
            "2.0": {
                "aa": (ratio >= 4.5),
                "aa-18pt": (ratio >= 3),
                "aaa": (ratio >= 7),
                "aaa-18pt": (ratio >= 4.5)
            }
        };
    }
}

const wcag = new WCAG();
module.exports = {
    wcag
};

