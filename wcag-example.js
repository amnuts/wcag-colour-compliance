const { wcag } = require('./wcag');

console.log('===== Compatibility checks =====');
console.log(wcag.compatibility('013035', 'F2C75C'));
console.log(wcag.compatibility('1E428A', 'C284A3'));
console.log(wcag.compatibility('D6D2C4', 'FFE900'));
console.log(wcag.compatibility('FF9966', '000000'));
console.log(wcag.compatibility('FFFFFF', [0, 0, 0]));
console.log(wcag.compatibility([255, 255, 255], '#000'));

console.log('===== Luminance =====');
console.log(wcag.luminance('013035'));
console.log(wcag.luminance('1E428A'));
console.log(wcag.luminance('D6D2C4'));
console.log(wcag.luminance('FF9966'));
console.log(wcag.luminance('FFFFFF'));
console.log(wcag.luminance('000000'));

console.log('===== Contrast ratio =====');
console.log(wcag.contrastRatio('013035', 'F2C75C'));
console.log(wcag.contrastRatio('1E428A', 'C284A3'));
console.log(wcag.contrastRatio('D6D2C4', 'FFE900'));
console.log(wcag.contrastRatio('FF9966', '000000'));
console.log(wcag.contrastRatio('FFFFFF', [0, 0, 0]));
console.log(wcag.contrastRatio([255, 255, 255], '#000'));

console.log('===== Hex to RGB =====');
console.log(wcag.hex2rgb('#013035'));
console.log(wcag.hex2rgb('1E428A'));
console.log(wcag.hex2rgb('#D6D2C4'));
console.log(wcag.hex2rgb('FF9966'));
console.log(wcag.hex2rgb('#FFF'));
console.log(wcag.hex2rgb('#000'));
console.log(wcag.hex2rgb('FFFFFF'));
console.log(wcag.hex2rgb('000000'));