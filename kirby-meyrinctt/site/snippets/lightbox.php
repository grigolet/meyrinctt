<?php
/**
 * Lightbox snippet
 * 
 * A modal lightbox for viewing images in full screen.
 * Include this snippet once on pages that need it (albums, galleries).
 * 
 * Usage: snippet('lightbox', ['images' => $imageCollection])
 */

$images = $images ?? [];
$imageUrls = [];
$imageThumbUrls = [];

foreach ($images as $image) {
    if (is_object($image) && method_exists($image, 'url')) {
        $imageUrls[] = $image->url();
        $imageThumbUrls[] = $image->resize(100)->url();
    } elseif (is_string($image)) {
        $imageUrls[] = $image;
        $imageThumbUrls[] = $image;
    }
}
?>

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
    const lightboxImages = <?= json_encode($imageUrls, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_SLASHES) ?>;
    const lightboxThumbs = <?= json_encode($imageThumbUrls, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_SLASHES) ?>;
    let currentIndex = 0;

    function openLightbox(index) {
        currentIndex = index;
        updateLightbox();
        lightbox.classList.remove('hidden');
        lightbox.showModal();
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        lightbox.close();
        lightbox.classList.add('hidden');
        document.body.style.overflow = '';
    }

    function updateLightbox() {
        if (lightboxImages.length > 0) {
            // Progressive loading: show thumbnail first, then full image
            lightboxImg.style.opacity = '0.5';
            lightboxImg.src = lightboxThumbs[currentIndex];
            
            const fullImg = new Image();
            fullImg.onload = function() {
                lightboxImg.src = fullImg.src;
                lightboxImg.style.opacity = '1';
            };
            fullImg.src = lightboxImages[currentIndex];
            
            lightboxCounter.textContent = `${currentIndex + 1} / ${lightboxImages.length}`;
            
            // Preload next and previous images
            if (lightboxImages[currentIndex + 1]) {
                new Image().src = lightboxImages[currentIndex + 1];
            }
            if (currentIndex > 0 && lightboxImages[currentIndex - 1]) {
                new Image().src = lightboxImages[currentIndex - 1];
            }
        }
    }

    function nextImage() {
        currentIndex = (currentIndex + 1) % lightboxImages.length;
        updateLightbox();
    }

    function prevImage() {
        currentIndex = (currentIndex - 1 + lightboxImages.length) % lightboxImages.length;
        updateLightbox();
    }

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (!lightbox.open) return;
        if (e.key === 'ArrowRight') nextImage();
        if (e.key === 'ArrowLeft') prevImage();
        if (e.key === 'Escape') closeLightbox();
    });

    // Touch swipe support
    let touchStartX = 0;
    lightbox.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
    });
    lightbox.addEventListener('touchend', (e) => {
        const diff = touchStartX - e.changedTouches[0].screenX;
        if (Math.abs(diff) > 50) {
            if (diff > 0) nextImage();
            else prevImage();
        }
    });
</script>
