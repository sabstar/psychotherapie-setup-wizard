<?php
/**
 * Step 16: Setup abgeschlossen - Nächste Schritte
 */
if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="wizard-step" data-step="16">
    <div style="text-align: center; padding: 40px 20px;">
        <div style="font-size: 64px; margin-bottom: 20px;">🎉</div>
        <h2 style="font-size: 32px; margin-bottom: 15px; color: #10b981;"><?php _e('Geschafft!', 'psycho-wizard'); ?></h2>
        <p style="font-size: 18px; color: #64748b; margin-bottom: 40px;">
            <?php _e('Super! Du hast deine <strong>Basic Settings und Styles</strong> erfolgreich abgeschlossen.', 'psycho-wizard'); ?>
        </p>
    </div>

    <div style="max-width: 900px; margin: 0 auto;">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 16px; padding: 40px; color: white; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);">
            <h3 style="font-size: 24px; margin: 0 0 20px 0; color: white;"><?php _e('📝 Jetzt: Eigene Inhalte & Bilder hinzufügen', 'psycho-wizard'); ?></h3>
            <p style="font-size: 16px; line-height: 1.8; margin: 0; opacity: 0.95;">
                <?php _e('Deine Website ist jetzt bereit für deine persönlichen Inhalte! Folge dieser Anleitung, um Texte und Bilder in den Templates zu personalisieren.', 'psycho-wizard'); ?>
            </p>
        </div>

        <!-- Schritt-für-Schritt Anleitung -->
        <div style="background: white; border: 2px solid #e5e7eb; border-radius: 12px; padding: 35px; margin-bottom: 30px;">
            <h3 style="font-size: 22px; margin: 0 0 25px 0; color: #1e293b; display: flex; align-items: center; gap: 10px;">
                <span style="background: #3b82f6; color: white; width: 32px; height: 32px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 18px;">1</span>
                <?php _e('Theme Builder öffnen', 'psycho-wizard'); ?>
            </h3>
            <p style="color: #64748b; font-size: 16px; line-height: 1.7; margin: 0 0 20px 40px;">
                <?php _e('Gehe im WordPress-Backend zu: <br><strong style="color: #1e293b; font-size: 17px;">Templates → Theme Builder</strong>', 'psycho-wizard'); ?>
            </p>

            <h3 style="font-size: 22px; margin: 30px 0 25px 0; color: #1e293b; display: flex; align-items: center; gap: 10px;">
                <span style="background: #3b82f6; color: white; width: 32px; height: 32px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 18px;">2</span>
                <?php _e('Seite zum Bearbeiten auswählen', 'psycho-wizard'); ?>
            </h3>
            <p style="color: #64748b; font-size: 16px; line-height: 1.7; margin: 0 0 20px 40px;">
                <?php _e('Suche die Seite heraus, auf der du deine <strong>Texte und Bilder personalisieren</strong> möchtest.<br>Klicke auf <strong>"Bearbeiten"</strong>.', 'psycho-wizard'); ?>
            </p>

            <h3 style="font-size: 22px; margin: 30px 0 25px 0; color: #1e293b; display: flex; align-items: center; gap: 10px;">
                <span style="background: #3b82f6; color: white; width: 32px; height: 32px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 18px;">3</span>
                <?php _e('Widget auswählen und Inhalt ändern', 'psycho-wizard'); ?>
            </h3>
            <p style="color: #64748b; font-size: 16px; line-height: 1.7; margin: 0 0 15px 40px;">
                <?php _e('Klicke einfach in das <strong>Widget</strong> (Textblock, Überschrift, Bild etc.), das du bearbeiten möchtest.', 'psycho-wizard'); ?>
            </p>

            <div style="background: #f0fdf4; border: 2px solid #10b981; border-radius: 10px; padding: 20px; margin: 20px 0 20px 40px;">
                <div style="display: flex; align-items: flex-start; gap: 15px;">
                    <div style="font-size: 32px; flex-shrink: 0;">✅</div>
                    <div>
                        <h4 style="color: #065f46; margin: 0 0 10px 0; font-size: 18px; font-weight: 600;"><?php _e('DO: Nur im Tab "Inhalt" arbeiten', 'psycho-wizard'); ?></h4>
                        <p style="color: #065f46; margin: 0; line-height: 1.6;">
                            <?php _e('Ändere <strong>NUR</strong> die Inhalte im Tab <strong>"Inhalt"</strong>:<br>• Texte anpassen<br>• Bilder austauschen<br>• Links aktualisieren<br><br>So bleiben deine <strong>globalen Styles konsistent</strong> und du kannst jederzeit global Änderungen vornehmen.', 'psycho-wizard'); ?>
                        </p>
                    </div>
                </div>
            </div>

            <div style="background: #fef2f2; border: 2px solid #ef4444; border-radius: 10px; padding: 20px; margin: 20px 0 0 40px;">
                <div style="display: flex; align-items: flex-start; gap: 15px;">
                    <div style="font-size: 32px; flex-shrink: 0;">⚠️</div>
                    <div>
                        <h4 style="color: #991b1b; margin: 0 0 10px 0; font-size: 18px; font-weight: 600;"><?php _e('DON\'T: Tab "Style" vermeiden', 'psycho-wizard'); ?></h4>
                        <p style="color: #991b1b; margin: 0; line-height: 1.6;">
                            <?php _e('Mache <strong>nur in Ausnahmefällen</strong> Änderungen im Tab <strong>"Style"</strong>.<br><br><strong>Warum?</strong> Sobald du Styles in einzelnen Widgets änderst:<br>• Verlierst du die <strong>Konsistenz</strong> deines Layouts<br>• Kannst du Änderungen <strong>nicht mehr global</strong> anwenden<br>• Lassen sich diese Widget-Styles <strong>nicht mehr zurücksetzen</strong><br><br>Alle Widget-spezifischen Style-Änderungen überschreiben die Global Settings und werden <strong>nicht</strong> von globalen Änderungen betroffen.', 'psycho-wizard'); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hilfreiche Tipps -->
        <div style="background: #eff6ff; border: 2px solid #3b82f6; border-radius: 12px; padding: 30px; margin-bottom: 30px;">
            <h3 style="font-size: 20px; margin: 0 0 20px 0; color: #1e40af; display: flex; align-items: center; gap: 10px;">
                <?php _e('💡 Hilfreiche Tipps', 'psycho-wizard'); ?>
            </h3>
            <ul style="color: #1e40af; font-size: 15px; line-height: 1.8; margin: 0; padding-left: 25px;">
                <li style="margin-bottom: 12px;">
                    <?php _e('<strong>Global Settings</strong> findest du unter: <code style="background: white; padding: 2px 8px; border-radius: 4px; font-size: 14px;">Elementor → Site Settings</code>', 'psycho-wizard'); ?>
                </li>
                <li style="margin-bottom: 12px;">
                    <?php _e('Dort kannst du <strong>Farben, Schriftarten, Button-Styles</strong> und mehr für die gesamte Website ändern', 'psycho-wizard'); ?>
                </li>
                <li style="margin-bottom: 12px;">
                    <?php _e('Du kannst jederzeit zu diesem Wizard zurückkehren über: <strong>Template Setup im Dashboard</strong>', 'psycho-wizard'); ?>
                </li>
                <li style="margin-bottom: 0;">
                    <?php echo sprintf(
                        __('Bei Fragen zur Bedienung von Elementor: <a href="%s" target="_blank" style="color: #2563eb; text-decoration: underline;">Elementor Documentation</a>', 'psycho-wizard'),
                        'https://elementor.com/help/'
                    ); ?>
                </li>
            </ul>
        </div>

        <!-- Abschluss -->
        <div style="text-align: center; padding: 20px;">
            <p style="font-size: 18px; color: #64748b; margin-bottom: 25px;">
                <?php _e('Viel Erfolg mit deiner neuen Website! 🚀', 'psycho-wizard'); ?>
            </p>
            <button type="button" class="btn btn-primary" onclick="location.href='<?php echo admin_url('admin.php?page=elementor-app#/site-editor/templates'); ?>'" style="font-size: 16px; padding: 15px 40px;">
                <?php _e('🎨 Zum Theme Builder', 'psycho-wizard'); ?>
            </button>
        </div>
    </div>
</div>

<style>
/* Step 16 spezifisches Styling */
.wizard-step[data-step="16"] code {
    font-family: 'Courier New', monospace;
}

.wizard-step[data-step="16"] strong {
    font-weight: 600;
}

.wizard-step[data-step="16"] h3 {
    font-weight: 600;
}

.wizard-step[data-step="16"] h4 {
    font-weight: 600;
}
</style>
