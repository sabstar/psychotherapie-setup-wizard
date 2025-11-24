# Psychotherapie Template Kit - Setup Wizard

Ein professioneller Setup-Wizard für WordPress, der deine Kunden durch die komplette Installation deines Template Kits führt.

## 📁 Plugin-Struktur

```
psychotherapie-setup-wizard/
├── psychotherapie-setup-wizard.php    # Haupt-Plugin-Datei
├── README.md                          # Diese Datei
├── BENUTZER-ANLEITUNG.md             # Detaillierte Anleitung (Deutsch)
├── USER-GUIDE.md                      # Detailed Guide (English)
├── includes/
│   ├── class-wizard.php              # Wizard Hauptklasse
│   ├── class-installer.php           # Installation-Funktionen
│   ├── class-ajax-handlers.php       # AJAX Requests Handler
│   ├── class-status-checker.php      # Status Validation
│   └── class-waiting-badge.php       # Waiting Badge Manager
├── assets/
│   ├── css/
│   │   └── wizard.css               # Wizard Styles
│   ├── js/
│   │   ├── wizard.js                # Wizard JavaScript
│   │   └── waiting-badge.js         # Badge Cookie & Close Logic
│   └── images/                       # Wizard Icons
├── templates/
│   ├── wizard-page.php              # Wizard Main Page
│   ├── admin-waiting-badge.php      # Waiting Badge Settings
│   ├── admin-recovery.php           # Wizard Recovery Tool
│   └── steps/                       # Individual Wizard Steps
└── languages/
    └── psycho-wizard-de_DE.l10n.php # German Translations
```

## 🚀 Installation

### 1. Plugin hochladen

1. ZIP-Datei des Plugins erstellen
2. In WordPress unter **Plugins → Installieren → Plugin hochladen**
3. ZIP-Datei auswählen und installieren
4. Plugin aktivieren

### 2. Automatischer Redirect

Nach der Aktivierung wird der Benutzer automatisch zum Setup-Wizard weitergeleitet.

## ⏱️ Waiting Badge Feature

Das Plugin enthält ein **Waiting Badge Management System**:

### Features
- ✅ **Admin Settings Page** - Vollständige Kontrolle über Badge-Texte und -Verhalten
- ✅ **Elementor Integration** - Shortcodes für dynamische Inhalte
- ✅ **Cookie Management** - Badge ausblenden nach Close-Click
- ✅ **Export/Import** - JSON-Export für Template Kits
- ✅ **Automatische Show/Hide Logik** - Keine Display Conditions nötig
- ✅ **Responsive** - Automatische Anpassung auf Mobile

### Verwendung

**Admin-Bereich:** WordPress → Setup Wizard → ⏱️ Waiting Badge

**Elementor Shortcodes:**
- `[waiting_badge_heading]` - Zeigt die Überschrift
- `[waiting_badge_time]` - Zeigt die Zeitangabe
- `[waiting_badge_show]...[/waiting_badge_show]` - Conditional display wrapper

**CSS-Klassen:**
- `waiting-badge-container` - Für Badge Container (Section/Container)
- `waiting-badge-close` - Für Close-Button (Icon Widget)

**Body-Klassen (automatisch):**
- `waiting-badge-enabled` - Badge ist aktiv
- `waiting-badge-disabled` - Badge ist inaktiv

### Export für Template Kits

1. Badge in Elementor designen (mit korrekten CSS-Klassen)
2. Settings exportieren: Admin → Waiting Badge → Export (JSON)
3. JSON-Datei in Template Kit ZIP packen
4. Bei Installation: JSON importieren → Badge funktioniert sofort!

## 🔧 Anpassungen für dein Template Kit

### 1. Plugin-Informationen ändern

In `psychotherapie-setup-wizard.php`:

```php
/**
 * Plugin Name: Dein Template Kit Name - Setup Wizard
 * Description: Setup Wizard für [Dein Template Kit Name]
 * Author: Dein Name
 * Author URI: https://deine-website.de
 */
```

### 2. Template Kit Import anpassen

In `includes/class-installer.php` → `import_template_kit()`:

