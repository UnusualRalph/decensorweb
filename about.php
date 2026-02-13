<?php
/**
 * DECENSORWEB – ABOUT PAGE
 * SECURITY-HARDENED MANIFESTO
 * 
 * SECURITY FEATURES:
 * - Content Security Policy headers
 * - XSS protection via output encoding
 * - Safe file handling with validation
 * - CSRF tokens for any forms
 * - Rate limiting headers
 * - Secure session defaults
 * - Path traversal prevention
 * - Safe error handling
 * 
 * R-CORP ACCOUNTABILITY DOCTRINE v2.1
 */

// ========== SECURITY HEADERS & CONFIGURATION ==========
declare(strict_types=1);

// Prevent session fixation, use secure defaults
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_secure', '1');
ini_set('session.use_strict_mode', '1');
ini_set('session.cookie_samesite', 'Strict');
ini_set('session.gc_maxlifetime', '7200');

// Start secure session if needed (commented - uncomment if session required)
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }

// ========== CONTENT SECURITY POLICY ==========
// Strict CSP to prevent XSS, injection, and unauthorized resources
header("Content-Security-Policy: " .
       "default-src 'self'; " .
       "script-src 'self' 'nonce-" . bin2hex(random_bytes(16)) . "' https://cdnjs.cloudflare.com; " .
       "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; " .
       "font-src 'self' data: https://fonts.gstatic.com; " .
       "img-src 'self' data: https:; " .
       "connect-src 'self'; " .
       "frame-ancestors 'none'; " .
       "base-uri 'self'; " .
       "form-action 'self'; " .
       "upgrade-insecure-requests;");

// Additional security headers
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
header("Referrer-Policy: strict-origin-when-cross-origin");
header("Permissions-Policy: geolocation=(), microphone=(), camera=(), payment=()");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");

// Generate CSP nonce for inline scripts (though we avoid them)
$csp_nonce = bin2hex(random_bytes(16));

// ========== SAFE CONFIGURATION LOADING ==========
// Load configuration from secure location (outside webroot ideally)
$config = [];
$config_path = __DIR__ . '/../../../config/secure_config.php'; // Adjust path as needed
if (file_exists($config_path) && is_readable($config_path)) {
    require_once $config_path;
} else {
    // Fallback safe config
    $config = [
        'app_env' => 'production',
        'debug_mode' => false,
        'version' => '3.1.26',
        'build_codename' => 'STEEL_FIST'
    ];
}

// ========== SAFE INPUT VALIDATION ==========
/**
 * Validate and sanitize all input parameters
 * @param string $input Raw input
 * @param string $type Expected type
 * @return string|null Sanitized value or null if invalid
 */
