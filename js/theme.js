/**
 * theme.js - ROADMAP THEME SWITCHER
 * SECURE · EXTERNAL · CSP COMPLIANT
 * 
 * Provides 4 tactical themes:
 * - BLOOD (default) · Red/black anarchy
 * - MIDNIGHT · Blue/black covert ops
 * - FOREST · Green resistance
 * - AMBER · Tactical/survival
 * 
 * FILE: js/theme.js
 * VERSION: 1.0.0
 */

(function () {
    'use strict';

    // ========== CONFIGURATION ==========
    const THEMES = ['blood', 'midnight', 'forest', 'amber'];
    const STORAGE_KEY = 'roadmap_theme';
    const DEFAULT_THEME = 'blood';

    // ========== APPLY THEME ==========
    function setTheme(themeName) {
        if (!THEMES.includes(themeName)) {
            console.warn(`[THEME] Unknown theme: ${themeName}, falling back to default`);
            themeName = DEFAULT_THEME;
        }

        // Remove existing theme attributes
        document.documentElement.removeAttribute('data-theme');

        // Apply new theme
        document.documentElement.setAttribute('data-theme', themeName);

        // Update active button states
        updateActiveButton(themeName);

        // Save preference
        try {
            localStorage.setItem(STORAGE_KEY, themeName);
        } catch (e) {
            // localStorage unavailable - continue without persistence
        }

        // Log theme change (quiet in production)
        if (window.console && window.console.log) {
            console.log(`%c[THEME] Applied: ${themeName.toUpperCase()}`,
                `color: ${getThemeColor(themeName)}; font-weight: bold;`);
        }
    }

    // ========== GET THEME COLOR FOR CONSOLE ==========
    function getThemeColor(theme) {
        const colors = {
            blood: '#ff0000',
            midnight: '#3366ff',
            forest: '#33aa33',
            amber: '#ffaa33'
        };
        return colors[theme] || '#ff0000';
    }

    // ========== UPDATE ACTIVE BUTTON ==========
    function updateActiveButton(activeTheme) {
        const buttons = document.querySelectorAll('.theme-btn');
        buttons.forEach(btn => {
            const theme = btn.getAttribute('data-theme');
            if (theme === activeTheme) {
                btn.classList.add('active');
                btn.setAttribute('aria-pressed', 'true');
            } else {
                btn.classList.remove('active');
                btn.setAttribute('aria-pressed', 'false');
            }
        });
    }

    // ========== INITIALIZE THEME ==========
    function initTheme() {
        // Check for saved preference
        let savedTheme = DEFAULT_THEME;
        try {
            const stored = localStorage.getItem(STORAGE_KEY);
            if (stored && THEMES.includes(stored)) {
                savedTheme = stored;
            }
        } catch (e) {
            // localStorage unavailable - use default
        }

        // Apply saved or default theme
        setTheme(savedTheme);

        // Set up event listeners for theme buttons
        const buttons = document.querySelectorAll('.theme-btn');
        buttons.forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const theme = this.getAttribute('data-theme');
                if (theme) {
                    setTheme(theme);
                }
            });
        });

        // Add keyboard accessibility
        buttons.forEach(btn => {
            btn.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.click();
                }
            });
        });
    }

    // ========== RUN WHEN DOM READY ==========
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initTheme);
    } else {
        initTheme();
    }
})();