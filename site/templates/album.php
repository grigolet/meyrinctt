<?php
/**
 * Album page template
 * 
 * Displays a single photo album with lightbox.
 */
snippet('header');

// Get all files except cover images
$files = $page->files()->filterBy('template', '!=', 'cover')->sortBy('sort', 'asc');

// Get YouTube videos from structure field
$youtubeVideos = $page->youtube_videos()->toStructure();

// Combine total count
$totalCount = $files->count() + $youtubeVideos->count();

// Debug: Log what files we have
// Uncomment the next lines to debug
// echo "<!-- Files found: " . $files->count() . " | YouTube: " . $youtubeVideos->count() . " -->\n";

snippet('hero', [
    'title' => $page->title(),
    'subtitle' => $totalCount . ' ' . ($totalCount > 1 ? 'éléments' : 'élément')
]);

?>

<section class="py-16">
    <div class="max-w-[1200px] mx-auto px-4">
        <div class="mb-8">
            <a href="<?= $page->parent()->url() ?>" class="font-bold text-primary hover:underline">&larr; Retour à la galerie</a>
        </div>

        <?php if ($page->description()->isNotEmpty()): ?>
        <div class="mb-8">
            <p class="text-lg text-gray-700"><?= $page->description()->kt() ?></p>
        </div>
        <?php endif ?>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <?php $index = 0; ?>
            
            <?php // Display uploaded files (photos and videos) ?>
            <?php foreach ($files as $file): ?>
            <?php $isVideo = $file->type() === 'video' || $file->extension() === 'mp4' || $file->extension() === 'webm' || $file->extension() === 'mov'; ?>
<<<<<<< HEAD
            <div class="flex flex-col">
=======
>>>>>>> ac98036476495e09ea32adc4a6c52ff57f5a9306
            <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden cursor-pointer shadow-sm hover:shadow-md transition-all hover:scale-[1.02] relative" onclick="openLightbox(<?= $index ?>)">
                <?php if ($isVideo): ?>
                    <!-- Uploaded video thumbnail -->
                    <?php 
                    $posterImage = $file->poster()->toFile();
                    $posterUrl = $posterImage ? $posterImage->crop(400, 400)->url() : '';
                    ?>
                    <?php if ($posterUrl): ?>
                        <img src="<?= $posterUrl ?>" alt="<?= $file->alt()->or('Vidéo')->esc() ?>" class="w-full h-full object-cover" loading="lazy">
                    <?php else: ?>
                        <div class="w-full h-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center">
                            <svg class="w-20 h-20 text-white opacity-40" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"/>
                            </svg>
                        </div>
                    <?php endif ?>
                    <div class="absolute inset-0 flex items-center justify-center bg-black/30 pointer-events-none">
                        <svg class="w-16 h-16 text-white opacity-90 drop-shadow-lg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                    </div>
                <?php else: ?>
                    <!-- Image thumbnail -->
                    <?php snippet('responsive-image', [
                        'image' => $file,
                        'alt' => $file->alt()->or('Photo ' . ($index + 1))->esc(),
                        'preset' => 'thumbnail',
                        'sizes' => '(max-width: 768px) 50vw, (max-width: 1200px) 33vw, 25vw',
                        'class' => 'w-full h-full object-cover',
                        'lazy' => true,
                        'width' => 400,
                        'height' => 400
                    ]) ?>
                <?php endif ?>
<<<<<<< HEAD
            </div>
            <?php if ($file->title()->isNotEmpty() || $file->caption()->isNotEmpty()): ?>
            <div class="mt-2 px-1">
                <?php if ($file->title()->isNotEmpty()): ?>
                <h3 class="font-semibold text-sm text-gray-900"><?= $file->title()->esc() ?></h3>
                <?php endif ?>
                <?php if ($file->caption()->isNotEmpty()): ?>
                <p class="text-xs text-gray-600 mt-1"><?= $file->caption()->esc() ?></p>
                <?php endif ?>
            </div>
            <?php endif ?>
