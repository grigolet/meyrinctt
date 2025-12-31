<?php
/**
 * Responsive Background Image Helper
 * 
 * Generates optimized background image using CSS custom properties and image-set().
 * Converts background images to img tags when possible for better optimization.
 * 
 * Usage: snippet('responsive-bg', [
 *     'image' => $imageObject,
 *     'alt' => 'Alt text',
 *     'preset' => 'default',
 *     'class' => 'additional-classes',
 *     'lazy' => true
 * ])
 */

$image = $image ?? null;
$alt = $alt ?? '';
$preset = $preset ?? 'default';
$class = $class ?? '';
$lazy = $lazy ?? true;

if (!$image || !is_object($image)) {
    return;
}

// Generate optimized image URLs
$webpUrl = $image->thumb(['format' => 'webp'])->url();
$fallbackUrl = $image->url();

$loadingAttr = $lazy ? 'loading="lazy"' : '';
?>

<div class="<?= $class ?> relative overflow-hidden">
    <img 
        src="<?= $webpUrl ?>" 
        alt="<?= esc($alt) ?>" 
        class="absolute inset-0 w-full h-full object-cover"
        <?= $loadingAttr ?>
    >
</div>
