<?php
/**
 * Step 5: Template Kit
 */
if (!defined('ABSPATH')) {
    exit;
}

// Prüfe ob Template Kit bereits importiert wurde
$wizard_status = Psycho_Status_Checker::get_wizard_status();
$is_imported = isset($wizard_status['template_kit_imported']) && $wizard_status['template_kit_imported'];

// Prüfe auch in Datenbank nach Templates
$has_templates = false;
$template_count = 0;
$page_count = 0;

if (class_exists('\Elementor\Plugin')) {
    $args = array(
        'post_type' => 'elementor_library',
        'post_status' => 'publish',
        'posts_per_page' => -1,
    );
    $templates = get_posts($args);
    $template_count = count($templates);

    $args_pages = array(
        'post_type' => 'page',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => '_elementor_edit_mode',
                'value' => 'builder',
                'compare' => '='
            )
        )
    );
    $elementor_pages = get_posts($args_pages);
    $page_count = count($elementor_pages);

    $has_templates = ($template_count + $page_count) > 5; // Mindestens 5 Items

    // WICHTIG: Status dynamisch aktualisieren (auch zurücksetzen wenn keine Templates mehr da)
    if ($has_templates) {
        // Templates vorhanden -> Status auf true
        if (!$is_imported) {
            Psycho_Status_Checker::update_status('template_kit_imported', true);
            $is_imported = true;
        }
    } else {
        // Keine Templates mehr vorhanden -> Status zurücksetzen (für Progress Bubble)
        if ($is_imported) {
            Psycho_Status_Checker::update_status('template_kit_imported', false);
            $is_imported = false;
        }
    }
}
?>

<div class="wizard-step" data-step="5">
    <h2><?php _e('Template Kit importieren', 'psycho-wizard'); ?></h2>
    <p class="step-description">
        <?php if ($has_templates): ?>
            <?php _e('✅ Template Kit wurde bereits importiert!', 'psycho-wizard'); ?>
        <?php else: ?>
            <?php _e('Importiere jetzt dein Elementor Website Kit über die offizielle Elementor Import-Seite.', 'psycho-wizard'); ?>
        <?php endif; ?>
    </p>

    <?php if ($has_templates): ?>
        <!-- Template Kit bereits importiert -->
        <div class="info-box" style="background: #d1fae5; border-color: #10b981;">
            <div class="info-box-title" style="color: #065f46;"><?php _e('✅ Template Kit bereits importiert!', 'psycho-wizard'); ?></div>
            <div class="info-box-content" style="color: #065f46;">
                <?php echo sprintf(__('<strong>Gefundene Inhalte:</strong><br>• %d Elementor Templates (Header, Footer, Singles, etc.)<br>• %d Seiten mit Elementor erstellt<br><br>Du kannst direkt zum nächsten Schritt weitergehen!', 'psycho-wizard'), $template_count, $page_count); ?>
            </div>
        </div>

        <div style="margin-top: 20px;">
            <button type="button"
                    class="btn btn-secondary"
                    id="checkImportBtn"
                    onclick="checkTemplateKitImport()">
                <?php _e('🔄 Status erneut prüfen', 'psycho-wizard'); ?>
            </button>
        </div>

        <!-- Status Anzeige für Recheck -->
        <div id="importStatusDisplay" style="margin-top: 20px; padding: 15px; border-radius: 8px; display: none;">
            <div id="importStatusText"></div>
        </div>

    <?php else: ?>
        <!-- Template Kit noch nicht importiert -->
        <div class="info-box">
            <div class="info-box-title"><?php _e('📦 So importierst du dein Template Kit', 'psycho-wizard'); ?></div>
            <div class="info-box-content">
                <?php _e('<strong>Schritt-für-Schritt:</strong><br><br><strong>1.</strong> Klicke auf "Elementor Kit Import öffnen" (öffnet in neuem Tab)<br><strong>2.</strong> Klicke auf <strong>"Upload"</strong> und wähle deine ZIP-Datei aus<br><strong>3.</strong> Wähle aus was importiert werden soll:<br>&nbsp;&nbsp;&nbsp;&nbsp;✅ Templates<br>&nbsp;&nbsp;&nbsp;&nbsp;✅ Content (Seiten)<br>&nbsp;&nbsp;&nbsp;&nbsp;✅ Site Settings<br><strong>4.</strong> Klicke auf <strong>"Import"</strong> und warte bis der Import abgeschlossen ist<br><strong>5.</strong> Kehre zu diesem Tab zurück und klicke auf "Import-Status prüfen"', 'psycho-wizard'); ?>
            </div>
        </div>

        <!-- SVG Upload Warnung und Aktivierung -->
        <div class="info-box" style="background: #fff7ed; border-color: #fb923c; margin-top: 20px;">
            <div class="info-box-title" style="color: #c2410c;"><?php _e('⚠️ Wichtig: Custom Icons (SVG)', 'psycho-wizard'); ?></div>
            <div class="info-box-content" style="color: #c2410c;">
                <?php _e('Falls dein Template Kit <strong>Custom Icons (SVG)</strong> enthält (z.B. Lucide Icons), musst du SVG-Uploads aktivieren, BEVOR du das Kit importierst.', 'psycho-wizard'); ?><br><br>
                <strong><?php _e('⚠️ Sicherheitshinweis:', 'psycho-wizard'); ?></strong> <?php _e('Dies ist ein potentielles Sicherheitsrisiko. Aktiviere es nur, wenn du der Quelle deines Kits vertraust.', 'psycho-wizard'); ?>
            </div>
        </div>

        <div style="margin-top: 20px; padding: 15px; background: #f3f4f6; border-radius: 8px;">
            <button type="button"
                    class="btn btn-secondary"
                    id="enableSvgBtn"
                    onclick="enableSvgUpload()">
                <?php _e('🔓 SVG-Upload aktivieren (für Icons)', 'psycho-wizard'); ?>
            </button>
            <span id="svgStatus" style="margin-left: 15px; display: none; color: #10b981; font-weight: 600;">
                <?php _e('✓ SVG-Upload aktiviert', 'psycho-wizard'); ?>
            </span>
        </div>

        <!-- Buttons -->
        <div style="display: flex; gap: 15px; margin-top: 30px;">
            <a href="<?php echo admin_url('admin.php?page=elementor-tools#tab-import-export-kit'); ?>"
               target="_blank"
               class="btn btn-primary"
               id="openElementorImport"
               style="text-decoration: none; display: inline-block;">
                <?php _e('🚀 Elementor Kit Import öffnen (neuer Tab)', 'psycho-wizard'); ?>
            </a>

            <button type="button"
                    class="btn btn-secondary"
                    id="checkImportBtn"
                    onclick="checkTemplateKitImport()">
                <?php _e('🔄 Import-Status prüfen', 'psycho-wizard'); ?>
            </button>
        </div>

        <!-- Status Anzeige -->
        <div id="importStatusDisplay" style="margin-top: 20px; padding: 15px; border-radius: 8px; display: none;">
            <div id="importStatusText"></div>
        </div>

    <?php endif; ?>
