<?php
/**
 * Waiting Badge Admin Options Page
 *
 * @package PsychoWizard
 * @subpackage Templates
 *
 * WordPress Functions Used:
 * @uses get_option()
 * @uses update_option()
 * @uses check_admin_referer()
 * @uses wp_nonce_field()
 * @uses wp_nonce_url()
 * @uses sanitize_text_field()
 * @uses absint()
 * @uses admin_url()
 * @uses esc_attr()
 * @uses esc_html()
 * @uses esc_js()
 * @uses checked()
 * @uses selected()
 * @uses current_time()
 *
 * @global wpdb $wpdb WordPress database abstraction object
 */

// Security check
if (!defined('ABSPATH')) {
    exit;
}

// Hole aktuelle Settings
$enabled = get_option('psycho_waiting_badge_enabled', false);
$heading = get_option('psycho_waiting_badge_heading', 'Waiting time');
$time = get_option('psycho_waiting_badge_time', '8-10 weeks');
$position = get_option('psycho_waiting_badge_position', 'bottom-left');
$cookie_days = get_option('psycho_waiting_badge_cookie_days', 30);

// Handle Form Submission
if (isset($_POST['psycho_waiting_badge_submit']) && check_admin_referer('psycho_waiting_badge_settings', 'psycho_waiting_badge_nonce')) {
    // Update Options
    update_option('psycho_waiting_badge_enabled', isset($_POST['psycho_waiting_badge_enabled']));
    update_option('psycho_waiting_badge_heading', sanitize_text_field($_POST['psycho_waiting_badge_heading']));
    update_option('psycho_waiting_badge_time', sanitize_text_field($_POST['psycho_waiting_badge_time']));
    update_option('psycho_waiting_badge_position', sanitize_text_field($_POST['psycho_waiting_badge_position']));
    update_option('psycho_waiting_badge_cookie_days', absint($_POST['psycho_waiting_badge_cookie_days']));

    // Reload Settings
    $enabled = get_option('psycho_waiting_badge_enabled', false);
    $heading = get_option('psycho_waiting_badge_heading', 'Waiting time');
    $time = get_option('psycho_waiting_badge_time', '8-10 weeks');
    $position = get_option('psycho_waiting_badge_position', 'bottom-left');
    $cookie_days = get_option('psycho_waiting_badge_cookie_days', 30);

    echo '<div class="notice notice-success is-dismissible"><p><strong>' . __('✅ Settings saved!', 'psycho-wizard') . '</strong></p></div>';
}
?>

