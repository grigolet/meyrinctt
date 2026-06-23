<?php
/**
 * Video Block
 * 
 * Optimized video block with poster image optimization.
 */

$caption = $block->caption();
$url = '';
$video = null;

// Get video source
if ($block->location() == 'web') {
    $url = $block->url()->value();
} elseif ($video = $block->video()->toFile()) {
    $url = $video->url();
}

if ($url === '') {
    return;
}

// Get optimized poster
$poster = null;
if ($posterImage = $block->poster()->toFile()) {
    $poster = $posterImage->resize(1200)->url();
}
?>

<figure class="article-video-block">
    <video 
        <?= $poster ? 'poster="' . esc($poster, 'attr') . '"' : '' ?>
        controls
        preload="metadata"
        playsinline
        class="w-full h-auto rounded-xl bg-black shadow-soft"
    >
        <source src="<?= esc($url, 'attr') ?>" type="<?= $video ? esc($video->mime(), 'attr') : 'video/mp4' ?>">
        Your browser does not support the video tag.
    </video>

    <?php if ($caption->isNotEmpty()): ?>
    <figcaption>
        <?= $caption->esc() ?>
    </figcaption>
    <?php endif ?>
</figure>
