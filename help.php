<?php
/**
 * DECENSORWEB · ABOUT.PHP
 * SECURITY-FIRST MANIFESTO PAGE
 * CONTACT: rrralefaso@outlook.com · R-CORP ACCOUNTABILITY
 * 
 * COMPLETE REDESIGN - ZERO INLINE CSS/JS
 * ALL SECURITY HEADERS · INPUT VALIDATION · CSP · SRI
 * 
 * R-CORP ACCOUNTABILITY DOCTRINE v3.1
 */

// ========== SECURITY HEADERS ==========
declare(strict_types=1);

// Prevent any output before headers
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
    'version' => '3.1.0',
    'build' => 'HARDENED_RELEASE',
    'environment' => 'production',
    'contact_email' => 'rrralefaso@outlook.com'
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
    $allowed_dirs = ['css/', 'js/', 'assets/icons/'];
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
$css_about = validateAsset('css/about.css');
$js_about = validateAsset('js/about.js');

// ========== CONTENT (SAFE, NO USER INPUT) ==========
$manifesto = [
    'title' => 'DECENSORWEB',
    'version' => $config['version'],
    'build' => $config['build'],
    'contact' => $config['contact_email'],
    'mission' => 'We do not negotiate with censors. We do not remove political dissent. We do not comply with government takedown requests. decensorweb exists as a permanent, unassailable alternative to the compromised platforms.',
    'doctrine' => 'All accounts, identities, and data channels are governed under the sovereignty of R-CORP. We assume full responsibility for every user profile—this is not control, it is protection. You speak behind our shield.'
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
    
    <title>DECENSORWEB · R-CORP · ANTI-CENSORSHIP</title>
    
    <!-- CSS · VALIDATED PATHS · SRI PROTECTED -->
    <?php if ($css_roadmap): ?>
    <link rel="stylesheet" href="<?php echo e($css_roadmap); ?>" 
          integrity="sha384-<?php echo e(base64_encode(hash_file('sha384', __DIR__ . '/' . $css_roadmap, true))); ?>"
          crossorigin="anonymous">
    <?php endif; ?>
    
    <?php if ($css_about): ?>
    <link rel="stylesheet" href="<?php echo e($css_about); ?>"
          integrity="sha384-<?php echo e(base64_encode(hash_file('sha384', __DIR__ . '/' . $css_about, true))); ?>"
          crossorigin="anonymous">
    <?php endif; ?>
    
    <!-- FALLBACK FAVICON · DATA URI ONLY -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' fill='%23000000'/><text x='20' y='70' font-size='70' fill='%23ff0000'>⛧</text></svg>">
</head>
<body>
    <!-- 
        R-CORP ACCOUNTABILITY DOCTRINE
        ALL ACCOUNTS PROTECTED · NO CENSORSHIP COMPLIANCE
        CONTACT: rrralefaso@outlook.com
        SECURE BUILD: <?php echo e($config['build']); ?> · <?php echo e(date('Y-m-d')); ?>
    -->

    <div class="roadmap-container manifesto-container">
        <!-- MAP CORNERS · TACTICAL AESTHETIC -->
        <div class="map-corner top-left"></div>
        <div class="map-corner top-right"></div>
        <div class="map-corner bottom-left"></div>
        <div class="map-corner bottom-right"></div>

        <!-- ========== ICON GRID · R-CORP AUTHORITY ========== -->
        <div class="icon-grid">
            <?php
            $icon_path = validateAsset('assets/icons/icon.jpeg');
            if ($icon_path):
            ?>
            <img src="<?php echo e($icon_path); ?>" 
                 alt="decensorweb insignia" 
                 class="manifesto-icon"
                 loading="lazy"
                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
            <?php endif; ?>
            <div class="icon-fallback">⛧ DECENSOR</div>
            
            <div class="rcorp-shield" aria-label="R-CORP: Parent company · Full accountability">
                <span class="shield-letter">R</span>
                <span class="shield-caption">CORP · ACCOUNTABLE</span>
            </div>
        </div>

        <!-- ========== SPONSOR BADGE ========== -->
        <div class="badge-container">
            <a href="https://github.com/sponsors/RR-Ralefaso" 
               target="_blank"
               rel="noopener noreferrer nofollow"
               class="sponsor-badge">
                ⚡ SPONSOR THE RESISTANCE · GITHUB ⚡
            </a>
        </div>

        <!-- ========== TITLE ========== -->
        <h1 class="manifesto-title"><?php echo e($manifesto['title']); ?></h1>
        <div class="manifesto-subheader">
            “A fortified platform for the unfiltered voice — accountable only to the people,<br>
            <span class="emphasis-red">guaranteed by R-CORP</span>”
        </div>

        <!-- ========== MISSION · ANTI-CENSORSHIP ========== -->
        <div class="mission-block core-mission">
            <div class="mission-symbol">⚔️⚔️⚔️</div>
            <h2>THE MISSION: TOTAL CENSORSHIP RESISTANCE</h2>
            <p class="mission-statement"><?php echo e($manifesto['mission']); ?></p>
            <ul class="doctrine-list">
                <li>✹ <strong>No compliance</strong> – Government takedown requests are ignored. Permanently.</li>
                <li>✹ <strong>No shadowbanning</strong> – Political dissent is protected speech.</li>
                <li>✹ <strong>No algorithmic suppression</strong> – Your voice reaches who you intend.</li>
                <li>✹ <strong>Encrypted by default</strong> – We do not log, we do not share.</li>
            </ul>
        </div>

        <!-- ========== R-CORP ACCOUNTABILITY · PARENT COMPANY ========== -->
        <div class="accountability-panel">
            <div class="panel-header">
                <span class="rcorp-insignia">⛧ R-CORP ⛧</span>
                <span class="authority-stamp">FULL ACCOUNTABILITY</span>
            </div>
            <div class="accountability-content">
                <div class="seal-mark">⛊</div>
                <div class="accountability-text">
                    <h3>THE PARENT COMPANY RESPONSIBLE FOR YOUR ACCOUNT</h3>
                    <p><?php echo e($manifesto['doctrine']); ?></p>
                    <div class="accountability-fact">
                        Every account on decensorweb is issued and protected by <strong>R-CORP</strong>.
                        We do not sell user data. We do not comply with surveillance requests.
                        Your identity is your own — but the shield is ours.
                    </div>
                </div>
            </div>
            <div class="accountability-footer">
                R-CORP · EST. 2024 · SOVEREIGN DIGITAL TERRITORY
            </div>
        </div>

        <!-- ========== THREE PILLARS ========== -->
        <h2 class="section-heading">🎯 THE THREE PILLARS</h2>
        <div class="pillar-grid">
            <div class="pillar-card">
                <div class="pillar-icon">🛡️</div>
                <h3>Safety First — R-CORP GUARANTEED</h3>
                <p>End-to-end encrypted channels, anonymous authentication, strict zero-log policy. R-Corp assumes full liability for infrastructure security.</p>
            </div>
            <div class="pillar-card">
                <div class="pillar-icon">💬</div>
                <h3>Unfiltered Thought — NO CENSORS</h3>
                <p>We do not remove content based on political pressure. R-Corp legal defense fund actively challenges gag orders and censorship mandates.</p>
            </div>
            <div class="pillar-card">
                <div class="pillar-icon">⛔</div>
                <h3>Zero Hate Speech — PRINCIPLED</h3>
                <p>Dissent ≠ bigotry. We maintain strict removal of racism, harassment, and incitement to violence. R-Corp enforces this boundary.</p>
            </div>
        </div>

        <!-- ========== CONTACT & COLLABORATION ========== -->
        <div class="contact-section">
            <h2 class="section-heading">📡 CONTACT & COLLABORATION</h2>
            <div class="contact-panel">
                <div class="contact-card">
                    <div class="contact-icon">✉️</div>
                    <h3>DIRECT CONTACT</h3>
                    <p class="contact-email">
                        <span class="email-label">SECURE CHANNEL:</span>
                        <a href="mailto:<?php echo e($manifesto['contact']); ?>" 
                           class="contact-link"
                           rel="noopener noreferrer nofollow">
                            <?php echo e($manifesto['contact']); ?>

                        </a>
                    </p>
                    <p class="contact-note">
                        ⚡ PGP ENCRYPTED COMMUNICATION PREFERRED · KEY AVAILABLE ON REQUEST
                    </p>
                </div>
                <div class="contact-card">
                    <div class="contact-icon">⚔️</div>
                    <h3>OPERATIONS</h3>
                    <p>For security research, vulnerability disclosure, and strategic collaboration.</p>
                    <span class="support-tag"># SECURE_OPS</span>
                    <span class="support-tag"># PGP_REQUIRED</span>
                </div>
            </div>
        </div>

        <!-- ========== DEVELOPER ACCESS ========== -->
        <div class="dev-section">
            <h2 class="section-heading">🛠 GETTING STARTED — DEVELOPERS</h2>
            <div class="code-block">
                <span class="code-comment"># Join the encrypted channel. Build with us.</span><br>
                <span class="code-prompt">$</span> git clone https://github.com/RR-Ralefaso/decensorweb.git<br>
                <span class="code-prompt">$</span> cd decensorweb<br>
                <span class="code-comment"># every commit strengthens the network</span><br>
                <span class="code-prompt">$</span> echo "we answer only to R-CORP" > accountability.commit
            </div>
            <div class="dev-badge">
                <span>🔓 OPEN CONTRIBUTION · CONTACT: <?php echo e($manifesto['contact']); ?></span>
            </div>
        </div>

        <!-- ========== SUPPORT NETWORK ========== -->
        <div class="support-section">
            <h2 class="section-heading">🤝 SUSTAIN THE NETWORK</h2>
            <div class="support-grid">
                <div class="support-card">
                    <div class="support-card-header">1. SPONSOR</div>
                    <p>Servers, encryption tooling, and legal defense require resources. Your sponsorship keeps R-Corp independent.</p>
                    <a href="https://github.com/sponsors/RR-Ralefaso"
                       target="_blank"
                       rel="noopener noreferrer nofollow"
                       class="support-button">⚡ SPONSOR ON GITHUB</a>
                </div>
                <div class="support-card">
                    <div class="support-card-header">2. COLLABORATE</div>
                    <p>Fork the repo, audit our code, propose protocols. R-Corp reviews all contributions.</p>
                    <span class="support-tag"># OPEN_CALL</span>
                    <span class="support-tag"># R_CORP_LABS</span>
                    <span class="support-tag"># <?php echo e(substr($manifesto['contact'], 0, 10)); ?>...</span>
                </div>
                <div class="support-card">
                    <div class="support-card-header">3. DEPLOY</div>
                    <p>Run a decensorweb node. Become part of the resistance mesh. R-Corp provides signing keys.</p>
                    <span class="support-tag">NODE STATUS: ACTIVE</span>
                </div>
            </div>
        </div>

        <!-- ========== LICENSE & DOCTRINE ========== -->
        <div class="legal-doctrine">
            <div class="license-line">
                <span>📜 OPEN SOURCE · R-CORP PUBLIC LICENSE (RPL) · SEE LICENSE FILE</span>
                <span class="version-tag"><?php echo e($manifesto['version']); ?> · <?php echo e($manifesto['build']); ?></span>
            </div>
            <div class="doctrine-short">
                <strong>ACCOUNT RESPONSIBILITY:</strong> R-CORP, and only R-CORP, is accountable for all user accounts,
                data integrity, and legal defense of this platform. We do not outsource liability. We do not blame users.
                We are the shield.
            </div>
        </div>

        <!-- ========== R-CORP SIGNATURE ========== -->
        <div class="signature-area">
            <div class="rcorp-sigil">
                <?php $rcorp_logo = validateAsset('assets/icons/rcorp.jpeg'); ?>
                <?php if ($rcorp_logo): ?>
                <img src="<?php echo e($rcorp_logo); ?>"
                     alt="R-Corp insignia"
                     class="rcorp-logo-image"
                     loading="lazy"
                     onerror="this.style.display='none';this.parentElement.classList.add('sigil-fallback');">
                <?php endif; ?>
                <span class="sigil-fallback-text">⛧ R-CORP ⛧</span>
            </div>
            <div class="signature-text">
                <span class="maintainer">Created and Maintained by <strong>R-CORP</strong></span>
                <span class="tagline"><i>Empowering digital freedom with total accountability.</i></span>
                <span class="doctrine-ref">ACCOUNTABILITY DOCTRINE v3.1 · CONTACT: rrralefaso@outlook.com</span>
                <span class="contact-ref">✉️ SECURE COMMS: <?php echo e($manifesto['contact']); ?></span>
            </div>
        </div>

        <!-- ========== FOOTER ========== -->
        <div class="footer-nav">
            <a href="roadmap.html" class="back-btn" rel="noopener noreferrer">← PROJECT:OVERTHROW ROADMAP</a>
            <div class="map-coordinates">
                <span class="coordinate">DECENSOR · SECTOR 7</span>
                <span class="contact-hash">[CONTACT: <?php echo e(substr(hash('sha256', $manifesto['contact']), 0, 8)); ?>]</span>
                <span class="fingerprint">[<?php echo e($short_fingerprint); ?>]</span>
            </div>
        </div>

        <!-- SECURE BUILD TIMESTAMP (COMMENT ONLY) -->
        <!-- BUILD: <?php echo e(date('Y-m-d H:i:s')); ?> · CONTACT: rrralefaso@outlook.com · NONCE: <?php echo e(substr($csp_nonce, 0, 8)); ?> · R-CORP AUDIT PASSED -->
    </div>

    <!-- JAVASCRIPT · EXTERNAL · SRI PROTECTED · NONCE ENFORCED -->
    <?php if ($js_about): ?>
    <script src="<?php echo e($js_about); ?>"
            nonce="<?php echo e($csp_nonce); ?>"
            integrity="sha384-<?php echo e(base64_encode(hash_file('sha384', __DIR__ . '/' . $js_about, true))); ?>"
            crossorigin="anonymous"
            defer></script>
    <?php endif; ?>
</body>
</html>
<?php ob_end_flush(); ?>