=======
>>>>>>> ac98036476495e09ea32adc4a6c52ff57f5a9306
            </div>
            <?php $index++; endforeach ?>
            
            <?php // Display YouTube videos ?>
            <?php foreach ($youtubeVideos as $ytVideo): ?>
            <?php if ($ytVideo->youtube_url()->isNotEmpty()): ?>
            <?php
                $youtubeUrl = $ytVideo->youtube_url()->value();
                preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $youtubeUrl, $matches);
                $videoId = $matches[1] ?? '';
                $thumbnailUrl = $videoId ? "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg" : '';
<<<<<<< HEAD
            ?>            <div class="flex flex-col">            <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden cursor-pointer shadow-sm hover:shadow-md transition-all hover:scale-[1.02] relative" onclick="openLightbox(<?= $index ?>)">
=======
            ?>
            <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden cursor-pointer shadow-sm hover:shadow-md transition-all hover:scale-[1.02] relative" onclick="openLightbox(<?= $index ?>)">
>>>>>>> ac98036476495e09ea32adc4a6c52ff57f5a9306
                <?php if ($thumbnailUrl): ?>
                    <img src="<?= $thumbnailUrl ?>" alt="<?= $ytVideo->title()->or('Vidéo YouTube')->esc() ?>" class="w-full h-full object-cover" loading="lazy">
                <?php else: ?>
                    <div class="w-full h-full bg-gradient-to-br from-red-500 to-red-700 flex items-center justify-center">
                        <svg class="w-20 h-20 text-white opacity-40" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M10 15l5.19-3L10 9v6m11.56-7.83c.13.47.22 1.1.28 1.9.07.8.1 1.49.1 2.09L22 12c0 2.19-.16 3.8-.44 4.83-.25.9-.83 1.48-1.73 1.73-.47.13-1.33.22-2.65.28-1.3.07-2.49.1-3.59.1L12 19c-4.19 0-6.8-.16-7.83-.44-.9-.25-1.48-.83-1.73-1.73-.13-.47-.22-1.1-.28-1.9-.07-.8-.1-1.49-.1-2.09L2 12c0-2.19.16-3.8.44-4.83.25-.9.83-1.48 1.73-1.73.47-.13 1.33-.22 2.65-.28 1.3-.07 2.49-.1 3.59-.1L12 5c4.19 0 6.8.16 7.83.44.9.25 1.48.83 1.73 1.73z"/>
                        </svg>
                    </div>
                <?php endif ?>
                <div class="absolute inset-0 flex items-center justify-center bg-black/30 pointer-events-none">
                    <svg class="w-16 h-16 text-white opacity-90 drop-shadow-lg" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M10 15l5.19-3L10 9v6m11.56-7.83c.13.47.22 1.1.28 1.9.07.8.1 1.49.1 2.09L22 12c0 2.19-.16 3.8-.44 4.83-.25.9-.83 1.48-1.73 1.73-.47.13-1.33.22-2.65.28-1.3.07-2.49.1-3.59.1L12 19c-4.19 0-6.8-.16-7.83-.44-.9-.25-1.48-.83-1.73-1.73-.13-.47-.22-1.1-.28-1.9-.07-.8-.1-1.49-.1-2.09L2 12c0-2.19.16-3.8.44-4.83.25-.9.83-1.48 1.73-1.73.47-.13 1.33-.22 2.65-.28 1.3-.07 2.49-.1 3.59-.1L12 5c4.19 0 6.8.16 7.83.44.9.25 1.48.83 1.73 1.73z"/>
                    </svg>
                </div>
            </div>
<<<<<<< HEAD
            <?php if ($ytVideo->title()->isNotEmpty() || $ytVideo->caption()->isNotEmpty()): ?>
            <div class="mt-2 px-1">
                <?php if ($ytVideo->title()->isNotEmpty()): ?>
                <h3 class="font-semibold text-sm text-gray-900"><?= $ytVideo->title()->esc() ?></h3>
                <?php endif ?>
                <?php if ($ytVideo->caption()->isNotEmpty()): ?>
                <p class="text-xs text-gray-600 mt-1"><?= $ytVideo->caption()->esc() ?></p>
                <?php endif ?>
            </div>
            <?php endif ?>
            </div>
=======
>>>>>>> ac98036476495e09ea32adc4a6c52ff57f5a9306
            <?php $index++; endif; endforeach ?>
        </div>
    </div>
</section>

<?php snippet('lightbox', ['files' => $files, 'youtubeVideos' => $youtubeVideos]) ?>

<?php snippet('footer') ?>
