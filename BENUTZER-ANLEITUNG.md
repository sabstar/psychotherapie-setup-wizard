# Psychotherapie Setup Wizard - Benutzeranleitung

## 📋 Inhaltsverzeichnis

1. [Übersicht](#übersicht)
2. [Voraussetzungen](#voraussetzungen)
3. [Schritt-für-Schritt Anleitung](#schritt-für-schritt-anleitung)
4. [Wichtige Hinweise](#wichtige-hinweise)
5. [Troubleshooting](#troubleshooting)
6. [FAQ](#faq)

---

## 🎯 Übersicht

Der **Psychotherapie Setup Wizard** führt Sie durch die komplette Einrichtung Ihrer Psychotherapie-Website. Der Wizard besteht aus **16 Schritten** und automatisiert die Installation und Konfiguration aller benötigten Komponenten.

### Was der Wizard einrichtet:

- ✅ Hello Theme & Elementor
- ✅ Elementor Pro mit Lizenzaktivierung
- ✅ Template Kit Import
- ✅ ACF Felder für Team Members
- ✅ Team Settings & Elementor Konfiguration
- ✅ Demo-Daten (optional)
- ✅ WordPress Grundeinstellungen
- ✅ Farben, Schriftarten und Styles
- ✅ Template-Zuweisungen

### Geschätzte Dauer: 15-30 Minuten

---

## ⚙️ Voraussetzungen

Bevor Sie mit dem Setup beginnen, stellen Sie sicher, dass Sie folgendes bereit haben:

### 📁 Benötigte Dateien

1. **Elementor Pro ZIP** - Die aktuelle Elementor Pro Plugin-Datei
2. **Elementor Pro Lizenzschlüssel** - Ihr gültiger Lizenzkey
3. **Template Kit ZIP** - Ihr Elementor Website Kit als ZIP-Datei
4. **ACF JSON Datei** - Die Team Member ACF Felder (z.B. `acf-export.json`)
5. **Demo-Daten XML** (optional) - Beispiel Team Members (z.B. `team-demo.xml`)
6. **Styling Plugin ZIP** (optional) - Falls vorhanden

### 💻 Technische Anforderungen

- WordPress 5.8 oder höher
- PHP 7.4 oder höher
- MySQL 5.6 oder höher
- Mindestens 256MB PHP Memory Limit
- Aktive Internetverbindung

---

## 📖 Schritt-für-Schritt Anleitung

### Step 1: Willkommen 👋

Der Willkommensbildschirm gibt Ihnen einen Überblick über den Setup-Prozess.

**Aktionen:**
- Lesen Sie die Informationen
- Klicken Sie auf **"Los geht's →"**

**Hinweis:** Wenn Sie den Wizard unterbrechen, können Sie später über die "Fortsetzen"-Kachel an der Stelle weitermachen.

---

### Step 2: Hello Theme installieren 🎨

Das Hello Theme ist ein minimalistisches Theme, optimiert für Elementor.

**Aktionen:**
1. Klicken Sie auf **"Installieren"** neben "Hello Theme"
2. Warten Sie auf die Bestätigung (Status wird grün: "Installiert")
3. Klicken Sie auf **"Weiter →"**

**Status-Anzeige:**
- 🔘 Bereit - Theme ist noch nicht installiert
- ⏳ Installiere... - Installation läuft
- ✅ Installiert - Theme wurde erfolgreich installiert

**Progress Bubble:** Wird automatisch grün nach erfolgreicher Installation

---

### Step 3: Elementor installieren ⚙️

Elementor ist der Page Builder für Ihre Website.

**Aktionen:**
1. Klicken Sie auf **"Installieren"** neben "Elementor"
2. Warten Sie auf die Bestätigung
3. Klicken Sie auf **"Weiter →"**

**Hinweis:** Die Installation kann 30-60 Sekunden dauern.

---

### Step 4: Elementor Pro hochladen & aktivieren 🚀

Elementor Pro erweitert Elementor um professionelle Features.

**Aktionen:**
1. **Elementor Pro hochladen:**
   - Klicken Sie auf die Upload-Fläche oder ziehen Sie die ZIP-Datei per Drag & Drop
   - Warten Sie auf die Upload-Bestätigung
   - Die Lizenz-Aktivierungssektion erscheint automatisch

2. **Lizenz aktivieren:**
   - Klicken Sie auf **"Elementor Pro Lizenz aktivieren (neuer Tab)"**
   - Geben Sie Ihren Lizenzschlüssel ein und aktivieren Sie ihn
   - Kehren Sie zum Wizard-Tab zurück
   - Klicken Sie auf **"🔄 Lizenz-Status prüfen"**
   - Wenn die Lizenz aktiv ist (grüne Box), klicken Sie auf **"Weiter →"**

**Wichtig:**
- ⚠️ Die Lizenz MUSS aktiv sein, bevor Sie fortfahren können
- Die Progress Bubble wird erst grün, wenn die Lizenz aktiviert ist

**Fehlerbehebung:**
- Falls "Lizenz noch nicht aktiv" angezeigt wird, aktivieren Sie die Lizenz erneut im Elementor-Tab
- Prüfen Sie dann nochmal den Status

---

### Step 5: Template Kit importieren 📦

Ihr Elementor Website Kit enthält alle Templates, Seiten und Einstellungen.

**Aktionen:**
1. Klicken Sie auf **"🚀 Elementor Kit Import öffnen (neuer Tab)"**
2. Im Elementor-Tab:
   - Klicken Sie auf **"Upload"**
   - Wählen Sie Ihre Template Kit ZIP-Datei
   - Wählen Sie aus was importiert werden soll:
     - ✅ Templates
     - ✅ Content (Seiten)
     - ✅ Site Settings
   - Klicken Sie auf **"Import"**
   - Warten Sie bis der Import abgeschlossen ist (1-3 Minuten)
3. Kehren Sie zum Wizard-Tab zurück
4. Klicken Sie auf **"🔄 Import-Status prüfen"**

**Status-Anzeige:**
- ✅ Grüne Box - Templates wurden gefunden, Import erfolgreich
- ⚠️ Gelbe Box - Noch keine Templates gefunden, bitte zuerst importieren

**Progress Bubble:** Wird automatisch grün, wenn Templates erkannt werden

**Wichtig:**
- Der Import kann 1-3 Minuten dauern, haben Sie Geduld
- Verlassen Sie den Elementor-Tab nicht, bis der Import abgeschlossen ist

---

### Step 6: ACF Felder importieren 📝

ACF (Advanced Custom Fields) Felder definieren die Team Member Struktur.

**Aktionen:**
1. Klicken Sie auf die Upload-Fläche
2. Wählen Sie Ihre ACF JSON-Datei (z.B. `acf-export.json`)
3. Warten Sie auf die Upload-Bestätigung
4. Eine grüne Erfolgs-Notification erscheint oben rechts
5. Klicken Sie auf **"Weiter →"**

**Was wird importiert:**
- Team Member Custom Post Type
- 40+ ACF Felder für Team Member Profile
- Field Groups mit Location Rules

**Progress Bubble:** Wird automatisch grün nach erfolgreichem Upload

---

### Step 7: Team Settings konfigurieren 👥

Aktiviert Team Members in Elementor und deaktiviert Standard-Schemas.

**Aktionen:**
1. Klicken Sie auf **"⚙️ Elementor Settings öffnen (neuer Tab)"**
2. Im Elementor Settings Tab:
   - Gehen Sie zu **"CPT Support"**
   - Aktivieren Sie **"Team Member"** (Checkbox setzen)
   - Scrollen Sie zu **"Disable Default Colors"** - Auf **"Yes"** setzen
   - Scrollen Sie zu **"Disable Default Fonts"** - Auf **"Yes"** setzen
   - Klicken Sie auf **"Save Changes"**
3. Kehren Sie zum Wizard-Tab zurück
4. Klicken Sie auf **"✅ Einstellungen prüfen"**
5. Bei grüner Box: Klicken Sie auf **"Weiter →"**

**Wichtig:**
- Alle 3 Einstellungen müssen aktiv sein
- Die Prüfung validiert automatisch alle Einstellungen

---

### Step 8: Styling Plugin installieren (Optional) 🎨

Ein optionales Plugin für erweiterte Styling-Optionen.

**Aktionen (wenn vorhanden):**
1. Klicken Sie auf die Upload-Fläche
2. Laden Sie die Styling Plugin ZIP hoch
3. Warten Sie auf die Installation
4. Klicken Sie auf **"Weiter →"**

**Falls kein Plugin vorhanden:**
- Klicken Sie einfach auf **"Weiter →"**

---

### Step 9: Demo-Daten importieren (Optional) 📊

Demo Team Members helfen Ihnen, die Struktur zu verstehen.

**⚠️ WICHTIG - MEHRFACH-IMPORT VERMEIDEN:**

**Wenn bereits importiert:**
- Sie sehen eine **grüne Box** mit "✅ Demo-Daten erfolgreich importiert!"
- Eine **grüne Warnung** "⚠️ Bitte nicht erneut importieren"
- **NICHT nochmal importieren** - sonst werden Posts doppelt angelegt!
- Falls nötig, nutzen Sie den **"🔄 Zurücksetzen"** Button ERST

**Aktionen (Erstimport):**
1. Aktivieren Sie die Checkbox **"Demo Team Members importieren"**
2. Der Upload-Bereich erscheint
3. Laden Sie Ihre Demo-Daten XML hoch (z.B. `team-demo.xml`)
4. Warten Sie auf die Bestätigung (5-10 Sekunden)
5. Sie sehen:
   - ✅ **Grüne Notification oben rechts** (8 Sekunden sichtbar)
   - ✅ **Grüne Success-Box** im Step-Content
   - ✅ **Progress Bubble wird grün**

**Falls keine Demo-Daten gewünscht:**
- Klicken Sie auf **"⏭️ Überspringen (keine Demo-Daten)"**

**Progress Bubble:** Wird grün nach Import oder nach Überspringen

**Fehlerbehebung:**
- Falls versehentlich doppelt importiert: Nutzen Sie den Reset-Button

---

### Step 10: Datenschutzseite veröffentlichen 🔒

Veröffentlicht die Datenschutzseite und setzt WordPress Settings.

**Aktionen:**
1. Klicken Sie auf **"📄 Datenschutzseite jetzt veröffentlichen"**
2. Warten Sie auf die Bestätigung
3. Klicken Sie auf **"Weiter →"**

**Was passiert:**
- Datenschutzseite wird veröffentlicht
- WordPress Privacy Policy Page wird gesetzt
- Impressum wird veröffentlicht (falls vorhanden)

---

### Step 11: Templates zuweisen 🔗

Weist Elementor Templates den entsprechenden Seiten zu.

**Aktionen:**
1. Klicken Sie auf **"⚙️ Theme Builder öffnen (neuer Tab)"**
2. Im Theme Builder:
   - Weisen Sie Header-Template zu (Site Header)
   - Weisen Sie Footer-Template zu (Site Footer)
   - Weisen Sie Single Team Template zu (Single → Team Member)
   - Weisen Sie Archive Team Template zu (Archive → Team Member)
3. Kehren Sie zum Wizard zurück
4. Klicken Sie auf **"✅ Fertig - Templates zugewiesen"**

**Wichtig:** Vergessen Sie nicht, die Templates zu aktivieren (Publish)

---

### Step 12: WordPress Einstellungen 🛠️

Konfiguriert grundlegende WordPress-Einstellungen.

**Aktionen:**
1. Klicken Sie auf **"💾 Einstellungen automatisch setzen"**
2. Warten Sie auf die Bestätigung
3. Klicken Sie auf **"Weiter →"**

**Was wird konfiguriert:**
- Homepage als Startseite
- Blog-Seite für Beiträge
- Permalink-Struktur: `/%postname%/`
- Datenschutzseite als WP Privacy Policy

---

### Step 13: Farbschema wählen 🎨

Wählen Sie ein Farbschema für Ihre Website.

**Verfügbare Schemas:**
- ✨ Template Standard (Grüntöne)
- 🌾 Warme Erdtöne
- 💜 Sanfte Lavendeltöne
- 🌸 Warme Rosétöne
- 🌊 Blaugrau/Apricot
- 🕊️ Taubenblau/Beige
- 🪻 Weiches Mauve

**Aktionen:**
1. Klicken Sie auf ein Farbschema
2. Das Schema wird **sofort angewendet** (keine Wartezeit)
3. Sie sehen eine Erfolgs-Notification
4. Die Progress Bubble wird grün
5. Sie können zwischen Schemas wechseln (einfach ein anderes anklicken)
6. Klicken Sie auf **"Weiter →"** wenn zufrieden

**Features:**
- ✅ Sofortige Anwendung (kein "Apply"-Button nötig)
- ✅ Setzt 10 Basis-Farben + 3 Hover-Varianten
- ✅ Preview-Button für jeden Scheme
- ✅ Aktives Schema wird mit grünem Rahmen markiert

**Hinweis:** Sie können die Farben später in Elementor Global Colors anpassen

---

### Step 14: Schriftarten wählen 📖

Wählen Sie ein Typography-Schema für Ihre Website.

**Verfügbare Schemas:**
- 📖 Template Standard (Instrument Serif + Inter)
- 🎯 Modern Sans (Inter)
- ✨ Elegant Serif (Playfair Display + Inter)
- 😊 Warm & Friendly (Outfit + Inter)
- 💼 Professional (Montserrat + Inter)

**Aktionen:**
1. Klicken Sie auf **"🔤 Fonts vorbereiten"**
   - Lädt Custom Fonts neu
   - Aktiviert Google Fonts lokal (DSGVO-konform)
2. Klicken Sie auf ein Typography-Schema
3. Das Schema wird sofort angewendet
4. Progress Bubble wird grün
5. Klicken Sie auf **"Weiter →"**

**Was wird gesetzt:**
- Primary Font (Überschriften)
- Secondary Font
- Text Font (Fließtext)
- Accent Font
- Small Text Font
- Number Big Font
- Quote Font

---

### Step 15: Button & Image Styles (Optional) 🎭

Definiert globale Styles für Buttons und Bilder.

**Verfügbare Schemas:**
- 🎨 Template Standard
- 🔷 Modern Minimal
- ✨ Elegant Rounded
- 🎯 Bold & Clear

**Aktionen:**
1. Klicken Sie auf ein Style-Schema (optional)
2. Das Schema wird sofort angewendet
3. Oder klicken Sie auf **"Weiter (Styles beibehalten)"**

**Hinweis:** Dieser Schritt ist komplett optional

---

### Step 16: Setup abgeschlossen! 🎉

Glückwunsch! Ihr Setup ist vollständig.

**Nächste Schritte:**
1. Klicken Sie auf **"🎨 Zum Theme Builder"** - Feinschliff an Templates
2. Klicken Sie auf **"📝 Team Members verwalten"** - Eigene Team Members anlegen
3. Oder gehen Sie direkt zur **Website-Ansicht**

**Was Sie jetzt haben:**
- ✅ Vollständig konfigurierte WordPress Installation
- ✅ Elementor mit aktivierter Pro-Lizenz
- ✅ Importierte Templates und Seiten
- ✅ Konfigurierte Team Member Struktur
- ✅ Globale Farben und Schriftarten
- ✅ Zugewiesene Templates
- ✅ WordPress-Grundeinstellungen

---

## ⚠️ Wichtige Hinweise

### 🚨 Mehrfach-Imports vermeiden

**Step 9 (Demo-Daten):**
- ⚠️ **NICHT mehrfach importieren!**
- Wenn die grüne Success-Box angezeigt wird, sind die Daten bereits importiert
- Mehrfach-Import erstellt doppelte Posts → kann zu Fehlern führen
- Falls nötig: Erst **"🔄 Zurücksetzen"** klicken, dann neu importieren

**Step 5 (Template Kit):**
- Template Kits sollten nur EINMAL importiert werden
- Bei erneutem Import können Konflikte entstehen

### 💾 Status-Speicherung

Der Wizard speichert Ihren Fortschritt automatisch:
- ✅ Abgeschlossene Steps werden markiert (grüne Bubbles)
- ✅ Sie können den Wizard jederzeit verlassen und fortsetzen
- ✅ Die Welcome-Page zeigt eine "Fortsetzen"-Kachel

### 🔄 Neustart

Falls Sie von vorne beginnen möchten:
- Löschen Sie die Option `psycho_wizard_status` in der Datenbank
- Oder verwenden Sie ein Recovery-Tool (falls vorhanden)

### 🌐 Browser-Kompatibilität

Empfohlene Browser:
- ✅ Chrome/Edge (neueste Version)
- ✅ Firefox (neueste Version)
- ✅ Safari (neueste Version)
- ⚠️ Internet Explorer wird NICHT unterstützt

---

## 🔧 Troubleshooting

### Problem: Progress Bubble wird nicht grün

**Step 5 (Template Kit):**
- **Ursache:** Templates wurden noch nicht importiert oder nicht erkannt
- **Lösung:**
  1. Prüfen Sie im Elementor-Tab, ob der Import wirklich abgeschlossen ist
  2. Klicken Sie auf "🔄 Import-Status prüfen"
  3. Laden Sie die Wizard-Seite neu (F5)

**Step 9 (Demo-Daten):**
- **Lösung:** Laden Sie die Seite neu (F5)
- Der Status wird beim Laden automatisch erkannt

### Problem: Notification wird nicht angezeigt (Step 9)

**Ursachen:**
1. JavaScript-Fehler im Browser
2. Browser-Cache

**Lösung:**
1. Öffnen Sie die Browser-Console (F12)
2. Suchen Sie nach Fehlermeldungen (rot)
3. Laden Sie die Seite mit Strg+Shift+R neu (Hard Reload)
4. Prüfen Sie ob Sie diese Logs sehen:
   ```
   showNotification called: success, [Message]
   Notification added to DOM
   Notification setup complete
   ```

### Problem: Upload schlägt fehl

**Mögliche Ursachen:**
- Datei zu groß
- Falsches Dateiformat
- Server-Timeout
- PHP Memory Limit zu niedrig

**Lösung:**
1. Prüfen Sie das Dateiformat (ZIP für Plugins/Kits, XML für Demo-Daten)
2. Prüfen Sie die Dateigröße (max 50MB)
3. Erhöhen Sie das PHP Memory Limit auf 256MB oder höher
4. Kontaktieren Sie Ihren Hosting-Provider

### Problem: Elementor Pro Lizenz wird nicht erkannt

**Lösung:**
1. Aktivieren Sie die Lizenz DIREKT auf der Elementor Pro Seite
2. Warten Sie 5-10 Sekunden
3. Kehren Sie zum Wizard zurück
4. Klicken Sie auf "🔄 Lizenz-Status prüfen"
5. Falls immer noch nicht aktiv: Prüfen Sie Ihren Lizenzschlüssel

### Problem: Theme Builder Templates erscheinen nicht

**Ursache:** Template Kit wurde noch nicht importiert

**Lösung:**
1. Gehen Sie zurück zu Step 5
2. Importieren Sie das Template Kit
3. Kehren Sie zu Step 11 zurück

### Problem: ACF Felder werden nicht angezeigt

**Ursache:** ACF Plugin nicht installiert oder Felder nicht importiert

**Lösung:**
1. Prüfen Sie ob ACF Pro installiert und aktiviert ist
2. Importieren Sie die ACF JSON Datei erneut (Step 6)
3. Gehen Sie zu ACF → Field Groups und prüfen Sie ob "Team Member" Gruppe existiert

---

## ❓ FAQ

### Kann ich den Wizard mehrfach durchlaufen?

Ja, aber vorsichtig:
- ⚠️ Vermeiden Sie Mehrfach-Imports (Step 5, Step 9)
- ✅ Farben, Fonts und Styles können beliebig oft geändert werden
- ⚠️ Template-Zuweisungen überschreiben vorherige Einstellungen

### Kann ich einzelne Steps überspringen?

- Ja, die meisten Steps können übersprungen werden
- ⚠️ **Pflicht-Steps:** 1-4 (Hello Theme, Elementor, Elementor Pro)
- ⚠️ Ohne Template Kit (Step 5) fehlen Templates
- ⚠️ Ohne ACF (Step 6) fehlen Team Member Felder

### Was passiert wenn ich den Wizard schließe?

- ✅ Ihr Fortschritt wird automatisch gespeichert
- ✅ Abgeschlossene Steps bleiben grün markiert
- ✅ Sie können jederzeit fortsetzen (Welcome Page → "Fortsetzen")

### Wie lange sind die Notifications sichtbar?

- 8 Sekunden (automatisches Verschwinden)
- Sie können mehrere Notifications gleichzeitig sehen
- Notifications erscheinen oben rechts

### Kann ich die Farben/Fonts später ändern?

Ja, absolut:
- **Farben:** Elementor → Site Settings → Global Colors
- **Fonts:** Elementor → Site Settings → Custom Fonts / Typography
- **Styles:** Elementor → Site Settings → Buttons / Images

### Was passiert bei Fehlern während des Imports?

- ❌ Eine rote Error-Notification wird angezeigt
- ❌ Der Step wird NICHT als abgeschlossen markiert
- ✅ Sie können den Import wiederholen
- ✅ Prüfen Sie die Browser-Console (F12) für Details

### Wie kann ich Demo-Daten wieder löschen?

1. Gehen Sie zu Step 9
2. Klicken Sie auf **"🔄 Demo-Daten zurücksetzen"**
3. Bestätigen Sie die Aktion
4. Alle Demo Team Members werden gelöscht
5. Sie können neu importieren (falls gewünscht)

### Werden meine Daten überschrieben?

**Nein, wenn Sie vorsichtig sind:**
- ✅ Neue Installations → Keine Daten zum Überschreiben
- ⚠️ Bei bestehendem Content: Mehrfach-Import vermeiden
- ⚠️ Template-Zuweisungen überschreiben vorherige Assignments

### Kann ich den Wizard auf einer Live-Site verwenden?

- ⚠️ **Nicht empfohlen** auf produktiven Sites
- ✅ Besser: Staging-Umgebung oder frische WordPress-Installation
- ⚠️ Templates und Settings werden überschrieben

---

## ⏱️ Waiting Badge Verwaltung

Nach Abschluss des Setups steht Ihnen ein **Waiting Badge Feature** zur Verfügung, mit dem Sie Ihre aktuelle Wartezeit prominent auf der Website anzeigen können.

### Zugriff auf die Einstellungen

1. WordPress Admin → **Setup Wizard → ⏱️ Waiting Badge**

### Funktionen

**Badge aktivieren/deaktivieren:**
- Toggle-Switch zum An/Ausschalten
- Wird sofort auf der Website sichtbar/unsichtbar

**Anpassbare Texte:**
- **Überschrift:** z.B. "Waiting time", "Wartezeit", "Verfügbarkeit"
- **Zeitangabe:** z.B. "8-10 weeks", "6-8 Wochen", "Ab sofort"

**Position wählen:**
- Unten Links oder Unten Rechts
- Fixed Position (scrollt mit)

**Cookie-Dauer:**
- Bestimmt wie lange das Badge nach dem Wegklicken versteckt bleibt (1-365 Tage)

### Elementor Integration

Das Waiting Badge wird vollständig in Elementor gestaltet:

**1. Badge Container erstellen (Section/Container):**
- CSS-Klasse hinzufügen: `waiting-badge-container`

**2. Texte via Shortcodes einfügen:**
- Heading Widget: `[waiting_badge_heading]`
- Heading Widget: `[waiting_badge_time]`

**3. Close-Button hinzufügen:**
- Icon Widget mit CSS-Klasse: `waiting-badge-close`

**4. Farben automatisch:**
- Alle Elementor Global Colors werden automatisch verwendet

### Show/Hide Logik

**Automatische Sichtbarkeitssteuerung:**
- Badge wird NUR angezeigt wenn in den Settings aktiviert
- Keine Elementor Display Conditions nötig!
- Cookie-basiertes Ausblenden nach Close-Click

**Body-Klassen:**
- `waiting-badge-enabled` - Badge ist aktiviert
- `waiting-badge-disabled` - Badge ist deaktiviert

### Export / Import

**Settings exportieren:**
- Perfekt für Template Kits!
- JSON-Datei mit allen Badge-Einstellungen
- Enthält: Texte, Position, Cookie-Dauer, Aktivierungsstatus

**Settings importieren:**
- JSON-Datei hochladen
- Alle Einstellungen werden übernommen

**Verwendung in Template Kits:**
1. Badge in Elementor designen (mit korrekten CSS-Klassen)
2. Settings exportieren (JSON-Datei)
3. In Template Kit ZIP packen
4. Bei Installation: JSON importieren → Badge funktioniert sofort!

### Technische Details

**JavaScript:**
- Cookie-Management
- Close-Button Funktion
- Fade-Out Animation
- ESC-Taste zum Schließen
- Responsive (kleinere Badge auf Mobile)

**Position:**
- Fixed Positioning via JavaScript
- Überschreibt Elementor Position
- Z-Index: 9999 (immer im Vordergrund)

### Beispiel-Setup

1. **Elementor öffnen** (beliebige Seite)
2. **Container hinzufügen** (Fixed Position)
3. **CSS-Klasse setzen:** `waiting-badge-container`
4. **Heading hinzufügen:** `[waiting_badge_heading]`
5. **Heading hinzufügen:** `[waiting_badge_time]`
6. **Icon hinzufügen** mit Klasse: `waiting-badge-close`
7. **Farben & Styles** über Elementor Global Colors
8. **Als Template speichern** (Optional: In Header/Footer einbauen)

### Häufige Fragen

**Muss ich Display Conditions in Elementor setzen?**
- Nein! Das Badge wird automatisch via PHP/JS ein-/ausgeblendet

**Kann ich mehrere Badges haben?**
- Nein, nur ein Badge pro Site (Cookie-Name ist hardcoded)

**Was passiert wenn ich das Badge deaktiviere?**
- Badge wird sofort auf der gesamten Website ausgeblendet
- Keine Änderungen in Elementor nötig

**Wie ändere ich das Design?**
- Im Elementor Template bearbeiten (Farben, Schriftarten, Padding, etc.)
- Settings ändern nur Texte und Position

**Funktioniert das mit Caching?**
- Ja! Cookie-Check läuft client-side (JavaScript)
- Kein Server-Side-Rendering nötig

---

## 📞 Support

Bei Fragen oder Problemen:

1. **Prüfen Sie diese Anleitung** - Die meisten Fragen werden hier beantwortet
2. **Browser Console** (F12) - Zeigt technische Fehler
3. **WordPress Debug Log** - Aktivieren Sie WP_DEBUG für Details
4. **Kontaktieren Sie Ihren Administrator** - Bei technischen Problemen

---

## ✅ Checkliste: Erfolgreiches Setup

Nach Abschluss sollten Sie haben:

- [ ] Hello Theme ist aktiv
- [ ] Elementor ist installiert und aktiviert
- [ ] Elementor Pro ist installiert mit aktiver Lizenz
- [ ] Template Kit ist importiert (Templates + Seiten vorhanden)
- [ ] ACF Felder sind importiert (Team Member Field Group existiert)
- [ ] Team Settings sind konfiguriert (CPT Support, Schemas deaktiviert)
- [ ] Demo-Daten sind importiert (optional)
- [ ] WordPress Settings sind gesetzt (Homepage, Permalinks)
- [ ] Templates sind zugewiesen (Header, Footer, Singles)
- [ ] Farben sind gewählt (Global Colors)
- [ ] Schriftarten sind gewählt (Custom Fonts)
- [ ] Alle Progress Bubbles sind grün (außer optionale Steps)

**Wenn alle Punkte erfüllt sind: Herzlichen Glückwunsch! 🎉**

Ihre Psychotherapie-Website ist bereit für Inhalte!

---

*Letzte Aktualisierung: 2025*
*Version: 1.0*
