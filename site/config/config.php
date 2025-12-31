<?php

/**
 * Kirby Configuration
 * 
 * The configuration options are documented here:
 * https://getkirby.com/docs/reference/system/options
 */

return [
    'debug' => true,

    // Turnstile captcha settings (testing keys)
    // See: https://developers.cloudflare.com/turnstile/troubleshooting/testing/
    'turnstile' => [
        'enabled' => true,
        'siteKey' => '1x00000000000000000000AA',           // Always passes (visible widget test key)
        'secretKey' => '1x0000000000000000000000000000000AA' // Always passes (test secret key)
    ],

    // Homepage settings
    'home' => 'accueil',
    
    // Panel settings
    'panel' => [
        'install' => true,
        'slug' => 'panel',
        'language' => 'fr'
    ],
    
    // Language settings
    'languages' => false,
    
    // Thumbnails
    'thumbs' => [
        'srcsets' => [
            'default' => [300, 600, 900, 1200, 1800],
            'cover' => [800, 1024, 1536, 2048],
            'card' => [400, 600, 800, 1200],
            'avatar' => [120, 240, 360],
            'thumbnail' => [200, 400, 600]
        ],
        'quality' => 80,
        'format' => 'webp',
        'presets' => [
            'avif' => ['format' => 'avif', 'quality' => 75],
            'webp' => ['format' => 'webp', 'quality' => 80],
            'card' => ['width' => 800, 'height' => 600, 'crop' => true],
            'avatar' => ['width' => 120, 'height' => 120, 'crop' => true],
            'thumbnail' => ['width' => 400, 'height' => 400, 'crop' => true]
        ]
    ],
    
    // Email settings - SMTP for smtp4dev local testing
    // Note: smtp4dev container maps internal port 25 to host port 2525
    'email' => [
        'transport' => [
            'type' => 'smtp',
            'host' => 'localhost',
            'port' => 2525,
            'security' => false
        ]
    ],
    
    // Cache settings
    'cache' => [
        'pages' => [
            'active' => false,
            'type' => 'file'
        ]
    ],
    
    // Custom routes
    'routes' => [
        // Redirect old URLs if needed
        [
            'pattern' => 'index.php',
            'action' => function() {
                go('/');
            }
        ],
        [
            'pattern' => 'news.php',
            'action' => function() {
                go('actualites');
            }
        ],
        [
            'pattern' => 'gallery.php',
            'action' => function() {
                go('galerie');
            }
        ],
        [
            'pattern' => 'contact.php',
            'action' => function() {
                go('contact');
            }
        ],
        [
            'pattern' => 'club.php',
            'action' => function() {
                go('club');
            }
        ],
        [
            'pattern' => 'horaires.php',
            'action' => function() {
                go('horaires');
            }
        ],
        [
            'pattern' => 'inscription.php',
            'action' => function() {
                go('inscription');
            }
        ]
    ]
];
