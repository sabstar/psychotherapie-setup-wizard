<?php
/**
 * Emergency Recovery Page für verlorene Elementor Settings
 */
if (!defined('ABSPATH')) {
    exit;
}

// Nur für Admins zugänglich
if (!current_user_can('manage_options')) {
    wp_die('Keine Berechtigung');
}
?>

<div class="wrap" style="max-width: 1200px; margin: 40px auto; padding: 20px;">
    <h1 style="margin-bottom: 30px;">🆘 Elementor Settings Recovery</h1>

    <div style="background: #fef3c7; border: 2px solid #f59e0b; border-radius: 8px; padding: 20px; margin-bottom: 30px;">
        <h3 style="color: #92400e; margin: 0 0 10px 0;">⚠️ Was ist passiert?</h3>
        <p style="color: #92400e; margin: 0;">
            Durch einen Fehler in der Farbschema-Funktion wurden möglicherweise deine Elementor Site Settings (Typography, Button Styles, Image Styles) überschrieben.
            Diese Seite hilft dir, die Template-Standard-Einstellungen wiederherzustellen.
        </p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-bottom: 30px;">

        <!-- Farben wiederherstellen -->
        <div style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 25px;">
            <h3 style="margin: 0 0 15px 0; color: #1e293b;">🎨 Template-Farben</h3>
            <p style="color: #64748b; margin-bottom: 20px; font-size: 14px;">
                Setze die Global Colors auf die Template-Standardwerte zurück.
            </p>
            <button type="button" class="button button-primary" onclick="recoverColors()" id="recoverColorsBtn" style="width: 100%;">
                Farben wiederherstellen
            </button>
        </div>

        <!-- Typography wiederherstellen -->
        <div style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 25px;">
            <h3 style="margin: 0 0 15px 0; color: #1e293b;">🔤 Typography</h3>
            <p style="color: #64748b; margin-bottom: 20px; font-size: 14px;">
                Stelle Schriftgrößen und -gewichte wieder her (erfordert manuelles Setzen in Elementor).
            </p>
            <a href="<?php echo admin_url('admin.php?page=elementor#tab-typography'); ?>" class="button" style="width: 100%; text-align: center;">
                Zu Typography Settings
            </a>
        </div>

        <!-- Button Styles wiederherstellen -->
        <div style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 25px;">
            <h3 style="margin: 0 0 15px 0; color: #1e293b;">🔘 Button Styles</h3>
            <p style="color: #64748b; margin-bottom: 20px; font-size: 14px;">
                Setze Button Padding, Border Radius und Hover-Effekte zurück.
            </p>
            <a href="<?php echo admin_url('admin.php?page=elementor#tab-buttons'); ?>" class="button" style="width: 100%; text-align: center;">
                Zu Button Settings
            </a>
        </div>

        <!-- Image Styles wiederherstellen -->
        <div style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 25px;">
            <h3 style="margin: 0 0 15px 0; color: #1e293b;">🖼️ Image Styles</h3>
            <p style="color: #64748b; margin-bottom: 20px; font-size: 14px;">
                Setze Border Radius und Schatten für Bilder zurück.
            </p>
            <a href="<?php echo admin_url('admin.php?page=elementor#tab-lightbox'); ?>" class="button" style="width: 100%; text-align: center;">
                Zu Image Settings
            </a>
        </div>

    </div>

    <!-- Vollständige Neuinstallation -->
    <div style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 30px;">
        <h3 style="margin: 0 0 15px 0; color: #1e293b;">🔄 Template Kit neu importieren</h3>
        <p style="color: #64748b; margin-bottom: 20px;">
            Die sicherste Methode: Importiere das Template Kit erneut. Dadurch werden alle Elementor Settings,
            Typography, Button Styles und Image Styles auf die Original-Werte zurückgesetzt.
        </p>
        <p style="color: #dc2626; margin-bottom: 20px; font-weight: 500;">
            ⚠️ Achtung: Eigene Anpassungen an Templates gehen dabei verloren!
        </p>
        <a href="<?php echo admin_url('admin.php?page=psycho-wizard'); ?>" class="button button-secondary">
            Zurück zum Setup Wizard
        </a>
    </div>

    <!-- Status Anzeige -->
    <div id="statusBox" style="margin-top: 30px; display: none;"></div>

</div>

<script>
function recoverColors() {
    const btn = document.getElementById('recoverColorsBtn');
    btn.disabled = true;
    btn.textContent = '🔄 Stelle wieder her...';

    jQuery.ajax({
        url: ajaxurl,
        type: 'POST',
        data: {
            action: 'psycho_reset_template_colors',
            nonce: '<?php echo wp_create_nonce('psycho_wizard_nonce'); ?>'
        },
        success: function(response) {
            const statusBox = document.getElementById('statusBox');
            statusBox.style.display = 'block';

            if (response.success) {
                statusBox.innerHTML = '<div style="background: #d1fae5; border: 2px solid #10b981; border-radius: 8px; padding: 20px; color: #065f46;">' +
                    '<strong>✅ Erfolgreich!</strong><br>' +
                    'Template-Farben wurden wiederhergestellt.' +
                    '</div>';
                btn.textContent = '✅ Wiederhergestellt';
            } else {
                statusBox.innerHTML = '<div style="background: #fee2e2; border: 2px solid #dc2626; border-radius: 8px; padding: 20px; color: #991b1b;">' +
                    '<strong>❌ Fehler</strong><br>' +
                    (response.data.message || 'Ein unbekannter Fehler ist aufgetreten.') +
                    '</div>';
                btn.disabled = false;
                btn.textContent = 'Farben wiederherstellen';
            }
        },
        error: function() {
            const statusBox = document.getElementById('statusBox');
            statusBox.style.display = 'block';
            statusBox.innerHTML = '<div style="background: #fee2e2; border: 2px solid #dc2626; border-radius: 8px; padding: 20px; color: #991b1b;">' +
                '<strong>❌ Fehler</strong><br>' +
                'Verbindung zum Server fehlgeschlagen.' +
                '</div>';
            btn.disabled = false;
            btn.textContent = 'Farben wiederherstellen';
        }
    });
}
</script>
