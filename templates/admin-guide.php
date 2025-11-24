<?php
/**
 * Benutzer-Anleitung Admin Page
 */
if (!defined('ABSPATH')) {
    exit;
}

// Lade Markdown-Datei basierend auf Sprache
$locale = get_locale();
$is_german = (strpos($locale, 'de') === 0); // de_DE, de_DE_formal, de_CH, etc.

if ($is_german) {
    $guide_file = PSYCHO_WIZARD_PATH . 'BENUTZER-ANLEITUNG.md';
} else {
    // Englisch als Fallback
    $guide_file = PSYCHO_WIZARD_PATH . 'USER-GUIDE.md';

    // Falls englische Datei nicht existiert, nehme deutsche als Fallback
    if (!file_exists($guide_file)) {
        $guide_file = PSYCHO_WIZARD_PATH . 'BENUTZER-ANLEITUNG.md';
    }
}

$guide_content = file_exists($guide_file) ? file_get_contents($guide_file) : '';

// Einfache Markdown zu HTML Konvertierung für bessere Lesbarkeit
function simple_markdown_to_html($markdown) {
    // Headers
    $html = preg_replace('/^# (.+)$/m', '<h1>$1</h1>', $markdown);
    $html = preg_replace('/^## (.+)$/m', '<h2>$1</h2>', $html);
    $html = preg_replace('/^### (.+)$/m', '<h3>$1</h3>', $html);
    $html = preg_replace('/^#### (.+)$/m', '<h4>$1</h4>', $html);

    // Bold
    $html = preg_replace('/\*\*(.+?)\*\*/s', '<strong>$1</strong>', $html);

    // Italic
    $html = preg_replace('/\*(.+?)\*/s', '<em>$1</em>', $html);

    // Code blocks
    $html = preg_replace('/```(.+?)```/s', '<pre><code>$1</code></pre>', $html);
    $html = preg_replace('/`(.+?)`/', '<code>$1</code>', $html);

    // Lists
    $html = preg_replace('/^- (.+)$/m', '<li>$1</li>', $html);
    $html = preg_replace('/(<li>.*<\/li>\n?)+/s', '<ul>$0</ul>', $html);

    // Links
    $html = preg_replace('/\[(.+?)\]\((.+?)\)/', '<a href="$2">$1</a>', $html);

    // Line breaks
    $html = preg_replace('/\n\n/', '</p><p>', $html);
    $html = '<p>' . $html . '</p>';

    // Cleanup
    $html = str_replace('<p><h', '<h', $html);
    $html = str_replace('</h1></p>', '</h1>', $html);
    $html = str_replace('</h2></p>', '</h2>', $html);
    $html = str_replace('</h3></p>', '</h3>', $html);
    $html = str_replace('</h4></p>', '</h4>', $html);
    $html = str_replace('<p><ul>', '<ul>', $html);
    $html = str_replace('</ul></p>', '</ul>', $html);
    $html = str_replace('<p><pre>', '<pre>', $html);
    $html = str_replace('</pre></p>', '</pre>', $html);
    $html = str_replace('<p></p>', '', $html);

    return $html;
}

$guide_html = simple_markdown_to_html($guide_content);
?>

