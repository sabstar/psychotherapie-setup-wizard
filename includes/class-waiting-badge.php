<?php
/**
 * Waiting Badge Manager
 *
 * Verwaltet das Waiting Time Badge:
 * - Admin Options Page
 * - Shortcodes für Elementor
 * - JavaScript für Close-Button
 * - Cookie Management
 */

if (!defined('ABSPATH')) {
    exit;
}

class Psycho_Waiting_Badge {

    /**
     * Option Name für Settings
     */
    const OPTION_GROUP = 'psycho_waiting_badge_settings';
    const OPTION_ENABLED = 'psycho_waiting_badge_enabled';
    const OPTION_HEADING = 'psycho_waiting_badge_heading';
    const OPTION_TIME = 'psycho_waiting_badge_time';
    const OPTION_POSITION = 'psycho_waiting_badge_position';
    const OPTION_COOKIE_DAYS = 'psycho_waiting_badge_cookie_days';

    public function init() {
        // Admin Menu registrieren
        add_action('admin_menu', array($this, 'add_admin_menu'));

        // Settings registrieren
        add_action('admin_init', array($this, 'register_settings'));

        // Shortcodes registrieren
        add_shortcode('waiting_badge_heading', array($this, 'shortcode_heading'));
        add_shortcode('waiting_badge_time', array($this, 'shortcode_time'));
        add_shortcode('waiting_badge_show', array($this, 'shortcode_conditional_display'));

        // Frontend Scripts laden (nur wenn Badge aktiviert)
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_scripts'));

        // JavaScript Variablen bereitstellen
        add_action('wp_head', array($this, 'add_inline_js_vars'));

        // Export/Import Handler
        add_action('admin_init', array($this, 'handle_export'));
        add_action('admin_init', array($this, 'handle_import'));

        // Body-Klasse hinzufügen für CSS-basierte Show/Hide
        add_filter('body_class', array($this, 'add_body_class'));

        // Frontend CSS für Badge Show/Hide
        add_action('wp_head', array($this, 'add_frontend_css'), 1);
    }

    /**
     * Admin Menu hinzufügen
     */
    public function add_admin_menu() {
        add_submenu_page(
            'psycho-wizard',
            __('Waiting Badge', 'psycho-wizard'),
            __('⏱️ Waiting Badge', 'psycho-wizard'),
            'manage_options',
            'psycho-waiting-badge',
            array($this, 'render_admin_page')
        );
    }

    /**
     * Settings registrieren
     */
    public function register_settings() {
        // Enabled Toggle
        register_setting(self::OPTION_GROUP, self::OPTION_ENABLED, array(
            'type' => 'boolean',
            'default' => false,
            'sanitize_callback' => 'rest_sanitize_boolean'
        ));

        // Heading Text
        register_setting(self::OPTION_GROUP, self::OPTION_HEADING, array(
            'type' => 'string',
            'default' => 'Waiting time',
            'sanitize_callback' => 'sanitize_text_field'
        ));

        // Time Text
        register_setting(self::OPTION_GROUP, self::OPTION_TIME, array(
            'type' => 'string',
            'default' => '8-10 weeks',
            'sanitize_callback' => 'sanitize_text_field'
        ));

        // Position
        register_setting(self::OPTION_GROUP, self::OPTION_POSITION, array(
            'type' => 'string',
            'default' => 'bottom-left',
            'sanitize_callback' => 'sanitize_text_field'
        ));

        // Cookie Days
        register_setting(self::OPTION_GROUP, self::OPTION_COOKIE_DAYS, array(
            'type' => 'integer',
            'default' => 30,
            'sanitize_callback' => 'absint'
        ));
    }

    /**
     * Admin Page rendern
     */
    public function render_admin_page() {
        include PSYCHO_WIZARD_PATH . 'templates/admin-waiting-badge.php';
    }

    /**
     * Shortcode: Heading
     */
    public function shortcode_heading($atts) {
        $heading = get_option(self::OPTION_HEADING, 'Waiting time');
        return esc_html($heading);
    }

