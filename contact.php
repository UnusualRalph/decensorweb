<?php
/**
 * CONTACT.PHP · DECENSORWEB SECURE COMMUNICATIONS CHANNEL
 * R-CORP ACCOUNTABILITY · ENCRYPTED CONTACT PROTOCOL
 * 
 * CONTACT DETAILS:
 * - EMAIL: rrralefaso@outlook.com
 * - GITHUB: rr-ralefaso
 * - INSTAGRAM: @unusualralph
 * - SPONSOR: GitHub Sponsors
 * 
 * SECURITY FEATURES:
 * - Strict CSP headers with nonce
 * - XSS protection via contextual encoding
 * - Path traversal prevention
 * - Secure asset validation with SRI
 * - Session fingerprinting
 * - PGP encryption recommended
 * 
 * R-CORP DOCTRINE v3.4 · CONTACT HARDENED
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
    'version' => '3.4.0',
    'build' => 'CONTACT_HARDENED',
    'environment' => 'production',
    'project' => 'DECENSORWEB · SECURE CONTACT PROTOCOL',
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
$css_contact = validateAsset('css/contact.css');
$js_contact = validateAsset('js/contact.js');

// ========== CONTACT INFORMATION ==========
$contact = [
    'email' => 'rrralefaso@outlook.com',
    'github' => 'rr-ralefaso',
    'github_url' => 'https://github.com/rr-ralefaso',
    'github_sponsors' => 'https://github.com/sponsors/RR-Ralefaso',
    'instagram' => '@unusualralph',
    'instagram_url' => 'https://instagram.com/unusualralph',
    'instagram_handle' => 'unusualralph',
    'pgp_fingerprint' => 'R-CORP · SECURE CHANNEL · PGP KEY AVAILABLE ON REQUEST'
];

// ========== SPONSORSHIP TIERS ==========
$sponsorship_tiers = [
    [
        'name' => 'RESISTANCE SUPPORTER',
        'amount' => '$5/month',
        'description' => 'Fund server infrastructure and basic operations. Every contribution strengthens the network.',
        'icon' => '⚡'
    ],
    [
        'name' => 'DIGITAL FREEDOM GUARDIAN',
        'amount' => '$20/month',
        'description' => 'Support encryption tooling, security audits, and legal defense preparedness.',
        'icon' => '🛡️'
    ],
    [
        'name' => 'SOVEREIGNTY PROTECTOR',
        'amount' => '$50/month',
        'description' => 'Sustain long-term platform independence and R-CORP accountability operations.',
        'icon' => '⚔️'
    ]
];

// ========== COMMUNICATION CHANNELS ==========
$channels = [
    [
        'name' => 'SECURE EMAIL',
        'value' => 'rrralefaso@outlook.com',
        'url' => 'mailto:rrralefaso@outlook.com',
        'icon' => '✉️',
        'description' => 'Primary contact channel. PGP encrypted communication strongly preferred.',
        'security' => 'PGP ENCRYPTED · TLS 1.3',
        'response' => '72 HOURS'
    ],
    [
        'name' => 'GITHUB',
        'value' => 'rr-ralefaso',
        'url' => 'https://github.com/rr-ralefaso',
        'icon' => '⌨️',
        'description' => 'Project repository, issue tracking, code contributions, and security disclosures.',
        'security' => '2FA REQUIRED · SIGNED COMMITS',
        'response' => '48 HOURS'
    ],
    [
        'name' => 'INSTAGRAM',
        'value' => '@unusualralph',
        'url' => 'https://instagram.com/unusualralph',
        'icon' => '📷',
        'description' => 'Project updates, censorship resistance news, and community announcements.',
        'security' => 'DIRECT MESSAGES MONITORED',
        'response' => '24-48 HOURS'
    ]
];

// ========== SYSTEM STATUS ==========
$system_status = [
    'state' => 'OPERATIONAL',
    'security' => 'HARDENED',
    'doctrine' => 'v3.4',
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
    
    <title>CONTACT · SECURE CHANNELS · DECENSORWEB · R-CORP</title>
    
    <!-- CSS · VALIDATED PATHS · SRI PROTECTED -->
    <?php if ($css_roadmap): ?>
    <link rel="stylesheet" href="<?php echo e($css_roadmap); ?>" 
          integrity="sha384-<?php echo e(base64_encode(hash_file('sha384', __DIR__ . '/' . $css_roadmap, true))); ?>"
          crossorigin="anonymous">
    <?php endif; ?>
    
    <?php if ($css_contact): ?>
    <link rel="stylesheet" href="<?php echo e($css_contact); ?>"
          integrity="sha384-<?php echo e(base64_encode(hash_file('sha384', __DIR__ . '/' . $css_contact, true))); ?>"
          crossorigin="anonymous">
    <?php endif; ?>
    
    <!-- FALLBACK FAVICON · DATA URI ONLY -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' fill='%23000000'/><text x='20' y='70' font-size='70' fill='%23ff0000'>⛧</text></svg>">
</head>
<body>
    <!-- 
        ================================================
        DECENSORWEB · SECURE COMMUNICATIONS CHANNEL
        R-CORP ACCOUNTABILITY DOCTRINE v3.4
        ENCRYPTED CONTACT PROTOCOL · PGP PREFERRED
        CONTACT: rrralefaso@outlook.com
        GITHUB: rr-ralefaso
        INSTAGRAM: @unusualralph
        ================================================
    -->

    <div class="contact-container">
        <!-- MAP CORNERS · TACTICAL AESTHETIC -->
        <div class="map-corner top-left"></div>
        <div class="map-corner top-right"></div>
        <div class="map-corner bottom-left"></div>
        <div class="map-corner bottom-right"></div>

        <!-- ========== HEADER ========== -->
        <div class="contact-header">
            <div class="contact-insignia">
                <span class="insignia-mark">✉️</span>
                <h1 class="contact-title">SECURE CONTACT PROTOCOL</h1>
                <span class="insignia-mark">🔐</span>
            </div>
            <div class="contact-subheader">
                <span class="doctrine-tag">R-CORP · ACCOUNTABLE</span>
                <span class="status-badge">SYSTEM: <?php echo e($system_status['state']); ?></span>
                <span class="security-badge">SECURITY: <?php echo e($system_status['security']); ?></span>
            </div>
        </div>

        <!-- ========== PGP NOTICE ========== -->
        <div class="pgp-notice-panel">
            <div class="pgp-icon">🔑</div>
            <div class="pgp-content">
                <h3 class="pgp-title">PGP ENCRYPTED COMMUNICATION PREFERRED</h3>
                <p class="pgp-statement">
                    For sensitive communications, security disclosures, or confidential collaboration, 
                    PGP encryption is strongly preferred. R-CORP maintains zero-access encryption 
                    standards. Key fingerprint available upon request via established channels.
                </p>
                <div class="pgp-fingerprint">
                    <span class="fingerprint-label">PGP FINGERPRINT:</span>
                    <span class="fingerprint-value">[REQUEST VIA SECURE CHANNEL]</span>
                </div>
            </div>
        </div>

        <!-- ========== COMMUNICATIONS GRID ========== -->
        <h2 class="section-heading">📡 COMMUNICATIONS CHANNELS</h2>
        <div class="channels-grid">
            <?php foreach ($channels as $channel): ?>
            <div class="channel-card">
                <div class="channel-card-header" style="border-left-color: #8b0000;">
                    <span class="channel-icon"><?php echo e($channel['icon']); ?></span>
                    <h3 class="channel-title"><?php echo e($channel['name']); ?></h3>
                </div>
                <div class="channel-card-body">
                    <p class="channel-description"><?php echo e($channel['description']); ?></p>
                    
                    <div class="channel-contact">
                        <span class="contact-label">CONTACT:</span>
                        <a href="<?php echo e($channel['url']); ?>" 
                           class="contact-link"
                           rel="noopener noreferrer nofollow"
                           target="<?php echo e($channel['name'] === 'SECURE EMAIL' ? '_self' : '_blank'); ?>">
                            <?php echo e($channel['value']); ?>

                        </a>
                    </div>
                    
                    <div class="channel-security">
                        <span class="security-label">SECURITY:</span>
                        <span class="security-value"><?php echo e($channel['security']); ?></span>
                    </div>
                    
                    <div class="channel-response">
                        <span class="response-label">RESPONSE:</span>
                        <span class="response-value"><?php echo e($channel['response']); ?></span>
                    </div>
                </div>
                <div class="channel-card-footer">
                    <span class="channel-doctrine">R-CORP · VERIFIED</span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- ========== SPONSORSHIP SECTION ========== -->
        <div class="sponsorship-panel">
            <div class="sponsorship-header">
                <span class="sponsor-icon">⚡</span>
                <h2 class="sponsorship-title">SPONSOR THE RESISTANCE</h2>
                <span class="sponsor-icon">⚡</span>
            </div>
            
            <p class="sponsorship-mission">
                Decensorweb is a free, independent platform. No investors. No advertisers. 
                No data monetization. We are sustained entirely by community sponsorship. 
                Your contribution directly funds server infrastructure, encryption tooling, 
                security audits, and legal defense. Every sponsor strengthens the network.
            </p>
            
            <div class="sponsorship-grid">
                <?php foreach ($sponsorship_tiers as $tier): ?>
                <div class="sponsorship-card">
                    <div class="sponsorship-card-header">
                        <span class="tier-icon"><?php echo e($tier['icon']); ?></span>
                        <h3 class="tier-name"><?php echo e($tier['name']); ?></h3>
                        <span class="tier-amount"><?php echo e($tier['amount']); ?></span>
                    </div>
                    <div class="sponsorship-card-body">
                        <p class="tier-description"><?php echo e($tier['description']); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="sponsorship-cta">
                <a href="<?php echo e($contact['github_sponsors']); ?>" 
                   target="_blank"
                   rel="noopener noreferrer nofollow"
                   class="sponsorship-button">
                    ⚡ BECOME A SPONSOR ON GITHUB ⚡
                </a>
                <p class="sponsorship-note">
                    All sponsorships are processed through GitHub Sponsors. 
                    R-CORP maintains no access to your payment information.
                </p>
            </div>
        </div>

        <!-- ========== GITHUB PROJECT STATUS ========== -->
        <div class="github-panel">
            <div class="github-header">
                <span class="github-icon">⌨️</span>
                <h3 class="github-title">PROJECT REPOSITORY</h3>
                <span class="github-icon">⌨️</span>
            </div>
            
            <div class="github-content">
                <div class="github-profile">
                    <span class="profile-label">GITHUB:</span>
                    <a href="<?php echo e($contact['github_url']); ?>" 
                       target="_blank"
                       rel="noopener noreferrer nofollow"
                       class="profile-link">
                        github.com/<?php echo e($contact['github']); ?>

                    </a>
                </div>
                
                <div class="github-stats">
                    <div class="stat-item">
                        <span class="stat-label">REPOSITORY:</span>
                        <span class="stat-value">decensorweb · PRIVATE</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">CONTRIBUTIONS:</span>
                        <span class="stat-value">OPEN · WELCOME</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">SECURITY:</span>
                        <span class="stat-value">SIGNED COMMITS · 2FA REQUIRED</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">ISSUES:</span>
                        <span class="stat-value">PUBLIC · RESPONSIBLE DISCLOSURE</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========== INSTAGRAM COMMUNITY ========== -->
        <div class="instagram-panel">
            <div class="instagram-header">
                <span class="instagram-icon">📷</span>
                <h3 class="instagram-title">COMMUNITY & UPDATES</h3>
                <span class="instagram-icon">📷</span>
            </div>
            
            <div class="instagram-content">
                <div class="instagram-profile">
                    <span class="profile-label">INSTAGRAM:</span>
                    <a href="<?php echo e($contact['instagram_url']); ?>" 
                       target="_blank"
                       rel="noopener noreferrer nofollow"
                       class="profile-link">
                        instagram.com/<?php echo e($contact['instagram_handle']); ?>

                    </a>
                    <span class="profile-handle"><?php echo e($contact['instagram']); ?></span>
                </div>
                
                <div class="instagram-description">
                    <p class="instagram-statement">
                        Follow for project announcements, censorship resistance news, 
                        digital sovereignty updates, and community engagement. 
                        Direct messages are monitored for legitimate collaboration inquiries.
                    </p>
                </div>
                
                <div class="instagram-guidelines">
                    <span class="guidelines-title">COMMUNITY GUIDELINES:</span>
                    <ul class="guidelines-list">
                        <li>✹ Political dissent welcomed · Hate speech not tolerated</li>
                        <li>✹ Encryption advocacy · Privacy education</li>
                        <li>✹ No harassment · No doxxing · No threats</li>
                        <li>✹ R-CORP accountability always</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- ========== RESPONSE COMMITMENT ========== -->
        <div class="response-commitment-panel">
            <div class="commitment-header">
                <span class="commitment-icon">⏱️</span>
                <h3 class="commitment-title">RESPONSE COMMITMENT</h3>
                <span class="commitment-icon">⏱️</span>
            </div>
            
            <div class="commitment-content">
                <div class="commitment-grid">
                    <div class="commitment-item">
                        <span class="commitment-channel">SECURE EMAIL</span>
                        <span class="commitment-time">72 HOURS</span>
                        <span class="commitment-priority">PGP PREFERRED</span>
                    </div>
                    <div class="commitment-item">
                        <span class="commitment-channel">GITHUB</span>
                        <span class="commitment-time">48 HOURS</span>
                        <span class="commitment-priority">SECURITY ISSUES PRIORITY</span>
                    </div>
                    <div class="commitment-item">
                        <span class="commitment-channel">INSTAGRAM DM</span>
                        <span class="commitment-time">24-48 HOURS</span>
                        <span class="commitment-priority">COLLABORATION INQUIRIES</span>
                    </div>
                </div>
                <p class="commitment-note">
                    R-CORP is committed to timely, secure, and accountable communication. 
                    All channels are monitored by the Office of Accountability. 
                    Encrypted communication always takes precedence.
                </p>
            </div>
        </div>

        <!-- ========== R-CORP ACCOUNTABILITY DECLARATION ========== -->
        <div class="accountability-declaration">
            <div class="declaration-header">
                <span class="rcorp-seal">⛧ R-CORP ⛧</span>
                <span class="declaration-stamp">ACCOUNTABILITY DOCTRINE</span>
            </div>
            <div class="declaration-content">
                <p class="declaration-text">
                    R-CORP, as the parent company and sole governing entity of decensorweb, 
                    assumes full responsibility for all communications received through these channels. 
                    Your inquiries are protected. Your disclosures are secure. Your identity is your own.
                    We do not share contact information. We do not monitor private channels without consent.
                    <strong>We are the shield.</strong>
                </p>
                <div class="declaration-signature">
                    <span class="signature-line">————————</span>
                    <span class="signature-title">R-CORP · OFFICE OF ACCOUNTABILITY</span>
                    <span class="signature-line">————————</span>
                </div>
            </div>
        </div>

        <!-- ========== QUICK CONTACT REFERENCE ========== -->
        <div class="quick-reference-panel">
            <h3 class="reference-title">⚡ QUICK CONTACT REFERENCE</h3>
            <div class="reference-grid">
                <div class="reference-item">
                    <span class="reference-icon">✉️</span>
                    <span class="reference-label">EMAIL:</span>
                    <span class="reference-value"><?php echo e($contact['email']); ?></span>
                </div>
                <div class="reference-item">
                    <span class="reference-icon">⌨️</span>
                    <span class="reference-label">GITHUB:</span>
                    <span class="reference-value"><?php echo e($contact['github']); ?></span>
                </div>
                <div class="reference-item">
                    <span class="reference-icon">📷</span>
                    <span class="reference-label">INSTAGRAM:</span>
                    <span class="reference-value"><?php echo e($contact['instagram']); ?></span>
                </div>
                <div class="reference-item">
                    <span class="reference-icon">⚡</span>
                    <span class="reference-label">SPONSOR:</span>
                    <span class="reference-value">GitHub Sponsors</span>
                </div>
            </div>
        </div>

        <!-- ========== FOOTER NAVIGATION ========== -->
        <div class="contact-footer">
            <div class="footer-nav-links">
                <a href="index.html" class="footer-nav-link" rel="noopener noreferrer">← MAIN TERMINAL</a>
                <a href="navigate.php" class="footer-nav-link" rel="noopener noreferrer">← NAVIGATION HUB</a>
                <a href="roadmap.html" class="footer-nav-link" rel="noopener noreferrer">← PROJECT:OVERTHROW</a>
                <a href="about.php" class="footer-nav-link" rel="noopener noreferrer">← DECENSORWEB</a>
                <a href="privacy.php" class="footer-nav-link" rel="noopener noreferrer">← PRIVACY</a>
            </div>
            <div class="footer-status">
                <span class="coordinate">CONTACT · SECTOR 7</span>
                <span class="doctrine-version">v<?php echo e($config['version']); ?> · <?php echo e($config['build']); ?></span>
                <span class="fingerprint">[<?php echo e($short_fingerprint); ?>]</span>
            </div>
            <div class="footer-doctrine">
                <span class="doctrine-short">ENCRYPTED · ACCOUNTABLE · SOVEREIGN</span>
            </div>
        </div>

        <!-- SECURE BUILD TIMESTAMP (COMMENT ONLY) -->
        <!-- BUILD: <?php echo e(date('Y-m-d H:i:s')); ?> · CONTACT: rrralefaso@outlook.com · GITHUB: rr-ralefaso · INSTAGRAM: @unusualralph · NONCE: <?php echo e(substr($csp_nonce, 0, 8)); ?> · R-CORP AUDIT PASSED -->
    </div>

    <!-- JAVASCRIPT · EXTERNAL · SRI PROTECTED · NONCE ENFORCED -->
    <?php if ($js_contact): ?>
    <script src="<?php echo e($js_contact); ?>"
            nonce="<?php echo e($csp_nonce); ?>"
            integrity="sha384-<?php echo e(base64_encode(hash_file('sha384', __DIR__ . '/' . $js_contact, true))); ?>"
            crossorigin="anonymous"
            defer></script>
    <?php endif; ?>
</body>
</html>
<?php ob_end_flush(); ?>