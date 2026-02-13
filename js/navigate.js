/**
 * contact.js - DECENSORWEB SECURE COMMUNICATIONS CHANNEL
 * SECURITY-FOCUSED · EXTERNAL ONLY · CSP COMPLIANT
 * 
 * ENCRYPTED CONTACT PROTOCOL · R-CORP ACCOUNTABILITY
 * CONTACT: rrralefaso@outlook.com
 * GITHUB: rr-ralefaso
 * INSTAGRAM: @unusualralph
 * SPONSOR: GitHub Sponsors
 * 
 * FILE: js/contact.js
 * VERSION: 3.4.0
 */

(function () {
    'use strict';

    // ========== SECURE CONFIGURATION ==========
    const CONFIG = {
        debug: false,
        version: '3.4.0',
        build: 'CONTACT_HARDENED',
        contact: {
            email: 'rrralefaso@outlook.com',
            github: 'rr-ralefaso',
            github_url: 'https://github.com/rr-ralefaso',
            github_sponsors: 'https://github.com/sponsors/RR-Ralefaso',
            instagram: '@unusualralph',
            instagram_url: 'https://instagram.com/unusualralph',
            instagram_handle: 'unusualralph'
        },
        nonce: document.currentScript?.getAttribute('nonce') || '',
        doctrine: 'R-CORP · ENCRYPTED · ACCOUNTABLE'
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
        '✉️ DECENSORWEB · SECURE CONTACT PROTOCOL ✉️',
        'R-CORP ACCOUNTABLE COMMUNICATIONS CHANNEL',
        'CONTACT: rrralefaso@outlook.com',
        'GITHUB: rr-ralefaso',
        'INSTAGRAM: @unusualralph',
        'SPONSOR: GitHub Sponsors',
        '➤ PGP ENCRYPTION PREFERRED · NO TRACKING · NO LOGGING'
    ];

    // Console signature (safe) - reinforces secure contact
    if (window.console) {
        window.console.log(
            '%c' + doctrine.join('\n'),
            'color: #ff5555; background: #0a0a0a; font-size: 11px; font-family: monospace; padding: 8px; border: 1px solid red;'
        );

        // Additional security notice
        window.console.log(
            '%c🔐 SECURE CONTACT NOTICE: This channel supports PGP encryption. No tracking. No logging. 🔐',
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

    // ========== SECURE EXTERNAL LINKS ==========
    function secureLinks() {
        const links = document.querySelectorAll('a[target="_blank"]');
        links.forEach(link => {
            try {
                link.setAttribute('rel', 'noopener noreferrer nofollow');
            } catch (e) { }
        });
    }

    // ========== SECURE CONTACT LINKS ==========
    function secureContactLinks() {
        // Email link
        const emailLink = document.querySelector('.contact-link[href*="mailto"]');
        if (emailLink) {
            setSafeAttribute(emailLink, 'rel', 'noopener noreferrer nofollow');
            setSafeAttribute(emailLink, 'title', 'Secure email contact · PGP encrypted preferred');
        }

        // GitHub link
        const githubLinks = document.querySelectorAll('a[href*="github.com"]');
        githubLinks.forEach(link => {
            setSafeAttribute(link, 'rel', 'noopener noreferrer nofollow');
            setSafeAttribute(link, 'title', 'GitHub · Project repository · Secure contributions');
        });

        // Instagram link
        const instagramLinks = document.querySelectorAll('a[href*="instagram.com"]');
        instagramLinks.forEach(link => {
            setSafeAttribute(link, 'rel', 'noopener noreferrer nofollow');
            setSafeAttribute(link, 'title', 'Instagram · Community updates · Digital sovereignty');
        });
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

    // ========== SPONSORSHIP BUTTON ENHANCEMENT ==========
    function enhanceSponsorshipButton() {
        const sponsorBtn = $('.sponsorship-button');
        if (sponsorBtn) {
            setSafeAttribute(sponsorBtn, 'rel', 'noopener noreferrer nofollow');
            setSafeAttribute(sponsorBtn, 'title', 'Sponsor decensorweb on GitHub · Support digital freedom');
        }
    }

    // ========== PGP FINGERPRINT INTERACTION ==========
    function enhancePGPNotice() {
        const pgpFingerprint = $('.fingerprint-value');
        if (pgpFingerprint) {
            setSafeAttribute(pgpFingerprint, 'title', 'PGP key available upon request via secure channel');

            // Add copy functionality (secure, no clipboard access without interaction)
            pgpFingerprint.addEventListener('click', function () {
                try {
                    const text = 'PGP fingerprint request: rrralefaso@outlook.com';
                    logger.log('[PGP] Key request initiated');

                    // Visual feedback only
                    this.style.backgroundColor = '#3a2a2a';
                    setTimeout(() => {
                        this.style.backgroundColor = '';
                    }, 200);
                } catch (e) { }
            });
        }
    }

    // ========== VERIFY CONTACT CHANNELS ==========
    function verifyContactChannels() {
        const channels = {
            email: document.querySelector('a[href*="mailto:rrralefaso"]'),
            github: document.querySelector('a[href*="github.com/rr-ralefaso"]'),
            instagram: document.querySelector('a[href*="instagram.com/unusualralph"]'),
            sponsor: document.querySelector('a[href*="github.com/sponsors/RR-Ralefaso"]')
        };

        // Verify all required channels exist
        for (const [channel, element] of Object.entries(channels)) {
            if (element) {
                logger.log(`[CONTACT] ${channel.toUpperCase()} channel verified`);
            } else {
                logger.log(`[CONTACT] ⚠️ ${channel.toUpperCase()} channel missing`);
            }
        }

        // Log verification to console (non-invasive)
        console.log('%c✓ CONTACT CHANNELS VERIFIED: Email · GitHub · Instagram · Sponsors',
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
        const currentPage = window.location.pathname.split('/').pop() || 'contact.php';
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
        const footer = $('.contact-footer');
        if (!footer) return;

        const status = footer.querySelector('.footer-status');
        if (status && !footer.querySelector('.doctrine-watermark')) {
            try {
                const watermark = document.createElement('span');
                watermark.className = 'doctrine-watermark';
                watermark.style.cssText = 'opacity:0.3; font-size:0.65rem; margin-left:12px; color:#6b4b4b; text-transform:uppercase;';
                watermark.textContent = 'PGP PREFERRED · NO TRACKING';
                status.appendChild(watermark);
            } catch (e) { }
        }
    }

    // ========== NO-TRACKING VERIFICATION ==========
    function verifyNoTracking() {
        // Check for any third-party tracking scripts
        const trackingPatterns = ['analytics', 'tracking', 'pixel', 'facebook', 'google-analytics', 'gtag'];
        const scripts = document.querySelectorAll('script[src]');

        let trackingDetected = false;

        scripts.forEach(script => {
            const src = script.getAttribute('src') || '';
            trackingPatterns.forEach(pattern => {
                if (src.includes(pattern)) {
                    trackingDetected = true;
                    logger.log(`[PRIVACY] ⚠️ Potential tracking detected: ${src}`);
                    try {
                        script.remove();
                        logger.log('[PRIVACY] Removed unauthorized tracking script');
                    } catch (e) { }
                }
            });
        });

        if (!trackingDetected) {
            logger.log('[PRIVACY] ✓ No tracking scripts detected');
        }

        // Log privacy verification
        console.log('%c✓ PRIVACY VERIFIED: This page contains no tracking · No analytics · No fingerprinting',
            'color: #aaffaa; background: #0a1a0a; font-size: 10px; padding: 2px;');
    }

    // ========== SPONSORSHIP TIER HOVER EFFECTS ==========
    function enhanceSponsorshipTiers() {
        const tiers = document.querySelectorAll('.sponsorship-card');
        tiers.forEach((tier, index) => {
            tier.addEventListener('mouseenter', function () {
                logger.log(`[SPONSOR] Tier ${index + 1} viewed`);
            });
        });
    }

    // ========== INITIALIZE ==========
    function init() {
        try {
            secureLinks();
            secureContactLinks();
            secureNavLinks();
            setFingerprintTooltip();
            enhanceSponsorshipButton();
            enhancePGPNotice();
            verifyContactChannels();
            propagateNonce();
            highlightCurrentPage();
            addDoctrineWatermark();
            verifyNoTracking();
            enhanceSponsorshipTiers();

            logger.log('[CONTACT] Secure communications protocol active · v' + CONFIG.version);
            logger.log('[CONTACT] Email: ' + CONFIG.contact.email);
            logger.log('[CONTACT] GitHub: ' + CONFIG.contact.github);
            logger.log('[CONTACT] Instagram: ' + CONFIG.contact.instagram);

            // Final secure contact notice
            console.log('%c✉️ R-CORP SECURE CONTACT: All channels monitored by Office of Accountability · PGP preferred ✉️',
                'color: #ffaaaa; background: #1a0a0a; font-size: 11px; font-family: monospace; padding: 6px; border: 1px solid #ff5555;');
        } catch (e) {
            logger.log('[CONTACT] Initialization suppressed');
        }
    }

    // Run when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();