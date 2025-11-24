<?php
/**
 * Step 4: Elementor Pro
 */
if (!defined('ABSPATH')) {
    exit;
}

// Prüfe ob Elementor Pro bereits installiert ist (auch wenn deaktiviert)
$pro_plugin_path = WP_PLUGIN_DIR . '/elementor-pro/elementor-pro.php';
$is_pro_installed = file_exists($pro_plugin_path);
$is_pro_active = is_plugin_active('elementor-pro/elementor-pro.php');
$is_license_active = Psycho_Status_Checker::is_elementor_pro_license_active();
?>

<div class="wizard-step" data-step="4">
    <h2><?php _e('Elementor Pro hochladen & aktivieren', 'psycho-wizard'); ?></h2>
    <p class="step-description">
        <?php if ($is_pro_installed && $is_license_active): ?>
            <?php _e('✅ Elementor Pro ist bereits installiert und die Lizenz ist aktiv!', 'psycho-wizard'); ?>
        <?php else: ?>
            <?php _e('Lade Elementor Pro hoch und aktiviere anschließend deine Lizenz.', 'psycho-wizard'); ?>
        <?php endif; ?>
    </p>
    
    <?php if ($is_pro_installed && $is_license_active): ?>
        <!-- Elementor Pro bereits installiert und aktiv -->
        <div class="info-box" style="background: #d1fae5; border-color: #10b981;">
            <div class="info-box-title" style="color: #065f46;"><?php _e('✅ Alles bereit!', 'psycho-wizard'); ?></div>
            <div class="info-box-content" style="color: #065f46;">
                <?php _e('<strong>Elementor Pro Status:</strong><br>• Plugin: ✅ Installiert und aktiviert<br>• Lizenz: ✅ Aktiv<br><br>Du kannst direkt zum nächsten Schritt weitergehen!', 'psycho-wizard'); ?>
            </div>
        </div>
        
        <div style="margin-top: 20px;">
            <button type="button"
                    class="btn btn-secondary"
                    id="recheckProBtn"
                    onclick="checkElementorProLicense()">
                <?php _e('🔄 Status erneut prüfen', 'psycho-wizard'); ?>
            </button>
        </div>
        
    <?php elseif ($is_pro_installed && !$is_pro_active): ?>
        <!-- Pro installiert, aber deaktiviert -->
        <div class="info-box" style="background: #fef3c7; border-color: #f59e0b;">
            <div class="info-box-title" style="color: #92400e;"><?php _e('✅ Plugin bereits installiert', 'psycho-wizard'); ?></div>
            <div class="info-box-content" style="color: #92400e;">
                <?php _e('<strong>Elementor Pro ist bereits auf deinem System installiert, aber momentan deaktiviert.</strong><br><br>Du musst es nicht nochmal hochladen! Aktiviere es einfach und verbinde dann die Lizenz.', 'psycho-wizard'); ?>
            </div>
        </div>

        <div id="licenseActivationSection" style="margin-top: 30px;">
            <div class="info-box">
                <div class="info-box-title"><?php _e('🔌 Plugin aktivieren & Lizenz verbinden', 'psycho-wizard'); ?></div>
                <div class="info-box-content">
                    <?php _e('<strong>So geht\'s:</strong><br>1. Klicke auf "Elementor Pro aktivieren" (öffnet Plugins-Seite in neuem Tab)<br>2. Finde <strong>"Elementor Pro"</strong> in der Plugin-Liste und klicke auf <strong>"Aktivieren"</strong><br>3. Klicke dann auf <strong>"Connect & Activate"</strong> um die Lizenz zu verbinden<br>4. Melde dich mit deinem Elementor-Account an<br>5. Kehre zu diesem Tab zurück und klicke auf "Status prüfen"', 'psycho-wizard'); ?>
                </div>
            </div>

            <div style="display: flex; gap: 15px; margin-top: 20px;">
                <a href="<?php echo admin_url('plugins.php'); ?>"
                   target="_blank"
                   class="btn btn-primary"
                   style="text-decoration: none; display: inline-block;">
                    <?php _e('🔗 Elementor Pro aktivieren (öffnet in neuem Tab)', 'psycho-wizard'); ?>
                </a>

                <button type="button"
                        class="btn btn-secondary"
                        id="checkLicenseBtn"
                        onclick="checkElementorProLicense()">
                    <?php _e('🔄 Status prüfen', 'psycho-wizard'); ?>
                </button>
            </div>

            <div id="licenseStatusDisplay" style="margin-top: 20px; padding: 15px; border-radius: 8px; display: none;">
                <div id="licenseStatusText"></div>
            </div>
        </div>

    <?php elseif ($is_pro_installed && !$is_license_active): ?>
        <!-- Pro installiert und aktiv, aber Lizenz nicht aktiv -->
        <div class="warning-box">
            <div class="warning-box-title"><?php _e('⚠️ Lizenz nicht aktiv', 'psycho-wizard'); ?></div>
            <div class="warning-box-content">
                <?php _e('Elementor Pro ist installiert und aktiviert, aber die Lizenz wurde noch nicht verbunden.', 'psycho-wizard'); ?>
            </div>
        </div>

        <div id="licenseActivationSection" style="margin-top: 30px;">
            <div class="info-box">
                <div class="info-box-title"><?php _e('🔑 Lizenz verbinden', 'psycho-wizard'); ?></div>
                <div class="info-box-content">
                    <?php _e('<strong>So geht\'s:</strong><br>1. Klicke auf "Zur Lizenz-Seite" (öffnet in neuem Tab)<br>2. Klicke auf <strong>"Connect & Activate"</strong><br>3. Melde dich mit deinem Elementor-Account an<br>4. Kehre zu diesem Tab zurück und klicke auf "Lizenz-Status prüfen"', 'psycho-wizard'); ?>
                </div>
            </div>

            <div style="display: flex; gap: 15px; margin-top: 20px;">
                <a href="<?php echo admin_url('admin.php?page=elementor-license'); ?>"
                   target="_blank"
                   class="btn btn-primary"
                   style="text-decoration: none; display: inline-block;">
                    <?php _e('🔗 Zur Lizenz-Seite (öffnet in neuem Tab)', 'psycho-wizard'); ?>
                </a>

                <button type="button"
                        class="btn btn-secondary"
                        id="checkLicenseBtn"
                        onclick="checkElementorProLicense()">
                    <?php _e('🔄 Lizenz-Status prüfen', 'psycho-wizard'); ?>
                </button>
            </div>

            <div id="licenseStatusDisplay" style="margin-top: 20px; padding: 15px; border-radius: 8px; display: none;">
                <div id="licenseStatusText"></div>
            </div>
        </div>
        
    <?php else: ?>
        <!-- Elementor Pro noch nicht installiert - Upload nötig -->
        <div class="upload-area" id="proUpload">
            <div class="upload-icon">📤</div>
            <div class="upload-text"><?php _e('Elementor Pro ZIP hochladen', 'psycho-wizard'); ?></div>
            <div class="upload-hint"><?php _e('Klicke oder ziehe die elementor-pro.zip Datei hier her', 'psycho-wizard'); ?></div>
        </div>

        <div id="licenseActivationSection" style="display: none; margin-top: 30px;">
            <div class="info-box">
                <div class="info-box-title"><?php _e('🔑 Schritt 2: Lizenz aktivieren', 'psycho-wizard'); ?></div>
                <div class="info-box-content">
                    <?php _e('<strong>Elementor Pro wurde installiert!</strong><br><br>Aktiviere jetzt deine Lizenz, damit du das Template Kit importieren kannst.<br><br><strong>So geht\'s:</strong><br>1. Klicke auf "Elementor Pro aktivieren" (öffnet in neuem Tab)<br>2. Klicke auf <strong>"Connect & Activate"</strong><br>3. Melde dich mit deinem Elementor-Account an<br>4. Kehre zu diesem Tab zurück und klicke auf "Lizenz-Status prüfen"', 'psycho-wizard'); ?>
                </div>
            </div>

            <div style="display: flex; gap: 15px; margin-top: 20px;">
                <a href="<?php echo admin_url('plugins.php'); ?>"
                   target="_blank"
                   class="btn btn-primary"
                   style="text-decoration: none; display: inline-block;">
                    <?php _e('🔗 Elementor Pro aktivieren (öffnet in neuem Tab)', 'psycho-wizard'); ?>
                </a>

                <button type="button"
                        class="btn btn-secondary"
                        id="checkLicenseBtn"
                        onclick="checkElementorProLicense()">
                    <?php _e('🔄 Lizenz-Status prüfen', 'psycho-wizard'); ?>
                </button>
            </div>

            <div id="licenseStatusDisplay" style="margin-top: 20px; padding: 15px; border-radius: 8px; display: none;">
                <div id="licenseStatusText"></div>
            </div>
        </div>
    <?php endif; ?>

    <div class="warning-box" style="margin-top: 20px;">
        <div class="warning-box-title"><?php _e('⚠️ Wichtig', 'psycho-wizard'); ?></div>
        <div class="warning-box-content">
            <?php _e('<strong>Die Lizenz-Aktivierung ist zwingend erforderlich!</strong><br>Ohne aktive Elementor Pro Lizenz kann das Template Kit nicht importiert werden.<br><br><strong>Falls die Lizenz bereits woanders verwendet wird:</strong><br>Gehe auf der alten Website zu Elementor → Lizenz → "Deaktivieren"', 'psycho-wizard'); ?>
        </div>
    </div>
</div>

<script>
// Status beim Laden setzen
jQuery(document).ready(function($) {
    <?php if ($is_pro_installed && $is_pro_active && $is_license_active): ?>
        // Pro installiert, aktiviert und Lizenz aktiv
        window.uploadedFiles.elementorPro = true;
        window.uploadedFiles.elementorProActivated = true;
        window.updateButtons();
    <?php elseif ($is_pro_installed && $is_pro_active): ?>
        // Pro installiert und aktiviert, aber Lizenz nicht aktiv
        window.uploadedFiles.elementorPro = true;
        window.uploadedFiles.elementorProActivated = false;
        window.updateButtons();
    <?php elseif ($is_pro_installed): ?>
        // Pro nur installiert, aber nicht aktiviert
        window.uploadedFiles.elementorPro = true;
        window.uploadedFiles.elementorProActivated = false;
        window.updateButtons();
    <?php endif; ?>
});

// Status-Prüfung wird über checkElementorProLicense() gemacht (in wizard.js)
</script>