```php
public static function import_template_kit($file_path) {
    // Hier musst du die Elementor Import API nutzen
    // Beispiel:
    
    $plugin = \Elementor\Plugin::instance();
    $templates_manager = $plugin->templates_manager;
    
    $import_data = json_decode(file_get_contents($file_path), true);
    
    foreach ($import_data as $template_data) {
        $templates_manager->import_template($template_data);
    }
    
    return array('success' => true, 'message' => 'Template Kit importiert');
}
```

### 3. Deine 10 Elementor Farben definieren

In `assets/js/wizard.js` → `colorSchemes`:

```javascript
const colorSchemes = {
    'dein-schema': {
        colors: [
            '#primary',      // Color 1 - Primary
            '#secondary',    // Color 2 - Secondary
            '#accent',       // Color 3 - Accent
            '#background1',  // Color 4 - Light Background
            '#background2',  // Color 5 - Alt Background
            '#text1',        // Color 6 - Dark Text
            '#text2',        // Color 7 - Light Text
            '#hover1',       // Color 8 - Hover State
            '#hover2',       // Color 9 - Alt Hover
            '#special'       // Color 10 - Special Color
        ]
    }
};
```

### 4. ACF Import anpassen

Stelle sicher, dass deine ACF JSON-Datei das richtige Format hat:

```json
[
    {
        "key": "group_team_members",
        "title": "Team Member Details",
        "fields": [
            {
                "key": "field_name",
                "label": "Name",
                "name": "member_name",
                "type": "text"
            }
            // ... weitere 39 Felder
        ]
    }
]
```

### 5. Styling Plugin ersetzen

In `includes/class-ajax-handlers.php` → `install_styling_plugin()`:

```php
public function install_styling_plugin() {
    // Wenn du ein Custom Plugin als ZIP hast:
    $plugin_path = PSYCHO_WIZARD_PATH . 'plugins/dein-styling-plugin.zip';
    $result = Psycho_Installer::install_elementor_pro($plugin_path);
    
    // ODER aus WordPress Repository:
    $result = Psycho_Installer::install_plugin('dein-plugin-slug');
}
```

## 📋 Benötigte Dateien vorbereiten

Deine Kunden benötigen folgende Dateien:

