<?php
/**
 * Status Checker - Prüft ob Schritte bereits abgeschlossen sind
 */

if (!defined('ABSPATH')) {
    exit;
}

class Psycho_Status_Checker {
    
    /**
     * Hole aktuellen Wizard-Status
     */
    public static function get_wizard_status() {
        $status = get_option('psycho_wizard_status', array(
            'current_step' => 1,
            'completed_steps' => array(),
            'hello_theme_installed' => false,
            'elementor_installed' => false,
            'elementor_pro_installed' => false,
            'elementor_pro_active' => false,
            'template_kit_imported' => false,
            'acf_imported' => false,
            'demo_data_imported' => false,
            'styling_plugin_installed' => false,
            'settings_configured' => false,
            'templates_assigned' => false,
            'colors_set' => false,
            'fonts_uploaded' => false
        ));
        
        return $status;
    }
    
    /**
     * Speichere Wizard-Status
     */
    public static function save_wizard_status($status) {
        update_option('psycho_wizard_status', $status);
    }
    
    /**
     * Aktualisiere einzelnen Status
     */
    public static function update_status($key, $value) {
        $status = self::get_wizard_status();
        $status[$key] = $value;
        self::save_wizard_status($status);
    }
    
    /**
     * Markiere Step als abgeschlossen
     */
    public static function mark_step_completed($step_number) {
        $status = self::get_wizard_status();
        if (!in_array($step_number, $status['completed_steps'])) {
            $status['completed_steps'][] = $step_number;
            self::save_wizard_status($status);
        }
    }
    
    /**
     * Prüfe ob Hello Theme installiert ist
     */
    public static function is_hello_theme_installed() {
        $theme = wp_get_theme('hello-elementor');
        return $theme->exists();
    }
    
    /**
     * Prüfe ob Hello Theme aktiv ist
     */
    public static function is_hello_theme_active() {
        $current_theme = wp_get_theme();
        return $current_theme->get_template() === 'hello-elementor';
    }
    
    /**
     * Prüfe ob Elementor installiert ist
     */
    public static function is_elementor_installed() {
        return class_exists('\Elementor\Plugin');
    }
    
    /**
     * Prüfe ob Elementor aktiv ist
     */
    public static function is_elementor_active() {
        return is_plugin_active('elementor/elementor.php');
    }
    
    /**
     * Prüfe ob Elementor Pro installiert ist
     */
    public static function is_elementor_pro_installed() {
        return class_exists('\ElementorPro\Plugin');
    }
    
    /**
     * Prüfe ob Elementor Pro aktiv ist
     */
    public static function is_elementor_pro_active() {
        return is_plugin_active('elementor-pro/elementor-pro.php');
    }
    
    /**
     * Prüfe ob Elementor Pro Lizenz aktiv ist
     */
    public static function is_elementor_pro_license_active() {
        if (!self::is_elementor_pro_installed()) {
            return false;
        }
        
        // Mehrere Methoden prüfen
        $license_key = get_option('elementor_pro_license_key');
        $alt_license_key = get_option('_elementor_pro_license_key');
        $license_data = get_option('_elementor_pro_license_data');
        
        // Wenn Lizenzschlüssel gespeichert ist
        if (!empty($license_key) || !empty($alt_license_key)) {
            return true;
        }
        
        // Wenn Lizenz-Daten vorhanden und valid
        if ($license_data && isset($license_data['license']) && $license_data['license'] === 'valid') {
            return true;
        }
        
        return false;
    }
    
    /**
     * Hole kompletten Status als Array für Frontend
     */
    public static function get_complete_status() {
        $wizard_status = self::get_wizard_status();

        // Auto-Detection: Prüfe ob Step 7 (Team Settings) bereits konfiguriert ist
        $elementor_cpt_support = get_option('elementor_cpt_support', array());
        $team_active = is_array($elementor_cpt_support) && (in_array('team_member', $elementor_cpt_support) || in_array('team', $elementor_cpt_support));
        $colors_disabled = get_option('elementor_disable_color_schemes', '') === 'yes';
        $fonts_disabled = get_option('elementor_disable_typography_schemes', '') === 'yes';

        if ($team_active && $colors_disabled && $fonts_disabled) {
            // Step 7 ist bereits konfiguriert - speichere das
            if (!isset($wizard_status['team_settings_configured']) || !$wizard_status['team_settings_configured']) {
                $wizard_status['team_settings_configured'] = true;
                self::save_wizard_status($wizard_status);
            }
        }

        // Auto-Detection: Prüfe ob Step 8 (Styling Plugin) bereits installiert ist
        if (is_plugin_active('psychotherapeuten-styling/psychotherapeuten-styling.php')) {
            if (!isset($wizard_status['styling_plugin_installed']) || !$wizard_status['styling_plugin_installed']) {
                $wizard_status['styling_plugin_installed'] = true;
                self::save_wizard_status($wizard_status);
            }
        }

        // Auto-Detection: Prüfe ob Step 10 (Datenschutzseite) bereits veröffentlicht ist
        $privacy_page = get_page_by_title('Datenschutz');
        if (!$privacy_page) {
            $privacy_page = get_page_by_title('Privacy Policy');
        }
        if ($privacy_page && $privacy_page->post_status === 'publish') {
            if (!isset($wizard_status['privacy_page_published']) || !$wizard_status['privacy_page_published']) {
                $wizard_status['privacy_page_published'] = true;
                self::save_wizard_status($wizard_status);
            }
        }

        // Bereinige completed_steps: Entferne Steps die nicht mehr completed sind
        if (isset($wizard_status['completed_steps']) && is_array($wizard_status['completed_steps'])) {
            // Step 3 (Elementor) nur als completed wenn auch wirklich aktiv
            if (!self::is_elementor_active()) {
                $wizard_status['completed_steps'] = array_diff($wizard_status['completed_steps'], [3]);
            }
            // Reindex das Array
            $wizard_status['completed_steps'] = array_values($wizard_status['completed_steps']);
        }

        return array(
            'hello_theme_installed' => self::is_hello_theme_installed(),
            'hello_theme_active' => self::is_hello_theme_active(),
            'elementor_installed' => self::is_elementor_installed(),
            'elementor_active' => self::is_elementor_active(),
            'elementor_pro_installed' => self::is_elementor_pro_installed(),
            'elementor_pro_active' => self::is_elementor_pro_active(),
            'elementor_pro_license_active' => self::is_elementor_pro_license_active(),
            'wizard_status' => $wizard_status
        );
    }
}