<?php
/**
 * Step 9: Demo-Daten
 */
if (!defined('ABSPATH')) {
    exit;
}

$wizard_status = Psycho_Status_Checker::get_wizard_status();
$is_imported = isset($wizard_status['demo_data_imported']) && $wizard_status['demo_data_imported'];

// Prüfe ob Demo-Daten tatsächlich existieren (als zusätzliche Sicherheit)
if (!$is_imported && post_type_exists('team_member')) {
    $demo_posts = get_posts(array(
        'post_type' => 'team_member',
        'posts_per_page' => 1,
        'post_status' => 'any'
    ));

    // Wenn Team Members vorhanden sind, Status speichern
    if (!empty($demo_posts)) {
        Psycho_Status_Checker::update_status('demo_data_imported', true);
        $is_imported = true;
    }
}
?>

<div class="wizard-step" data-step="9">
    <h2><?php _e('Demo-Daten importieren (Optional)', 'psycho-wizard'); ?></h2>
    <p class="step-description">
        <?php if ($is_imported): ?>
            <?php _e('✅ Demo-Daten wurden importiert!', 'psycho-wizard'); ?>
        <?php else: ?>
            <?php _e('Importiere Beispiel-Team-Members um die Struktur zu verstehen (optional).', 'psycho-wizard'); ?>
        <?php endif; ?>
    </p>

    <?php if ($is_imported): ?>
        <div class="info-box" style="background: #d1fae5; border-color: #10b981;">
            <div class="info-box-title" style="color: #065f46;"><?php _e('✅ Demo-Daten importiert!', 'psycho-wizard'); ?></div>
            <div class="info-box-content" style="color: #065f46;">
                <?php _e('Die Beispiel-Team-Members wurden erfolgreich importiert und können als Vorlage genutzt werden.', 'psycho-wizard'); ?>
            </div>
        </div>

        <div style="margin-top: 20px;">
            <button type="button" class="btn btn-secondary" onclick="resetDemoData()">
                <?php _e('🔄 Demo-Daten zurücksetzen & erneut importieren', 'psycho-wizard'); ?>
            </button>
        </div>
    <?php else: ?>
        <div class="checkbox-group">
            <label class="checkbox-item">
                <input type="checkbox" id="importDemoCheckbox">
                <div class="checkbox-label">
                    <div class="checkbox-title"><?php _e('Demo Team Members importieren', 'psycho-wizard'); ?></div>
                    <div class="checkbox-desc"><?php _e('Beispiel-Daten mit ausgefüllten Feldern als Vorlage (optional)', 'psycho-wizard'); ?></div>
                </div>
            </label>
        </div>

        <div id="demoUploadSection" style="display: none; margin-top: 20px;">
            <div class="upload-area" id="demoDataUpload">
                <div class="upload-icon">📊</div>
                <div class="upload-text"><?php _e('Demo-Daten XML hochladen', 'psycho-wizard'); ?></div>
                <div class="upload-hint"><?php _e('team-members-demo.xml', 'psycho-wizard'); ?></div>
            </div>
        </div>

        <div class="info-box" style="margin-top: 20px;">
            <div class="info-box-title"><?php _e('💡 Hinweis', 'psycho-wizard'); ?></div>
            <div class="info-box-content">
                <?php _e('Die Demo-Daten sind <strong>optional</strong>. Du kannst auch direkt mit eigenen Team Members starten.<br>Die Demo-Daten helfen dir zu verstehen, wie die 40+ Felder ausgefüllt werden sollten.', 'psycho-wizard'); ?>
            </div>
        </div>

        <div style="margin-top: 20px;">
            <button type="button" class="btn btn-primary" id="skipDemoBtn" onclick="skipDemoData()">
                <?php _e('⏭️ Überspringen (keine Demo-Daten)', 'psycho-wizard'); ?>
            </button>
        </div>
    <?php endif; ?>
</div>

