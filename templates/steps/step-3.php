<?php
/**
 * Step 3: Elementor
 */
if (!defined('ABSPATH')) {
    exit;
}

// Prüfe ob Elementor bereits installiert ist (auch wenn deaktiviert)
$elementor_plugin_path = WP_PLUGIN_DIR . '/elementor/elementor.php';
$is_elementor_installed = file_exists($elementor_plugin_path);
$is_elementor_active = is_plugin_active('elementor/elementor.php');
?>

<div class="wizard-step" data-step="3">
    <h2><?php _e('Elementor installieren & aktivieren', 'psycho-wizard'); ?></h2>
    <p class="step-description">
        <?php _e('Elementor ist der Page Builder, mit dem alle Templates erstellt wurden.', 'psycho-wizard'); ?>
    </p>

    <?php if ($is_elementor_installed && $is_elementor_active): ?>
        <!-- Elementor bereits installiert und aktiv -->
        <div class="info-box" style="background: #d1fae5; border-color: #10b981;">
            <div class="info-box-title" style="color: #065f46;"><?php _e('✅ Elementor ist aktiv!', 'psycho-wizard'); ?></div>
            <div class="info-box-content" style="color: #065f46;">
                <strong><?php _e('Elementor Status:', 'psycho-wizard'); ?></strong><br>
                <?php _e('• Plugin: ✅ Installiert und aktiviert', 'psycho-wizard'); ?><br><br>
                <?php _e('Du kannst direkt zum nächsten Schritt weitergehen!', 'psycho-wizard'); ?>
            </div>
        </div>

        <div style="margin-top: 20px;">
            <button type="button"
                    class="btn btn-secondary"
                    id="recheckElementorBtn">
                <?php _e('🔄 Status erneut prüfen', 'psycho-wizard'); ?>
            </button>
        </div>

        <div id="elementorStatusDisplay" style="margin-top: 20px; padding: 15px; border-radius: 8px; display: none;">
            <div id="elementorStatusText"></div>
        </div>

    <?php elseif ($is_elementor_installed && !$is_elementor_active): ?>
        <!-- Elementor installiert, aber deaktiviert -->
        <div class="info-box" style="background: #fef3c7; border-color: #f59e0b;">
            <div class="info-box-title" style="color: #92400e;"><?php _e('✅ Plugin bereits installiert', 'psycho-wizard'); ?></div>
            <div class="info-box-content" style="color: #92400e;">
                <strong><?php _e('Elementor ist bereits auf deinem System installiert, aber momentan deaktiviert.', 'psycho-wizard'); ?></strong><br><br>
                <?php _e('Du musst es nicht nochmal installieren! Aktiviere es einfach über die Plugins-Seite.', 'psycho-wizard'); ?>
            </div>
        </div>

        <div style="margin-top: 30px;">
            <div class="info-box">
                <div class="info-box-title"><?php _e('🔌 Plugin aktivieren', 'psycho-wizard'); ?></div>
                <div class="info-box-content">
                    <strong><?php _e('So geht\'s:', 'psycho-wizard'); ?></strong><br>
                    <?php _e('1. Klicke auf "Elementor aktivieren" (öffnet Plugins-Seite in neuem Tab)', 'psycho-wizard'); ?><br>
                    <?php _e('2. Finde <strong>"Elementor"</strong> in der Plugin-Liste und klicke auf <strong>"Aktivieren"</strong>', 'psycho-wizard'); ?><br>
                    <?php _e('3. Kehre zu diesem Tab zurück und klicke auf "Status prüfen"', 'psycho-wizard'); ?>
                </div>
            </div>

            <div style="display: flex; gap: 15px; margin-top: 20px;">
                <a href="<?php echo admin_url('plugins.php'); ?>"
                   target="_blank"
                   class="btn btn-primary"
                   style="text-decoration: none; display: inline-block;">
                    <?php _e('🔗 Elementor aktivieren (öffnet in neuem Tab)', 'psycho-wizard'); ?>
                </a>

                <button type="button"
                        class="btn btn-secondary"
                        id="checkElementorStatusBtn">
                    <?php _e('🔄 Status prüfen', 'psycho-wizard'); ?>
                </button>
            </div>

            <div id="elementorStatusDisplay" style="margin-top: 20px; padding: 15px; border-radius: 8px; display: none;">
                <div id="elementorStatusText"></div>
            </div>
        </div>

    <?php else: ?>
        <!-- Elementor noch nicht installiert -->
        <div class="plugin-list">
            <div class="plugin-item">
                <div class="plugin-info">
                    <div class="plugin-name"><?php _e('Elementor', 'psycho-wizard'); ?></div>
                    <div class="plugin-desc"><?php _e('Visueller Page Builder für WordPress', 'psycho-wizard'); ?></div>
                </div>
                <div class="plugin-status status-pending" id="elementor"><?php _e('Bereit zur Installation', 'psycho-wizard'); ?></div>
            </div>
        </div>

        <div class="info-box" style="margin-top: 20px;">
            <div class="info-box-title"><?php _e('ℹ️ Installation', 'psycho-wizard'); ?></div>
            <div class="info-box-content">
                <?php _e('Klicke auf <strong>"Elementor installieren"</strong> um das Plugin automatisch aus dem WordPress Repository zu installieren und zu aktivieren.', 'psycho-wizard'); ?>
            </div>
        </div>

        <div style="margin-top: 20px;">
            <button type="button"
                    class="btn btn-primary"
                    id="installElementorBtn"
                    onclick="installElementor()">
                <?php _e('🚀 Elementor installieren', 'psycho-wizard'); ?>
            </button>
        </div>
    <?php endif; ?>
