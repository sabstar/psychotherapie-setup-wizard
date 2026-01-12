<?php
/**
 * Step 12: WordPress Settings
 */
if (!defined('ABSPATH')) {
    exit;
}

$wizard_status = Psycho_Status_Checker::get_wizard_status();
$is_configured = isset($wizard_status['settings_configured']) && $wizard_status['settings_configured'];

// URLs für die Links vorbereiten
$customizer_url = admin_url('customize.php');
$menus_url = admin_url('nav-menus.php');
?>

<div class="wizard-step" data-step="12">
    <h2><?php _e('WordPress Einstellungen', 'psycho-wizard'); ?></h2>
    <p class="step-description">
        <?php _e('Konfiguriere die grundlegenden WordPress-Einstellungen für deine Psychotherapie-Praxis.', 'psycho-wizard'); ?>
    </p>

    <!-- Automatische Konfiguration -->
    <div style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 30px; margin-bottom: 30px;">
        <h3 style="font-size: 20px; margin-bottom: 20px; color: #1e293b;"><?php _e('⚙️ Automatische Konfiguration', 'psycho-wizard'); ?></h3>

        <?php if ($is_configured): ?>
            <div class="info-box" style="background: #d1fae5; border-color: #10b981; margin-bottom: 20px;">
                <div class="info-box-title" style="color: #065f46;"><?php _e('✅ Automatisch konfiguriert', 'psycho-wizard'); ?></div>
                <div class="info-box-content" style="color: #065f46;">
                    <?php _e('• Homepage als Startseite festgelegt<br>• Blog-Seite für Beiträge zugewiesen<br>• SEO-freundliche Permalinks aktiviert<br>• Menü-Optionen konfiguriert (Team, Tags, Job Title, Therapy Focus, Link Target)', 'psycho-wizard'); ?>
                </div>
            </div>

            <!-- Button zum erneuten Anwenden -->
            <div style="margin-top: 20px;">
                <button type="button" class="btn btn-secondary" id="reapplySettingsBtn" onclick="reapplySettings()">
                    <?php _e('🔄 Einstellungen erneut anwenden', 'psycho-wizard'); ?>
                </button>
                <p style="color: #64748b; margin-top: 10px; font-size: 13px;">
                    <?php _e('Wendet alle Einstellungen erneut an (z.B. um neue Features zu aktivieren).', 'psycho-wizard'); ?>
                </p>
            </div>
        <?php else: ?>
            <p style="color: #64748b; margin-bottom: 20px;">
                <?php _e('Klicke auf den Button um Homepage, Blog-Seite, Permalinks und Datenschutzseiten automatisch zu konfigurieren.', 'psycho-wizard'); ?>
            </p>

            <button type="button" class="btn btn-primary" id="saveSettingsBtn" onclick="saveWPSettings()" style="margin-bottom: 20px;">
                <?php _e('⚙️ Einstellungen übernehmen', 'psycho-wizard'); ?>
            </button>

            <div class="info-box" style="background: #eff6ff; border-color: #3b82f6;">
                <div class="info-box-title" style="color: #1e40af;"><?php _e('ℹ️ Was wird konfiguriert?', 'psycho-wizard'); ?></div>
                <div class="info-box-content" style="color: #1e40af;">
                    <?php _e('• <strong>Startseite:</strong> Die "Home" Seite wird als statische Startseite festgelegt<br>• <strong>Blog-Seite:</strong> Die "Blog" Seite wird für Blog-Beiträge zugewiesen<br>• <strong>Datenschutz & Impressum:</strong> Werden veröffentlicht<br>• <strong>Permalinks:</strong> Auf SEO-freundliche URLs umgestellt (/%postname%/)', 'psycho-wizard'); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Manuelle Anpassungen -->
    <div style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 30px; margin-bottom: 30px;">
        <h3 style="font-size: 20px; margin-bottom: 20px; color: #1e293b;"><?php _e('🎨 Manuelle Anpassungen', 'psycho-wizard'); ?></h3>

        <!-- Home & Blog Seite -->
        <div style="margin-bottom: 40px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                <div style="background: #10b981; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0;">1</div>
                <h4 style="margin: 0; font-size: 16px; font-weight: 600; color: #1e293b;"><?php _e('Home und Blog Seite festlegen (optional)', 'psycho-wizard'); ?></h4>
            </div>
            <p style="color: #64748b; margin-bottom: 15px; padding-left: 44px;">
                <?php _e('Falls du die Zuweisung manuell ändern möchtest, gehe zu <strong>Design → Customizer</strong>.<br>Bei <strong>Homepage Einstellungen</strong> legst du deine Startseite und Blogseite fest.', 'psycho-wizard'); ?>
            </p>
            <img src="<?php echo esc_url(PSYCHO_WIZARD_URL . 'assets/images/set_home_and_blog_page.png'); ?>" alt="<?php esc_attr_e('Homepage und Blog festlegen', 'psycho-wizard'); ?>" style="max-width: 25%; height: auto; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-left: 44px;">
        </div>

        <!-- Logo & Website Icon -->
        <div style="margin-bottom: 40px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                <div style="background: #10b981; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0;">2</div>
                <h4 style="margin: 0; font-size: 16px; font-weight: 600; color: #1e293b;"><?php _e('Logo und Website Icon hochladen', 'psycho-wizard'); ?></h4>
            </div>
            <p style="color: #64748b; margin-bottom: 15px; padding-left: 44px;">
                <?php _e('Im Customizer unter <strong>Website Informationen</strong> lädst du dein Logo und auch das Website Icon (Favicon) hoch.', 'psycho-wizard'); ?>
            </p>
            <img src="<?php echo esc_url(PSYCHO_WIZARD_URL . 'assets/images/select_logo_and_favicon.png'); ?>" alt="<?php esc_attr_e('Logo und Icon hochladen', 'psycho-wizard'); ?>" style="max-width: 25%; height: auto; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-left: 44px;">
        </div>

        <!-- Main Menu - Adjust navigation menus -->
        <div style="margin-bottom: 40px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                <div style="background: #10b981; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0;">3</div>
                <h4 style="margin: 0; font-size: 16px; font-weight: 600; color: #1e293b;"><?php _e('Navigationsmenüs anpassen', 'psycho-wizard'); ?></h4>
            </div>
            <div style="padding-left: 44px;">
                <ol style="color: #64748b; margin-bottom: 20px; padding-left: 20px;">
                    <li style="margin-bottom: 10px;"><?php _e('Gehe zu <strong>Design → Menüs</strong> und wähle <strong>Psychotherapy Main Menu</strong> aus und klicke auf <strong>"Auswählen"</strong> (Nummer 1)', 'psycho-wizard'); ?></li>
                    <li style="margin-bottom: 10px;"><?php _e('Gehe zu <strong>Seiten</strong> oder <strong>Team</strong> oder einer anderen Seite, die du hinzufügen oder entfernen möchtest und klicke entweder auf <strong>"Zum Menü hinzufügen"</strong> oder auf <strong>"Entfernen"</strong> (Nummer 2)', 'psycho-wizard'); ?></li>
                    <li style="margin-bottom: 10px;"><?php _e('Falls du nicht alle Elemente siehst, klicke auf <strong>"Alle anzeigen"</strong> (Nummer 3)', 'psycho-wizard'); ?></li>
                    <li style="margin-bottom: 10px;"><?php _e('Passe deine Navigationsbeschriftungen an (Nummer 4)', 'psycho-wizard'); ?></li>
                    <li style="margin-bottom: 10px;"><?php _e('Weise das Menü dem <strong>Header</strong> zu und klicke auf <strong>"Speichern"</strong>', 'psycho-wizard'); ?></li>
                </ol>

                <img src="<?php echo esc_url(PSYCHO_WIZARD_URL . 'assets/images/manage menu items.png'); ?>" alt="<?php esc_attr_e('Menüpunkte verwalten', 'psycho-wizard'); ?>" style="max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 15px;">

                <img src="<?php echo esc_url(PSYCHO_WIZARD_URL . 'assets/images/set header and save.png'); ?>" alt="<?php esc_attr_e('Header zuweisen und speichern', 'psycho-wizard'); ?>" style="max-width: 50%; height: auto; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            </div>
        </div>

        <!-- Edit footer Legal Menu -->
        <div style="margin-bottom: 40px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                <div style="background: #10b981; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0;">4</div>
                <h4 style="margin: 0; font-size: 16px; font-weight: 600; color: #1e293b;"><?php _e('Footer Legal-Menü bearbeiten', 'psycho-wizard'); ?></h4>
            </div>
            <div style="padding-left: 44px;">
                <ol style="color: #64748b; margin-bottom: 20px; padding-left: 20px;">
                    <li style="margin-bottom: 10px;"><?php _e('Gehe zu <strong>Design → Menüs</strong>', 'psycho-wizard'); ?></li>
                    <li style="margin-bottom: 10px;"><?php _e('Wähle das <strong>Footer menu legal</strong> aus und klicke auf <strong>"Auswählen"</strong> (Nummer 1)', 'psycho-wizard'); ?></li>
                    <li style="margin-bottom: 10px;"><?php _e('Wähle auf der linken Seite die <strong>Datenschutzseite</strong> aus und klicke auf <strong>"Zum Menü hinzufügen"</strong> (Nummer 2)', 'psycho-wizard'); ?></li>
                    <li style="margin-bottom: 10px;"><?php _e('Wähle als Anzeigeposition <strong>Footer</strong> aus (Nummer 3)', 'psycho-wizard'); ?></li>
                    <li style="margin-bottom: 10px;"><?php _e('Klicke auf <strong>"Speichern"</strong> (Nummer 4)', 'psycho-wizard'); ?></li>
                </ol>

                <img src="<?php echo esc_url(PSYCHO_WIZARD_URL . 'assets/images/legal_menu.png'); ?>" alt="<?php esc_attr_e('Legal-Menü', 'psycho-wizard'); ?>" style="max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            </div>
        </div>
    </div>

    <!-- Abschluss-Box -->
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; padding: 30px; color: white; text-align: center; margin-bottom: 30px;">
        <h3 style="margin: 0 0 15px 0; font-size: 24px; color: white;"><?php _e('🎉 Grund-Setup abgeschlossen!', 'psycho-wizard'); ?></h3>
        <p style="margin: 0; font-size: 16px; opacity: 0.95;">
            <?php _e('Damit ist das Grund-Setup fertig. Jetzt geht es daran, deine Seite zu personalisieren und deine eigenen Farben, Schriften und Inhalte einzufügen.', 'psycho-wizard'); ?>
        </p>
    </div>

