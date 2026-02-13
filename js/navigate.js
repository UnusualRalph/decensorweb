/**
 * navigate.js - DECENSORWEB NAVIGATION HUB
 * SECURITY-FOCUSED · EXTERNAL ONLY · CSP COMPLIANT
 * 
 * R-CORP ACCOUNTABILITY ENHANCEMENTS
 * PROJECT:OVERTHROW · CENTRAL ROUTING
 * 
 * FILE: js/navigate.js
 * VERSION: 3.2.0
 */

(function () {
    'use strict';

    // ========== SECURE CONFIGURATION ==========
    const CONFIG = {
        debug: false,
        version: '3.2.0',
        build: 'NAVIGATION_HUB',
        contact: 'rrralefaso@outlook.com',
        nonce: document.currentScript?.getAttribute('nonce') || '',
        doctrine: 'R-CORP · FULL ACCOUNTABILITY'
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
        '⛧ DECENSORWEB · NAVIGATION HUB ⛧',
        'R-CORP ACCOUNTABLE PLATFORM · PROJECT:OVERTHROW',
        'CONTACT: rrralefaso@outlook.com',
        'SECURITY: CSP · SRI · HSTS',
        'SYSTEM: OPERATIONAL · HARDENED',
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
        const contactLink = $('.support-contact');
        if (contactLink) {
            setSafeAttribute(contactLink, 'rel', 'noopener noreferrer nofollow');
            setSafeAttribute(contactLink, 'title', 'Secure contact · PGP encrypted preferred');
        }
    }

    // ========== SECURE NAVIGATION BUTTONS ==========
    function secureNavButtons() {
        const navButtons = document.querySelectorAll('.nav-button');
        navButtons.forEach(button => {
            try {
                button.setAttribute('rel', 'noopener noreferrer');

                // Validate href attribute
                const href = button.getAttribute('href');
                if (href && (href.startsWith('javascript:') || href.includes('<script'))) {
                    button.setAttribute('href', '#');
                    logger.log('[SECURE] Blocked malicious navigation link');
                }
            } catch (e) { }
        });
    }

    // ========== FINGERPRINT TOOLTIP ==========
    function setFingerprintTooltip() {
        const fp = $('.fingerprint');
        if (fp) {
            setSafeAttribute(fp, 'title', 'Secure session fingerprint · R-CORP signed');
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

    // ========== ACTIVE NAVIGATION HIGHLIGHT ==========
    function highlightCurrentPage() {
        const currentPage = window.location.pathname.split('/').pop() || 'index.html';
        const navCards = document.querySelectorAll('.nav-card');

        navCards.forEach(card => {
            const filePath = card.querySelector('.file-path');
            if (filePath && filePath.textContent.trim() === currentPage) {
                try {
                    card.style.borderColor = '#ff0000';
                    card.style.boxShadow = '8px 8px 0 #8b0000';

                    const header = card.querySelector('.nav-card-header');
                    if (header) {
                        header.style.borderLeftColor = '#ff0000';
                        header.style.background = 'rgba(139, 0, 0, 0.2)';
                    }

                    const button = card.querySelector('.nav-button');
                    if (button) {
                        button.style.background = '#8b0000';
                        button.style.color = '#ffffff';
                        button.style.borderColor = '#ffffff';
                    }
                } catch (e) { }
            }
        });
    }

    // ========== DOCTRINE WATERMARK ==========
    function addDoctrineWatermark() {
        const footer = $('.nav-footer');
        if (!footer) return;

        const coords = footer.querySelector('.footer-coordinates');
        if (coords && !footer.querySelector('.doctrine-watermark')) {
            try {
                const watermark = document.createElement('span');
                watermark.className = 'doctrine-watermark';
                watermark.style.cssText = 'opacity:0.3; font-size:0.65rem; margin-left:12px; color:#6b4b4b; text-transform:uppercase;';
                watermark.textContent = 'R-CORP · ACCOUNTABLE';
                coords.appendChild(watermark);
            } catch (e) { }
        }
    }

    // ========== INITIALIZE ==========
    function init() {
        try {
            secureLinks();
            secureContactLink();
            secureNavButtons();
            setFingerprintTooltip();
            propagateNonce();
            highlightCurrentPage();
            addDoctrineWatermark();

            logger.log('[NAVIGATION] Secure routing active · v' + CONFIG.version);
            logger.log('[NAVIGATION] Doctrine: ' + CONFIG.doctrine);
        } catch (e) {
            logger.log('[NAVIGATION] Initialization suppressed');
        }
    }

    // Run when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();