<div class="wrap psycho-waiting-badge-settings">
    <style>
        .psycho-waiting-badge-settings {
            max-width: 1000px;
        }
        .settings-header {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin: 20px 0 30px 0;
        }
        .settings-header h1 {
            margin: 0 0 10px 0;
            color: #2F6D67;
            font-size: 32px;
        }
        .settings-header p {
            margin: 0;
            color: #666;
            font-size: 16px;
        }
        .settings-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .setting-row {
            margin-bottom: 25px;
            padding-bottom: 25px;
            border-bottom: 1px solid #e5e5e5;
        }
        .setting-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
            margin-bottom: 0;
        }
        .setting-label {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }
        .setting-description {
            color: #666;
            font-size: 14px;
            margin-bottom: 12px;
        }
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }
        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        input:checked + .toggle-slider {
            background-color: #2F6D67;
        }
        input:checked + .toggle-slider:before {
            transform: translateX(26px);
        }
        .text-input {
            width: 100%;
            max-width: 500px;
            padding: 10px 15px;
            font-size: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: border-color 0.2s;
        }
        .text-input:focus {
            outline: none;
            border-color: #2F6D67;
        }
        .select-input {
            width: 100%;
            max-width: 300px;
            padding: 10px 15px;
            font-size: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .info-box {
            background: #f0f9f8;
            border-left: 4px solid #2F6D67;
            padding: 15px 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .info-box h3 {
            margin: 0 0 10px 0;
            color: #2F6D67;
            font-size: 16px;
        }
        .info-box p {
            margin: 5px 0;
            color: #555;
            font-size: 14px;
        }
        .info-box code {
            background: white;
            padding: 2px 8px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            color: #d63384;
        }
        .shortcode-box {
            background: #f5f5f5;
            padding: 12px 15px;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            color: #d63384;
            font-size: 14px;
            display: inline-block;
            margin: 5px 5px 5px 0;
        }
        .save-button {
            background: #2F6D67;
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.2s;
        }
        .save-button:hover {
            background: #265950;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            margin-left: 15px;
        }
        .status-active {
            background: #d1fae5;
            color: #065f46;
        }
        .status-inactive {
            background: #fee2e2;
            color: #991b1b;
        }
    </style>

    <div class="settings-header">
        <h1><?php _e('⏱️ Waiting Badge Settings', 'psycho-wizard'); ?></h1>
        <p><?php _e('Manage your Waiting Time Badge - fully integrated with Elementor', 'psycho-wizard'); ?></p>
    </div>

    <form method="post" action="">
        <?php wp_nonce_field('psycho_waiting_badge_settings', 'psycho_waiting_badge_nonce'); ?>

        <div class="settings-container">
            <!-- Badge Aktivierung -->
            <div class="setting-row">
                <label class="setting-label">
                    <?php _e('Badge Status', 'psycho-wizard'); ?>
                    <?php if ($enabled): ?>
                        <span class="status-badge status-active"><?php _e('✅ Active', 'psycho-wizard'); ?></span>
                    <?php else: ?>
                        <span class="status-badge status-inactive"><?php _e('⭕ Inactive', 'psycho-wizard'); ?></span>
                    <?php endif; ?>
                </label>
                <p class="setting-description">
                    <?php _e('Enable or disable the Waiting Badge on your website.', 'psycho-wizard'); ?>
                </p>
                <label class="toggle-switch">
                    <input type="checkbox" name="psycho_waiting_badge_enabled" <?php checked($enabled); ?>>
                    <span class="toggle-slider"></span>
                </label>
            </div>

            <!-- Überschrift Text -->
            <div class="setting-row">
                <label class="setting-label" for="psycho_waiting_badge_heading">
                    <?php _e('Heading', 'psycho-wizard'); ?>
                </label>
                <p class="setting-description">
                    <?php _e('The main text of the badge (e.g. "Waiting time", "Availability")', 'psycho-wizard'); ?>
                </p>
                <input type="text"
                       id="psycho_waiting_badge_heading"
                       name="psycho_waiting_badge_heading"
                       value="<?php echo esc_attr($heading); ?>"
                       class="text-input"
                       placeholder="Waiting time">
            </div>

            <!-- Zeitangabe Text -->
            <div class="setting-row">
                <label class="setting-label" for="psycho_waiting_badge_time">
                    <?php _e('Time Period', 'psycho-wizard'); ?>
                </label>
                <p class="setting-description">
                    <?php _e('The waiting time or availability (e.g. "8-10 weeks", "Available now")', 'psycho-wizard'); ?>
                </p>
                <input type="text"
                       id="psycho_waiting_badge_time"
                       name="psycho_waiting_badge_time"
                       value="<?php echo esc_attr($time); ?>"
                       class="text-input"
                       placeholder="8-10 weeks">
            </div>

            <!-- Position -->
            <div class="setting-row">
                <label class="setting-label" for="psycho_waiting_badge_position">
                    <?php _e('Position', 'psycho-wizard'); ?>
                </label>
                <p class="setting-description">
                    <?php _e('Where should the badge be displayed on the page?', 'psycho-wizard'); ?>
                </p>
                <select id="psycho_waiting_badge_position"
                        name="psycho_waiting_badge_position"
                        class="select-input">
                    <option value="bottom-left" <?php selected($position, 'bottom-left'); ?>>
                        <?php _e('Bottom Left', 'psycho-wizard'); ?>
                    </option>
                    <option value="bottom-right" <?php selected($position, 'bottom-right'); ?>>
                        <?php _e('Bottom Right', 'psycho-wizard'); ?>
                    </option>
                </select>
            </div>

            <!-- Cookie Dauer -->
            <div class="setting-row">
                <label class="setting-label" for="psycho_waiting_badge_cookie_days">
                    <?php _e('Cookie Duration (Days)', 'psycho-wizard'); ?>
                </label>
                <p class="setting-description">
                    <?php _e('How many days should the badge remain hidden after being closed?', 'psycho-wizard'); ?>
                </p>
                <input type="number"
                       id="psycho_waiting_badge_cookie_days"
                       name="psycho_waiting_badge_cookie_days"
                       value="<?php echo esc_attr($cookie_days); ?>"
                       class="text-input"
                       min="1"
                       max="365"
                       style="max-width: 150px;">
            </div>
        </div>

        <!-- Elementor Integration Anleitung -->
        <div class="info-box">
            <h3><?php _e('📖 Elementor Integration', 'psycho-wizard'); ?></h3>
            <p><strong><?php _e('How to use the shortcodes in your Elementor widgets:', 'psycho-wizard'); ?></strong></p>
            <p>
                <strong><?php _e('1. Heading Widget for heading:', 'psycho-wizard'); ?></strong><br>
                <span class="shortcode-box">[waiting_badge_heading]</span>
                <span style="color: #666;"><?php printf(__('→ Shows: "%s"', 'psycho-wizard'), esc_html($heading)); ?></span>
            </p>
            <p>
                <strong><?php _e('2. Heading Widget for time period:', 'psycho-wizard'); ?></strong><br>
                <span class="shortcode-box">[waiting_badge_time]</span>
                <span style="color: #666;"><?php printf(__('→ Shows: "%s"', 'psycho-wizard'), esc_html($time)); ?></span>
            </p>
            <p>
                <strong><?php _e('3. Add CSS class to Container/Section:', 'psycho-wizard'); ?></strong><br>
                <code>waiting-badge-container</code>
            </p>
            <p>
                <strong><?php _e('4. Icon Widget (Close Button) CSS class:', 'psycho-wizard'); ?></strong><br>
                <code>waiting-badge-close</code>
            </p>
            <p style="margin-top: 15px; color: #2F6D67; font-weight: 600;">
                <?php _e('✨ Colors are automatically inherited from your Elementor Global Colors!', 'psycho-wizard'); ?>
            </p>
        </div>

        <!-- Save Button -->
        <p class="submit">
            <button type="submit" name="psycho_waiting_badge_submit" class="save-button">
                <?php _e('💾 Save Settings', 'psycho-wizard'); ?>
            </button>
        </p>
    </form>

    <!-- Export/Import Section -->
    <div class="info-box" style="margin-top: 30px;">
        <h3><?php _e('📦 Export / Import', 'psycho-wizard'); ?></h3>
        <p><?php _e('Export your badge settings as JSON file for template kits or import settings from another site.', 'psycho-wizard'); ?></p>

        <div style="display: flex; gap: 20px; margin-top: 20px; flex-wrap: wrap;">
            <!-- Export -->
            <div style="flex: 1; min-width: 300px;">
                <h4 style="margin-top: 0; color: #2F6D67;"><?php _e('⬇️ Export', 'psycho-wizard'); ?></h4>
                <p style="color: #666; font-size: 14px;">
                    <?php _e('Download your current badge settings as JSON file.', 'psycho-wizard'); ?>
                </p>
                <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=psycho-waiting-badge&psycho_badge_export=1'), 'psycho_badge_export'); ?>"
                   class="button button-secondary"
                   style="margin-top: 10px;">
                    <?php _e('📥 Export Settings (JSON)', 'psycho-wizard'); ?>
                </a>
            </div>

            <!-- Import -->
            <div style="flex: 1; min-width: 300px;">
                <h4 style="margin-top: 0; color: #2F6D67;"><?php _e('⬆️ Import', 'psycho-wizard'); ?></h4>
                <p style="color: #666; font-size: 14px;">
                    <?php _e('Import badge settings from a JSON file.', 'psycho-wizard'); ?>
                </p>
                <form method="post" enctype="multipart/form-data" style="margin-top: 10px;">
                    <?php wp_nonce_field('psycho_badge_import', 'psycho_badge_import_nonce'); ?>
                    <input type="file" name="psycho_badge_import_file" accept=".json" style="margin-bottom: 10px;">
                    <br>
                    <button type="submit" name="psycho_badge_import" class="button button-secondary">
                        <?php _e('📤 Import Settings', 'psycho-wizard'); ?>
                    </button>
                </form>
            </div>
        </div>

        <!-- JSON Preview (Optional) -->
        <details style="margin-top: 20px;">
            <summary style="cursor: pointer; color: #2F6D67; font-weight: 600;"><?php _e('🔍 JSON Structure Preview', 'psycho-wizard'); ?></summary>
            <pre style="background: #f5f5f5; padding: 15px; border-radius: 5px; overflow-x: auto; margin-top: 10px; font-size: 13px;">{
  "version": "1.5.0",
  "exported_at": "2025-01-19 10:30:00",
  "site_url": "https://ihre-site.de",
  "settings": {
    "enabled": true,
    "heading": "Waiting time",
    "time": "8-10 weeks",
    "position": "bottom-left",
    "cookie_days": 30
  }
}</pre>
        </details>
    </div>
</div>
