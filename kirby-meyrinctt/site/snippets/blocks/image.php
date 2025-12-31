<?php
/**
 * Image Block
 * 
 * Optimized image block with responsive images, lazy loading, and modern formats.
 */

$alt = $block->alt()->or('');
$caption = $block->caption();
$crop = $block->crop()->isTrue();
$link = $block->link();
$ratio = $block->ratio()->or('auto');
$src = null;

if ($block->location() == 'web') {
    $src = $block->src()->esc();
} elseif ($image = $block->image()->toFile()) {
    $src = $image;
}

if (!$src) {
    return;
}
?>

<figure<?= Html::attr(['data-ratio' => $ratio, 'data-crop' => $crop], null, ' ') ?>>
    <?php if ($link->isNotEmpty()): ?>
    <a href="<?= Str::esc($link) ?>">
    <?php endif ?>

    <?php if (is_string($src)): ?>
        <img src="<?= $src ?>" alt="<?= $alt->esc() ?>" loading="lazy">
    <?php else: ?>
        <?php snippet('responsive-image', [
            'image' => $src,
            'alt' => $alt->value(),
            'preset' => 'default',
            'sizes' => '(max-width: 768px) 100vw, (max-width: 1200px) 80vw, 900px',
            'class' => '',
            'lazy' => true,
            'width' => $src->width(),
            'height' => $src->height()
        ]) ?>
    <?php endif ?>

    <?php if ($link->isNotEmpty()): ?>
    </a>
    <?php endif ?>

    <?php if ($caption->isNotEmpty()): ?>
    <figcaption>
        <?= $caption ?>
    </figcaption>
    <?php endif ?>
</figure>
