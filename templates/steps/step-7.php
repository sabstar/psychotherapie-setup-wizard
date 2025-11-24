<?php
/**
 * Step 7: Team CPT & Elementor Settings
 */
if (!defined('ABSPATH')) {
    exit;
}

// Prüfe ob bereits konfiguriert
$wizard_status = Psycho_Status_Checker::get_wizard_status();
$is_configured = isset($wizard_status['team_settings_configured']) && $wizard_status['team_settings_configured'];
?>

<div class="wizard-step" data-step="7">
    <h2><?php _e('Team CPT & Elementor Einstellungen', 'psycho-wizard'); ?></h2>
    <p class="step-description">
        <?php if ($is_configured): ?>
            <?php _e('✅ Einstellungen wurden bereits konfiguriert!', 'psycho-wizard'); ?>
        <?php else: ?>
            <?php _e('Aktiviere den Team Custom Post Type und konfiguriere die Elementor-Einstellungen für beste Darstellung.', 'psycho-wizard'); ?>
        <?php endif; ?>
    </p>

    <?php if ($is_configured): ?>
        <!-- Bereits konfiguriert -->
        <div class="info-box" style="background: #d1fae5; border-color: #10b981;">
            <div class="info-box-title" style="color: #065f46;"><?php _e('✅ Einstellungen aktiv!', 'psycho-wizard'); ?></div>
            <div class="info-box-content" style="color: #065f46;">
                <?php _e('<strong>Folgende Einstellungen wurden gesetzt:</strong><br>• Team Custom Post Type aktiviert<br>• Standardfarben deaktiviert (Theme-Farben aktiv)<br>• Standardschriftarten deaktiviert (Theme-Fonts aktiv)<br><br>Du kannst direkt zum nächsten Schritt weitergehen!', 'psycho-wizard'); ?>
            </div>
        </div>

        <div style="margin-top: 20px;">
            <button type="button"
                    class="btn btn-secondary"
                    id="checkTeamSettingsBtn"
                    onclick="checkTeamSettings()">
                <?php _e('🔄 Status erneut prüfen', 'psycho-wizard'); ?>
            </button>
        </div>

        <!-- Status Anzeige für Recheck -->
        <div id="teamSettingsDisplay" style="margin-top: 20px; padding: 15px; border-radius: 8px; display: none;">
            <div id="teamSettingsText"></div>
        </div>

    <?php else: ?>
        <!-- Noch nicht konfiguriert - Anleitung -->
        <div class="info-box">
            <div class="info-box-title"><?php _e('⚙️ Schritt-für-Schritt Anleitung', 'psycho-wizard'); ?></div>
            <div class="info-box-content">
                <?php _e('<strong>1. Öffne die Elementor Einstellungen</strong><br>Klicke auf den Button unten um die Elementor-Einstellungen in einem neuen Tab zu öffnen.<br><br><strong>2. Aktiviere den Team Post Type</strong><br>• Gehe zu <strong>Funktionen</strong> (Features)<br>• Scrolle nach unten zu <strong>"Custom Post Types"</strong><br>• Aktiviere das Häkchen bei <strong>"Team"</strong><br><br><strong>3. Deaktiviere Standard-Farben & Schriftarten</strong><br>• Scrolle weiter nach unten<br>• Aktiviere <strong>"Standardfarben deaktivieren"</strong><br>• Aktiviere <strong>"Standardschriftarten deaktivieren"</strong><br><br><strong>4. Speichern</strong><br>• Klicke auf <strong>"Änderungen speichern"</strong> ganz unten<br>• Kehre zu diesem Tab zurück und klicke auf "Konfiguration prüfen"', 'psycho-wizard'); ?>
            </div>
        </div>

        <!-- Buttons -->
        <div style="display: flex; gap: 15px; margin-top: 30px;">
            <a href="<?php echo admin_url('admin.php?page=elementor-settings'); ?>"
               target="_blank"
               class="btn btn-primary"
               style="text-decoration: none; display: inline-block;">
                <?php _e('Open Elementor Settings (new tab)', 'psycho-wizard'); ?>
            </a>

            <button type="button"
                    class="btn btn-secondary"
                    id="checkTeamSettingsBtn"
                    onclick="checkTeamSettings()">
                <?php _e('Check Configuration', 'psycho-wizard'); ?>
            </button>
        </div>

        <!-- Status Anzeige -->
        <div id="teamSettingsDisplay" style="margin-top: 20px; padding: 15px; border-radius: 8px; display: none;">
            <div id="teamSettingsText"></div>
        </div>

        <div class="warning-box" style="margin-top: 30px;">
            <div class="warning-box-title"><?php _e('⚠️ Wichtig', 'psycho-wizard'); ?></div>
            <div class="warning-box-content">
                <?php _e('<strong>Warum ist das wichtig?</strong><br><br><strong>Team Post Type:</strong><br>Ermöglicht die Verwaltung deiner Team-Mitglieder mit allen 40+ Custom Fields (Foto, Position, Qualifikationen, etc.)<br><br><strong>Standardfarben deaktivieren:</strong><br>Deine Template-Farben werden verwendet statt Elementor-Standard. So siehst du sofort die richtigen Farben auf deiner Website.<br><br><strong>Standardschriftarten deaktivieren:</strong><br>Deine Template-Fonts werden verwendet. So erscheinen alle Texte in der korrekten Schriftart.', 'psycho-wizard'); ?>
            </div>
        </div>

        <div class="info-box" style="margin-top: 20px;">
            <div class="info-box-title"><?php _e('💡 Tipp', 'psycho-wizard'); ?></div>
            <div class="info-box-content">
                <?php _e('Der <strong>Team Post Type</strong> erscheint nur, wenn das ACF JSON erfolgreich importiert wurde (Schritt 6).<br>Falls "Team" nicht sichtbar ist, gehe zurück zu Schritt 6 und importiere das ACF JSON erneut.', 'psycho-wizard'); ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
