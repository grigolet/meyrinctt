<?php
/**
 * Default page template
 * 
 * A simple page with title and content blocks.
 */
snippet('header');
snippet('hero');
?>

<article class="py-16">
    <div class="max-w-[800px] mx-auto px-4">
        <?php if ($page->text()->isNotEmpty()): ?>
        <div class="prose lg:prose-xl">
            <?= $page->text()->toBlocks() ?>
        </div>
        <?php endif ?>
    </div>
</article>

<?php snippet('footer') ?>
