<?php
/**
 * Horaires (schedule) page template.
 */
snippet('header');
snippet('hero');

$dayNames = [
    'lundi' => 'Lundi',
    'mardi' => 'Mardi',
    'mercredi' => 'Mercredi',
    'jeudi' => 'Jeudi',
    'vendredi' => 'Vendredi',
    'samedi' => 'Samedi',
    'dimanche' => 'Dimanche',
];

$categoryLabels = [
    'ecole' => 'École de tennis de table',
    'juniors' => 'Juniors',
    'adultes' => 'Adultes',
    'libre' => 'Entraînement libre',
    'competition' => 'Compétition',
    'autre' => 'Autre',
];

$allowedColors = ['blue', 'green', 'orange', 'yellow', 'purple', 'grey'];
$courses = $page->courses()->isNotEmpty() ? $page->courses()->toStructure() : [];
$seasonStartValue = $page->season_start()->value();
$seasonEndValue = $page->season_end()->value();
$scheduleTimezone = new DateTimeZone('Europe/Zurich');
$today = new DateTimeImmutable('today', $scheduleTimezone);
$initialDate = $today;

try {
    $seasonStart = $seasonStartValue ? new DateTimeImmutable($seasonStartValue, $scheduleTimezone) : null;
    $seasonEnd = $seasonEndValue ? new DateTimeImmutable($seasonEndValue, $scheduleTimezone) : null;

    if ($seasonStart && $today < $seasonStart) {
        $initialDate = $seasonStart;
    } elseif ($seasonEnd && $today > $seasonEnd) {
        $initialDate = $seasonEnd;
    }
} catch (Throwable) {
    $seasonStart = null;
    $seasonEnd = null;
}

$formatDate = static function ($field): string {
    return $field->isNotEmpty() ? $field->toDate('d.m.Y') : '';
};

$formatTime = static function ($field): string {
    return $field->isNotEmpty() ? $field->toDate('H\hi') : '';
};

$schedulePdf = $page->schedule_pdf();
$schedulePdfFile = $schedulePdf->toFile();
$schedulePdfUrl = $schedulePdfFile ? $schedulePdfFile->url() : $schedulePdf->toUrl();
?>

