<?php
/**
 * Article card snippet
 * 
 * Displays a single article/news card in a grid.
 * Matches the original index.php article cards exactly.
 * 
 * Usage: snippet('article-card', ['article' => $articlePage])
 */

$article = $article ?? $page;
$cover = $article->cover()->toFile() ?? $article->images()->first();
$date = $article->date()->toDate('d M Y');
?>

<a href="<?= $article->url() ?>" class="flex flex-col h-full bg-surface border-2 border-border rounded-xl shadow-soft transition-transform hover:-translate-y-1.5 hover:shadow-hover overflow-hidden group">
    <?php if ($cover): ?>
    <div class="h-[240px] shrink-0 border-b-2 border-border relative overflow-hidden">
        <?php snippet('responsive-image', [
            'image' => $cover,
            'alt' => $article->title()->esc(),
            'preset' => 'card',
            'sizes' => '(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 33vw',
            'class' => 'w-full h-full object-cover',
            'lazy' => true,
            'width' => 800,
            'height' => 240
        ]) ?>
    </div>
    <?php else: ?>
    <div class="h-[240px] shrink-0 border-b-2 border-border bg-gray-200"></div>
    <?php endif ?>
    <div class="flex flex-col grow p-8">
        <div class="mb-4">
            <span class="block text-sm font-bold text-primary uppercase mb-2"><?= $date ?></span>
            <h3 class="text-2xl font-extrabold mb-2 leading-tight"><?= $article->title()->esc() ?></h3>
            <?php if ($article->excerpt()->isNotEmpty()): ?>
            <p><?= $article->excerpt()->esc() ?></p>
            <?php endif ?>
        </div>
        <div class="mt-auto flex items-center justify-between">
            <small class="font-extrabold"><?= $article->author()->esc() ?></small>
            <span class="font-bold text-text border-b-2 border-accent uppercase text-sm">Lire la suite...</span>
        </div>
    </div>
</a>
