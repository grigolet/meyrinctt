<?php
/**
 * News listing page template
 * 
 * Lists all news articles with pagination.
 */
snippet('header');
snippet('hero');

$perPage = $page->per_page()->or(9)->toInt();
$articles = $page->children()->listed()->sortBy('date', 'desc')->paginate($perPage);
$pagination = $articles->pagination();
?>

<section class="py-16">
    <div class="max-w-[1200px] mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($articles as $article): ?>
                <?php snippet('article-card', ['article' => $article]) ?>
            <?php endforeach ?>
        </div>

        <?php snippet('pagination', ['pagination' => $pagination]) ?>
    </div>
</section>

<?php snippet('footer') ?>