<section class="schedule-page py-12 md:py-16" data-schedule-page>
    <div class="max-w-[1200px] mx-auto px-4">
        <header class="schedule-heading text-center">
            <p class="schedule-eyebrow">Meyrin CTT</p>
            <h2 class="text-3xl md:text-5xl font-black text-primary uppercase mb-4"><?= $page->schedule_title()->or('Planning des cours')->esc() ?></h2>

            <?php if ($seasonStartValue && $seasonEndValue): ?>
            <p class="schedule-season">
                Saison du <time datetime="<?= esc($seasonStartValue, 'attr') ?>"><?= $formatDate($page->season_start()) ?></time>
                au <time datetime="<?= esc($seasonEndValue, 'attr') ?>"><?= $formatDate($page->season_end()) ?></time>
            </p>
            <?php endif ?>

            <?php if ($page->schedule_notice()->isNotEmpty()): ?>
            <p class="schedule-notice" role="note"><?= $page->schedule_notice()->esc() ?></p>
            <?php endif ?>

            <?php if ($page->schedule_intro()->isNotEmpty()): ?>
            <div class="schedule-intro"><?= $page->schedule_intro()->kirbytext() ?></div>
            <?php endif ?>
        </header>

        <?php if (count($courses) > 0): ?>
        <div class="schedule-calendar-shell">
            <div
                class="schedule-calendar"
                data-schedule-calendar
                data-events-url="<?= esc($page->url() . '.json', 'attr') ?>"
                data-initial-date="<?= $initialDate->format('Y-m-d') ?>"
                data-slot-min="<?= esc($page->calendar_min_time()->or('09:00:00')->value(), 'attr') ?>"
                data-slot-max="<?= esc($page->calendar_max_time()->or('22:30:00')->value(), 'attr') ?>"
                data-slot-duration="<?= esc($page->calendar_slot_duration()->or('00:30:00')->value(), 'attr') ?>"
                data-hide-weekends="<?= $page->calendar_hide_weekends()->toBool() ? 'true' : 'false' ?>"
                data-slot-min-height="<?= max(24, min(60, $page->calendar_slot_min_height()->or(40)->toInt())) ?>"
                aria-label="Planning hebdomadaire des entraînements"
            ></div>
            <p class="schedule-calendar-status" data-schedule-status role="status" aria-live="polite">Chargement du planning…</p>
            <noscript>
                <p class="schedule-calendar-error">JavaScript est nécessaire pour afficher le calendrier. Les informations de chaque créneau restent disponibles ci-dessous.</p>
            </noscript>
        </div>

        <section class="schedule-details" aria-labelledby="schedule-details-title">
            <div class="schedule-section-heading">
                <p class="schedule-eyebrow">Informations</p>
                <h3 id="schedule-details-title">Détail des créneaux</h3>
                <p>Retrouvez ici les informations essentielles de chaque activité.</p>
            </div>

            <div class="schedule-card-grid">
                <?php foreach ($courses as $activity):
                    $color = $activity->color()->or('blue')->value();
                    $color = in_array($color, $allowedColors, true) ? $color : 'blue';
                    $categoryKey = $activity->category()->or('autre')->value();
                    $defaultTrainer = trim((string)$activity->default_trainer()->value());
                ?>
                <article class="schedule-card schedule-card--<?= esc($color, 'attr') ?>">
                    <div class="schedule-card__accent" aria-hidden="true"></div>
                    <div class="schedule-card__body">
                        <p class="schedule-card__category"><?= esc($categoryLabels[$categoryKey] ?? $categoryLabels['autre']) ?></p>
                        <h4><?= $activity->course_description()->esc() ?></h4>
                        <?php if ($activity->details()->isNotEmpty()): ?>
                        <div class="schedule-card__description"><?= $activity->details()->kirbytext() ?></div>
                        <?php endif ?>

                        <?php if ($activity->slots()->isNotEmpty()): ?>
                        <ul class="schedule-card__slots" aria-label="Créneaux hebdomadaires">
                            <?php foreach ($activity->slots()->toStructure() as $slot):
                                $dayKey = $slot->day()->value();
                                $slotTrainer = trim((string)$slot->trainer()->value());
                                $trainer = $slotTrainer !== '' ? $slotTrainer : $defaultTrainer;
                            ?>
                            <li>
                                <div class="schedule-card__meta">
                                    <strong><?= esc($dayNames[$dayKey] ?? ucfirst($dayKey)) ?></strong>
                                    <span><?= $formatTime($slot->start_time()) ?>–<?= $formatTime($slot->end_time()) ?></span>
                                    <?php if ($trainer !== ''): ?>
                                    <span>Avec <?= esc($trainer) ?></span>
                                    <?php endif ?>
                                </div>
                                <?php if ($slot->slot_note()->isNotEmpty()): ?>
                                <p class="schedule-card__slot-note"><?= $slot->slot_note()->esc() ?></p>
                                <?php endif ?>
                            </li>
                            <?php endforeach ?>
                        </ul>
                        <?php endif ?>
                    </div>
                </article>
                <?php endforeach ?>
            </div>
        </section>
        <?php else: ?>
        <div class="schedule-empty">
            <h3>Le planning sera bientôt disponible</h3>
            <p>Les créneaux de la prochaine saison sont en cours de préparation.</p>
        </div>
        <?php endif ?>

        <?php if ($page->holidays()->isNotEmpty()): ?>
        <section class="schedule-closures" aria-labelledby="schedule-closures-title">
            <div class="schedule-section-heading">
                <p class="schedule-eyebrow">Dates à retenir</p>
                <h3 id="schedule-closures-title"><?= $page->holidays_title()->or('Vacances scolaires et fermetures')->esc() ?></h3>
            </div>
            <div class="schedule-closure-grid">
                <?php foreach ($page->holidays()->toStructure() as $holiday): ?>
                <article class="schedule-closure">
                    <h4><?= $holiday->name()->esc() ?></h4>
                    <?php if ($holiday->dates()->isNotEmpty()): ?>
                    <p><?= $holiday->dates()->esc() ?></p>
                    <?php elseif ($holiday->start_date()->isNotEmpty()): ?>
                    <p><?= $formatDate($holiday->start_date()) ?><?php if ($holiday->end_date()->isNotEmpty() && $holiday->end_date()->value() !== $holiday->start_date()->value()): ?> – <?= $formatDate($holiday->end_date()) ?><?php endif ?></p>
                    <?php endif ?>
                </article>
                <?php endforeach ?>
            </div>
        </section>
        <?php endif ?>

        <?php if ($schedulePdfUrl): ?>
        <div class="schedule-download">
            <a href="<?= esc($schedulePdfUrl, 'attr') ?>" target="_blank" rel="noopener" class="schedule-download__link">
                Télécharger le planning en PDF
            </a>
        </div>
        <?php endif ?>
    </div>

    <dialog class="schedule-dialog" data-schedule-dialog aria-labelledby="schedule-dialog-title">
        <button type="button" class="schedule-dialog__close" data-schedule-dialog-close aria-label="Fermer les informations">×</button>
        <p class="schedule-dialog__category" data-schedule-dialog-category></p>
        <h3 id="schedule-dialog-title" data-schedule-dialog-title></h3>
        <p class="schedule-dialog__time" data-schedule-dialog-time></p>
        <p class="schedule-dialog__trainer" data-schedule-dialog-trainer></p>
        <div class="schedule-dialog__description" data-schedule-dialog-description></div>
    </dialog>
</section>

<?php snippet('footer') ?>