</div>

<script>
(function($) {
    // Elementor Installation
    window.installElementor = function() {
        const $btn = $('#installElementorBtn');
        const $status = $('#elementor');

        $btn.prop('disabled', true).text(<?php echo json_encode(__('⏳ Installiere...', 'psycho-wizard')); ?>);
        $status.removeClass('status-pending').addClass('status-installing').text(<?php echo json_encode(__('Installiere...', 'psycho-wizard')); ?>);

        $.ajax({
            url: psychoWizard.ajaxUrl,
            type: 'POST',
            data: {
                action: 'psycho_install_elementor',
                nonce: psychoWizard.nonce
            },
            success: function(response) {
                if (response.success) {
                    $status.removeClass('status-installing').addClass('status-installed').text(psychoWizard.i18n.installed);
                    $btn.hide();

                    window.showNotification('success', '✅ Elementor erfolgreich installiert und aktiviert!');

                    // Speichere dass kein Auto-Jump nach Reload erfolgen soll
                    sessionStorage.setItem('psycho_wizard_no_autojump', 'true');
                    sessionStorage.setItem('psycho_wizard_stay_on_step', '3');

                    // Reload nach 2 Sekunden
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    $status.removeClass('status-installing').addClass('status-pending').text(<?php echo json_encode(__('Fehler', 'psycho-wizard')); ?>);
                    $btn.prop('disabled', false).text(<?php echo json_encode(__('🚀 Elementor installieren', 'psycho-wizard')); ?>);
                    window.showNotification('error', response.data.message || 'Installation fehlgeschlagen');
                }
            },
            error: function() {
                $status.removeClass('status-installing').addClass('status-pending').text(<?php echo json_encode(__('Fehler', 'psycho-wizard')); ?>);
                $btn.prop('disabled', false).text(<?php echo json_encode(__('🚀 Elementor installieren', 'psycho-wizard')); ?>);
                window.showNotification('error', 'Fehler beim Installieren. Bitte versuche es erneut.');
            }
        });
    };

    // Status beim Laden setzen
    $(document).ready(function() {
    <?php if ($is_elementor_installed && $is_elementor_active): ?>
        // Elementor bereits installiert und aktiv
        window.updateButtons();
    <?php elseif ($is_elementor_installed): ?>
        // Elementor installiert, aber nicht aktiv
        window.updateButtons();
    <?php endif; ?>

    // Status prüfen Button Handler
    $('#checkElementorStatusBtn, #recheckElementorBtn').on('click', function() {
        const $btn = $(this);
        const $statusDisplay = $('#elementorStatusDisplay');
        const $statusText = $('#elementorStatusText');

        $btn.prop('disabled', true).text(<?php echo json_encode(__('⏳ Prüfe Status...', 'psycho-wizard')); ?>);

        $.ajax({
            url: psychoWizard.ajaxUrl,
            type: 'POST',
            data: {
                action: 'psycho_get_status',
                nonce: psychoWizard.nonce
            },
            success: function(response) {
                $btn.prop('disabled', false).text(<?php echo json_encode(__('🔄 Status prüfen', 'psycho-wizard')); ?>);

                if (response.success && response.data.elementor_active) {
                    // Elementor ist jetzt aktiv!
                    $statusDisplay.show().css('background', '#d1fae5').css('border', '2px solid #10b981');
                    $statusText.html(<?php echo json_encode('<strong style="color: #065f46;">' . __('✅ Elementor ist jetzt aktiv!', 'psycho-wizard') . '</strong><br>' . __('Die Seite wird in 2 Sekunden aktualisiert...', 'psycho-wizard')); ?>);

                    // Speichere dass kein Auto-Jump nach Reload erfolgen soll UND aktuellen Step
                    sessionStorage.setItem('psycho_wizard_no_autojump', 'true');
                    sessionStorage.setItem('psycho_wizard_stay_on_step', '3');

                    // Lade Status neu (ohne auto-jump da wir gleich reloaden)
                    if (typeof loadWizardStatus === 'function') {
                        loadWizardStatus(false);
                    }

                    // Reload nach 2 Sekunden damit die neue Ansicht geladen wird
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    // Noch nicht aktiv
                    $statusDisplay.show().css('background', '#fef3c7').css('border', '2px solid #f59e0b');
                    $statusText.html(<?php echo json_encode('<strong style="color: #92400e;">' . __('⚠️ Elementor ist noch nicht aktiviert', 'psycho-wizard') . '</strong><br>' . __('Bitte aktiviere Elementor über die Plugins-Seite.', 'psycho-wizard')); ?>);
                }
            },
            error: function() {
                $btn.prop('disabled', false).text(<?php echo json_encode(__('🔄 Status prüfen', 'psycho-wizard')); ?>);
                $statusDisplay.show().css('background', '#fee').css('border', '2px solid #dc2626');
                $statusText.html(<?php echo json_encode('<strong style="color: #991b1b;">' . __('❌ Fehler beim Status-Check', 'psycho-wizard') . '</strong><br>' . __('Bitte versuche es erneut.', 'psycho-wizard')); ?>);
            }
        });
    });  // Schließt den click handler
    });  // Schließt $(document).ready
})(jQuery);  // Schließt die IIFE
</script>
