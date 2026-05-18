<?php
/**
 * Lightbox snippet
 * 
 * A modal lightbox for viewing images and videos in full screen.
 * Include this snippet once on pages that need it (albums, galleries).
 * 
 * Usage: snippet('lightbox', ['files' => $fileCollection]) or snippet('lightbox', ['images' => $imageCollection])
 */

// Support both 'files' and 'images' parameters for backwards compatibility
$files = $files ?? $images ?? [];
$youtubeVideos = $youtubeVideos ?? [];
$mediaItems = [];

// Add uploaded files (photos and videos)
foreach ($files as $file) {
    if (is_object($file) && method_exists($file, 'url')) {
        // Better video detection for uploaded videos
        $isVideo = $file->type() === 'video' || 
                   in_array($file->extension(), ['mp4', 'webm', 'mov', 'avi', 'mkv', 'ogg']);
        
        $mediaItems[] = [
            'url' => $file->url(),
            'type' => $isVideo ? 'video' : 'image',
            'mime' => $file->mime(),
            'alt' => $file->alt()->or('Media')->value(),
            'title' => $file->title()->isNotEmpty() ? $file->title()->value() : '',
            'caption' => $file->caption()->isNotEmpty() ? $file->caption()->value() : ''
        ];
    } elseif (is_string($file)) {
        // Fallback for string URLs (assumes image)
        $mediaItems[] = [
            'url' => $file,
            'type' => 'image',
            'mime' => 'image/jpeg',
            'alt' => 'Media',
            'title' => '',
            'caption' => ''
        ];
    }
}

// Add YouTube videos from structure field
foreach ($youtubeVideos as $ytVideo) {
    if ($ytVideo->youtube_url()->isNotEmpty()) {
        // Extract YouTube video ID
        $youtubeUrl = $ytVideo->youtube_url()->value();
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $youtubeUrl, $matches);
        $videoId = $matches[1] ?? '';
        $embedUrl = $videoId ? "https://www.youtube.com/embed/{$videoId}?autoplay=1" : '';
        
        if ($embedUrl) {
            $mediaItems[] = [
                'url' => $embedUrl,
                'type' => 'youtube',
                'mime' => '',
                'alt' => $ytVideo->title()->or('Vidéo YouTube')->value(),
                'title' => $ytVideo->title()->isNotEmpty() ? $ytVideo->title()->value() : '',
                'caption' => $ytVideo->caption()->isNotEmpty() ? $ytVideo->caption()->value() : ''
            ];
        }
    }
}
?>

<!-- Lightbox Modal -->
<dialog id="lightbox" class="fixed inset-0 z-[100] w-full h-full bg-black/95 p-0 m-0 max-w-none max-h-none border-none backdrop:bg-black/95 open:flex flex-col items-center justify-center hidden outline-none">
    
    <!-- Toolbar -->
    <div class="absolute top-0 left-0 w-full p-4 flex justify-between items-center z-[110] text-white bg-gradient-to-b from-black/50 to-transparent">
        <div class="flex-1 mr-4">
            <span id="lightbox-counter" class="font-bold text-sm"></span>
            <div id="lightbox-info" class="mt-1 max-w-2xl">
                <h3 id="lightbox-title" class="font-semibold text-base hidden"></h3>
                <p id="lightbox-caption" class="text-sm text-gray-300 mt-1 hidden"></p>
            </div>
        </div>
        <button onclick="closeLightbox()" class="text-4xl leading-none hover:text-gray-300 focus:outline-none flex-shrink-0">&times;</button>
    </div>

    <!-- Navigation Buttons -->
    <button onclick="prevMedia()" class="absolute left-4 top-1/2 -translate-y-1/2 text-white text-5xl hover:text-gray-300 z-[110] focus:outline-none hidden md:block">&lsaquo;</button>
    <button onclick="nextMedia()" class="absolute right-4 top-1/2 -translate-y-1/2 text-white text-5xl hover:text-gray-300 z-[110] focus:outline-none hidden md:block">&rsaquo;</button>

    <!-- Media Container -->
    <div class="w-full h-full flex items-center justify-center p-4 md:p-12" onclick="event.target === this && closeLightbox()">
        <img id="lightbox-img" src="" alt="Full screen" class="max-w-full max-h-full object-contain shadow-2xl transition-opacity duration-300" style="display: none;" onclick="event.stopPropagation()">
        <video id="lightbox-video" controls preload="auto" class="max-w-full max-h-full shadow-2xl transition-opacity duration-300" style="display: none; background: black;" onclick="event.stopPropagation()">
            Your browser does not support the video element.
        </video>
        <iframe id="lightbox-youtube" class="max-w-full max-h-full shadow-2xl" style="display: none; aspect-ratio: 16/9; max-width: 90vw; max-height: 90vh;" width="100%" height="100%" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen onclick="event.stopPropagation()"></iframe>
    </div>

