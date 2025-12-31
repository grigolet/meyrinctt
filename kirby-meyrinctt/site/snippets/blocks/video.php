<?php
/**
 * Video Block
 * 
 * Optimized video block with poster image optimization.
 */

$caption = $block->caption();
$url = $block->url();

if ($url->isEmpty()) {
    return;
}

// Get video source
if ($block->location() == 'web') {
    $url = $url->esc();
    $video = null;
} elseif ($video = $block->video()->toFile()) {
    $url = $video->url();
}

// Get optimized poster
$poster = null;
if ($posterImage = $block->poster()->toFile()) {
    $poster = $posterImage->resize(1200)->url();
}
?>

<figure>
    <video 
        <?= $poster ? 'poster="' . $poster . '"' : '' ?> 
        controls
        preload="metadata"
        <?php if ($video && $video->width() && $video->height()): ?>
        width="<?= $video->width() ?>"
        height="<?= $video->height() ?>"
        <?php endif ?>
    >
        <source src="<?= $url ?>" type="<?= $video ? $video->mime() : 'video/mp4' ?>">
        Your browser does not support the video tag.
    </video>

    <?php if ($caption->isNotEmpty()): ?>
    <figcaption>
        <?= $caption ?>
    </figcaption>
    <?php endif ?>
</figure>
