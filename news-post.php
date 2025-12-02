<?php
$config = require __DIR__ . '/config.php';

$slug = $_GET['slug'] ?? null;
$post_file = __DIR__ . '/content/news/' . $slug . '.php';

if (!$slug || !file_exists($post_file)) {
    header('Location: news.php');
    exit;
}

$post = include $post_file;

$page_title = $post['title'] . " - " . $config['site_name'];
$hero_title = $post['title'];
$hero_subtitle = date('d M Y', strtotime($post['date']));
$hero_bg = $post['image']; // Use post image as hero bg

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/hero.php';
?>

<section class="py-16">
    <div class="max-w-[800px] mx-auto px-4 prose lg:prose-xl">
        <!-- <img src="<?php echo $post['image']; ?>" alt="<?php echo $post['title']; ?>" class="w-full rounded-xl border-2 border-border shadow-soft mb-8"> -->
        
        <?php echo $post['content']; ?>
        
        <div class="mt-12 pt-8 border-t-2 border-border">
            <a href="news.php" class="font-bold text-primary hover:underline">&larr; Retour aux actualités</a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
