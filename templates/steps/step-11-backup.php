<?php
/**
 * Step 11: WordPress Settings
 */
if (!defined('ABSPATH')) {
    exit;
}

$wizard_status = Psycho_Status_Checker::get_wizard_status();
$is_configured = isset($wizard_status['settings_configured']) && $wizard_status['settings_configured'];

// URLs für die Links vorbereiten
$customizer_url = admin_url('customize.php?autofocus[section]=title_tagline');
$menus_url = admin_url('nav-menus.php');
$pages_url = admin_url('edit.php?post_type=page');
$single_pages_url = admin_url('edit.php?post_type=elementor_library&elementor_library_type=page');
?>

<div class="wizard-step" data-step="11">
    <h2>WordPress Einstellungen</h2>
    <p class="step-description">
        <?php if ($is_configured): ?>
            ✅ Grundeinstellungen wurden konfiguriert! Jetzt kannst du deine Website personalisieren.
        <?php else: ?>
            Konfiguriere die grundlegenden WordPress-Einstellungen für deine Psychotherapie-Praxis.
        <?php endif; ?>
    </p>

    <?php if ($is_configured): ?>
        <div class="info-box" style="background: #d1fae5; border-color: #10b981; margin-bottom: 30px;">
            <div class="info-box-title" style="color: #065f46;">✅ Automatische Konfiguration abgeschlossen!</div>
            <div class="info-box-content" style="color: #065f46;">
                • Homepage und Blog-Seite wurden zugewiesen<br>
                • Datenschutz und Impressum wurden veröffentlicht<br>
                • SEO-freundliche Permalinks wurden aktiviert
            </div>
        </div>

        <h3 style="margin-top: 30px; margin-bottom: 20px; font-size: 18px;">🎨 Nächste Schritte: Personalisierung</h3>
        <p style="color: #64748b; margin-bottom: 30px;">
            Die technische Einrichtung ist abgeschlossen. Jetzt kannst du deine Website mit deinen eigenen Inhalten personalisieren.
        </p>
    <?php endif; ?>

    <div class="settings-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">

        <!-- Automatische Settings -->
        <div class="setting-item" style="background: <?php echo $is_configured ? '#d1fae5' : '#f8fafc'; ?>; border: 2px solid <?php echo $is_configured ? '#10b981' : '#e2e8f0'; ?>; border-radius: 12px; padding: 20px;">
            <div class="setting-header" style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <div class="setting-icon" style="font-size: 32px;"><?php echo $is_configured ? '✅' : '🏠'; ?></div>
                <div class="setting-title" style="font-size: 16px; font-weight: 600; color: #1e293b;">Homepage & Blog-Seite</div>
            </div>
            <div class="setting-content" style="color: #64748b; font-size: 14px; line-height: 1.6;">
                <?php if ($is_configured): ?>
                    Automatisch konfiguriert:<br>
                    • "Home" als Startseite<br>
                    • "Blog" für Beiträge
                <?php else: ?>
                    Wird automatisch konfiguriert:<br>
                    Homepage und Blog-Seite werden aus deinem Template Kit zugewiesen.
                <?php endif; ?>
            </div>
        </div>

        <!-- Datenschutz & Impressum -->
        <div class="setting-item" style="background: <?php echo $is_configured ? '#d1fae5' : '#fff7ed'; ?>; border: 2px solid <?php echo $is_configured ? '#10b981' : '#fb923c'; ?>; border-radius: 12px; padding: 20px; <?php if (!$is_configured): ?>cursor: pointer; transition: transform 0.2s;<?php endif; ?>" <?php if (!$is_configured): ?>onclick="window.open('<?php echo esc_url($pages_url); ?>', '_blank');" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(251, 146, 60, 0.2)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';"<?php endif; ?>>
            <div class="setting-header" style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <div class="setting-icon" style="font-size: 32px;"><?php echo $is_configured ? '✅' : '🔒'; ?></div>
                <div class="setting-title" style="font-size: 16px; font-weight: 600; color: #1e293b;">Datenschutz & Impressum</div>
            </div>
            <div class="setting-content" style="color: #64748b; font-size: 14px; line-height: 1.6;<?php if (!$is_configured): ?> margin-bottom: 12px;<?php endif; ?>">
                <?php if ($is_configured): ?>
                    Seiten wurden veröffentlicht.<br>
                    Jetzt im Footer Menu verlinken.
                <?php else: ?>
                    Bearbeite erst deine Impressum- und Datenschutzseite, bevor du sie veröffentlichst.
                <?php endif; ?>
            </div>
            <?php if (!$is_configured): ?>
            <div style="display: inline-flex; align-items: center; gap: 6px; color: #fb923c; font-weight: 600; font-size: 14px;">
                → Zu Seiten
            </div>
            <?php endif; ?>
        </div>

        <!-- Logo & Favicon -->
        <div class="setting-item" style="background: #fff7ed; border: 2px solid #fb923c; border-radius: 12px; padding: 20px; cursor: pointer; transition: transform 0.2s;" onclick="window.open('<?php echo esc_url($customizer_url); ?>', '_blank');" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(251, 146, 60, 0.2)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
            <div class="setting-header" style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <div class="setting-icon" style="font-size: 32px;">🖼️</div>
                <div class="setting-title" style="font-size: 16px; font-weight: 600; color: #1e293b;">Logo & Favicon hochladen</div>
            </div>
            <div class="setting-content" style="color: #64748b; font-size: 14px; line-height: 1.6; margin-bottom: 12px;">
                Lade dein Praxis-Logo und Browser-Icon im WordPress Customizer hoch.
            </div>
            <div style="display: inline-flex; align-items: center; gap: 6px; color: #fb923c; font-weight: 600; font-size: 14px;">
                → Zum Customizer öffnen
            </div>
        </div>

        <!-- Menüs anpassen -->
        <div class="setting-item" style="background: #fff7ed; border: 2px solid #fb923c; border-radius: 12px; padding: 20px; cursor: pointer; transition: transform 0.2s;" onclick="window.open('<?php echo esc_url($menus_url); ?>', '_blank');" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(251, 146, 60, 0.2)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
            <div class="setting-header" style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <div class="setting-icon" style="font-size: 32px;">🧭</div>
                <div class="setting-title" style="font-size: 16px; font-weight: 600; color: #1e293b;">Menüs anpassen</div>
            </div>
            <div class="setting-content" style="color: #64748b; font-size: 14px; line-height: 1.6; margin-bottom: 12px;">
                Nach Veröffentlichung: Datenschutz & Impressum zum Footer Menu hinzufügen.<br>
                Entscheide: Team oder About Me? Blog-Link hinzufügen?
            </div>
            <div style="display: inline-flex; align-items: center; gap: 6px; color: #fb923c; font-weight: 600; font-size: 14px;">
                → Zu Design > Menüs
            </div>
        </div>

        <!-- Templates personalisieren -->
        <div class="setting-item" style="background: #fff7ed; border: 2px solid #fb923c; border-radius: 12px; padding: 20px; cursor: pointer; transition: transform 0.2s;" onclick="window.open('<?php echo esc_url($single_pages_url); ?>', '_blank');" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(251, 146, 60, 0.2)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
            <div class="setting-header" style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <div class="setting-icon" style="font-size: 32px;">✏️</div>
                <div class="setting-title" style="font-size: 16px; font-weight: 600; color: #1e293b;">Templates personalisieren</div>
            </div>
            <div class="setting-content" style="color: #64748b; font-size: 14px; line-height: 1.6; margin-bottom: 12px;">
                Passe Texte, Bilder und Sections in deinen Templates an.
            </div>
            <div style="display: inline-flex; align-items: center; gap: 6px; color: #fb923c; font-weight: 600; font-size: 14px;">
                → Zu Templates > Elementor > Single Pages
            </div>
        </div>

    </div>

    <?php if (!$is_configured): ?>
        <div style="margin-top: 30px;">
            <button type="button" class="btn btn-primary" id="saveSettingsBtn" onclick="saveWPSettings()">
                ⚙️ Einstellungen übernehmen & Fortfahren
            </button>
        </div>

        <div class="info-box" style="margin-top: 20px;">
            <div class="info-box-title">ℹ️ Was wird automatisch konfiguriert?</div>
            <div class="info-box-content">
                • <strong>Startseite:</strong> Die "Home" Seite wird als statische Startseite festgelegt<br>
                • <strong>Blog-Seite:</strong> Die "Blog" Seite wird für Blog-Beiträge zugewiesen<br>
                • <strong>Datenschutz & Impressum:</strong> Werden veröffentlicht und im Footer Legal Menu verlinkt<br>
                • <strong>Permalinks:</strong> Auf SEO-freundliche URLs umgestellt (/%postname%/)
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
jQuery(document).ready(function($) {
    <?php if ($is_configured): ?>
        if (typeof window.markStepCompleted === 'function') {
            window.markStepCompleted(11);
        }
        if (typeof window.updateButtons === 'function') {
            window.updateButtons();
        }
    <?php endif; ?>
});

