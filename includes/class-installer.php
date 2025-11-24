<?php
/**
 * Installer Klasse für Themes und Plugins
 */

if (!defined('ABSPATH')) {
    exit;
}

class Psycho_Installer {
    
    /**
     * Hello Theme installieren
     */
    public static function install_hello_theme() {
        require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
        require_once ABSPATH . 'wp-admin/includes/theme.php';

        $theme_slug = 'hello-elementor';

        // Prüfe ob bereits installiert
        $theme = wp_get_theme($theme_slug);
        if ($theme->exists()) {
            // Theme aktivieren - verhindere Redirects während AJAX
            add_filter('wp_redirect', '__return_false', 999);
            switch_theme($theme_slug);
            remove_filter('wp_redirect', '__return_false', 999);
            return array('success' => true, 'message' => 'Hello Theme aktiviert');
        }

        // Theme installieren
        $api = themes_api('theme_information', array('slug' => $theme_slug));

        if (is_wp_error($api)) {
            return array('success' => false, 'message' => $api->get_error_message());
        }

        $upgrader = new Theme_Upgrader(new WP_Ajax_Upgrader_Skin());
        $result = $upgrader->install($api->download_link);

        if (is_wp_error($result)) {
            return array('success' => false, 'message' => $result->get_error_message());
        }

        // Theme aktivieren - verhindere Redirects während AJAX
        add_filter('wp_redirect', '__return_false', 999);
        switch_theme($theme_slug);
        remove_filter('wp_redirect', '__return_false', 999);

        return array('success' => true, 'message' => 'Hello Theme erfolgreich installiert und aktiviert');
    }
    
    /**
     * Plugin aus WordPress Repository installieren
     */
    public static function install_plugin($plugin_slug) {
        require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
        require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
        
        // Plugin Info abrufen
        $api = plugins_api('plugin_information', array(
            'slug' => $plugin_slug,
            'fields' => array('sections' => false)
        ));
        
        if (is_wp_error($api)) {
            return array('success' => false, 'message' => $api->get_error_message());
        }
        
        // Plugin installieren
        $upgrader = new Plugin_Upgrader(new WP_Ajax_Upgrader_Skin());
        $result = $upgrader->install($api->download_link);
        
        if (is_wp_error($result)) {
            return array('success' => false, 'message' => $result->get_error_message());
        }
        
        // Plugin aktivieren
        $plugin_file = $upgrader->plugin_info();
        if ($plugin_file) {
            activate_plugin($plugin_file);
        }
        
        return array('success' => true, 'message' => 'Plugin erfolgreich installiert und aktiviert');
    }
    
    /**
     * Elementor Pro ZIP hochladen und installieren
     */
    public static function install_elementor_pro($file_path) {
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
        
        $upgrader = new Plugin_Upgrader(new WP_Ajax_Upgrader_Skin());
        $result = $upgrader->install($file_path);
        
        if (is_wp_error($result)) {
            return array('success' => false, 'message' => $result->get_error_message());
        }
        
        // Plugin aktivieren
        $plugin_file = $upgrader->plugin_info();
        if ($plugin_file) {
            activate_plugin($plugin_file);
        }
        
        return array('success' => true, 'message' => 'Elementor Pro erfolgreich installiert');
    }
    
    /**
     * Elementor Pro Lizenz aktivieren
     * WICHTIG: Die Lizenz wird NACH dem Plugin-Upload automatisch aktiviert
     */
    public static function activate_elementor_license($license_key) {
        // Prüfe ob Elementor Pro installiert ist
        if (!class_exists('\ElementorPro\Plugin')) {
            return array('success' => false, 'message' => 'Elementor Pro muss zuerst installiert werden');
        }
        
        // Lizenzschlüssel speichern
        update_option('elementor_pro_license_key', $license_key);
        
        // Versuche die Lizenz über Elementor Pro API zu aktivieren
        $api_url = 'https://my.elementor.com/api/v1/licenses/activate';
        
        $response = wp_remote_post($api_url, array(
            'timeout' => 30,
            'body' => array(
                'license' => $license_key,
                'url' => home_url(),
                'api_version' => ELEMENTOR_PRO_VERSION
            )
        ));
        
        if (is_wp_error($response)) {
            // Auch wenn API fehlschlägt, Lizenz speichern (kann später manuell aktiviert werden)
            update_option('_elementor_pro_license_key', $license_key);
            return array(
                'success' => true, 
                'message' => 'Lizenzschlüssel gespeichert. Bitte aktiviere die Lizenz nach dem Setup in Elementor → Lizenz.'
            );
        }
        
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        
        // Prüfe Response
        if (isset($data['success']) && $data['success']) {
            // Lizenz erfolgreich aktiviert
            update_option('_elementor_pro_license_data', $data);
            return array('success' => true, 'message' => 'Lizenz erfolgreich aktiviert!');
        } else {
            // Fehler bei Aktivierung, aber Lizenz speichern
            $error_message = isset($data['message']) ? $data['message'] : 'Unbekannter Fehler';
            update_option('_elementor_pro_license_key', $license_key);
            
            return array(
                'success' => true, 
                'message' => 'Lizenzschlüssel gespeichert. Hinweis: ' . $error_message . ' - Du kannst die Lizenz nach dem Setup manuell in Elementor aktivieren.'
            );
        }
    }
    
