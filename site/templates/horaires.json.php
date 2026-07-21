<?php

$timezone = new DateTimeZone('Europe/Zurich');
$today = new DateTimeImmutable('today', $timezone);

$parseDate = static function (?string $value, DateTimeImmutable $fallback) use ($timezone): DateTimeImmutable {
    if (!$value) {
        return $fallback;
    }

    try {
        return (new DateTimeImmutable($value, $timezone))->setTimezone($timezone)->setTime(0, 0);
    } catch (Throwable) {
        return $fallback;
    }
};

$seasonStart = $parseDate($page->season_start()->value(), $today->modify('-6 months'));
$seasonEnd = $parseDate($page->season_end()->value(), $today->modify('+6 months'));

if ($seasonEnd < $seasonStart) {
    [$seasonStart, $seasonEnd] = [$seasonEnd, $seasonStart];
}

$requestedStart = $parseDate(get('start'), $seasonStart);
$requestedEnd = $parseDate(get('end'), $seasonEnd->modify('+1 day'));

// FullCalendar's end boundary is exclusive. Keep accidental feed requests bounded.
if ($requestedEnd <= $requestedStart) {
    $requestedEnd = $requestedStart->modify('+8 days');
}

if ($requestedEnd > $requestedStart->modify('+400 days')) {
    $requestedEnd = $requestedStart->modify('+400 days');
}

$dayNumbers = [
    'lundi' => 1,
    'mardi' => 2,
    'mercredi' => 3,
    'jeudi' => 4,
    'vendredi' => 5,
    'samedi' => 6,
    'dimanche' => 7,
];

$categoryLabels = [
    'ecole' => 'École de tennis de table',
    'juniors' => 'Juniors',
    'adultes' => 'Adultes',
    'libre' => 'Entraînement libre',
    'competition' => 'Compétition',
    'autre' => 'Autre',
];

$colors = [
    'blue' => ['background' => '#0759b7', 'border' => '#003d82', 'text' => '#ffffff'],
    'green' => ['background' => '#23845b', 'border' => '#12603f', 'text' => '#ffffff'],
    'orange' => ['background' => '#d95f18', 'border' => '#a83f07', 'text' => '#ffffff'],
    'yellow' => ['background' => '#f5cf2e', 'border' => '#b88e00', 'text' => '#1f2937'],
    'purple' => ['background' => '#8054b3', 'border' => '#5e368f', 'text' => '#ffffff'],
    'grey' => ['background' => '#5f6b78', 'border' => '#3f4852', 'text' => '#ffffff'],
];

$closures = [];
if ($page->holidays()->isNotEmpty()) {
    foreach ($page->holidays()->toStructure() as $holiday) {
        if (!$holiday->exclude_courses()->toBool() || $holiday->start_date()->isEmpty()) {
            continue;
        }

        $start = $parseDate($holiday->start_date()->value(), $seasonStart);
        $end = $parseDate($holiday->end_date()->or($holiday->start_date())->value(), $start);

        if ($end < $start) {
            [$start, $end] = [$end, $start];
        }

        $closures[] = [$start, $end];
    }
}

$isClosed = static function (DateTimeImmutable $date) use ($closures): bool {
    foreach ($closures as [$start, $end]) {
        if ($date >= $start && $date <= $end) {
            return true;
        }
    }

    return false;
};

$events = [];

if ($page->courses()->isNotEmpty()) {
    foreach ($page->courses()->toStructure() as $activityIndex => $activity) {
        $title = trim((string)$activity->course_description()->value());
        $activityDescription = trim((string)$activity->details()->value());
        $activityDescriptionHtml = trim((string)$activity->details()->kirbytext());
        $defaultTrainer = trim((string)$activity->default_trainer()->value());
        $colorKey = $activity->color()->or('blue')->value();
        $color = $colors[$colorKey] ?? $colors['blue'];
        $categoryKey = $activity->category()->or('autre')->value();
        $activityValidFrom = $activity->valid_from()->isNotEmpty()
            ? $parseDate($activity->valid_from()->value(), $seasonStart)
            : $seasonStart;
        $activityValidUntil = $activity->valid_until()->isNotEmpty()
            ? $parseDate($activity->valid_until()->value(), $seasonEnd)
            : $seasonEnd;

        if ($title === '' || $activity->slots()->isEmpty()) {
            continue;
        }

        foreach ($activity->slots()->toStructure() as $slotIndex => $slot) {
            $dayKey = $slot->day()->value();
            $dayNumber = $dayNumbers[$dayKey] ?? null;
            $startTime = trim((string)$slot->start_time()->value());
            $endTime = trim((string)$slot->end_time()->value());

            if (!$dayNumber || $startTime === '' || $endTime === '') {
                continue;
            }

            $slotValidFrom = $slot->valid_from()->isNotEmpty()
                ? $parseDate($slot->valid_from()->value(), $activityValidFrom)
                : $activityValidFrom;
            $slotValidUntil = $slot->valid_until()->isNotEmpty()
                ? $parseDate($slot->valid_until()->value(), $activityValidUntil)
                : $activityValidUntil;
            $rangeStart = max($requestedStart, $seasonStart, $activityValidFrom, $slotValidFrom);
            $rangeEnd = min(
                $requestedEnd,
                $seasonEnd->modify('+1 day'),
                $activityValidUntil->modify('+1 day'),
                $slotValidUntil->modify('+1 day')
            );

            if ($rangeStart >= $rangeEnd) {
                continue;
            }

            $offset = ($dayNumber - (int)$rangeStart->format('N') + 7) % 7;
            $occurrenceDate = $rangeStart->modify('+' . $offset . ' days');
            $slotTrainer = trim((string)$slot->trainer()->value());
            $trainer = $slotTrainer !== '' ? $slotTrainer : $defaultTrainer;
            $slotNote = trim((string)$slot->slot_note()->value());
            $slotNoteHtml = trim((string)$slot->slot_note()->kirbytext());
            $description = implode("\n\n", array_filter([$activityDescription, $slotNote]));
            $descriptionHtml = implode("\n", array_filter([$activityDescriptionHtml, $slotNoteHtml]));

            while ($occurrenceDate < $rangeEnd) {
                if (!$isClosed($occurrenceDate)) {
                    $date = $occurrenceDate->format('Y-m-d');
                    $start = new DateTimeImmutable($date . 'T' . $startTime, $timezone);
                    $end = new DateTimeImmutable($date . 'T' . $endTime, $timezone);

                    if ($end > $start) {
                        $events[] = [
                            'id' => 'activity-' . $activityIndex . '-slot-' . $slotIndex . '-' . $date,
                            'groupId' => 'activity-' . $activityIndex,
                            'title' => $title,
                            'start' => $start->format('Y-m-d\TH:i:s'),
                            'end' => $end->format('Y-m-d\TH:i:s'),
                            'backgroundColor' => $color['background'],
                            'borderColor' => $color['border'],
                            'textColor' => $color['text'],
                            'classNames' => ['schedule-event', 'schedule-event--' . $colorKey],
                            'extendedProps' => [
                                'trainer' => $trainer,
                                'description' => $description,
                                'descriptionHtml' => $descriptionHtml,
                                'category' => $categoryLabels[$categoryKey] ?? $categoryLabels['autre'],
                                'day' => $dayKey,
                                'color' => $colorKey,
                            ],
                        ];
                    }
                }

                $occurrenceDate = $occurrenceDate->modify('+7 days');
            }
        }
    }
}

echo json_encode($events, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
