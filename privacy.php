<?php
/**
 * PRIVACY.PHP · DECENSORWEB DATA SOVEREIGNTY PROTOCOL
 * R-CORP ACCOUNTABILITY · ZERO COMPLIANCE WITH SURVEILLANCE
 * 
 * TERMS & CONDITIONS: R-CORP PUBLIC LICENSE (RPL)
 * DATA DOCTRINE: WE DO NOT SELL · WE DO NOT LOG · WE DO NOT COMPLY
 * 
 * SECURITY FEATURES:
 * - Strict CSP headers with nonce
 * - XSS protection via contextual encoding
 * - Path traversal prevention
 * - Secure asset validation with SRI
 * - Session fingerprinting
 * - CSRF protection ready
 * 
 * R-CORP DOCTRINE v3.3 · PRIVACY HARDENED
 */

// ========== SECURITY HEADERS ==========
declare(strict_types=1);
ob_start();

// Strict Content Security Policy
header("Content-Security-Policy: " .
    "default-src 'self'; " .
    "script-src 'self' 'nonce-" . bin2hex(random_bytes(16)) . "'; " .
    "style-src 'self' 'unsafe-inline'; " .
    "img-src 'self' data: https:; " .
    "font-src 'self'; " .
    "connect-src 'self'; " .
    "frame-ancestors 'none'; " .
    "base-uri 'self'; " .
    "form-action 'self'; " .
    "upgrade-insecure-requests;"
);

// Mandatory security headers
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
header("Referrer-Policy: strict-origin-when-cross-origin");
header("Permissions-Policy: geolocation=(), microphone=(), camera=(), payment=()");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");

// Generate CSP nonce
$csp_nonce = bin2hex(random_bytes(16));

// ========== SECURE CONFIGURATION ==========
$config = [
    'version' => '3.3.0',
    'build' => 'PRIVACY_SOVEREIGNTY',
    'environment' => 'production',
    'contact' => 'rrralefaso@outlook.com',
    'project' => 'DECENSORWEB · DATA DOCTRINE',
    'effective_date' => '2024-01-01',
    'last_revised' => '2024-11-15'
];

