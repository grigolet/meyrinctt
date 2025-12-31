<?php
/**
 * Web-based Image Optimization Tool
 * 
 * For hosting providers without SSH access, you can run this script
 * by accessing it in your browser: https://yoursite.com/optimize-web.php
 * 
 * SECURITY WARNING: This file should be password protected or deleted
 * after use to prevent unauthorized access.
 */

// Simple password protection - CHANGE THIS PASSWORD!
define('ADMIN_PASSWORD', 'meyrin2025');

session_start();

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: optimize-web.php');
    exit;
}

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
    if ($_POST['password'] === ADMIN_PASSWORD) {
        $_SESSION['authenticated'] = true;
    } else {
        $error = 'Invalid password';
    }
}

// Check authentication
$authenticated = isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true;

// Handle optimization request
$result = null;
if ($authenticated && isset($_POST['optimize'])) {
    $base_dir = __DIR__;
    $config = require $base_dir . '/config.php';
    require_once $base_dir . '/includes/functions.php';
    
    set_time_limit(300); // Allow 5 minutes for large galleries
    
    $start_time = microtime(true);
    $stats = optimize_images($base_dir, $config);
    $end_time = microtime(true);
    
    $result = [
        'stats' => $stats,
        'duration' => round($end_time - $start_time, 2)
    ];
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Optimization Tool</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f5f5;
            padding: 20px;
            line-height: 1.6;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #0056b3;
            margin-bottom: 10px;
        }
        .subtitle {
            color: #666;
            margin-bottom: 30px;
        }
        .login-form, .tool {
            margin-top: 20px;
        }
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            margin-bottom: 10px;
        }
        button {
            background: #0056b3;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            font-weight: bold;
        }
        button:hover {
            background: #004494;
        }
        .btn-secondary {
            background: #6c757d;
        }
        .btn-secondary:hover {
            background: #5a6268;
        }
        .error {
            background: #fee;
            color: #c00;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .success {
            background: #efe;
            color: #070;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .warning {
            background: #ffeaa7;
            color: #856404;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .info-box {
            background: #e3f2fd;
            padding: 20px;
            border-radius: 5px;
            border-left: 4px solid #0056b3;
            margin-bottom: 20px;
        }
        .stats {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .stat-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #dee2e6;
        }
        .stat-row:last-child {
            border-bottom: none;
        }
        .stat-label {
            font-weight: bold;
        }
        .logout {
            float: right;
            font-size: 14px;
        }
        ul {
            margin: 15px 0 15px 20px;
        }
        li {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (!$authenticated): ?>
            <h1>🔒 Image Optimization Tool</h1>
            <p class="subtitle">Enter password to access</p>
            
            <?php if (isset($error)): ?>
                <div class="error">❌ <?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <div class="warning">
                ⚠️ <strong>Security Notice:</strong> This tool should be password protected and removed after use.
            </div>
            
            <form method="POST" class="login-form">
                <input type="password" name="password" placeholder="Enter password" required autofocus>
                <button type="submit">Login</button>
            </form>
            
        <?php else: ?>
            <h1>🎨 Image Optimization Tool</h1>
            <a href="?logout" class="logout">Logout</a>
            <p class="subtitle">Optimize images for fast web loading</p>
            
            <?php if ($result): ?>
                <?php if ($result['stats']['processed'] > 0): ?>
                    <div class="success">✅ Optimization completed successfully!</div>
                <?php elseif ($result['stats']['already_webp'] > 0): ?>
                    <div class="success">✅ All images are already optimized!</div>
                <?php else: ?>
                    <div class="warning">⚠️ No images found to optimize.</div>
                <?php endif; ?>
                
                <div class="stats">
                    <h3>Results</h3>
                    
                    <?php if ($result['stats']['already_webp'] > 0): ?>
                        <div class="stat-row">
                            <span class="stat-label">✓ Already optimized:</span>
                            <span><?php echo $result['stats']['already_webp']; ?> WebP images</span>
                        </div>
                    <?php endif; ?>
                    
                    <div class="stat-row">
                        <span class="stat-label">✓ Processed:</span>
                        <span><?php echo $result['stats']['processed']; ?> images</span>
                    </div>
                    <div class="stat-row">
                        <span class="stat-label">⊘ Skipped:</span>
                        <span><?php echo $result['stats']['skipped']; ?> images (already optimized)</span>
                    </div>
                    <div class="stat-row">
                        <span class="stat-label">✗ Errors:</span>
                        <span><?php echo $result['stats']['errors']; ?> images</span>
                    </div>
                    
                    <?php if ($result['stats']['processed'] > 0): ?>
                        <?php
                        $original_mb = round($result['stats']['original_size'] / 1024 / 1024, 2);
                        $new_mb = round($result['stats']['new_size'] / 1024 / 1024, 2);
                        $saved_mb = round(($result['stats']['original_size'] - $result['stats']['new_size']) / 1024 / 1024, 2);
                        $percent = round((($result['stats']['original_size'] - $result['stats']['new_size']) / $result['stats']['original_size']) * 100, 1);
                        ?>
                        <div class="stat-row">
                            <span class="stat-label">💾 Original size:</span>
                            <span><?php echo $original_mb; ?> MB</span>
                        </div>
                        <div class="stat-row">
                            <span class="stat-label">💾 Optimized size:</span>
                            <span><?php echo $new_mb; ?> MB</span>
                        </div>
                        <div class="stat-row">
                            <span class="stat-label">📉 Saved:</span>
                            <span><?php echo $saved_mb; ?> MB (<?php echo $percent; ?>% reduction)</span>
                        </div>
                    <?php endif; ?>
                    
                    <div class="stat-row">
                        <span class="stat-label">⏱️ Duration:</span>
                        <span><?php echo $result['duration']; ?> seconds</span>
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="info-box">
                <h3>What this tool does:</h3>
                <ul>
                    <li>Converts JPG/PNG images to WebP format (~30% smaller)</li>
                    <li>Resizes large images to maximum 1920px width</li>
                    <li>Creates 400px thumbnails for fast gallery loading</li>
                    <li>Fixes image orientation based on EXIF data</li>
                    <li>Uses 75% quality (optimal for web)</li>
                </ul>
                
                <?php
                // Check for existing images
                $albums_dir = __DIR__ . '/assets/albums';
                $webp_count = 0;
                $jpg_png_count = 0;
                if (is_dir($albums_dir)) {
                    $dirs = scandir($albums_dir);
                    foreach ($dirs as $dir) {
                        if ($dir === '.' || $dir === '..') continue;
                        $path = $albums_dir . '/' . $dir;
                        if (is_dir($path)) {
                            $webp_count += count(glob($path . '/*.webp'));
                            $jpg_png_count += count(glob($path . '/*.{jpg,jpeg,png,JPG,JPEG,PNG}', GLOB_BRACE));
                        }
                    }
                }
                ?>
                
                <div style="margin-top: 15px; padding: 10px; background: #f8f9fa; border-radius: 5px;">
                    <strong>Current Status:</strong><br>
                    📊 <?php echo $webp_count; ?> WebP images (optimized)<br>
                    📷 <?php echo $jpg_png_count; ?> JPG/PNG images (need optimization)
                </div>
            </div>
            
            <div class="warning">
                ⚠️ <strong>Important:</strong> This process may take several minutes for large galleries. 
                <?php if ($config = require __DIR__ . '/config.php'): ?>
                    <?php if ($config['replace_originals']): ?>
                        Original images will be replaced with optimized versions.
                    <?php else: ?>
                        Original images will be kept alongside WebP versions.
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            
            <form method="POST" class="tool">
                <button type="submit" name="optimize" value="1">🚀 Start Optimization</button>
            </form>
            
            <div style="margin-top: 30px; padding-top: 20px; border-top: 2px solid #dee2e6;">
                <h3>For Hosting Providers:</h3>
                <p style="margin: 10px 0;">You can also run optimization via:</p>
                <ul>
                    <li><strong>SSH/Terminal:</strong> <code>php optimize-images.php</code></li>
                    <li><strong>Cron Job:</strong> Set up automatic optimization weekly</li>
                    <li><strong>FTP:</strong> Upload new images, then run this tool</li>
                </ul>
                <p style="margin-top: 15px; color: #c00; font-weight: bold;">
                    🔒 Delete this file (optimize-web.php) after use for security!
                </p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