    /**
     * Shortcode: Time
     */
    public function shortcode_time($atts) {
        $time = get_option(self::OPTION_TIME, '8-10 weeks');
        return esc_html($time);
    }

    /**
     * Shortcode: Conditional Display
     * Zeigt Content nur an wenn Badge aktiviert ist
     * Usage: [waiting_badge_show]Content hier[/waiting_badge_show]
     */
    public function shortcode_conditional_display($atts, $content = '') {
        // Prüfe ob Badge aktiviert ist
        if (!$this->is_badge_enabled()) {
            return ''; // Badge deaktiviert - nichts anzeigen
        }

        // Badge ist aktiviert - Content rendern
        return do_shortcode($content);
    }

    /**
     * Frontend Scripts laden
     */
    public function enqueue_frontend_scripts() {
        // Nur laden wenn Badge aktiviert ist
        if (!$this->is_badge_enabled()) {
            return;
        }

        // JavaScript für Close-Button
        wp_enqueue_script(
            'psycho-waiting-badge',
            PSYCHO_WIZARD_URL . 'assets/js/waiting-badge.js',
            array('jquery'),
            PSYCHO_WIZARD_VERSION,
            true
        );

        // Übergebe Settings an JavaScript
        wp_localize_script('psycho-waiting-badge', 'psychoWaitingBadge', array(
            'enabled' => $this->is_badge_enabled(),
            'cookieName' => 'psycho_waiting_badge_closed',
            'cookieDays' => intval(get_option(self::OPTION_COOKIE_DAYS, 30)),
            'position' => get_option(self::OPTION_POSITION, 'bottom-left')
        ));
    }

    /**
     * Body-Klasse hinzufügen
     * Fügt 'waiting-badge-enabled' zur Body-Klasse hinzu wenn Badge aktiviert ist
     */
    public function add_body_class($classes) {
        if ($this->is_badge_enabled()) {
            $classes[] = 'waiting-badge-enabled';
        } else {
            $classes[] = 'waiting-badge-disabled';
        }
        return $classes;
    }

