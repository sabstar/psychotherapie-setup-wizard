<?php
/**
 * Step 14: Schriftarten
 */
if (!defined('ABSPATH')) {
    exit;
}

$wizard_status = Psycho_Status_Checker::get_wizard_status();
$is_uploaded = isset($wizard_status['fonts_uploaded']) && $wizard_status['fonts_uploaded'];
?>

<div class="wizard-step" data-step="14">
    <h2>Schriftarten hochladen</h2>
    <p class="step-description">
        <?php if ($is_uploaded): ?>
            ✅ Schriftarten wurden hochgeladen!
        <?php else: ?>
            Lade deine gewünschten Schriftarten hoch. Du benötigst mindestens eine für Überschriften und eine für Fließtext.
        <?php endif; ?>
    </p>

    <?php if ($is_uploaded): ?>
        <div class="info-box" style="background: #d1fae5; border-color: #10b981;">
            <div class="info-box-title" style="color: #065f46;">✅ Schriftarten hochgeladen!</div>
            <div class="info-box-content" style="color: #065f46;">
                Deine Custom Fonts wurden erfolgreich zu Elementor hinzugefügt und können jetzt verwendet werden.
            </div>
        </div>
        
        <div style="margin-top: 20px;">
            <button type="button" class="btn btn-secondary" onclick="location.reload()">
                🔄 Status erneut prüfen
            </button>
        </div>
        
    <?php else: ?>
        <div class="font-upload-area">
            <div class="font-upload-box" id="headingFontUpload">
                <div class="font-upload-icon">🔤</div>
                <div class="font-upload-label">Überschriften-Schrift</div>
                <div class="upload-hint">TTF, OTF oder WOFF2</div>
            </div>

            <div class="font-upload-box" id="bodyFontUpload">
                <div class="font-upload-icon">📝</div>
                <div class="font-upload-label">Fließtext-Schrift</div>
                <div class="upload-hint">TTF, OTF oder WOFF2</div>
            </div>
        </div>

        <div class="settings-grid">
            <div class="setting-item">
                <div class="setting-header">
                    <div class="setting-icon">⚙️</div>
                    <div class="setting-title">Global Typography</div>
                </div>
                <div class="setting-content">
                    Schriftgrößen und -gewichte werden automatisch auf alle Überschriften (H1-H6) und Text-Elemente angewendet.
                </div>
            </div>

            <div class="setting-item">
                <div class="setting-header">
                    <div class="setting-icon">🔘</div>
                    <div class="setting-title">Button Styles</div>
                </div>
                <div class="setting-content">
                    Border Radius, Padding und Hover-Effekte werden global für alle Buttons festgelegt.
                </div>
            </div>

            <div class="setting-item">
                <div class="setting-header">
                    <div class="setting-icon">🖼️</div>
                    <div class="setting-title">Image Styles</div>
                </div>
                <div class="setting-content">
                    Border Radius und Schatten für Bilder werden einheitlich gesetzt.
                </div>
            </div>

            <div class="setting-item">
                <div class="setting-header">
                    <div class="setting-icon">📐</div>
                    <div class="setting-title">Spacing & Layout</div>
                </div>
                <div class="setting-content">
                    Abstände zwischen Sections und Spalten werden definiert.
                </div>
            </div>
        </div>

        <div class="warning-box">
            <div class="warning-box-title">⚠️ Lizenzen beachten</div>
            <div class="warning-box-content">
                Stelle sicher, dass du die Lizenz für die Verwendung der Schriftarten auf deiner Website besitzt. Google Fonts sind kostenlos nutzbar.
            </div>
        </div>
    <?php endif; ?>

    <!-- Reset Buttons für Elementor Settings -->
    <div style="margin-top: 40px; padding: 30px; background: white; border: 1px solid #e5e7eb; border-radius: 8px;">
        <h3 style="font-size: 20px; margin: 0 0 20px 0; color: #1e293b;">🔄 Elementor Einstellungen zurücksetzen</h3>
        <p style="color: #64748b; margin-bottom: 20px;">
            Falls du Änderungen an den Elementor Global Settings vorgenommen hast und zu den Template-Standards zurückkehren möchtest.
        </p>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px;">
            <button type="button" class="btn btn-secondary" onclick="resetTypography()" id="resetTypographyBtn">
                🔤 Typography zurücksetzen
            </button>
            <button type="button" class="btn btn-secondary" onclick="resetButtonStyles()" id="resetButtonStylesBtn">
                🔘 Button Styles zurücksetzen
            </button>
            <button type="button" class="btn btn-secondary" onclick="resetImageStyles()" id="resetImageStylesBtn">
                🖼️ Image Styles zurücksetzen
            </button>
        </div>

        <div class="info-box" style="margin-top: 20px; background: #fef3c7; border-color: #f59e0b;">
            <div class="info-box-title" style="color: #92400e;">⚠️ Hinweis</div>
            <div class="info-box-content" style="color: #92400e;">
                Diese Funktionen setzen die Elementor Global Settings auf die Template-Standardwerte zurück.
                Eigene Anpassungen gehen dabei verloren.
            </div>
        </div>
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    <?php if ($is_uploaded): ?>
        window.markStepCompleted(14);
        window.updateButtons();
    <?php endif; ?>
});

