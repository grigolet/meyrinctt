<?php
/**
 * Gallery Block
 * 
 * Optimized gallery block with responsive images and lazy loading.
 */

$alt = $block->alt();
$caption = $block->caption();
$crop = $block->crop()->isTrue();
$images = $block->images()->toFiles();
$ratio = $block->ratio()->or('auto');

if ($images->count() === 0) {
    return;
}
?>

<figure class="gallery"<?= Html::attr(['data-ratio' => $ratio, 'data-crop' => $crop], null, ' ') ?>>
    <ul class="grid grid-cols-2 md:grid-cols-3 gap-4">
        <?php foreach ($images as $image): ?>
        <li>
            <?php snippet('responsive-image', [
                'image' => $image,
                'alt' => $alt->or($image->alt())->value(),
                'preset' => 'thumbnail',
                'sizes' => '(max-width: 768px) 50vw, 33vw',
                'class' => 'block w-full h-full object-cover',
                'lazy' => true,
                'width' => 400,
                'height' => 400
            ]) ?>
        </li>
        <?php endforeach ?>
    </ul>

    <?php if ($caption->isNotEmpty()): ?>
    <figcaption>
        <?= $caption->esc() ?>
    </figcaption>
    <?php endif ?>
</figure>
