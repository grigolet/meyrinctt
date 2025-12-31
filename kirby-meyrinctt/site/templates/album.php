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
            <?php foreach ($images as $index => $image): ?>
            <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden cursor-pointer shadow-sm hover:shadow-md transition-all hover:scale-[1.02]" onclick="openLightbox(<?= $index ?>)">
                <img src="<?= $image->resize(400)->url() ?>" alt="<?= $image->alt()->or('Photo ' . ($index + 1))->esc() ?>" class="w-full h-full object-cover" loading="lazy">
            </div>
            <?php endforeach ?>
        </div>
    </div>
</section>

<?php snippet('lightbox', ['images' => $images]) ?>

<?php snippet('footer') ?>
