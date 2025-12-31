<?php
$config = require __DIR__ . '/config.php';
$page_title = "Galerie - " . $config['site_name'];
require_once __DIR__ . '/includes/functions.php';

// Trigger optimization on page load (for prototype simplicity)
// In production, this should be a background job or CLI script
// optimize_images(__DIR__, $config);

$albums = get_albums(__DIR__);

$hero_title = "Galerie";
$hero_subtitle = "Retrouvez les photos et vidéos de nos événements.";
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/hero.php';
?>

<section class="py-16">
    <div class="max-w-[1200px] mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($albums as $index => $album): ?>
                <a href="album.php?name=<?php echo urlencode($album['name']); ?>" class="block bg-surface border-2 border-border rounded-xl shadow-soft transition-transform hover:-translate-y-1.5 hover:shadow-hover overflow-hidden group">
                    <?php if ($album['cover']): ?>
                        <div class="h-[240px] border-b-2 border-border bg-cover bg-center" style="background-image: url('<?php echo htmlspecialchars($album['cover']); ?>');"></div>
                    <?php else: ?>
                        <div class="h-[240px] border-b-2 border-border bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-400 font-bold text-4xl">?</span>
                        </div>
                    <?php endif; ?>
                    
                    <div class="p-6">
                        <!-- Extract date from folder name if possible, otherwise generic -->
                        <span class="block text-sm font-bold text-primary uppercase mb-2">Album</span>
                        <h3 class="text-xl font-extrabold mb-2 leading-tight"><?php echo htmlspecialchars($album['name']); ?></h3>
                        <p class="text-sm text-gray-600"><?php echo $album['count']; ?> photos</p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Lightbox removed from here as it is now in album.php -->

<?php include __DIR__ . '/includes/footer.php'; ?>

