<?php
/**
 * Responsive Image Snippet
 * 
 * Outputs a picture element with AVIF/WebP/fallback sources and srcset for responsive images.
 * 
 * Usage: snippet('responsive-image', [
 *     'image' => $imageObject,
 *     'alt' => 'Alt text',
 *     'sizes' => '(max-width: 768px) 100vw, 50vw',
 *     'preset' => 'default',
 *     'class' => 'css-classes',
 *     'lazy' => true,
 *     'width' => 800,
 *     'height' => 600
 * ])
 */

$image = $image ?? null;
$alt = $alt ?? '';
$sizes = $sizes ?? '100vw';
$preset = $preset ?? 'default';
$class = $class ?? '';
$lazy = $lazy ?? true;
$width = $width ?? null;
$height = $height ?? null;

if (!$image || !is_object($image)) {
    return;
}

// Generate srcsets for different formats
$srcsetAvif = $image->srcset($preset, ['format' => 'avif']);
$srcsetWebp = $image->srcset($preset, ['format' => 'webp']);
$srcsetDefault = $image->srcset($preset);

// Fallback image
$fallbackUrl = $image->url();

// Get dimensions if not provided
if (!$width || !$height) {
    $width = $width ?? $image->width();
    $height = $height ?? $image->height();
}

$loadingAttr = $lazy ? 'loading="lazy"' : '';
?>

<picture>
    <?php if ($srcsetAvif): ?>
    <source srcset="<?= $srcsetAvif ?>" sizes="<?= $sizes ?>" type="image/avif">
    <?php endif ?>
    <?php if ($srcsetWebp): ?>
    <source srcset="<?= $srcsetWebp ?>" sizes="<?= $sizes ?>" type="image/webp">
    <?php endif ?>
    <?php if ($srcsetDefault): ?>
    <source srcset="<?= $srcsetDefault ?>" sizes="<?= $sizes ?>">
    <?php endif ?>
    <img 
        src="<?= $fallbackUrl ?>" 
        alt="<?= esc($alt) ?>" 
        <?php if ($width && $height): ?>
        width="<?= $width ?>" 
        height="<?= $height ?>"
        <?php endif ?>
        <?= $loadingAttr ?>
        <?php if ($class): ?>class="<?= $class ?>"<?php endif ?>
    >
</picture>
