<?php
/**
 * Step 11: Templates zuweisen
 */
if (!defined('ABSPATH')) {
    exit;
}

$wizard_status = Psycho_Status_Checker::get_wizard_status();
$is_assigned = isset($wizard_status['templates_assigned']) && $wizard_status['templates_assigned'];
?>

<div class="wizard-step" data-step="11">
    <h2><?php _e('Templates zuweisen', 'psycho-wizard'); ?></h2>
    <p class="step-description">
        <?php _e('Weise die Elementor Templates den jeweiligen Seiten zu und verbinde Loop Grids mit deinen Inhalten.', 'psycho-wizard'); ?>
    </p>

    <div class="info-box" style="background: #eff6ff; border-color: #3b82f6; margin-bottom: 30px;">
        <div class="info-box-title" style="color: #1e40af;"><?php _e('📘 Wichtig', 'psycho-wizard'); ?></div>
        <div class="info-box-content" style="color: #1e40af;">
            <?php _e('Dieser Schritt ist essentiell! Ohne Template-Zuordnung werden deine Seiten nicht korrekt angezeigt.', 'psycho-wizard'); ?>
        </div>
    </div>

    <!-- Section 1: Single Pages zuweisen -->
    <div style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 30px; margin-bottom: 30px;">
        <h3 style="font-size: 20px; margin-bottom: 20px; color: #1e293b;"><?php _e('📄 Teil 1: Single Pages zuweisen', 'psycho-wizard'); ?></h3>

        <!-- Schritt 1 -->
        <div style="margin-bottom: 30px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                <div style="background: #3b82f6; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0;">1</div>
                <h4 style="margin: 0; font-size: 16px; font-weight: 600; color: #1e293b;"><?php _e('Gehe zu Templates → Theme Builder', 'psycho-wizard'); ?></h4>
            </div>
            <p style="color: #64748b; margin-bottom: 15px; padding-left: 44px;">
                <?php _e('Öffne im WordPress Dashboard den Theme Builder von Elementor.', 'psycho-wizard'); ?>
            </p>
        </div>

        <!-- Schritt 2 mit Screenshot -->
        <div style="margin-bottom: 30px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                <div style="background: #3b82f6; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0;">2</div>
                <h4 style="margin: 0; font-size: 16px; font-weight: 600; color: #1e293b;"><?php _e('Theme Builder Übersicht verstehen', 'psycho-wizard'); ?></h4>
            </div>
            <p style="color: #64748b; margin-bottom: 15px; padding-left: 44px;">
                <?php _e('Du siehst hier die Übersichtsseite mit allen Templates. Wenn ein Template einen <strong style="color: #10b981;">grünen Punkt</strong> oben links hat, bedeutet dies, dass es bereits einer Seite zugeordnet ist.<br><br>In der Übersicht siehst du auch die <strong>Loop Grids</strong>, die wir später den Blog- und Team-Seiten zuordnen werden.', 'psycho-wizard'); ?>
            </p>
            <img src="<?php echo esc_url(PSYCHO_WIZARD_URL . 'assets/images/Theme_Builder_Overview_new.png'); ?>" alt="<?php esc_attr_e('Theme Builder Übersicht', 'psycho-wizard'); ?>" style="max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-left: 44px;">
        </div>

        <!-- Schritt 3 -->
        <div style="margin-bottom: 30px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                <div style="background: #3b82f6; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0;">3</div>
                <h4 style="margin: 0; font-size: 16px; font-weight: 600; color: #1e293b;"><?php _e('Klicke links auf "Einzelne Seite"', 'psycho-wizard'); ?></h4>
            </div>
            <p style="color: #64748b; margin-bottom: 15px; padding-left: 44px;">
                <?php _e('Wir werden jetzt Seite für Seite die Templates zuordnen. Wähle eine Seite aus, die noch nicht zugeordnet ist (z.B. <strong>Contact</strong>).', 'psycho-wizard'); ?>
            </p>
        </div>

        <!-- Schritt 4 mit Screenshot -->
        <div style="margin-bottom: 30px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                <div style="background: #3b82f6; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0;">4</div>
                <h4 style="margin: 0; font-size: 16px; font-weight: 600; color: #1e293b;"><?php _e('Bedingungen bearbeiten', 'psycho-wizard'); ?></h4>
            </div>
            <p style="color: #64748b; margin-bottom: 15px; padding-left: 44px;">
                <?php _e('Bei dem ausgewählten Template siehst du links unten die Option <strong>"Bedingungen bearbeiten"</strong>. Klicke darauf.', 'psycho-wizard'); ?>
            </p>
            <img src="<?php echo esc_url(PSYCHO_WIZARD_URL . 'assets/images/Conditions_new.png'); ?>" alt="<?php esc_attr_e('Bedingungen bearbeiten', 'psycho-wizard'); ?>" style="max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-left: 44px;">
        </div>

        <!-- Schritt 5 mit Screenshot -->
        <div style="margin-bottom: 30px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                <div style="background: #3b82f6; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0;">5</div>
                <h4 style="margin: 0; font-size: 16px; font-weight: 600; color: #1e293b;"><?php _e('Bedingung hinzufügen', 'psycho-wizard'); ?></h4>
            </div>
            <p style="color: #64748b; margin-bottom: 15px; padding-left: 44px;">
                <?php _e('Klicke auf <strong>"Bedingung hinzufügen"</strong>.', 'psycho-wizard'); ?>
            </p>
            <img src="<?php echo esc_url(PSYCHO_WIZARD_URL . 'assets/images/Add_Condition_new.png'); ?>" alt="<?php esc_attr_e('Bedingung hinzufügen', 'psycho-wizard'); ?>" style="max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-left: 44px;">
        </div>

        <!-- Schritt 6 mit Screenshot -->
        <div style="margin-bottom: 30px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                <div style="background: #3b82f6; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0;">6</div>
                <h4 style="margin: 0; font-size: 16px; font-weight: 600; color: #1e293b;"><?php _e('Seite auswählen und speichern', 'psycho-wizard'); ?></h4>
            </div>
            <p style="color: #64748b; margin-bottom: 15px; padding-left: 44px;">
                <?php _e('Wähle im ersten Dropdown <strong>"Seiten"</strong> aus. Im zweiten Dropdown gibst du <strong>"Contact"</strong> in die Suche ein. Die Contact-Seite sollte nun erscheinen. Wähle sie aus und klicke auf <strong>"Speichern und Schließen"</strong>.', 'psycho-wizard'); ?>
            </p>
            <img src="<?php echo esc_url(PSYCHO_WIZARD_URL . 'assets/images/add_page_and_save_new_contact.png'); ?>" alt="<?php esc_attr_e('Seite auswählen', 'psycho-wizard'); ?>" style="max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-left: 44px;">
        </div>

        <!-- Wiederhole für andere Seiten -->
        <div style="background: #f8fafc; border-left: 4px solid #3b82f6; padding: 20px; margin-top: 20px; margin-left: 44px;">
            <h5 style="margin: 0 0 15px 0; color: #1e293b; font-size: 15px; font-weight: 600;"><?php _e('📋 Wiederhole dies für folgende Seiten:', 'psycho-wizard'); ?></h5>
            <ul style="margin: 0; padding-left: 20px; color: #64748b;">
                <li style="margin-bottom: 8px;"><?php _e('<strong>Contact</strong> → Suche nach "Contact"', 'psycho-wizard'); ?></li>
                <li style="margin-bottom: 8px;"><?php _e('<strong>How it works</strong> → Suche nach "How it works"', 'psycho-wizard'); ?></li>
                <li style="margin-bottom: 8px;"><?php _e('<strong>Home</strong> → Suche nach "Home"', 'psycho-wizard'); ?></li>
                <li style="margin-bottom: 8px;"><?php _e('<strong>Kosten & Abrechnung</strong> → Suche nach "Fees"', 'psycho-wizard'); ?></li>
                <li style="margin-bottom: 8px;"><?php _e('<strong>Therapy Services</strong> → Suche nach "Services"', 'psycho-wizard'); ?></li>
            </ul>
        </div>
    </div>

    <!-- Section 2: Legal Pages -->
    <div style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 30px; margin-bottom: 30px;">
        <h3 style="font-size: 20px; margin-bottom: 20px; color: #1e293b;"><?php _e('🔒 Teil 2: Legal Pages zuweisen', 'psycho-wizard'); ?></h3>

        <div style="margin-bottom: 20px;">
            <p style="color: #64748b; margin-bottom: 15px;">
                <?php _e('Bei den Legal Pages wählst du <strong>Imprint UND Privacy Policy</strong> aus.', 'psycho-wizard'); ?>
            </p>

            <div class="info-box" style="background: #fef3c7; border-color: #f59e0b; margin-bottom: 15px;">
                <div class="info-box-title" style="color: #92400e;"><?php _e('⚠️ Wichtig', 'psycho-wizard'); ?></div>
                <div class="info-box-content" style="color: #92400e;">
                    <?php _e('Die Privacy Page (Datenschutz) muss zuerst veröffentlicht sein, um sie auswählen und zuordnen zu können!', 'psycho-wizard'); ?>
                </div>
            </div>

            <img src="<?php echo esc_url(PSYCHO_WIZARD_URL . 'assets/images/Legal_Pages_new.png'); ?>" alt="<?php esc_attr_e('Legal Pages zuweisen', 'psycho-wizard'); ?>" style="max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        </div>
    </div>

    <!-- Section 3: Loop Grids - Blog -->
    <div style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 30px; margin-bottom: 30px;">
        <h3 style="font-size: 20px; margin-bottom: 20px; color: #1e293b;"><?php _e('📝 Teil 3: Blog Übersichtsseite - Loop Grid & Bedingungen verwalten', 'psycho-wizard'); ?></h3>

        <h4 style="font-size: 18px; margin-bottom: 15px; color: #8b5cf6; font-weight: 600;"><?php _e('1. Loop Grid zuweisen', 'psycho-wizard'); ?></h4>

        <!-- Schritt 1 -->
        <div style="margin-bottom: 30px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                <div style="background: #8b5cf6; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0;">1</div>
                <h4 style="margin: 0; font-size: 16px; font-weight: 600; color: #1e293b;"><?php _e('Öffne Blog Overview im Theme Builder', 'psycho-wizard'); ?></h4>
            </div>
            <p style="color: #64748b; margin-bottom: 15px; padding-left: 44px;">
                <?php _e('Gehe im Theme Builder auf <strong>"Archiv"</strong> und klicke bei der <strong>Blog Overview</strong> Seite auf <strong>"Bearbeiten"</strong>.', 'psycho-wizard'); ?>
            </p>
            <img src="<?php echo esc_url(PSYCHO_WIZARD_URL . 'assets/images/Archive_edit_blog_overview.png'); ?>" alt="<?php esc_attr_e('Archiv Übersicht', 'psycho-wizard'); ?>" style="max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-left: 44px;">
        </div>

        <!-- Schritt 2 -->
        <div style="margin-bottom: 30px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                <div style="background: #8b5cf6; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0;">2</div>
                <h4 style="margin: 0; font-size: 16px; font-weight: 600; color: #1e293b;"><?php _e('Loop Grid Widget auswählen', 'psycho-wizard'); ?></h4>
            </div>
            <p style="color: #64748b; margin-bottom: 15px; padding-left: 44px;">
                <?php _e('Klicke auf das <strong>Loop Grid Widget</strong> - entweder direkt auf die graue Fläche oder rechts in der Struktur.', 'psycho-wizard'); ?>
            </p>
            <img src="<?php echo esc_url(PSYCHO_WIZARD_URL . 'assets/images/assign_loopgrid_new.png'); ?>" alt="<?php esc_attr_e('Loop Grid auswählen', 'psycho-wizard'); ?>" style="max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-left: 44px;">
        </div>

        <!-- Schritt 3 -->
        <div style="margin-bottom: 30px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                <div style="background: #8b5cf6; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0;">3</div>
                <h4 style="margin: 0; font-size: 16px; font-weight: 600; color: #1e293b;"><?php _e('Blog Template zuweisen', 'psycho-wizard'); ?></h4>
            </div>
            <p style="color: #64748b; margin-bottom: 15px; padding-left: 44px;">
                <?php _e('Auf der linken Seite im Loop Grid wählst du jetzt das Template aus. Gebe <strong>"blog"</strong> ein. Es erscheint das <strong>"Blog Posts Layout (Template)"</strong>. Wähle es aus.', 'psycho-wizard'); ?>
            </p>
            <img src="<?php echo esc_url(PSYCHO_WIZARD_URL . 'assets/images/choose_template_new.png'); ?>" alt="<?php esc_attr_e('Blog Template wählen', 'psycho-wizard'); ?>" style="max-width: 50%; height: auto; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-left: 44px;">
        </div>

        <!-- Schritt 4 -->
        <div style="margin-bottom: 30px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                <div style="background: #8b5cf6; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0;">4</div>
                <h4 style="margin: 0; font-size: 16px; font-weight: 600; color: #1e293b;"><?php _e('Überprüfen und Veröffentlichen', 'psycho-wizard'); ?></h4>
            </div>
            <p style="color: #64748b; margin-bottom: 15px; padding-left: 44px;">
                <?php _e('Im Editor sollten jetzt deine Blogposts in der Übersicht erscheinen (sofern du bereits Blog Posts erstellt hast). Klicke auf <strong>"Veröffentlichen"</strong> damit alles gespeichert wird.', 'psycho-wizard'); ?>
            </p>
            <img src="<?php echo esc_url(PSYCHO_WIZARD_URL . 'assets/images/posts_layout_new.png'); ?>" alt="<?php esc_attr_e('Blog Posts Layout', 'psycho-wizard'); ?>" style="max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-left: 44px;">
        </div>

        <h4 style="font-size: 18px; margin: 30px 0 15px 0; color: #8b5cf6; font-weight: 600;"><?php _e('2. Bedingung festlegen', 'psycho-wizard'); ?></h4>

        <!-- Condition Steps -->
        <div style="margin-bottom: 30px;">
            <p style="color: #64748b; margin-bottom: 15px;">
                <?php _e('Klicke in der Archiv-Übersicht bei der Blog Overview auf <strong>"Bedingungen bearbeiten"</strong>.', 'psycho-wizard'); ?>
            </p>
            <img src="<?php echo esc_url(PSYCHO_WIZARD_URL . 'assets/images/edit_condition_blog_archive.png'); ?>" alt="<?php esc_attr_e('Bedingungen bearbeiten Blog Archiv', 'psycho-wizard'); ?>" style="max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 20px;">

            <p style="color: #64748b; margin-bottom: 15px;">
                <?php _e('Klicke auf <strong>"Bedingung hinzufügen"</strong> und wähle das <strong>Beitragsarchiv</strong> aus. Vergiss nicht zu speichern!', 'psycho-wizard'); ?>
            </p>
            <img src="<?php echo esc_url(PSYCHO_WIZARD_URL . 'assets/images/condition_post_archive.png'); ?>" alt="<?php esc_attr_e('Bedingung Beitragsarchiv', 'psycho-wizard'); ?>" style="max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        </div>
    </div>

    <!-- Section 4: Loop Grids - Team -->
    <div style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 30px; margin-bottom: 30px;">
        <h3 style="font-size: 20px; margin-bottom: 20px; color: #1e293b;"><?php _e('👥 Teil 4: Team Übersicht - Taxonomie, Loop Grid & Bedingungen verwalten', 'psycho-wizard'); ?></h3>

        <h4 style="font-size: 18px; margin-bottom: 15px; color: #10b981; font-weight: 600;"><?php _e('1. Taxonomie & Loop Grid zuweisen', 'psycho-wizard'); ?></h4>

        <!-- Schritt 1 -->
        <div style="margin-bottom: 30px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                <div style="background: #10b981; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0;">1</div>
                <h4 style="margin: 0; font-size: 16px; font-weight: 600; color: #1e293b;"><?php _e('Team Overview Template auswählen', 'psycho-wizard'); ?></h4>
            </div>
            <p style="color: #64748b; margin-bottom: 15px; padding-left: 44px;">
                <?php _e('Gehe in der Archiv-Übersicht zum <strong>Team Overview Template</strong> und klicke auf <strong>"Bearbeiten"</strong>.', 'psycho-wizard'); ?>
            </p>
            <img src="<?php echo esc_url(PSYCHO_WIZARD_URL . 'assets/images/select_team_overview_new.png'); ?>" alt="<?php esc_attr_e('Team Overview auswählen', 'psycho-wizard'); ?>" style="max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-left: 44px;">
        </div>

        <!-- Schritt 2 -->
        <div style="margin-bottom: 30px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                <div style="background: #10b981; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0;">2</div>
                <h4 style="margin: 0; font-size: 16px; font-weight: 600; color: #1e293b;"><?php _e('Taxonomie-Filter auswählen', 'psycho-wizard'); ?></h4>
            </div>
            <p style="color: #64748b; margin-bottom: 15px; padding-left: 44px;">
                <?php _e('Suche in der Navigationsleiste nach dem <strong>Taxonomie-Filter</strong> und klicke darauf. Auf der linken Seite wählst du <strong>Loop Grid 1</strong> aus. Dann siehst du die Focus Therapy Tags.', 'psycho-wizard'); ?>
            </p>
            <div class="info-box" style="background: #fef3c7; border-color: #f59e0b; margin-left: 44px; margin-bottom: 15px;">
                <div class="info-box-title" style="color: #92400e;"><?php _e('📌 Hinweis', 'psycho-wizard'); ?></div>
                <div class="info-box-content" style="color: #92400e;">
                    <?php _e('Die Tags werden hier nur angezeigt, wenn du die Demo-Daten importiert hast oder bereits eigene Tags erstellt hast.', 'psycho-wizard'); ?>
                </div>
            </div>
            <img src="<?php echo esc_url(PSYCHO_WIZARD_URL . 'assets/images/select taxonomy filter.png'); ?>" alt="<?php esc_attr_e('Taxonomie-Filter auswählen', 'psycho-wizard'); ?>" style="max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-left: 44px;">
        </div>

        <!-- Schritt 3 -->
        <div style="margin-bottom: 30px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                <div style="background: #10b981; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0;">3</div>
                <h4 style="margin: 0; font-size: 16px; font-weight: 600; color: #1e293b;"><?php _e('Team Loop Grid Template zuweisen', 'psycho-wizard'); ?></h4>
            </div>
            <p style="color: #64748b; margin-bottom: 15px; padding-left: 44px;">
                <?php _e('Suche in der Navigationsstruktur nach dem <strong>Loop Grid</strong>, klicke darauf und suche auf der linken Seite nach dem <strong>team template</strong> und wähle es aus.', 'psycho-wizard'); ?>
            </p>
            <img src="<?php echo esc_url(PSYCHO_WIZARD_URL . 'assets/images/select Team Loop Grid.png'); ?>" alt="<?php esc_attr_e('Team Loop Grid auswählen', 'psycho-wizard'); ?>" style="max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-left: 44px;">
        </div>

        <!-- Schritt 4 -->
        <div style="margin-bottom: 30px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                <div style="background: #10b981; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0;">4</div>
                <h4 style="margin: 0; font-size: 16px; font-weight: 600; color: #1e293b;"><?php _e('Seite veröffentlichen', 'psycho-wizard'); ?></h4>
            </div>
            <p style="color: #64748b; margin-bottom: 15px; padding-left: 44px;">
                <?php _e('Veröffentliche abschließend die Seite, um alle Änderungen zu speichern.', 'psycho-wizard'); ?>
            </p>
            <img src="<?php echo esc_url(PSYCHO_WIZARD_URL . 'assets/images/team overview Publish.png'); ?>" alt="<?php esc_attr_e('Team Overview veröffentlichen', 'psycho-wizard'); ?>" style="max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-left: 44px;">
        </div>

        <h4 style="font-size: 18px; margin: 30px 0 15px 0; color: #10b981; font-weight: 600;"><?php _e('2. Bedingung festlegen', 'psycho-wizard'); ?></h4>

        <!-- Condition Steps -->
        <div style="margin-bottom: 30px;">
            <p style="color: #64748b; margin-bottom: 15px;">
                <?php _e('Klicke in der Archiv-Übersicht bei der Team Overview auf <strong>"Bedingungen bearbeiten"</strong>.', 'psycho-wizard'); ?>
            </p>
            <img src="<?php echo esc_url(PSYCHO_WIZARD_URL . 'assets/images/edit_condition_team_archive.png'); ?>" alt="<?php esc_attr_e('Bedingungen bearbeiten Team Archiv', 'psycho-wizard'); ?>" style="max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 20px;">

            <p style="color: #64748b; margin-bottom: 15px;">
                <?php _e('Klicke auf <strong>"Bedingung hinzufügen"</strong> und wähle das <strong>Team-Archiv</strong> aus. Vergiss nicht zu speichern!', 'psycho-wizard'); ?>
            </p>
            <img src="<?php echo esc_url(PSYCHO_WIZARD_URL . 'assets/images/condition_team_archive.png'); ?>" alt="<?php esc_attr_e('Bedingung Team Archiv', 'psycho-wizard'); ?>" style="max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        </div>

        <div class="info-box" style="background: #dbeafe; border-color: #3b82f6;">
            <div class="info-box-title" style="color: #1e40af;"><?php _e('💡 Hinweis für Solo-Therapeuten', 'psycho-wizard'); ?></div>
            <div class="info-box-content" style="color: #1e40af;">
                <?php _e('<strong>Team-Mitglieder werden nur angezeigt, wenn du sie erstellt hast.</strong> Nach dem Import des Kits sind noch keine Team-Mitglieder vorhanden.<br><br><strong>Solo-Therapeut?</strong> Wenn du alleine arbeitest, erstelle ein Team-Mitglied für dich selbst und verlinke diese Seite im Menü als "Über mich" statt "Team".', 'psycho-wizard'); ?>
            </div>
        </div>
    </div>

    <!-- Section 5: Seiten verwalten -->
    <div style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 30px; margin-bottom: 30px;">
        <h3 style="font-size: 20px; margin-bottom: 20px; color: #1e293b;"><?php _e('🗑️ Teil 5: Nicht benötigte Seiten verwalten', 'psycho-wizard'); ?></h3>

        <div style="margin-bottom: 20px;">
            <p style="color: #64748b; margin-bottom: 15px;">
                <?php _e('Wenn du bestimmte Seiten nicht brauchst (z.B. Team-Seite als Solo-Therapeut), solltest du:', 'psycho-wizard'); ?>
            </p>

            <ol style="color: #64748b; padding-left: 20px; margin-bottom: 20px;">
                <li style="margin-bottom: 10px;"><?php _e('Das Template aus den <strong>Conditions</strong> im Theme Builder löschen', 'psycho-wizard'); ?></li>
                <li style="margin-bottom: 10px;"><?php _e('Die Seite auf <strong>"Entwurf"</strong> stellen (sie sollte nicht veröffentlicht sein)', 'psycho-wizard'); ?></li>
                <li style="margin-bottom: 10px;"><?php _e('Die Seite aus dem Menü entfernen (das machen wir im nächsten Step)', 'psycho-wizard'); ?></li>
            </ol>

            <h4 style="font-size: 16px; font-weight: 600; margin-bottom: 10px; color: #1e293b;"><?php _e('So stellst du eine Seite auf Entwurf:', 'psycho-wizard'); ?></h4>
            <p style="color: #64748b; margin-bottom: 15px;">
                <?php _e('Gehe zu <strong>Seiten → Alle Seiten</strong>, wähle z.B. "Team" aus und klicke auf <strong>"Schnellbearbeitung"</strong>. Bei Status wählst du <strong>"Entwurf"</strong> aus und klickst auf <strong>"Aktualisieren"</strong>.', 'psycho-wizard'); ?>
            </p>
            <img src="<?php echo esc_url(PSYCHO_WIZARD_URL . 'assets/images/Manage Unneeded pages.png'); ?>" alt="<?php esc_attr_e('Seiten Status ändern', 'psycho-wizard'); ?>" style="max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        </div>

        <div class="info-box" style="background: #fef3c7; border-color: #f59e0b; margin-top: 20px;">
            <div class="info-box-title" style="color: #92400e;"><?php _e('💡 Tipp', 'psycho-wizard'); ?></div>
            <div class="info-box-content" style="color: #92400e;">
                <?php _e('Das gleiche gilt für alle anderen Seiten, die du nicht brauchst. Im nächsten Step werden wir die Menüpunkte anpassen.', 'psycho-wizard'); ?>
            </div>
        </div>
    </div>

    <!-- Fertig Button -->
    <div style="margin-top: 30px;">
        <button type="button" class="btn btn-primary" onclick="markTemplatesCompleted()">
            <?php _e('✅ Templates zugewiesen - Weiter', 'psycho-wizard'); ?>
        </button>
    </div>