<script>
jQuery(document).ready(function($) {
    <?php if ($is_imported): ?>
        if (typeof window.markStepCompleted === 'function') {
            window.markStepCompleted(9);
        }
        if (typeof window.updateButtons === 'function') {
            window.updateButtons();
        }
    <?php endif; ?>
    // Checkbox-Handler wird in wizard.js setupStepUploads() registriert
});

window.uploadDemoData = function(file) {
    const $ = jQuery;

    // Validiere Datei
    if (!file) {
        if (typeof window.showNotification === 'function') {
            window.showNotification('error', <?php echo json_encode(__('Keine Datei ausgewählt', 'psycho-wizard')); ?>);
        }
        return;
    }

    // Prüfe Dateityp
    if (!file.name.toLowerCase().endsWith('.xml')) {
        if (typeof window.showNotification === 'function') {
            window.showNotification('error', <?php echo json_encode(__('Bitte lade eine XML-Datei hoch (.xml)', 'psycho-wizard')); ?>);
        }
        return;
    }

    // Prüfe Dateigröße (max 10MB für XML)
    const maxSize = 10 * 1024 * 1024; // 10MB
    if (file.size > maxSize) {
        if (typeof window.showNotification === 'function') {
            window.showNotification('error', <?php echo json_encode(__('Datei ist zu groß. Maximum: 10MB', 'psycho-wizard')); ?>);
        }
        return;
    }

    const formData = new FormData();
    formData.append('action', 'psycho_upload_demo_data');
    formData.append('nonce', psychoWizard.nonce);
    formData.append('file', file);

    if (typeof window.showNotification === 'function') {
        window.showNotification('info', <?php echo json_encode(__('Demo-Daten werden importiert...', 'psycho-wizard')); ?>);
    }

    $.ajax({
        url: psychoWizard.ajaxUrl,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            console.log('Upload response:', response);

            if (response.success) {
                console.log('Upload successful - showing success state');

                if (typeof window.markStepCompleted === 'function') {
                    window.markStepCompleted(9);
                }
                // Update progress bubble immediately
                $('.step[data-step="9"]').addClass('completed');
                if (typeof window.updateButtons === 'function') {
                    window.updateButtons();
                }

                // Zeige Erfolgs-Zustand
                const $container = $('.wizard-step[data-step="9"]');
                console.log('Container found:', $container.length);

                // Entferne ALLE Kinder außer h2 und description
                $container.children().not('h2, p.step-description').remove();
                console.log('Removed old content');

                // Update Description
                $container.find('p.step-description').html(<?php echo json_encode(__('✅ Demo-Daten wurden importiert!', 'psycho-wizard')); ?>);
                console.log('Updated description');

                // Zeige Erfolgs-Box und Reset-Button (SEHR PROMINENT)
                const successHTML = `
                    <div class="info-box" style="background: #d1fae5; border: 3px solid #10b981; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); animation: pulse 2s ease-in-out;">
                        <div class="info-box-title" style="color: #065f46; font-size: 18px; font-weight: 700;">
                            ✅ <?php echo esc_js(__('Demo-Daten erfolgreich importiert!', 'psycho-wizard')); ?>
                        </div>
                        <div class="info-box-content" style="color: #065f46; font-size: 15px; margin-top: 10px;">
                            <strong><?php echo esc_js(__('Import abgeschlossen!', 'psycho-wizard')); ?></strong><br>
                            <?php echo esc_js(__('Die Beispiel-Team-Members wurden erfolgreich importiert und können als Vorlage genutzt werden.', 'psycho-wizard')); ?><br><br>
                            <span style="background: #10b981; color: white; padding: 8px 16px; border-radius: 6px; display: inline-block; margin-top: 10px;">
                                ⚠️ <?php echo esc_js(__('Bitte nicht erneut importieren - Daten sind bereits vorhanden!', 'psycho-wizard')); ?>
                            </span>
                        </div>
                    </div>

                    <div style="margin-top: 20px;">
                        <button type="button" class="btn btn-secondary" onclick="resetDemoData()">
                            <?php echo esc_js(__('🔄 Demo-Daten zurücksetzen & erneut importieren', 'psycho-wizard')); ?>
                        </button>
                    </div>
                `;

                $container.append(successHTML);
                console.log('Success HTML appended');

                // Show notification AFTER DOM update (slight delay to ensure visibility)
                setTimeout(function() {
                    if (typeof window.showNotification === 'function') {
                        const successMessage = response.data.message || <?php echo json_encode(__('✅ Demo data successfully imported!', 'psycho-wizard')); ?>;
                        window.showNotification('success', successMessage);
                    }
                }, 100);
            } else {
                // Fehler beim Import
                const errorMessage = response.data && response.data.message
                    ? response.data.message
                    : <?php echo json_encode(__('Fehler beim Importieren der Demo-Daten', 'psycho-wizard')); ?>;

                if (typeof window.showNotification === 'function') {
                    window.showNotification('error', errorMessage);
                }
            }
        },
        error: function(xhr, status, error) {
            console.error('Demo data upload error:', xhr.responseText);

            let errorMessage = <?php echo json_encode(__('Upload fehlgeschlagen. ', 'psycho-wizard')); ?>;

            if (status === 'timeout') {
                errorMessage += <?php echo json_encode(__('Die Anfrage hat zu lange gedauert.', 'psycho-wizard')); ?>;
            } else if (xhr.status === 413) {
                errorMessage += <?php echo json_encode(__('Datei ist zu groß.', 'psycho-wizard')); ?>;
            } else if (xhr.status === 403) {
                errorMessage += <?php echo json_encode(__('Keine Berechtigung.', 'psycho-wizard')); ?>;
            } else if (xhr.status === 0) {
                errorMessage += <?php echo json_encode(__('Keine Verbindung zum Server.', 'psycho-wizard')); ?>;
            } else {
                errorMessage += error || <?php echo json_encode(__('Unbekannter Fehler', 'psycho-wizard')); ?>;
            }

            if (typeof window.showNotification === 'function') {
                window.showNotification('error', errorMessage);
            }
        }
    });
};

