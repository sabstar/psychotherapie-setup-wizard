<?php
/**
 * Step 15: Button & Image Styles
 */
if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="wizard-step" data-step="15">
    <h2><?php _e('🎨 Button, Image & Container Styles', 'psycho-wizard'); ?></h2>
    <p class="step-description">
        <?php _e('Wähle ein Style-Set für deine Buttons, Images und Container. Du kannst die Styles jederzeit hier ändern.', 'psycho-wizard'); ?>
    </p>

    <!-- Style Schemes Section -->
    <div style="margin-bottom: 30px;">
        <div class="style-schemes" id="styleSchemes">
            <!-- Wird von JavaScript gefüllt -->
        </div>
    </div>

    <div class="info-box">
        <div class="info-box-title"><?php _e('💡 Tipp: Zurück zu Template-Standards', 'psycho-wizard'); ?></div>
        <div class="info-box-content">
            <?php _e('Um alle Styles auf die Template-Standardwerte zurückzusetzen, wähle einfach <strong>"🎯 Template Standard"</strong> aus. Die Styles gelten für alle Buttons, Images und Container mit der Klasse <code>.rounded-container</code>.', 'psycho-wizard'); ?>
        </div>
    </div>

    <div class="info-box" style="margin-top: 20px; background: #eff6ff; border-color: #3b82f6;">
        <div class="info-box-title" style="color: #1e40af;"><?php _e('ℹ️ Optionaler Schritt', 'psycho-wizard'); ?></div>
        <div class="info-box-content" style="color: #1e40af;">
            <?php _e('Dieser Schritt ist <strong>optional</strong>. Du kannst direkt zum nächsten Schritt gehen, falls du die Styles nicht ändern möchtest.', 'psycho-wizard'); ?>
        </div>
    </div>
</div>

