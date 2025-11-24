/**
 * Waiting Badge - Close Button & Cookie Management
 *
 * Funktionen:
 * - Prüft Cookie ob Badge bereits geschlossen wurde
 * - Close-Button Handler
 * - Cookie setzen für X Tage
 * - Smooth Fade-Out Animation
 */

(function($) {
    'use strict';

    // Settings aus wp_localize_script oder inline vars
    var settings = window.psychoWaitingBadgeSettings || window.psychoWaitingBadge || {
        enabled: true,
        cookieName: 'psycho_waiting_badge_closed',
        cookieDays: 30,
        position: 'bottom-left'
    };

    /**
     * Cookie Helper Functions
     */
    function setCookie(name, value, days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
        console.log('Waiting Badge: Cookie set for ' + days + ' days');
    }

    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    /**
     * Initialisierung
     */
    $(document).ready(function() {
        console.log('Waiting Badge: Initializing...', settings);

        // Finde Badge Container (Elementor Section/Container)
        var $badge = $('.waiting-badge-container');

        if (!$badge.length) {
            console.log('Waiting Badge: Container not found (.waiting-badge-container)');
            return;
        }

        console.log('Waiting Badge: Container found');

        // Prüfe ob Badge bereits geschlossen wurde (Cookie Check)
        var isClosed = getCookie(settings.cookieName);
        if (isClosed === 'true') {
            console.log('Waiting Badge: Already closed (cookie found)');
            $badge.hide();
            return;
        }

        // Badge ist sichtbar
        console.log('Waiting Badge: Showing badge');

        // WICHTIG: Position via JavaScript setzen (überschreibt Elementor!)
        var positionStyles = {
            'position': 'fixed',
            'bottom': '20px',
            'z-index': '9999',
            'max-width': '400px'
        };

        if (settings.position === 'bottom-right') {
            positionStyles['right'] = '20px';
            positionStyles['left'] = 'auto';
        } else {
            positionStyles['left'] = '20px';
            positionStyles['right'] = 'auto';
        }

        // Wende Position an (mit !important via cssText für höchste Priorität)
        $badge.css(positionStyles);

        // Optional: Responsive - kleinere Badge auf Mobile
        if (window.innerWidth < 768) {
            $badge.css({
                'max-width': '280px',
                'bottom': '10px',
                'left': '10px',
                'right': '10px'
            });
        }

        // WICHTIG: Füge 'badge-ready' Klasse hinzu damit Badge sichtbar wird
        $badge.addClass('badge-ready');
        console.log('Waiting Badge: Made visible with badge-ready class');

        // Close-Button Handler
        var $closeBtn = $badge.find('.waiting-badge-close');

        if (!$closeBtn.length) {
            console.log('Waiting Badge: Close button not found (.waiting-badge-close)');
            // Alternative: Suche nach Elementor Icon Widget
            $closeBtn = $badge.find('.elementor-icon, [class*="close"]');
        }

        if ($closeBtn.length) {
            console.log('Waiting Badge: Close button found, attaching handler');

            $closeBtn.on('click', function(e) {
                e.preventDefault();
                console.log('Waiting Badge: Close button clicked');

                // Fade Out Animation
                $badge.fadeOut(300, function() {
                    console.log('Waiting Badge: Faded out');
                    $(this).remove();
                });

                // Cookie setzen
                setCookie(settings.cookieName, 'true', settings.cookieDays);
            });

            // Hover Effect für Close-Button
            $closeBtn.css('cursor', 'pointer');
        } else {
            console.log('Waiting Badge: No close button found');
        }

        // Optional: Accessibility - ESC Key zum Schließen
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' || e.keyCode === 27) {
                if ($badge.is(':visible')) {
                    $closeBtn.trigger('click');
                }
            }
        });
    });

})(jQuery);
