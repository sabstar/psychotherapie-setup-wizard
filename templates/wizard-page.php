<?php
/**
 * Setup Wizard Template
 */

if (!defined('ABSPATH')) {
    exit;
}

// Prüfe ob bereits abgeschlossen
$wizard_completed = get_option('psycho_wizard_completed', false);

if ($wizard_completed) {
    ?>
    <div class="wrap">
        <h1><?php _e('✓ Setup bereits abgeschlossen', 'psycho-wizard'); ?></h1>
        <p><?php _e('Der Setup-Wizard wurde bereits durchlaufen.', 'psycho-wizard'); ?></p>
        <p><a href="<?php echo admin_url(); ?>" class="button button-primary"><?php _e('Zum Dashboard', 'psycho-wizard'); ?></a></p>
        <p><a href="<?php echo admin_url('admin.php?page=psycho-wizard&reset=1'); ?>" class="button"><?php _e('Setup erneut durchführen', 'psycho-wizard'); ?></a></p>
    </div>
    <?php

    // Reset wenn Parameter gesetzt
    if (isset($_GET['reset']) && $_GET['reset'] == '1') {
        delete_option('psycho_wizard_completed');
        wp_redirect(admin_url('admin.php?page=psycho-wizard'));
        exit;
    }

    return;
}
?>

<div class="wrap" style="margin: 0; padding: 0;">
    <!-- Hier kommt der komplette HTML-Code aus dem Artefakt -->
    <!-- Der CSS ist in assets/css/wizard.css -->
    <!-- Der JavaScript ist in assets/js/wizard.js -->

    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px;">
        <div class="wizard-container wizard-lang-<?php echo str_replace('_', '-', get_locale()); ?>" style="background: white; border-radius: 20px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); width: 100%; overflow: hidden; max-height: 90vh; display: flex; flex-direction: column;">

            <div class="progress-bar" style="height: 6px; background: #e0e0e0; position: relative;">
                <div class="progress-fill" id="progressFill" style="height: 100%; background: linear-gradient(90deg, #667eea 0%, #764ba2 100%); transition: width 0.4s ease; width: 0%;"></div>
            </div>

            <div class="wizard-header" style="padding: 30px 50px 20px; border-bottom: 1px solid #f0f0f0;">
                <div class="steps-container" style="overflow-x: auto; overflow-y: hidden; padding-bottom: 5px;">
                    <div class="steps" id="stepsContainer" style="display: flex; gap: 10px; min-width: max-content; padding-bottom: 10px;">
                        <?php
                        $steps = array(
                            __('Willkommen', 'psycho-wizard'),
                            __('Hello Theme', 'psycho-wizard'),
                            __('Elementor', 'psycho-wizard'),
                            __('Elementor Pro', 'psycho-wizard'),
                            __('Template Kit', 'psycho-wizard'),
                            __('ACF Setup', 'psycho-wizard'),
                            __('Team Settings', 'psycho-wizard'),
                            __('Styling Plugin', 'psycho-wizard'),
                            __('Demo Daten', 'psycho-wizard'),
                            __('Datenschutz', 'psycho-wizard'),
                            __('Templates', 'psycho-wizard'),
                            __('WP Settings', 'psycho-wizard'),
                            __('Farben', 'psycho-wizard'),
                            __('Typography', 'psycho-wizard'),
                            __('Styles', 'psycho-wizard'),
                            __('Fertig', 'psycho-wizard')
                        );

                        foreach ($steps as $index => $label) {
                            $step_num = $index + 1;
                            $active_class = $step_num === 1 ? 'active' : '';
                            ?>
                            <div class="step <?php echo $active_class; ?>" data-step="<?php echo $step_num; ?>">
                                <div class="step-number"><?php echo $step_num; ?></div>
                                <div class="step-label"><?php echo $label; ?></div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="wizard-body" style="padding: 30px 50px; overflow-y: auto; flex: 1;">

                <?php
                // Hier werden alle 13 Schritte inkludiert
                // Step 1: Welcome
                include PSYCHO_WIZARD_PATH . 'templates/steps/step-welcome.php';

                // Step 2-16: Weitere Steps
                for ($i = 2; $i <= 16; $i++) {
                    $step_file = PSYCHO_WIZARD_PATH . 'templates/steps/step-' . $i . '.php';
                    if (file_exists($step_file)) {
                        include $step_file;
                    }
                }
                ?>

            </div>

            <div class="wizard-footer" style="padding: 20px 50px; border-top: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center;">
                <button class="btn btn-secondary" id="prevBtn" style="visibility: hidden;">
                    <?php _e('← Zurück', 'psycho-wizard'); ?>
                </button>
                <button class="btn btn-primary" id="nextBtn">
                    <?php _e('Los geht\'s →', 'psycho-wizard'); ?>
                </button>
            </div>

        </div>
    </div>
</div>

<style>
/* Minimales Inline CSS - Haupt-Styles sind in wizard.css */
.wizard-container * {
    box-sizing: border-box;
}
</style>