function saveWPSettings() {
    const $btn = jQuery('#saveSettingsBtn');
    $btn.prop('disabled', true).text('⚙️ Konfiguriere...');

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
                window.markStepCompleted(11);

                // Button verstecken und Success-Ansicht anzeigen
                $btn.closest('div').fadeOut(300);
                jQuery('.info-box').fadeOut(300);

                // Info-Box und Kacheln aktualisieren
                setTimeout(function() {
                    // Ändere erste Kachel zu grün (Homepage & Blog)
                    jQuery('.setting-item').first().css({
                        'background': '#d1fae5',
                        'border-color': '#10b981'
                    }).find('.setting-icon').text('✅');

                    // Zweite Kachel (Datenschutz & Impressum) - Text ändern aber orange lassen
                    jQuery('.setting-item').eq(1).find('.setting-content').html(
                        'Seiten wurden veröffentlicht.<br>Jetzt im Footer Menu verlinken.'
                    );

                    // Step Description aktualisieren
                    jQuery('.step-description').html('✅ Grundeinstellungen wurden konfiguriert! Jetzt kannst du deine Website personalisieren.');

                    // Success Info-Box anzeigen
                    const successBox = jQuery('<div class="info-box" style="background: #d1fae5; border-color: #10b981; margin-bottom: 30px;">' +
                        '<div class="info-box-title" style="color: #065f46;">✅ Automatische Konfiguration abgeschlossen!</div>' +
                        '<div class="info-box-content" style="color: #065f46;">' +
                        '• Homepage und Blog-Seite wurden zugewiesen<br>' +
                        '• Datenschutz und Impressum wurden veröffentlicht<br>' +
                        '• SEO-freundliche Permalinks wurden aktiviert' +
                        '</div>' +
                        '</div>');

                    const personalizationHeader = jQuery('<h3 style="margin-top: 30px; margin-bottom: 20px; font-size: 18px;">🎨 Nächste Schritte: Personalisierung</h3>' +
                        '<p style="color: #64748b; margin-bottom: 30px;">' +
                        'Die technische Einrichtung ist abgeschlossen. Jetzt kannst du deine Website mit deinen eigenen Inhalten personalisieren.' +
                        '</p>');

                    jQuery('.settings-grid').before(successBox).before(personalizationHeader);

                    window.updateButtons();
                }, 400);
            } else {
                $btn.prop('disabled', false).text('⚙️ Einstellungen übernehmen & Fortfahren');
                showNotification('error', response.data.message || 'Ein Fehler ist aufgetreten');
                console.error('Error response:', response);
            }
        },
        error: function(xhr, status, error) {
            $btn.prop('disabled', false).text('⚙️ Einstellungen übernehmen & Fortfahren');
            showNotification('error', 'Ein Fehler ist aufgetreten. Bitte versuche es erneut.');
            console.error('AJAX Error:', {xhr: xhr, status: status, error: error});
        }
    });
}
</script>