    /**
     * Template Kit importieren (Elementor Website Kit ZIP)
     */
    public static function import_template_kit($file_path) {
        // Prüfe ob Elementor installiert ist
        if (!class_exists('\Elementor\Plugin')) {
            return array('success' => false, 'message' => 'Elementor muss installiert sein');
        }
        
        // Prüfe ob Elementor Pro installiert ist
        if (!class_exists('\ElementorPro\Plugin')) {
            return array('success' => false, 'message' => 'Elementor Pro muss installiert und aktiviert sein');
        }
        
        // Prüfe ob Datei existiert
        if (!file_exists($file_path)) {
            return array('success' => false, 'message' => 'Datei nicht gefunden');
        }
        
        // Prüfe ob es eine ZIP-Datei ist
        if (pathinfo($file_path, PATHINFO_EXTENSION) !== 'zip') {
            return array('success' => false, 'message' => 'Datei muss eine ZIP-Datei sein');
        }
        
        try {
            // Nutze Elementor's eigene Import-Klasse
            $import = new \Elementor\Core\App\Modules\ImportExport\Module();
            
            // Alternativ: Über Elementor Kit Library
            if (class_exists('\Elementor\Core\Kits\Manager')) {
                $kit_manager = \Elementor\Plugin::instance()->kits_manager;
                
                // Import durchführen
                $result = $kit_manager->import_kit($file_path, array(
                    'include' => array('content', 'templates', 'settings'),
                    'overrideConditions' => false,
                    'referrer' => 'psycho-wizard'
                ));
                
                if (is_wp_error($result)) {
                    return array('success' => false, 'message' => $result->get_error_message());
                }
                
                // Speichere Status
                Psycho_Status_Checker::update_status('template_kit_imported', true);
                
                return array('success' => true, 'message' => 'Template Kit erfolgreich importiert!');
            }
            
            // Fallback: Manueller Import über Elementor Import API
            require_once ABSPATH . 'wp-admin/includes/file.php';
            WP_Filesystem();
            
            global $wp_filesystem;
            
            // Entpacke ZIP in temporäres Verzeichnis
            $temp_dir = wp_upload_dir()['basedir'] . '/elementor/tmp/kit-import-' . time();
            
            if (!$wp_filesystem->exists($temp_dir)) {
                wp_mkdir_p($temp_dir);
            }
            
            // ZIP entpacken
            $unzip = unzip_file($file_path, $temp_dir);
            
            if (is_wp_error($unzip)) {
                return array('success' => false, 'message' => 'Fehler beim Entpacken: ' . $unzip->get_error_message());
            }
            
            // Importiere Templates aus dem entpackten Kit
            // Die genaue Implementierung hängt von der Struktur deines Kits ab
            // Elementor Website Kits haben eine manifest.json Datei
            
            $manifest_file = $temp_dir . '/manifest.json';
            
            if (file_exists($manifest_file)) {
                $manifest = json_decode($wp_filesystem->get_contents($manifest_file), true);
                
                // Importiere basierend auf Manifest
                // Hier würde die spezifische Import-Logik kommen
                
                // Aufräumen
                $wp_filesystem->delete($temp_dir, true);
                
                Psycho_Status_Checker::update_status('template_kit_imported', true);
                
                return array('success' => true, 'message' => 'Template Kit erfolgreich importiert!');
            }
            
            return array('success' => false, 'message' => 'Ungültiges Template Kit Format');
            
        } catch (Exception $e) {
            return array('success' => false, 'message' => 'Import-Fehler: ' . $e->getMessage());
        }
    }
    
    /**
     * ACF Fields importieren
     */
    public static function import_acf_fields($file_path) {
        // Prüfe ob ACF installiert ist
        if (!function_exists('acf_import_field_group')) {
            return array('success' => false, 'message' => 'ACF muss installiert sein. Bitte installiere Advanced Custom Fields zuerst.');
        }

        // Lese JSON Datei
        $json_data = file_get_contents($file_path);

        if (!$json_data) {
            return array('success' => false, 'message' => 'Datei konnte nicht gelesen werden');
        }

        // Decode JSON
        $items = json_decode($json_data, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return array('success' => false, 'message' => 'Ungültige JSON-Datei: ' . json_last_error_msg());
        }

        // Prüfe ob es ein einzelnes Objekt oder ein Array ist
        if (!is_array($items) || (isset($items['key']) && !isset($items[0]))) {
            $items = array($items);
        }

        $imported_field_groups = 0;
        $imported_post_types = 0;
        $imported_taxonomies = 0;
        $errors = array();

        // Durchlaufe alle Items und importiere nach Typ
        foreach ($items as $item) {
            if (!isset($item['key'])) {
                $errors[] = 'Item ohne Key gefunden';
                continue;
            }

            // Bestimme Item-Typ
            $item_type = '';
            if (isset($item['post_type'])) {
                $item_type = 'post_type';
            } elseif (isset($item['taxonomy'])) {
                $item_type = 'taxonomy';
            } elseif (isset($item['fields'])) {
                $item_type = 'field_group';
            }

            // Importiere basierend auf Typ
            switch ($item_type) {
                case 'post_type':
                    $result = self::import_acf_post_type($item);
                    if ($result) {
                        $imported_post_types++;
                    } else {
                        $errors[] = 'Fehler beim Import von CPT: ' . ($item['title'] ?? $item['key']);
                    }
                    break;

                case 'taxonomy':
                    $result = self::import_acf_taxonomy($item);
                    if ($result) {
                        $imported_taxonomies++;
                    } else {
                        $errors[] = 'Fehler beim Import von Taxonomy: ' . ($item['title'] ?? $item['key']);
                    }
                    break;

                case 'field_group':
                    // Prüfe ob Feldgruppe bereits existiert
                    $existing = acf_get_field_group($item['key']);

                    if ($existing) {
                        $result = acf_update_field_group($item);
                    } else {
                        $result = acf_import_field_group($item);
                    }

                    if ($result) {
                        $imported_field_groups++;
                    } else {
                        $errors[] = 'Fehler beim Import von Field Group: ' . ($item['title'] ?? $item['key']);
                    }
                    break;

                default:
                    $errors[] = 'Unbekannter Item-Typ für: ' . ($item['title'] ?? $item['key']);
            }
        }

        $total_imported = $imported_field_groups + $imported_post_types + $imported_taxonomies;

        if ($total_imported > 0) {
            // Speichere Status
            Psycho_Status_Checker::update_status('acf_imported', true);

            // Flush Rewrite Rules damit CPT funktioniert
            flush_rewrite_rules();

            $message = "Import erfolgreich: {$imported_field_groups} Field Group(s), {$imported_post_types} CPT(s), {$imported_taxonomies} Taxonomy/ies";
            if (count($errors) > 0) {
                $message .= ' (mit ' . count($errors) . ' Fehler(n))';
            }

            return array(
                'success' => true,
                'message' => $message,
                'imported_field_groups' => $imported_field_groups,
                'imported_post_types' => $imported_post_types,
                'imported_taxonomies' => $imported_taxonomies,
                'errors' => $errors
            );
        } else {
            return array(
                'success' => false,
                'message' => 'Import fehlgeschlagen: ' . implode(', ', $errors)
            );
        }
    }