<script>
// Style Schemes Definition
const styleSchemes = {
    'template-standard': {
        name: <?php echo json_encode(__('🎯 Template Standard', 'psycho-wizard')); ?>,
        description: <?php echo json_encode(__('Runde Buttons & sanfte Schatten', 'psycho-wizard')); ?>,
        button_border_radius: {
            unit: 'px',
            top: '50',
            right: '50',
            bottom: '50',
            left: '50',
            isLinked: true
        },
        button_padding: {
            unit: 'px',
            top: '016',
            right: '036',
            bottom: '016',
            left: '036',
            isLinked: false
        },
        image_border_radius: {
            unit: 'px',
            top: '15',
            right: '15',
            bottom: '15',
            left: '15',
            isLinked: true
        },
        image_box_shadow: {
            horizontal: 4,
            vertical: 3,
            blur: 10,
            spread: 0,
            color: 'rgba(0,0,0,0.5)'
        },
        container_border_radius: 15,
        container_box_shadow: '0 2px 8px rgba(0,0,0,0.1)'
    },
    'modern-sharp': {
        name: <?php echo json_encode(__('🔲 Modern & Sharp', 'psycho-wizard')); ?>,
        description: <?php echo json_encode(__('Kantige Buttons, minimale Schatten', 'psycho-wizard')); ?>,
        button_border_radius: {
            unit: 'px',
            top: '0',
            right: '0',
            bottom: '0',
            left: '0',
            isLinked: true
        },
        button_padding: {
            unit: 'px',
            top: '018',
            right: '040',
            bottom: '018',
            left: '040',
            isLinked: false
        },
        image_border_radius: {
            unit: 'px',
            top: '0',
            right: '0',
            bottom: '0',
            left: '0',
            isLinked: true
        },
        image_box_shadow: {
            horizontal: 0,
            vertical: 2,
            blur: 8,
            spread: 0,
            color: 'rgba(0,0,0,0.15)'
        },
        container_border_radius: 0,
        container_box_shadow: '0 1px 3px rgba(0,0,0,0.05)'
    },
    'soft-rounded': {
        name: <?php echo json_encode(__('🌸 Soft & Cozy', 'psycho-wizard')); ?>,
        description: <?php echo json_encode(__('Sehr runde Ecken, weiche Schatten', 'psycho-wizard')); ?>,
        button_border_radius: {
            unit: 'px',
            top: '100',
            right: '100',
            bottom: '100',
            left: '100',
            isLinked: true
        },
        button_padding: {
            unit: 'px',
            top: '020',
            right: '045',
            bottom: '020',
            left: '045',
            isLinked: false
        },
        image_border_radius: {
            unit: 'px',
            top: '30',
            right: '30',
            bottom: '30',
            left: '30',
            isLinked: true
        },
        image_box_shadow: {
            horizontal: 0,
            vertical: 8,
            blur: 20,
            spread: 0,
            color: 'rgba(0,0,0,0.2)'
        },
        container_border_radius: 30,
        container_box_shadow: '0 8px 24px rgba(0,0,0,0.15)'
    },
    'minimal': {
        name: <?php echo json_encode(__('✨ Minimal', 'psycho-wizard')); ?>,
        description: <?php echo json_encode(__('Leichte Rundung, soft shadows', 'psycho-wizard')); ?>,
        button_border_radius: {
            unit: 'px',
            top: '8',
            right: '8',
            bottom: '8',
            left: '8',
            isLinked: true
        },
        button_padding: {
            unit: 'px',
            top: '014',
            right: '032',
            bottom: '014',
            left: '032',
            isLinked: false
        },
        image_border_radius: {
            unit: 'px',
            top: '8',
            right: '8',
            bottom: '8',
            left: '8',
            isLinked: true
        },
        image_box_shadow: {
            horizontal: 0,
            vertical: 2,
            blur: 8,
            spread: 0,
            color: 'rgba(0,0,0,0.08)'
        },
        container_border_radius: 8,
        container_box_shadow: '0 2px 8px rgba(0,0,0,0.06)'
    },
    'spacious-welcoming': {
        name: <?php echo json_encode(__('🤗 Spacious & Welcoming', 'psycho-wizard')); ?>,
        description: <?php echo json_encode(__('Größere Buttons, sanfte Schatten', 'psycho-wizard')); ?>,
        button_border_radius: {
            unit: 'px',
            top: '12',
            right: '12',
            bottom: '12',
            left: '12',
            isLinked: true
        },
        button_padding: {
            unit: 'px',
            top: '020',
            right: '044',
            bottom: '020',
            left: '044',
            isLinked: false
        },
        image_border_radius: {
            unit: 'px',
            top: '12',
            right: '12',
            bottom: '12',
            left: '12',
            isLinked: true
        },
        image_box_shadow: {
            horizontal: 0,
            vertical: 4,
            blur: 12,
            spread: 0,
            color: 'rgba(0,0,0,0.12)'
        },
        container_border_radius: 12,
        container_box_shadow: '0 4px 12px rgba(0,0,0,0.08)'
    },
    'elegant-refined': {
        name: <?php echo json_encode(__('💎 Elegant & Refined', 'psycho-wizard')); ?>,
        description: <?php echo json_encode(__('Sophisticated, subtile Eleganz', 'psycho-wizard')); ?>,
        button_border_radius: {
            unit: 'px',
            top: '18',
            right: '18',
            bottom: '18',
            left: '18',
            isLinked: true
        },
        button_padding: {
            unit: 'px',
            top: '017',
            right: '038',
            bottom: '017',
            left: '038',
            isLinked: false
        },
        image_border_radius: {
            unit: 'px',
            top: '18',
            right: '18',
            bottom: '18',
            left: '18',
            isLinked: true
        },
        image_box_shadow: {
            horizontal: 0,
            vertical: 6,
            blur: 16,
            spread: -2,
            color: 'rgba(0,0,0,0.18)'
        },
        container_border_radius: 18,
        container_box_shadow: '0 6px 16px -2px rgba(0,0,0,0.12)'
    }
};

