<?php
/**
 * Step 6: ACF Setup
 */
if (!defined('ABSPATH')) {
    exit;
}

// Prüfe ob ACF bereits importiert wurde
$wizard_status = Psycho_Status_Checker::get_wizard_status();
$is_acf_imported = isset($wizard_status['acf_imported']) && $wizard_status['acf_imported'];

// Prüfe auch direkt ob Team CPT und Field Groups existieren
$team_cpt_exists = post_type_exists('team_member');
$field_groups_count = 0;
$team_field_groups = 0;

if (function_exists('acf_get_field_groups')) {
    $field_groups = acf_get_field_groups();
    $field_groups_count = count($field_groups);

    // Zähle Team-Field-Groups
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
}

$has_acf_setup = $team_cpt_exists && $team_field_groups > 0;
?>

<div class="wizard-step" data-step="6">
    <h2><?php _e('ACF für Team Members', 'psycho-wizard'); ?></h2>
    <p class="step-description">
        <?php if ($has_acf_setup): ?>
            <?php _e('✅ ACF Setup wurde bereits erfolgreich abgeschlossen!', 'psycho-wizard'); ?>
        <?php else: ?>
            <?php _e('Lade die ACF JSON-Datei hoch, um die Custom Post Type Struktur für Team Members zu erstellen.', 'psycho-wizard'); ?>
        <?php endif; ?>
    </p>

    <?php if ($has_acf_setup): ?>
        <!-- ACF bereits importiert -->
        <div class="info-box" style="background: #d1fae5; border-color: #10b981;">
            <div class="info-box-title" style="color: #065f46;"><?php _e('✅ Setup abgeschlossen!', 'psycho-wizard'); ?></div>
            <div class="info-box-content" style="color: #065f46;">
                <?php echo sprintf(__('<strong>Erfolgreich eingerichtet:</strong><br>• Custom Post Type "Team Member" (team_member)<br>• %d ACF Field Group(s) für Team Members<br>• Insgesamt %d ACF Field Group(s) vorhanden<br><br>Du kannst jetzt Team Members unter "Team" im WordPress Menü verwalten!<br><strong>⚠️ Wichtig:</strong> Lade die ACF-Datei nicht erneut hoch, das würde Duplikate erstellen!', 'psycho-wizard'), $team_field_groups, $field_groups_count); ?>
            </div>
        </div>

        <div style="margin-top: 20px;">
            <button type="button"
                    class="btn btn-secondary"
                    id="checkAcfBtn"
                    onclick="checkAcfImportStatus()">
                <?php _e('🔄 Status erneut prüfen', 'psycho-wizard'); ?>
            </button>
        </div>

        <!-- Status Anzeige für Recheck -->
        <div id="acfStatusDisplay" style="margin-top: 20px; padding: 15px; border-radius: 8px; display: none;">
            <div id="acfStatusText"></div>
        </div>

    <?php else: ?>
        <!-- ACF noch nicht importiert -->
        <div class="upload-area" id="acfUpload">
            <div class="upload-icon">⚙️</div>
            <div class="upload-text"><?php _e('ACF JSON Datei hochladen', 'psycho-wizard'); ?></div>
            <div class="upload-hint"><?php _e('acf-team-members.json', 'psycho-wizard'); ?></div>
        </div>

        <div class="info-box">
            <div class="info-box-title"><?php _e('👥 Was sind Team Members?', 'psycho-wizard'); ?></div>
            <div class="info-box-content">
                <?php _e('Der Custom Post Type "Team Members" ermöglicht es dir, dein Team mit ca. 40 individuellen Feldern zu verwalten (Foto, Position, Qualifikationen, Spezialisierungen, etc.).', 'psycho-wizard'); ?>
            </div>
        </div>

        <div class="warning-box" style="margin-top: 20px;">
            <div class="warning-box-title"><?php _e('⚠️ Wichtig', 'psycho-wizard'); ?></div>
            <div class="warning-box-content">
                <?php _e('<strong>Lade die ACF JSON-Datei nur einmal hoch!</strong><br>Ein erneuter Upload würde Duplikate erstellen und das Backend beschädigen.', 'psycho-wizard'); ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
// Status beim Laden setzen
jQuery(document).ready(function($) {
    <?php if ($has_acf_setup): ?>
        // ACF bereits importiert
        window.uploadedFiles.acfJson = true;
        window.updateButtons();
    <?php endif; ?>
});

// ACF Import Status prüfen
window.checkAcfImportStatus = function() {
    const $ = jQuery;
    const $btn = $('#checkAcfBtn');
    const $statusDisplay = $('#acfStatusDisplay');
    const $statusText = $('#acfStatusText');

    $btn.prop('disabled', true).text(<?php echo json_encode(__('⏳ Prüfe Status...', 'psycho-wizard')); ?>);
    $statusDisplay.hide();

    $.ajax({
        url: psychoWizard.ajaxUrl,
        type: 'POST',
        data: {
            action: 'psycho_check_acf_import',
            nonce: psychoWizard.nonce
        },
        success: function(response) {
            console.log('ACF check response:', response);
            $btn.prop('disabled', false).text(<?php echo json_encode(__('🔄 Status erneut prüfen', 'psycho-wizard')); ?>);

            if (response.success && response.data.acf_imported) {
                // ACF ist importiert!
                if (typeof window.uploadedFiles !== 'undefined') {
                    window.uploadedFiles.acfJson = true;
                }
                $statusDisplay.css('background', '#d1fae5').css('border', '2px solid #10b981').show();
                $statusText.html(<?php echo json_encode(__('✅ <strong>ACF Setup erfolgreich!</strong><br>Team CPT: ', 'psycho-wizard')); ?> + (response.data.team_cpt_exists ? '✓' : '✗') + ', ' +
                               <?php echo json_encode(__('Field Groups: ', 'psycho-wizard')); ?> + response.data.team_field_groups);

                if (typeof window.updateButtons === 'function') {
                    window.updateButtons();
                }
            } else {
                // Noch nicht importiert oder unvollständig
                $statusDisplay.css('background', '#fef3c7').css('border', '2px solid #f59e0b').show();
                $statusText.html(<?php echo json_encode(__('⚠️ <strong>ACF Setup unvollständig</strong><br>', 'psycho-wizard')); ?> +
                               (response.data.message || <?php echo json_encode(__('Bitte lade die ACF JSON-Datei hoch.', 'psycho-wizard')); ?>));
            }
        },
        error: function(xhr, status, error) {
            console.error('ACF check error:', error);
            $btn.prop('disabled', false).text(<?php echo json_encode(__('🔄 Status erneut prüfen', 'psycho-wizard')); ?>);
            $statusDisplay.css('background', '#fee2e2').css('border', '2px solid #ef4444').show();
            $statusText.html(<?php echo json_encode(__('❌ <strong>Fehler beim Prüfen</strong><br>Bitte versuche es erneut.', 'psycho-wizard')); ?>);
        }
    });
};
</script>
