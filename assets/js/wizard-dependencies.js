/**
 * Wizard Dependencies & Navigation System
 */

// Step-Abhängigkeiten definieren
const stepDependencies = {
    1: [], // Welcome - keine Abhängigkeiten
    2: [], // Hello Theme - keine Abhängigkeiten
    3: [2], // Elementor - benötigt Hello Theme
    4: [2, 3], // Elementor Pro - benötigt Hello + Elementor
    5: [2, 3, 4], // Template Kit - benötigt Hello + Elementor + Pro
    6: [2, 3, 4, 5], // ACF JSON - benötigt alle vorherigen
    7: [2, 3, 4, 5, 6], // Team CPT + Settings - benötigt ACF
    8: [2, 3, 4, 5, 6, 7], // Styling Plugin - benötigt Basics
    9: [2, 3, 4, 5, 6, 7], // Demo-Daten - benötigt Basics (optional aber nach Basics)
    10: [2, 3, 4, 5, 6, 7], // WP Settings - benötigt Basics
    11: [2, 3, 4, 5, 6, 7], // Template-Zuordnung - benötigt Basics
    12: [2, 3, 4, 5, 6, 7], // Farben - benötigt Basics
    13: [2, 3, 4, 5, 6, 7]  // Schriftarten - benötigt Basics
};

// Completed Steps (wird beim Laden gefüllt)
let completedSteps = [];

/**
 * Prüfe ob Step abgeschlossen ist
 */
function isStepCompleted(stepNumber) {
    return completedSteps.includes(stepNumber);
}

/**
 * Prüfe ob Step entsperrt ist (alle Abhängigkeiten erfüllt)
 */
function isStepUnlocked(stepNumber) {
    const dependencies = stepDependencies[stepNumber] || [];
    
    // Prüfe ob alle Abhängigkeiten erfüllt sind
    for (let dep of dependencies) {
        if (!isStepCompleted(dep)) {
            return false;
        }
    }
    
    return true;
}

/**
 * Prüfe ob Navigation zu Step erlaubt ist
 */
function canNavigateToStep(targetStep) {
    // Zurückspringen ist immer erlaubt
    if (targetStep < currentStep) {
        return true;
    }
    
    // Zu aktuellem Step ist erlaubt
    if (targetStep === currentStep) {
        return true;
    }
    
    // Vorwärtsspringen nur zu entsperrten Steps
    return isStepUnlocked(targetStep);
}

/**
 * Hole fehlende Abhängigkeiten für einen Step
 */
function getMissingDependencies(stepNumber) {
    const dependencies = stepDependencies[stepNumber] || [];
    const missing = [];
    
    for (let dep of dependencies) {
        if (!isStepCompleted(dep)) {
            missing.push(dep);
        }
    }
    
    return missing;
}

/**
 * Zeige Lock-Overlay wenn Step gesperrt ist
 */
function showStepLockOverlay(stepNumber) {
    const missing = getMissingDependencies(stepNumber);
    
    if (missing.length === 0) {
        return; // Keine fehlenden Abhängigkeiten
    }
    
    // Erstelle Overlay
    const stepNames = {
        2: 'Hello Theme',
        3: 'Elementor',
        4: 'Elementor Pro',
        5: 'Template Kit',
        6: 'ACF Setup',
        7: 'Team CPT & Elementor Settings'
    };
    
    let missingStepNames = missing.map(s => stepNames[s]).join(', ');

    const $overlay = jQuery('<div class="step-lock-overlay">')
        .html(`
            <div class="lock-content">
                <div class="lock-icon">🔒</div>
                <h3>Dieser Schritt ist noch gesperrt</h3>
                <p>Bitte schließe zuerst folgende Schritte ab:</p>
                <ul class="missing-steps">
                    ${missing.map(s => `<li>Schritt ${s}: ${stepNames[s]}</li>`).join('')}
                </ul>
                <button class="btn btn-primary" onclick="goToFirstMissingStep(${stepNumber})">
                    Zum nächsten offenen Schritt
                </button>
            </div>
        `);

    jQuery('.wizard-step[data-step="' + stepNumber + '"]').prepend($overlay);
}

