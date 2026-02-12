/**
 * about.js – decensorweb manifesto
 * SECURITY HARDENED EDITION v2.1
 * 
 * SECURITY FEATURES:
 * - CSP compliant (no eval, no inline)
 * - No DOM-based XSS vectors
 * - Safe attribute manipulation
 * - Subresource Integrity (SRI) ready
 * - Input sanitization helpers
 * - CSRF token injection protection
 * 
 * FILE: js/about.js
 */

(function () {
    "use strict";

    // ========== SECURE CONFIGURATION ==========
    const CONFIG = {
        debug: false,  // Disable in production
        csp_enforced: true,
        doctrine_version: '2.1'
    };

    // ========== SAFE CONSOLE OUTPUT ==========
    const safeConsole = {
        log: function (message, style) {
            if (CONFIG.debug && window.console && window.console.log) {
                try {
                    window.console.log(message, style || '');
                } catch (e) {
                    // Silently fail - never break UX
                }
            }
        }
    };

    // ========== DOCTRINE MANIFESTO (NO XSS) ==========
    const doctrine = [
        '⛧ DECENSORWEB · R-CORP ACCOUNTABLE PLATFORM ⛧',
        'PARENT COMPANY: R-CORP — FULL RESPONSIBILITY FOR ALL ACCOUNTS',
        'WE DO NOT COMPLY WITH CENSORSHIP ORDERS.',
        'YOUR ACCOUNT IS PROTECTED BY R-CORP SOVEREIGNTY.',
        '➤ MISSION: ANTI-CENSORSHIP. ALWAYS.'
    ];

    // Quiet console manifesto – no user input, safe
    if (window.console && window.console.log) {
        window.console.log('%c' + doctrine.join('\n'),
            'color: #ff5555; background: #0a0a0a; font-size: 11px; font-family: monospace; padding: 8px; border: 1px solid red;');
    }

    // ========== SECURE ELEMENT SELECTOR (with validation) ==========
    /**
     * Safely query DOM elements with validation
     * @param {string} selector - CSS selector
     * @returns {Element|null} Element or null if invalid
     */
    function safeQuerySelector(selector) {
        if (!selector || typeof selector !== 'string') {
            safeConsole.log('[SECURITY] Invalid selector type');
            return null;
        }

        // Block potentially dangerous selectors
        if (selector.includes('<') || selector.includes('>') || selector.includes('script')) {
            safeConsole.log('[SECURITY] Blocked suspicious selector');
            return null;
        }

        try {
            return document.querySelector(selector);
        } catch (e) {
            safeConsole.log('[SECURITY] Selector error: ' + e.message);
            return null;
        }
    }

    /**
     * Safely set attribute with validation
     * @param {Element} el - DOM element
     * @param {string} attr - Attribute name
     * @param {string} value - Attribute value
     * @returns {boolean} Success status
     */
    function safeSetAttribute(el, attr, value) {
        if (!el || !attr || typeof attr !== 'string' || typeof value !== 'string') {
            return false;
        }

        // Block dangerous attributes
        const dangerousAttrs = ['onerror', 'onload', 'onclick', 'onmouseover', 'onfocus', 'onblur', 'srcdoc'];
        if (dangerousAttrs.includes(attr.toLowerCase())) {
            safeConsole.log('[SECURITY] Blocked dangerous attribute: ' + attr);
            return false;
        }

        // Sanitize attribute values
        if (attr === 'href' || attr === 'src') {
            // Only allow safe protocols
            if (value.startsWith('javascript:') || value.startsWith('data:') || value.startsWith('vbscript:')) {
                safeConsole.log('[SECURITY] Blocked unsafe protocol');
                return false;
            }
        }

        try {
            el.setAttribute(attr, value);
            return true;
        } catch (e) {
            safeConsole.log('[SECURITY] Attribute error: ' + e.message);
            return false;
        }
    }

    /**
     * Safely set text content (prevents XSS)
     * @param {Element} el - DOM element
     * @param {string} text - Text content
     * @returns {boolean} Success status
     */
    function safeSetTextContent(el, text) {
        if (!el || typeof text !== 'string') {
            return false;
        }

        try {
            el.textContent = text;  // Safe, no HTML parsing
            return true;
        } catch (e) {
            return false;
        }
    }

    // ========== SECURE FEATURE ENHANCEMENTS ==========

    // 1. Enhance accountability badge with safe attributes
    function enhanceAccountabilityBadge() {
        const shield = safeQuerySelector('.rcorp-badge-shield');
        if (shield) {
            safeSetAttribute(shield, 'aria-label', 'R-CORP: Sole parent entity · Full account liability · We protect every profile');
        }
    }

    // 2. Set anti-censorship marker (safe dataset)
    function setAntiCensorshipMarker() {
        const missionBlock = safeQuerySelector('.core-mission');
        if (missionBlock) {
            try {
                missionBlock.dataset.antiCensorship = 'active';
                missionBlock.dataset.doctrineVersion = CONFIG.doctrine_version;
            } catch (e) {
                safeConsole.log('[SECURITY] Dataset error: ' + e.message);
            }
        }
    }

    // 3. Display fingerprint tooltip (sanitized)
    function displayFingerprintTooltip() {
        const fingerprintEl = safeQuerySelector('.fingerprint');
        if (fingerprintEl) {
            safeSetAttribute(fingerprintEl, 'title', 'Secure channel fingerprint · R-CORP signed');
        }
    }

    // 4. Handle image fallbacks securely (no eval)
    function handleImageFallbacks() {
        const imgs = document.querySelectorAll('.manifesto-icon, .rcorp-logo-image');
        imgs.forEach(img => {
            img.addEventListener('error', function (e) {
                // Prevent infinite loop
                if (this.hasAttribute('data-error-handled')) {
                    return;
                }

                try {
                    this.style.display = 'none';
                    this.setAttribute('data-error-handled', 'true');

                    if (this.classList.contains('manifesto-icon')) {
                        const fallback = this.nextElementSibling;
                        if (fallback && fallback.classList.contains('icon-fallback')) {
                            fallback.style.display = 'flex';
                        }
                    } else if (this.classList.contains('rcorp-logo-image')) {
                        const parent = this.parentElement;
                        if (parent) {
                            parent.classList.add('sigil-fallback');
                            const fallbackSpan = parent.querySelector('.sigil-fallback-text');
                            if (fallbackSpan) {
                                fallbackSpan.style.display = 'block';
                            }
                        }
                    }
                } catch (err) {
                    safeConsole.log('[SECURITY] Error handler error: ' + err.message);
                }
            }, { once: true });  // Ensure it only runs once
        });
    }

    // 5. Add doctrine watermark (safe text content)
    function addDoctrineWatermark() {
        const footer = safeQuerySelector('.footer-nav');
        if (!footer) return;

        // Check if already exists
        if (footer.querySelector('.doctrine-watermark')) {
            return;
        }

        const coords = footer.querySelector('.map-coordinates');
        if (coords) {
            try {
                const watermark = document.createElement('span');
                watermark.className = 'doctrine-watermark';
                watermark.style.cssText = 'opacity:0.25; font-size:0.6rem; margin-left:15px; color:#6b4b4b; text-transform:uppercase;';
                safeSetTextContent(watermark, 'R-CORP · ACCOUNTABLE');
                coords.appendChild(watermark);
            } catch (e) {
                safeConsole.log('[SECURITY] Watermark error: ' + e.message);
            }
        }
    }

    // 6. CSRF token validator (for future forms)
    function setupCsrfProtection() {
        const csrfToken = safeQuerySelector('#csrf_token');
        if (!csrfToken) return;

        // Intercept form submissions to ensure CSRF token is included
        document.addEventListener('submit', function (e) {
            const form = e.target;
            if (form && form.tagName === 'FORM') {
                // Check if form already has CSRF field
                if (!form.querySelector('[name="csrf_token"]')) {
                    try {
                        const tokenInput = document.createElement('input');
                        tokenInput.type = 'hidden';
                        tokenInput.name = 'csrf_token';
                        tokenInput.value = csrfToken.value || '';
                        form.appendChild(tokenInput);
                    } catch (err) {
                        safeConsole.log('[SECURITY] CSRF injection error');
                    }
                }
            }
        });
    }

    // 7. Secure external links
    function secureExternalLinks() {
        const links = document.querySelectorAll('a[target="_blank"]');
        links.forEach(link => {
            try {
                link.setAttribute('rel', 'noopener noreferrer nofollow');
            } catch (e) {
                // Ignore
            }
        });
    }

    // 8. Prevent clickjacking (already in headers, but reinforce)
    function preventClickjacking() {
        try {
            if (window.self !== window.top) {
                window.top.location = window.self.location;
            }
        } catch (e) {
            // Cross-origin restrictions - ignore
        }
    }

    // 9. Safe localStorage usage (optional, with try/catch)
    function safeStorageAccess() {
        try {
            // Test if storage is available
            if (typeof localStorage !== 'undefined') {
                const test = 'test';
                localStorage.setItem(test, test);
                localStorage.removeItem(test);
            }
        } catch (e) {
            safeConsole.log('[SECURITY] Storage access denied');
        }
    }

    // ========== INITIALIZE SECURE FEATURES ==========
    function initialize() {
        try {
            enhanceAccountabilityBadge();
            setAntiCensorshipMarker();
            displayFingerprintTooltip();
            handleImageFallbacks();
            addDoctrineWatermark();
            setupCsrfProtection();
            secureExternalLinks();
            preventClickjacking();
            safeStorageAccess();

            safeConsole.log('[R-CORP] Security enhancements loaded · v' + CONFIG.doctrine_version);
        } catch (error) {
            // Silent fail - never expose internal errors
            safeConsole.log('[SECURITY] Initialization error (suppressed)');
        }
    }

    // Run when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initialize);
    } else {
        initialize();
    }

})();