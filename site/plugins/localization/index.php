<?php

use Kirby\Cms\App as Kirby;

function meyrinctt_date($value, string $pattern = 'd MMMM y', string $locale = 'fr_CH'): string
{
    if (is_object($value) && method_exists($value, 'isEmpty') && $value->isEmpty()) {
        return '';
    }

    if (is_object($value) && method_exists($value, 'toDate')) {
        $timestamp = $value->toDate('U');
    } elseif (is_numeric($value)) {
        $timestamp = (int)$value;
    } else {
        $timestamp = strtotime((string)$value);
    }

    if ($timestamp === false || $timestamp === null) {
        return '';
    }

    if (class_exists(IntlDateFormatter::class)) {
        $formatter = new IntlDateFormatter(
            $locale,
            IntlDateFormatter::NONE,
            IntlDateFormatter::NONE,
            date_default_timezone_get() ?: 'Europe/Zurich',
            IntlDateFormatter::GREGORIAN,
            $pattern
        );

        $formatted = $formatter->format((int)$timestamp);

        if ($formatted !== false) {
            return $formatted;
        }
    }

    $months = [
        1 => 'janvier',
        2 => 'février',
        3 => 'mars',
        4 => 'avril',
        5 => 'mai',
        6 => 'juin',
        7 => 'juillet',
        8 => 'août',
        9 => 'septembre',
        10 => 'octobre',
        11 => 'novembre',
        12 => 'décembre',
    ];

    $day = date('j', (int)$timestamp);
    $month = $months[(int)date('n', (int)$timestamp)] ?? date('m', (int)$timestamp);
    $year = date('Y', (int)$timestamp);

    return $day . ' ' . $month . ' ' . $year;
}

Kirby::plugin('meyrinctt/localization', [
    'translations' => [
        'fr' => [
            'article.by' => 'Par',
            'article.readMore' => 'Lire la suite',
            'article.backToNews' => 'Retour aux actualités',
        ],
    ],
]);