<div class="wrap psycho-guide-page">
    <style>
        .psycho-guide-page {
            max-width: 1200px;
            margin: 20px 0;
        }
        .psycho-guide-header {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .psycho-guide-header h1 {
            margin: 0 0 10px 0;
            font-size: 32px;
            color: #2F6D67;
        }
        .psycho-guide-header p {
            margin: 0;
            font-size: 16px;
            color: #666;
        }
        .psycho-guide-content {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            line-height: 1.8;
        }
        .psycho-guide-content h1 {
            color: #2F6D67;
            font-size: 28px;
            margin-top: 40px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #2F6D67;
        }
        .psycho-guide-content h2 {
            color: #2F6D67;
            font-size: 24px;
            margin-top: 35px;
            margin-bottom: 15px;
        }
        .psycho-guide-content h3 {
            color: #333;
            font-size: 20px;
            margin-top: 25px;
            margin-bottom: 12px;
        }
        .psycho-guide-content h4 {
            color: #555;
            font-size: 18px;
            margin-top: 20px;
            margin-bottom: 10px;
        }
        .psycho-guide-content p {
            margin: 15px 0;
            color: #333;
            font-size: 15px;
        }
        .psycho-guide-content ul {
            margin: 15px 0;
            padding-left: 30px;
        }
        .psycho-guide-content li {
            margin: 8px 0;
            color: #333;
            font-size: 15px;
        }
        .psycho-guide-content code {
            background: #f5f5f5;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            color: #d63384;
        }
        .psycho-guide-content pre {
            background: #f5f5f5;
            padding: 20px;
            border-radius: 5px;
            overflow-x: auto;
            margin: 20px 0;
        }
        .psycho-guide-content pre code {
            background: none;
            padding: 0;
            color: #333;
        }
        .psycho-guide-content strong {
            color: #2F6D67;
            font-weight: 600;
        }
        .psycho-guide-actions {
            background: #f0f9f8;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            gap: 15px;
            align-items: center;
        }
        .psycho-guide-actions .button {
            margin: 0;
        }
        .psycho-quick-nav {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .psycho-quick-nav h3 {
            margin-top: 0;
            color: #2F6D67;
        }
        .psycho-quick-nav a {
            display: inline-block;
            padding: 8px 15px;
            margin: 5px 5px 5px 0;
            background: #f0f9f8;
            color: #2F6D67;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.2s;
        }
        .psycho-quick-nav a:hover {
            background: #2F6D67;
            color: white;
        }
        .toc-link {
            scroll-margin-top: 100px;
        }
    </style>

    <div class="psycho-guide-header">
        <h1>📖 <?php echo $is_german ? 'Psychotherapie Setup Wizard - Benutzer-Anleitung' : 'Psychotherapy Setup Wizard - User Guide'; ?></h1>
        <p><?php echo $is_german ? 'Vollständige Anleitung für den erfolgreichen Setup Ihrer Psychotherapie-Website' : 'Complete guide for successfully setting up your psychotherapy website'; ?></p>
    </div>

    <div class="psycho-guide-actions">
        <a href="<?php echo admin_url('admin.php?page=psycho-wizard'); ?>" class="button button-primary button-large">
            <?php echo $is_german ? '← Zurück zum Setup Wizard' : '← Back to Setup Wizard'; ?>
        </a>
        <a href="<?php echo PSYCHO_WIZARD_URL . basename($guide_file); ?>" class="button button-secondary" download>
            <?php echo $is_german ? '📥 Anleitung als Markdown herunterladen' : '📥 Download Guide as Markdown'; ?>
        </a>
        <span style="margin-left: auto; color: #666;">Version 1.0 | <?php echo date('Y'); ?></span>
    </div>

    <div class="psycho-quick-nav" id="quickNavContainer">
        <h3>⚡ <?php echo $is_german ? 'Schnellnavigation' : 'Quick Navigation'; ?></h3>
        <div id="quickNavLinks">
            <!-- Wird dynamisch via JavaScript generiert -->
        </div>
    </div>

    <div class="psycho-guide-content">
        <?php if ($guide_content): ?>
            <?php echo $guide_html; ?>
        <?php else: ?>
            <div style="padding: 40px; text-align: center; color: #999;">
                <p style="font-size: 18px;">❌ Anleitung konnte nicht geladen werden.</p>
                <p>Die Datei <code>BENUTZER-ANLEITUNG.md</code> wurde nicht gefunden.</p>
            </div>
        <?php endif; ?>
    </div>

    <div class="psycho-guide-actions" style="margin-top: 30px;">
        <a href="<?php echo admin_url('admin.php?page=psycho-wizard'); ?>" class="button button-primary button-large">
            <?php echo $is_german ? '← Zurück zum Setup Wizard' : '← Back to Setup Wizard'; ?>
        </a>
        <a href="#top" class="button button-secondary">
            <?php echo $is_german ? '↑ Nach oben' : '↑ Back to Top'; ?>
        </a>
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    console.log('Admin Guide: Initializing...');

    // Funktion um saubere IDs aus Text zu generieren
    function generateId(text) {
        return text.toLowerCase()
            .trim()
            // Entferne Emojis und Sonderzeichen
            .replace(/[\u{1F300}-\u{1F9FF}]/gu, '') // Emojis
            .replace(/[^a-z0-9äöüß\s-]/g, '') // Nur Buchstaben, Zahlen, Umlaute
            .replace(/\s+/g, '-') // Leerzeichen zu Bindestrichen
            .replace(/-+/g, '-') // Multiple Bindestriche zu einem
            .replace(/^-|-$/g, ''); // Bindestriche am Anfang/Ende entfernen
    }

    // IDs zu ALLEN Überschriften hinzufügen (H1 und H2)
    var headings = [];
    $('.psycho-guide-content h1, .psycho-guide-content h2').each(function() {
        var $heading = $(this);
        var text = $heading.text();
        var id = generateId(text);

        // Füge ID hinzu
        $heading.attr('id', id).addClass('toc-link');

        // Speichere für Quick Nav (nur erste 6-8 wichtige)
        if (headings.length < 8) {
            headings.push({
                text: text,
                id: id,
                level: this.tagName
            });
        }

        console.log('Created anchor:', id, 'for heading:', text);
    });

    // Generiere Quick Navigation dynamisch
    var $quickNav = $('#quickNavLinks');
    headings.forEach(function(heading) {
        var $link = $('<a>')
            .attr('href', '#' + heading.id)
            .text(heading.text)
            .css('font-weight', heading.level === 'H1' ? '600' : '400');
        $quickNav.append($link);
    });

    console.log('Quick Nav: Created', headings.length, 'links');

    // Smooth Scrolling für Anchor Links
    $(document).on('click', 'a[href^="#"]', function(e) {
        var hash = this.hash;

        // Skip empty hashes
        if (!hash || hash === '#') return;

        var $target = $(hash);

        if ($target.length) {
            e.preventDefault();

            console.log('Scrolling to:', hash);

            $('html, body').animate({
                scrollTop: $target.offset().top - 100
            }, 500, function() {
                // Update URL hash ohne zu scrollen
                if (history.pushState) {
                    history.pushState(null, null, hash);
                }
            });
        } else {
            console.warn('Target not found for hash:', hash);
        }
    });

    // Wenn Seite mit Hash geladen wird, scroll dorthin
    if (window.location.hash) {
        setTimeout(function() {
            var $target = $(window.location.hash);
            if ($target.length) {
                $('html, body').animate({
                    scrollTop: $target.offset().top - 100
                }, 500);
            }
        }, 300);
    }

    console.log('Admin Guide: Initialization complete');
});
</script>
