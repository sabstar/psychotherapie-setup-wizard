<?php
// Test if translations load
define('ABSPATH', true);

// Simulate WordPress
$locale = 'en_US';
$domain = 'psycho-wizard';
$mofile = __DIR__ . '/languages/psycho-wizard-en_US.mo';

echo "Locale: $locale\n";
echo "MO File: $mofile\n";
echo "MO File exists: " . (file_exists($mofile) ? 'YES' : 'NO') . "\n";
echo "MO File size: " . filesize($mofile) . " bytes\n";

// Try to load MO file directly
if (class_exists('MO')) {
    $mo = new MO();
    $mo->import_from_file($mofile);
    echo "\nTest translation for 'Los geht's →':\n";
    echo $mo->translate("Los geht's →") . "\n";
}
