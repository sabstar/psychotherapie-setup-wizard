<?php
/**
 * Step 8: Styling Plugin
 */
if (!defined('ABSPATH')) {
    exit;
}

// Prüfe ob bereits installiert
$wizard_status = Psycho_Status_Checker::get_wizard_status();
$is_installed = isset($wizard_status['styling_plugin_installed']) && $wizard_status['styling_plugin_installed'];
?>

<div class="wizard-step" data-step="8">
    <h2><?php _e('Backend Styling Plugin', 'psycho-wizard'); ?></h2>
    <p class="step-description">
        <?php if ($is_installed): ?>
            <?php _e('✅ Styling Plugin wurde bereits installiert!', 'psycho-wizard'); ?>
        <?php else: ?>
            <?php _e('Installiere das Backend Styling Plugin für eine bessere Übersicht der Team Member Felder.', 'psycho-wizard'); ?>
        <?php endif; ?>
    </p>

    <?php if ($is_installed): ?>
        <!-- Bereits installiert -->
        <div class="info-box" style="background: #d1fae5; border-color: #10b981;">
            <div class="info-box-title" style="color: #065f46;"><?php _e('✅ Plugin installiert!', 'psycho-wizard'); ?></div>
            <div class="info-box-content" style="color: #065f46;">
                <?php _e('Das Backend Styling Plugin ist aktiv und verbessert die Darstellung der Team Member Felder im WordPress Backend.', 'psycho-wizard'); ?>
            </div>
        </div>

        <div style="margin-top: 20px;">
            <button type="button"
                    class="btn btn-secondary"
                    id="checkStylingPluginBtn"
                    onclick="checkStylingPluginStatus()">
                <?php _e('🔄 Status erneut prüfen', 'psycho-wizard'); ?>
            </button>
        </div>

        <!-- Status Anzeige für Recheck -->
        <div id="stylingPluginStatusDisplay" style="margin-top: 20px; padding: 15px; border-radius: 8px; display: none;">
            <div id="stylingPluginStatusText"></div>
        </div>

    <?php else: ?>
        <!-- Upload Area -->
        <div class="upload-area" id="stylingPluginUpload">
            <div class="upload-icon">📤</div>
            <div class="upload-text"><?php _e('Styling Plugin ZIP hochladen', 'psycho-wizard'); ?></div>
            <div class="upload-hint"><?php _e('Ziehe die styling-plugin.zip Datei hier her', 'psycho-wizard'); ?></div>
        </div>

        <div class="info-box" style="margin-top: 20px;">
            <div class="info-box-title"><?php _e('✨ Was macht dieses Plugin?', 'psycho-wizard'); ?></div>
            <div class="info-box-content">
                <?php _e('<strong>Bessere Backend-Übersicht:</strong><br>• Größere, lesbarere Überschriften für ACF Feldgruppen<br>• Bessere visuelle Trennung zwischen Feld-Sections<br>• Optimierte Darstellung bei 40+ Feldern<br>• Hilft deinen Kunden beim Bearbeiten der Team Members<br><br>Das Plugin ist im Template Kit Paket enthalten als <code>styling-plugin.zip</code>', 'psycho-wizard'); ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
jQuery(document).ready(function($) {
    <?php if ($is_installed): ?>
        if (typeof window.markStepCompleted === 'function') {
            window.markStepCompleted(8);
        }
        if (typeof window.updateButtons === 'function') {
            window.updateButtons();
        }
    <?php endif; ?>
});

// Status Check Function
window.checkStylingPluginStatus = function() {
    const $ = jQuery;
    const $btn = $('#checkStylingPluginBtn');
    const $statusDisplay = $('#stylingPluginStatusDisplay');
    const $statusText = $('#stylingPluginStatusText');

    $btn.prop('disabled', true).text(<?php echo json_encode(__('⏳ Prüfe Status...', 'psycho-wizard')); ?>);
    $statusDisplay.hide();

    $.ajax({
        url: psychoWizard.ajaxUrl,
        type: 'POST',
        data: {
            action: 'psycho_check_styling_plugin',
            nonce: psychoWizard.nonce
        },
        success: function(response) {
            console.log('Styling plugin check:', response);
            $btn.prop('disabled', false).text(<?php echo json_encode(__('🔄 Status erneut prüfen', 'psycho-wizard')); ?>);

            if (response.success && response.data.is_installed) {
                // Plugin ist installiert!
                $statusDisplay.css('background', '#d1fae5').css('border', '2px solid #10b981').show();
                $statusText.html(<?php echo json_encode(__('✅ <strong>Plugin aktiv!</strong><br>Das Backend Styling Plugin ist installiert.', 'psycho-wizard')); ?>);

                if (typeof window.markStepCompleted === 'function') {
                    window.markStepCompleted(8);
                }
                if (typeof window.updateButtons === 'function') {
                    window.updateButtons();
                }
            } else {
                // Noch nicht installiert
                $statusDisplay.css('background', '#fef3c7').css('border', '2px solid #f59e0b').show();
                $statusText.html(<?php echo json_encode(__('⚠️ <strong>Plugin noch nicht installiert</strong><br>', 'psycho-wizard')); ?> +
                               (response.data.message || <?php echo json_encode(__('Bitte lade das Plugin hoch.', 'psycho-wizard')); ?>));
            }
        },
        error: function(xhr, status, error) {
            console.error('Styling plugin check error:', xhr.responseText);
            $btn.prop('disabled', false).text(<?php echo json_encode(__('🔄 Status erneut prüfen', 'psycho-wizard')); ?>);
            $statusDisplay.css('background', '#fee2e2').css('border', '2px solid #ef4444').show();
            $statusText.html(<?php echo json_encode(__('❌ <strong>Fehler beim Prüfen</strong><br>Bitte versuche es erneut.', 'psycho-wizard')); ?>);
        }
    });
};
</script>
