<?php
/**
 * Header snippet for Meyrin CTT Kirby Theme
 * 
 * This snippet contains the opening HTML tags, head section, and header/navigation.
 * Reused across all templates.
 */
$activeSkin = $site->active_skin()->or('v2')->value();
$isModernSkin = $activeSkin === 'v2';
$cssVersion = @filemtime(kirby()->root('index') . '/assets/css/index.css') ?: null;
$fontStacks = [
    'space-grotesk' => "'Space Grotesk', sans-serif",
    'dm-sans' => "'DM Sans', sans-serif",
    'system' => "system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif",
];
$headingFontSetting = $site->font_heading()->value();
$bodyFontSetting = $site->font_body()->value();
$headingFont = $fontStacks[$headingFontSetting] ?? (in_array($headingFontSetting, $fontStacks, true) ? $headingFontSetting : $fontStacks['space-grotesk']);
$bodyFont = $fontStacks[$bodyFontSetting] ?? (in_array($bodyFontSetting, $fontStacks, true) ? $bodyFontSetting : $fontStacks['dm-sans']);
$themeAccent = $site->color_accent()->or($isModernSkin ? '#6ee7b7' : '#d32f2f');
$isArticlePage = $page->intendedTemplate()->name() === 'article';
$metaTitle = $isArticlePage ? $page->title()->value() : $page->title()->value() . ' | ' . $site->title()->value();
$metaDescription = $isArticlePage
    ? $page->excerpt()->or($page->metaDescription())->or($site->site_description())->value()
    : $page->metaDescription()->or($site->site_description())->value();
$metaDescription = trim(preg_replace('/\s+/', ' ', $metaDescription));
$metaUrl = $page->url();
$metaImage = null;

if ($isArticlePage && function_exists('meyrinctt_cover_image')) {
    $metaImage = meyrinctt_cover_image($page);
}

if (!$metaImage) {
    $metaImage = $page->hero_image()->toFile() ?? $site->default_hero_image()->toFile() ?? null;
}

$metaImageUrl = $metaImage
    ? $metaImage->thumb(['width' => 1200, 'height' => 630, 'crop' => true, 'format' => 'jpg', 'quality' => 85])->url()
    : url('assets/hero.webp');
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title><?= esc($metaTitle) ?></title>
    <meta name="description" content="<?= esc($metaDescription, 'attr') ?>">
    <link rel="canonical" href="<?= esc($metaUrl, 'attr') ?>">

    <meta property="og:type" content="<?= $isArticlePage ? 'article' : 'website' ?>">
    <meta property="og:locale" content="fr_CH">
    <meta property="og:site_name" content="<?= $site->title()->esc() ?>">
    <meta property="og:title" content="<?= esc($metaTitle, 'attr') ?>">
    <meta property="og:description" content="<?= esc($metaDescription, 'attr') ?>">
    <meta property="og:url" content="<?= esc($metaUrl, 'attr') ?>">
    <meta property="og:image" content="<?= esc($metaImageUrl, 'attr') ?>">
    <meta property="og:image:secure_url" content="<?= esc($metaImageUrl, 'attr') ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <?php if ($isArticlePage && $page->date()->isNotEmpty()): ?>
    <meta property="article:published_time" content="<?= esc(date('c', $page->date()->toDate('U')), 'attr') ?>">
    <?php endif ?>

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= esc($metaTitle, 'attr') ?>">
    <meta name="twitter:description" content="<?= esc($metaDescription, 'attr') ?>">
    <meta name="twitter:image" content="<?= esc($metaImageUrl, 'attr') ?>">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&display=swap" rel="stylesheet">

    <!-- Tailwind CSS v4 CDN -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    
    <!-- Swiper.js for carousel -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= url('assets/css/index.css') ?><?= $cssVersion ? '?v=' . $cssVersion : '' ?>">
    
    <style type="text/tailwindcss">
        @theme {
            --color-primary: <?= $isModernSkin ? '#0056b3' : $site->color_primary()->or('#0056b3') ?>;
            --color-primary-light: <?= $isModernSkin ? '#eef7ff' : $site->color_primary_light()->or('#e3f2fd') ?>;
            --color-primary-dark: <?= $isModernSkin ? '#003d82' : $site->color_primary_dark()->or('#003d82') ?>;
            --color-bg: <?= $isModernSkin ? '#f6fbff' : $site->color_bg()->or('#f8f9fa') ?>;
            --color-surface: <?= $isModernSkin ? '#ffffff' : $site->color_surface()->or('#ffffff') ?>;
            --color-text: <?= $isModernSkin ? '#102033' : $site->color_text()->or('#1a1a1a') ?>;
            --color-border: <?= $isModernSkin ? '#c9deef' : $site->color_border()->or('#004494') ?>;
            --color-accent: <?= $themeAccent ?>;

            --font-heading: <?= $headingFont ?>;
            --font-body: <?= $bodyFont ?>;

            --shadow-soft: 4px 4px 0px rgba(0, 86, 179, 0.15);
            --shadow-hover: 6px 6px 0px rgba(0, 86, 179, 0.25);

            --animate-float: float 20s infinite linear;
        }

        /* Font pairing: Space Grotesk for headings, DM Sans for body */
        body {
            font-family: var(--font-body);
        }

        h1, h2, h3, h4, h5, h6,
        .font-heading,
        nav a,
        button,
        .btn-primary {
            font-family: var(--font-heading);
        }

        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -50px) rotate(120deg); }
            66% { transform: translate(-20px, 20px) rotate(240deg); }
            100% { transform: translate(0, 0) rotate(360deg); }
        }

        @keyframes snowfall {
            0% { transform: translateY(-10px) rotate(0deg); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(100vh) rotate(360deg); opacity: 0; }
        }

        @keyframes twinkle {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 1; }
        }

        .snowflake {
            position: fixed;
            top: -10px;
            z-index: 9999;
            pointer-events: none;
            animation: snowfall linear infinite;
        }

        .christmas-light {
            position: fixed;
            top: 0;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            z-index: 9998;
            pointer-events: none;
            animation: twinkle 2s ease-in-out infinite;
        }

        .light-string {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 50px;
            z-index: 9997;
            pointer-events: none;
            overflow: visible;
        }

        /* Ball animation positions */
        .ball:nth-child(1) { top: 0%; left: 0%; animation-duration: 20s; animation-delay: 0s; }
        .ball:nth-child(2) { top: 70%; left: 80%; width: 60px; height: 60px; animation-duration: 25s; animation-delay: -5s; }
        .ball:nth-child(3) { top: 40%; left: 20%; width: 30px; height: 30px; opacity: 0.4; animation-duration: 18s; animation-delay: -10s; }
        .ball:nth-child(4) { top: 80%; left: 15%; animation-duration: 22s; animation-delay: -2s; }
        .ball:nth-child(5) { top: 20%; left: 90%; width: 50px; height: 50px; animation-duration: 28s; animation-delay: -8s; }

        body.skin-modern {
            --color-accent: <?= $themeAccent ?>;
        }
    </style>
