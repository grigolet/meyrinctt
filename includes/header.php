<?php
$config = require __DIR__ . '/../config.php';
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? $config['site_name']; ?></title>
    <meta name="description" content="<?php echo $page_description ?? $config['site_name']; ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS v4 CDN -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

    <style type="text/tailwindcss">
        @theme {
            --color-primary: <?php echo $config['theme']['colors']['primary']; ?>;
            --color-primary-light: <?php echo $config['theme']['colors']['primary-light']; ?>;
            --color-bg: <?php echo $config['theme']['colors']['bg']; ?>;
            --color-surface: <?php echo $config['theme']['colors']['surface']; ?>;
            --color-text: <?php echo $config['theme']['colors']['text']; ?>;
            --color-border: <?php echo $config['theme']['colors']['border']; ?>;
            --color-accent: <?php echo $config['theme']['colors']['accent']; ?>;
            
            --font-sans: <?php echo $config['theme']['fonts']['sans']; ?>;
            
            --shadow-soft: 4px 4px 0px rgba(0, 86, 179, 0.15);
            --shadow-hover: 6px 6px 0px rgba(0, 86, 179, 0.25);
            
            --animate-float: float 20s infinite linear;
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

        @keyframes swing {
            0%, 100% { transform: rotate(-3deg); }
            50% { transform: rotate(3deg); }
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

        /* Custom utility for the ball animation delays/positions */
        .ball:nth-child(1) { top: 0%; left: 0%; animation-duration: 20s; animation-delay: 0s; }
        .ball:nth-child(2) { top: 70%; left: 80%; width: 60px; height: 60px; animation-duration: 25s; animation-delay: -5s; }
        .ball:nth-child(3) { top: 40%; left: 20%; width: 30px; height: 30px; opacity: 0.4; animation-duration: 18s; animation-delay: -10s; }
        .ball:nth-child(4) { top: 80%; left: 15%; animation-duration: 22s; animation-delay: -2s; }
        .ball:nth-child(5) { top: 20%; left: 90%; width: 50px; height: 50px; animation-duration: 28s; animation-delay: -8s; }
    </style>
</head>

<body class="font-sans bg-bg text-text leading-relaxed overflow-x-hidden antialiased flex flex-col min-h-screen">

    <!-- Announcement Banner -->
    <?php if ($config['announcement_banner']['enabled']): ?>
    <div id="announcement-banner" class="bg-accent text-white py-2 px-4 relative z-[60]">
        <div class="max-w-[1200px] mx-auto flex justify-between items-center">
            <p class="text-sm font-bold text-center w-full"><?php echo htmlspecialchars($config['announcement_banner']['text']); ?></p>
            <button id="close-banner" class="text-white hover:text-white/80 font-bold ml-4" aria-label="Fermer">&times;</button>
        </div>
    </div>
    <?php endif; ?>

    <header class="py-4 bg-bg/95 border-b-2 border-border sticky top-0 z-50 backdrop-blur-sm">
        <div class="max-w-[1200px] mx-auto px-4 flex justify-between items-center relative z-10">
            <a href="index.php" class="flex items-center gap-3">
                <img src="assets/logo.png" alt="<?php echo $config['site_name']; ?> Logo" class="h-12 w-auto">
                <span class="text-3xl font-black text-primary uppercase tracking-tighter"><?php echo $config['site_name']; ?></span>
            </a>

            <button class="mobile-menu-toggle md:hidden p-2 cursor-pointer bg-transparent" aria-label="Menu">
                <span class="block w-6 h-[3px] bg-text relative before:content-[''] before:absolute before:w-full before:h-[3px] before:bg-text before:left-0 before:-top-2 after:content-[''] after:absolute after:w-full after:h-[3px] after:bg-text after:left-0 after:-bottom-2"></span>
            </button>

            <?php include __DIR__ . '/nav.php'; ?>
        </div>
    </header>

    <?php if ($config['holiday_decorations']): ?>
    <!-- Christmas Decorations -->
    <div class="christmas-decorations">
        <!-- Light String Container -->
        <svg id="light-string-svg" class="light-string" xmlns="http://www.w3.org/2000/svg">
            <!-- Wire path - will be dynamically generated -->
            <path id="light-wire" d="" stroke="#2d3748" stroke-width="2" fill="none" opacity="0.3"/>
            <!-- Lights container - will be dynamically populated -->
            <g id="lights-container"></g>
        </svg>

        <!-- Snowflakes -->
        <div id="snowflakes-container"></div>
    </div>

    <script>
        // Christmas Lights Dynamic Generation
        if (<?php echo $config['holiday_decorations'] ? 'true' : 'false'; ?>) {
            function generateChristmasLights() {
                const svg = document.getElementById('light-string-svg');
                const wire = document.getElementById('light-wire');
                const container = document.getElementById('lights-container');

                // Get viewport width
                const width = window.innerWidth;
                const height = 50;

                // Update SVG viewBox to match viewport
                svg.setAttribute('viewBox', `0 0 ${width} ${height}`);

                // Generate wire path (curved string)
                const numSegments = Math.ceil(width / 200);
                let pathData = 'M0,10';
                for (let i = 1; i <= numSegments; i++) {
                    const x = i * 200;
                    pathData += ` Q${x - 100},25 ${x},10`;
                }
                pathData += ` T${width},10`;
                wire.setAttribute('d', pathData);

                // Clear existing lights
                container.innerHTML = '';

                // Generate lights based on viewport width
                const lightSpacing = 100; // Space between lights
                const numLights = Math.floor(width / lightSpacing);
                const colors = ['#ef4444', '#3b82f6', '#fbbf24', '#10b981', '#8b5cf6'];

                for (let i = 0; i < numLights; i++) {
                    const x = 50 + (i * lightSpacing);
                    const y = (i % 2 === 0) ? 10 : 25; // Alternate heights
                    const color = colors[i % colors.length];
                    const animDuration = (1.5 + (Math.random() * 1)).toFixed(1); // 1.5s - 2.5s

                    const circle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
                    circle.setAttribute('cx', x);
                    circle.setAttribute('cy', y);
                    circle.setAttribute('r', 6);
                    circle.setAttribute('fill', color);
                    circle.setAttribute('opacity', 0.8);

                    // Add animation
                    const animate = document.createElementNS('http://www.w3.org/2000/svg', 'animate');
                    animate.setAttribute('attributeName', 'opacity');
                    animate.setAttribute('values', '0.3;1;0.3');
                    animate.setAttribute('dur', `${animDuration}s`);
                    animate.setAttribute('repeatCount', 'indefinite');

                    circle.appendChild(animate);
                    container.appendChild(circle);
                }
            }

            // Generate lights on load
            generateChristmasLights();

            // Regenerate on window resize (debounced)
            let resizeTimer;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(generateChristmasLights, 250);
            });

            // Generate snowflakes
            const snowContainer = document.getElementById('snowflakes-container');
            const snowflakeCount = 30;

            const snowflakeSVG = (size) => `
                <svg width="${size}" height="${size}" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2L12 22M12 2L9 5M12 2L15 5M12 22L9 19M12 22L15 19" stroke="#e0f2fe" stroke-width="1.5" stroke-linecap="round"/>
                    <path d="M4.22 7L19.78 17M4.22 7L6.34 4.22M4.22 7L2 9.22M19.78 17L17.66 19.78M19.78 17L22 14.78" stroke="#e0f2fe" stroke-width="1.5" stroke-linecap="round"/>
                    <path d="M4.22 17L19.78 7M4.22 17L2 14.78M4.22 17L6.34 19.78M19.78 7L22 9.22M19.78 7L17.66 4.22" stroke="#e0f2fe" stroke-width="1.5" stroke-linecap="round"/>
                    <circle cx="12" cy="12" r="2" fill="#e0f2fe"/>
                </svg>
            `;

            for (let i = 0; i < snowflakeCount; i++) {
                const snowflake = document.createElement('div');
                snowflake.className = 'snowflake';
                const size = Math.random() * 15 + 10; // 10-25px
                snowflake.innerHTML = snowflakeSVG(size);
                snowflake.style.left = Math.random() * 100 + '%';
                snowflake.style.animationDuration = (Math.random() * 10 + 10) + 's'; // 10-20s
                snowflake.style.animationDelay = Math.random() * 5 + 's';
                snowflake.style.opacity = Math.random() * 0.6 + 0.4; // 0.4-1
                snowContainer.appendChild(snowflake);
            }
        }
    </script>
    <?php endif; ?>

    <!-- Sidebar (Opt-in) -->
    <!-- Uncomment to enable sidebar
    <aside class="fixed top-0 left-0 h-screen w-64 bg-surface border-r-2 border-border z-40 hidden md:flex flex-col p-6 shadow-soft">
        <a href="index.php" class="text-2xl font-black text-primary uppercase tracking-tighter mb-12"><?php echo $config['site_name']; ?></a>
        <?php // include __DIR__ . '/nav_sidebar.php'; ?>
        <div class="mt-auto">
            <a href="#inscription" class="block w-full py-3 bg-primary text-white text-center font-bold uppercase rounded-lg shadow-soft hover:shadow-hover transition-all">S'inscrire</a>
        </div>
    </aside>
    -->

    <main class="flex-grow">
