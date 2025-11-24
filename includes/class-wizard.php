<?php
/**
 * Hauptklasse für den Setup Wizard
 */

if (!defined('ABSPATH')) {
    exit;
}

class Psycho_Wizard {
    
    public function init() {
        // Admin Menü registrieren
        add_action('admin_menu', array($this, 'add_admin_menu'));
        
        // Styles und Scripts laden
        add_action('admin_enqueue_scripts', array($this, 'enqueue_assets'));
    }
    
    /**
     * Admin Menü hinzufügen
     */
    public function add_admin_menu() {
        add_menu_page(
            __('Template Setup', 'psycho-wizard'),
            __('Template Setup', 'psycho-wizard'),
            'manage_options',
            'psycho-wizard',
            array($this, 'render_wizard_page'),
            'dashicons-admin-generic',
            3
        );

        // Anleitung Submenu hinzufügen
        add_submenu_page(
            'psycho-wizard',
            __('User Manual', 'psycho-wizard'),
            __('📖 User Manual', 'psycho-wizard'),
            'manage_options',
            'psycho-wizard-guide',
            array($this, 'render_guide_page')
        );
    }
    
    /**
     * CSS und JS laden
     */
    public function enqueue_assets($hook) {
        // Nur auf der Wizard-Seite laden
        if ($hook !== 'toplevel_page_psycho-wizard') {
            return;
        }
        
        // CSS
        wp_enqueue_style(
            'psycho-wizard-css',
            PSYCHO_WIZARD_URL . 'assets/css/wizard.css',
            array(),
            PSYCHO_WIZARD_VERSION
        );
        
        // Dependencies JS (ZUERST laden - IM FOOTER damit jQuery definitiv verfügbar ist)
        wp_enqueue_script(
            'psycho-wizard-deps',
            PSYCHO_WIZARD_URL . 'assets/js/wizard-dependencies.js',
            array('jquery'),
            PSYCHO_WIZARD_VERSION,
            true  // Im Footer laden - jQuery ist dann garantiert verfügbar
        );

        // Haupt JS (IM FOOTER damit jQuery verfügbar ist)
        wp_enqueue_script(
            'psycho-wizard-js',
            PSYCHO_WIZARD_URL . 'assets/js/wizard.js',
            array('jquery', 'psycho-wizard-deps'),
            PSYCHO_WIZARD_VERSION,
            true  // Im Footer laden - jQuery ist dann garantiert verfügbar
        );
        
        // WordPress Media Uploader
        wp_enqueue_media();
        
        // AJAX URL und Nonce für JavaScript
        wp_localize_script('psycho-wizard-js', 'psychoWizard', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('psycho_wizard_nonce'),
            'pluginUrl' => PSYCHO_WIZARD_URL,
            'i18n' => array(
                'nextBtn' => __('Weiter →', 'psycho-wizard'),
                'startBtn' => __('Los geht\'s →', 'psycho-wizard'),
                'pleasActivateLicenseBtn' => __('Bitte Lizenz aktivieren', 'psycho-wizard'),
                'pleaseImportTemplateKitBtn' => __('Bitte Template Kit importieren', 'psycho-wizard'),
                'applyColorsBtn' => __('Farben anwenden →', 'psycho-wizard'),
                'continueWithoutChangeBtn' => __('Weiter ohne Änderung →', 'psycho-wizard'),
                'continueStylesOptionalBtn' => __('Weiter (Styles sind optional) →', 'psycho-wizard'),
                'setupCompletedBtn' => __('Setup abgeschlossen ✓', 'psycho-wizard'),
                'checkImportStatusBtn' => __('🔄 Import-Status prüfen', 'psycho-wizard'),
                'applyingColors' => __('🎨 Wende Farben an...', 'psycho-wizard'),
                'templateKitImported' => __('✅ <strong>Template Kit erfolgreich importiert!</strong>', 'psycho-wizard'),
                'foundTemplates' => __('Gefunden: %d Templates, %d Seiten', 'psycho-wizard'),
                'installed' => __('✓ Installiert', 'psycho-wizard'),
                'checkingLicense' => __('⏳ Prüfe Lizenz...', 'psycho-wizard'),
                'checkLicenseStatusBtn' => __('🔄 Lizenz-Status prüfen', 'psycho-wizard'),
            )
        ));
    }
    
    /**
     * Wizard Seite rendern
     */
    public function render_wizard_page() {
        // Prüfe ob bereits abgeschlossen
        $wizard_completed = get_option('psycho_wizard_completed', false);

        // Template laden
        include PSYCHO_WIZARD_PATH . 'templates/wizard-page.php';
    }

    /**
     * Anleitung Page rendern
     */
    public function render_guide_page() {
        include PSYCHO_WIZARD_PATH . 'templates/admin-guide.php';
    }

    /**
     * Prüfe ob Plugin installiert ist
     */
    public static function is_plugin_installed($slug) {
        $plugins = get_plugins();
        
        foreach ($plugins as $plugin_path => $plugin_data) {
            if (strpos($plugin_path, $slug) !== false) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Prüfe ob Plugin aktiv ist
     */
    public static function is_plugin_active($slug) {
        $plugins = get_option('active_plugins');
        
        foreach ($plugins as $plugin) {
            if (strpos($plugin, $slug) !== false) {
                return true;
            }
        }
        
        return false;
    }
}