<?php
// Configuration

return [
    'site_name' => 'Meyrin CTT',
    'optimize_images' => true, // Enable/disable image optimization
    'replace_originals' => true, // Replace original images with optimized versions
    'holiday_decorations' => true, // Enable/disable winter holiday decorations
    'contact' => [
        'email_to' => 'helferjoan@hotmail.com', // Email address to receive contact form submissions
        'email_from' => 'noreply@meyrinctt.ch', // From email address
        'email_subject' => 'Nouveau message depuis le site Meyrin CTT', // Email subject
        'enable_notifications' => true, // Enable/disable email notifications
    ],
    'theme' => [
        'colors' => [
            'primary' => '#0056b3',
            'primary-light' => '#e3f2fd',
            'bg' => '#f8f9fa',
            'surface' => '#ffffff',
            'text' => '#1a1a1a',
            'border' => '#004494',
            'accent' => '#d32f2f',
        ],
        'fonts' => [
            'sans' => "'Inter', sans-serif",
        ],
    ],
];