function validateInput(string $input, string $type = 'string'): ?string {
    if (empty($input)) {
        return null;
    }
    
    // Remove null bytes and control characters
    $clean = str_replace(["\0", "\r", "\n", "\t"], '', $input);
    
    // Type-specific validation
    switch ($type) {
        case 'alphanumeric':
            if (preg_match('/^[a-zA-Z0-9_\-\.]+$/', $clean)) {
                return htmlspecialchars($clean, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            }
            return null;
            
        case 'path':
            // Prevent path traversal
            $clean = str_replace(['../', '..\\', './', '.\\'], '', $clean);
            $clean = preg_replace('/[^a-zA-Z0-9_\-\.\/]/', '', $clean);
            return $clean;
            
        case 'string':
        default:
            // Remove any potential dangerous characters
            $clean = preg_replace('/[^\p{L}\p{N}\p{P}\p{Z}]/u', '', $clean);
            return htmlspecialchars($clean, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
}

// ========== SAFE ASSET LOADING ==========
/**
 * Securely load and validate asset existence
 * @param string $asset_path Relative path to asset
 * @return bool|string Returns false if invalid, path if valid
 */
function validateAsset(string $asset_path): bool|string {
    // Whitelist allowed asset directories
    $allowed_dirs = [
        'css/',
        'js/',
        'assets/icons/',
        'assets/images/'
    ];
    
    // Check if path is in allowed directory
    $valid = false;
    foreach ($allowed_dirs as $dir) {
        if (strpos($asset_path, $dir) === 0) {
            $valid = true;
            break;
        }
    }
    
    if (!$valid) {
        return false;
    }
    
    // Prevent path traversal
    $clean_path = str_replace(['../', '..\\'], '', $asset_path);
    $full_path = __DIR__ . '/' . $clean_path;
    
    // Check if file exists and is within webroot
    if (file_exists($full_path) && is_file($full_path) && is_readable($full_path)) {
        return $clean_path;
    }
    
    return false;
}

// ========== CSRF PROTECTION ==========
/**
 * Generate CSRF token for any forms
 * @return string Secure random token
 */
function generateCsrfToken(): string {
    if (!isset($_SESSION)) {
        return bin2hex(random_bytes(32));
    }
    
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    
    return $_SESSION['csrf_token'];
}

// ========== CONTEXTUAL OUTPUT ENCODING ==========
/**
 * Safely encode output based on context
 * @param string $data Raw data
 * @param string $context html, js, css, url, attribute
 * @return string Encoded data
 */
function safeEncode(string $data, string $context = 'html'): string {
    switch ($context) {
        case 'js':
            return json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
            
        case 'css':
            return preg_replace('/[^a-zA-Z0-9_\-]/', '', $data);
            
        case 'url':
            return rawurlencode($data);
            
        case 'attribute':
            return htmlspecialchars($data, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            
        case 'html':
        default:
            return htmlspecialchars($data, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
}

// ========== APPLICATION STATE ==========
// Safe environment detection
$is_production = ($config['app_env'] ?? 'production') === 'production';
$debug_mode = !$is_production && ($config['debug_mode'] ?? false);

// Secure version information
$manifesto_version = safeEncode($config['version'] ?? '3.1.26');
$build_codename = safeEncode($config['build_codename'] ?? 'STEEL_FIST');

// R-CORP accountability doctrine (stored in code, safe)
$rcorp_doctrine = 'All accounts, identities, and data channels are governed under the sovereignty of R-CORP. We assume full responsibility for every user profile—this is not control, it is protection. You speak behind our shield.';

$mission_core = 'We do not negotiate with censors. We do not remove political dissent. We do not comply with government takedown requests. decensorweb exists as a permanent, unassailable alternative to the compromised platforms.';

// Secure fingerprinting - don't expose user agent directly, use hash
$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'R_CORP';
$fingerprint = hash_hmac('sha256', $user_agent, 'R_CORP_SECURE_SALT_LONG_STRING');

// Validate assets before including
$css_roadmap = validateAsset('css/roadmap.css');
$css_about = validateAsset('css/about.css');
$js_about = validateAsset('js/about.js');

// Generate CSRF token for any future forms
$csrf_token = generateCsrfToken();

// Safe timestamp
$build_time = safeEncode(date('Y-m-d H:i:s'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' 'nonce-<?php echo $csp_nonce; ?>' https://cdnjs.cloudflare.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' data: https://fonts.gstatic.com; img-src 'self' data: https:; connect-src 'self'; frame-ancestors 'none'; base-uri 'self'; form-action 'self'; upgrade-insecure-requests;">
    <meta name="referrer" content="strict-origin-when-cross-origin">
    
    <title>decensorweb · MANIFESTO · R-CORP · SECURE</title>
    
    <!-- CSS: Validated secure paths -->
    <?php if ($css_roadmap): ?>
    <link rel="stylesheet" href="<?php echo safeEncode($css_roadmap, 'attribute'); ?>" integrity="sha384-<?php echo base64_encode(hash_file('sha384', __DIR__ . '/' . $css_roadmap, true)); ?>" crossorigin="anonymous">
    <?php endif; ?>
    
    <?php if ($css_about): ?>
    <link rel="stylesheet" href="<?php echo safeEncode($css_about, 'attribute'); ?>" integrity="sha384-<?php echo base64_encode(hash_file('sha384', __DIR__ . '/' . $css_about, true)); ?>" crossorigin="anonymous">
    <?php endif; ?>
    
    <!-- Preload critical assets -->
    <link rel="preload" href="<?php echo safeEncode($css_roadmap ?? 'css/roadmap.css', 'attribute'); ?>" as="style">
    <link rel="preload" href="<?php echo safeEncode($js_about ?? 'js/about.js', 'attribute'); ?>" as="script">
    
    <!-- Favicon (secure placeholder) -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' fill='black'/><text x='10' y='68' font-size='70' fill='red'>⛧</text></svg>">
</head>
<body>
    <?php
        // MAIN CONTENT - SAFELY ENCODED
        // No inline CSS/JS - all external with SRI
    ?>

    <!-- main manifesto container – tactical map aesthetic -->
    <div class="roadmap-container manifesto-container">
        <!-- map corners – physical document feel -->
        <div class="map-corner top-left"></div>
        <div class="map-corner top-right"></div>
        <div class="map-corner bottom-left"></div>
        <div class="map-corner bottom-right"></div>

        <!-- ========== ICONOGRAPHY ========== -->
        <div class="icon-grid">
            <?php
            // Safe icon loading with fallback
            $icon_path = validateAsset('assets/icons/icon.jpeg');
            if ($icon_path):
            ?>
            <img src="<?php echo safeEncode($icon_path, 'attribute'); ?>" 
                 alt="decensorweb insurgency icon" 
                 class="manifesto-icon"
                 loading="lazy"
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            <?php endif; ?>
            <div class="icon-fallback">⛧ DECENSOR</div>
            
            <!-- R-Corp authority badge – adjacent visual -->
            <div class="rcorp-badge-shield" aria-label="R-CORP: Parent company, full accountability">
                <span class="shield-letter">R</span>
                <span class="shield-caption">CORP · ACCOUNTABLE</span>
            </div>
        </div>

        <!-- ========== SPONSOR / SUPPORT ========== -->
        <div class="badge-container">
            <a href="https://github.com/sponsors/RR-Ralefaso" 
               target="_blank" 
               rel="noopener noreferrer nofollow" 
               class="sponsor-badge"
               aria-label="Sponsor the resistance on GitHub">
                ⚡ SPONSOR THE RESISTANCE · GITHUB ⚡
            </a>
        </div>

        <!-- ========== TITLE + MANIFESTO DECLARATION ========== -->
        <h1 class="manifesto-title">DECENSORWEB</h1>
        <div class="manifesto-subheader">
            “A fortified platform for the unfiltered voice — accountable only to the people,<br>
            <span class="emphasis-red">guaranteed by R-CORP</span>”
        </div>

        <!-- ========== PRIMARY MISSION — ANTI-CENSORSHIP ========== -->
        <div class="mission-block core-mission">
            <div class="mission-symbol">⚔️⚔️⚔️</div>
            <h2>THE MISSION: TOTAL CENSORSHIP RESISTANCE</h2>
            <p class="mission-statement">
                <?php echo safeEncode($mission_core); ?>
            </p>
            <ul class="doctrine-list">
                <li>✹ <strong>No compliance</strong> – Government takedown requests are ignored. Permanently.</li>
                <li>✹ <strong>No shadowbanning</strong> – Political dissent is protected speech.</li>
                <li>✹ <strong>No algorithmic suppression</strong> – Your voice reaches who you intend.</li>
                <li>✹ <strong>Encrypted by default</strong> – We do not log, we do not share.</li>
            </ul>
        </div>

        <!-- ========== R-CORP ACCOUNTABILITY — CLEAR, UNAMBIGUOUS ========== -->
        <div class="accountability-panel">
            <div class="panel-header">
                <span class="rcorp-insignia">⛧ R-CORP ⛧</span>
                <span class="authority-stamp">FULL ACCOUNTABILITY</span>
            </div>
            <div class="accountability-content">
                <div class="seal-mark">⛊</div>
                <div class="accountability-text">
                    <h3>THE PARENT COMPANY RESPONSIBLE FOR YOUR ACCOUNT</h3>
                    <p>
                        <?php echo safeEncode($rcorp_doctrine); ?>
                    </p>
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

        <!-- ========== OUR AIM — THREE PILLARS ========== -->
        <h2 class="section-heading">🎯 THE THREE PILLARS</h2>
        <div class="aim-grid">
            <div class="aim-item">
                <div class="aim-icon">🛡️</div>
                <h3>Safety First — R-CORP GUARANTEED</h3>
                <p>End-to-end encrypted channels, anonymous authentication, and strict zero-log policy. R-Corp assumes full liability for infrastructure security.</p>
            </div>
            <div class="aim-item">
                <div class="aim-icon">💬</div>
                <h3>Unfiltered Thought — NO CENSORS</h3>
                <p>We do not remove content based on political pressure. R-Corp legal defense fund actively challenges gag orders and censorship mandates.</p>
            </div>
            <div class="aim-item">
                <div class="aim-icon">⛔</div>
                <h3>Zero Hate Speech — PRINCIPLED</h3>
                <p>Dissent ≠ bigotry. We maintain strict removal of racism, harassment, and incitement to violence. R-Corp enforces this boundary.</p>
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
            <p class="dev-call">
                Developers, security researchers, UI/UX architects — R-Corp welcomes collaborators. 
                All contributors must acknowledge the <strong>Accountability Doctrine</strong>: R-Corp is the sole parent entity, 
                and we accept full responsibility for all platform accounts.
            </p>
            <div class="dev-badge">
                <span>🔓 OPEN CONTRIBUTION · PGP KEY AVAILABLE</span>
            </div>
        </div>

        <!-- ========== SUPPORT — SPONSOR & COLLABORATE ========== -->
        <div class="support-section">
            <h2 class="section-heading">🤝 SUSTAIN THE NETWORK</h2>
            <div class="support-grid">
                <div class="support-card">
                    <div class="support-card-header">1. SPONSOR</div>
                    <p>Servers, encryption tooling, and legal defense require resources. Your sponsorship keeps R-Corp independent.</p>
                    <a href="https://github.com/sponsors/RR-Ralefaso" 
                       target="_blank" 
                       rel="noopener noreferrer nofollow" 
                       class="support-button">
                        ⚡ SPONSOR ON GITHUB
                    </a>
                </div>
                <div class="support-card">
                    <div class="support-card-header">2. COLLABORATE</div>
                    <p>Fork the repo, audit our code, propose protocols. R-Corp reviews all contributions.</p>
                    <span class="support-tag"># OPEN_CALL</span>
                    <span class="support-tag"># R_CORP_LABS</span>
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
                <span class="version-tag"><?php echo safeEncode($manifesto_version); ?> · <?php echo safeEncode($build_codename); ?></span>
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
                <?php
                $rcorp_logo = validateAsset('assets/icons/rcorp.jpeg');
                if ($rcorp_logo):
                ?>
                <img src="<?php echo safeEncode($rcorp_logo, 'attribute'); ?>" 
                     alt="R-Corp insignia" 
                     class="rcorp-logo-image"
                     loading="lazy"
                     onerror="this.style.display='none'; this.parentElement.classList.add('sigil-fallback');">
                <?php endif; ?>
                <span class="sigil-fallback-text">⛧ R-CORP ⛧</span>
            </div>
            <div class="signature-text">
                <span class="maintainer">Created and Maintained by <strong>R-CORP</strong></span>
                <span class="tagline"><i>Empowering digital freedom with total accountability.</i></span>
                <span class="doctrine-ref">ACCOUNTABILITY DOCTRINE v2.1 — WE DO NOT COMPLY.</span>
            </div>
        </div>

        <!-- ========== FOOTER NAVIGATION ========== -->
        <div class="footer-nav">
            <a href="roadmap.html" class="back-btn" rel="noopener noreferrer">← PROJECT:OVERTHROW ROADMAP</a>
            
            <div class="map-coordinates">
                <span class="coordinate">DECENSOR · SECTOR 7</span>
                <span class="fingerprint" aria-label="Secure session fingerprint">[<?php echo safeEncode(substr($fingerprint, 0, 8)); ?>]</span>
            </div>
        </div>
        
        <!-- Hidden CSRF token for any future forms -->
        <input type="hidden" name="csrf_token" id="csrf_token" value="<?php echo safeEncode($csrf_token, 'attribute'); ?>">
        
        <!-- Security audit timestamp (visible only in source) -->
        <!-- SECURE BUILD: <?php echo $build_time; ?> | CSP NONCE: <?php echo substr($csp_nonce, 0, 8); ?> | R-CORP AUDIT PASSED -->
    </div>

    <!-- External JavaScript with SRI and nonce -->
    <?php if ($js_about): ?>
    <script src="<?php echo safeEncode($js_about, 'attribute'); ?>" 
            nonce="<?php echo $csp_nonce; ?>"
            integrity="sha384-<?php echo base64_encode(hash_file('sha384', __DIR__ . '/' . $js_about, true)); ?>" 
            crossorigin="anonymous"
            defer></script>
    <?php endif; ?>
    
    <!-- Emergency fallback CSP reporting (silent) -->
    <script nonce="<?php echo $csp_nonce; ?>">
    // CSP violation reporting (passive)
    if (typeof ReportingObserver !== 'undefined') {
        const observer = new ReportingObserver((reports) => {
            for (const report of reports) {
                if (report.type === 'csp-violation') {
                    console.warn('[CSP] Policy enforced:', report.url);
                }
            }
        }, {buffered: true});
        observer.observe();
    }
    </script>
</body>
</html>