</div>

<script>
jQuery(document).ready(function($) {
    // Prüfe ob bereits zugewiesen
    <?php if ($is_assigned): ?>
        if (typeof window.markStepCompleted === 'function') {
            window.markStepCompleted(11);
        }
        if (typeof window.updateButtons === 'function') {
            window.updateButtons();
        }
    <?php endif; ?>
});

function markTemplatesCompleted() {
    const $btn = jQuery('button[onclick="markTemplatesCompleted()"]');
    $btn.prop('disabled', true).text(<?php echo json_encode(__('✅ Speichere...', 'psycho-wizard')); ?>);

    jQuery.ajax({
        url: psychoWizard.ajaxUrl,
        type: 'POST',
        data: {
            action: 'psycho_mark_templates_assigned',
            nonce: psychoWizard.nonce
        },
        success: function(response) {
            if (response.success) {
                window.markStepCompleted(11);
                // Update progress bubble immediately
                jQuery(`.step[data-step="11"]`).addClass('completed');
                showNotification('success', <?php echo json_encode(__('Templates wurden als zugewiesen markiert!', 'psycho-wizard')); ?>);

                // Gehe zum nächsten Step und scrolle nach oben
                setTimeout(function() {
                    window.nextStep();
                    // Scroll to top of page
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }, 500);
            } else {
                $btn.prop('disabled', false).text(<?php echo json_encode(__('✅ Templates zugewiesen - Weiter', 'psycho-wizard')); ?>);
                showNotification('error', response.data.message || <?php echo json_encode(__('Ein Fehler ist aufgetreten', 'psycho-wizard')); ?>);
            }
        },
        error: function() {
            $btn.prop('disabled', false).text(<?php echo json_encode(__('✅ Templates zugewiesen - Weiter', 'psycho-wizard')); ?>);
            showNotification('error', <?php echo json_encode(__('Ein Fehler ist aufgetreten. Bitte versuche es erneut.', 'psycho-wizard')); ?>);
        }
    });
}
</script>
