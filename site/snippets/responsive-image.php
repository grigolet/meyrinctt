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
 *     'fetchpriority' => 'auto',
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
$fetchpriority = $fetchpriority ?? null;
$width = $width ?? null;
$height = $height ?? null;
$style = $style ?? '';

if (!$image || !is_object($image)) {
    return;
}

// Generate srcsets for different formats
$srcsetAvif = $image->srcset($preset, ['format' => 'avif']);
$srcsetWebp = $image->srcset($preset, ['format' => 'webp']);
$srcsetDefault = $image->srcset($preset);

// Fallback image for browsers that don't support picture/srcset.
$fallbackOptions = [
    'thumbnail' => ['width' => 400, 'height' => 400, 'crop' => true],
    'avatar' => ['width' => 120, 'height' => 120, 'crop' => true],
    'card' => ['width' => 800, 'height' => 600, 'crop' => true],
    'cover' => ['width' => 1600],
    'default' => ['width' => 1200],
];
$fallbackUrl = $image->thumb($fallbackOptions[$preset] ?? $fallbackOptions['default'])->url();

// Get dimensions if not provided
if (!$width || !$height) {
    $width = $width ?? $image->width();
    $height = $height ?? $image->height();
}

$loadingAttr = $lazy ? 'loading="lazy"' : '';
$focusPosition = function_exists('meyrinctt_focus_position') ? meyrinctt_focus_position($image) : null;
$styleRules = trim($style);

if ($focusPosition) {
    $styleRules = trim($styleRules . '; object-position: ' . $focusPosition, '; ');
}
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
        decoding="async"
        <?php if ($fetchpriority): ?>fetchpriority="<?= esc($fetchpriority) ?>"<?php endif ?>
        <?php if ($class): ?>class="<?= $class ?>"<?php endif ?>
        <?php if ($styleRules): ?>style="<?= esc($styleRules, 'attr') ?>"<?php endif ?>
    >
</picture>
