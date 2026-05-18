<?php
/**
 * Article page template
 * 
 * Displays a single news article.
 */
snippet('header');

$cover = $page->files()->template('cover')->first() ?? $page->images()->first();

// Fallback to random cover from covers folder if no cover exists
if (!$cover) {
    if (!$cover && $coversPage = site()->find('covers')) {
        $coverImages = $coversPage->images()->filterBy('extension', 'in', ['jpg', 'jpeg', 'png', 'webp']);
        if ($coverImages->count() > 0) {
            // Use article ID to seed random selection for consistency
            $seed = crc32($page->id());
            $index = $seed % $coverImages->count();
            $cover = $coverImages->nth($index);
        }
    }
}
?>

<?php snippet('hero', [
    'title' => $page->title(),
    'subtitle' => $page->date()->toDate('d M Y'),
    'image' => $cover
]) ?>

<section class="py-16">
    <div class="max-w-[800px] mx-auto px-4">

        <?php if ($page->excerpt()->isNotEmpty()): ?>
        <p class="lead text-xl font-medium text-gray-600 mb-8 prose"><?= $page->excerpt()->esc() ?></p>
        <?php endif ?>

        <?php if ($page->text()->isNotEmpty()): ?>
        <div class="article-content prose lg:prose-xl">
            <?= $page->text()->toBlocks() ?>
        </div>
        <?php endif ?>

        <!-- Back link -->
        <div class="mt-12 pt-8 border-t-2 border-border not-prose">
            <a href="<?= $page->parent()->url() ?>" class="font-bold text-primary hover:underline">&larr; Retour aux actualités</a>
        </div>

    </div>
</section>

<?php snippet('footer') ?>