</div>

<script>
// Status beim Laden setzen
jQuery(document).ready(function($) {
    <?php if ($has_templates): ?>
        // Template Kit bereits importiert (Status wurde bereits im PHP gespeichert)
        window.uploadedFiles.templateKit = true;
        window.updateButtons();
    <?php endif; ?>
});

// Status-Prüfung wird über checkTemplateKitImport() gemacht (in wizard.js)
// Die Progress Bubble wird automatisch von loadWizardStatus() gesetzt

// SVG Upload aktivieren
window.enableSvgUpload = function() {
    const $ = jQuery;
    const $btn = $('#enableSvgBtn');
    const $status = $('#svgStatus');

    $btn.prop('disabled', true).text(<?php echo json_encode(__('⏳ Aktiviere...', 'psycho-wizard')); ?>);

    $.ajax({
        url: psychoWizard.ajaxUrl,
        type: 'POST',
        data: {
            action: 'psycho_enable_svg_upload',
            nonce: psychoWizard.nonce
        },
        success: function(response) {
            if (response.success) {
                $status.fadeIn();
                $btn.hide();
                if (typeof window.showNotification === 'function') {
                    window.showNotification('success', response.data.message);
                }
            } else {
                $btn.prop('disabled', false).text(<?php echo json_encode(__('🔓 SVG-Upload aktivieren (für Icons)', 'psycho-wizard')); ?>);
                if (typeof window.showNotification === 'function') {
                    window.showNotification('error', response.data.message || <?php echo json_encode(__('Fehler beim Aktivieren', 'psycho-wizard')); ?>);
                }
            }
        },
        error: function() {
            $btn.prop('disabled', false).text(<?php echo json_encode(__('🔓 SVG-Upload aktivieren (für Icons)', 'psycho-wizard')); ?>);
            if (typeof window.showNotification === 'function') {
                window.showNotification('error', <?php echo json_encode(__('Fehler beim Aktivieren. Bitte versuche es erneut.', 'psycho-wizard')); ?>);
            }
        }
    });
};
</script>
