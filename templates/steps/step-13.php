<?php
/**
 * Step 13: Farben
 */
if (!defined('ABSPATH')) {
    exit;
}

$wizard_status = Psycho_Status_Checker::get_wizard_status();
$is_set = isset($wizard_status['colors_set']) && $wizard_status['colors_set'];
?>

<div class="wizard-step" data-step="13">
    <h2><?php _e('Farbschema personalisieren', 'psycho-wizard'); ?></h2>
    <p class="step-description">
        <?php _e('Wähle ein Farbschema für deine Website.', 'psycho-wizard'); ?>
    </p>

    <div class="info-box" style="background: #eff6ff; border-color: #3b82f6; margin-bottom: 30px;">
        <div class="info-box-title" style="color: #1e40af;"><?php _e('💡 Farbschema-System', 'psycho-wizard'); ?></div>
        <div class="info-box-content" style="color: #1e40af;">
            <?php _e('Wähle eines der 4 vorgefertigten Schemas oder erstelle dein eigenes direkt in den <strong>Elementor → Site Settings → Global Colors</strong>. Das aktive Schema wird grün markiert. Hover-Farben werden automatisch 15% dunkler berechnet.', 'psycho-wizard'); ?>
        </div>
    </div>

    <div class="color-schemes" id="colorSchemesContainer">
        <!-- Template Standard Farben (deine originalen Farben) -->
        <div class="color-scheme" data-scheme="template-standard">
            <div class="scheme-name"><?php _e('✨ Template Standard', 'psycho-wizard'); ?></div>
            <div class="color-palette">
                <div class="color-swatch" style="background: #2F6D67;" title="Primary"></div>
                <div class="color-swatch" style="background: #6FA89F;" title="Secondary"></div>
                <div class="color-swatch" style="background: #1A1F23;" title="Text"></div>
                <div class="color-swatch" style="background: #0D47A1;" title="Info"></div>
                <div class="color-swatch" style="background: #8C6E00;" title="Warning"></div>
            </div>
            <div class="color-palette">
                <div class="color-swatch" style="background: #C0392B;" title="Error"></div>
                <div class="color-swatch" style="background: #FAFAF8;" title="Background"></div>
                <div class="color-swatch" style="background: #F2F5F3;" title="Surface"></div>
                <div class="color-swatch" style="background: #5B6366;" title="Muted"></div>
                <div class="color-swatch" style="background: #D9E3DF;" title="Border"></div>
            </div>
        </div>

        <!-- Variante 1: Salbeigrün -->
        <div class="color-scheme" data-scheme="sage-green">
            <div class="scheme-name"><?php _e('🌿 Salbeigrün', 'psycho-wizard'); ?></div>
            <div class="color-palette">
                <div class="color-swatch" style="background: #5D7D5D;" title="Primary"></div>
                <div class="color-swatch" style="background: #B8C9B8;" title="Secondary"></div>
                <div class="color-swatch" style="background: #2A2F2A;" title="Text"></div>
                <div class="color-swatch" style="background: #5B8CA8;" title="Info"></div>
                <div class="color-swatch" style="background: #A89D5B;" title="Warning"></div>
            </div>
            <div class="color-palette">
                <div class="color-swatch" style="background: #A85B5B;" title="Error"></div>
                <div class="color-swatch" style="background: #F7F9F7;" title="Background"></div>
                <div class="color-swatch" style="background: #EFF3EF;" title="Surface"></div>
                <div class="color-swatch" style="background: #6B716B;" title="Muted"></div>
                <div class="color-swatch" style="background: #D4DDD4;" title="Border"></div>
            </div>
        </div>

        <!-- Variante 2: Sanfte Lavendeltöne -->
        <div class="color-scheme" data-scheme="soft-lavender">
            <div class="scheme-name"><?php _e('💜 Sanfte Lavendeltöne', 'psycho-wizard'); ?></div>
            <div class="color-palette">
                <div class="color-swatch" style="background: #5A6A99;" title="Primary"></div>
                <div class="color-swatch" style="background: #A8B3D4;" title="Secondary"></div>
                <div class="color-swatch" style="background: #2E2E3A;" title="Text"></div>
                <div class="color-swatch" style="background: #6A9AB0;" title="Info"></div>
                <div class="color-swatch" style="background: #B5A67C;" title="Warning"></div>
            </div>
            <div class="color-palette">
                <div class="color-swatch" style="background: #A86B6B;" title="Error"></div>
                <div class="color-swatch" style="background: #F9F9FC;" title="Background"></div>
                <div class="color-swatch" style="background: #F0F0F5;" title="Surface"></div>
                <div class="color-swatch" style="background: #6B6B7D;" title="Muted"></div>
                <div class="color-swatch" style="background: #D8D8E8;" title="Border"></div>
            </div>
        </div>

        <!-- Variante 3: Warme Rosétöne -->
        <div class="color-scheme" data-scheme="warm-rose">
            <div class="scheme-name"><?php _e('🌸 Warme Rosétöne', 'psycho-wizard'); ?></div>
            <div class="color-palette">
                <div class="color-swatch" style="background: #B8644D;" title="Primary"></div>
                <div class="color-swatch" style="background: #E8AFA6;" title="Secondary"></div>
                <div class="color-swatch" style="background: #3A2E2E;" title="Text"></div>
                <div class="color-swatch" style="background: #7FA3B8;" title="Info"></div>
                <div class="color-swatch" style="background: #D4A87B;" title="Warning"></div>
            </div>
            <div class="color-palette">
                <div class="color-swatch" style="background: #B86B6B;" title="Error"></div>
                <div class="color-swatch" style="background: #FCF8F7;" title="Background"></div>
                <div class="color-swatch" style="background: #F5EFED;" title="Surface"></div>
                <div class="color-swatch" style="background: #7D6E6B;" title="Muted"></div>
                <div class="color-swatch" style="background: #E8DDD8;" title="Border"></div>
            </div>
        </div>

        <!-- Variante 4: Blaugrau/Apricot -->
        <div class="color-scheme" data-scheme="warm-blue-apricot">
            <div class="scheme-name"><?php _e('🌊 Blaugrau/Apricot', 'psycho-wizard'); ?></div>
            <div class="color-palette">
                <div class="color-swatch" style="background: #5A7387;" title="Primary"></div>
                <div class="color-swatch" style="background: #A8BDC9;" title="Secondary"></div>
                <div class="color-swatch" style="background: #232A2E;" title="Text"></div>
                <div class="color-swatch" style="background: #5B7FA8;" title="Info"></div>
                <div class="color-swatch" style="background: #D4A03D;" title="Warning"></div>
            </div>
            <div class="color-palette">
                <div class="color-swatch" style="background: #C64B42;" title="Error"></div>
                <div class="color-swatch" style="background: #FAFBFC;" title="Background"></div>
                <div class="color-swatch" style="background: #EEF3F5;" title="Surface"></div>
                <div class="color-swatch" style="background: #656B70;" title="Muted"></div>
                <div class="color-swatch" style="background: #D6E1E7;" title="Border"></div>
            </div>
        </div>

        <!-- Variante 5: Schokobraun -->
        <div class="color-scheme" data-scheme="chocolate-mokka">
            <div class="scheme-name"><?php _e('☕ Schokobraun', 'psycho-wizard'); ?></div>
            <div class="color-palette">
                <div class="color-swatch" style="background: #6B5447;" title="Primary"></div>
                <div class="color-swatch" style="background: #9B8577;" title="Secondary"></div>
                <div class="color-swatch" style="background: #2F2926;" title="Text"></div>
                <div class="color-swatch" style="background: #5B7FA8;" title="Info"></div>
                <div class="color-swatch" style="background: #A88D47;" title="Warning"></div>
            </div>
            <div class="color-palette">
                <div class="color-swatch" style="background: #A84D47;" title="Error"></div>
                <div class="color-swatch" style="background: #FAF8F7;" title="Background"></div>
                <div class="color-swatch" style="background: #F0EBE8;" title="Surface"></div>
                <div class="color-swatch" style="background: #6B6560;" title="Muted"></div>
                <div class="color-swatch" style="background: #DDD5D0;" title="Border"></div>
            </div>
        </div>

        <!-- Variante 6: Klares Mittelblau -->
        <div class="color-scheme" data-scheme="clear-blue">
            <div class="scheme-name"><?php _e('💙 Klares Mittelblau', 'psycho-wizard'); ?></div>
            <div class="color-palette">
                <div class="color-swatch" style="background: #3D6B94;" title="Primary"></div>
                <div class="color-swatch" style="background: #8FB3D4;" title="Secondary"></div>
                <div class="color-swatch" style="background: #232A2F;" title="Text"></div>
                <div class="color-swatch" style="background: #4A7BA7;" title="Info"></div>
                <div class="color-swatch" style="background: #B8A047;" title="Warning"></div>
            </div>
            <div class="color-palette">
                <div class="color-swatch" style="background: #B84D4D;" title="Error"></div>
                <div class="color-swatch" style="background: #F7FAFC;" title="Background"></div>
                <div class="color-swatch" style="background: #EDF3F7;" title="Surface"></div>
                <div class="color-swatch" style="background: #5F666B;" title="Muted"></div>
                <div class="color-swatch" style="background: #D4E1EA;" title="Border"></div>
            </div>
        </div>

        <!-- Variante 7: Tiefes Terracotta -->
        <div class="color-scheme" data-scheme="deep-terracotta">
            <div class="scheme-name"><?php _e('🍂 Tiefes Terracotta', 'psycho-wizard'); ?></div>
            <div class="color-palette">
                <div class="color-swatch" style="background: #8C4530;" title="Primary"></div>
                <div class="color-swatch" style="background: #D4936B;" title="Secondary"></div>
                <div class="color-swatch" style="background: #2F2623;" title="Text"></div>
                <div class="color-swatch" style="background: #5B84A8;" title="Info"></div>
                <div class="color-swatch" style="background: #B89447;" title="Warning"></div>
            </div>
            <div class="color-palette">
                <div class="color-swatch" style="background: #B84747;" title="Error"></div>
                <div class="color-swatch" style="background: #FCF8F6;" title="Background"></div>
                <div class="color-swatch" style="background: #F5EEEA;" title="Surface"></div>
                <div class="color-swatch" style="background: #6F6560;" title="Muted"></div>
                <div class="color-swatch" style="background: #E8DDD4;" title="Border"></div>
            </div>
        </div>

        <!-- Variante 8: Weiches Mauve -->
        <div class="color-scheme" data-scheme="soft-mauve">
            <div class="scheme-name"><?php _e('🪻 Weiches Mauve', 'psycho-wizard'); ?></div>
            <div class="color-palette">
                <div class="color-swatch" style="background: #856478;" title="Primary"></div>
                <div class="color-swatch" style="background: #C9B3BE;" title="Secondary"></div>
                <div class="color-swatch" style="background: #2A2628;" title="Text"></div>
                <div class="color-swatch" style="background: #6B8AA8;" title="Info"></div>
                <div class="color-swatch" style="background: #C9A350;" title="Warning"></div>
            </div>
            <div class="color-palette">
                <div class="color-swatch" style="background: #B84D4D;" title="Error"></div>
                <div class="color-swatch" style="background: #FDFBFC;" title="Background"></div>
                <div class="color-swatch" style="background: #F5F0F3;" title="Surface"></div>
                <div class="color-swatch" style="background: #6F696D;" title="Muted"></div>
                <div class="color-swatch" style="background: #E3D8DE;" title="Border"></div>
            </div>
        </div>
    </div>

    <div class="demo-preview" id="demoPreview">
        <div class="preview-header">
            <div class="preview-dot"></div>
            <div class="preview-dot"></div>
            <div class="preview-dot"></div>
        </div>
        <div class="preview-content">
            <div class="preview-box" id="previewBox"></div>
            <div class="preview-text" id="previewText1"></div>
            <div class="preview-text" id="previewText2"></div>
            <div class="preview-text" id="previewText3" style="width: 60%; margin-left: auto; margin-right: auto;">
            </div>
        </div>
    </div>

    <div style="margin-top: 30px; padding: 20px; background: #fef3c7; border: 2px solid #f59e0b; border-radius: 8px;">
        <h4 style="margin: 0 0 10px 0; color: #92400e;"><?php _e('⚠️ Wichtig: Global Colors', 'psycho-wizard'); ?></h4>
        <p style="margin: 0; color: #92400e;">
            <?php _e('Das gewählte Farbschema überschreibt alle Elementor Global Colors. Wenn du eigene Farben verwendet hast, gehen diese verloren. <strong>Wähle "Template Standard"</strong> um die Original-Farben des Templates wiederherzustellen.', 'psycho-wizard'); ?>
        </p>
    </div>

    <div class="info-box" style="margin-top: 20px;">
        <div class="info-box-title"><?php _e('🎨 Global Colors System', 'psycho-wizard'); ?></div>
        <div class="info-box-content">
            <?php _e('Das Template nutzt Elementor Global Colors für maximale Flexibilität. Du kannst jede Farbe später unter <strong>Elementor → Custom Colors</strong> einzeln anpassen.', 'psycho-wizard'); ?>
        </div>
    </div>

</div>

<script>
jQuery(document).ready(function($) {
    // Farbschema-Auswahl Handler wird in wizard.js registriert
});
</script>