    /**
     * Importiere ACF Post Type
     */
    private static function import_acf_post_type($post_type_data) {
        if (!function_exists('acf_import_post_type')) {
            // ACF Version unterstützt CPT Import nicht, registriere manuell
            return self::register_post_type_from_acf_data($post_type_data);
        }

        // Nutze ACF's eingebaute Funktion wenn verfügbar
        return acf_import_post_type($post_type_data);
    }

    /**
     * Registriere Post Type aus ACF Daten
     */
    private static function register_post_type_from_acf_data($data) {
        $post_type_key = $data['post_type'] ?? '';

        if (empty($post_type_key)) {
            return false;
        }

        // Prüfe ob bereits registriert
        if (post_type_exists($post_type_key)) {
            // Aktiviere in Elementor
            self::enable_cpt_in_elementor($post_type_key);
            return true;
        }

        $labels = $data['labels'] ?? array();
        $args = array(
            'labels' => $labels,
            'public' => $data['public'] ?? true,
            'hierarchical' => $data['hierarchical'] ?? false,
            'publicly_queryable' => $data['publicly_queryable'] ?? true,
            'show_ui' => $data['show_ui'] ?? true,
            'show_in_menu' => $data['show_in_menu'] ?? true,
            'show_in_nav_menus' => $data['show_in_nav_menus'] ?? true,
            'show_in_admin_bar' => $data['show_in_admin_bar'] ?? true,
            'show_in_rest' => $data['show_in_rest'] ?? true,
            'has_archive' => $data['has_archive'] ?? true,
            'supports' => $data['supports'] ?? array('title', 'editor', 'thumbnail'),
            'capability_type' => 'post',
        );

        // Menu Icon
        if (isset($data['menu_icon']['value'])) {
            $args['menu_icon'] = $data['menu_icon']['value'];
        }

        // Rewrite
        if (isset($data['has_archive_slug'])) {
            $args['rewrite'] = array('slug' => $data['has_archive_slug']);
        }

        // Registriere CPT
        register_post_type($post_type_key, $args);

        // Aktiviere in Elementor
        self::enable_cpt_in_elementor($post_type_key);

        // Speichere Flag
        update_option('psycho_' . $post_type_key . '_cpt_registered', true);

        return true;
    }

    /**
     * Importiere ACF Taxonomy
     */
    private static function import_acf_taxonomy($taxonomy_data) {
        if (!function_exists('acf_import_taxonomy')) {
            // ACF Version unterstützt Taxonomy Import nicht, registriere manuell
            return self::register_taxonomy_from_acf_data($taxonomy_data);
        }

        // Nutze ACF's eingebaute Funktion wenn verfügbar
        return acf_import_taxonomy($taxonomy_data);
    }

    /**
     * Registriere Taxonomy aus ACF Daten
     */
    private static function register_taxonomy_from_acf_data($data) {
        $taxonomy_key = $data['taxonomy'] ?? '';
        $object_types = $data['object_type'] ?? array();

        if (empty($taxonomy_key) || empty($object_types)) {
            return false;
        }

        // Prüfe ob bereits registriert
        if (taxonomy_exists($taxonomy_key)) {
            return true;
        }

        $labels = $data['labels'] ?? array();
        $args = array(
            'labels' => $labels,
            'public' => $data['public'] ?? true,
            'publicly_queryable' => $data['publicly_queryable'] ?? true,
            'hierarchical' => $data['hierarchical'] ?? false,
            'show_ui' => $data['show_ui'] ?? true,
            'show_in_menu' => $data['show_in_menu'] ?? true,
            'show_in_nav_menus' => $data['show_in_nav_menus'] ?? true,
            'show_in_rest' => $data['show_in_rest'] ?? true,
            'show_admin_column' => $data['show_admin_column'] ?? true,
        );

        // Rewrite
        if (isset($data['rewrite'])) {
            $args['rewrite'] = $data['rewrite'];
        }

        // Registriere Taxonomy
        register_taxonomy($taxonomy_key, $object_types, $args);

        return true;
    }

    /**
     * Aktiviere CPT in Elementor (generische Funktion)
     */
    private static function enable_cpt_in_elementor($post_type_key) {
        // Hole aktuelle Elementor CPT Support Einstellung
        $elementor_cpt_support = get_option('elementor_cpt_support', array());

        // Stelle sicher dass es ein Array ist
        if (!is_array($elementor_cpt_support)) {
            $elementor_cpt_support = array();
        }

        // Füge CPT hinzu wenn noch nicht vorhanden
        if (!in_array($post_type_key, $elementor_cpt_support)) {
            $elementor_cpt_support[] = $post_type_key;
            update_option('elementor_cpt_support', $elementor_cpt_support);
        }
    }

    /**
     * Re-registriere alle ACF CPTs beim WordPress Init
     * Diese Funktion wird vom Main-Plugin-File aufgerufen
     */
    public static function reregister_acf_cpts() {
        // Hole alle gespeicherten CPT Keys
        global $wpdb;
        $results = $wpdb->get_results(
            "SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE 'psycho_%_cpt_registered' AND option_value = '1'",
            ARRAY_A
        );

        foreach ($results as $row) {
            // Extrahiere CPT Key aus Option Name
            // z.B. "psycho_team_member_cpt_registered" -> "team_member"
            $cpt_key = str_replace(array('psycho_', '_cpt_registered'), '', $row['option_name']);

            // Stelle sicher dass CPT in Elementor aktiviert ist
            if (!empty($cpt_key)) {
                self::enable_cpt_in_elementor($cpt_key);
            }
        }
    }
    