function skipDemoData() {
    // Markiere als completed auch ohne Import
    if (typeof window.markStepCompleted === 'function') {
        window.markStepCompleted(9);
    }
    if (typeof window.updateButtons === 'function') {
        window.updateButtons();
    }
    if (typeof window.showNotification === 'function') {
        window.showNotification('success', <?php echo json_encode(__('Demo-Daten übersprungen', 'psycho-wizard')); ?>);
    }
    if (typeof nextStep === 'function') {
        nextStep();
    }
}

function resetDemoData() {
    const $ = jQuery;

    if (!confirm(<?php echo json_encode(__('Möchtest du wirklich die Demo-Daten zurücksetzen? Dies löscht alle importierten Team Members und setzt den Status zurück.', 'psycho-wizard')); ?>)) {
        return;
    }

    const $container = $('.wizard-step[data-step="9"]');

    $.ajax({
        url: psychoWizard.ajaxUrl,
        type: 'POST',
        data: {
            action: 'psycho_reset_demo_data',
            nonce: psychoWizard.nonce
        },
        success: function(response) {
            if (response.success) {
                if (typeof window.showNotification === 'function') {
                    window.showNotification('success', response.data.message);
                }

                // Zeige Upload-Bereich ohne Reload
                const uploadHTML = `
                    <div class="checkbox-group">
                        <label class="checkbox-item">
                            <input type="checkbox" id="importDemoCheckbox">
                            <div class="checkbox-label">
                                <div class="checkbox-title"><?php echo esc_js(__('Demo Team Members importieren', 'psycho-wizard')); ?></div>
                                <div class="checkbox-desc"><?php echo esc_js(__('Beispiel-Daten mit ausgefüllten Feldern als Vorlage (optional)', 'psycho-wizard')); ?></div>
                            </div>
                        </label>
                    </div>

                    <div id="demoUploadSection" style="display: none; margin-top: 20px;">
                        <div class="upload-area" id="demoDataUpload">
                            <div class="upload-icon">📊</div>
                            <div class="upload-text"><?php echo esc_js(__('Demo-Daten XML hochladen', 'psycho-wizard')); ?></div>
                            <div class="upload-hint"><?php echo esc_js(__('team-members-demo.xml', 'psycho-wizard')); ?></div>
                        </div>
                    </div>

                    <div class="info-box" style="margin-top: 20px;">
                        <div class="info-box-title"><?php echo esc_js(__('💡 Hinweis', 'psycho-wizard')); ?></div>
                        <div class="info-box-content">
                            <?php echo esc_js(__('Die Demo-Daten sind <strong>optional</strong>. Du kannst auch direkt mit eigenen Team Members starten.<br>Die Demo-Daten helfen dir zu verstehen, wie die 40+ Felder ausgefüllt werden sollten.', 'psycho-wizard')); ?>
                        </div>
                    </div>

                    <div style="margin-top: 20px;">
                        <button type="button" class="btn btn-primary" id="skipDemoBtn" onclick="skipDemoData()">
                            <?php echo esc_js(__('⏭️ Überspringen (keine Demo-Daten)', 'psycho-wizard')); ?>
                        </button>
                    </div>
                `;

                // Ersetze den Inhalt
                $container.find('p.step-description').html(<?php echo json_encode(__('Importiere Beispiel-Team-Members um die Struktur zu verstehen (optional).', 'psycho-wizard')); ?>);

                // Entferne nur die Erfolgs-Meldung und den Button (nicht h2 und description!)
                $container.find('.info-box[style*="background: #d1fae5"]').remove();
                $container.find('button[onclick="resetDemoData()"]').closest('div').remove();

                // Füge Upload-Bereich hinzu
                $container.append(uploadHTML);

                // Re-initialisiere Upload-Handler und Checkbox
                setTimeout(function() {
                    console.log('Reset complete - re-initializing handlers');

                    // Entferne alle Event-Handler und Flags
                    $('#demoDataUpload').off('click dragover dragleave drop').removeData('upload-ready');
                    $('#importDemoCheckbox').off('change').removeData('handler-registered');

                    // Registriere Checkbox-Handler NEU
                    $('#importDemoCheckbox').on('change', function() {
                        console.log('Checkbox changed:', this.checked);

                        if (this.checked) {
                            $('#demoUploadSection').slideDown();
                            $('#skipDemoBtn').hide();

                            // Warte bis Animation fertig ist, dann setup Upload
                            setTimeout(function() {
                                const $uploadArea = $('#demoDataUpload');

                                if ($uploadArea.length && !$uploadArea.data('upload-ready')) {
                                    console.log('Setting up upload area - fresh start');
                                    $uploadArea.data('upload-ready', true);

                                    // Click handler
                                    $uploadArea.on('click', function() {
                                        console.log('Upload area clicked');
                                        const input = $('<input type="file" accept=".xml">');
                                        input.on('change', function(e) {
                                            if (e.target.files[0]) {
                                                console.log('File selected:', e.target.files[0].name);
                                                uploadDemoData(e.target.files[0]);
                                            }
                                        });
                                        input.click();
                                    });

                                    // Drag & drop
                                    $uploadArea.on('dragover', function(e) {
                                        e.preventDefault();
                                        $(this).addClass('dragover');
                                    });

                                    $uploadArea.on('dragleave', function() {
                                        $(this).removeClass('dragover');
                                    });

                                    $uploadArea.on('drop', function(e) {
                                        e.preventDefault();
                                        $(this).removeClass('dragover');
                                        if (e.originalEvent.dataTransfer.files[0]) {
                                            uploadDemoData(e.originalEvent.dataTransfer.files[0]);
                                        }
                                    });
                                }
                            }, 400);
                        } else {
                            $('#demoUploadSection').slideUp();
                            $('#skipDemoBtn').show();
                        }
                    });
                }, 200);
            } else {
                if (typeof window.showNotification === 'function') {
                    window.showNotification('error', response.data.message);
                }
            }
        },
        error: function() {
            if (typeof window.showNotification === 'function') {
                window.showNotification('error', <?php echo json_encode(__('Fehler beim Zurücksetzen', 'psycho-wizard')); ?>);
            }
        }
    });
}
</script>
