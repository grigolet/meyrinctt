#!/usr/bin/env php
<?php
/**
 * Image Optimization CLI Script
 * 
 * This script optimizes all images in the assets/albums directory.
 * Run this script via SSH or cron job on your hosting provider.
 * 
 * Usage:
 *   php optimize-images.php              # Run optimization
 *   php optimize-images.php --dry-run    # See what would be optimized
 *   php optimize-images.php --help       # Show help
 * 
 * Requirements:
 *   - PHP 7.0+ with GD library
 *   - WebP support in GD (most modern PHP installations)
 * 
 * On shared hosting, you can:
 *   1. Upload this file via FTP/SFTP
 *   2. SSH into your server (if available)
 *   3. Run: php optimize-images.php
 *   4. Or set up a cron job to run it automatically
 */

// Check if running from command line
if (php_sapi_name() !== 'cli') {
    die("This script must be run from the command line.\n");
}

// Parse command line arguments
$options = getopt('', ['dry-run', 'help', 'verbose']);
$dry_run = isset($options['dry-run']);
$verbose = isset($options['verbose']);

if (isset($options['help'])) {
    echo "Image Optimization Script\n";
    echo "=========================\n\n";
    echo "Usage: php optimize-images.php [options]\n\n";
    echo "Options:\n";
    echo "  --dry-run    Show what would be done without making changes\n";
    echo "  --verbose    Show detailed output\n";
    echo "  --help       Show this help message\n\n";
    echo "Examples:\n";
    echo "  php optimize-images.php\n";
    echo "  php optimize-images.php --dry-run\n";
    echo "  php optimize-images.php --verbose\n\n";
    exit(0);
}

// Check for GD library
if (!extension_loaded('gd')) {
    echo "ERROR: PHP GD library is not installed.\n";
    echo "Please install it: sudo apt-get install php-gd (on Ubuntu/Debian)\n";
    exit(1);
}

// Check for WebP support
if (!function_exists('imagewebp')) {
    echo "ERROR: WebP support is not available in your PHP GD library.\n";
    echo "Please upgrade to PHP 7.0+ with WebP support.\n";
    exit(1);
}

echo "🎨 Image Optimization Script\n";
echo "============================\n\n";

if ($dry_run) {
    echo "⚠️  DRY RUN MODE - No files will be modified\n\n";
}

// Load configuration
$base_dir = __DIR__;
$config = require $base_dir . '/config.php';
require_once $base_dir . '/includes/functions.php';

// Override config for dry run
if ($dry_run) {
    $config['replace_originals'] = false;
}

echo "Configuration:\n";
echo "  Base directory: $base_dir\n";
echo "  Replace originals: " . ($config['replace_originals'] ? 'Yes' : 'No') . "\n";
echo "  Max width: 1920px\n";
echo "  Thumbnail width: 400px\n";
echo "  WebP quality: 75%\n\n";

// Check if albums directory exists
$albums_dir = $base_dir . '/assets/albums';
if (!is_dir($albums_dir)) {
    echo "ERROR: Albums directory not found: $albums_dir\n";
    exit(1);
}

echo "📁 Scanning albums directory...\n\n";

// Count images before optimization
$total_images = 0;
$total_webp = 0;
$dirs = scandir($albums_dir);
foreach ($dirs as $dir) {
    if ($dir === '.' || $dir === '..') continue;
    $path = $albums_dir . '/' . $dir;
    if (is_dir($path)) {
        $images = glob($path . '/*.{jpg,jpeg,png,JPG,JPEG,PNG}', GLOB_BRACE);
        $webp = glob($path . '/*.webp');
        $count = count($images);
        $webp_count = count($webp);
        $total_images += $count;
        $total_webp += $webp_count;
        if ($verbose && ($count > 0 || $webp_count > 0)) {
            echo "  📂 $dir: $count images";
            if ($webp_count > 0) {
                echo " ($webp_count already WebP)";
            }
            echo "\n";
        }
    }
}

echo "\nFound $total_images images to process\n";
if ($total_webp > 0) {
    echo "Found $total_webp WebP images (already optimized)\n";
}
echo "\n";

if ($total_images === 0) {
    if ($total_webp > 0) {
        echo "✅ All images are already optimized as WebP!\n";
        echo "💡 To re-optimize, delete .webp files and restore original JPG/PNG files.\n";
    } else {
        echo "✅ No images found to optimize.\n";
    }
    exit(0);
}

if ($dry_run) {
    echo "✅ Dry run complete. Run without --dry-run to optimize images.\n";
    exit(0);
}

// Run optimization
echo "🔄 Optimizing images...\n\n";
$start_time = microtime(true);

$stats = optimize_images($base_dir, $config);

$end_time = microtime(true);
$duration = round($end_time - $start_time, 2);

// Display results
echo "\n✅ Optimization Complete!\n";
echo "=========================\n\n";
echo "Results:\n";
if ($stats['already_webp'] > 0) {
    echo "  ✓ Already optimized: " . $stats['already_webp'] . " WebP images\n";
}
echo "  ✓ Processed: " . $stats['processed'] . " images\n";
echo "  ⊘ Skipped: " . $stats['skipped'] . " images (already optimized)\n";
echo "  ✗ Errors: " . $stats['errors'] . " images\n\n";

if ($stats['processed'] > 0) {
    $original_mb = round($stats['original_size'] / 1024 / 1024, 2);
    $new_mb = round($stats['new_size'] / 1024 / 1024, 2);
    $saved_mb = round(($stats['original_size'] - $stats['new_size']) / 1024 / 1024, 2);
    $percent = round((($stats['original_size'] - $stats['new_size']) / $stats['original_size']) * 100, 1);
    
    echo "Storage:\n";
    echo "  Original size: {$original_mb} MB\n";
    echo "  Optimized size: {$new_mb} MB\n";
    echo "  Saved: {$saved_mb} MB ({$percent}% reduction)\n\n";
}

echo "Duration: {$duration} seconds\n\n";
echo "💡 Tips:\n";
echo "  - Images have been resized to max 1920px width\n";
echo "  - Thumbnails created at 400px width for fast gallery loading\n";
echo "  - WebP format is ~30% smaller than JPEG with same quality\n";
echo "  - Run this script after adding new images to your albums\n\n";
