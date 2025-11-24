<?php
/**
 * Step 14: Schriftarten vorbereiten & anpassen (Typography)
 */
if (!defined('ABSPATH')) {
    exit;
}

$wizard_status = Psycho_Status_Checker::get_wizard_status();
$fonts_prepared = isset($wizard_status['fonts_prepared']) && $wizard_status['fonts_prepared'];
$typography_set = isset($wizard_status['typography_set']) && $wizard_status['typography_set'];
?>

<div class="wizard-step" data-step="14">
    <h2><?php _e('🔤 Schriftarten vorbereiten & anpassen', 'psycho-wizard'); ?></h2>
    <p class="step-description">
        <?php _e('Bereite deine Custom Fonts vor und wähle ein Schriftarten-Schema für deine Website.', 'psycho-wizard'); ?>
    </p>

    <!-- Section 1: Fonts vorbereiten -->
    <div class="setup-section" id="fontsPreparation">
        <h3><?php _e('📋 Schritt 1: Fonts vorbereiten (wichtig!)', 'psycho-wizard'); ?></h3>

        <div class="info-box" style="background: #eff6ff; border-color: #3b82f6; margin-bottom: 20px;">
            <div class="info-box-title" style="color: #1e40af;"><?php _e('🔧 Was wird gemacht?', 'psycho-wizard'); ?></div>
            <div class="info-box-content" style="color: #1e40af;">
                <ul style="margin: 10px 0; padding-left: 20px;">
                    <li><?php _e('<strong>Custom Fonts aktualisieren:</strong> Alle importierten Custom Fonts (Inter, Inter Italic, Instrument Serif, Instrument Serif Italic) werden aktualisiert und im Dropdown sichtbar gemacht', 'psycho-wizard'); ?></li>
                    <li><?php _e('<strong>Google Fonts lokal laden:</strong> Elementor wird so konfiguriert, dass Google Fonts DSGVO-konform von deinem Server geladen werden (nicht von Google)', 'psycho-wizard'); ?></li>
                </ul>
            </div>
        </div>

        <div class="info-box" style="background: #fef3c7; border-color: #f59e0b; margin-bottom: 20px;">
            <div class="info-box-title" style="color: #92400e;"><?php _e('💡 Manuelle Einstellung (falls benötigt)', 'psycho-wizard'); ?></div>
            <div class="info-box-content" style="color: #92400e;">
                <p style="margin: 5px 0;"><?php _e('Diese Einstellungen werden automatisch vorgenommen. Falls du sie später manuell ändern möchtest:', 'psycho-wizard'); ?></p>
                <ul style="margin: 10px 0; padding-left: 20px;">
                    <li><?php _e('<strong>Custom Fonts aktualisieren:</strong> Elementor → Custom Fonts → Jede Font bearbeiten und "Aktualisieren" klicken', 'psycho-wizard'); ?></li>
                    <li><?php _e('<strong>Google Fonts lokal laden:</strong> Elementor → Settings → Performance → "Load Google Fonts Locally" auf "Enable" setzen', 'psycho-wizard'); ?></li>
                </ul>
            </div>
        </div>

        <div class="info-box" style="background: #eff6ff; border-color: #3b82f6; margin-bottom: 20px;">
            <div class="info-box-title" style="color: #1e40af;"><?php _e('⚠️ WICHTIG: Prüfe Google Fonts Setting', 'psycho-wizard'); ?></div>
            <div class="info-box-content" style="color: #1e40af;">
                <p style="margin: 5px 0 15px 0;"><?php _e('<strong>Datenschutz-relevante Einstellung!</strong><br>Bitte prüfe nach dem Fonts-Vorbereiten, ob "Load Google Fonts Locally" in den Elementor Performance Settings aktiviert ist. Dies ist wichtig für DSGVO-Konformität!', 'psycho-wizard'); ?></p>
                <a href="<?php echo admin_url('admin.php?page=elementor#tab-advanced'); ?>"
                   target="_blank"
                   class="btn btn-secondary"
                   style="text-decoration: none; display: inline-block;">
                    <?php _e('Open Elementor Performance Settings (new tab)', 'psycho-wizard'); ?>
                </a>
            </div>
        </div>

        <?php if (!$fonts_prepared): ?>
            <button type="button" class="btn btn-primary" id="prepareFontsBtn" style="margin-top: 15px;">
                <?php _e('🚀 Fonts jetzt vorbereiten', 'psycho-wizard'); ?>
            </button>
            <div id="prepareFontsStatus" style="margin-top: 15px;"></div>
        <?php else: ?>
            <div class="success-message" style="background: #ecfdf5; border: 2px solid #10b981; padding: 15px; border-radius: 8px;">
                <?php _e('✅ <strong>Fonts sind vorbereitet!</strong> Custom Fonts aktualisiert und Google Fonts lokal aktiviert.', 'psycho-wizard'); ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Section 2: Typography Schemes (nur sichtbar wenn Fonts vorbereitet) -->
    <div class="setup-section" id="typographySchemes" style="margin-top: 50px; <?php echo !$fonts_prepared ? 'opacity: 0.5; pointer-events: none;' : ''; ?>">
        <h3><?php _e('🎨 Schritt 2: Schriftarten-Schema wählen', 'psycho-wizard'); ?></h3>

        <?php if (!$fonts_prepared): ?>
            <div class="info-box" style="background: #f3f4f6; border-color: #9ca3af;">
                <div class="info-box-content" style="color: #6b7280;">
                    <?php _e('⏸️ Bitte bereite zuerst die Fonts vor (Schritt 1), um die Schriftarten-Schemas auswählen zu können.', 'psycho-wizard'); ?>
                </div>
            </div>
        <?php endif; ?>

        <p class="step-description">
            <?php _e('Wähle ein Schriftarten-Schema für deine Website. Es werden nur die Schriftarten geändert, Größen und Abstände bleiben erhalten.', 'psycho-wizard'); ?>
        </p>

        <div class="info-box" style="background: #eff6ff; border-color: #3b82f6; margin-bottom: 30px;">
            <div class="info-box-title" style="color: #1e40af;"><?php _e('💡 Typography-System', 'psycho-wizard'); ?></div>
            <div class="info-box-content" style="color: #1e40af;">
                <?php _e('Das System ändert <strong>15 Schriftarten</strong>: 4 System Fonts (Primary, Secondary, Text, Accent/Button) + 3 Custom Fonts (Small Text, Numbers, Quotes) + H1-H6 + Body + Link. Font-Größen, Line-Heights und Text-Transforms bleiben unverändert. <strong>H1-H4</strong> verwenden die Primary Font, <strong>H5-H6</strong> die Text Font.', 'psycho-wizard'); ?>
            </div>
        </div>

        <div class="typography-schemes" id="typographySchemesContainer">
            <!-- Template Standard (mit Instrument Serif Custom Font) -->
            <div class="typography-scheme" data-scheme="template-standard">
                <div class="scheme-name"><?php _e('📖 Template Standard', 'psycho-wizard'); ?></div>
                <div class="font-preview">
                    <div class="preview-primary" style="font-family: serif; font-size: 32px; font-weight: 400; margin-bottom: 8px;"><?php _e('Überschrift', 'psycho-wizard'); ?></div>
                    <div class="preview-text" style="font-family: sans-serif; font-size: 16px;"><?php _e('Fließtext mit Inter — professionell und gut lesbar', 'psycho-wizard'); ?></div>
                </div>
                <div class="font-list">
                    <small><?php _e('<strong>Instrument Serif</strong> (Custom) + <strong>Inter</strong>', 'psycho-wizard'); ?></small>
                </div>
            </div>

            <!-- Modern Sans -->
            <div class="typography-scheme" data-scheme="modern-sans">
                <div class="scheme-name"><?php _e('🎯 Modern Sans', 'psycho-wizard'); ?></div>
                <div class="font-preview">
                    <div class="preview-primary" style="font-family: 'Inter', sans-serif; font-size: 32px; font-weight: 600; margin-bottom: 8px;"><?php _e('Überschrift', 'psycho-wizard'); ?></div>
                    <div class="preview-text" style="font-family: 'Inter', sans-serif; font-size: 16px;"><?php _e('Fließtext mit Inter — clean, modern und minimal', 'psycho-wizard'); ?></div>
                </div>
                <div class="font-list">
                    <small><?php _e('Nur <strong>Inter</strong> (Clean & Modern)', 'psycho-wizard'); ?></small>
                </div>
            </div>

            <!-- Elegant Serif -->
            <div class="typography-scheme" data-scheme="elegant-serif">
                <div class="scheme-name"><?php _e('✨ Elegant Serif', 'psycho-wizard'); ?></div>
                <div class="font-preview">
                    <div class="preview-primary" style="font-family: 'Playfair Display', serif; font-size: 32px; font-weight: 400; margin-bottom: 8px;"><?php _e('Überschrift', 'psycho-wizard'); ?></div>
                    <div class="preview-text" style="font-family: 'Inter', sans-serif; font-size: 16px;"><?php _e('Fließtext mit Inter — elegant und klassisch', 'psycho-wizard'); ?></div>
                </div>
                <div class="font-list">
                    <small><?php _e('<strong>Playfair Display</strong> + <strong>Inter</strong>', 'psycho-wizard'); ?></small>
                </div>
            </div>

            <!-- Warm & Friendly -->
            <div class="typography-scheme" data-scheme="warm-friendly">
                <div class="scheme-name"><?php _e('😊 Warm & Friendly', 'psycho-wizard'); ?></div>
                <div class="font-preview">
                    <div class="preview-primary" style="font-family: 'Outfit', sans-serif; font-size: 32px; font-weight: 500; margin-bottom: 8px;"><?php _e('Überschrift', 'psycho-wizard'); ?></div>
                    <div class="preview-text" style="font-family: 'Inter', sans-serif; font-size: 16px;"><?php _e('Fließtext mit Inter — freundlich und einladend', 'psycho-wizard'); ?></div>
                </div>
                <div class="font-list">
                    <small><?php _e('<strong>Outfit</strong> + <strong>Inter</strong> (Rounded)', 'psycho-wizard'); ?></small>
                </div>
            </div>

            <!-- Professional -->
            <div class="typography-scheme" data-scheme="professional">
                <div class="scheme-name"><?php _e('💼 Professional', 'psycho-wizard'); ?></div>
                <div class="font-preview">
                    <div class="preview-primary" style="font-family: 'Montserrat', sans-serif; font-size: 32px; font-weight: 600; margin-bottom: 8px;"><?php _e('Überschrift', 'psycho-wizard'); ?></div>
                    <div class="preview-text" style="font-family: 'Inter', sans-serif; font-size: 16px;"><?php _e('Fließtext mit Inter — professionell und klar', 'psycho-wizard'); ?></div>
                </div>
                <div class="font-list">
                    <small><?php _e('<strong>Montserrat</strong> + <strong>Inter</strong> (Corporate)', 'psycho-wizard'); ?></small>
                </div>
            </div>

            <!-- Warm & Einladend -->
            <div class="typography-scheme" data-scheme="warm-inviting">
                <div class="scheme-name"><?php _e('🏡 Warm & Einladend', 'psycho-wizard'); ?></div>
                <div class="font-preview">
                    <div class="preview-primary" style="font-family: 'Merriweather', serif; font-size: 32px; font-weight: 400; margin-bottom: 8px;"><?php _e('Überschrift', 'psycho-wizard'); ?></div>
                    <div class="preview-text" style="font-family: 'Lato', sans-serif; font-size: 16px;"><?php _e('Fließtext mit Lato — lesbar, warm, professionell', 'psycho-wizard'); ?></div>
                </div>
                <div class="font-list">
                    <small><?php _e('<strong>Merriweather</strong> (Serif) + <strong>Lato</strong> (Sans-Serif)', 'psycho-wizard'); ?></small>
                </div>
            </div>

            <!-- Ruhig & Harmonisch -->
            <div class="typography-scheme" data-scheme="calm-harmonious">
                <div class="scheme-name"><?php _e('🧘 Ruhig & Harmonisch', 'psycho-wizard'); ?></div>
                <div class="font-preview">
                    <div class="preview-primary" style="font-family: 'Poppins', sans-serif; font-size: 32px; font-weight: 500; margin-bottom: 8px;"><?php _e('Überschrift', 'psycho-wizard'); ?></div>
                    <div class="preview-text" style="font-family: 'Nunito', sans-serif; font-size: 16px;"><?php _e('Fließtext mit Nunito — sanft, modern, beruhigend', 'psycho-wizard'); ?></div>
                </div>
                <div class="font-list">
                    <small><?php _e('<strong>Poppins</strong> + <strong>Nunito</strong> (beide Sans-Serif)', 'psycho-wizard'); ?></small>
                </div>
            </div>

            <!-- Zeitlos & Seriös -->
            <div class="typography-scheme" data-scheme="timeless-serious">
                <div class="scheme-name"><?php _e('⚖️ Zeitlos & Seriös', 'psycho-wizard'); ?></div>
                <div class="font-preview">
                    <div class="preview-primary" style="font-family: 'Cormorant Garamond', serif; font-size: 32px; font-weight: 400; margin-bottom: 8px;"><?php _e('Überschrift', 'psycho-wizard'); ?></div>
                    <div class="preview-text" style="font-family: 'Raleway', sans-serif; font-size: 16px;"><?php _e('Fließtext mit Raleway — elegant, gebildet, vertrauenswürdig', 'psycho-wizard'); ?></div>
                </div>
                <div class="font-list">
                    <small><?php _e('<strong>Cormorant Garamond</strong> (Serif) + <strong>Raleway</strong> (Sans-Serif)', 'psycho-wizard'); ?></small>
                </div>
            </div>
        </div>

        <div style="margin-top: 30px; padding: 20px; background: #fef3c7; border: 2px solid #f59e0b; border-radius: 8px;">
            <h4 style="margin: 0 0 10px 0; color: #92400e;"><?php _e('⚠️ Wichtig', 'psycho-wizard'); ?></h4>
            <p style="margin: 0; color: #92400e;">
                <?php _e('Google Fonts werden lokal geladen (DSGVO-konform). Custom Fonts wie <strong>Instrument Serif</strong> bleiben verfügbar. Die Schriftarten-Auswahl ändert nur die <strong>font-family</strong>, alle Größen bleiben erhalten.', 'psycho-wizard'); ?>
            </p>
        </div>

        <div class="info-box" style="margin-top: 20px;">
            <div class="info-box-title"><?php _e('🎨 Weitere Anpassungen', 'psycho-wizard'); ?></div>
            <div class="info-box-content">
                <?php _e('Du kannst später jede Schriftart einzeln unter <strong>Elementor → Site Settings → Typography</strong> anpassen. Dort findest du alle System Fonts, Custom Fonts, H1-H6, Body und Link Settings.', 'psycho-wizard'); ?>
            </div>
        </div>
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    // Button: Fonts vorbereiten
    $('#prepareFontsBtn').on('click', function() {
        const $btn = $(this);
        const $status = $('#prepareFontsStatus');

        $btn.prop('disabled', true).text(<?php echo json_encode(__('⏳ Bereite Fonts vor...', 'psycho-wizard')); ?>);
        $status.html('<div class="info-message" style="background: #e0f2fe; border: 1px solid #0ea5e9; padding: 12px; border-radius: 6px; color: #075985;">' + <?php echo json_encode(__('⏳ Custom Fonts werden aktualisiert und Google Fonts lokal aktiviert...', 'psycho-wizard')); ?> + '</div>');

        $.ajax({
            url: psychoWizard.ajaxUrl,
            method: 'POST',
            data: {
                action: 'psycho_prepare_fonts',
                nonce: psychoWizard.nonce
            },
            success: function(response) {
                if (response.success) {
                    $status.html('<div class="success-message" style="background: #ecfdf5; border: 2px solid #10b981; padding: 15px; border-radius: 8px; color: #065f46;">' + <?php echo json_encode(__('✅ <strong>', 'psycho-wizard')); ?> + response.data.message + <?php echo json_encode(__('</strong>', 'psycho-wizard')); ?> + '</div>');

                    // Button als erfolgreich markieren (nicht wieder aktivieren)
                    $btn.text(<?php echo json_encode(__('✅ Fonts vorbereitet!', 'psycho-wizard')); ?>);

                    // Section 2 aktivieren
                    $('#typographySchemes').css({'opacity': '1', 'pointer-events': 'auto'});
                    $('#typographySchemes .info-box:first').hide();

                    // Status neu laden
                    setTimeout(function() {
                        loadWizardStatus();
                    }, 1000);
                } else {
                    $status.html('<div class="error-message" style="background: #fee; border: 2px solid #dc2626; padding: 15px; border-radius: 8px; color: #991b1b;">' + <?php echo json_encode(__('❌ <strong>Fehler:</strong> ', 'psycho-wizard')); ?> + (response.data?.message || <?php echo json_encode(__('Unbekannter Fehler', 'psycho-wizard')); ?>) + '</div>');
                    $btn.prop('disabled', false).text(<?php echo json_encode(__('🚀 Fonts jetzt vorbereiten', 'psycho-wizard')); ?>);
                }
            },
            error: function() {
                $status.html('<div class="error-message" style="background: #fee; border: 2px solid #dc2626; padding: 15px; border-radius: 8px; color: #991b1b;">' + <?php echo json_encode(__('❌ <strong>Verbindungsfehler</strong> beim Vorbereiten der Fonts', 'psycho-wizard')); ?> + '</div>');
                $btn.prop('disabled', false).text(<?php echo json_encode(__('🚀 Fonts jetzt vorbereiten', 'psycho-wizard')); ?>);
            }
        });
    });

    // Typography Scheme Handler wird in wizard.js registriert
});
</script>
