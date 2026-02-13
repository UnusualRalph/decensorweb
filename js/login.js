/**
 * login.js · DECENSORWEB SECURE LOGIN SYSTEM
 * COMPLETE · FULLY FEATURED · R-CORP ACCOUNTABILITY
 * 
 * Features:
 * - Client-side validation
 * - Password strength meter
 * - Toggle password visibility
 * - CSRF token refresh
 * - Rate limiting feedback
 * - Accessibility compliance
 * - Security notifications
 * - PGP key reference
 * - Dual authentication (username + email)
 * 
 * FILE: js/login.js
 * VERSION: 1.1.0
 */

(function () {
    'use strict';

    // ========== CONFIGURATION ==========
    const CONFIG = {
        debug: false,
        doctrine: 'R-CORP · WE DO NOT SELL · WE DO NOT LOG · WE DO NOT COMPLY',
        minPasswordLength: 8,
        sessionTimeout: 7200, // 2 hours
        version: '1.1.0'
    };

    // ========== DOM ELEMENTS ==========
    const elements = {
        loginForm: document.querySelector('.login-form'),
        registerForm: document.querySelector('.register-form'),
        loginInput: document.getElementById('login'),
        usernameInput: document.getElementById('username'),
        emailInput: document.getElementById('email'),
        passwordInput: document.getElementById('password'),
        confirmInput: document.getElementById('confirm_password'),
        doctrineCheckbox: document.getElementById('doctrine'),
        csrfInput: document.querySelector('input[name="csrf_token"]'),
        rememberCheckbox: document.getElementById('remember'),
        passwordStrength: document.querySelector('.password-strength'),
        toggleButtons: document.querySelectorAll('.password-toggle')
    };

    // ========== DOCTRINE MANIFESTO ==========
    const doctrine = [
        '⛧ DECENSORWEB · SECURE AUTHENTICATION ⛧',
        'R-CORP ACCOUNTABLE · ZERO TRACKING',
        'WE DO NOT SELL · WE DO NOT LOG',
        'WE DO NOT COMPLY WITH SURVEILLANCE',
        '➤ PGP ENCRYPTION PREFERRED',
        `➤ VERSION: ${CONFIG.version}`
    ];

    // Console signature (non-invasive, only in dev tools)
    if (window.console) {
        console.log(
            '%c' + doctrine.join('\n'),
            'color: #ff5555; background: #0a0a0a; font-size: 11px; font-family: monospace; padding: 8px; border: 1px solid red;'
        );

        // Additional security notice
        console.log(
            '%c🔐 SECURE CONNECTION: This page uses CSP, SRI, and encrypted transmission. No tracking. No logging. 🔐',
            'color: #aaffaa; background: #0a1a0a; font-size: 10px; font-family: monospace; padding: 4px; border: 1px solid #00aa00;'
        );
    }

    // ========== UTILITY FUNCTIONS ==========

    /**
     * Show notification message
     */
    function showNotification(message, type = 'info', duration = 5000) {
        // Remove existing alerts of same type
        const existingAlerts = document.querySelectorAll(`.alert.${type}`);
        if (existingAlerts.length > 3) {
            existingAlerts[0].remove();
        }

        const alert = document.createElement('div');
        alert.className = `alert ${type}`;
        alert.setAttribute('role', 'alert');
        alert.setAttribute('aria-live', 'polite');

        // Add icon based on type
        const icons = {
            error: '⛔',
            success: '✓',
            warning: '⚠️',
            info: 'ℹ️'
        };
        alert.innerHTML = `${icons[type] || '•'} ${message}`;

        // Insert at top of form
        const form = document.querySelector('.login-form, .register-form');
        if (form) {
            form.insertBefore(alert, form.firstChild);

            // Auto-hide after duration
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.remove();
                    }
                }, 300);
            }, duration);
        }
    }

    /**
     * Sanitize input (prevent XSS)
     */
    function sanitizeInput(input) {
        if (!input) return '';
        const div = document.createElement('div');
        div.textContent = input;
        return div.innerHTML;
    }

    /**
     * Validate email format
     */
    function isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    /**
     * Validate username format
     */
    function isValidUsername(username) {
        return /^[a-zA-Z0-9_]{3,50}$/.test(username);
    }

    /**
     * Check if input is email or username
     */
    function isEmail(input) {
        return isValidEmail(input);
    }

    /**
     * Check password strength
     */
    function checkPasswordStrength(password) {
        if (!password) return 0;

        let strength = 0;

        // Length check
        if (password.length >= 8) strength += 1;
        if (password.length >= 12) strength += 1;

        // Character variety
        if (/[a-z]/.test(password)) strength += 1;
        if (/[A-Z]/.test(password)) strength += 1;
        if (/[0-9]/.test(password)) strength += 1;
        if (/[^a-zA-Z0-9]/.test(password)) strength += 1;

        // Avoid common patterns
        if (!/(password|12345|qwerty|admin|letmein)/i.test(password)) strength += 1;

        return Math.min(strength, 5); // Cap at 5
    }

    /**
     * Get password strength label
     */
    function getStrengthLabel(strength) {
        const labels = [
            { text: 'INSECURE', color: '#ff5555' },
            { text: 'WEAK', color: '#ff8888' },
            { text: 'FAIR', color: '#ffaa55' },
            { text: 'GOOD', color: '#aaff55' },
            { text: 'STRONG', color: '#55ff55' },
            { text: 'EXCELLENT', color: '#00ff00' }
        ];
        return labels[strength] || labels[0];
    }

    // ========== PASSWORD STRENGTH METER ==========
    function setupPasswordStrengthMeter() {
        const passwordInput = elements.passwordInput;
        if (!passwordInput) return;

        // Create strength meter if it doesn't exist
        let meter = document.querySelector('.password-strength-meter');
        if (!meter) {
            meter = document.createElement('div');
            meter.className = 'password-strength-meter';
            passwordInput.parentNode.appendChild(meter);
        }

        passwordInput.addEventListener('input', function () {
            const password = this.value;
            const strength = checkPasswordStrength(password);
            const label = getStrengthLabel(strength);

            meter.innerHTML = `
                <div class="strength-bar">
                    <div class="strength-fill" style="width: ${strength * 20}%; background: ${label.color};"></div>
                </div>
                <span class="strength-label" style="color: ${label.color};">${label.text}</span>
            `;

            // Add classes for styling
            meter.className = `password-strength-meter strength-${strength}`;
        });

        // Trigger initial check
        if (passwordInput.value) {
            passwordInput.dispatchEvent(new Event('input'));
        }
    }

    // ========== PASSWORD VISIBILITY TOGGLE ==========
    function setupPasswordToggles() {
        const passwordInputs = [elements.passwordInput, elements.confirmInput].filter(Boolean);

        passwordInputs.forEach(input => {
            if (!input || input.dataset.toggleInitialized) return;

            // Create toggle button
            const toggleBtn = document.createElement('button');
            toggleBtn.type = 'button';
            toggleBtn.className = 'password-toggle';
            toggleBtn.innerHTML = '👁️';
            toggleBtn.setAttribute('aria-label', 'Toggle password visibility');
            toggleBtn.setAttribute('tabindex', '-1');

            // Position relative to input
            input.parentNode.style.position = 'relative';
            input.parentNode.appendChild(toggleBtn);

            toggleBtn.addEventListener('click', function () {
                const type = input.type === 'password' ? 'text' : 'password';
                input.type = type;
                this.innerHTML = type === 'password' ? '👁️' : '👁️‍🗨️';
                this.setAttribute('aria-label', type === 'password' ? 'Show password' : 'Hide password');

                // Focus back to input
                input.focus();
            });

            input.dataset.toggleInitialized = 'true';
        });
    }

    // ========== FORM VALIDATION ==========
    function setupFormValidation() {
        const forms = [elements.loginForm, elements.registerForm].filter(Boolean);

        forms.forEach(form => {
            form.addEventListener('submit', function (e) {
                let isValid = true;
                const errors = [];

                // Determine form type
                const isLogin = form.classList.contains('login-form');
                const isRegister = form.classList.contains('register-form');

                // Validate based on form type
                if (isLogin) {
                    // Login validation - SUPPORTS BOTH USERNAME AND EMAIL
                    const login = elements.loginInput?.value.trim();
                    const password = elements.passwordInput?.value;

                    if (!login) {
                        isValid = false;
                        errors.push('Username or email required');
                        if (elements.loginInput) elements.loginInput.style.borderColor = '#ff5555';
                    } else {
                        // Check if it's a valid username OR email
                        if (!isValidUsername(login) && !isValidEmail(login)) {
                            isValid = false;
                            errors.push('Please enter a valid username (letters/numbers/underscores) or email address');
                            if (elements.loginInput) elements.loginInput.style.borderColor = '#ff5555';
                        } else {
                            if (elements.loginInput) elements.loginInput.style.borderColor = '';

                            // Add helpful hint about what format was detected
                            if (isValidEmail(login)) {
                                // It's an email - all good
                                if (CONFIG.debug) console.log('[LOGIN] Email format detected');
                            } else {
                                // It's a username - all good
                                if (CONFIG.debug) console.log('[LOGIN] Username format detected');
                            }
                        }
                    }

                    if (!password) {
                        isValid = false;
                        errors.push('Password required');
                        if (elements.passwordInput) elements.passwordInput.style.borderColor = '#ff5555';
                    } else if (password.length < CONFIG.minPasswordLength) {
                        isValid = false;
                        errors.push(`Password must be at least ${CONFIG.minPasswordLength} characters`);
                        if (elements.passwordInput) elements.passwordInput.style.borderColor = '#ff5555';
                    } else {
                        if (elements.passwordInput) elements.passwordInput.style.borderColor = '';
                    }
                }

                if (isRegister) {
                    // Registration validation - REQUIRE BOTH USERNAME AND EMAIL
                    const username = elements.usernameInput?.value.trim();
                    const email = elements.emailInput?.value.trim();
                    const password = elements.passwordInput?.value;
                    const confirm = elements.confirmInput?.value;
                    const doctrine = elements.doctrineCheckbox?.checked;

                    // Username validation
                    if (!username) {
                        isValid = false;
                        errors.push('Username required');
                        if (elements.usernameInput) elements.usernameInput.style.borderColor = '#ff5555';
                    } else if (!isValidUsername(username)) {
                        isValid = false;
                        errors.push('Username must be 3-50 characters and contain only letters, numbers, underscores');
                        if (elements.usernameInput) elements.usernameInput.style.borderColor = '#ff5555';
                    } else {
                        if (elements.usernameInput) elements.usernameInput.style.borderColor = '';
                    }

                    // Email validation
                    if (!email) {
                        isValid = false;
                        errors.push('Email required');
                        if (elements.emailInput) elements.emailInput.style.borderColor = '#ff5555';
                    } else if (!isValidEmail(email)) {
                        isValid = false;
                        errors.push('Invalid email format');
                        if (elements.emailInput) elements.emailInput.style.borderColor = '#ff5555';
                    } else {
                        if (elements.emailInput) elements.emailInput.style.borderColor = '';
                    }

                    // Password validation
                    if (!password) {
                        isValid = false;
                        errors.push('Password required');
                        if (elements.passwordInput) elements.passwordInput.style.borderColor = '#ff5555';
                    } else if (password.length < CONFIG.minPasswordLength) {
                        isValid = false;
                        errors.push(`Password must be at least ${CONFIG.minPasswordLength} characters`);
                        if (elements.passwordInput) elements.passwordInput.style.borderColor = '#ff5555';
                    } else if (checkPasswordStrength(password) < 2) {
                        isValid = false;
                        errors.push('Password is too weak. Include mixed case, numbers, and symbols');
                        if (elements.passwordInput) elements.passwordInput.style.borderColor = '#ff5555';
                    } else {
                        if (elements.passwordInput) elements.passwordInput.style.borderColor = '';
                    }

                    // Confirm password
                    if (password !== confirm) {
                        isValid = false;
                        errors.push('Passwords do not match');
                        if (elements.confirmInput) elements.confirmInput.style.borderColor = '#ff5555';
                    } else {
                        if (elements.confirmInput) elements.confirmInput.style.borderColor = '';
                    }

                    // Doctrine acceptance
                    if (!doctrine) {
                        isValid = false;
                        errors.push('You must accept the R-CORP accountability doctrine');
                        if (elements.doctrineCheckbox) {
                            elements.doctrineCheckbox.parentNode.style.borderColor = '#ff5555';
                        }
                    } else {
                        if (elements.doctrineCheckbox) {
                            elements.doctrineCheckbox.parentNode.style.borderColor = '';
                        }
                    }
                }

                // Show errors or allow submission
                if (!isValid) {
                    e.preventDefault();

                    // Show first error as notification
                    if (errors.length > 0) {
                        showNotification(errors[0], 'error');
                    }

                    // Scroll to first error
                    const firstError = document.querySelector('[style*="border-color: #ff5555"]');
                    if (firstError) {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                } else {
                    // Add loading state to submit button
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '⚡ PROCESSING ⚡';
                    }

                    // For login form, add a hidden field to indicate what type of login was used
                    if (isLogin && elements.loginInput) {
                        const loginValue = elements.loginInput.value.trim();

                        // Check if there's already a hidden field for login_type
                        let loginTypeField = form.querySelector('input[name="login_type"]');
                        if (!loginTypeField) {
                            loginTypeField = document.createElement('input');
                            loginTypeField.type = 'hidden';
                            loginTypeField.name = 'login_type';
                            form.appendChild(loginTypeField);
                        }

                        // Set the login type based on the input format
                        if (isValidEmail(loginValue)) {
                            loginTypeField.value = 'email';
                        } else {
                            loginTypeField.value = 'username';
                        }
                    }
                }
            });

            // Add real-time validation for login field to give feedback
            if (isLogin && elements.loginInput) {
                elements.loginInput.addEventListener('input', function () {
                    const value = this.value.trim();

                    // Reset border
                    this.style.borderColor = '';

                    // Only show hint if there's enough text
                    if (value.length > 2) {
                        if (isValidEmail(value)) {
                            this.style.borderColor = '#55ff55'; // Green for email
                        } else if (isValidUsername(value)) {
                            this.style.borderColor = '#55aaff'; // Blue for username
                        }
                    }
                });
            }
        });
    }

    // ========== CSRF TOKEN REFRESH ==========
    function setupCsrfRefresh() {
        const csrfInput = elements.csrfInput;
        if (!csrfInput) return;

        // Refresh token every 30 minutes
        setInterval(() => {
            fetch('refresh-csrf.php', {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.token) {
                        csrfInput.value = data.token;
                        showNotification('Security token refreshed', 'success', 3000);
                    }
                })
                .catch(error => {
                    console.log('[CSRF] Refresh failed (non-critical)');
                });
        }, 30 * 60 * 1000); // 30 minutes
    }

    // ========== RATE LIMIT FEEDBACK ==========
    function checkRateLimit() {
        const attempts = parseInt(localStorage.getItem('login_attempts') || '0');
        const lastAttempt = parseInt(localStorage.getItem('last_attempt') || '0');
        const now = Math.floor(Date.now() / 1000);

        if (attempts >= 5 && (now - lastAttempt) < 900) {
            const waitTime = 900 - (now - lastAttempt);
            const minutes = Math.ceil(waitTime / 60);

            showNotification(`Too many attempts. Try again in ${minutes} minute(s).`, 'warning');

            // Disable form if on login page
            if (elements.loginForm) {
                const submitBtn = elements.loginForm.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = `⏳ WAIT ${minutes} MIN ⏳`;
                }
            }
        }
    }

    // ========== PGP KEY REFERENCE ==========
    function addPGPReference() {
        const footer = document.querySelector('.accountability-footer');
        if (!footer) return;

        const pgpRef = document.createElement('div');
        pgpRef.className = 'pgp-reference';
        pgpRef.innerHTML = `
            <span class="pgp-icon">🔑</span>
            <span class="pgp-text">PGP ENCRYPTED COMMUNICATION PREFERRED · KEY AVAILABLE ON REQUEST</span>
        `;

        footer.appendChild(pgpRef);
    }

    // ========== ACCESSIBILITY ENHANCEMENTS ==========
    function setupAccessibility() {
        // Add ARIA labels
        const inputs = document.querySelectorAll('input[type="text"], input[type="email"], input[type="password"]');
        inputs.forEach(input => {
            const label = document.querySelector(`label[for="${input.id}"]`);
            if (label && !input.getAttribute('aria-label')) {
                input.setAttribute('aria-label', label.textContent.trim());
            }
        });

        // Add keyboard navigation
        document.addEventListener('keydown', function (e) {
            // Ctrl+Shift+L focuses login field
            if (e.ctrlKey && e.shiftKey && e.key === 'L') {
                e.preventDefault();
                if (elements.loginInput) {
                    elements.loginInput.focus();
                }
            }

            // Escape clears notifications
            if (e.key === 'Escape') {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => alert.remove());
            }
        });
    }

    // ========== INPUT MASKING FOR SENSITIVE DATA ==========
    function setupInputMasking() {
        const emailInput = elements.emailInput;
        if (emailInput) {
            emailInput.addEventListener('blur', function () {
                const email = this.value.trim();
                if (email && !isValidEmail(email)) {
                    this.style.borderColor = '#ff5555';
                    showNotification('Please enter a valid email address', 'warning', 3000);
                }
            });
        }
    }

    // ========== SESSION TIMEOUT WARNING ==========
    function checkSessionTimeout() {
        const loginTime = localStorage.getItem('login_time');
        if (loginTime) {
            const elapsed = Math.floor(Date.now() / 1000) - parseInt(loginTime);
            const remaining = CONFIG.sessionTimeout - elapsed;

            if (remaining < 300 && remaining > 0) {
                const minutes = Math.ceil(remaining / 60);
                showNotification(`Session expires in ${minutes} minutes. Please save your work.`, 'warning');
            }
        }
    }

    // ========== INITIALIZE ALL FEATURES ==========
    function init() {
        try {
            // Setup form validation
            setupFormValidation();

            // Password features
            setupPasswordStrengthMeter();
            setupPasswordToggles();

            // Security features
            setupCsrfRefresh();
            checkRateLimit();

            // UX enhancements
            addPGPReference();
            setupAccessibility();
            setupInputMasking();
            checkSessionTimeout();

            // Track login attempts (client-side rate limiting)
            if (elements.loginForm) {
                elements.loginForm.addEventListener('submit', function () {
                    const attempts = parseInt(localStorage.getItem('login_attempts') || '0');
                    localStorage.setItem('login_attempts', (attempts + 1).toString());
                    localStorage.setItem('last_attempt', Math.floor(Date.now() / 1000).toString());
                });
            }

            // Clear login attempts on successful login (call this from dashboard)
            if (window.location.pathname.includes('dashboard')) {
                localStorage.removeItem('login_attempts');
                localStorage.removeItem('last_attempt');
                localStorage.setItem('login_time', Math.floor(Date.now() / 1000).toString());
            }

            // Log initialization
            if (CONFIG.debug) {
                console.log('[LOGIN] Security features initialized');
            }

            // Final security notice
            console.log(
                '%c🔒 R-CORP SECURE AUTH: Client-side validation active · No tracking · No logging · PGP ready · Dual auth (username/email) 🔒',
                'color: #aaffaa; background: #0a1a0a; font-size: 10px; font-family: monospace; padding: 4px; border: 1px solid #00aa00;'
            );

        } catch (error) {
            console.error('[LOGIN] Initialization error:', error);
            // Fail silently - don't break the form
        }
    }

    // Run when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();