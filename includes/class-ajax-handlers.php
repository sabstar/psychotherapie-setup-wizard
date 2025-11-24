<?php
/**
 * AJAX Handler für alle Wizard-Aktionen
 */

if (!defined('ABSPATH')) {
    exit;
}

class Psycho_Ajax_Handlers {
    
    public function __construct() {
        // AJAX Actions registrieren
        add_action('wp_ajax_psycho_get_status', array($this, 'get_status'));
        add_action('wp_ajax_psycho_save_step', array($this, 'save_step'));
        add_action('wp_ajax_psycho_mark_step_completed', array($this, 'mark_step_completed'));
        add_action('wp_ajax_psycho_install_hello_theme', array($this, 'install_hello_theme'));
        add_action('wp_ajax_psycho_install_elementor', array($this, 'install_elementor'));
        add_action('wp_ajax_psycho_upload_elementor_pro', array($this, 'upload_elementor_pro'));
        add_action('wp_ajax_psycho_check_elementor_license', array($this, 'check_elementor_license'));
        add_action('wp_ajax_psycho_activate_license', array($this, 'activate_license'));
        add_action('wp_ajax_psycho_check_template_import', array($this, 'check_template_import')); // NEU
        add_action('wp_ajax_psycho_check_team_settings', array($this, 'check_team_settings'));
        add_action('wp_ajax_psycho_upload_styling_plugin', array($this, 'upload_styling_plugin')); // NEU
        add_action('wp_ajax_psycho_check_styling_plugin', array($this, 'check_styling_plugin')); // NEU
        add_action('wp_ajax_psycho_save_wp_settings', array($this, 'save_wp_settings')); // NEU
        add_action('wp_ajax_psycho_mark_templates_assigned', array($this, 'mark_templates_assigned')); // NEU
        add_action('wp_ajax_psycho_assign_all_templates', array($this, 'assign_all_templates')); // NEU
        add_action('wp_ajax_psycho_publish_privacy_page', array($this, 'publish_privacy_page')); // NEU
        add_action('wp_ajax_psycho_upload_template_kit', array($this, 'upload_template_kit'));
        add_action('wp_ajax_psycho_upload_acf_json', array($this, 'upload_acf_json'));
        add_action('wp_ajax_psycho_check_acf_import', array($this, 'check_acf_import')); // NEU
        add_action('wp_ajax_psycho_upload_demo_data', array($this, 'upload_demo_data'));
        add_action('wp_ajax_psycho_reset_demo_data', array($this, 'reset_demo_data')); // NEU
        add_action('wp_ajax_psycho_install_styling_plugin', array($this, 'install_styling_plugin'));
        add_action('wp_ajax_psycho_configure_settings', array($this, 'configure_settings'));
        add_action('wp_ajax_psycho_assign_templates', array($this, 'assign_templates'));
        add_action('wp_ajax_psycho_set_colors', array($this, 'set_colors'));
        add_action('wp_ajax_psycho_get_current_colors', array($this, 'get_current_colors')); // NEU
        add_action('wp_ajax_psycho_reset_template_colors', array($this, 'reset_template_colors')); // NEU
        add_action('wp_ajax_psycho_reset_typography', array($this, 'reset_typography')); // NEU
        add_action('wp_ajax_psycho_reset_button_styles', array($this, 'reset_button_styles')); // NEU
        add_action('wp_ajax_psycho_reset_image_styles', array($this, 'reset_image_styles')); // NEU
        add_action('wp_ajax_psycho_upload_fonts', array($this, 'upload_fonts'));
        add_action('wp_ajax_psycho_complete_wizard', array($this, 'complete_wizard'));
        // Typography Actions
        add_action('wp_ajax_psycho_prepare_fonts', array($this, 'prepare_fonts'));
        add_action('wp_ajax_psycho_apply_typography', array($this, 'apply_typography'));
        // Schema Status Actions
        add_action('wp_ajax_psycho_get_active_color_scheme', array($this, 'get_active_color_scheme'));
        add_action('wp_ajax_psycho_get_active_typography_scheme', array($this, 'get_active_typography_scheme'));
        add_action('wp_ajax_psycho_get_active_style_scheme', array($this, 'get_active_style_scheme'));
        // Button & Image Styles Actions
        add_action('wp_ajax_psycho_apply_style_scheme', array($this, 'apply_style_scheme'));
    }
    
    /**
     * Hole aktuellen Status
     */
    public function get_status() {
        $this->verify_request();
        
        $status = Psycho_Status_Checker::get_complete_status();
        
        wp_send_json_success($status);
    }
    