jQuery(document).ready(function($) {
    // Rendere Style-Scheme Cards
    function renderStyleSchemes() {
        const $container = $('#styleSchemes');
        let html = '';

        for (const [schemeKey, schemeData] of Object.entries(styleSchemes)) {
            html += `
                <div class="style-scheme" data-scheme="${schemeKey}">
                    <div class="style-scheme-header">
                        <h4>${schemeData.name}</h4>
                        <p>${schemeData.description}</p>
                    </div>
                    <div class="style-scheme-preview">
                        <div class="preview-button" style="border-radius: ${schemeData.button_border_radius.top}px; padding: 12px 24px;">
                            <?php echo esc_js(__('Button', 'psycho-wizard')); ?>
                        </div>
                        <div class="preview-image" style="
                            border-radius: ${schemeData.image_border_radius.top}px;
                            box-shadow: ${schemeData.image_box_shadow.horizontal}px ${schemeData.image_box_shadow.vertical}px ${schemeData.image_box_shadow.blur}px ${schemeData.image_box_shadow.spread}px ${schemeData.image_box_shadow.color};
                        ">
                            <div style="width: 100%; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: ${schemeData.image_border_radius.top}px;"></div>
                        </div>
                        <div class="preview-container" style="
                            border: 2px solid #e5e7eb;
                            border-radius: ${schemeData.container_border_radius}px;
                            box-shadow: ${schemeData.container_box_shadow};
                            padding: 15px;
                            background: white;
                            font-size: 12px;
                            color: #64748b;
                            text-align: center;
                        ">
                            <?php echo esc_js(__('Container', 'psycho-wizard')); ?>
                        </div>
                    </div>
                </div>
            `;
        }

        $container.html(html);
    }

    renderStyleSchemes();

    // Lade aktives Style-Schema beim Start
    $.ajax({
        url: psychoWizard.ajaxUrl,
        type: 'POST',
        data: {
            action: 'psycho_get_active_style_scheme',
            nonce: psychoWizard.nonce
        },
        success: function(response) {
            if (response.success && response.data.scheme) {
                $(`.style-scheme[data-scheme="${response.data.scheme}"]`).addClass('active');
            }
        }
    });

    // Style-Schema anwenden
    $(document).on('click', '.style-scheme', function() {
        const $this = $(this);
        const scheme = $this.data('scheme');
        const schemeData = styleSchemes[scheme];

        if (!schemeData) {
            return;
        }

        // Visuelles Feedback
        $('.style-scheme').removeClass('active');
        $this.addClass('active applying');
        $this.find('.style-scheme-header h4').text(<?php echo json_encode(__('⏳ Wird angewendet...', 'psycho-wizard')); ?>);

        $.ajax({
            url: psychoWizard.ajaxUrl,
            type: 'POST',
            data: {
                action: 'psycho_apply_style_scheme',
                nonce: psychoWizard.nonce,
                scheme: scheme,
                styles: {
                    button_border_radius: schemeData.button_border_radius,
                    button_padding: schemeData.button_padding,
                    image_border_radius: schemeData.image_border_radius,
                    image_box_shadow: schemeData.image_box_shadow,
                    container_border_radius: schemeData.container_border_radius,
                    container_box_shadow: schemeData.container_box_shadow
                }
            },
            success: function(response) {
                $this.removeClass('applying');
                $this.find('.style-scheme-header h4').text(schemeData.name);

                console.log('Style Scheme Response:', response);

                if (response.success) {
                    window.showNotification('success', '✅ ' + response.data.message);

                    // Markiere Step 15 manuell als completed in der Progress Bar
                    $('.step[data-step="15"]').addClass('completed');
                    console.log('Step 15 manually marked as completed');

                    // Lade Wizard Status neu um Step 15 als completed zu markieren
                    if (typeof loadWizardStatus === 'function') {
                        console.log('Calling loadWizardStatus...');
                        loadWizardStatus();
                    } else {
                        console.error('loadWizardStatus is not defined');
                    }
                } else {
                    window.showNotification('error', '❌ ' + (response.data?.message || <?php echo json_encode(__('Fehler beim Anwenden', 'psycho-wizard')); ?>));
                    $('.style-scheme').removeClass('active');
                }
            },
            error: function() {
                $this.removeClass('applying');
                $this.find('.style-scheme-header h4').text(schemeData.name);
                window.showNotification('error', <?php echo json_encode(__('❌ Verbindungsfehler', 'psycho-wizard')); ?>);
                $('.style-scheme').removeClass('active');
            }
        });
    });
});
</script>
