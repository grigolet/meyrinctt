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
    <ul class="article-gallery-grid">
        <?php foreach ($images as $image): ?>
        <?php
        $isVideo = $image->type() === 'video' || in_array(strtolower($image->extension()), ['mp4', 'webm', 'mov', 'ogg']);
        $mediaLabel = $alt->or($image->alt())->or($image->filename())->value();
        $posterImage = $isVideo ? $image->poster()->toFile() : null;
        ?>
        <li>
            <a
                href="<?= $image->url() ?>"
                class="article-gallery-item"
                data-lightbox-file="<?= esc($image->id(), 'attr') ?>"
                aria-label="<?= esc(($isVideo ? 'Lire ' : 'Agrandir ') . $mediaLabel, 'attr') ?>"
            >
            <?php if ($isVideo): ?>
                <?php if ($posterImage): ?>
                    <?php snippet('responsive-image', [
                        'image' => $posterImage,
                        'alt' => $mediaLabel,
                        'preset' => 'thumbnail',
                        'sizes' => '(max-width: 768px) 50vw, 33vw',
                        'class' => 'block w-full h-full object-cover',
                        'lazy' => true,
                        'width' => 400,
                        'height' => 400
                    ]) ?>
                <?php else: ?>
                    <video class="article-gallery-video" preload="metadata" muted playsinline aria-label="<?= esc($mediaLabel, 'attr') ?>">
                        <source src="<?= esc($image->url(), 'attr') ?>#t=0.1" type="<?= esc($image->mime(), 'attr') ?>">
                    </video>
                <?php endif ?>
                <span class="video-thumbnail-overlay" aria-hidden="true">
                    <span class="article-video-play"></span>
                </span>
            <?php else: ?>
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
            <?php endif ?>
            </a>
        </li>
        <?php endforeach ?>
    </ul>

    <?php if ($caption->isNotEmpty()): ?>
    <figcaption>
        <?= $caption->esc() ?>
    </figcaption>
    <?php endif ?>
</figure>
