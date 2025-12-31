<?php
/**
 * Album card snippet
 * 
 * Displays a single album card in a grid.
 * Matches the original gallery.php album cards.
 * 
 * Usage: snippet('album-card', ['album' => $albumPage])
 */

$album = $album ?? $page;
$cover = $album->cover()->toFile() ?? $album->images()->first();
$coverUrl = $cover ? $cover->url() : null;
$imageCount = $album->images()->count();
?>

<a href="<?= $album->url() ?>" class="block bg-surface border-2 border-border rounded-xl shadow-soft transition-transform hover:-translate-y-1.5 hover:shadow-hover overflow-hidden group">
    <?php if ($coverUrl): ?>
    <div class="h-[240px] border-b-2 border-border bg-cover bg-center" style="background-image: url('<?= $coverUrl ?>');"></div>
    <?php else: ?>
    <div class="h-[240px] border-b-2 border-border bg-gray-200 flex items-center justify-center">
        <span class="text-gray-400 font-bold text-4xl">📷</span>
    </div>
    <?php endif ?>
    
    <div class="p-6">
        <span class="block text-sm font-bold text-primary uppercase mb-2">Album</span>
        <h3 class="text-xl font-extrabold mb-2 leading-tight"><?= $album->title()->esc() ?></h3>
        <p class="text-sm text-gray-600"><?= $imageCount ?> photos</p>
    </div>
</a>