</dialog>

<script>
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    const lightboxVideo = document.getElementById('lightbox-video');
    const lightboxYoutube = document.getElementById('lightbox-youtube');
    const lightboxCounter = document.getElementById('lightbox-counter');
    const lightboxTitle = document.getElementById('lightbox-title');
    const lightboxCaption = document.getElementById('lightbox-caption');
    const lightboxMedia = <?= json_encode($mediaItems) ?>;
    let currentIndex = 0;
    
    // Debug: log all media items
    console.log('Lightbox media items:', lightboxMedia);
    console.log('Total items:', lightboxMedia.length);

    function openLightbox(index) {
        console.log('Opening lightbox with index:', index);
        currentIndex = index;
        updateLightbox();
        lightbox.classList.remove('hidden');
        lightbox.showModal();
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        // Pause video if playing
        if (!lightboxVideo.classList.contains('hidden')) {
            lightboxVideo.pause();
            lightboxVideo.src = '';
        }
        // Stop YouTube video
        if (!lightboxYoutube.classList.contains('hidden')) {
            lightboxYoutube.src = '';
        }
        lightbox.close();
        lightbox.classList.add('hidden');
        document.body.style.overflow = '';
    }

    function updateLightbox() {
        if (lightboxMedia.length > 0) {
            const currentMedia = lightboxMedia[currentIndex];
            
            console.log('Loading media:', currentMedia); // Debug log
            
            // Hide all media elements first using inline styles
            lightboxImg.style.display = 'none';
            lightboxVideo.style.display = 'none';
            lightboxYoutube.style.display = 'none';
            
            // Stop/clear current media
            lightboxVideo.pause();
            lightboxVideo.src = '';
            lightboxYoutube.src = '';
            
            if (currentMedia.type === 'youtube') {
                // Show YouTube iframe
                lightboxYoutube.style.display = 'block';
                lightboxYoutube.src = currentMedia.url;
                console.log('YouTube iframe src set to:', lightboxYoutube.src);
            } else if (currentMedia.type === 'video') {
                // Show uploaded video
                lightboxVideo.style.display = 'block';
                
                // Set video source directly on the video element
                lightboxVideo.src = currentMedia.url;
                lightboxVideo.type = currentMedia.mime || 'video/mp4';
                
                // Load the video
                lightboxVideo.load();
                
                console.log('Video element src set to:', lightboxVideo.src);
                
                // Try to play after a small delay
                setTimeout(() => {
                    lightboxVideo.play().catch(e => {
                        console.log('Autoplay prevented, user must click play:', e);
                    });
                }, 100);
            } else {
                // Show image
                lightboxImg.style.display = 'block';
                lightboxImg.src = currentMedia.url;
                lightboxImg.alt = currentMedia.alt;
            }
            
            lightboxCounter.textContent = `${currentIndex + 1} / ${lightboxMedia.length}`;
            
            // Update title and caption - check for non-empty strings
            if (currentMedia.title && typeof currentMedia.title === 'string' && currentMedia.title.trim() !== '') {
                lightboxTitle.textContent = currentMedia.title;
                lightboxTitle.classList.remove('hidden');
            } else {
                lightboxTitle.textContent = '';
                lightboxTitle.classList.add('hidden');
            }
            
            if (currentMedia.caption && typeof currentMedia.caption === 'string' && currentMedia.caption.trim() !== '') {
                lightboxCaption.textContent = currentMedia.caption;
                lightboxCaption.classList.remove('hidden');
            } else {
                lightboxCaption.textContent = '';
                lightboxCaption.classList.add('hidden');
            }
        }
    }

    function nextMedia() {
        currentIndex = (currentIndex + 1) % lightboxMedia.length;
        updateLightbox();
    }

    function prevMedia() {
        currentIndex = (currentIndex - 1 + lightboxMedia.length) % lightboxMedia.length;
        updateLightbox();
    }

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (!lightbox.open) return;
        if (e.key === 'ArrowRight') nextMedia();
        if (e.key === 'ArrowLeft') prevMedia();
        if (e.key === 'Escape') closeLightbox();
        if (e.key === ' ' && !lightboxVideo.classList.contains('hidden')) {
            e.preventDefault();
            if (lightboxVideo.paused) {
                lightboxVideo.play();
            } else {
                lightboxVideo.pause();
            }
        }
    });

    // Touch swipe support
    let touchStartX = 0;
    lightbox.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
    });
    lightbox.addEventListener('touchend', (e) => {
        const diff = touchStartX - e.changedTouches[0].screenX;
        if (Math.abs(diff) > 50) {
            if (diff > 0) nextMedia();
            else prevMedia();
        }
    });
</script>
