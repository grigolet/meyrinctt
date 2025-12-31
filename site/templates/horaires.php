<?php
/**
 * Horaires (Schedule) page template
 */
snippet('header');
snippet('hero');

// Map day names
$dayNames = [
    'lundi' => 'Lundi',
    'mardi' => 'Mardi',
    'mercredi' => 'Mercredi',
    'jeudi' => 'Jeudi',
    'vendredi' => 'Vendredi',
    'samedi' => 'Samedi',
    'dimanche' => 'Dimanche'
];

// Group courses by day
$coursesByDay = [];
if ($page->courses()->isNotEmpty()) {
    foreach ($page->courses()->toStructure() as $course) {
        $day = $course->day()->value();
        if (!isset($coursesByDay[$day])) {
            $coursesByDay[$day] = [];
        }
        $coursesByDay[$day][] = $course;
    }
}

// Format time helper
function formatTimeKirby($time) {
    if (!$time) return '';
    return $time->toDate('H') . 'h' . $time->toDate('i');
}
?>

<section class="py-16">
    <div class="max-w-[1200px] mx-auto px-4">
        <h2 class="text-4xl font-black uppercase mb-4 text-center"><?= $page->schedule_title()->or('PLANNING des cours 2025/2026')->esc() ?></h2>
        
        <?php if ($page->schedule_notice()->isNotEmpty()): ?>
        <p class="text-center text-red-600 font-bold mb-8"><?= $page->schedule_notice()->esc() ?></p>
        <?php endif ?>

        <?php if (!empty($coursesByDay)): ?>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border-2 border-black bg-white">
                <thead>
                    <tr class="bg-white">
                        <th class="p-4 text-center font-bold border-2 border-black">Jour</th>
                        <th class="p-4 text-center font-bold border-2 border-black">J+S</th>
                        <th class="p-4 text-center font-bold border-2 border-black">Horaire</th>
                        <th class="p-4 text-center font-bold border-2 border-black">Entraîneur</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $dayOrder = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];
                    foreach ($dayOrder as $dayKey):
                        if (!isset($coursesByDay[$dayKey])) continue;
                        $dayCourses = $coursesByDay[$dayKey];
                        $courseNum = 1;
                        foreach ($dayCourses as $course):
                            $dayName = $dayNames[$dayKey] ?? $dayKey;
                            $displayDay = count($dayCourses) > 1 ? $dayName . ' - cours ' . $courseNum : $dayName;
                    ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 border-2 border-black font-semibold"><?= Str::esc($displayDay) ?></td>
                        <td class="p-4 border-2 border-black"><?= $course->course_description()->esc() ?></td>
                        <td class="p-4 border-2 border-black text-center">
                            <?= $course->start_time()->toDate('H') ?>h<?= $course->start_time()->toDate('i') ?> / 
                            <?= $course->end_time()->toDate('H') ?>h<?= $course->end_time()->toDate('i') ?>
                        </td>
                        <td class="p-4 border-2 border-black text-center"><?= $course->trainer()->esc() ?></td>
                    </tr>
                    <?php 
                        $courseNum++;
                        endforeach;
                    endforeach; 
                    ?>
                </tbody>
            </table>
        </div>
        <?php endif ?>

        <?php if ($page->holidays()->isNotEmpty()): ?>
        <div class="mt-12 bg-white border-2 border-black p-6 rounded-lg">
            <h3 class="text-red-600 font-bold text-xl mb-4"><?= $page->holidays_title()->or('Sauf Vacances scolaires 2025-2026')->esc() ?> :</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm">
                <?php foreach ($page->holidays()->toStructure() as $holiday): ?>
                <div><span class="font-semibold"><?= $holiday->name()->esc() ?></span> <?= $holiday->dates()->esc() ?></div>
                <?php endforeach ?>
            </div>
        </div>
        <?php endif ?>

        <?php if ($page->schedule_pdf()->isNotEmpty()): ?>
        <div class="mt-8 text-center">
            <a href="<?= $page->schedule_pdf()->esc() ?>" target="_blank" class="inline-block px-8 py-4 bg-primary text-white border-2 border-border rounded-full font-bold uppercase shadow-soft transition-all hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-hover active:translate-0 active:shadow-none cursor-pointer">
                Télécharger le PDF
            </a>
        </div>
        <?php endif ?>
    </div>
</section>

<?php snippet('footer') ?>
