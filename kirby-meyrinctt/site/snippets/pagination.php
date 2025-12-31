<?php
/**
 * Pagination snippet
 * 
 * Displays pagination controls.
 * 
 * Usage: snippet('pagination', ['pagination' => $pagination])
 */

$pagination = $pagination ?? null;
if (!$pagination || $pagination->pages() <= 1) return;
?>

<div class="mt-16 flex justify-center items-center gap-2">
    <?php if ($pagination->hasPrevPage()): ?>
    <a href="<?= $pagination->prevPageUrl() ?>" class="w-10 h-10 flex items-center justify-center rounded-lg border-2 border-border bg-white text-text font-bold hover:bg-primary-light hover:text-primary hover:border-primary transition-colors">
        &larr;
    </a>
    <?php else: ?>
    <span class="w-10 h-10 flex items-center justify-center rounded-lg border-2 border-border bg-white text-gray-400 cursor-not-allowed font-bold">
        &larr;
    </span>
    <?php endif ?>
    
    <?php foreach ($pagination->range(5) as $num): ?>
    <a href="<?= $pagination->pageUrl($num) ?>" 
       class="w-10 h-10 flex items-center justify-center rounded-lg border-2 font-bold <?= $pagination->page() === $num ? 'border-primary bg-primary text-white shadow-soft' : 'border-border bg-white text-text hover:bg-primary-light hover:text-primary hover:border-primary transition-colors' ?>">
        <?= $num ?>
    </a>
    <?php endforeach ?>
    
    <?php if ($pagination->hasNextPage()): ?>
    <a href="<?= $pagination->nextPageUrl() ?>" class="w-10 h-10 flex items-center justify-center rounded-lg border-2 border-border bg-white text-text font-bold hover:bg-primary-light hover:text-primary hover:border-primary transition-colors">
        &rarr;
    </a>
    <?php else: ?>
    <span class="w-10 h-10 flex items-center justify-center rounded-lg border-2 border-border bg-white text-gray-400 cursor-not-allowed font-bold">
        &rarr;
    </span>
    <?php endif ?>
</div>
