<?php
/**
 * Header snippet for Meyrin CTT Kirby Theme
 * 
 * This snippet contains the opening HTML tags, head section, and header/navigation.
 * Reused across all templates.
 */
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title><?= $page->title()->esc() ?> | <?= $site->title()->esc() ?></title>
    <meta name="description" content="<?= $page->metaDescription()->or($site->site_description())->esc() ?>">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&display=swap" rel="stylesheet">

    <!-- Tailwind CSS v4 CDN -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    
    <style type="text/tailwindcss">
        @theme {
            --color-primary: <?= $site->color_primary()->or('#0056b3') ?>;
            --color-primary-light: <?= $site->color_primary_light()->or('#e3f2fd') ?>;
            --color-primary-dark: <?= $site->color_primary_dark()->or('#003d82') ?>;
            --color-bg: <?= $site->color_bg()->or('#f8f9fa') ?>;
            --color-surface: <?= $site->color_surface()->or('#ffffff') ?>;
            --color-text: <?= $site->color_text()->or('#1a1a1a') ?>;
            --color-border: <?= $site->color_border()->or('#004494') ?>;
            --color-accent: <?= $site->color_accent()->or('#d32f2f') ?>;

            --font-heading: <?= $site->font_heading()->or("'Space Grotesk', sans-serif") ?>;
            --font-body: <?= $site->font_body()->or("'DM Sans', sans-serif") ?>;

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
    </style>
</head>

<body class="bg-bg text-text leading-relaxed overflow-x-hidden antialiased flex flex-col min-h-screen">

    <!-- Announcement Banner -->
    <?php if ($site->announcement_enabled()->toBool()): ?>
    <div id="announcement-banner" class="bg-accent text-white py-2 px-4 relative z-[60]">
        <div class="max-w-[1200px] mx-auto flex justify-between items-center">
            <p class="text-sm font-bold text-center w-full">
                <?php if ($site->announcement_icon()->isNotEmpty()): ?>
                    <?= $site->announcement_icon()->esc() ?>
                <?php endif ?>
                <?= $site->announcement_text()->esc() ?>
            </p>
            <button id="close-banner" class="text-white hover:text-white/80 font-bold ml-4" aria-label="Fermer">&times;</button>
        </div>
    </div>
    <?php endif ?>

    <header class="py-4 bg-bg/95 border-b-2 border-border sticky top-0 z-50 backdrop-blur-sm">
        <div class="max-w-[1200px] mx-auto px-4 flex justify-between items-center relative z-10">
            <a href="<?= $site->url() ?>" class="flex items-center gap-3">
                <?php if ($logo = $site->logo()->toFile()): ?>
                    <img src="<?= $logo->url() ?>" alt="<?= $site->title()->esc() ?> Logo" class="h-12 w-auto">
                <?php else: ?>
                    <img src="<?= url('assets/logo.png') ?>" alt="<?= $site->title()->esc() ?> Logo" class="h-12 w-auto">
                <?php endif ?>
                <span class="text-3xl font-black text-primary uppercase tracking-tighter"><?= $site->title()->esc() ?></span>
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
