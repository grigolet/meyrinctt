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

// Fallback to random cover from covers folder if no cover exists
if (!$cover) {
    $coversPage = site()->find('covers');
    if ($coversPage) {
        $coverImages = $coversPage->images()->filterBy('extension', 'in', ['jpg', 'jpeg', 'png', 'webp']);
        if ($coverImages->count() > 0) {
            // Use article ID to seed random selection for consistency
            $seed = crc32($article->id());
            $index = $seed % $coverImages->count();
            $cover = $coverImages->nth($index);
        }
    }
}

$coverUrl = $cover ? $cover->url() : url('assets/placeholder.jpg');
$date = $article->date()->toDate('d M Y');
$author = $article->author()->isNotEmpty() ? $article->author()->esc() : null;
?>

<a href="<?= $article->url() ?>" class="flex flex-col bg-surface border-2 border-border rounded-xl shadow-soft transition-transform hover:-translate-y-1.5 hover:shadow-hover overflow-hidden relative group">
    <div class="absolute top-2.5 right-2.5 w-[30px] h-[30px] bg-[url('<?= url('assets/paddle-illustration.png') ?>')] bg-contain bg-no-repeat opacity-10 z-0"></div>
    <div class="h-[240px] border-b-2 border-border bg-cover bg-center flex-shrink-0" style="background-image: url('<?= $coverUrl ?>');"></div>
    <div class="p-8 relative z-10 flex flex-col flex-grow">
        <span class="block text-sm font-bold text-primary uppercase mb-2"><?= $date ?></span>
        <h3 class="text-2xl font-extrabold mb-2 leading-tight"><?= $article->title()->esc() ?></h3>
        <?php if ($article->excerpt()->isNotEmpty()): ?>
        <p class="mb-4 flex-grow"><?= $article->excerpt()->esc() ?></p>
        <?php endif ?>
        <div class="mt-auto">
            <?php if ($author): ?>
            <p class="text-sm text-gray-600 mb-3">Par <?= $author ?></p>
            <?php endif ?>
            <span class="inline-block font-bold text-text border-b-2 border-accent uppercase text-sm">Lire la suite</span>
        </div>
    </div>
</a>
