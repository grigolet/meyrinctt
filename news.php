<?php
$config = require __DIR__ . '/config.php';
$page_title = "Actualités - " . $config['site_name'];
$hero_title = "Actualités";
$hero_subtitle = "Suivez la vie du club et les résultats de nos équipes.";
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/hero.php';

// Scan for news posts
$posts = [];
$news_dir = __DIR__ . '/content/news';
if (is_dir($news_dir)) {
    $files = glob($news_dir . '/*.php');
    foreach ($files as $file) {
        $post = include $file;
        $post['slug'] = basename($file, '.php');
        $posts[] = $post;
    }
    // Sort by date desc
    usort($posts, function($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });
}
?>

<section class="py-16">
    <div class="max-w-[1200px] mx-auto px-4">
        <!-- Fluid Grid: 1 col mobile, 2 col tablet, 3 col desktop -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($posts as $post): ?>
            <article class="bg-surface border-2 border-border rounded-xl shadow-soft flex flex-col overflow-hidden transition-transform hover:-translate-y-1.5 hover:shadow-hover group h-full">
                <div class="h-[200px] bg-gray-200 bg-cover bg-center border-b-2 border-border" style="background-image: url('<?php echo $post['image']; ?>');"></div>
                <div class="p-6 flex-1 flex flex-col">
                    <span class="block text-sm font-bold text-primary uppercase mb-2"><?php echo date('d M Y', strtotime($post['date'])); ?></span>
                    <h3 class="text-xl font-extrabold mb-3 leading-tight"><?php echo $post['title']; ?></h3>
                    <p class="mb-4 text-gray-700 text-sm flex-1"><?php echo $post['excerpt']; ?></p>
                    <a href="news-post.php?slug=<?php echo $post['slug']; ?>" class="inline-block font-bold text-text border-b-2 border-accent uppercase text-sm hover:text-primary hover:border-primary transition-colors self-start">Lire la suite</a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>

        <!-- Pagination (Static for now) -->
        <div class="mt-16 flex justify-center items-center gap-2">
            <a href="#" class="w-10 h-10 flex items-center justify-center rounded-lg border-2 border-border bg-white text-gray-400 cursor-not-allowed font-bold hover:bg-gray-50 transition-colors" aria-disabled="true">&larr;</a>
            <a href="#" class="w-10 h-10 flex items-center justify-center rounded-lg border-2 border-primary bg-primary text-white font-bold shadow-soft">1</a>
            <a href="#" class="w-10 h-10 flex items-center justify-center rounded-lg border-2 border-border bg-white text-text font-bold hover:bg-primary-light hover:text-primary hover:border-primary transition-colors">2</a>
            <a href="#" class="w-10 h-10 flex items-center justify-center rounded-lg border-2 border-border bg-white text-text font-bold hover:bg-primary-light hover:text-primary hover:border-primary transition-colors">&rarr;</a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
