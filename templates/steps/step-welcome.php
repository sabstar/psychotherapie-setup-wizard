<?php
/**
 * Step 1: Welcome
 */
if (!defined('ABSPATH')) {
    exit;
}

// Hole aktuellen Status
$status = Psycho_Status_Checker::get_wizard_status();
$current_step = $status['current_step'] ?? 1;
$is_continued = $current_step > 1;
?>

<div class="wizard-step active" data-step="1">
    <div class="welcome-container">

        <!-- Hero Section -->
        <div class="welcome-hero">
            <h1><?php _e('Willkommen beim Setup Wizard', 'psycho-wizard'); ?></h1>
            <p class="welcome-subtitle">
                <?php _e('Richte deine Psychotherapie-Website in wenigen Schritten ein', 'psycho-wizard'); ?>
            </p>
        </div>

        <!-- Progress Overview (nur wenn bereits gestartet) -->
        <?php if ($is_continued): ?>
        <div class="setup-progress-overview">
            <div class="progress-header">
                <span class="progress-icon">📊</span>
                <h3><?php _e('Dein Fortschritt', 'psycho-wizard'); ?></h3>
            </div>
            <div class="progress-bar-container">
                <div class="progress-bar">
                    <div class="progress-fill" style="width: <?php echo round(($current_step / 13) * 100); ?>%"></div>
                </div>
                <span class="progress-text"><?php printf(__('Schritt %d von 13', 'psycho-wizard'), $current_step); ?></span>
            </div>
        </div>
        <?php endif; ?>

        <!-- Was wird eingerichtet -->
        <div class="setup-features">
            <h2><?php _e('Was wird eingerichtet?', 'psycho-wizard'); ?></h2>
            <div class="features-grid">
                <div class="feature-card">
                    <span class="feature-icon">🔌</span>
                    <h3><?php _e('Plugins', 'psycho-wizard'); ?></h3>
                    <p><?php _e('Elementor & notwendige Erweiterungen', 'psycho-wizard'); ?></p>
                </div>
                <div class="feature-card">
                    <span class="feature-icon">👥</span>
                    <h3><?php _e('Team Members', 'psycho-wizard'); ?></h3>
                    <p><?php _e('Custom Post Type mit 40+ Feldern', 'psycho-wizard'); ?></p>
                </div>
                <div class="feature-card">
                    <span class="feature-icon">🎨</span>
                    <h3><?php _e('Design', 'psycho-wizard'); ?></h3>
                    <p><?php _e('Farben, Schriften & Templates', 'psycho-wizard'); ?></p>
                </div>
                <div class="feature-card">
                    <span class="feature-icon">⚙️</span>
                    <h3><?php _e('Konfiguration', 'psycho-wizard'); ?></h3>
                    <p><?php _e('WordPress & Elementor Settings', 'psycho-wizard'); ?></p>
                </div>
            </div>
        </div>

        <!-- Fortsetzen Kachel (wird per JavaScript gefüllt wenn es abgeschlossene Steps gibt) -->
        <div id="continueSetupCard" style="display: none; margin: 30px 0; padding: 25px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; color: white; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);">
            <div style="display: flex; align-items: center; gap: 15px;">
                <div style="font-size: 48px;">⚡</div>
                <div style="flex: 1;">
                    <h3 style="margin: 0 0 8px 0; font-size: 20px; color: white;"><?php _e('Weitermachen wo du aufgehört hast', 'psycho-wizard'); ?></h3>
                    <p style="margin: 0; opacity: 0.9; font-size: 14px;" id="nextStepDescription">
                        <?php _e('Nächster Schritt:', 'psycho-wizard'); ?> <strong id="nextStepName"><?php _e('Loading...', 'psycho-wizard'); ?></strong>
                    </p>
                </div>
                <button
                    id="jumpToNextStep"
                    style="padding: 12px 24px; background: white; color: #667eea; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.2); transition: transform 0.2s;"
                    onmouseover="this.style.transform='scale(1.05)'"
                    onmouseout="this.style.transform='scale(1)'">
                    <?php _e('Jetzt fortsetzen →', 'psycho-wizard'); ?>
                </button>
            </div>
        </div>

        <!-- Info Text -->
        <div style="text-align: center; margin-top: 30px; color: #64748b;">
            <p><?php _e('Klicke auf "Los geht\'s →" unten rechts um zu beginnen', 'psycho-wizard'); ?></p>
        </div>

    </div>
