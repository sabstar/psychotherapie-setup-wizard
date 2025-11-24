<?php
/**
 * Plugin Name: Psychotherapie Template Kit - Setup Wizard
 * Plugin URI: https://lechclick.de
 * Description: Setup Wizard für das Psychotherapie Template Kit mit automatischer Installation und Konfiguration
 * Version: 1.0.0
 * Author: Lechclick
 * Author URI: https://lechclick.de
 * License: GPL v2 or later
 * Text Domain: psycho-wizard
 */

if (!defined('ABSPATH')) {
    exit;
}

// Plugin Konstanten
define('PSYCHO_WIZARD_VERSION', '1.5.5');
define('PSYCHO_WIZARD_PATH', plugin_dir_path(__FILE__));
define('PSYCHO_WIZARD_URL', plugin_dir_url(__FILE__));

// Plugin Update Checker
require_once PSYCHO_WIZARD_PATH . 'lib/plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
    'https://github.com/sabstar/psychotherapie-setup-wizard/',
    __FILE__,
    'psychotherapie-setup-wizard'
);

// Optional: Branch festlegen
$myUpdateChecker->setBranch('main');


// Hauptklasse laden
require_once PSYCHO_WIZARD_PATH . 'includes/class-wizard.php';
require_once PSYCHO_WIZARD_PATH . 'includes/class-installer.php';
require_once PSYCHO_WIZARD_PATH . 'includes/class-ajax-handlers.php';
require_once PSYCHO_WIZARD_PATH . 'includes/class-status-checker.php';
require_once PSYCHO_WIZARD_PATH . 'includes/class-waiting-badge.php';

// Text Domain laden
function psycho_wizard_load_textdomain() {
    $loaded = load_plugin_textdomain(
        'psycho-wizard',
        false,
        dirname(plugin_basename(__FILE__)) . '/languages'
    );

    // Debug: Log locale and loading status
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_log('Psycho Wizard - Current Locale: ' . get_locale());
        error_log('Psycho Wizard - Text Domain Loaded: ' . ($loaded ? 'YES' : 'NO'));
        error_log('Psycho Wizard - Translation Test: ' . __('Los geht\'s →', 'psycho-wizard'));
    }
}
add_action('plugins_loaded', 'psycho_wizard_load_textdomain', 1);

// Plugin initialisieren
function psycho_wizard_init() {
    $wizard = new Psycho_Wizard();
    $wizard->init();
}
add_action('plugins_loaded', 'psycho_wizard_init');

// Waiting Badge initialisieren
function psycho_waiting_badge_init() {
    $waiting_badge = new Psycho_Waiting_Badge();
    $waiting_badge->init();
}
add_action('plugins_loaded', 'psycho_waiting_badge_init');

// Bei Plugin-Aktivierung
register_activation_hook(__FILE__, 'psycho_wizard_activate');
function psycho_wizard_activate() {
    // Setze Flag dass Wizard angezeigt werden soll
    set_transient('psycho_wizard_show', true, 60);
    
    // Erstelle Upload-Verzeichnis für Template-Dateien
    $upload_dir = wp_upload_dir();
    $wizard_dir = $upload_dir['basedir'] . '/psycho-wizard';
    if (!file_exists($wizard_dir)) {
        wp_mkdir_p($wizard_dir);
    }
}

// Erlaube JSON, XML, SVG und ZIP Uploads
add_filter('upload_mimes', 'psycho_wizard_allow_file_types');
function psycho_wizard_allow_file_types($mimes) {
    // Nur für Admins
    if (!current_user_can('manage_options')) {
        return $mimes;
    }

    // JSON erlauben
    $mimes['json'] = 'application/json';

    // XML erlauben (für Demo-Daten Import)
    $mimes['xml'] = 'application/xml';
    $mimes['xml'] = 'text/xml';

    // Weitere Mimes die evtl. fehlen
    $mimes['svg'] = 'image/svg+xml';

    return $mimes;
}

// Zusätzlicher Filter um XML-Upload zu erlauben (umgeht WordPress Security Check)
add_filter('wp_check_filetype_and_ext', 'psycho_wizard_allow_xml_upload', 10, 4);
function psycho_wizard_allow_xml_upload($data, $file, $filename, $mimes) {
    // Nur für Admins
    if (!current_user_can('manage_options')) {
        return $data;
    }

    $filetype = wp_check_filetype($filename, $mimes);

    // Prüfe ob es eine XML-Datei ist
    if ($filetype['ext'] === 'xml') {
        $data['ext'] = 'xml';
        $data['type'] = 'application/xml';
        $data['proper_filename'] = $filename;
    }

    return $data;
}

// Redirect nach Aktivierung
add_action('admin_init', 'psycho_wizard_redirect');
function psycho_wizard_redirect() {
    if (get_transient('psycho_wizard_show')) {
        delete_transient('psycho_wizard_show');
        wp_safe_redirect(admin_url('admin.php?page=psycho-wizard'));
        exit;
    }
}

// Re-registriere ACF CPTs und Taxonomien beim WordPress Init
add_action('init', 'psycho_wizard_reregister_acf_cpts');
function psycho_wizard_reregister_acf_cpts() {
    // Stelle sicher dass importierte ACF CPTs in Elementor aktiviert bleiben
    Psycho_Installer::reregister_acf_cpts();
}

// Admin Menü Hinweis
add_action('admin_notices', 'psycho_wizard_admin_notice');
function psycho_wizard_admin_notice() {
    // Nur anzeigen wenn Wizard noch nicht abgeschlossen wurde
    $wizard_completed = get_option('psycho_wizard_completed', false);

    if (!$wizard_completed && (!isset($_GET['page']) || $_GET['page'] !== 'psycho-wizard')) {
        // Hole aktuellen Status
        $wizard_status = get_option('psycho_wizard_status', array('current_step' => 1));
        $current_step = isset($wizard_status['current_step']) ? $wizard_status['current_step'] : 1;

        // Nicht anzeigen wenn bei Step 16 (Abschluss)
        if ($current_step >= 16) {
            return;
        }

        // Bestimme Button-Text und Emoji
        $is_started = $current_step > 1;
        $button_text = $is_started
            ? sprintf(__('▶️ Setup fortsetzen (Schritt %d)', 'psycho-wizard'), $current_step)
            : __('🚀 Setup fortführen', 'psycho-wizard');
        $notice_title = $is_started
            ? __('🎯 Psychotherapie Template Kit Setup - Fortsetzen', 'psycho-wizard')
            : __('🎯 Psychotherapie Template Kit Setup', 'psycho-wizard');
        $notice_text = $is_started
            ? sprintf(__('Du bist bei Schritt %d von 16. Setze den Setup-Wizard fort um dein Template Kit zu vervollständigen.', 'psycho-wizard'), $current_step)
            : __('Führe den Setup-Wizard fort um dein Template Kit zu installieren und zu konfigurieren.', 'psycho-wizard');

        ?>
<div class="notice notice-info is-dismissible">
    <p>
        <strong><?php echo $notice_title; ?></strong><br>
        <?php echo $notice_text; ?>
        <br>
        <a href="<?php echo admin_url('admin.php?page=psycho-wizard'); ?>" class="button button-primary"
            style="margin-top: 10px;">
            <?php echo $button_text; ?>
        </a>
    </p>
</div>
<?php
    }
}