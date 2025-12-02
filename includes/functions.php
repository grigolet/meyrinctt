<?php

/**
 * Scans the albums directory and returns a list of albums.
 * Each album contains the folder name, a cover image, and image count.
 */
function get_albums($base_dir) {
    $albums = [];
    $albums_dir = $base_dir . '/assets/albums';

    if (!is_dir($albums_dir)) {
        return [];
    }

    $dirs = scandir($albums_dir);
    foreach ($dirs as $dir) {
        if ($dir === '.' || $dir === '..') continue;
        
        $path = $albums_dir . '/' . $dir;
        if (is_dir($path)) {
            $images = glob($path . '/*.{jpg,jpeg,png,webp}', GLOB_BRACE);
            $count = count($images);
            
            // Find a cover image (first image found)
            $cover = !empty($images) ? 'assets/albums/' . $dir . '/' . basename($images[0]) : null;

            $albums[] = [
                'name' => $dir,
                'path' => $path,
                'cover' => $cover,
                'count' => $count,
                'images' => $images
            ];
        }
    }
    return $albums;
}

/**
 * Optimizes images in the albums directory by converting them to WebP.
 * Resizes images for web display and replaces original files if configured.
 * 
 * Improvements for fast web loading:
 * - Resizes large images to max 1920px width (sufficient for web)
 * - Creates thumbnails at 400px for gallery listings
 * - Uses 75% quality for WebP (good balance of size/quality)
 * - Preserves EXIF orientation
 */
function optimize_images($base_dir, $config) {
    if (!$config['optimize_images']) return;

    $albums_dir = $base_dir . '/assets/albums';
    if (!is_dir($albums_dir)) return;

    $max_width = 1920;  // Max width for full images
    $thumb_width = 400; // Thumbnail width for galleries
    $quality = 75;      // WebP quality (lower = smaller files)
    
    $stats = [
        'processed' => 0,
        'skipped' => 0,
        'errors' => 0,
        'already_webp' => 0,
        'original_size' => 0,
        'new_size' => 0
    ];

    $dirs = scandir($albums_dir);
    foreach ($dirs as $dir) {
        if ($dir === '.' || $dir === '..') continue;
        
        $path = $albums_dir . '/' . $dir;
        if (is_dir($path)) {
            // Count existing WebP files
            $webp_files = glob($path . '/*.webp', GLOB_BRACE);
            $stats['already_webp'] += count($webp_files);
            
            $images = glob($path . '/*.{jpg,jpeg,png,JPG,JPEG,PNG}', GLOB_BRACE);
            foreach ($images as $image_path) {
                $ext = strtolower(pathinfo($image_path, PATHINFO_EXTENSION));
                $basename = pathinfo($image_path, PATHINFO_FILENAME);
                $webp_path = $path . '/' . $basename . '.webp';
                $thumb_path = $path . '/thumb_' . $basename . '.webp';

                // Skip if WebP already exists and is newer
                if (file_exists($webp_path) && filemtime($webp_path) >= filemtime($image_path)) {
                    if ($config['replace_originals'] && file_exists($image_path) && $image_path !== $webp_path) {
                         unlink($image_path);
                    }
                    $stats['skipped']++;
                    continue;
                }

                $stats['original_size'] += filesize($image_path);

                // Load image based on type
                $image = null;
                if ($ext === 'jpg' || $ext === 'jpeg') {
                    $image = @imagecreatefromjpeg($image_path);
                } elseif ($ext === 'png') {
                    $image = @imagecreatefrompng($image_path);
                }

                if (!$image) {
                    $stats['errors']++;
                    continue;
                }

                // Get original dimensions
                $orig_width = imagesx($image);
                $orig_height = imagesy($image);

                // Fix orientation based on EXIF data
                if (function_exists('exif_read_data') && ($ext === 'jpg' || $ext === 'jpeg')) {
                    $exif = @exif_read_data($image_path);
                    if ($exif && isset($exif['Orientation'])) {
                        $image = fix_image_orientation($image, $exif['Orientation']);
                        // Update dimensions after rotation
                        $orig_width = imagesx($image);
                        $orig_height = imagesy($image);
                    }
                }

                // Resize if image is larger than max_width
                if ($orig_width > $max_width) {
                    $new_width = $max_width;
                    $new_height = intval(($orig_height / $orig_width) * $new_width);
                    $resized = imagecreatetruecolor($new_width, $new_height);
                    
                    // Preserve transparency for PNGs
                    if ($ext === 'png') {
                        imagealphablending($resized, false);
                        imagesavealpha($resized, true);
                    }
                    
                    imagecopyresampled($resized, $image, 0, 0, 0, 0, $new_width, $new_height, $orig_width, $orig_height);
                    imagedestroy($image);
                    $image = $resized;
                }

                // Save as WebP
                imagewebp($image, $webp_path, $quality);
                if (file_exists($webp_path)) {
                    $stats['new_size'] += filesize($webp_path);
                }

                // Create thumbnail
                $thumb_height = intval((imagesy($image) / imagesx($image)) * $thumb_width);
                $thumbnail = imagecreatetruecolor($thumb_width, $thumb_height);
                imagecopyresampled($thumbnail, $image, 0, 0, 0, 0, $thumb_width, $thumb_height, imagesx($image), imagesy($image));
                imagewebp($thumbnail, $thumb_path, $quality);
                imagedestroy($thumbnail);

                imagedestroy($image);
                
                // Replace original if configured
                if ($config['replace_originals'] && $image_path !== $webp_path) {
                    unlink($image_path);
                }
                
                $stats['processed']++;
            }
        }
    }
    
    return $stats;
}

/**
 * Fixes image orientation based on EXIF data
 */
function fix_image_orientation($image, $orientation) {
    switch ($orientation) {
        case 3:
            return imagerotate($image, 180, 0);
        case 6:
            return imagerotate($image, -90, 0);
        case 8:
            return imagerotate($image, 90, 0);
        default:
            return $image;
    }
}

/**
 * Returns a list of images for a specific album.
 */
function get_album_images($base_dir, $album_name) {
    $album_path = $base_dir . '/assets/albums/' . $album_name;
    
    // Security check to prevent directory traversal
    if (strpos($album_name, '..') !== false || !is_dir($album_path)) {
        return [];
    }

    $images = glob($album_path . '/*.{jpg,jpeg,png,webp}', GLOB_BRACE);
    
    // Return relative paths
    return array_map(function($img) use ($base_dir) {
        return str_replace($base_dir . '/', '', $img);
    }, $images);
}