    /**
     * Frontend CSS für Badge Show/Hide
     * Blendet Badge aus wenn deaktiviert - funktioniert OHNE Display Conditions!
     */
    public function add_frontend_css() {
        ?>
        <style type="text/css">
        /* Blende Badge aus wenn deaktiviert */
        body.waiting-badge-disabled .waiting-badge-container {
            display: none !important;
        }

        /* Badge ist standardmäßig versteckt bis JavaScript lädt */
        .waiting-badge-container {
            visibility: hidden;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        /* JavaScript macht Badge sichtbar */
        body.waiting-badge-enabled .waiting-badge-container.badge-ready {
            visibility: visible;
            opacity: 1;
        }
        </style>
        <?php
    }

    /**
     * Inline JavaScript Variablen im Head
     */
    public function add_inline_js_vars() {
        if (!$this->is_badge_enabled()) {
            return;
        }

        ?>
        <script type="text/javascript">
        // Waiting Badge Settings für JavaScript
        var psychoWaitingBadgeSettings = {
            enabled: <?php echo json_encode($this->is_badge_enabled()); ?>,
            cookieName: 'psycho_waiting_badge_closed',
            cookieDays: <?php echo intval(get_option(self::OPTION_COOKIE_DAYS, 30)); ?>,
            position: '<?php echo esc_js(get_option(self::OPTION_POSITION, 'bottom-left')); ?>'
        };
        </script>
        <?php
    }

    /**
     * Prüfe ob Badge aktiviert ist
     */
    public function is_badge_enabled() {
        return (bool) get_option(self::OPTION_ENABLED, false);
    }

    /**
     * Hole alle Settings
     */
    public function get_settings() {
        return array(
            'enabled' => $this->is_badge_enabled(),
            'heading' => get_option(self::OPTION_HEADING, 'Waiting time'),
            'time' => get_option(self::OPTION_TIME, '8-10 weeks'),
            'position' => get_option(self::OPTION_POSITION, 'bottom-left'),
            'cookie_days' => intval(get_option(self::OPTION_COOKIE_DAYS, 30))
        );
    }

    /**
     * Export Handler - Exportiert Settings als JSON
     */
    public function handle_export() {
        // Prüfe ob Export angefordert wurde
        if (!isset($_GET['psycho_badge_export']) || !isset($_GET['_wpnonce'])) {
            return;
        }

        // Nonce prüfen
        if (!wp_verify_nonce($_GET['_wpnonce'], 'psycho_badge_export')) {
            wp_die('Security check failed');
        }

        // Berechtigung prüfen
        if (!current_user_can('manage_options')) {
            wp_die('Insufficient permissions');
        }

        // Hole alle Settings
        $settings = $this->get_settings();

        // Füge Metadata hinzu
        $export_data = array(
            'version' => PSYCHO_WIZARD_VERSION,
            'exported_at' => current_time('mysql'),
            'site_url' => get_site_url(),
            'settings' => $settings
        );

        // Erstelle JSON
        $json = json_encode($export_data, JSON_PRETTY_PRINT);

        // Dateiname mit Timestamp
        $filename = 'waiting-badge-settings-' . date('Y-m-d-His') . '.json';

        // Headers für Download
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: 0');

        // Ausgabe
        echo $json;
        exit;
    }

    /**
     * Import Handler - Importiert Settings aus JSON
     */
    public function handle_import() {
        // Prüfe ob Import angefordert wurde
        if (!isset($_POST['psycho_badge_import']) || !isset($_POST['psycho_badge_import_nonce'])) {
            return;
        }

        // Nonce prüfen
        if (!wp_verify_nonce($_POST['psycho_badge_import_nonce'], 'psycho_badge_import')) {
            add_settings_error(
                'psycho_waiting_badge',
                'import_error',
                'Security check failed',
                'error'
            );
            return;
        }

        // Berechtigung prüfen
        if (!current_user_can('manage_options')) {
            add_settings_error(
                'psycho_waiting_badge',
                'import_error',
                'Insufficient permissions',
                'error'
            );
            return;
        }

        // Prüfe ob Datei hochgeladen wurde
        if (!isset($_FILES['psycho_badge_import_file']) || $_FILES['psycho_badge_import_file']['error'] !== UPLOAD_ERR_OK) {
            add_settings_error(
                'psycho_waiting_badge',
                'import_error',
                'Keine Datei hochgeladen oder Upload-Fehler',
                'error'
            );
            return;
        }

        // Datei einlesen
        $file = $_FILES['psycho_badge_import_file'];
        $json_content = file_get_contents($file['tmp_name']);

        // JSON parsen
        $import_data = json_decode($json_content, true);

        // Validierung
        if (!$import_data || !isset($import_data['settings'])) {
            add_settings_error(
                'psycho_waiting_badge',
                'import_error',
                'Ungültige JSON-Datei oder falsche Struktur',
                'error'
            );
            return;
        }

        $settings = $import_data['settings'];

        // Validiere und importiere Settings
        if (isset($settings['enabled'])) {
            update_option(self::OPTION_ENABLED, (bool) $settings['enabled']);
        }

        if (isset($settings['heading'])) {
            update_option(self::OPTION_HEADING, sanitize_text_field($settings['heading']));
        }

        if (isset($settings['time'])) {
            update_option(self::OPTION_TIME, sanitize_text_field($settings['time']));
        }

        if (isset($settings['position']) && in_array($settings['position'], array('bottom-left', 'bottom-right'))) {
            update_option(self::OPTION_POSITION, $settings['position']);
        }

        if (isset($settings['cookie_days'])) {
            update_option(self::OPTION_COOKIE_DAYS, absint($settings['cookie_days']));
        }

        // Erfolgs-Meldung
        add_settings_error(
            'psycho_waiting_badge',
            'import_success',
            '✅ Badge-Settings erfolgreich importiert!',
            'success'
        );

        // Redirect um POST-Daten zu clearen
        wp_safe_redirect(add_query_arg('settings-updated', 'true', wp_get_referer()));
        exit;
    }
}