// Status beim Laden setzen
jQuery(document).ready(function($) {
    <?php if ($is_configured): ?>
        // Bereits konfiguriert
        window.markStepCompleted(7);
        window.updateButtons();
    <?php endif; ?>
});

// Check Funktion
window.checkTeamSettings = function() {
    const $ = jQuery;
    const $btn = $('#checkTeamSettingsBtn');
    const $statusDisplay = $('#teamSettingsDisplay');
    const $statusText = $('#teamSettingsText');

    $btn.prop('disabled', true).text(<?php echo json_encode(__('⏳ Prüfe Einstellungen...', 'psycho-wizard')); ?>);
    $statusDisplay.hide();

    $.ajax({
        url: psychoWizard.ajaxUrl,
        type: 'POST',
        data: {
            action: 'psycho_check_team_settings',
            nonce: psychoWizard.nonce
        },
        success: function(response) {
            console.log('Team settings check:', response);
            $btn.prop('disabled', false).text(<?php echo json_encode(__('🔄 Konfiguration prüfen', 'psycho-wizard')); ?>);

            if (response.success && response.data.all_configured) {
                // Alles konfiguriert!
                $statusDisplay.css('background', '#d1fae5').css('border', '2px solid #10b981').show();
                $statusText.html(<?php echo json_encode(__('✅ <strong>Perfekt konfiguriert!</strong><br>Team CPT: ', 'psycho-wizard')); ?> + (response.data.team_active ? '✓' : '✗') + ' | ' +
                               <?php echo json_encode(__('Farben: ', 'psycho-wizard')); ?> + (response.data.colors_disabled ? '✓' : '✗') + ' | ' +
                               <?php echo json_encode(__('Fonts: ', 'psycho-wizard')); ?> + (response.data.fonts_disabled ? '✓' : '✗'));

                if (typeof window.markStepCompleted === 'function') {
                    window.markStepCompleted(7);
                }
                if (typeof window.updateButtons === 'function') {
                    window.updateButtons();
                }
            } else {
                // Noch nicht vollständig
                let missingItems = [];
                if (!response.data.team_active) missingItems.push(<?php echo json_encode(__('Team CPT nicht aktiviert', 'psycho-wizard')); ?>);
                if (!response.data.colors_disabled) missingItems.push(<?php echo json_encode(__('Standardfarben noch aktiv', 'psycho-wizard')); ?>);
                if (!response.data.fonts_disabled) missingItems.push(<?php echo json_encode(__('Standardschriftarten noch aktiv', 'psycho-wizard')); ?>);

                $statusDisplay.css('background', '#fef3c7').css('border', '2px solid #f59e0b').show();
                $statusText.html(<?php echo json_encode(__('⚠️ <strong>Noch nicht vollständig konfiguriert</strong><br>', 'psycho-wizard')); ?> +
                               missingItems.join('<br>'));
            }
        },
        error: function(xhr, status, error) {
            console.error('Team settings check error:', xhr.responseText);
            $btn.prop('disabled', false).text(<?php echo json_encode(__('🔄 Konfiguration prüfen', 'psycho-wizard')); ?>);
            $statusDisplay.css('background', '#fee2e2').css('border', '2px solid #ef4444').show();
            $statusText.html(<?php echo json_encode(__('❌ <strong>Fehler beim Prüfen</strong><br>Bitte versuche es erneut.', 'psycho-wizard')); ?>);
        }
    });
};
</script>
