<?php
/**
 * Step 10: Datenschutzseite vorbereiten
 */
if (!defined('ABSPATH')) {
    exit;
}

$wizard_status = Psycho_Status_Checker::get_wizard_status();
$is_privacy_published = isset($wizard_status['privacy_page_published']) && $wizard_status['privacy_page_published'];

// Prüfe ob Datenschutzseite existiert
$privacy_page = get_page_by_title('Datenschutz');
if (!$privacy_page) {
    $privacy_page = get_page_by_title('Privacy Policy');
}

$privacy_status = $privacy_page ? $privacy_page->post_status : 'not_found';
$privacy_edit_url = $privacy_page ? admin_url('post.php?post=' . $privacy_page->ID . '&action=edit') : admin_url('options-privacy.php');
?>

<div class="wizard-step" data-step="10">
    <h2><?php _e('Datenschutzseite vorbereiten', 'psycho-wizard'); ?></h2>
    <p class="step-description">
        <?php _e('Bevor wir die Templates zuweisen, müssen wir die Datenschutzseite veröffentlichen.', 'psycho-wizard'); ?>
    </p>

    <!-- Wichtiger Hinweis -->
    <div class="info-box" style="background: #fef3c7; border-color: #f59e0b; margin-bottom: 30px;">
        <div class="info-box-title" style="color: #92400e;"><?php _e('⚠️ WICHTIG: Deine rechtliche Verantwortung!', 'psycho-wizard'); ?></div>
        <div class="info-box-content" style="color: #92400e;">
            <?php _e('Die Datenschutzseite ist <strong>deine rechtliche Verantwortung</strong>!<br><br>WordPress erstellt automatisch eine Standard-Datenschutzseite. Du <strong>MUSST</strong>:<br>• Den Inhalt an deine Praxis anpassen<br>• Rechtlich korrekte Informationen eintragen<br>• Bei Unsicherheit einen Anwalt konsultieren', 'psycho-wizard'); ?>
        </div>
    </div>

    <!-- Status Anzeige -->
    <div style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 30px; margin-bottom: 30px;">
        <h3 style="font-size: 20px; margin-bottom: 20px; color: #1e293b;"><?php _e('📄 Status der Datenschutzseite', 'psycho-wizard'); ?></h3>

        <?php if ($privacy_status === 'publish'): ?>
            <div class="info-box" style="background: #d1fae5; border-color: #10b981;">
                <div class="info-box-title" style="color: #065f46;"><?php _e('✅ Datenschutzseite ist veröffentlicht', 'psycho-wizard'); ?></div>
                <div class="info-box-content" style="color: #065f46;">
                    <?php _e('Die Datenschutzseite ist bereits veröffentlicht und kann den Templates zugewiesen werden.', 'psycho-wizard'); ?>
                </div>
            </div>
        <?php elseif ($privacy_status === 'draft'): ?>
            <div class="info-box" style="background: #fff7ed; border-color: #fb923c;">
                <div class="info-box-title" style="color: #c2410c;"><?php _e('📝 Datenschutzseite ist im Entwurf', 'psycho-wizard'); ?></div>
                <div class="info-box-content" style="color: #c2410c;">
                    <?php _e('Die Datenschutzseite existiert, ist aber noch nicht veröffentlicht.', 'psycho-wizard'); ?>
                </div>
            </div>
        <?php else: ?>
            <div class="info-box" style="background: #fee2e2; border-color: #ef4444;">
                <div class="info-box-title" style="color: #991b1b;"><?php _e('❌ Datenschutzseite nicht gefunden', 'psycho-wizard'); ?></div>
                <div class="info-box-content" style="color: #991b1b;">
                    <?php _e('Keine Datenschutzseite gefunden. Erstelle eine unter Einstellungen → Datenschutz.', 'psycho-wizard'); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Anleitung -->
    <div style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 30px; margin-bottom: 30px;">
        <h3 style="font-size: 20px; margin-bottom: 20px; color: #1e293b;"><?php _e('📋 So bereitest du die Datenschutzseite vor', 'psycho-wizard'); ?></h3>

        <div style="margin-bottom: 30px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                <div style="background: #3b82f6; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0;">1</div>
                <h4 style="margin: 0; font-size: 16px; font-weight: 600; color: #1e293b;"><?php _e('Gehe zu Einstellungen → Datenschutz', 'psycho-wizard'); ?></h4>
            </div>
            <p style="color: #64748b; margin-bottom: 15px; padding-left: 44px;">
                <?php _e('Öffne die Datenschutz-Einstellungen in WordPress.', 'psycho-wizard'); ?>
            </p>
        </div>

        <div style="margin-bottom: 30px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                <div style="background: #3b82f6; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0;">2</div>
                <h4 style="margin: 0; font-size: 16px; font-weight: 600; color: #1e293b;"><?php _e('Bearbeite die Datenschutzseite', 'psycho-wizard'); ?></h4>
            </div>
            <p style="color: #64748b; margin-bottom: 15px; padding-left: 44px;">
                <?php _e('Passe den Inhalt der Datenschutzseite an deine Praxis an. Stelle sicher, dass alle Informationen rechtlich korrekt sind.', 'psycho-wizard'); ?>
            </p>
            <?php if ($privacy_page): ?>
            <a href="<?php echo esc_url($privacy_edit_url); ?>" class="btn btn-secondary" target="_blank" style="margin-left: 44px; display: inline-block;">
                <?php _e('✏️ Datenschutzseite bearbeiten', 'psycho-wizard'); ?>
            </a>
            <?php endif; ?>
        </div>

        <div style="margin-bottom: 30px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                <div style="background: #3b82f6; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0;">3</div>
                <h4 style="margin: 0; font-size: 16px; font-weight: 600; color: #1e293b;"><?php _e('Veröffentliche die Seite', 'psycho-wizard'); ?></h4>
            </div>
            <p style="color: #64748b; margin-bottom: 15px; padding-left: 44px;">
                <?php _e('Nachdem du den Inhalt angepasst hast, klicke unten auf den Button um die Datenschutzseite zu veröffentlichen.', 'psycho-wizard'); ?>
            </p>
        </div>
    </div>

    <!-- Zusätzliche Info -->
    <div class="info-box" style="background: #dbeafe; border-color: #3b82f6; margin-bottom: 30px;">
        <div class="info-box-title" style="color: #1e40af;"><?php _e('ℹ️ Hinweis zur Impressum-Seite', 'psycho-wizard'); ?></div>
        <div class="info-box-content" style="color: #1e40af;">
            <?php _e('Die <strong>Impressum-Seite</strong> ist bereits in deinem Template Kit enthalten und veröffentlicht. Du musst nur noch den Inhalt mit deinen eigenen Daten anpassen.', 'psycho-wizard'); ?>
        </div>
    </div>

    <!-- Action Button -->
    <?php if ($privacy_status === 'publish'): ?>
        <div style="margin-top: 30px;">
            <button type="button" class="btn btn-primary" onclick="markPrivacyCompleted()">
                <?php _e('✅ Weiter zum nächsten Schritt', 'psycho-wizard'); ?>
            </button>
        </div>
    <?php else: ?>
        <div style="margin-top: 30px;">
            <button type="button" class="btn btn-primary" id="publishPrivacyBtn" onclick="publishPrivacyPage()">
                <?php _e('📢 Datenschutzseite jetzt veröffentlichen', 'psycho-wizard'); ?>
            </button>
        </div>
    <?php endif; ?>