1. **elementor-pro.zip** - Elementor Pro Plugin
2. **elementor-lizenz-key.txt** - Ihr Lizenzschlüssel
3. **template-kit.json** - Dein exportiertes Elementor Template Kit
4. **acf-team-members.json** - ACF Feldgruppen Export
5. **demo-data.xml** (optional) - WordPress XML Export mit Demo Team Members
6. **fonts/** (optional) - TTF/OTF/WOFF2 Schriftarten

## 🎨 CSS anpassen

Die CSS-Datei (`assets/css/wizard.css`) ist identisch mit dem Style-Block aus dem HTML-Artefakt. 

Du kannst folgendes anpassen:

```css
/* Hauptfarbe des Wizards ändern */
.progress-fill,
.btn-primary,
.step.active .step-number {
    background: linear-gradient(135deg, #DEINE-FARBE-1 0%, #DEINE-FARBE-2 100%);
}
```

## 🔌 WordPress Integration Details

### Template Zuweisung

In `includes/class-ajax-handlers.php` → `assign_templates()`:

```php
// Elementor Theme Builder Locations
$locations = array(
    'header' => $header_template_id,
    'footer' => $footer_template_id,
    'single' => array(
        'team-member' => $single_team_template_id
    ),
    'archive' => array(
        'team-member' => $archive_team_template_id
    )
);

// Für jede Location
foreach ($locations as $location => $template_id) {
    update_post_meta($template_id, '_elementor_location', $location);
    update_post_meta($template_id, '_elementor_conditions', array(
        'include/general'
    ));
}
```

### Menüs erstellen

```php
// In configure_wp_settings()

// Hauptmenü erstellen
$menu_id = wp_create_nav_menu('Hauptmenü');

// Menü-Items hinzufügen
wp_update_nav_menu_item($menu_id, 0, array(
    'menu-item-title' => 'Home',
    'menu-item-object-id' => $homepage_id,
    'menu-item-object' => 'page',
    'menu-item-type' => 'post_type',
    'menu-item-status' => 'publish'
));

// Menü-Location zuweisen
set_theme_mod('nav_menu_locations', array(
    'primary' => $menu_id
));
```

## ⚙️ Erweiterte Funktionen

### Progress speichern

Wenn du möchtest, dass Benutzer den Wizard unterbrechen und später fortsetzen können:

```php
// Progress speichern
update_option('psycho_wizard_progress', array(
    'current_step' => $current_step,
    'completed_steps' => $completed_steps,
    'uploaded_files' => $uploaded_files
));

// Progress laden
$progress = get_option('psycho_wizard_progress', array());
```

### Email-Benachrichtigung

Nach Abschluss Email an Admin senden:

```php
// In complete_wizard()
$admin_email = get_option('admin_email');

wp_mail(
    $admin_email,
    'Template Kit Setup abgeschlossen',
    'Der Setup-Wizard wurde erfolgreich abgeschlossen.',
    array('Content-Type: text/html; charset=UTF-8')
);
```

### Fehler-Logging

```php
// Error Log Datei erstellen
$log_file = PSYCHO_WIZARD_PATH . 'wizard-errors.log';

function psycho_log_error($message) {
    $timestamp = current_time('mysql');
    $log_entry = "[$timestamp] $message\n";
    file_put_contents($log_file, $log_entry, FILE_APPEND);
}
```

## 🐛 Debugging

Debug-Modus aktivieren:

```php
// In psychotherapie-setup-wizard.php
define('PSYCHO_WIZARD_DEBUG', true);

// Dann in den Funktionen:
if (defined('PSYCHO_WIZARD_DEBUG') && PSYCHO_WIZARD_DEBUG) {
    error_log('Debug Info: ' . print_r($data, true));
}
```

## 📝 Testing Checklist

Vor dem Verkauf testen:

- [ ] Frische WordPress Installation (neueste Version)
- [ ] Plugin aktiviert ohne Fehler
- [ ] Redirect zum Wizard funktioniert
- [ ] Alle File-Uploads funktionieren
- [ ] Hello Theme wird installiert
- [ ] Elementor wird installiert
- [ ] Elementor Pro Upload & Lizenz-Aktivierung
- [ ] Template Kit Import funktioniert
- [ ] ACF Fields werden korrekt importiert
- [ ] Farben werden in Elementor übernommen (alle 10!)
- [ ] Fonts werden hochgeladen
- [ ] Templates werden zugewiesen
- [ ] WordPress Settings werden gesetzt
- [ ] Wizard kann abgeschlossen werden
- [ ] Notice verschwindet nach Abschluss

## 🎯 Support für deine Kunden

### Häufige Probleme

**"Upload schlägt fehl"**
- PHP upload_max_filesize erhöhen (empfohlen: 128M)
- PHP post_max_size erhöhen (empfohlen: 128M)
- PHP max_execution_time erhöhen (empfohlen: 300)

**"Elementor Pro Lizenz kann nicht aktiviert werden"**
- Lizenzschlüssel korrekt kopiert?
- Domain muss öffentlich erreichbar sein
- Firewall blockiert eventuell API-Anfragen

**"Template Kit Import funktioniert nicht"**
- Elementor muss aktiv sein
- JSON-Datei muss valide sein
- Memory Limit prüfen (empfohlen: 256M)

## 📦 Distribution

### Als ZIP verpacken

```bash
zip -r psychotherapie-setup-wizard.zip \
  psychotherapie-setup-wizard/ \
  -x "*.git*" \
  -x "*.DS_Store" \
  -x "node_modules/*"
```

### Mit Template Kit bundlen

Struktur für dein Template Kit Paket:

```
dein-template-kit/
├── psychotherapie-setup-wizard.zip
├── template-dateien/
│   ├── template-kit.json
│   ├── acf-team-members.json
│   └── demo-data.xml (optional)
├── schriftarten/
│   ├── heading-font.woff2
│   └── body-font.woff2
└── anleitung.pdf
```

## 📄 Lizenz

GPL v2 or later

## 👨‍💻 Support

Bei Fragen oder Problemen:
- Email: deine@email.de
- Support: https://deine-website.de/support