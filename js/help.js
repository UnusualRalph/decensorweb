/**
 * about.js - DECENSORWEB MANIFESTO
 * SECURITY-FOCUSED · EXTERNAL ONLY · CSP COMPLIANT
 * 
 * R-CORP ACCOUNTABILITY ENHANCEMENTS
 * CONTACT: rrralefaso@outlook.com
 * NAVIGATION: RETURNS TO INDEX.HTML
 * NO EVAL · NO INLINE · NO UNSAFE DOM MANIPULATION
 * 
 * FILE: js/about.js
 * VERSION: 3.2.0
 */

(function () {
    'use strict';

    // ========== SECURE CONFIGURATION ==========
    const CONFIG = {
        debug: false,
        doctrine: 'v3.2.0',
        contact: 'rrralefaso@outlook.com',
        nonce: document.currentScript?.getAttribute('nonce') || '',
        indexPage: 'index.html'
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
        '⛧ DECENSORWEB · R-CORP ACCOUNTABLE PLATFORM ⛧',
        'PARENT COMPANY: R-CORP — FULL RESPONSIBILITY FOR ALL ACCOUNTS',
        'CONTACT: rrralefaso@outlook.com',
        'NAVIGATION: RETURNS TO INDEX.HTML',
        'WE DO NOT COMPLY WITH CENSORSHIP ORDERS.',
        'YOUR ACCOUNT IS PROTECTED BY R-CORP SOVEREIGNTY.',
        '➤ MISSION: ANTI-CENSORSHIP. ALWAYS.'
    ];

    // Console signature (safe)
    if (window.console) {
        window.console.log(
            '%c' + doctrine.join('\n'),
            'color: #ff5555; background: #0a0a0a; font-size: 11px; font-family: monospace; padding: 8px; border: 1px solid red;'
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

    // ========== SAFE TEXT CONTENT ==========
    const setText = function (el, text) {
        if (!el || typeof text !== 'string') return false;
        try {
            el.textContent = text;
            return true;
        } catch (e) {
            return false;
        }
    };

    // ========== ENHANCE ACCOUNTABILITY BADGE ==========
    function enhanceAccountability() {
        const shield = $('.rcorp-shield');
        if (shield) {
            setSafeAttribute(shield, 'aria-label', 'R-CORP: Parent company · Full account liability');
            setSafeAttribute(shield, 'data-doctrine', CONFIG.doctrine);
            setSafeAttribute(shield, 'data-contact', CONFIG.contact);
        }
    }

    // ========== SET MISSION MARKER ==========
    function setMissionMarker() {
        const mission = $('.core-mission');
        if (mission) {
            try {
                mission.dataset.antiCensorship = 'active';
                mission.dataset.doctrineVersion = CONFIG.doctrine;
                mission.dataset.contact = CONFIG.contact;
                mission.dataset.navigation = CONFIG.indexPage;
            } catch (e) { }
        }
    }

    // ========== FINGERPRINT TOOLTIP ==========
    function setFingerprintTooltip() {
        const fp = $('.fingerprint');
        if (fp) {
            setSafeAttribute(fp, 'title', 'Secure session fingerprint · R-CORP signed');
        }
    }

    // ========== SECURE CONTACT LINK ==========
    function secureContactLink() {
        const contactLink = $('.contact-link');
        if (contactLink) {
            setSafeAttribute(contactLink, 'rel', 'noopener noreferrer nofollow');
            setSafeAttribute(contactLink, 'title', 'Secure contact · PGP encrypted preferred');
        }
    }

    // ========== SECURE NAVIGATION LINK ==========
    function secureNavLink() {
        const navLink = $('.back-btn');
        if (navLink) {
            setSafeAttribute(navLink, 'rel', 'noopener noreferrer');
            setSafeAttribute(navLink, 'title', 'Return to main terminal · index.html');

            // Ensure href points to index.html
            const currentHref = navLink.getAttribute('href');
            if (currentHref !== CONFIG.indexPage) {
                setSafeAttribute(navLink, 'href', CONFIG.indexPage);
            }
        }
    }

    // ========== SECURE IMAGE FALLBACKS ==========
    function handleImageFallbacks() {
        const images = document.querySelectorAll('.manifesto-icon, .rcorp-logo-image');
        images.forEach(img => {
            if (img.hasAttribute('data-error-handled')) return;

            img.addEventListener('error', function (e) {
                try {
                    this.style.display = 'none';
                    this.setAttribute('data-error-handled', 'true');

                    if (this.classList.contains('manifesto-icon')) {
                        const fallback = this.nextElementSibling;
                        if (fallback?.classList.contains('icon-fallback')) {
                            fallback.style.display = 'flex';
                        }
                    } else if (this.classList.contains('rcorp-logo-image')) {
                        const parent = this.parentElement;
                        if (parent) {
                            parent.classList.add('sigil-fallback');
                            const fallbackSpan = parent.querySelector('.sigil-fallback-text');
                            if (fallbackSpan) fallbackSpan.style.display = 'block';
                        }
                    }
                } catch (err) { }
            }, { once: true });
        });
    }

    // ========== SECURE EXTERNAL LINKS ==========
    function secureLinks() {
        const links = document.querySelectorAll('a[target="_blank"]');
        links.forEach(link => {
            try {
                link.setAttribute('rel', 'noopener noreferrer nofollow');
            } catch (e) { }
        });
    }

    // ========== DOCTRINE WATERMARK ==========
    function addDoctrineWatermark() {
        const footer = $('.footer-nav');
        if (!footer) return;

        const coords = footer.querySelector('.map-coordinates');
        if (coords && !footer.querySelector('.doctrine-watermark')) {
            try {
                const watermark = document.createElement('span');
                watermark.className = 'doctrine-watermark';
                watermark.style.cssText = 'opacity:0.3; font-size:0.65rem; margin-left:12px; color:#6b4b4b; text-transform:uppercase;';
                setText(watermark, 'R-CORP · ACCOUNTABLE');
                coords.appendChild(watermark);
            } catch (e) { }
        }
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

    // ========== INITIALIZE ==========
    function init() {
        try {
            enhanceAccountability();
            setMissionMarker();
            setFingerprintTooltip();
            secureContactLink();
            secureNavLink();
            handleImageFallbacks();
            secureLinks();
            addDoctrineWatermark();
            propagateNonce();

            logger.log('[R-CORP] Security enhancements active · ' + CONFIG.doctrine);
            logger.log('[R-CORP] Contact: ' + CONFIG.contact);
            logger.log('[R-CORP] Navigation: ' + CONFIG.indexPage);
        } catch (e) {
            logger.log('[R-CORP] Initialization suppressed');
        }
    }

    // Run when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();