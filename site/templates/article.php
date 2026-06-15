<?php
/**
 * Article page template
 * 
 * Displays a single news article.
 */
snippet('header');

$cover = meyrinctt_cover_image($page);
?>

<?php snippet('hero', [
    'title' => $page->title(),
    'subtitle' => meyrinctt_date($page->date()),
    'image' => $cover
]) ?>

<section class="py-16">
    <div class="max-w-[800px] mx-auto px-4">

        <!-- Back link -->
        <div class="mt-12 pt-8 mb-8 border-t-2 border-border">
            <a href="<?= $page->parent()->url() ?>" class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-md border-2 border-primary bg-primary/10 px-5 py-3 font-bold text-primary transition-colors hover:bg-primary hover:text-white focus:outline-none focus-visible:ring-4 focus-visible:ring-primary/25">
                <span aria-hidden="true">&larr;</span>
                <span><?= t('article.backToNews', 'Retour aux actualités') ?></span>
            </a>
        </div>

        <?php if ($page->excerpt()->isNotEmpty()): ?>
        <div class="lead text-xl font-medium text-gray-600 mb-8 prose">
            <?= $page->excerpt()->kt() ?>
        </div>
        <?php endif ?>

        <?php if ($page->text()->isNotEmpty()): ?>
        <div class="article-content prose lg:prose-xl">
            <?= $page->text()->toBlocks() ?>
        </div>
        <?php endif ?>

    </div>
</section>

<?php snippet('footer') ?>
