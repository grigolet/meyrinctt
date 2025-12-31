<?php
/**
 * Gallery page template
 * 
 * Lists all photo albums.
 */
snippet('header');
snippet('hero');

$albums = $page->children()->listed();
?>

<section class="py-16">
    <div class="max-w-[1200px] mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($albums as $album): ?>
                <?php snippet('album-card', ['album' => $album]) ?>
            <?php endforeach ?>
        </div>
    </div>
</section>

<?php snippet('footer') ?>
