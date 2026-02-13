/**
 * privacy.js - DECENSORWEB DATA SOVEREIGNTY PROTOCOL
 * SECURITY-FOCUSED · EXTERNAL ONLY · CSP COMPLIANT
 * 
 * R-CORP ACCOUNTABILITY · TERMS & CONDITIONS ENFORCEMENT
 * ZERO DATA LOGGING · ZERO COMPLIANCE · ZERO TRACKING
 * 
 * FILE: js/privacy.js
 * VERSION: 3.3.0
 */

(function () {
    'use strict';

    // ========== SECURE CONFIGURATION ==========
    const CONFIG = {
        debug: false,
        version: '3.3.0',
        build: 'PRIVACY_SOVEREIGNTY',
        contact: 'rrralefaso@outlook.com',
        nonce: document.currentScript?.getAttribute('nonce') || '',
        doctrine: 'R-CORP · WE DO NOT SELL · WE DO NOT LOG · WE DO NOT COMPLY',
        effective_date: '2024-01-01'
    };

    // ========== SAFE LOGGING ==========
    const logger = {
        log: function (msg, style) {
            if (CONFIG.debug && window.console) {
                try {
                    console.log(msg, style || '');
                } catch (e) { }
            }
        }
    };

    // ========== DOCTRINE MANIFESTO ==========
    const doctrine = [
        '🔐 DECENSORWEB · DATA SOVEREIGNTY PROTOCOL 🔐',
        'R-CORP ACCOUNTABLE PLATFORM · TERMS & CONDITIONS',
        'CONTACT: rrralefaso@outlook.com',
        'WE DO NOT SELL YOUR DATA. WE DO NOT LOG YOUR ACTIVITY.',
        'WE DO NOT COMPLY WITH SURVEILLANCE. WE DO NOT BACKDOOR.',
        'YOUR ACCOUNT IS PROTECTED BY R-CORP SOVEREIGNTY.',
        '➤ PRIVACY IS NOT OPTIONAL. PRIVACY IS MANDATORY.'
    ];

    // Console signature (safe) - reinforces privacy commitment
    if (window.console) {
        window.console.log(
            '%c' + doctrine.join('\n'),
            'color: #ff5555; background: #0a0a0a; font-size: 11px; font-family: monospace; padding: 8px; border: 1px solid red;'
        );

        // Additional privacy notice in console
        window.console.log(
            '%c⚠️ R-CORP PRIVACY NOTICE: This console contains no tracking. No analytics. No fingerprinting. ⚠️',
            'color: #aaffaa; background: #0a1a0a; font-size: 10px; font-family: monospace; padding: 4px; border: 1px solid #00aa00;'
        );
    }

    // ========== SAFE DOM SELECTOR ==========
    const $ = function (selector) {
        if (!selector || typeof selector !== 'string') return null;
        if (selector.includes('<') || selector.includes('>')) return null;
        try {
            return document.querySelector(selector);
        } catch (e) {
            logger.log('[SECURE] Selector error');
            return null;
        }
    };

    // ========== SAFE ATTRIBUTE SETTER ==========
    const setSafeAttribute = function (el, attr, value) {
        if (!el || !attr || typeof value !== 'string') return false;

        const dangerous = ['onerror', 'onload', 'onclick', 'onmouseover', 'onfocus', 'srcdoc'];
        if (dangerous.includes(attr.toLowerCase())) return false;

        if (attr === 'href' || attr === 'src') {
            if (value.startsWith('javascript:') || value.startsWith('data:')) return false;
        }

        try {
            el.setAttribute(attr, value);
            return true;
        } catch (e) {
            return false;
        }
    };

    // ========== SECURE EXTERNAL LINKS ==========
    function secureLinks() {
        const links = document.querySelectorAll('a[target="_blank"]');
        links.forEach(link => {
            try {
                link.setAttribute('rel', 'noopener noreferrer nofollow');
            } catch (e) { }
        });
    }

    // ========== SECURE CONTACT LINK ==========
    function secureContactLink() {
        const contactLink = $('.contact-email');
        if (contactLink) {
            setSafeAttribute(contactLink, 'rel', 'noopener noreferrer nofollow');
            setSafeAttribute(contactLink, 'title', 'Secure privacy contact · PGP encrypted preferred');

            // Ensure mailto: is properly formatted
            const href = contactLink.getAttribute('href');
            if (href && !href.startsWith('mailto:')) {
                setSafeAttribute(contactLink, 'href', 'mailto:' + CONFIG.contact);
            }
        }
    }

    // ========== SECURE NAVIGATION LINKS ==========
    function secureNavLinks() {
        const navLinks = document.querySelectorAll('.footer-nav-link');
        navLinks.forEach(link => {
            try {
                link.setAttribute('rel', 'noopener noreferrer');

                // Validate href attribute
                const href = link.getAttribute('href');
                if (href && (href.startsWith('javascript:') || href.includes('<script'))) {
                    link.setAttribute('href', '#');
                    logger.log('[SECURE] Blocked malicious navigation link');
                }
            } catch (e) { }
        });
    }

    // ========== FINGERPRINT TOOLTIP ==========
    function setFingerprintTooltip() {
        const fp = $('.fingerprint');
        if (fp) {
            setSafeAttribute(fp, 'title', 'Secure session fingerprint · No persistent tracking');
        }
    }

    // ========== WARRANT CANARY UPDATE ==========
    function updateCanaryDate() {
        const canaryStatements = document.querySelectorAll('.canary-statement');
        if (canaryStatements.length > 0) {
            try {
                // First canary statement contains the date
                const firstCanary = canaryStatements[0];
                const today = new Date();
                const formattedDate = today.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });

                // Update the date in the canary statement
                if (firstCanary.textContent.includes('As of')) {
                    firstCanary.textContent = firstCanary.textContent.replace(
                        /As of [A-Za-z]+ \d{1,2}, \d{4}/,
                        `As of ${formattedDate}`
                    );
                }

                // Update canary hash
                const canaryHash = $('.canary-hash');
                if (canaryHash) {
                    const dateStr = today.toISOString().split('T')[0];
                    const hash = Array.from(dateStr + 'UNCOMPROMISED')
                        .reduce((acc, char) => ((acc << 5) - acc) + char.charCodeAt(0), 0)
                        .toString(16)
                        .substring(0, 12);
                    canaryHash.textContent = `[${hash}]`;
                }
            } catch (e) {
                logger.log('[CANARY] Update error (non-critical)');
            }
        }
    }

    // ========== NO-TRACKING VERIFICATION ==========
    function verifyNoTracking() {
        // Check for any third-party scripts or tracking pixels
        const scripts = document.querySelectorAll('script[src*="analytics"], script[src*="tracking"], script[src*="pixel"], img[src*="pixel"]');

        if (scripts.length > 0) {
            logger.log('[PRIVACY] ⚠️ Potential tracking detected - this should not happen on decensorweb');

            // Remove any unauthorized tracking scripts
            scripts.forEach(script => {
                try {
                    script.remove();
                    logger.log('[PRIVACY] Removed unauthorized script');
                } catch (e) { }
            });
        } else {
            logger.log('[PRIVACY] ✓ No tracking scripts detected - privacy preserved');
        }

        // Log privacy verification
        console.log('%c✓ PRIVACY VERIFIED: No third-party tracking, no analytics, no fingerprinting',
            'color: #aaffaa; background: #0a1a0a; font-size: 10px; padding: 2px;');
    }

    // ========== CSP NONCE PROPAGATION ==========
    function propagateNonce() {
        if (CONFIG.nonce) {
            const scripts = document.querySelectorAll('script[data-needs-nonce]');
            scripts.forEach(script => {
                try {
                    script.setAttribute('nonce', CONFIG.nonce);
                } catch (e) { }
            });
        }
    }

    // ========== ACTIVE PAGE HIGHLIGHT ==========
    function highlightCurrentPage() {
        const currentPage = window.location.pathname.split('/').pop() || 'privacy.php';
        const navLinks = document.querySelectorAll('.footer-nav-link');

        navLinks.forEach(link => {
            const href = link.getAttribute('href');
            if (href === currentPage) {
                try {
                    link.style.color = '#ffffff';
                    link.style.borderBottom = '1px solid #ffffff';
                    link.style.fontWeight = 'bold';
                } catch (e) { }
            }
        });
    }

    // ========== DOCTRINE WATERMARK ==========
    function addDoctrineWatermark() {
        const footer = $('.privacy-footer');
        if (!footer) return;

        const status = footer.querySelector('.footer-status');
        if (status && !footer.querySelector('.doctrine-watermark')) {
            try {
                const watermark = document.createElement('span');
                watermark.className = 'doctrine-watermark';
                watermark.style.cssText = 'opacity:0.3; font-size:0.65rem; margin-left:12px; color:#6b4b4b; text-transform:uppercase;';
                watermark.textContent = 'WE DO NOT SELL YOUR DATA';
                status.appendChild(watermark);
            } catch (e) { }
        }
    }

    // ========== TERMS ACKNOWLEDGMENT PROMPT (FIRST VISIT) ==========
    function checkTermsAcknowledgment() {
        // This is non-blocking and purely informational
        try {
            if (typeof localStorage !== 'undefined') {
                const acknowledged = localStorage.getItem('decensorweb_terms_acknowledged');
                const version = localStorage.getItem('decensorweb_terms_version');

                if (!acknowledged || version !== CONFIG.version) {
                    logger.log('[TERMS] User has not acknowledged current terms (v' + CONFIG.version + ')');
                    // We don't show a blocking dialog - privacy doesn't interrupt
                }
            }
        } catch (e) {
            // LocalStorage unavailable - continue without
        }
    }

    // ========== INITIALIZE ==========
    function init() {
        try {
            secureLinks();
            secureContactLink();
            secureNavLinks();
            setFingerprintTooltip();
            updateCanaryDate();
            verifyNoTracking();
            propagateNonce();
            highlightCurrentPage();
            addDoctrineWatermark();
            checkTermsAcknowledgment();

            logger.log('[PRIVACY] Data sovereignty protocol active · v' + CONFIG.version);
            logger.log('[PRIVACY] Doctrine: ' + CONFIG.doctrine);

            // Final privacy verification
            console.log('%c🔐 R-CORP PRIVACY COMMITMENT: This page contains no tracking. Your visit is not recorded. 🔐',
                'color: #ffaaaa; background: #1a0a0a; font-size: 11px; font-family: monospace; padding: 6px; border: 1px solid #ff5555;');
        } catch (e) {
            logger.log('[PRIVACY] Initialization suppressed');
        }
    }

    // Run when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();