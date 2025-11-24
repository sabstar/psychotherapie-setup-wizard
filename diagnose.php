<?php
/**
 * Diagnose-Datei für Psycho Wizard
 * 
 * Lade diese Datei in das Plugin-Hauptverzeichnis hoch
 * Dann rufe auf: deine-domain.de/wp-content/plugins/psychotherapie-setup-wizard/diagnose.php
 */

// Zeige alle Fehler an
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo '<h1>🔍 Psycho Wizard Diagnose</h1>';
echo '<hr>';

// 1. Prüfe Plugin-Pfad
echo '<h2>1. Plugin-Pfad prüfen</h2>';
$plugin_dir = dirname(__FILE__);
echo '<p><strong>Plugin Verzeichnis:</strong> ' . $plugin_dir . '</p>';

// 2. Prüfe Ordnerstruktur
echo '<h2>2. Ordnerstruktur prüfen</h2>';

$required_files = array(
    'psychotherapie-setup-wizard.php' => 'Hauptdatei',
    'includes/class-wizard.php' => 'Wizard Klasse',
    'includes/class-installer.php' => 'Installer Klasse',
    'includes/class-ajax-handlers.php' => 'AJAX Handler',
    'assets/css/wizard.css' => 'CSS Datei',
    'assets/js/wizard.js' => 'JavaScript Datei',
    'templates/wizard-page.php' => 'Template Datei',
);

$missing_files = array();

echo '<table border="1" cellpadding="5" style="border-collapse: collapse;">';
echo '<tr><th>Datei</th><th>Status</th><th>Pfad</th></tr>';

foreach ($required_files as $file => $description) {
    $full_path = $plugin_dir . '/' . $file;
    $exists = file_exists($full_path);
    $status = $exists ? '✅' : '❌';
    $color = $exists ? 'green' : 'red';
    
    if (!$exists) {
        $missing_files[] = $file;
    }
    
    echo '<tr>';
    echo '<td>' . $description . '</td>';
    echo '<td style="color: ' . $color . '; font-weight: bold;">' . $status . '</td>';
    echo '<td style="font-size: 11px;">' . $full_path . '</td>';
    echo '</tr>';
}

echo '</table>';

// 3. Prüfe Step-Dateien
echo '<h2>3. Step-Dateien prüfen</h2>';

$steps_dir = $plugin_dir . '/templates/steps/';
$missing_steps = array();

echo '<table border="1" cellpadding="5" style="border-collapse: collapse;">';
echo '<tr><th>Step</th><th>Status</th><th>Pfad</th></tr>';

for ($i = 1; $i <= 13; $i++) {
    $step_file = $steps_dir . 'step-' . $i . '.php';
    $exists = file_exists($step_file);
    $status = $exists ? '✅' : '❌';
    $color = $exists ? 'green' : 'red';
    
    if (!$exists) {
        $missing_steps[] = 'step-' . $i . '.php';
    }
    
    echo '<tr>';
    echo '<td>Step ' . $i . '</td>';
    echo '<td style="color: ' . $color . '; font-weight: bold;">' . $status . '</td>';
    echo '<td style="font-size: 11px;">' . $step_file . '</td>';
    echo '</tr>';
}

echo '</table>';

// 4. Prüfe PHP Syntax
echo '<h2>4. PHP Syntax prüfen</h2>';

$php_files = array(
    'psychotherapie-setup-wizard.php',
    'includes/class-wizard.php',
    'includes/class-installer.php',
    'includes/class-ajax-handlers.php',
);

echo '<table border="1" cellpadding="5" style="border-collapse: collapse;">';
echo '<tr><th>Datei</th><th>Syntax</th><th>Fehler</th></tr>';

foreach ($php_files as $file) {
    $full_path = $plugin_dir . '/' . $file;
    
    if (!file_exists($full_path)) {
        echo '<tr>';
        echo '<td>' . $file . '</td>';
        echo '<td style="color: red;">❌</td>';
        echo '<td>Datei existiert nicht</td>';
        echo '</tr>';
        continue;
    }
    
    // Syntax Check
    $output = array();
    $return_var = 0;
    exec("php -l " . escapeshellarg($full_path) . " 2>&1", $output, $return_var);
    
    $syntax_ok = ($return_var === 0);
    $status = $syntax_ok ? '✅' : '❌';
    $color = $syntax_ok ? 'green' : 'red';
    $error = $syntax_ok ? 'OK' : implode('<br>', $output);
    
    echo '<tr>';
    echo '<td>' . $file . '</td>';
    echo '<td style="color: ' . $color . '; font-weight: bold;">' . $status . '</td>';
    echo '<td style="font-size: 11px;">' . $error . '</td>';
    echo '</tr>';
}

echo '</table>';

// 5. Zusammenfassung
echo '<h2>5. Zusammenfassung</h2>';

$total_errors = count($missing_files) + count($missing_steps);

if ($total_errors === 0) {
    echo '<p style="color: green; font-size: 18px; font-weight: bold;">✅ Alle Dateien vorhanden! Plugin sollte funktionieren.</p>';
} else {
    echo '<p style="color: red; font-size: 18px; font-weight: bold;">❌ ' . $total_errors . ' Problem(e) gefunden:</p>';
    
    if (count($missing_files) > 0) {
        echo '<p><strong>Fehlende Hauptdateien:</strong></p>';
        echo '<ul>';
        foreach ($missing_files as $file) {
            echo '<li>' . $file . '</li>';
        }
        echo '</ul>';
    }
    
    if (count($missing_steps) > 0) {
        echo '<p><strong>Fehlende Step-Dateien:</strong></p>';
        echo '<ul>';
        foreach ($missing_steps as $step) {
            echo '<li>' . $step . '</li>';
        }
        echo '</ul>';
    }
}

// 6. Dateirechte prüfen
echo '<h2>6. Dateirechte prüfen</h2>';

$writable_dirs = array(
    'uploads' => wp_upload_dir()['basedir'],
);

echo '<p>WordPress Upload Verzeichnis: <strong>' . wp_upload_dir()['basedir'] . '</strong></p>';
echo '<p>Schreibbar: <strong>' . (is_writable(wp_upload_dir()['basedir']) ? '✅ Ja' : '❌ Nein') . '</strong></p>';

echo '<hr>';
echo '<p><em>Diagnose abgeschlossen. Wenn Fehler gefunden wurden, lade die fehlenden Dateien hoch.</em></p>';
?>