</div>

<style>
.welcome-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 40px 20px;
}

/* Hero Section */
.welcome-hero {
    text-align: center;
    margin-bottom: 30px;
}

.welcome-hero h1 {
    font-size: 36px;
    font-weight: 700;
    margin: 0 0 15px 0;
    color: #1e293b;
}

.welcome-subtitle {
    font-size: 18px;
    color: #64748b;
    margin: 0;
}

/* Progress Overview */
.setup-progress-overview {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 30px;
    border-radius: 16px;
    margin-bottom: 40px;
    color: white;
}

.progress-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
}

.progress-header .progress-icon {
    font-size: 24px;
}

.progress-header h3 {
    margin: 0;
    font-size: 20px;
    font-weight: 600;
}

.progress-bar-container {
    position: relative;
}

.progress-bar {
    height: 12px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 6px;
    overflow: hidden;
    margin-bottom: 10px;
}

.progress-fill {
    height: 100%;
    background: white;
    border-radius: 6px;
    transition: width 0.3s ease;
}

.progress-text {
    font-size: 14px;
    opacity: 0.9;
}

/* Features Section */
.setup-features {
    margin-bottom: 40px;
}

.setup-features h2 {
    text-align: center;
    font-size: 24px;
    margin-bottom: 30px;
    color: #1e293b;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 20px;
    margin-bottom: 20px;
}

.feature-card {
    text-align: center;
    padding: 25px 15px;
    background: #f8fafc;
    border-radius: 12px;
    border: 2px solid #e2e8f0;
    transition: all 0.2s ease;
}

.feature-card:hover {
    transform: translateY(-2px);
    border-color: #667eea;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
}

.feature-icon {
    font-size: 40px;
    display: block;
    margin-bottom: 12px;
}

.feature-card h3 {
    font-size: 16px;
    font-weight: 600;
    margin: 0 0 8px 0;
    color: #1e293b;
}

.feature-card p {
    font-size: 13px;
    color: #64748b;
    margin: 0;
    line-height: 1.4;
}

/* Checklist */
.setup-checklist {
    background: white;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 40px;
}

.setup-checklist h3 {
    font-size: 18px;
    margin: 0 0 20px 0;
    color: #1e293b;
}

.checklist-items {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.checklist-item {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 15px;
    padding: 8px 0;
}

.checklist-item.completed {
    color: #059669;
}

.checklist-item.pending {
    color: #64748b;
}

.check-icon {
    font-size: 20px;
    font-weight: bold;
    width: 24px;
    text-align: center;
}

/* CTA Section */
.welcome-cta {
    text-align: center;
    padding-top: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 15px;
}

.btn-large {
    font-size: 18px;
    padding: 18px 40px;
    min-width: 280px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
}

.btn-icon {
    font-size: 24px;
}

.btn-hint {
    font-size: 13px;
    opacity: 0.9;
    font-weight: 400;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 4px 14px rgba(102, 126, 234, 0.4);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
}

.btn-secondary {
    background: transparent;
    color: #64748b;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    padding: 12px 24px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-secondary:hover {
    border-color: #cbd5e1;
    color: #475569;
}

/* Responsive */
@media (max-width: 640px) {
    .welcome-hero h1 {
        font-size: 28px;
    }

    .welcome-subtitle {
        font-size: 16px;
    }

    .features-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .btn-large {
        min-width: 100%;
    }
}
</style>

<script>
jQuery(document).ready(function($) {
    // Continue Setup Button
    $('#continueSetup').on('click', function() {
        const currentStep = <?php echo $current_step; ?>;
        $('.wizard-step').removeClass('active');
        $(`.wizard-step[data-step="${currentStep}"]`).addClass('active');
    });

    // Start Setup Button
    $('#startSetup').on('click', function() {
        $('.wizard-step').removeClass('active');
        $('.wizard-step[data-step="2"]').addClass('active');
    });

    // Restart Setup Button
    $('#restartSetup').on('click', function() {
        if (confirm(<?php echo json_encode(__('Möchtest du wirklich von vorne beginnen? Der bisherige Fortschritt bleibt erhalten.', 'psycho-wizard')); ?>)) {
            $('.wizard-step').removeClass('active');
            $('.wizard-step[data-step="2"]').addClass('active');
        }
    });
});
</script>