</div>

<script>
jQuery(document).ready(function($) {
    <?php if ($privacy_status === 'publish'): ?>
        if (typeof window.markStepCompleted === 'function') {
            window.markStepCompleted(10);
        }
        if (typeof window.updateButtons === 'function') {
            window.updateButtons();
        }
    <?php endif; ?>
});

function publishPrivacyPage() {
    const $btn = jQuery('#publishPrivacyBtn');
    $btn.prop('disabled', true).text(<?php echo json_encode(__('📢 Veröffentliche...', 'psycho-wizard')); ?>);

    jQuery.ajax({
        url: psychoWizard.ajaxUrl,
        type: 'POST',
        data: {
            action: 'psycho_publish_privacy_page',
            nonce: psychoWizard.nonce
        },
        success: function(response) {
            if (response.success) {
                if (typeof window.showNotification === 'function') {
                    window.showNotification('success', response.data.message);
                }

                // Markiere Step als completed
                if (typeof window.markStepCompleted === 'function') {
                    window.markStepCompleted(10);
                }

                // Lade Wizard Status neu
                if (typeof loadWizardStatus === 'function') {
                    loadWizardStatus();
                }

                // Seite neu laden um Status zu aktualisieren
                setTimeout(function() {
                    location.reload();
                }, 1500);
            } else {
                $btn.prop('disabled', false).text(<?php echo json_encode(__('📢 Datenschutzseite jetzt veröffentlichen', 'psycho-wizard')); ?>);
                if (typeof window.showNotification === 'function') {
                    window.showNotification('error', response.data.message || <?php echo json_encode(__('Ein Fehler ist aufgetreten', 'psycho-wizard')); ?>);
                }
            }
        },
        error: function() {
            $btn.prop('disabled', false).text(<?php echo json_encode(__('📢 Datenschutzseite jetzt veröffentlichen', 'psycho-wizard')); ?>);
            if (typeof window.showNotification === 'function') {
                window.showNotification('error', <?php echo json_encode(__('Ein Fehler ist aufgetreten. Bitte versuche es erneut.', 'psycho-wizard')); ?>);
            }
        }
    });
}

function markPrivacyCompleted() {
    window.markStepCompleted(10);
    window.nextStep();
}
</script>
