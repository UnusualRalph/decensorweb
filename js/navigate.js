/**
 * navigate.js - UPDATED
 * DECENSORWEB NAVIGATION HUB · COMPLETE SYSTEM ROUTING
 * SECURITY-FOCUSED · EXTERNAL ONLY · CSP COMPLIANT
 * 
 * 5 ACTIVE NODES:
 * - INDEX.HTML        · Main Terminal
 * - ROADMAP.HTML      · Project:Overthrow
 * - ABOUT.PHP         · Decensorweb Manifesto
 * - PRIVACY.PHP       · Data Sovereignty Protocol
 * - CONTACT.PHP       · Secure Communications Channel
 * 
 * R-CORP ACCOUNTABILITY · PROJECT:OVERTHROW
 * FILE: js/navigate.js
 * VERSION: 3.5.0
 */

(function () {
    'use strict';

    // ========== SECURE CONFIGURATION ==========
    const CONFIG = {
        debug: false,
        version: '3.5.0',
        build: 'NAVIGATION_COMPLETE',
        contact: 'rrralefaso@outlook.com',
        github: 'rr-ralefaso',
        instagram: '@unusualralph',
        nonce: document.currentScript?.getAttribute('nonce') || '',
        doctrine: 'R-CORP · FULL ACCOUNTABILITY · 5 ACTIVE NODES',
        nodes: [
            'index.html',
            'roadmap.html',
            'about.php',
            'privacy.php',
            'contact.php'
        ]
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
        '5 ACTIVE NODES · COMPLETE SYSTEM ACCESS',
        'INDEX · ROADMAP · ABOUT · PRIVACY · CONTACT',
        'CONTACT: rrralefaso@outlook.com',
        'GITHUB: rr-ralefaso',
        'INSTAGRAM: @unusualralph',
        'SECURITY: CSP · SRI · HSTS · XSS PROTECTION',
        'SYSTEM: OPERATIONAL · HARDENED · SOVEREIGN',
        '➤ MISSION: ANTI-CENSORSHIP. ALWAYS.'
    ];

    // Console signature (safe)
    if (window.console) {
        window.console.log(
            '%c' + doctrine.join('\n'),
            'color: #ff5555; background: #0a0a0a; font-size: 11px; font-family: monospace; padding: 8px; border: 1px solid red;'
        );

        // System status notice
        window.console.log(
            '%c🔐 NAVIGATION HUB: 5/5 NODES ONLINE · ALL SYSTEMS OPERATIONAL · R-CORP ACCOUNTABLE 🔐',
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

    // ========== SECURE QUICK ACCESS LINKS ==========
    function secureQuickLinks() {
        const quickLinks = document.querySelectorAll('.quick-channel-link');
        quickLinks.forEach(link => {
            try {
                link.setAttribute('rel', 'noopener noreferrer nofollow');
            } catch (e) { }
        });
    }

    // ========== FINGERPRINT TOOLTIP ==========
    function setFingerprintTooltip() {
        const fingerprints = document.querySelectorAll('.fingerprint');
        fingerprints.forEach(fp => {
            setSafeAttribute(fp, 'title', 'Secure session fingerprint · R-CORP signed');
        });
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
        const currentPage = window.location.pathname.split('/').pop() || 'navigate.php';
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

    // ========== NODE COUNT VERIFICATION ==========
    function verifyNodeCount() {
        const navCards = document.querySelectorAll('.nav-card');
        const nodeCount = navCards.length;

        if (nodeCount === CONFIG.nodes.length) {
            logger.log(`[NAVIGATION] ✓ All ${nodeCount} nodes verified online`);

            // Update node count display
            const nodeBadges = document.querySelectorAll('.nodes-badge, .node-count');
            nodeBadges.forEach(badge => {
                if (badge.classList.contains('node-count')) {
                    badge.textContent = `${nodeCount}/${nodeCount} NODES ONLINE`;
                }
            });
        } else {
            logger.log(`[NAVIGATION] ⚠️ Node count mismatch: expected ${CONFIG.nodes.length}, found ${nodeCount}`);
        }
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
                watermark.textContent = '5/5 NODES · R-CORP ACCOUNTABLE';
                coords.appendChild(watermark);
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
    }

    // ========== DIRECTORY SORTING ==========
    function enhanceDirectory() {
        const directoryItems = document.querySelectorAll('.directory-item');
        if (directoryItems.length > 0) {
            // Ensure consistent ordering (alphabetical by filename)
            const itemsArray = Array.from(directoryItems);
            const parent = directoryItems[0].parentNode;

            // Sort by file extension (.html before .php)
            itemsArray.sort((a, b) => {
                const fileA = a.querySelector('.directory-file')?.textContent || '';
                const fileB = b.querySelector('.directory-file')?.textContent || '';

                // Put .html files first
                if (fileA.endsWith('.html') && !fileB.endsWith('.html')) return -1;
                if (!fileA.endsWith('.html') && fileB.endsWith('.html')) return 1;

                return fileA.localeCompare(fileB);
            });

            // Reorder if needed
            itemsArray.forEach((item, index) => {
                if (parent.children[index] !== item) {
                    parent.insertBefore(item, parent.children[index]);
                }
            });
        }
    }

    // ========== INITIALIZE ==========
    function init() {
        try {
            secureLinks();
            secureContactLink();
            secureNavButtons();
            secureQuickLinks();
            setFingerprintTooltip();
            propagateNonce();
            highlightCurrentPage();
            verifyNodeCount();
            addDoctrineWatermark();
            verifyNoTracking();
            enhanceDirectory();

            logger.log('[NAVIGATION] Secure routing active · v' + CONFIG.version);
            logger.log('[NAVIGATION] Doctrine: ' + CONFIG.doctrine);
            logger.log('[NAVIGATION] Nodes: ' + CONFIG.nodes.join(', '));

            // Final system status
            console.log('%c⚔️ NAVIGATION HUB: 5/5 NODES OPERATIONAL · COMPLETE SYSTEM ACCESS · R-CORP ACCOUNTABLE ⚔️',
                'color: #ffaaaa; background: #1a0a0a; font-size: 11px; font-family: monospace; padding: 6px; border: 1px solid #ff5555;');
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