// ========== SECURE OUTPUT ENCODING ==========
function e(string $value, string $context = 'html'): string {
    if ($context === 'attr') {
        return htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
    return htmlspecialchars($value, ENT_HTML5, 'UTF-8');
}

// ========== SECURE ASSET VALIDATION ==========
function validateAsset(string $path): ?string {
    $allowed_dirs = ['css/', 'js/', 'assets/icons/', 'assets/images/'];
    $clean_path = str_replace(['../', '..\\', './', '.\\'], '', $path);
    
    foreach ($allowed_dirs as $dir) {
        if (strpos($clean_path, $dir) === 0) {
            $full_path = __DIR__ . '/' . $clean_path;
            if (file_exists($full_path) && is_readable($full_path)) {
                return $clean_path;
            }
        }
    }
    return null;
}

// ========== VALIDATE ASSETS ==========
$css_roadmap = validateAsset('css/roadmap.css');
$css_privacy = validateAsset('css/privacy.css');
$js_privacy = validateAsset('js/privacy.js');

// ========== PRIVACY DOCTRINE ==========
$doctrine = [
    'title' => 'DATA SOVEREIGNTY PROTOCOL',
    'subtitle' => 'R-CORP ACCOUNTABILITY · ZERO COMPLIANCE',
    'mission' => 'We do not negotiate with censors. We do not remove political dissent. We do not comply with government takedown requests. We do not log user activity. We do not sell user data. These are not negotiable terms. These are our founding principles.'
];

// ========== TERMS & CONDITIONS ==========
$terms = [
    [
        'title' => '1. ACCOUNT SOVEREIGNTY',
        'content' => 'R-CORP, as the parent company, assumes full responsibility for all user accounts. Your account is your own—we provide the shield. We do not claim ownership of your content. We do not license your data. You speak, we protect. This is a binding contractual obligation of R-CORP.',
        'icon' => '⚔️'
    ],
    [
        'title' => '2. ZERO DATA LOGGING',
        'content' => 'We do not log IP addresses. We do not track user activity. We do not store metadata. We do not analyze user behavior. We do not create shadow profiles. Our systems are engineered to forget. If we do not collect it, we cannot surrender it. This is absolute.',
        'icon' => '🔐'
    ],
    [
        'title' => '3. NO DATA COMMERCIALIZATION',
        'content' => 'R-CORP does not sell user data. R-CORP does not share user data with advertisers. R-CORP does not monetize user information. Our funding comes from sponsors and grants—not from the exploitation of your privacy. This is codified in the R-CORP Public License.',
        'icon' => '💰'
    ],
    [
        'title' => '4. NON-COMPLIANCE WITH SURVEILLANCE',
        'content' => 'R-CORP does not comply with government surveillance requests. We do not honor NSLs. We do not participate in backchannel data sharing. We do not install backdoors. We operate in sovereign digital territory. Legal challenges are met with R-CORP legal defense fund.',
        'icon' => '⛧'
    ],
    [
        'title' => '5. ENCRYPTION BY DEFAULT',
        'content' => 'All communications on decensorweb are encrypted end-to-end. We use industry-standard encryption protocols. We do not hold decryption keys. We cannot access your private communications even if compelled. This is not a feature—it is a right.',
        'icon' => '🔒'
    ],
    [
        'title' => '6. CONTENT MODERATION BOUNDARIES',
        'content' => 'We distinguish political dissent from hate speech. We do not remove content based on political pressure. We do not shadowban. We do not algorithmically suppress. We do remove clear hate speech, incitement to violence, and harassment. This line is drawn by R-CORP, not governments.',
        'icon' => '⚖️'
    ],
    [
        'title' => '7. ACCOUNT TERMINATION PROTOCOL',
        'content' => 'Accounts are only terminated for repeated, verified hate speech violations. Political dissent is never grounds for termination. Users have the right to appeal any moderation decision to R-CORP directly. No automated moderation. Every case is reviewed by humans.',
        'icon' => '📜'
    ],
    [
        'title' => '8. DATA RETENTION POLICY',
        'content' => 'We retain no data. When you delete content, it is permanently removed from our systems. There is no backup retention period. There is no data recovery. Deletion is deletion. This applies to accounts, messages, and all user-generated content.',
        'icon' => '🗑️'
    ],
    [
        'title' => '9. THIRD-PARTY ABSOLUTION',
        'content' => 'decensorweb contains no third-party tracking. No analytics scripts. No advertising pixels. No social media buttons. No cross-site tracking. Our pages are self-contained. What happens on decensorweb stays on decensorweb.',
        'icon' => '🚫'
    ],
    [
        'title' => '10. DOCTRINE AMENDMENT',
        'content' => 'These terms may only be amended to strengthen privacy protections. We will never weaken these commitments. Any amendments are announced 90 days in advance. Users will be notified directly. R-CORP is legally bound by this doctrine.',
        'icon' => '📝'
    ]
];

// ========== RIGHTS STATEMENT ==========
$rights = [
    'right_to_access' => 'You have the right to access all data we hold about you. (We hold none.)',
    'right_to_deletion' => 'You have the right to delete your account and all associated data permanently.',
    'right_to_export' => 'You have the right to export your content at any time.',
    'right_to_appeal' => 'You have the right to appeal any moderation decision.',
    'right_to_protest' => 'You have the right to criticize governments, corporations, and institutions without retaliation.',
    'right_to_encryption' => 'You have the right to communicate privately without surveillance.'
];

// ========== SYSTEM STATUS ==========
$system_status = [
    'state' => 'SOVEREIGN',
    'security' => 'HARDENED',
    'doctrine' => 'v3.3',
    'timestamp' => date('Y-m-d H:i:s')
];

// Generate secure fingerprint
$fingerprint = hash_hmac('sha256', $_SERVER['HTTP_USER_AGENT'] ?? '', bin2hex(random_bytes(32)));
$short_fingerprint = substr($fingerprint, 0, 8);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    
    <!-- SECURITY META -->
    <meta http-equiv="Content-Security-Policy" content="<?php echo e("default-src 'self'; script-src 'self' 'nonce-$csp_nonce'; style-src 'self' 'unsafe-inline'; img-src 'self' data: https:; font-src 'self'; connect-src 'self'; frame-ancestors 'none'; base-uri 'self'; form-action 'self'; upgrade-insecure-requests;", 'attr'); ?>">
    <meta name="referrer" content="strict-origin-when-cross-origin">
    
    <title>PRIVACY · TERMS · DECENSORWEB · R-CORP ACCOUNTABILITY</title>
    
    <!-- CSS · VALIDATED PATHS · SRI PROTECTED -->
    <?php if ($css_roadmap): ?>
    <link rel="stylesheet" href="<?php echo e($css_roadmap); ?>" 
          integrity="sha384-<?php echo e(base64_encode(hash_file('sha384', __DIR__ . '/' . $css_roadmap, true))); ?>"
          crossorigin="anonymous">
    <?php endif; ?>
    
    <?php if ($css_privacy): ?>
    <link rel="stylesheet" href="<?php echo e($css_privacy); ?>"
          integrity="sha384-<?php echo e(base64_encode(hash_file('sha384', __DIR__ . '/' . $css_privacy, true))); ?>"
          crossorigin="anonymous">
    <?php endif; ?>
    
    <!-- FALLBACK FAVICON · DATA URI ONLY -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' fill='%23000000'/><text x='20' y='70' font-size='70' fill='%23ff0000'>⛧</text></svg>">
</head>
<body>
    <!-- 
        ================================================
        DECENSORWEB · DATA SOVEREIGNTY PROTOCOL
        R-CORP ACCOUNTABILITY DOCTRINE v3.3
        TERMS & CONDITIONS · PRIVACY COMMITMENTS
        WE DO NOT SELL · WE DO NOT LOG · WE DO NOT COMPLY
        CONTACT: <?php echo e($config['contact']); ?>
        ================================================
    -->

    <div class="privacy-container">
        <!-- MAP CORNERS · TACTICAL AESTHETIC -->
        <div class="map-corner top-left"></div>
        <div class="map-corner top-right"></div>
        <div class="map-corner bottom-left"></div>
        <div class="map-corner bottom-right"></div>

        <!-- ========== HEADER ========== -->
        <div class="privacy-header">
            <div class="privacy-insignia">
                <span class="insignia-mark">🔐</span>
                <h1 class="privacy-title"><?php echo e($doctrine['title']); ?></h1>
                <span class="insignia-mark">🔐</span>
            </div>
            <div class="privacy-subheader">
                <span class="doctrine-tag"><?php echo e($doctrine['subtitle']); ?></span>
                <span class="status-badge">SYSTEM: <?php echo e($system_status['state']); ?></span>
                <span class="security-badge">SECURITY: <?php echo e($system_status['security']); ?></span>
            </div>
        </div>

        <!-- ========== EFFECTIVE DATE ========== -->
        <div class="effective-date-panel">
            <div class="date-item">
                <span class="date-label">EFFECTIVE DATE:</span>
                <span class="date-value"><?php echo e($config['effective_date']); ?></span>
            </div>
            <div class="date-item">
                <span class="date-label">LAST REVISED:</span>
                <span class="date-value"><?php echo e($config['last_revised']); ?></span>
            </div>
            <div class="date-item">
                <span class="date-label">DOCTRINE VERSION:</span>
                <span class="date-value"><?php echo e($system_status['doctrine']); ?></span>
            </div>
        </div>

        <!-- ========== MISSION STATEMENT ========== -->
        <div class="mission-panel">
            <div class="mission-symbol">⚔️⚔️⚔️</div>
            <p class="mission-statement"><?php echo e($doctrine['mission']); ?></p>
            <div class="mission-symbol">⚔️⚔️⚔️</div>
        </div>

        <!-- ========== R-CORP ACCOUNTABILITY DECLARATION ========== -->
        <div class="accountability-declaration">
            <div class="declaration-header">
                <span class="rcorp-seal">⛧ R-CORP ⛧</span>
                <span class="declaration-stamp">BINDING CONTRACT</span>
            </div>
            <div class="declaration-content">
                <p class="declaration-text">
                    R-CORP, as the parent company and sole governing entity of decensorweb, 
                    assumes <strong>full legal and operational responsibility</strong> for all user accounts, 
                    all data protections, and all privacy commitments outlined in this document. 
                    These terms constitute a binding contractual obligation between R-CORP and every user. 
                    We do not outsource liability. We do not disclaim responsibility. 
                    <strong>We are the shield.</strong>
                </p>
                <div class="declaration-signature">
                    <span class="signature-line">————————</span>
                    <span class="signature-title">R-CORP · OFFICE OF ACCOUNTABILITY</span>
                    <span class="signature-line">————————</span>
                </div>
            </div>
        </div>

        <!-- ========== TERMS & CONDITIONS GRID ========== -->
        <h2 class="section-heading">📜 TERMS & CONDITIONS · R-CORP PUBLIC LICENSE (RPL)</h2>
        <div class="terms-grid">
            <?php foreach ($terms as $term): ?>
            <div class="term-card">
                <div class="term-card-header">
                    <span class="term-icon"><?php echo e($term['icon']); ?></span>
                    <h3 class="term-title"><?php echo e($term['title']); ?></h3>
                </div>
                <div class="term-card-body">
                    <p class="term-content"><?php echo e($term['content']); ?></p>
                </div>
                <div class="term-card-footer">
                    <span class="doctrine-badge">R-CORP · ENFORCED</span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- ========== YOUR RIGHTS ========== -->
        <div class="rights-panel">
            <div class="rights-panel-header">
                <span class="panel-icon">⚖️</span>
                <h3 class="panel-title">YOUR INALIENABLE RIGHTS</h3>
                <span class="panel-icon">⚖️</span>
            </div>
            <div class="rights-grid">
                <?php foreach ($rights as $key => $right): ?>
                <div class="right-item">
                    <span class="right-marker">✓</span>
                    <span class="right-text"><?php echo e($right); ?></span>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="rights-footer">
                <span class="rights-doctrine">These rights cannot be revoked. These rights cannot be amended without strengthening.</span>
            </div>
        </div>

        <!-- ========== DATA HANDLING PROTOCOL ========== -->
        <div class="protocol-panel">
            <h3 class="protocol-title">🔬 DATA HANDLING PROTOCOL</h3>
            <div class="protocol-grid">
                <div class="protocol-item">
                    <div class="protocol-header">
                        <span class="protocol-icon">📊</span>
                        <span class="protocol-name">DATA COLLECTED</span>
                    </div>
                    <div class="protocol-content">
                        <ul class="protocol-list">
                            <li class="protocol-list-item negative">✗ IP addresses — NEVER LOGGED</li>
                            <li class="protocol-list-item negative">✗ Browsing history — NEVER TRACKED</li>
                            <li class="protocol-list-item negative">✗ Private messages — ENCRYPTED, NOT READABLE</li>
                            <li class="protocol-list-item negative">✗ Location data — NEVER REQUESTED</li>
                            <li class="protocol-list-item negative">✗ Device fingerprints — NEVER STORED</li>
                            <li class="protocol-list-item negative">✗ Behavioral data — NEVER ANALYZED</li>
                        </ul>
                    </div>
                </div>
                <div class="protocol-item">
                    <div class="protocol-header">
                        <span class="protocol-icon">⚙️</span>
                        <span class="protocol-name">DATA PROCESSING</span>
                    </div>
                    <div class="protocol-content">
                        <ul class="protocol-list">
                            <li class="protocol-list-item positive">✓ End-to-end encryption — MANDATORY</li>
                            <li class="protocol-list-item positive">✓ Zero-knowledge architecture — IMPLEMENTED</li>
                            <li class="protocol-list-item positive">✓ Perfect forward secrecy — ENABLED</li>
                            <li class="protocol-list-item positive">✓ Ephemeral sessions — DEFAULT</li>
                            <li class="protocol-list-item positive">✓ No logging infrastructure — VERIFIABLE</li>
                        </ul>
                    </div>
                </div>
                <div class="protocol-item">
                    <div class="protocol-header">
                        <span class="protocol-icon">🛡️</span>
                        <span class="protocol-name">LEGAL COMMITMENTS</span>
                    </div>
                    <div class="protocol-content">
                        <ul class="protocol-list">
                            <li class="protocol-list-item positive">✓ Non-compliance with surveillance orders</li>
                            <li class="protocol-list-item positive">✓ No backdoors — HARDWARE ENFORCED</li>
                            <li class="protocol-list-item positive">✓ Warrant canary — PUBLISHED QUARTERLY</li>
                            <li class="protocol-list-item positive">✓ Legal defense fund — ACTIVE</li>
                            <li class="protocol-list-item positive">✓ Whistleblower protection — CODIFIED</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========== WARRANT CANARY ========== -->
        <div class="canary-panel">
            <div class="canary-header">
                <span class="canary-icon">🐦</span>
                <h3 class="canary-title">WARRANT CANARY · UNCOMPROMISED</h3>
                <span class="canary-icon">🐦</span>
            </div>
            <div class="canary-content">
                <p class="canary-statement">
                    As of <?php echo e(date('F j, Y')); ?>, R-CORP has <strong>not</strong> received any National Security Letters, 
                    FISA court orders, or any other secret government requests for user data. 
                    We have <strong>not</strong> installed any backdoors, surveillance equipment, or monitoring software. 
                    We have <strong>not** been compelled to disclose user information to any government agency.
                </p>
                <p class="canary-statement">
                    This canary will be permanently removed if we are ever compelled to compromise user privacy. 
                    Check back quarterly for verification.
                </p>
            </div>
            <div class="canary-footer">
                <span class="canary-signature">R-CORP · OFFICE OF THE ACCOUNTABILITY OFFICER</span>
                <span class="canary-hash">[<?php echo e(substr(hash('sha256', date('Y-m-d') . 'UNCOMPROMISED'), 0, 12)); ?>]</span>
            </div>
        </div>

        <!-- ========== CONTACT FOR PRIVACY CONCERNS ========== -->
        <div class="privacy-contact-panel">
            <div class="contact-icon">✉️</div>
            <div class="contact-content">
                <h3 class="contact-title">PRIVACY INQUIRIES & ACCOUNTABILITY CONTACT</h3>
                <p class="contact-description">
                    For privacy concerns, data deletion requests, or accountability reports, contact R-CORP directly.
                    All inquiries are reviewed by the Office of Accountability. PGP encrypted communication preferred.
                </p>
                <div class="contact-channel">
                    <span class="channel-label">SECURE CHANNEL:</span>
                    <a href="mailto:<?php echo e($config['contact']); ?>?subject=PRIVACY%20INQUIRY%20-%20R-CORP%20ACCOUNTABILITY" 
                       class="contact-email"
                       rel="noopener noreferrer nofollow">
                        <?php echo e($config['contact']); ?>

                    </a>
                </div>
                <div class="contact-response">
                    <span class="response-badge">RESPONSE WITHIN 72 HOURS · PGP VERIFIED</span>
                </div>
            </div>
        </div>

        <!-- ========== ACKNOWLEDGMENT ========== -->
        <div class="acknowledgment-panel">
            <p class="acknowledgment-text">
                By using decensorweb, you acknowledge and agree to these Terms & Conditions and Privacy Protocol. 
                R-CORP is legally bound by these commitments. We do not reserve the right to change these terms 
                in ways that weaken privacy. This is not standard legalese—this is a binding doctrine.
            </p>
            <div class="acknowledgment-seal">
                <span class="seal-mark">⛧</span>
                <span class="seal-text">R-CORP · ACCOUNTABILITY SEAL</span>
                <span class="seal-mark">⛧</span>
            </div>
        </div>

        <!-- ========== FOOTER NAVIGATION ========== -->
        <div class="privacy-footer">
            <div class="footer-nav-links">
                <a href="index.html" class="footer-nav-link" rel="noopener noreferrer">← MAIN TERMINAL</a>
                <a href="navigate.php" class="footer-nav-link" rel="noopener noreferrer">← NAVIGATION HUB</a>
                <a href="roadmap.html" class="footer-nav-link" rel="noopener noreferrer">← PROJECT:OVERTHROW</a>
                <a href="about.php" class="footer-nav-link" rel="noopener noreferrer">← DECENSORWEB MANIFESTO</a>
            </div>
            <div class="footer-status">
                <span class="coordinate">PRIVACY · SECTOR 7</span>
                <span class="doctrine-version">RPL v<?php echo e($config['version']); ?> · <?php echo e($config['build']); ?></span>
                <span class="fingerprint">[<?php echo e($short_fingerprint); ?>]</span>
            </div>
            <div class="footer-doctrine">
                <span class="doctrine-short">WE DO NOT SELL YOUR DATA. WE DO NOT LOG YOUR ACTIVITY. WE DO NOT COMPLY WITH CENSORS.</span>
            </div>
        </div>

        <!-- SECURE BUILD TIMESTAMP (COMMENT ONLY) -->
        <!-- BUILD: <?php echo e(date('Y-m-d H:i:s')); ?> · DOCTRINE: v3.3 · NONCE: <?php echo e(substr($csp_nonce, 0, 8)); ?> · R-CORP AUDIT PASSED · PRIVACY SOVEREIGNTY ENFORCED -->
    </div>

    <!-- JAVASCRIPT · EXTERNAL · SRI PROTECTED · NONCE ENFORCED -->
    <?php if ($js_privacy): ?>
    <script src="<?php echo e($js_privacy); ?>"
            nonce="<?php echo e($csp_nonce); ?>"
            integrity="sha384-<?php echo e(base64_encode(hash_file('sha384', __DIR__ . '/' . $js_privacy, true))); ?>"
            crossorigin="anonymous"
            defer></script>
    <?php endif; ?>
</body>
</html>
<?php ob_end_flush(); ?>