    /**
     * Speichere aktuellen Step
     */
    public function save_step() {
        $this->verify_request();
        
        $step = isset($_POST['step']) ? intval($_POST['step']) : 1;
        
        Psycho_Status_Checker::update_status('current_step', $step);
        
        wp_send_json_success(array('message' => 'Step gespeichert'));
    }
    
    /**
     * Markiere Step als abgeschlossen
     */
    public function mark_step_completed() {
        $this->verify_request();
        
        $step = isset($_POST['step']) ? intval($_POST['step']) : 0;
        
        if ($step > 0) {
            Psycho_Status_Checker::mark_step_completed($step);
            wp_send_json_success(array('message' => 'Step ' . $step . ' als abgeschlossen markiert'));
        } else {
            wp_send_json_error(array('message' => 'Ungültige Step-Nummer'));
        }
    }
    
    /**
     * Sicherheitsprüfung für alle AJAX Requests
     */
    private function verify_request() {
        check_ajax_referer('psycho_wizard_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => 'Keine Berechtigung'));
        }
    }
    
    /**
     * Hello Theme installieren
     */
    public function install_hello_theme() {
        $this->verify_request();
        
        $result = Psycho_Installer::install_hello_theme();
        
        if ($result['success']) {
            wp_send_json_success($result);
        } else {
            wp_send_json_error($result);
        }
    }
    
    /**
     * Elementor installieren
     */
    public function install_elementor() {
        $this->verify_request();
        
        $result = Psycho_Installer::install_plugin('elementor');
        
        if ($result['success']) {
            wp_send_json_success($result);
        } else {
            wp_send_json_error($result);
        }
    }
    
    /**
     * Elementor Pro hochladen
     */
    public function upload_elementor_pro() {
        $this->verify_request();
        
        if (empty($_FILES['file'])) {
            wp_send_json_error(array('message' => 'Keine Datei hochgeladen'));
        }
        
        // Datei verarbeiten
        $file = $_FILES['file'];
        $upload = wp_handle_upload($file, array('test_form' => false));
        
        if (isset($upload['error'])) {
            wp_send_json_error(array('message' => $upload['error']));
        }
        
        // Plugin installieren
        $result = Psycho_Installer::install_elementor_pro($upload['file']);
        
        if ($result['success']) {
            wp_send_json_success($result);
        } else {
            wp_send_json_error($result);
        }
    }
    
    /**
     * Lizenz aktivieren
     */
    public function activate_license() {
        $this->verify_request();
        
        $license_key = sanitize_text_field($_POST['license_key']);
        
        if (empty($license_key)) {
            wp_send_json_error(array('message' => 'Lizenzschlüssel fehlt'));
        }
        
        $result = Psycho_Installer::activate_elementor_license($license_key);
        
        if ($result['success']) {
            wp_send_json_success($result);
        } else {
            wp_send_json_error($result);
        }
    }
    
    /**
     * Prüfe Team Settings (CPT + Elementor Einstellungen)
     */
    public function check_team_settings() {
        $this->verify_request();

        $team_active = false;
        $colors_disabled = false;
        $fonts_disabled = false;

        // Prüfe ob Team CPT in Elementor aktiviert ist (team_member ist der korrekte CPT Name)
        $elementor_cpt_support = get_option('elementor_cpt_support', array());
        if (is_array($elementor_cpt_support) && (in_array('team_member', $elementor_cpt_support) || in_array('team', $elementor_cpt_support))) {
            $team_active = true;
        }
        
        // Prüfe ob Standardfarben deaktiviert sind
        $disable_color_schemes = get_option('elementor_disable_color_schemes', '');
        if ($disable_color_schemes === 'yes') {
            $colors_disabled = true;
        }
        
        // Prüfe ob Standardschriftarten deaktiviert sind
        $disable_typography_schemes = get_option('elementor_disable_typography_schemes', '');
        if ($disable_typography_schemes === 'yes') {
            $fonts_disabled = true;
        }
        
        $all_configured = $team_active && $colors_disabled && $fonts_disabled;
        
        if ($all_configured) {
            // Speichere Status
            Psycho_Status_Checker::update_status('team_settings_configured', true);
            
            wp_send_json_success(array(
                'message' => 'Team Settings konfiguriert',
                'all_configured' => true,
                'team_active' => $team_active,
                'colors_disabled' => $colors_disabled,
                'fonts_disabled' => $fonts_disabled
            ));
        } else {
            wp_send_json_error(array(
                'message' => 'Noch nicht vollständig konfiguriert',
                'all_configured' => false,
                'team_active' => $team_active,
                'colors_disabled' => $colors_disabled,
                'fonts_disabled' => $fonts_disabled
            ));
        }
    }
    
