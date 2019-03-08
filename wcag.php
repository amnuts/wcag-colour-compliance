<?php

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
     * @param  string $hex
     * @return array
     * @throws \InvalidArgumentException
     */
    public static function hex2rgb($hex)
    {
        $hex = preg_replace('/^#/', '', $hex);
        if (!preg_match('/^([0-9A-F]{3}|[0-9A-F]{6})$/i', $hex)) {
            throw new \InvalidArgumentException("The hex value '{$hex}' does not appear to be valid. Only 0-9, A-F allowed and must be consist of either 3 or 6 characters");
        }
        if (strlen($hex) == 3) {
            $v = explode(':', chunk_split($hex, 1, ':'));
            return array(16 * hexdec($v[0]) + hexdec($v[0]), 16 * hexdec($v[1]) + hexdec($v[1]), 16 * hexdec($v[2]) + hexdec($v[2]));
        }
        $v = explode(':', chunk_split($hex, 2, ':'));
        return array(hexdec($v[0]), hexdec($v[1]), hexdec($v[2]));
    }

    /**
     * Relative luminance of a colour.
     *
     * This calculates the relative luminance of a colour according to the
     * WCAG 2.0 specifications.
     *
     * Value returned is from 0 (no luminance/black) to 1 (full luminance/white).
     *
     * @param  string|array $rgb
     * @return float
     * @throws \InvalidArgumentException
     * @see    https://www.w3.org/TR/WCAG20/#relativeluminancedef
     */
    public static function luminance($rgb)
    {
        if (!is_array($rgb)) {
            $rgb = self::hex2rgb($rgb);
        }
        if (count($rgb) != 3) {
            throw new \InvalidArgumentException('Colour value must be a hex string or an array of RGB values');
        }
        for ($c = 0; $c < 3; $c++) {
            if ($rgb[$c] < 0 || $rgb[$c] > 255) {
                throw new \InvalidArgumentException('RGB array values must range between 0 and 255, inclusive');
            }
            $rgb[$c] /= 255;
            $rgb[$c] = ($rgb[$c] <= 0.03928
                ? $rgb[$c] / 12.92
                : pow((($rgb[$c] + 0.055) / 1.055), 2.4)
            );
        }
        return (float)sprintf('%.05f', (0.2126 * $rgb[0]) + (0.7152 * $rgb[1]) + (0.0722 * $rgb[2]));
    }

    /**
     * Calculate contrast ratio between two colours.
     *
     * @param string|array $rgb1
     * @param string|array $rgb2
     * @return float
     * @throws \InvalidArgumentException
     */
    public static function contrastRatio($rgb1, $rgb2)
    {
        if (!is_array($rgb1)) {
            $rgb1 = self::hex2rgb($rgb1);
        }
        if (!is_array($rgb2)) {
            $rgb2 = self::hex2rgb($rgb2);
        }
        if (count($rgb1) != 3 || count($rgb2) != 3) {
            throw new \InvalidArgumentException('Colour value must be a hex string or an array of RGB values');
        }
        for ($c = 0; $c < 3; $c++) {
            if (($rgb1[$c] < 0 || $rgb1[$c] > 255) || ($rgb2[$c] < 0 || $rgb2[$c] > 255)) {
                throw new \InvalidArgumentException('RGB array values must range between 0 and 255, inclusive');
            }
        }
        $l1 = static::luminance($rgb1);
        $l2 = static::luminance($rgb2);
        return sprintf('%.02f', ($l1 >= $l2
            ? ($l1 + .05) / ($l2 + .05)
            : ($l2 + .05) / ($l1 + .05)
        ));
    }

    /**
     * Get information about the WCAG compliancy.
     *
     * Currently this will return the contrast ratio and the WCAG 2.0 pass/fail
     * states.
     *
     * @param  string|array $fg
     * @param  string|array $bg
     * @return array
     * @throws \InvalidArgumentException
     */
    public static function accessibility($fg, $bg)
    {
        $ratio = static::contrastRatio($fg, $bg);
        return [
            'ratio' => $ratio,
            '2.0'   => [
                'aa'       => ($ratio >= 4.5),
                'aa-18pt'  => ($ratio >= 3),
                'aaa'      => ($ratio >= 7),
                'aaa-18pt' => ($ratio >= 4.5)
            ]
        ];
    }
}
