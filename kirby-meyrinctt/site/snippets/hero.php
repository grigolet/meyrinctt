<?php
/**
 * Hero snippet for Meyrin CTT Kirby Theme
 * 
 * A reusable hero section with title, subtitle, and background image.
 * 
 * Usage: snippet('hero', ['title' => 'Page Title', 'subtitle' => 'Optional subtitle', 'image' => $imageObject])
 */

$title = $title ?? $page->hero_title()->or($page->title());
$subtitle = $subtitle ?? $page->hero_subtitle()->value();
$bgImage = $image ?? ($page->hasImages() ? $page->images()->find('hero.webp') : null);
?>

<section class="py-32 bg-bg border-b-2 border-border relative overflow-hidden">
    <?php if ($bgImage): ?>
    <div class="absolute top-0 left-0 w-full h-full z-0">
        <?php snippet('responsive-image', [
            'image' => $bgImage,
            'alt' => Str::esc($title),
            'preset' => 'cover',
            'sizes' => '100vw',
            'class' => 'w-full h-full object-cover',
            'lazy' => false,
            'width' => 1920,
            'height' => 600
        ]) ?>
    </div>
    <?php endif ?>
    <div class="absolute top-0 left-0 w-full h-full bg-black/30 z-0 pointer-events-none"></div>

    <div class="absolute top-0 left-0 w-full pointer-events-none z-0">
        <div class="ball absolute bg-white/10 rounded-full w-10 h-10 animate-float"></div>
        <div class="ball absolute bg-white/10 rounded-full w-10 h-10 animate-float"></div>
        <div class="ball absolute bg-white/10 rounded-full w-10 h-10 animate-float"></div>
        <div class="ball absolute bg-white/10 rounded-full w-10 h-10 animate-float"></div>
        <div class="ball absolute bg-white/10 rounded-full w-10 h-10 animate-float"></div>
    </div>

    <div class="max-w-[900px] mx-auto px-4 text-center relative z-10">
        <h1 class="text-5xl md:text-7xl font-black mb-4 text-white leading-none uppercase tracking-tighter drop-shadow-[0_4px_4px_rgba(0,0,0,0.5)] text-shadow-lg/30">
            <?= Str::esc($title) ?>
        </h1>
        <?php if ($subtitle): ?>
        <p class="text-xl md:text-2xl font-bold text-white max-w-[700px] mx-auto drop-shadow-[0_2px_2px_rgba(0,0,0,0.5)] text-shadow-lg/30">
            <?= Str::esc($subtitle) ?>
        </p>
        <?php endif ?>
    </div>
</section>