function resetTypography() {
    const $btn = jQuery('#resetTypographyBtn');
    $btn.prop('disabled', true).text('🔄 Setze zurück...');

    jQuery.ajax({
        url: psychoWizard.ajaxUrl,
        type: 'POST',
        data: {
            action: 'psycho_reset_typography',
            nonce: psychoWizard.nonce
        },
        success: function(response) {
            if (response.success) {
                showNotification('success', response.data.message);
                setTimeout(function() {
                    $btn.prop('disabled', false).text('🔤 Typography zurücksetzen');
                }, 1500);
            } else {
                $btn.prop('disabled', false).text('🔤 Typography zurücksetzen');
                showNotification('error', response.data.message || 'Fehler beim Zurücksetzen');
            }
        },
        error: function() {
            $btn.prop('disabled', false).text('🔤 Typography zurücksetzen');
            showNotification('error', 'Ein Fehler ist aufgetreten');
        }
    });
}

function resetButtonStyles() {
    const $btn = jQuery('#resetButtonStylesBtn');
    $btn.prop('disabled', true).text('🔄 Setze zurück...');

    jQuery.ajax({
        url: psychoWizard.ajaxUrl,
        type: 'POST',
        data: {
            action: 'psycho_reset_button_styles',
            nonce: psychoWizard.nonce
        },
        success: function(response) {
            if (response.success) {
                showNotification('success', response.data.message);
                setTimeout(function() {
                    $btn.prop('disabled', false).text('🔘 Button Styles zurücksetzen');
                }, 1500);
            } else {
                $btn.prop('disabled', false).text('🔘 Button Styles zurücksetzen');
                showNotification('error', response.data.message || 'Fehler beim Zurücksetzen');
            }
        },
        error: function() {
            $btn.prop('disabled', false).text('🔘 Button Styles zurücksetzen');
            showNotification('error', 'Ein Fehler ist aufgetreten');
        }
    });
}

function resetImageStyles() {
    const $btn = jQuery('#resetImageStylesBtn');
    $btn.prop('disabled', true).text('🔄 Setze zurück...');

    jQuery.ajax({
        url: psychoWizard.ajaxUrl,
        type: 'POST',
        data: {
            action: 'psycho_reset_image_styles',
            nonce: psychoWizard.nonce
        },
        success: function(response) {
            if (response.success) {
                showNotification('success', response.data.message);
                setTimeout(function() {
                    $btn.prop('disabled', false).text('🖼️ Image Styles zurücksetzen');
                }, 1500);
            } else {
                $btn.prop('disabled', false).text('🖼️ Image Styles zurücksetzen');
                showNotification('error', response.data.message || 'Fehler beim Zurücksetzen');
            }
        },
        error: function() {
            $btn.prop('disabled', false).text('🖼️ Image Styles zurücksetzen');
            showNotification('error', 'Ein Fehler ist aufgetreten');
        }
    });
}
</script>