</head>

<body class="<?= $isModernSkin ? 'skin-modern ' : '' ?>bg-bg text-text leading-relaxed overflow-x-hidden antialiased flex flex-col min-h-screen" style="--color-accent: <?= esc($themeAccent, 'attr') ?>">

    <!-- Announcement Banner -->
    <?php
    $announcementText = $site->announcement_text();
    $announcementIcon = $site->announcement_icon();
    $announcementId = substr(sha1($announcementIcon->value() . '|' . $announcementText->value()), 0, 12);
    ?>
    <?php if ($site->announcement_enabled()->toBool() && $announcementText->isNotEmpty()): ?>
    <div id="announcement-banner" data-announcement-id="<?= $announcementId ?>" class="text-white py-2 px-4 relative z-[60]" style="background-color: <?= esc($themeAccent, 'attr') ?>">
        <div class="max-w-[1200px] mx-auto flex justify-between items-center">
            <div class="announcement-text text-sm font-bold text-center w-full">
                <?php if ($announcementIcon->isNotEmpty()): ?>
                    <?= $announcementIcon->esc() ?>
                <?php endif ?>
                <?= $announcementText->kti() ?>
            </div>
            <button id="close-banner" class="text-white hover:text-white/80 font-bold ml-4" aria-label="Fermer">&times;</button>
        </div>
    </div>
    <?php endif ?>

    <header class="site-header py-4 bg-bg/95 border-b-2 border-border sticky top-0 z-50 backdrop-blur-sm">
        <div class="max-w-[1200px] mx-auto px-4 flex justify-between items-center relative z-10">
            <a href="<?= $site->url() ?>" class="site-brand flex items-center gap-3">
                <?php if ($logo = $site->logo()->toFile()): ?>
                    <img src="<?= $logo->url() ?>" alt="<?= $site->title()->esc() ?> Logo" class="site-logo h-12 w-auto">
                <?php else: ?>
                    <img src="<?= url('assets/logo.png') ?>" alt="<?= $site->title()->esc() ?> Logo" class="site-logo h-12 w-auto">
                <?php endif ?>
                <span class="site-title text-3xl font-black text-primary uppercase tracking-tighter"><?= $site->title()->esc() ?></span>
            </a>

            <button class="mobile-menu-toggle md:hidden p-2 cursor-pointer bg-transparent" aria-label="Menu" aria-expanded="false">
                <span class="block w-6 h-[3px] bg-text relative before:content-[''] before:absolute before:w-full before:h-[3px] before:bg-text before:left-0 before:-top-2 after:content-[''] after:absolute after:w-full after:h-[3px] after:bg-text after:left-0 after:-bottom-2"></span>
            </button>

            <?php snippet('nav') ?>
        </div>
    </header>

    <?php if ($site->holiday_decorations()->toBool()): ?>
    <?php snippet('decorations') ?>
    <?php endif ?>

    <main class="flex-1">
