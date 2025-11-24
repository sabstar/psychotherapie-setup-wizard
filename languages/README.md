# Mehrsprachigkeit / Internationalization (i18n)

## Verfügbare Sprachen

Das Plugin unterstützt derzeit:
- 🇩🇪 **Deutsch** (de_DE) - Standardsprache
- 🇬🇧 **Englisch** (en_US)

## Sprache wechseln

### Methode 1: WordPress-Einstellungen
1. Gehe zu **Einstellungen → Allgemein**
2. Wähle unter **Sprache der Website** deine gewünschte Sprache
3. Speichern - das Plugin verwendet automatisch die gewählte Sprache

### Methode 2: wp-config.php
Füge in `wp-config.php` hinzu:
```php
define('WPLANG', 'de_DE'); // Deutsch
// oder
define('WPLANG', 'en_US'); // Englisch
```

## Übersetzungen anpassen

### Mit Poedit (Desktop-App - empfohlen)
1. Lade [Poedit](https://poedit.net/) herunter und installiere es
2. Öffne die gewünschte `.po`-Datei:
   - `psycho-wizard-de_DE.po` für Deutsch
   - `psycho-wizard-en_US.po` für Englisch
3. Bearbeite die Übersetzungen
4. Speichern - Poedit kompiliert automatisch die `.mo`-Datei

### Mit Loco Translate (WordPress-Plugin)
1. Installiere das Plugin [Loco Translate](https://wordpress.org/plugins/loco-translate/)
2. Gehe zu **Loco Translate → Plugins → Psychotherapie Template Kit - Setup Wizard**
3. Wähle die Sprache aus und bearbeite die Übersetzungen direkt im Browser
4. Speichern - die `.mo`-Datei wird automatisch erstellt

## Neue Sprache hinzufügen

### Mit Poedit
1. Öffne `psycho-wizard.pot` in Poedit
2. Erstelle eine neue Übersetzung: **Datei → Neue Übersetzung von POT**
3. Wähle die Zielsprache (z.B. Französisch)
4. Übersetze alle Strings
5. Speichere als `psycho-wizard-fr_FR.po` (für Französisch)
6. Poedit erstellt automatisch die `.mo`-Datei

### Mit Loco Translate
1. Gehe zu **Loco Translate → Plugins → Psychotherapie Template Kit - Setup Wizard**
2. Klicke auf **Neue Sprache**
3. Wähle die Sprache und beginne mit der Übersetzung

## Dateien im Überblick

```
languages/
├── psycho-wizard.pot           # Template (nicht bearbeiten!)
├── psycho-wizard-de_DE.po      # Deutsche Übersetzung (editierbar)
├── psycho-wizard-de_DE.mo      # Deutsche Übersetzung (kompiliert)
├── psycho-wizard-en_US.po      # Englische Übersetzung (editierbar)
├── psycho-wizard-en_US.mo      # Englische Übersetzung (kompiliert)
└── README.md                   # Diese Datei
```

## Wichtige Hinweise

- **Niemals die `.mo`-Dateien direkt bearbeiten** - sie sind binär und werden automatisch generiert
- **Die `.pot`-Datei ist das Master-Template** - sie wird bei Plugin-Updates aktualisiert
- **Bearbeite immer nur die `.po`-Dateien** - sie sind lesbar und editierbar
- **Nach Änderungen an `.po`-Dateien** muss die `.mo`-Datei neu kompiliert werden (automatisch in Poedit/Loco Translate)

## Manuelle MO-Kompilierung (für Fortgeschrittene)

Falls du die `.mo`-Dateien manuell kompilieren musst:

```bash
cd /pfad/zum/plugin/languages
msgfmt -o psycho-wizard-de_DE.mo psycho-wizard-de_DE.po
msgfmt -o psycho-wizard-en_US.mo psycho-wizard-en_US.po
```

**Voraussetzung:** gettext muss installiert sein (`brew install gettext` auf macOS)

## Support

Bei Fragen zur Mehrsprachigkeit:
- Prüfe die [WordPress i18n Dokumentation](https://developer.wordpress.org/apis/internationalization/)
- Nutze [Poedit](https://poedit.net/) für komfortable Übersetzungsverwaltung
- Für Live-Übersetzungen: [Loco Translate Plugin](https://wordpress.org/plugins/loco-translate/)
