 <?php
/**
 * Step 2: Hello Theme
 */
if (!defined('ABSPATH')) {
    exit;
}

// Prüfe ob Hello Theme bereits installiert ist
$hello_theme = wp_get_theme('hello-elementor');
$is_hello_installed = $hello_theme->exists();
$current_theme = wp_get_theme();
$is_hello_active = ($current_theme->get_stylesheet() === 'hello-elementor');
?>

<div class="wizard-step" data-step="2">
    <h2><?php _e('Hello Theme installieren', 'psycho-wizard'); ?></h2>
    <p class="step-description">
        <?php _e('Das Hello Theme ist das offizielle, leichtgewichtige Theme von Elementor.', 'psycho-wizard'); ?>
    </p>

    <?php if ($is_hello_active): ?>
        <!-- Hello Theme bereits aktiv -->
        <div class="info-box" style="background: #d1fae5; border-color: #10b981;">
            <div class="info-box-title" style="color: #065f46;"><?php _e('✅ Hello Theme ist aktiv!', 'psycho-wizard'); ?></div>
            <div class="info-box-content" style="color: #065f46;">
                <?php _e('Das Hello Theme ist bereits installiert und aktiviert. Du kannst direkt zum nächsten Schritt weitergehen!', 'psycho-wizard'); ?>
            </div>
        </div>

    <?php else: ?>
        <!-- Hello Theme noch nicht aktiv -->
        <div class="plugin-list">
            <div class="plugin-item">
                <div class="plugin-info">
                    <div class="plugin-name"><?php _e('Hello Elementor', 'psycho-wizard'); ?></div>
                    <div class="plugin-desc"><?php _e('Minimalistisches Theme optimiert für Elementor', 'psycho-wizard'); ?></div>
                </div>
                <div class="plugin-status status-pending" id="helloTheme"><?php _e('Bereit', 'psycho-wizard'); ?></div>
            </div>
        </div>

        <div class="info-box">
            <div class="info-box-title"><?php _e('ℹ️ Warum Hello Theme?', 'psycho-wizard'); ?></div>
            <div class="info-box-content">
                <?php _e('Hello Theme ist extra schlank und enthält nur das Nötigste. Das sorgt für beste Performance und volle Kontrolle über dein Design mit Elementor.', 'psycho-wizard'); ?>
            </div>
        </div>

        <div style="margin-top: 20px;">
            <button type="button"
                    class="btn btn-primary"
                    id="installHelloThemeBtn"
                    onclick="installHelloTheme()">
                <?php _e('🚀 Hello Theme installieren', 'psycho-wizard'); ?>
            </button>
        </div>
    <?php endif; ?>
</div>

<script>
(function($) {
    // Hello Theme Installation
    window.installHelloTheme = function() {
        const $btn = $('#installHelloThemeBtn');
        const $status = $('#helloTheme');

        $btn.prop('disabled', true).text(<?php echo json_encode(__('⏳ Installiere...', 'psycho-wizard')); ?>);
        $status.removeClass('status-pending').addClass('status-installing').text(<?php echo json_encode(__('Installiere...', 'psycho-wizard')); ?>);

        $.ajax({
            url: psychoWizard.ajaxUrl,
            type: 'POST',
            data: {
                action: 'psycho_install_hello_theme',
                nonce: psychoWizard.nonce
            },
            success: function(response) {
                if (response.success) {
                    $status.removeClass('status-installing').addClass('status-installed').text(psychoWizard.i18n.installed);
                    $btn.hide();

                    window.showNotification('success', '✅ Hello Theme erfolgreich installiert und aktiviert!');

                    // Markiere Step 2 als abgeschlossen
                    window.markStepCompleted(2);
                    window.updateButtons();

                    // Reload nach 2 Sekunden
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    $status.removeClass('status-installing').addClass('status-pending').text(<?php echo json_encode(__('Fehler', 'psycho-wizard')); ?>);
                    $btn.prop('disabled', false).text(<?php echo json_encode(__('🚀 Hello Theme installieren', 'psycho-wizard')); ?>);
                    window.showNotification('error', response.data.message || 'Installation fehlgeschlagen');
                }
            },
            error: function() {
                $status.removeClass('status-installing').addClass('status-pending').text(<?php echo json_encode(__('Fehler', 'psycho-wizard')); ?>);
                $btn.prop('disabled', false).text(<?php echo json_encode(__('🚀 Hello Theme installieren', 'psycho-wizard')); ?>);
                window.showNotification('error', 'Fehler beim Installieren. Bitte versuche es erneut.');
            }
        });
    };

    $(document).ready(function() {
        <?php if ($is_hello_active): ?>
            // Hello Theme bereits aktiv - markiere als abgeschlossen
            window.markStepCompleted(2);
            window.updateButtons();
        <?php endif; ?>
    });
})(jQuery);
</script>