/**
 * Entferne Lock-Overlay
 */
function removeStepLockOverlay() {
    jQuery('.step-lock-overlay').remove();
}

/**
 * Gehe zum ersten fehlenden Schritt
 */
window.goToFirstMissingStep = function(fromStep) {
    const missing = getMissingDependencies(fromStep);
    
    if (missing.length > 0) {
        currentStep = missing[0];
        updateSteps();
        updateProgress();
        updateButtons();
    }
};

/**
 * Update Step-Bubbles mit Lock-Status
 */
function updateStepBubbles() {
    jQuery('.step').each(function() {
        const stepNum = parseInt(jQuery(this).data('step'));
        const $stepNumber = jQuery(this).find('.step-number');

        // Entferne alte Klassen
        jQuery(this).removeClass('locked completed active');
        $stepNumber.removeClass('locked');

        if (stepNum === currentStep) {
            // Aktueller Step
            jQuery(this).addClass('active');
        } else if (isStepCompleted(stepNum)) {
            // Abgeschlossener Step
            jQuery(this).addClass('completed');
            $stepNumber.text('');
        } else if (!isStepUnlocked(stepNum)) {
            // Gesperrter Step
            jQuery(this).addClass('locked');
            $stepNumber.addClass('locked').html('🔒');
        } else {
            // Offener Step (noch nicht begonnen)
            $stepNumber.text(stepNum);
        }
    });
}

/**
 * Click-Handler für Step-Bubbles
 */
function setupStepNavigation() {
    jQuery('.step').on('click', function() {
        const targetStep = parseInt(jQuery(this).data('step'));
        
        if (canNavigateToStep(targetStep)) {
            currentStep = targetStep;
            removeStepLockOverlay();
            updateSteps();
            updateProgress();
            updateButtons();
            saveCurrentStep();
        } else {
            // Zeige Warnung
            showNotification('error', 'Dieser Schritt ist noch gesperrt. Bitte schließe zuerst die vorherigen Schritte ab.');
        }
    });
}

/**
 * Lade completed Steps aus Status
 */
function loadCompletedSteps(status) {
    completedSteps = [];
    
    // Step 2: Hello Theme
    if (status.hello_theme_active) {
        completedSteps.push(2);
    }
    
    // Step 3: Elementor
    if (status.elementor_active) {
        completedSteps.push(3);
    }
    
    // Step 4: Elementor Pro + Lizenz
    if (status.elementor_pro_active && status.elementor_pro_license_active) {
        completedSteps.push(4);
    }
    
    // Step 5: Template Kit
    if (status.wizard_status && status.wizard_status.template_kit_imported) {
        completedSteps.push(5);
    }
    
    // Step 6: ACF
    if (status.wizard_status && status.wizard_status.acf_imported) {
        completedSteps.push(6);
    }
    
    // Step 7: Team CPT + Settings
    if (status.wizard_status && status.wizard_status.team_settings_configured) {
        completedSteps.push(7);
    }
    
    // Step 8: Styling Plugin
    if (status.wizard_status && status.wizard_status.styling_plugin_installed) {
        completedSteps.push(8);
    }
    
    // Step 9: Demo Data
    if (status.wizard_status && status.wizard_status.demo_data_imported) {
        completedSteps.push(9);
    }
    
    // Step 10: WP Settings
    if (status.wizard_status && status.wizard_status.settings_configured) {
        completedSteps.push(10);
    }
    
    // Step 11: Templates
    if (status.wizard_status && status.wizard_status.templates_assigned) {
        completedSteps.push(11);
    }
    
    // Step 12: Colors
    if (status.wizard_status && status.wizard_status.colors_set) {
        completedSteps.push(12);
    }
    
    // Step 13: Fonts
    if (status.wizard_status && status.wizard_status.fonts_uploaded) {
        completedSteps.push(13);
    }

    console.log('Completed Steps:', completedSteps);
}