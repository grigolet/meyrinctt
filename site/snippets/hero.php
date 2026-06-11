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
$bgImage = $image
    ?? $page->hero_image()->toFile()
    ?? $site->default_hero_image()->toFile()
    ?? null;
?>

<section class="site-hero py-32 bg-bg border-b-2 border-border relative overflow-hidden">
    <?php if ($bgImage): ?>
        <?php snippet('responsive-image', [
            'image' => $bgImage,
            'alt' => '',
            'preset' => 'cover',
            'sizes' => '100vw',
            'class' => 'absolute inset-0 w-full h-full object-cover z-0',
            'lazy' => false,
            'fetchpriority' => 'high',
            'width' => 1600,
            'height' => 900
        ]) ?>
    <?php else: ?>
        <img src="<?= url('assets/hero.webp') ?>" alt="" class="absolute inset-0 w-full h-full object-cover z-0" decoding="async" fetchpriority="high">
    <?php endif ?>
    <div class="absolute top-0 left-0 w-full h-full bg-black/50 z-0 pointer-events-none"></div>

    <div class="hero-balls absolute top-0 left-0 w-full pointer-events-none z-0" aria-hidden="true">
        <div class="ball absolute bg-white/10 rounded-full w-10 h-10 animate-float"></div>
        <div class="ball absolute bg-white/10 rounded-full w-10 h-10 animate-float"></div>
        <div class="ball absolute bg-white/10 rounded-full w-10 h-10 animate-float"></div>
        <div class="ball absolute bg-white/10 rounded-full w-10 h-10 animate-float"></div>
        <div class="ball absolute bg-white/10 rounded-full w-10 h-10 animate-float"></div>
    </div>

    <div class="max-w-[900px] mx-auto px-4 text-center relative z-10">
        <h1 class="text-5xl md:text-7xl font-extrabold mb-4 text-white leading-none normal-case tracking-tight drop-shadow-[0_4px_4px_rgba(0,0,0,0.5)] text-shadow-lg/30">
            <?= Str::esc($title) ?>
        </h1>
        <?php if ($subtitle): ?>
        <p class="text-xl md:text-2xl font-bold text-white max-w-[700px] mx-auto drop-shadow-[0_2px_2px_rgba(0,0,0,0.5)] text-shadow-lg/30">
            <?= Str::esc($subtitle) ?>
        </p>
        <?php endif ?>
    </div>
</section>
