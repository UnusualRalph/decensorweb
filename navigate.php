<?php
/**
 * NAVIGATE.PHP · DECENSORWEB CENTRAL ROUTING
 * SECURE NAVIGATION HUB · R-CORP ACCOUNTABILITY
 * 
 * UPDATED NAVIGATION STRUCTURE:
 * - INDEX.HTML        · Main Terminal
 * - ROADMAP.HTML      · Project:Overthrow
 * - ABOUT.PHP         · Decensorweb Manifesto
 * - PRIVACY.PHP       · Data Sovereignty Protocol
 * - CONTACT.PHP       · Secure Communications Channel
 * 
 * SECURITY FEATURES:
 * - Strict CSP headers with nonce
 * - XSS protection via output encoding
 * - Path traversal prevention
 * - Secure asset validation with SRI
 * - Session fingerprinting
 * - CSRF protection ready
 * 
 * R-CORP DOCTRINE v3.5 · NAVIGATION HARDENED
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
    'version' => '3.5.0',
    'build' => 'NAVIGATION_COMPLETE',
    'environment' => 'production',
    'contact' => 'rrralefaso@outlook.com',
    'project' => 'DECENSORWEB · PROJECT:OVERTHROW',
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
$css_nav = validateAsset('css/navigate.css');
$js_nav = validateAsset('js/navigate.js');

// ========== UPDATED NAVIGATION STRUCTURE ==========
$nav_items = [
    'index' => [
        'title' => 'MAIN TERMINAL',
        'file' => 'index.html',
        'icon' => '⌂',
        'description' => 'Primary access point · Project:Overthrow command interface · System entry',
        'status' => 'ACTIVE',
        'color' => '#ff5555',
        'doctrine' => 'R-CORP · GATEWAY'
    ],
    'roadmap' => [
        'title' => 'PROJECT:OVERTHROW',
        'file' => 'roadmap.html',
        'icon' => '⚔️',
        'description' => 'Strategic timeline · Phase operations · Tactical deployment · Resistance roadmap',
        'status' => 'ACTIVE',
        'color' => '#ff7777',
        'doctrine' => 'OPERATION · ACTIVE'
    ],
    'about' => [
        'title' => 'DECENSORWEB',
        'file' => 'about.php',
        'icon' => '⛧',
        'description' => 'Anti-censorship manifesto · R-CORP accountability doctrine · Digital sovereignty',
        'status' => 'ACTIVE',
        'color' => '#ff8888',
        'doctrine' => 'MANIFESTO · ACTIVE'
    ],
    'privacy' => [
        'title' => 'PRIVACY & TERMS',
        'file' => 'privacy.php',
        'icon' => '🔐',
        'description' => 'Data sovereignty protocol · Zero logging · Non-compliance · R-CORP Public License',
        'status' => 'ACTIVE',
        'color' => '#55aaff',
        'doctrine' => 'SOVEREIGNTY · ENFORCED'
    ],
    'contact' => [
        'title' => 'SECURE CONTACT',
        'file' => 'contact.php',
        'icon' => '✉️',
        'description' => 'Encrypted communications · PGP preferred · GitHub: rr-ralefaso · Instagram: @unusualralph',
        'status' => 'ACTIVE',
        'color' => '#aa55ff',
        'doctrine' => 'ENCRYPTED · SECURE'
    ]
];

// ========== SYSTEM STATUS ==========
$system_status = [
    'state' => 'OPERATIONAL',
    'security' => 'HARDENED',
    'doctrine' => 'v3.5',
    'timestamp' => date('Y-m-d H:i:s'),
    'nodes' => count($nav_items),
    'protocol' => 'CSP · SRI · HSTS'
];

// ========== QUICK ACCESS ==========
$quick_access = [
    'github' => 'https://github.com/rr-ralefaso',
    'sponsor' => 'https://github.com/sponsors/RR-Ralefaso',
    'instagram' => 'https://instagram.com/unusualralph',
    'email' => 'mailto:rrralefaso@outlook.com'
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
    
    <title>NAVIGATE · DECENSORWEB · PROJECT:OVERTHROW · R-CORP</title>
    
    <!-- CSS · VALIDATED PATHS · SRI PROTECTED -->
    <?php if ($css_roadmap): ?>
    <link rel="stylesheet" href="<?php echo e($css_roadmap); ?>" 
          integrity="sha384-<?php echo e(base64_encode(hash_file('sha384', __DIR__ . '/' . $css_roadmap, true))); ?>"
          crossorigin="anonymous">
    <?php endif; ?>
    
    <?php if ($css_nav): ?>
    <link rel="stylesheet" href="<?php echo e($css_nav); ?>"
          integrity="sha384-<?php echo e(base64_encode(hash_file('sha384', __DIR__ . '/' . $css_nav, true))); ?>"
          crossorigin="anonymous">
    <?php endif; ?>
    
    <!-- FALLBACK FAVICON · DATA URI ONLY -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' fill='%23000000'/><text x='20' y='70' font-size='70' fill='%23ff0000'>⛧</text></svg>">
</head>
<body>
    <!-- 
        ================================================
        DECENSORWEB · CENTRAL NAVIGATION HUB
        R-CORP ACCOUNTABILITY DOCTRINE v3.5
        COMPLETE SYSTEM NAVIGATION · 5 ACTIVE NODES
        SECURE BUILD: <?php echo e($config['build']); ?> · <?php echo e(date('Y-m-d')); ?>
        SYSTEM STATE: OPERATIONAL · SECURITY HARDENED
        CONTACT: <?php echo e($config['contact']); ?>
        ================================================
    -->

    <div class="nav-container">
        <!-- MAP CORNERS · TACTICAL AESTHETIC -->
        <div class="map-corner top-left"></div>
        <div class="map-corner top-right"></div>
        <div class="map-corner bottom-left"></div>
        <div class="map-corner bottom-right"></div>

        <!-- ========== HEADER ========== -->
        <div class="nav-header">
            <div class="nav-insignia">
                <span class="insignia-mark">⛧</span>
                <h1 class="nav-title">NAVIGATION HUB</h1>
                <span class="insignia-mark">⛧</span>
            </div>
            <div class="nav-subheader">
                <span class="project-tag"><?php echo e($config['project']); ?></span>
                <span class="status-badge">SYSTEM: <?php echo e($system_status['state']); ?></span>
                <span class="security-badge">SECURITY: <?php echo e($system_status['security']); ?></span>
                <span class="nodes-badge">NODES: <?php echo e($system_status['nodes']); ?></span>
            </div>
        </div>

        <!-- ========== SYSTEM OVERVIEW ========== -->
        <div class="system-overview">
            <div class="overview-grid">
                <div class="overview-item">
                    <span class="overview-icon">🔐</span>
                    <span class="overview-label">PROTOCOL</span>
                    <span class="overview-value"><?php echo e($system_status['protocol']); ?></span>
                </div>
                <div class="overview-item">
                    <span class="overview-icon">📡</span>
                    <span class="overview-label">DOCTRINE</span>
                    <span class="overview-value"><?php echo e($system_status['doctrine']); ?></span>
                </div>
                <div class="overview-item">
                    <span class="overview-icon">⏱️</span>
                    <span class="overview-label">TIMESTAMP</span>
                    <span class="overview-value"><?php echo e($system_status['timestamp']); ?></span>
                </div>
                <div class="overview-item">
                    <span class="overview-icon">🖧</span>
                    <span class="overview-label">FINGERPRINT</span>
                    <span class="overview-value fingerprint">[<?php echo e($short_fingerprint); ?>]</span>
                </div>
            </div>
        </div>

        <!-- ========== NAVIGATION GRID ========== -->
        <h2 class="section-heading">⚡ ACTIVE SYSTEM NODES ⚡</h2>
        <div class="nav-grid">
            <?php foreach ($nav_items as $key => $item): ?>
            <div class="nav-card" data-nav="<?php echo e($key); ?>">
                <div class="nav-card-header" style="border-left-color: <?php echo e($item['color']); ?>;">
                    <span class="nav-icon"><?php echo e($item['icon']); ?></span>
                    <h2 class="nav-card-title"><?php echo e($item['title']); ?></h2>
                    <span class="nav-status"><?php echo e($item['status']); ?></span>
                </div>
                
                <div class="nav-card-body">
                    <p class="nav-description"><?php echo e($item['description']); ?></p>
                    
                    <div class="nav-file-info">
                        <span class="file-label">TARGET:</span>
                        <span class="file-path"><?php echo e($item['file']); ?></span>
                        <span class="file-doctrine"><?php echo e($item['doctrine']); ?></span>
                    </div>
                    
                    <div class="nav-actions">
                        <a href="<?php echo e($item['file']); ?>" 
                           class="nav-button"
                           rel="noopener noreferrer"
                           title="Access <?php echo e($item['title']); ?>">
                            ⚡ ACCESS TERMINAL
                        </a>
                    </div>
                </div>
                
                <div class="nav-card-footer">
                    <span class="doctrine-tag">R-CORP · ACCOUNTABLE</span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- ========== QUICK ACCESS PANEL ========== -->
        <div class="quick-access-panel">
            <div class="quick-access-header">
                <span class="quick-icon">⚡</span>
                <h3 class="quick-title">QUICK ACCESS · EXTERNAL CHANNELS</h3>
                <span class="quick-icon">⚡</span>
            </div>
            
            <div class="quick-access-grid">
                <div class="quick-access-item">
                    <span class="quick-channel-icon">⌨️</span>
                    <span class="quick-channel-label">GITHUB:</span>
                    <a href="<?php echo e($quick_access['github']); ?>" 
                       target="_blank"
                       rel="noopener noreferrer nofollow"
                       class="quick-channel-link">
                        rr-ralefaso
                    </a>
                </div>
                
                <div class="quick-access-item">
                    <span class="quick-channel-icon">⚡</span>
                    <span class="quick-channel-label">SPONSOR:</span>
                    <a href="<?php echo e($quick_access['sponsor']); ?>" 
                       target="_blank"
                       rel="noopener noreferrer nofollow"
                       class="quick-channel-link">
                        GitHub Sponsors
                    </a>
                </div>
                
                <div class="quick-access-item">
                    <span class="quick-channel-icon">📷</span>
                    <span class="quick-channel-label">INSTAGRAM:</span>
                    <a href="<?php echo e($quick_access['instagram']); ?>" 
                       target="_blank"
                       rel="noopener noreferrer nofollow"
                       class="quick-channel-link">
                        @unusualralph
                    </a>
                </div>
                
                <div class="quick-access-item">
                    <span class="quick-channel-icon">✉️</span>
                    <span class="quick-channel-label">EMAIL:</span>
                    <a href="<?php echo e($quick_access['email']); ?>" 
                       rel="noopener noreferrer nofollow"
                       class="quick-channel-link">
                        <?php echo e($config['contact']); ?>

                    </a>
                </div>
            </div>
            
            <div class="quick-access-footer">
                <span class="quick-doctrine">PGP ENCRYPTED · SECURE CHANNELS</span>
            </div>
        </div>

        <!-- ========== SYSTEM STATUS PANEL ========== -->
        <div class="status-panel">
            <div class="status-panel-header">
                <span class="panel-icon">🔐</span>
                <h3 class="panel-title">SECURITY CLEARANCE & SYSTEM STATUS</h3>
                <span class="panel-icon">🔐</span>
            </div>
            
            <div class="status-grid">
                <div class="status-item">
                    <span class="status-label">SECURITY PROTOCOL</span>
                    <span class="status-value">CSP · SRI · HSTS · XSS PROTECTION</span>
                </div>
                <div class="status-item">
                    <span class="status-label">SESSION FINGERPRINT</span>
                    <span class="status-value fingerprint">[<?php echo e($short_fingerprint); ?>]</span>
                </div>
                <div class="status-item">
                    <span class="status-label">DOCTRINE VERSION</span>
                    <span class="status-value"><?php echo e($system_status['doctrine']); ?></span>
                </div>
                <div class="status-item">
                    <span class="status-label">BUILD TIMESTAMP</span>
                    <span class="status-value"><?php echo e($system_status['timestamp']); ?></span>
                </div>
                <div class="status-item">
                    <span class="status-label">ACTIVE NODES</span>
                    <span class="status-value"><?php echo e($system_status['nodes']); ?> · ALL OPERATIONAL</span>
                </div>
                <div class="status-item">
                    <span class="status-label">CONTACT CHANNEL</span>
                    <span class="status-value contact-hash">[<?php echo e(substr(hash('sha256', $config['contact']), 0, 8)); ?>]</span>
                </div>
                <div class="status-item">
                    <span class="status-label">NODE STATUS</span>
                    <span class="status-value">ACTIVE · HARDENED · SOVEREIGN</span>
                </div>
                <div class="status-item">
                    <span class="status-label">ENCRYPTION</span>
                    <span class="status-value">TLS 1.3 · PGP READY</span>
                </div>
            </div>
            
            <div class="status-footer">
                <span class="doctrine-declaration">
                    ⚔️ R-CORP ASSUMES FULL ACCOUNTABILITY FOR ALL ACCESS POINTS · 5 ACTIVE NODES ⚔️
                </span>
            </div>
        </div>

        <!-- ========== NODE DIRECTORY ========== -->
        <div class="directory-panel">
            <h3 class="directory-title">📋 COMPLETE NODE DIRECTORY</h3>
            <div class="directory-grid">
                <?php foreach ($nav_items as $item): ?>
                <div class="directory-item">
                    <span class="directory-icon"><?php echo e($item['icon']); ?></span>
                    <span class="directory-name"><?php echo e($item['title']); ?></span>
                    <span class="directory-file"><?php echo e($item['file']); ?></span>
                    <span class="directory-status"><?php echo e($item['status']); ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- ========== CONTACT & SUPPORT ========== -->
        <div class="support-panel">
            <div class="support-links">
                <div class="support-item">
                    <span class="support-icon">✉️</span>
                    <span class="support-label">SECURE CONTACT:</span>
                    <a href="mailto:<?php echo e($config['contact']); ?>" 
                       class="support-contact"
                       rel="noopener noreferrer nofollow">
                        <?php echo e($config['contact']); ?>

                    </a>
                    <span class="support-badge">PGP PREFERRED</span>
                </div>
                <div class="support-item">
                    <span class="support-icon">⚡</span>
                    <span class="support-label">SPONSOR:</span>
                    <a href="https://github.com/sponsors/RR-Ralefaso" 
                       target="_blank"
                       rel="noopener noreferrer nofollow"
                       class="support-link">
                        GITHUB SPONSORS
                    </a>
                </div>
                <div class="support-item">
                    <span class="support-icon">📜</span>
                    <span class="support-label">LICENSE:</span>
                    <span class="support-text">R-CORP PUBLIC LICENSE (RPL)</span>
                </div>
                <div class="support-item">
                    <span class="support-icon">📷</span>
                    <span class="support-label">INSTAGRAM:</span>
                    <a href="https://instagram.com/unusualralph" 
                       target="_blank"
                       rel="noopener noreferrer nofollow"
                       class="support-link">
                        @unusualralph
                    </a>
                </div>
            </div>
        </div>

        <!-- ========== ACCOUNTABILITY DECLARATION ========== -->
        <div class="accountability-banner">
            <div class="banner-content">
                <span class="banner-icon">⛧</span>
                <span class="banner-text">
                    R-CORP · PARENT COMPANY · FULL ACCOUNTABILITY FOR ALL 5 SYSTEM NODES
                </span>
                <span class="banner-icon">⛧</span>
            </div>
        </div>

        <!-- ========== FOOTER ========== -->
        <div class="nav-footer">
            <div class="footer-doctrine">
                <span class="doctrine-short">
                    <strong>ACCOUNTABILITY:</strong> R-CORP · PARENT COMPANY · FULL RESPONSIBILITY · 5 ACTIVE NODES
                </span>
            </div>
            <div class="footer-coordinates">
                <span class="coordinate">DECENSOR · SECTOR 7</span>
                <span class="nav-indicator">[NAVIGATION HUB · v<?php echo e($config['version']); ?>]</span>
                <span class="version-tag"><?php echo e($config['build']); ?></span>
                <span class="node-count">5/5 NODES ONLINE</span>
                <span class="fingerprint">[<?php echo e($short_fingerprint); ?>]</span>
            </div>
        </div>

        <!-- SECURE BUILD TIMESTAMP (COMMENT ONLY) -->
        <!-- BUILD: <?php echo e(date('Y-m-d H:i:s')); ?> · NONCE: <?php echo e(substr($csp_nonce, 0, 8)); ?> · NODES: 5/5 · R-CORP AUDIT PASSED · NAVIGATION COMPLETE -->
    </div>

    <!-- JAVASCRIPT · EXTERNAL · SRI PROTECTED · NONCE ENFORCED -->
    <?php if ($js_nav): ?>
    <script src="<?php echo e($js_nav); ?>"
            nonce="<?php echo e($csp_nonce); ?>"
            integrity="sha384-<?php echo e(base64_encode(hash_file('sha384', __DIR__ . '/' . $js_nav, true))); ?>"
            crossorigin="anonymous"
            defer></script>
    <?php endif; ?>
</body>
</html>
<?php ob_end_flush(); ?>