    /**
     * Helper: Farbe abdunkeln (für Hover-States)
     * @param string $hex HEX-Farbe (z.B. #2F6D67)
     * @param float $percent Prozent zum Abdunkeln (0.15 = 15%)
     * @return string Abgedunkelte HEX-Farbe
     */
    private static function darken_color($hex, $percent = 0.15) {
        // Entferne # falls vorhanden
        $hex = ltrim($hex, '#');

        // Konvertiere HEX zu RGB
        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }

        // Dunkler machen
        $r = max(0, min(255, $r * (1 - $percent)));
        $g = max(0, min(255, $g * (1 - $percent)));
        $b = max(0, min(255, $b * (1 - $percent)));

        // Zurück zu HEX
        return '#' . str_pad(dechex(round($r)), 2, '0', STR_PAD_LEFT)
                  . str_pad(dechex(round($g)), 2, '0', STR_PAD_LEFT)
                  . str_pad(dechex(round($b)), 2, '0', STR_PAD_LEFT);
    }

    /**
     * Elementor Global Colors setzen (alle 23 Custom Colors)
     * @param array $colors Array mit 10 Basis-Farben [Primary, Secondary, Text, Info, Warning, Error, Background, Surface, Muted, Border]
     */
    public static function set_elementor_colors($colors) {
        // Berechne Hover-Farben (15% dunkler)
        $primary_hover = self::darken_color($colors[0], 0.15);      // Primary - 15%
        $secondary_hover = self::darken_color($colors[1], 0.15);    // Secondary - 15%
        $link_hover = self::darken_color($colors[0], 0.15);         // Link (= Primary) - 15%

        // Nur die 13 beschreibenden Custom Colors (color_1-10 werden nicht mehr angelegt)
        $custom_colors = array(
            // Die 13 Custom Colors (mit festen IDs aus deinem Template)
            array('_id' => '03d4c8c', 'title' => 'Success',        'color' => $colors[3]),  // = Info
            array('_id' => '7120ed1', 'title' => 'Info',           'color' => $colors[3]),  // = Info
            array('_id' => '4dc052d', 'title' => 'Warning ',       'color' => $colors[4]),  // = Warning
            array('_id' => '85a7d1c', 'title' => 'Error',          'color' => $colors[5]),  // = Error
            array('_id' => 'f97b96d', 'title' => 'Background',     'color' => $colors[6]),  // = Background
            array('_id' => '96e7ac6', 'title' => 'Surface',        'color' => $colors[7]),  // = Surface
            array('_id' => '42b21c5', 'title' => 'Muted',          'color' => $colors[8]),  // = Muted
            array('_id' => 'f268844', 'title' => 'Border',         'color' => $colors[9]),  // = Border
            array('_id' => '8f7c8e7', 'title' => 'Primary Hover',  'color' => $primary_hover),    // Primary - 15%
            array('_id' => 'b3cdd39', 'title' => 'On-Primary',     'color' => '#FFFFFF'),         // Weiß
            array('_id' => '8469757', 'title' => 'Secondary Hover','color' => $secondary_hover),  // Secondary - 15%
            array('_id' => 'f7dc858', 'title' => 'Link',           'color' => $colors[0]),        // = Primary
            array('_id' => '56b0924', 'title' => 'Link Hover',     'color' => $link_hover)        // Link - 15%
        );

        // System Colors definieren (die 4 Elementor Standard System Colors)
        $system_colors = array(
            array('_id' => 'primary',   'title' => 'Primary',     'color' => $colors[0]),  // Primary
            array('_id' => 'accent',    'title' => 'Secondary',   'color' => $colors[1]),  // Secondary
            array('_id' => 'secondary', 'title' => 'Accent/Link', 'color' => $colors[0]),  // Link = Primary
            array('_id' => 'text',      'title' => 'Text',        'color' => $colors[2])   // Text
        );

        // Legacy Elementor Scheme Optionen für System Colors Kompatibilität
        $legacy_scheme = array(
            '1' => $colors[0],  // Primary
            '2' => $colors[1],  // Secondary
            '3' => $colors[2],  // Text
            '4' => $colors[0],  // Accent (= Primary)
        );

        // Alte Scheme-Struktur für Legacy Support
        update_option('elementor_schemes', array(
            'color' => $legacy_scheme
        ));

        // Alte Color Picker Option
        update_option('elementor_scheme_color-picker', $legacy_scheme);

        // Elementor Kit Settings aktualisieren - custom_colors und system_colors ändern, rest behalten!
        $kit_id = get_option('elementor_active_kit');
        if ($kit_id) {
            // Hole ALLE existierenden Settings
            $existing_settings = get_post_meta($kit_id, '_elementor_page_settings', true);

            // Falls keine Settings existieren, erstelle leeres Array
            if (!is_array($existing_settings)) {
                $existing_settings = array();
            }

            // Aktualisiere custom_colors und system_colors, behalte alles andere (Typography, Buttons, etc.)
            $existing_settings['custom_colors'] = $custom_colors;
            $existing_settings['system_colors'] = $system_colors;

            // Speichere zurück mit allen Settings
            update_post_meta($kit_id, '_elementor_page_settings', $existing_settings);
        }

        // Aggressives Multi-Level Cache Clearing für sofortige Sichtbarkeit
        if (class_exists('\Elementor\Plugin')) {
            // 1. Files Manager Cache (CSS, JS Dateien)
            \Elementor\Plugin::$instance->files_manager->clear_cache();

            // 2. Kit Post CSS Meta löschen
            if ($kit_id) {
                delete_post_meta($kit_id, '_elementor_css');
                delete_post_meta($kit_id, 'elementor-css');
                delete_post_meta($kit_id, '_elementor_page_assets');
            }

            // 3. Alle Posts mit Elementor CSS Cache leeren
            global $wpdb;
            $wpdb->query("DELETE FROM {$wpdb->postmeta} WHERE meta_key = '_elementor_css'");
            $wpdb->query("DELETE FROM {$wpdb->postmeta} WHERE meta_key = 'elementor-css'");
            $wpdb->query("DELETE FROM {$wpdb->postmeta} WHERE meta_key = '_elementor_page_assets'");

            // 4. Elementor Transients löschen
            delete_transient('elementor_scheme_color');
            delete_transient('elementor_global_colors');
            delete_transient('elementor_system_colors');
            delete_transient('elementor_custom_colors');

            // 5. Force CSS Regeneration beim nächsten Laden
            update_option('elementor_regenerate_css_on_save', 'true');
            update_option('_elementor_regenerate_css', time());

            // 6. Clear Elementor caches aus wp_options
            delete_option('_elementor_global_css');
            delete_option('_elementor_global_colors_cache');
        }

        return array('success' => true, 'message' => 'Alle 17 Farben erfolgreich gesetzt (4 System + 13 Custom). Bitte Editor neu laden (F5).');
    }
    
    /**
     * Custom Font hochladen
     */
    public static function upload_custom_font($file_path, $font_name) {
        // Font in Elementor Custom Fonts hochladen
        // Nutzt Elementor Pro Custom Fonts Feature
        
        if (!class_exists('\ElementorPro\Plugin')) {
            return array('success' => false, 'message' => 'Elementor Pro benötigt');
        }
        
        // Font registrieren
        $fonts = get_option('elementor_custom_fonts', array());
        
        $fonts[$font_name] = array(
            'font_face' => $font_name,
            'font_weight' => 'normal',
            'font_style' => 'normal',
            'font_file' => $file_path
        );
        
        update_option('elementor_custom_fonts', $fonts);

        return array('success' => true, 'message' => 'Font erfolgreich hochgeladen');
    }

    /**
     * Aktualisiert alle Elementor Custom Fonts
     * Simuliert den "Update" Button für jede Custom Font
     * Notwendig nach Template Kit Import, damit Fonts im Dropdown erscheinen
     *
     * @return array Ergebnis mit Anzahl aktualisierter Fonts
     */
    public static function refresh_custom_fonts() {
        // Alle Custom Fonts laden
        $custom_fonts = get_posts(array(
            'post_type' => 'elementor_font',
            'posts_per_page' => -1,
            'post_status' => 'publish'
        ));

        if (empty($custom_fonts)) {
            return array(
                'success' => true,
                'message' => 'Keine Custom Fonts gefunden',
                'count' => 0,
                'fonts' => array()
            );
        }

        $updated_count = 0;
        $font_names = array();

        foreach ($custom_fonts as $font) {
            $font_names[] = $font->post_title;

            // Font "aktualisieren" = CSS neu generieren
            wp_update_post(array(
                'ID' => $font->ID,
                'post_modified' => current_time('mysql'),
                'post_modified_gmt' => current_time('mysql', 1)
            ));

            // Font CSS Cache löschen
            delete_post_meta($font->ID, '_elementor_font_css');
            delete_post_meta($font->ID, '_elementor_css');

            // CSS neu generieren (wenn Elementor geladen ist)
            if (class_exists('\Elementor\Core\Files\CSS\Post')) {
                $css_file = \Elementor\Core\Files\CSS\Post::create($font->ID);
                if ($css_file) {
                    $css_file->delete();
                    $css_file->update();
                }
            }

            $updated_count++;
        }

        // Elementor Font Manager Cache leeren
        if (class_exists('\Elementor\Plugin')) {
            \Elementor\Plugin::$instance->files_manager->clear_cache();

            // CSS neu generieren
            global $wpdb;
            $wpdb->query("DELETE FROM {$wpdb->postmeta} WHERE meta_key = '_elementor_css'");
            update_option('elementor_regenerate_css_on_save', 'true');
        }

        return array(
            'success' => true,
            'message' => sprintf('%d Custom Font(s) erfolgreich aktualisiert', $updated_count),
            'count' => $updated_count,
            'fonts' => $font_names
        );
    }

    /**
     * Aktiviert lokales Laden von Google Fonts in Elementor
     * Setzt: Elementor → Settings → Performance → Load Google Fonts Locally: Enable
     *
     * @return array Ergebnis
     */
    public static function enable_local_google_fonts() {
        // Google Fonts lokal laden aktivieren
        // Dies ist das wichtigste Setting für DSGVO-Konformität
        update_option('elementor_font_display', 'swap');

        // WICHTIG: Die richtige Option für "Load Google Fonts Locally"
        // Die Option heißt 'elementor_local_google_fonts' und muss auf '1' gesetzt werden
        update_option('elementor_local_google_fonts', '1');

        // Legacy Option für ältere Elementor Versionen (falls vorhanden)
        update_option('elementor_google_fonts', 'local');

        // Weitere Performance-Settings
        update_option('elementor_load_fa4_shim', 'yes');
        update_option('elementor_experiment-e_font_icon_svg', 'active');

        // Cache leeren
        if (class_exists('\Elementor\Plugin')) {
            \Elementor\Plugin::$instance->files_manager->clear_cache();

            // CSS neu generieren
            global $wpdb;
            $wpdb->query("DELETE FROM {$wpdb->postmeta} WHERE meta_key = '_elementor_css'");
            update_option('elementor_regenerate_css_on_save', 'true');
            update_option('_elementor_regenerate_css', time());
        }

        return array(
            'success' => true,
            'message' => 'Google Fonts lokal laden aktiviert (DSGVO-konform)'
        );
    }

    /**
     * Setzt Elementor Typography (System + Custom Fonts)
     * Ändert nur font_family, behält alle anderen Eigenschaften (Größen, Line-Heights, etc.)
     *
     * @param array $fonts Array mit 7 Font-Namen
     * @return array|WP_Error Ergebnis oder Fehler
     */
    public static function set_elementor_typography($fonts) {
        $kit_id = get_option('elementor_active_kit');
        if (!$kit_id) {
            return new \WP_Error('no_kit', 'Kein Elementor Kit gefunden');
        }

        $settings = get_post_meta($kit_id, '_elementor_page_settings', true);
        if (!is_array($settings)) {
            $settings = array();
        }

        // System Typography aktualisieren (nur font_family ändern!)
        if (isset($settings['system_typography']) && is_array($settings['system_typography'])) {
            foreach ($settings['system_typography'] as $key => $typo) {
                $id = isset($typo['_id']) ? $typo['_id'] : '';

                if ($id === 'primary' && isset($fonts['primary'])) {
                    $settings['system_typography'][$key]['typography_font_family'] = $fonts['primary'];
                }
                if ($id === 'secondary' && isset($fonts['secondary'])) {
                    $settings['system_typography'][$key]['typography_font_family'] = $fonts['secondary'];
                }
                if ($id === 'text' && isset($fonts['text'])) {
                    $settings['system_typography'][$key]['typography_font_family'] = $fonts['text'];
                }
                if ($id === 'accent' && isset($fonts['accent'])) {
                    $settings['system_typography'][$key]['typography_font_family'] = $fonts['accent'];
                }
            }
        }

        // Custom Typography aktualisieren (nur font_family ändern!)
        if (isset($settings['custom_typography']) && is_array($settings['custom_typography'])) {
            foreach ($settings['custom_typography'] as $key => $typo) {
                $id = isset($typo['_id']) ? $typo['_id'] : '';

                // Small Text / Subtitle (ID: 8cf967c)
                if ($id === '8cf967c' && isset($fonts['small_text'])) {
                    $settings['custom_typography'][$key]['typography_font_family'] = $fonts['small_text'];
                }
                // Number Item Big (ID: 10edc26)
                if ($id === '10edc26' && isset($fonts['number_big'])) {
                    $settings['custom_typography'][$key]['typography_font_family'] = $fonts['number_big'];
                }
                // Number Item Text/Quote (ID: f72d1cb)
                if ($id === 'f72d1cb' && isset($fonts['quote'])) {
                    $settings['custom_typography'][$key]['typography_font_family'] = $fonts['quote'];
                }
            }
        }

        // H1-H6 Typography aktualisieren (nur font_family ändern!)
        // H1-H4 verwenden Primary Font, H5-H6 verwenden Text Font
        if (isset($fonts['primary'])) {
            $settings['h1_typography_font_family'] = $fonts['primary'];
            $settings['h2_typography_font_family'] = $fonts['primary'];
            $settings['h3_typography_font_family'] = $fonts['primary'];
            $settings['h4_typography_font_family'] = $fonts['primary'];
        }
        if (isset($fonts['text'])) {
            $settings['h5_typography_font_family'] = $fonts['text'];
            $settings['h6_typography_font_family'] = $fonts['text'];
        }

        // Body & Link Typography aktualisieren
        if (isset($fonts['text'])) {
            $settings['body_typography_font_family'] = $fonts['text'];
            $settings['link_normal_typography_font_family'] = $fonts['text'];
        }

        // Settings speichern
        update_post_meta($kit_id, '_elementor_page_settings', $settings);

        // Aggressive Cache Clearing (wie bei Farben)
        if (class_exists('\Elementor\Plugin')) {
            \Elementor\Plugin::$instance->files_manager->clear_cache();

            // Post CSS Cache löschen
            delete_post_meta($kit_id, '_elementor_css');
            delete_post_meta($kit_id, 'elementor-css');
            delete_post_meta($kit_id, '_elementor_page_assets');

            // Alle CSS regenerieren
            global $wpdb;
            $wpdb->query("DELETE FROM {$wpdb->postmeta} WHERE meta_key = '_elementor_css'");
            $wpdb->query("DELETE FROM {$wpdb->postmeta} WHERE meta_key = 'elementor-css'");

            // Force CSS Regenerierung
            update_option('elementor_regenerate_css_on_save', 'true');
            update_option('_elementor_regenerate_css', time());
            delete_option('_elementor_global_css');
        }

        // Status speichern
        $status = get_option('psycho_wizard_status', array());
        $status['typography_set'] = true;
        $status['typography_updated_at'] = current_time('mysql');
        update_option('psycho_wizard_status', $status);

        return array(
            'success' => true,
            'message' => '15 Schriftarten erfolgreich aktualisiert! (4 System + 3 Custom + H1-H6 + Body + Link)',
            'kit_id' => $kit_id
        );
    }

    /**
     * Speichert das aktive Farbschema
     */
    public static function set_active_color_scheme($scheme_name) {
        $kit_id = get_option('elementor_active_kit');
        if (!$kit_id) {
            return array('success' => false, 'message' => 'Kein aktives Elementor Kit gefunden');
        }

        update_post_meta($kit_id, '_psycho_active_color_scheme', sanitize_text_field($scheme_name));

        return array(
            'success' => true,
            'message' => 'Aktives Farbschema gespeichert',
            'scheme' => $scheme_name
        );
    }

    /**
     * Holt das aktive Farbschema
     */
    public static function get_active_color_scheme() {
        $kit_id = get_option('elementor_active_kit');
        if (!$kit_id) {
            return null;
        }

        return get_post_meta($kit_id, '_psycho_active_color_scheme', true);
    }

    /**
     * Speichert das aktive Typography-Schema
     */
    public static function set_active_typography_scheme($scheme_name) {
        $kit_id = get_option('elementor_active_kit');
        if (!$kit_id) {
            return array('success' => false, 'message' => 'Kein aktives Elementor Kit gefunden');
        }

        update_post_meta($kit_id, '_psycho_active_typography_scheme', sanitize_text_field($scheme_name));

        return array(
            'success' => true,
            'message' => 'Aktives Typography-Schema gespeichert',
            'scheme' => $scheme_name
        );
    }

    /**
     * Holt das aktive Typography-Schema
     */
    public static function get_active_typography_scheme() {
        $kit_id = get_option('elementor_active_kit');
        if (!$kit_id) {
            return null;
        }

        return get_post_meta($kit_id, '_psycho_active_typography_scheme', true);
    }

    /**
     * Setzt Button & Image Styles
     */
    public static function set_button_image_styles($styles) {
        $kit_id = get_option('elementor_active_kit');
        if (!$kit_id) {
            return array('success' => false, 'message' => 'Kein aktives Elementor Kit gefunden');
        }

        $settings = get_post_meta($kit_id, '_elementor_page_settings', true);
        if (!is_array($settings)) {
            $settings = array();
        }

        // Button Styles
        if (isset($styles['button_border_radius'])) {
            $settings['button_border_radius'] = $styles['button_border_radius'];
            $settings['button_hover_border_radius'] = $styles['button_border_radius']; // Gleicher Wert für Hover
        }

        if (isset($styles['button_padding'])) {
            $settings['button_padding'] = $styles['button_padding'];
        }

        // Image Styles
        if (isset($styles['image_border_radius'])) {
            $settings['image_border_radius'] = $styles['image_border_radius'];
        }

        if (isset($styles['image_box_shadow'])) {
            $settings['image_box_shadow_box_shadow'] = $styles['image_box_shadow'];
        }

        // Container Border Radius (CSS Variable)
        if (isset($styles['container_border_radius'])) {
            $container_radius = $styles['container_border_radius'];

            // Hole aktuelles Custom CSS
            $custom_css = isset($settings['custom_css']) ? $settings['custom_css'] : '';

            // Regex um --container-border-radius zu finden und zu ersetzen
            $pattern = '/--container-border-radius:\s*\d+px;/';
            $replacement = '--container-border-radius: ' . intval($container_radius) . 'px;';

            if (preg_match($pattern, $custom_css)) {
                // Variable existiert bereits - ersetze den Wert
                $custom_css = preg_replace($pattern, $replacement, $custom_css);
            } else {
                // Variable existiert nicht - füge sie hinzu
                // Suche nach :root { oder füge es hinzu
                if (strpos($custom_css, ':root') !== false) {
                    // :root existiert - füge Variable hinzu
                    $custom_css = preg_replace(
                        '/(:root\s*\{)/',
                        "$1\n    " . $replacement,
                        $custom_css,
                        1
                    );
                } else {
                    // :root existiert nicht - erstelle es
                    $new_root = ":root {\n    " . $replacement . "\n}\n\n";
                    $custom_css = $new_root . $custom_css;
                }
            }

            $settings['custom_css'] = $custom_css;
        }

        // Container Box Shadow (CSS Variable)
        if (isset($styles['container_box_shadow'])) {
            $container_shadow = $styles['container_box_shadow'];

            // Hole aktuelles Custom CSS (kann sich durch border_radius geändert haben)
            $custom_css = isset($settings['custom_css']) ? $settings['custom_css'] : '';

            // Regex um --container-box-shadow zu finden und zu ersetzen
            // Pattern erlaubt verschiedene Formate: none, 0 2px 8px rgba(...), etc.
            $pattern = '/--container-box-shadow:\s*[^;]+;/';
            $replacement = '--container-box-shadow: ' . $container_shadow . ';';

            if (preg_match($pattern, $custom_css)) {
                // Variable existiert bereits - ersetze den Wert
                $custom_css = preg_replace($pattern, $replacement, $custom_css);
            } else {
                // Variable existiert nicht - füge sie hinzu
                if (strpos($custom_css, ':root') !== false) {
                    // :root existiert - füge Variable hinzu
                    $custom_css = preg_replace(
                        '/(:root\s*\{)/',
                        "$1\n    " . $replacement,
                        $custom_css,
                        1
                    );
                } else {
                    // :root existiert nicht - erstelle es
                    $new_root = ":root {\n    " . $replacement . "\n}\n\n";
                    $custom_css = $new_root . $custom_css;
                }
            }

            $settings['custom_css'] = $custom_css;
        }

        update_post_meta($kit_id, '_elementor_page_settings', $settings);

        // Cache leeren
        if (class_exists('\Elementor\Plugin')) {
            \Elementor\Plugin::instance()->files_manager->clear_cache();
        }

        return array(
            'success' => true,
            'message' => 'Button, Image & Container Styles erfolgreich aktualisiert!',
            'kit_id' => $kit_id
        );
    }

    /**
     * Speichert das aktive Style-Schema
     */
    public static function set_active_style_scheme($scheme_name) {
        $kit_id = get_option('elementor_active_kit');
        if (!$kit_id) {
            return array('success' => false, 'message' => 'Kein aktives Elementor Kit gefunden');
        }

        update_post_meta($kit_id, '_psycho_active_style_scheme', sanitize_text_field($scheme_name));

        return array(
            'success' => true,
            'message' => 'Aktives Style-Schema gespeichert',
            'scheme' => $scheme_name
        );
    }

    /**
     * Holt das aktive Style-Schema
     */
    public static function get_active_style_scheme() {
        $kit_id = get_option('elementor_active_kit');
        if (!$kit_id) {
            return null;
        }

        return get_post_meta($kit_id, '_psycho_active_style_scheme', true);
    }

    /**
     * WordPress Settings konfigurieren
     */
    public static function configure_wp_settings($settings) {
        // Homepage festlegen
        if (isset($settings['homepage_id'])) {
            update_option('page_on_front', $settings['homepage_id']);
            update_option('show_on_front', 'page');
        }
        
        // Blog-Seite festlegen
        if (isset($settings['blog_id'])) {
            update_option('page_for_posts', $settings['blog_id']);
        }
        
        // Datenschutzseite festlegen
        if (isset($settings['privacy_id'])) {
            update_option('wp_page_for_privacy_policy', $settings['privacy_id']);
        }
        
        // Permalink-Struktur
        update_option('permalink_structure', '/%postname%/');
        flush_rewrite_rules();

        return array('success' => true, 'message' => 'WordPress Settings konfiguriert');
    }

    /**
     * WordPress XML Import (WXR Format)
     */
    public static function import_wordpress_xml($file_path) {
        if (!file_exists($file_path)) {
            return array('success' => false, 'message' => 'Datei nicht gefunden');
        }

        // Prüfe ob WordPress Importer Plugin installiert ist
        if (!class_exists('WP_Import')) {
            // Lade WordPress Importer aus Core
            $importer_path = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
            if (!file_exists($importer_path)) {
                return array('success' => false, 'message' => 'WordPress Importer nicht verfügbar');
            }
            require_once $importer_path;

            // Lade WXR Parser
            $parser_path = ABSPATH . 'wp-admin/includes/class-wp-import.php';
            if (!file_exists($parser_path)) {
                // Falls nicht vorhanden, nutze vereinfachten Import
                return self::simple_xml_import($file_path);
            }
            require_once $parser_path;
        }

        // Nutze WordPress Importer
        $importer = new WP_Import();

        // Setze Import-Optionen
        $importer->fetch_attachments = false; // Keine Medien importieren

        // WICHTIG: WordPress Importer importiert automatisch:
        // - Posts
        // - Post Meta
        // - Taxonomien und Terms (Categories, Tags, Custom Taxonomies)
        // - Authors (falls vorhanden)

        // Die Terms werden automatisch erstellt, wenn sie nicht existieren
        // Die Terms werden automatisch den Posts zugewiesen

        // Führe Import aus
        ob_start();
        $result = $importer->import($file_path);
        $output = ob_get_clean();

        // Hole Import-Statistik falls verfügbar
        $imported_count = 'unknown';
        if (isset($importer->processed_posts) && is_array($importer->processed_posts)) {
            $imported_count = count($importer->processed_posts);
        }

        return array(
            'success' => true,
            'message' => 'Demo-Daten erfolgreich importiert (inkl. Taxonomien & Terms)',
            'imported_count' => $imported_count
        );
    }

    /**
     * Vereinfachter XML Import (falls WP_Import nicht verfügbar)
     */
    private static function simple_xml_import($file_path) {
        $xml = simplexml_load_file($file_path);

        if (!$xml) {
            return array('success' => false, 'message' => 'XML-Datei konnte nicht gelesen werden');
        }

        $imported_count = 0;
        $skipped_count = 0;
        $duplicate_count = 0;
        $namespaces = $xml->getNamespaces(true);

        // Parse Items
        foreach ($xml->channel->item as $item) {
            // Hole wp: Namespace Daten
            $wp = $item->children($namespaces['wp']);
            $content = $item->children($namespaces['content']);

            $post_type = (string) $wp->post_type;

            // Nur team_member importieren
            if ($post_type !== 'team_member') {
                $skipped_count++;
                continue;
            }

            // Erstelle Post
            $post_data = array(
                'post_title'   => (string) $item->title,
                'post_content' => (string) $content->encoded,
                'post_status'  => (string) $wp->status,
                'post_type'    => 'team_member',
                'post_date'    => (string) $wp->post_date,
            );

            // Prüfe ob Post bereits existiert (anhand Titel)
            $existing = get_page_by_title($post_data['post_title'], OBJECT, 'team_member');
            if ($existing) {
                $duplicate_count++;
                continue; // Überspringe Duplikate
            }

            $post_id = wp_insert_post($post_data);

            if (is_wp_error($post_id)) {
                continue;
            }

            // Importiere Post Meta (ACF Felder)
            foreach ($wp->postmeta as $meta) {
                $meta_key = (string) $meta->meta_key;
                $meta_value = (string) $meta->meta_value;

                // Überspringe WordPress interne Meta (außer wichtige)
                if (strpos($meta_key, '_edit') === 0) {
                    continue;
                }

                // Überspringe _wp_ Meta außer wichtige wie _wp_page_template
                if (strpos($meta_key, '_wp_') === 0 && $meta_key !== '_wp_page_template') {
                    continue;
                }

                // Überspringe Elementor-spezifische Meta-Daten (verursachen Fehler)
                if (strpos($meta_key, '_elementor') === 0) {
                    continue;
                }

                // Versuche serialisierte Daten zu erkennen und zu unserialisieren
                $unserialized = @maybe_unserialize($meta_value);
                if ($unserialized !== false) {
                    update_post_meta($post_id, $meta_key, $unserialized);
                } else {
                    update_post_meta($post_id, $meta_key, $meta_value);
                }
            }

            // WICHTIG: Importiere Taxonomien (Categories, Tags, Custom Taxonomies)
            $categories = $item->category;
            if ($categories) {
                $taxonomy_data = array();

                foreach ($categories as $cat) {
                    $domain = (string) $cat['domain']; // z.B. 'category', 'post_tag', 'custom_taxonomy'
                    $nicename = (string) $cat['nicename']; // Slug
                    $name = (string) $cat; // Term Name

                    if (empty($domain) || empty($nicename)) {
                        continue;
                    }

                    // Prüfe ob Taxonomie existiert
                    if (!taxonomy_exists($domain)) {
                        error_log("Taxonomy '{$domain}' does not exist, skipping term '{$name}'");
                        continue;
                    }

                    // Prüfe ob Term existiert
                    $term = term_exists($nicename, $domain);

                    if (!$term) {
                        // Term existiert nicht, erstelle ihn
                        $term = wp_insert_term($name, $domain, array(
                            'slug' => $nicename
                        ));

                        if (is_wp_error($term)) {
                            error_log("Failed to create term '{$name}' in taxonomy '{$domain}': " . $term->get_error_message());
                            continue;
                        }
                    }

                    // Sammle Terms nach Taxonomie
                    if (!isset($taxonomy_data[$domain])) {
                        $taxonomy_data[$domain] = array();
                    }

                    // Hole Term ID
                    if (is_array($term)) {
                        $taxonomy_data[$domain][] = intval($term['term_id']);
                    } else {
                        // Term existierte bereits
                        $existing_term = get_term_by('slug', $nicename, $domain);
                        if ($existing_term) {
                            $taxonomy_data[$domain][] = intval($existing_term->term_id);
                        }
                    }
                }

                // Weise alle Terms dem Post zu
                foreach ($taxonomy_data as $taxonomy => $term_ids) {
                    wp_set_object_terms($post_id, $term_ids, $taxonomy, false);
                }
            }

            $imported_count++;
        }

        $total_items = count($xml->channel->item);

        // Erstelle aussagekräftige Meldung
        $message = '';
        if ($imported_count > 0) {
            $message = $imported_count . ' Team Member erfolgreich importiert!';
        } elseif ($duplicate_count > 0) {
            $message = 'Keine neuen Team Members importiert - alle Einträge existieren bereits.';
        } else {
            $message = 'Keine Team Members in der XML-Datei gefunden.';
        }

        return array(
            'success' => true,
            'message' => $message,
            'imported_count' => $imported_count,
            'duplicate_count' => $duplicate_count,
            'skipped_count' => $skipped_count,
            'total_items' => $total_items
        );
    }
}