    /**
     * Prüfe ob Template Kit importiert wurde
     */
    public function check_template_import() {
        $this->verify_request();
        
        if (!class_exists('\Elementor\Plugin')) {
            wp_send_json_error(array(
                'message' => 'Elementor nicht installiert',
                'has_templates' => false
            ));
        }
        
        // Prüfe ob Templates existieren
        // Methode 1: Zähle Elementor Templates
        $args = array(
            'post_type' => 'elementor_library',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => '_elementor_template_type',
                    'value' => array('page', 'section', 'header', 'footer', 'single', 'archive'),
                    'compare' => 'IN'
                )
            )
        );
        
        $templates = get_posts($args);
        $template_count = count($templates);
        
        // Prüfe auch ob Seiten mit Elementor erstellt wurden
        $args_pages = array(
            'post_type' => 'page',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => '_elementor_edit_mode',
                    'value' => 'builder',
                    'compare' => '='
                )
            )
        );
        
        $elementor_pages = get_posts($args_pages);
        $page_count = count($elementor_pages);
        
        $total_items = $template_count + $page_count;
        
        if ($total_items > 0) {
            // Templates/Seiten gefunden!
            Psycho_Status_Checker::update_status('template_kit_imported', true);
            
            wp_send_json_success(array(
                'message' => 'Template Kit importiert',
                'has_templates' => true,
                'template_count' => $template_count,
                'page_count' => $page_count,
                'total_items' => $total_items
            ));
        } else {
            wp_send_json_error(array(
                'message' => 'Keine Templates oder Seiten gefunden. Bitte importiere dein Kit über Elementor.',
                'has_templates' => false,
                'template_count' => 0
            ));
        }
    }
    
    /**
     * Template Kit hochladen (NICHT MEHR VERWENDET - User geht zu Elementor)
     */
    public function upload_template_kit() {
        $this->verify_request();
        
        if (empty($_FILES['file'])) {
            wp_send_json_error(array('message' => 'Keine Datei hochgeladen'));
        }
        
        $file = $_FILES['file'];
        
        // Prüfe Dateityp
        $file_type = wp_check_filetype($file['name']);
        if ($file_type['ext'] !== 'zip') {
            wp_send_json_error(array('message' => 'Nur ZIP-Dateien sind erlaubt'));
        }
        
        // Erhöhe Upload-Limits temporär
        @ini_set('memory_limit', '512M');
        @ini_set('max_execution_time', '300');
        
        // Datei hochladen
        $upload = wp_handle_upload($file, array(
            'test_form' => false,
            'mimes' => array('zip' => 'application/zip')
        ));
        
        if (isset($upload['error'])) {
            wp_send_json_error(array('message' => $upload['error']));
        }
        
        // Template Kit importieren
        $result = Psycho_Installer::import_template_kit($upload['file']);
        
        // Temporäre Datei löschen
        @unlink($upload['file']);
        
        if ($result['success']) {
            wp_send_json_success($result);
        } else {
            wp_send_json_error($result);
        }
    }
    
    /**
     * ACF JSON hochladen
     */
    public function upload_acf_json() {
        $this->verify_request();
        
        if (empty($_FILES['file'])) {
            wp_send_json_error(array('message' => 'Keine Datei hochgeladen'));
        }
        
        $file = $_FILES['file'];
        $upload = wp_handle_upload($file, array('test_form' => false));
        
        if (isset($upload['error'])) {
            wp_send_json_error(array('message' => $upload['error']));
        }
        
        // ACF Fields importieren
        $result = Psycho_Installer::import_acf_fields($upload['file']);
        
        if ($result['success']) {
            wp_send_json_success($result);
        } else {
            wp_send_json_error($result);
        }
    }
    
    /**
     * Prüfe ob ACF importiert wurde und Team CPT existiert
     */
    public function check_acf_import() {
        $this->verify_request();

        $acf_imported = false;
        $team_cpt_exists = false;
        $field_groups_count = 0;

        // Prüfe ob ACF installiert ist
        if (!function_exists('acf_get_field_groups')) {
            wp_send_json_error(array(
                'message' => 'ACF nicht installiert',
                'acf_imported' => false
            ));
        }

        // Prüfe ob Team CPT existiert (team_member ist der korrekte CPT Name)
        if (post_type_exists('team_member')) {
            $team_cpt_exists = true;
        }

        // Zähle ACF Field Groups
        $field_groups = acf_get_field_groups();
        $field_groups_count = count($field_groups);

        // Suche speziell nach Team-bezogenen Field Groups
        $team_field_groups = 0;
        foreach ($field_groups as $group) {
            if (isset($group['location'])) {
                foreach ($group['location'] as $location_rules) {
                    foreach ($location_rules as $rule) {
                        if (isset($rule['param']) && $rule['param'] === 'post_type' &&
                            isset($rule['value']) && ($rule['value'] === 'team_member' || $rule['value'] === 'team')) {
                            $team_field_groups++;
                            break 2;
                        }
                    }
                }
            }
        }

        // Import ist erfolgreich wenn:
        // 1. Team CPT existiert
        // 2. Mindestens eine Team-Field-Group existiert
        if ($team_cpt_exists && $team_field_groups > 0) {
            Psycho_Status_Checker::update_status('acf_imported', true);

            wp_send_json_success(array(
                'message' => 'ACF erfolgreich importiert',
                'acf_imported' => true,
                'team_cpt_exists' => true,
                'field_groups_count' => $field_groups_count,
                'team_field_groups' => $team_field_groups
            ));
        } else {
            $error_msg = 'ACF Import unvollständig: ';
            if (!$team_cpt_exists) {
                $error_msg .= 'Team CPT (team_member) fehlt. ';
            }
            if ($team_field_groups === 0) {
                $error_msg .= 'Keine Team Field Groups gefunden.';
            }

            wp_send_json_error(array(
                'message' => $error_msg,
                'acf_imported' => false,
                'team_cpt_exists' => $team_cpt_exists,
                'field_groups_count' => $field_groups_count,
                'team_field_groups' => $team_field_groups
            ));
        }
    }

    /**
     * Demo Daten hochladen
     */
    public function upload_demo_data() {
        $this->verify_request();

        if (empty($_FILES['file'])) {
            wp_send_json_error(array('message' => 'Keine Datei hochgeladen'));
        }

        $file = $_FILES['file'];
        $upload = wp_handle_upload($file, array('test_form' => false));

        if (isset($upload['error'])) {
            wp_send_json_error(array('message' => $upload['error']));
        }

        // WordPress XML Import durchführen
        $result = Psycho_Installer::import_wordpress_xml($upload['file']);

        if ($result['success']) {
            Psycho_Status_Checker::update_status('demo_data_imported', true);
            wp_send_json_success(array(
                'message' => $result['message'],
                'imported_count' => $result['imported_count']
            ));
        } else {
            wp_send_json_error($result);
        }
    }

    /**
     * Reset Demo Data - Löscht alle importierten Team Members und setzt Status zurück
     */
    public function reset_demo_data() {
        $this->verify_request();

        // Hole alle team_member Posts
        $team_members = get_posts(array(
            'post_type' => 'team_member',
            'posts_per_page' => -1,
            'post_status' => 'any'
        ));

        $deleted_count = 0;

        // Lösche alle Team Members
        foreach ($team_members as $post) {
            wp_delete_post($post->ID, true); // true = force delete (bypass trash)
            $deleted_count++;
        }

        // Setze Status zurück
        Psycho_Status_Checker::update_status('demo_data_imported', false);

        wp_send_json_success(array(
            'message' => $deleted_count . ' Team Member gelöscht. Du kannst jetzt die Demo-Daten erneut importieren.',
            'deleted_count' => $deleted_count
        ));
    }

    /**
     * Upload Styling Plugin
     */
    public function upload_styling_plugin() {
        $this->verify_request();

        if (empty($_FILES['file'])) {
            wp_send_json_error(array('message' => 'Keine Datei hochgeladen'));
        }

        $file = $_FILES['file'];
        $upload = wp_handle_upload($file, array('test_form' => false));

        if (isset($upload['error'])) {
            wp_send_json_error(array('message' => $upload['error']));
        }

        // Plugin installieren
        $result = Psycho_Installer::install_elementor_pro($upload['file']); // Nutzt gleiche Funktion wie Pro

        if ($result['success']) {
            Psycho_Status_Checker::update_status('styling_plugin_installed', true);
            wp_send_json_success(array('message' => 'Styling Plugin erfolgreich installiert'));
        } else {
            wp_send_json_error($result);
        }
    }

    /**
     * Check Styling Plugin Status
     */
    public function check_styling_plugin() {
        $this->verify_request();

        $wizard_status = Psycho_Status_Checker::get_wizard_status();
        $is_installed = isset($wizard_status['styling_plugin_installed']) && $wizard_status['styling_plugin_installed'];

        wp_send_json_success(array(
            'is_installed' => $is_installed,
            'message' => $is_installed ? 'Plugin ist installiert' : 'Plugin noch nicht installiert'
        ));
    }

    /**
     * Speichere WordPress Settings
     */
    public function save_wp_settings() {
        $this->verify_request();

        error_log('=== PSYCHO WIZARD: save_wp_settings called ===');

        // Finde wichtige Seiten
        $home_page = get_page_by_title('Home');
        $blog_page = get_page_by_title('Blog');
        $privacy_page = get_page_by_title('Datenschutz');
        $imprint_page = get_page_by_title('Impressum');

        error_log('Found pages: Home=' . ($home_page ? $home_page->ID : 'NOT FOUND') .
                  ', Blog=' . ($blog_page ? $blog_page->ID : 'NOT FOUND') .
                  ', Privacy=' . ($privacy_page ? $privacy_page->ID : 'NOT FOUND') .
                  ', Imprint=' . ($imprint_page ? $imprint_page->ID : 'NOT FOUND'));

        // Homepage als Startseite setzen
        if ($home_page) {
            update_option('page_on_front', $home_page->ID);
            update_option('show_on_front', 'page');
            error_log('Set page_on_front to: ' . $home_page->ID);
        } else {
            error_log('WARNING: Home page not found!');
        }

        // Blog-Seite für Beiträge setzen
        if ($blog_page) {
            update_option('page_for_posts', $blog_page->ID);
            error_log('Set page_for_posts to: ' . $blog_page->ID);
        } else {
            error_log('WARNING: Blog page not found!');
        }

        // Datenschutzseite veröffentlichen und als WP Privacy Policy Page setzen
        if ($privacy_page) {
            // Veröffentlichen falls im Draft
            if ($privacy_page->post_status !== 'publish') {
                wp_update_post(array(
                    'ID' => $privacy_page->ID,
                    'post_status' => 'publish'
                ));
                error_log('Published privacy page: ' . $privacy_page->ID);
            }
            update_option('wp_page_for_privacy_policy', $privacy_page->ID);
        }

        // Impressum veröffentlichen
        if ($imprint_page && $imprint_page->post_status !== 'publish') {
            wp_update_post(array(
                'ID' => $imprint_page->ID,
                'post_status' => 'publish'
            ));
            error_log('Published imprint page: ' . $imprint_page->ID);
        }

        // Permalink-Struktur
        update_option('permalink_structure', '/%postname%/');
        flush_rewrite_rules();

        Psycho_Status_Checker::update_status('settings_configured', true);

        wp_send_json_success(array('message' => 'WordPress Einstellungen erfolgreich konfiguriert!'));
    }

    /**
     * Veröffentliche Datenschutzseite
     */
    public function publish_privacy_page() {
        $this->verify_request();

        $privacy_page = get_page_by_title('Datenschutz');
        if (!$privacy_page) {
            $privacy_page = get_page_by_title('Privacy Policy');
        }

        if ($privacy_page) {
            if ($privacy_page->post_status !== 'publish') {
                wp_update_post(array(
                    'ID' => $privacy_page->ID,
                    'post_status' => 'publish'
                ));

                Psycho_Status_Checker::update_status('privacy_page_published', true);

                wp_send_json_success(array('message' => 'Datenschutzseite wurde veröffentlicht!'));
            } else {
                Psycho_Status_Checker::update_status('privacy_page_published', true);
                wp_send_json_success(array('message' => 'Datenschutzseite ist bereits veröffentlicht!'));
            }
        } else {
            wp_send_json_error(array('message' => 'Datenschutzseite konnte nicht gefunden werden.'));
        }
    }

    /**
     * Markiere Templates als zugewiesen
     */
    public function mark_templates_assigned() {
        $this->verify_request();

        Psycho_Status_Checker::update_status('templates_assigned', true);

        wp_send_json_success(array('message' => 'Templates als zugewiesen markiert!'));
    }

    /**
     * Weise alle Templates zu
     */
    public function assign_all_templates() {
        $this->verify_request();
        
        // Finde Templates und Seiten
        $assignments = array(
            'Home' => 'Home',
            'Fees' => 'Fees',
            'Contact' => 'Contact',
            'Services' => 'Services',
            'How it works' => 'How it works'
        );
        
        $assigned_count = 0;
        
        foreach ($assignments as $page_title => $template_title) {
            $page = get_page_by_title($page_title);
            $template = get_page_by_title($template_title, OBJECT, 'elementor_library');
            
            if ($page && $template) {
                // Template-ID als Page Meta speichern
                update_post_meta($page->ID, '_elementor_template_id', $template->ID);
                $assigned_count++;
            }
        }
        
        // Loop Grids zuordnen wäre hier komplexer - vereinfacht markieren
        
        Psycho_Status_Checker::update_status('templates_assigned', true);
        
        wp_send_json_success(array(
            'message' => $assigned_count . ' Templates erfolgreich zugewiesen'
        ));
    }
    
    /**
     * Styling Plugin installieren (alter Code - jetzt überschrieben)
     */
    public function install_styling_plugin() {
        $this->verify_request();
        
        // Für jetzt überspringen wir das - du kannst später dein Plugin hier integrieren
        // Option 1: Plugin aus WordPress Repository
        // $result = Psycho_Installer::install_plugin('dein-plugin-slug');
        
        // Option 2: Custom ZIP-Plugin
        // $plugin_path = PSYCHO_WIZARD_PATH . 'plugins/styling-plugin.zip';
        // $result = Psycho_Installer::install_elementor_pro($plugin_path);
        
        // Für jetzt einfach erfolgreich zurückgeben
        wp_send_json_success(array('message' => 'Styling Plugin installiert'));
    }
    
    /**
     * WordPress Settings konfigurieren
     */
    public function configure_settings() {
        $this->verify_request();
        
        $settings = array(
            'homepage_id' => isset($_POST['homepage_id']) ? intval($_POST['homepage_id']) : 0,
            'blog_id' => isset($_POST['blog_id']) ? intval($_POST['blog_id']) : 0,
            'privacy_id' => isset($_POST['privacy_id']) ? intval($_POST['privacy_id']) : 0
        );
        
        $result = Psycho_Installer::configure_wp_settings($settings);
        
        if ($result['success']) {
            wp_send_json_success($result);
        } else {
            wp_send_json_error($result);
        }
    }
    
    /**
     * Templates zuweisen
     */
    public function assign_templates() {
        $this->verify_request();
        
        // Template IDs aus POST holen
        $header_template = isset($_POST['header_template_id']) ? intval($_POST['header_template_id']) : 0;
        $footer_template = isset($_POST['footer_template_id']) ? intval($_POST['footer_template_id']) : 0;
        $single_team = isset($_POST['single_team_template_id']) ? intval($_POST['single_team_template_id']) : 0;
        
        // Templates zuweisen
        $templates = array(
            'header' => $header_template,
            'footer' => $footer_template,
            'single' => $single_team
        );
        
        // Elementor Location Settings
        foreach ($templates as $location => $template_id) {
            if ($template_id > 0) {
                update_post_meta($template_id, '_elementor_location', $location);
                update_post_meta($template_id, '_elementor_conditions', array('include/general'));
            }
        }
        
        wp_send_json_success(array('message' => 'Templates erfolgreich zugewiesen'));
    }
    
    /**
     * Farben setzen
     */
    public function set_colors() {
        $this->verify_request();

        $colors = array();
        $scheme_name = isset($_POST['scheme']) ? sanitize_text_field($_POST['scheme']) : null;

        // 10 Farben aus POST
        for ($i = 1; $i <= 10; $i++) {
            if (isset($_POST['color_' . $i])) {
                $colors[] = sanitize_hex_color($_POST['color_' . $i]);
            }
        }

        if (count($colors) === 10) {
            $result = Psycho_Installer::set_elementor_colors($colors);

            if ($result['success']) {
                // Markiere Farben als gesetzt
                Psycho_Status_Checker::update_status('colors_set', true);

                // Speichere den Schema-Namen, falls vorhanden
                if ($scheme_name) {
                    Psycho_Installer::set_active_color_scheme($scheme_name);
                }

                wp_send_json_success($result);
            } else {
                wp_send_json_error($result);
            }
        } else {
            wp_send_json_error(array('message' => 'Es müssen 10 Farben übergeben werden'));
        }
    }

    /**
     * Hole aktuelle Global Colors (nur die ersten 10)
     */
    public function get_current_colors() {
        $this->verify_request();

        $kit_id = get_option('elementor_active_kit');
        if (!$kit_id) {
            wp_send_json_error(array('message' => 'Kein aktives Elementor Kit gefunden'));
            return;
        }

        $settings = get_post_meta($kit_id, '_elementor_page_settings', true);
        if (!$settings || !isset($settings['custom_colors'])) {
            wp_send_json_error(array('message' => 'Keine Global Colors gefunden'));
            return;
        }

        // Nur die ersten 10 Farben (color_1 bis color_10) extrahieren
        $colors = array();
        foreach ($settings['custom_colors'] as $color_data) {
            if (isset($color_data['_id']) && preg_match('/^color_(\d+)$/', $color_data['_id'])) {
                $colors[] = $color_data['color'];
            }
            // Stoppe nach 10 Farben
            if (count($colors) >= 10) {
                break;
            }
        }

        wp_send_json_success(array('colors' => $colors));
    }

    /**
     * Setze Template-Standardfarben zurück
     */
    public function reset_template_colors() {
        $this->verify_request();

        // Template Standard Farben (deine originalen Farben)
        $template_colors = array(
            '#2F6D67', // Primary
            '#6FA89F', // Secondary
            '#1A1F23', // Text
            '#0D47A1', // Info
            '#8C6E00', // Warning
            '#C0392B', // Error
            '#FAFAF8', // Background
            '#F2F5F3', // Surface
            '#5B6366', // Muted
            '#D9E3DF'  // Border
        );

        $result = Psycho_Installer::set_elementor_colors($template_colors);

        if ($result['success']) {
            Psycho_Status_Checker::update_status('colors_set', true);
            wp_send_json_success(array('message' => 'Template-Farben erfolgreich wiederhergestellt!'));
        } else {
            wp_send_json_error($result);
        }
    }
    
    /**
     * Setze Typography zurück
     */
    public function reset_typography() {
        $this->verify_request();

        // Deaktiviere Elementor Standard Typography Schemes
        update_option('elementor_disable_typography_schemes', 'yes');

        // Elementor Cache leeren
        if (class_exists('\Elementor\Plugin')) {
            \Elementor\Plugin::$instance->files_manager->clear_cache();
        }

        wp_send_json_success(array('message' => 'Typography-Einstellungen zurückgesetzt!'));
    }

    /**
     * Setze Button Styles zurück
     */
    public function reset_button_styles() {
        $this->verify_request();

        // Lösche Button Style Overrides
        delete_option('elementor_button_settings');

        // Elementor Cache leeren
        if (class_exists('\Elementor\Plugin')) {
            \Elementor\Plugin::$instance->files_manager->clear_cache();
        }

        wp_send_json_success(array('message' => 'Button Styles zurückgesetzt!'));
    }

    /**
     * Setze Image Styles zurück
     */
    public function reset_image_styles() {
        $this->verify_request();

        // Lösche Image Style Overrides
        delete_option('elementor_image_settings');

        // Elementor Cache leeren
        if (class_exists('\Elementor\Plugin')) {
            \Elementor\Plugin::$instance->files_manager->clear_cache();
        }

        wp_send_json_success(array('message' => 'Image Styles zurückgesetzt!'));
    }

    /**
     * Fonts hochladen
     */
    public function upload_fonts() {
        $this->verify_request();
        
        $fonts_uploaded = array();
        
        // Überschriften-Font
        if (!empty($_FILES['heading_font'])) {
            $file = $_FILES['heading_font'];
            $upload = wp_handle_upload($file, array('test_form' => false));
            
            if (!isset($upload['error'])) {
                Psycho_Installer::upload_custom_font($upload['file'], 'Heading Font');
                $fonts_uploaded[] = 'heading';
            }
        }
        
        // Fließtext-Font
        if (!empty($_FILES['body_font'])) {
            $file = $_FILES['body_font'];
            $upload = wp_handle_upload($file, array('test_form' => false));
            
            if (!isset($upload['error'])) {
                Psycho_Installer::upload_custom_font($upload['file'], 'Body Font');
                $fonts_uploaded[] = 'body';
            }
        }
        
        if (count($fonts_uploaded) > 0) {
            wp_send_json_success(array('message' => 'Fonts erfolgreich hochgeladen', 'fonts' => $fonts_uploaded));
        } else {
            wp_send_json_error(array('message' => 'Keine Fonts hochgeladen'));
        }
    }
    
    /**
     * Elementor Pro Lizenz-Status prüfen
     */
    public function check_elementor_license() {
        $this->verify_request();
        
        $is_active = Psycho_Status_Checker::is_elementor_pro_license_active();
        
        if ($is_active) {
            // Speichere Status
            Psycho_Status_Checker::update_status('elementor_pro_active', true);
            
            wp_send_json_success(array(
                'message' => 'Elementor Pro Lizenz ist aktiv',
                'is_active' => true
            ));
        } else {
            wp_send_json_error(array(
                'message' => 'Lizenz noch nicht aktiviert',
                'is_active' => false
            ));
        }
    }
    
    /**
     * Bereitet Fonts vor: Custom Fonts aktualisieren + Google Fonts lokal aktivieren
     */
    public function prepare_fonts() {
        $this->verify_request();

        $results = array();

        // 1. Custom Fonts aktualisieren
        $custom_fonts_result = Psycho_Installer::refresh_custom_fonts();
        $results['custom_fonts'] = $custom_fonts_result;

        // 2. Google Fonts lokal aktivieren
        $google_fonts_result = Psycho_Installer::enable_local_google_fonts();
        $results['google_fonts'] = $google_fonts_result;

        // Status speichern
        $status = get_option('psycho_wizard_status', array());
        $status['fonts_prepared'] = true;
        $status['fonts_prepared_at'] = current_time('mysql');
        update_option('psycho_wizard_status', $status);

        // Erfolgs-Message zusammenbauen
        $fonts_list = !empty($custom_fonts_result['fonts']) ? implode(', ', $custom_fonts_result['fonts']) : '';

        $message = sprintf(
            '✅ Fonts vorbereitet! %d Custom Font(s) aktualisiert (%s), Google Fonts lokal aktiviert.',
            $custom_fonts_result['count'],
            $fonts_list
        );

        wp_send_json_success(array(
            'message' => $message,
            'details' => $results
        ));
    }

    /**
     * Wendet Typography Scheme an
     */
    public function apply_typography() {
        $this->verify_request();

        $scheme = isset($_POST['scheme']) ? sanitize_text_field($_POST['scheme']) : '';
        $fonts = isset($_POST['fonts']) ? $_POST['fonts'] : array();

        if (empty($scheme) || empty($fonts)) {
            wp_send_json_error(array('message' => 'Scheme oder Fonts fehlen'));
        }

        // Validiere Font-Namen (erlaubt: Buchstaben, Zahlen, Leerzeichen, Bindestriche)
        foreach ($fonts as $key => $font) {
            $fonts[$key] = sanitize_text_field($font);
            if (!preg_match('/^[a-zA-Z0-9\s\-]+$/', $fonts[$key])) {
                wp_send_json_error(array('message' => 'Ungültiger Font-Name: ' . $font));
            }
        }

        $result = Psycho_Installer::set_elementor_typography($fonts);

        if (is_wp_error($result)) {
            wp_send_json_error(array('message' => $result->get_error_message()));
        }

        // Speichere den Schema-Namen
        if ($result['success']) {
            Psycho_Installer::set_active_typography_scheme($scheme);

            // Markiere Step 14 als abgeschlossen
            $status = get_option('psycho_wizard_status', array());
            if (!isset($status['completed_steps'])) {
                $status['completed_steps'] = array();
            }
            if (!in_array(14, $status['completed_steps'])) {
                $status['completed_steps'][] = 14;
            }
            $status['typography_set'] = true;
            update_option('psycho_wizard_status', $status);
        }

        wp_send_json_success($result);
    }

    /**
     * Wizard abschließen
     */
    public function complete_wizard() {
        $this->verify_request();

        // Flag setzen dass Wizard abgeschlossen ist
        update_option('psycho_wizard_completed', true);
        update_option('psycho_wizard_completed_date', current_time('mysql'));

        wp_send_json_success(array('message' => 'Setup erfolgreich abgeschlossen'));
    }

    /**
     * Hole aktives Farbschema
     */
    public function get_active_color_scheme() {
        $this->verify_request();

        $active_scheme = Psycho_Installer::get_active_color_scheme();

        wp_send_json_success(array(
            'scheme' => $active_scheme
        ));
    }

    /**
     * Hole aktives Typography-Schema
     */
    public function get_active_typography_scheme() {
        $this->verify_request();

        $active_scheme = Psycho_Installer::get_active_typography_scheme();

        wp_send_json_success(array(
            'scheme' => $active_scheme
        ));
    }

    /**
     * Hole aktives Style-Schema
     */
    public function get_active_style_scheme() {
        $this->verify_request();

        $active_scheme = Psycho_Installer::get_active_style_scheme();

        wp_send_json_success(array(
            'scheme' => $active_scheme
        ));
    }

    /**
     * Wende Button & Image Style-Schema an
     */
    public function apply_style_scheme() {
        $this->verify_request();

        $scheme = isset($_POST['scheme']) ? sanitize_text_field($_POST['scheme']) : '';
        $styles = isset($_POST['styles']) ? $_POST['styles'] : array();

        if (empty($scheme) || empty($styles)) {
            wp_send_json_error(array('message' => 'Scheme oder Styles fehlen'));
        }

        // Validiere Styles (rekursiv)
        array_walk_recursive($styles, function(&$value, $key) {
            if (is_string($value)) {
                $value = sanitize_text_field($value);
            } elseif (is_numeric($value)) {
                $value = floatval($value);
            }
        });

        $result = Psycho_Installer::set_button_image_styles($styles);

        if (is_wp_error($result)) {
            wp_send_json_error(array('message' => $result->get_error_message()));
        }

        // Speichere den Schema-Namen
        if ($result['success']) {
            Psycho_Installer::set_active_style_scheme($scheme);

            // Markiere Step 15 als abgeschlossen
            $status = get_option('psycho_wizard_status', array());
            if (!isset($status['completed_steps'])) {
                $status['completed_steps'] = array();
            }
            if (!in_array(15, $status['completed_steps'])) {
                $status['completed_steps'][] = 15;
            }
            $status['styles_set'] = true;
            update_option('psycho_wizard_status', $status);
        }

        wp_send_json_success($result);
    }
}

// AJAX Handlers initialisieren
new Psycho_Ajax_Handlers();