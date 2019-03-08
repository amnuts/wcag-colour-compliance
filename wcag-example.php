<?php

require './wcag.php';

echo "===== Compatibility checks =====\n";
var_dump(WCAG::accessibility('013035', 'F2C75C'));
var_dump(WCAG::accessibility('1E428A', 'C284A3'));
var_dump(WCAG::accessibility('D6D2C4', 'FFE900'));
var_dump(WCAG::accessibility('FF9966', '000000'));
var_dump(WCAG::accessibility('FFFFFF', [0, 0, 0]));
var_dump(WCAG::accessibility([255, 255, 255], '#000'));

echo "===== Luminance =====\n";
echo WCAG::luminance('013035') . "\n";
echo WCAG::luminance('1E428A') . "\n";
echo WCAG::luminance('D6D2C4') . "\n";
echo WCAG::luminance('FF9966') . "\n";
echo WCAG::luminance('FFFFFF') . "\n";
echo WCAG::luminance('000000') . "\n";

echo "===== Contrast ratio =====\n";
echo WCAG::contrastRatio('013035', 'F2C75C') . "\n";
echo WCAG::contrastRatio('1E428A', 'C284A3') . "\n";
echo WCAG::contrastRatio('D6D2C4', 'FFE900') . "\n";
echo WCAG::contrastRatio('FF9966', '000000') . "\n";
echo WCAG::contrastRatio('FFFFFF', [0, 0, 0]) . "\n";
echo WCAG::contrastRatio([255, 255, 255], '#000') . "\n";

echo "===== Hex to RGB =====\n";
var_dump(WCAG::hex2rgb('#013035'));
var_dump(WCAG::hex2rgb('1E428A'));
var_dump(WCAG::hex2rgb('#D6D2C4'));
var_dump(WCAG::hex2rgb('FF9966'));
var_dump(WCAG::hex2rgb('#FFF'));
var_dump(WCAG::hex2rgb('#000'));
var_dump(WCAG::hex2rgb('FFFFFF'));
var_dump(WCAG::hex2rgb('000000'));