</div>

<script>
jQuery(document).ready(function($) {
    <?php if ($is_configured): ?>
        if (typeof window.markStepCompleted === 'function') {
            window.markStepCompleted(12);
        }
        if (typeof window.updateButtons === 'function') {
            window.updateButtons();
        }
    <?php endif; ?>
});

function saveWPSettings() {
    const $btn = jQuery('#saveSettingsBtn');
    $btn.prop('disabled', true).text(<?php echo json_encode(__('⚙️ Konfiguriere...', 'psycho-wizard')); ?>);

    console.log('Saving WP Settings...', {
        url: psychoWizard.ajaxUrl,
        nonce: psychoWizard.nonce
    });

    jQuery.ajax({
        url: psychoWizard.ajaxUrl,
        type: 'POST',
        data: {
            action: 'psycho_save_wp_settings',
            nonce: psychoWizard.nonce
        },
        success: function(response) {
            console.log('AJAX Response:', response);

            if (response.success) {
                showNotification('success', response.data.message);
                window.markStepCompleted(12);
                // Update progress bubble immediately
                jQuery(`.step[data-step="12"]`).addClass('completed');

                // Button verstecken und Success-Ansicht zeigen
                $btn.closest('div').fadeOut(300);

                // Success Box anzeigen
                setTimeout(function() {
                    const successBox = jQuery('<div class="info-box" style="background: #d1fae5; border-color: #10b981; margin-bottom: 20px;">' +
                        '<div class="info-box-title" style="color: #065f46;">' + <?php echo json_encode(__('✅ Automatisch konfiguriert', 'psycho-wizard')); ?> + '</div>' +
                        '<div class="info-box-content" style="color: #065f46;">' +
                        <?php echo json_encode(__('• Homepage als Startseite festgelegt<br>• Blog-Seite für Beiträge zugewiesen<br>• SEO-freundliche Permalinks aktiviert<br>• Menü-Optionen konfiguriert (Team, Tags, Job Title, Therapy Focus, Link Target)', 'psycho-wizard')); ?> +
                        '</div>' +
                        '</div>');

                    jQuery('h3:contains("' + <?php echo json_encode(__('Automatische Konfiguration', 'psycho-wizard')); ?> + '")').after(successBox);
                    window.updateButtons();
                }, 400);
            } else {
                $btn.prop('disabled', false).text(<?php echo json_encode(__('⚙️ Einstellungen übernehmen', 'psycho-wizard')); ?>);
                showNotification('error', response.data.message || <?php echo json_encode(__('Ein Fehler ist aufgetreten', 'psycho-wizard')); ?>);
                console.error('Error response:', response);
            }
        },
        error: function(xhr, status, error) {
            $btn.prop('disabled', false).text(<?php echo json_encode(__('⚙️ Einstellungen übernehmen', 'psycho-wizard')); ?>);
            showNotification('error', <?php echo json_encode(__('Ein Fehler ist aufgetreten. Bitte versuche es erneut.', 'psycho-wizard')); ?>);
            console.error('AJAX Error:', {xhr: xhr, status: status, error: error});
        }
    });
}

