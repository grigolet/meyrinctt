<?php
/**
 * Album page template
 * 
 * Displays a single photo album with lightbox.
 */
snippet('header');
snippet('hero', [
    'title' => $page->title(),
    'subtitle' => $page->images()->count() . ' photos'
]);

$images = $page->images();
?>

<section class="py-16">
    <div class="max-w-[1200px] mx-auto px-4">
        <div class="mb-8">
            <a href="<?= $page->parent()->url() ?>" class="font-bold text-primary hover:underline">&larr; Retour à la galerie</a>
        </div>

        <?php if ($page->description()->isNotEmpty()): ?>
        <div class="mb-8">
            <p class="text-lg text-gray-700"><?= $page->description()->kt() ?></p>
        </div>
        <?php endif ?>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <?php $index = 0; foreach ($images as $image): ?>
            <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden cursor-pointer shadow-sm hover:shadow-md transition-all hover:scale-[1.02]" onclick="openLightbox(<?= $index ?>)">
                <?php snippet('responsive-image', [
                    'image' => $image,
                    'alt' => $image->alt()->or('Photo ' . ($index + 1))->esc(),
                    'preset' => 'thumbnail',
                    'sizes' => '(max-width: 768px) 50vw, (max-width: 1200px) 33vw, 25vw',
                    'class' => 'w-full h-full object-cover',
                    'lazy' => true,
                    'width' => 400,
                    'height' => 400
                ]) ?>
            </div>
            <?php $index++; endforeach ?>
        </div>
    </div>
</section>

<?php snippet('lightbox', ['images' => $images]) ?>

<?php snippet('footer') ?>
