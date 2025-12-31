<?php
$config = require __DIR__ . '/config.php';
require_once __DIR__ . '/includes/functions.php';

$album_name = $_GET['name'] ?? null;
$images = $album_name ? get_album_images(__DIR__, $album_name) : [];

if (!$album_name || empty($images)) {
    // Redirect to gallery if album not found or empty
    header('Location: gallery.php');
    exit;
}

$page_title = htmlspecialchars($album_name) . " - " . $config['site_name'];
$hero_title = htmlspecialchars($album_name);
$hero_subtitle = count($images) . " photos";

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/hero.php';
?>

<section class="py-16">
    <div class="max-w-[1200px] mx-auto px-4">
        <div class="mb-8">
            <a href="gallery.php" class="font-bold text-primary hover:underline">&larr; Retour à la galerie</a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <?php foreach ($images as $index => $image): ?>
                <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden cursor-pointer shadow-sm hover:shadow-md transition-all hover:scale-[1.02]" onclick="openLightbox(<?php echo $index; ?>)">
                    <img src="<?php echo htmlspecialchars($image); ?>" alt="Photo <?php echo $index + 1; ?>" class="w-full h-full object-cover" loading="lazy">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Lightbox Modal -->
<dialog id="lightbox" class="fixed inset-0 z-[100] w-full h-full bg-black/95 p-0 m-0 max-w-none max-h-none border-none backdrop:bg-black/95 open:flex flex-col items-center justify-center hidden outline-none">
    
    <!-- Toolbar -->
    <div class="absolute top-0 left-0 w-full p-4 flex justify-between items-center z-[110] text-white bg-gradient-to-b from-black/50 to-transparent">
        <span id="lightbox-counter" class="font-bold text-sm"></span>
        <button onclick="closeLightbox()" class="text-4xl leading-none hover:text-gray-300 focus:outline-none">&times;</button>
    </div>

    <!-- Navigation Buttons -->
    <button onclick="prevImage()" class="absolute left-4 top-1/2 -translate-y-1/2 text-white text-5xl hover:text-gray-300 z-[110] focus:outline-none hidden md:block">&lsaquo;</button>
    <button onclick="nextImage()" class="absolute right-4 top-1/2 -translate-y-1/2 text-white text-5xl hover:text-gray-300 z-[110] focus:outline-none hidden md:block">&rsaquo;</button>

    <!-- Image Container -->
    <div class="w-full h-full flex items-center justify-center p-4 md:p-12" onclick="closeLightbox()">
        <img id="lightbox-img" src="" alt="Full screen" class="max-w-full max-h-full object-contain shadow-2xl transition-opacity duration-300" onclick="event.stopPropagation()">
    </div>

</dialog>

<script>
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    const lightboxCounter = document.getElementById('lightbox-counter');
    const images = <?php echo json_encode($images); ?>;
    let currentIndex = 0;

    function openLightbox(index) {
        currentIndex = index;
        updateLightbox();
        lightbox.classList.remove('hidden');
        lightbox.showModal();
        document.body.style.overflow = 'hidden'; // Prevent scrolling
    }

    function closeLightbox() {
        lightbox.close();
        lightbox.classList.add('hidden');
        document.body.style.overflow = ''; // Restore scrolling
    }

    function updateLightbox() {
        lightboxImg.src = images[currentIndex];
        lightboxCounter.textContent = `${currentIndex + 1} / ${images.length}`;
    }

    function nextImage() {
        currentIndex = (currentIndex + 1) % images.length;
        updateLightbox();
    }

    function prevImage() {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        updateLightbox();
    }

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (!lightbox.open) return;
        if (e.key === 'ArrowRight') nextImage();
        if (e.key === 'ArrowLeft') prevImage();
        if (e.key === 'Escape') closeLightbox();
    });

    // Swipe support for mobile
    let touchStartX = 0;
    let touchEndX = 0;

    lightbox.addEventListener('touchstart', e => {
        touchStartX = e.changedTouches[0].screenX;
    });

    lightbox.addEventListener('touchend', e => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    });

    function handleSwipe() {
        if (touchEndX < touchStartX - 50) nextImage();
        if (touchEndX > touchStartX + 50) prevImage();
    }
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