// Einstellungen erneut anwenden (ohne Confirmation)
function reapplySettings() {
    const $btn = jQuery('#reapplySettingsBtn');
    $btn.prop('disabled', true).text(<?php echo json_encode(__('🔄 Wende an...', 'psycho-wizard')); ?>);

    jQuery.ajax({
        url: psychoWizard.ajaxUrl,
        type: 'POST',
        data: {
            action: 'psycho_save_wp_settings',
            nonce: psychoWizard.nonce
        },
        success: function(response) {
            if (response.success) {
                showNotification('success', response.data.message);
                $btn.prop('disabled', false).text(<?php echo json_encode(__('🔄 Einstellungen erneut anwenden', 'psycho-wizard')); ?>);
            } else {
                $btn.prop('disabled', false).text(<?php echo json_encode(__('🔄 Einstellungen erneut anwenden', 'psycho-wizard')); ?>);
                showNotification('error', response.data.message || <?php echo json_encode(__('Ein Fehler ist aufgetreten', 'psycho-wizard')); ?>);
            }
        },
        error: function() {
            $btn.prop('disabled', false).text(<?php echo json_encode(__('🔄 Einstellungen erneut anwenden', 'psycho-wizard')); ?>);
            showNotification('error', <?php echo json_encode(__('Ein Fehler ist aufgetreten. Bitte versuche es erneut.', 'psycho-wizard')); ?>);
        }
    });
}
</script>
