<?php
$config = require __DIR__ . '/config.php';
$page_title = "Horaires - " . $config['site_name'];
$hero_title = "Horaires";
$hero_subtitle = "Entraînements et Compétitions.";
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/hero.php';
?>

<section class="py-16">
    <div class="max-w-[1200px] mx-auto px-4">
        <h2 class="text-4xl font-black uppercase mb-4 text-center">PLANNING des cours 2025/2026</h2>
        <p class="text-center text-red-600 font-bold mb-8">Les cours de tennis de table débute le 25 AOÛT 2025</p>

        <?php
        // Load events from JSON file
        $eventsJson = file_get_contents(__DIR__ . '/assets/events.json');
        $events = json_decode($eventsJson, true);

        // Map day numbers to French day names
        $dayNames = [
            1 => 'Lundi',
            2 => 'Mardi',
            3 => 'Mercredi',
            4 => 'Jeudi',
            5 => 'Vendredi',
            6 => 'Samedi',
            0 => 'Dimanche'
        ];

        // Group events by day
        $eventsByDay = [];
        foreach ($events as $event) {
            $dayNum = $event['daysOfWeek'][0];
            if (!isset($eventsByDay[$dayNum])) {
                $eventsByDay[$dayNum] = [];
            }
            $eventsByDay[$dayNum][] = $event;
        }
        ksort($eventsByDay);

        // Helper function to format time
        function formatTime($time) {
            $parts = explode(':', $time);
            return $parts[0] . 'h' . $parts[1];
        }
        ?>

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
                    foreach ($eventsByDay as $dayNum => $dayEvents) {
                        $courseNum = 1;
                        foreach ($dayEvents as $event) {
                            $dayName = $dayNames[$dayNum];
                            $displayDay = count($dayEvents) > 1 ? $dayName . ' - cours ' . $courseNum : $dayName;
                            $timeRange = formatTime($event['startTime']) . ' / ' . formatTime($event['endTime']);
                            ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="p-4 border-2 border-black font-semibold"><?php echo htmlspecialchars($displayDay); ?></td>
                                <td class="p-4 border-2 border-black"><?php echo $event['courseDescription']; ?></td>
                                <td class="p-4 border-2 border-black text-center"><?php echo htmlspecialchars($timeRange); ?></td>
                                <td class="p-4 border-2 border-black text-center"><?php echo htmlspecialchars($event['trainer']); ?></td>
                            </tr>
                            <?php
                            $courseNum++;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="mt-12 bg-white border-2 border-black p-6 rounded-lg">
            <h3 class="text-red-600 font-bold text-xl mb-4">Sauf Vacances scolaires 2025-2026 :</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm">
                <div><span class="font-semibold">Jeune genevois</span> 11 septembre 2025</div>
                <div><span class="font-semibold underline">Automne</span> 20 au 24 octobre 2025</div>
                <div><span class="font-semibold underline">Noël</span> 22 décembre au 2 janvier 2026</div>
                <div><span class="font-semibold underline">Février</span> 23 au 27 février 2026</div>
                <div><span class="font-semibold underline">Pâques</span> 3 au 17 avril 2026</div>
                <div><span class="font-semibold">Fête du travail</span> 1er mai 2026</div>
                <div><span class="font-semibold underline">Ascension</span> 14 et 15 mai 2026</div>
                <div><span class="font-semibold underline">Pentecôte</span> 25 mai 2026</div>
            </div>
        </div>

        <div class="mt-8 text-center">
            <a href="https://www.meyrinctt.ch/docs/PLANNING%20des%20cours%202025-2026%20en%20A3-version%205%20Ao%C3%BBt%202025.pdf" target="_blank" class="inline-block px-8 py-4 bg-primary text-white border-2 border-border rounded-full font-bold uppercase shadow-soft transition-all hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-hover active:translate-0 active:shadow-none cursor-pointer">Télécharger le PDF</a>
        </div>
    </div>
</section>

<section class="py-16 bg-bg border-t-2 border-border">
    <div class="max-w-[1200px] mx-auto px-4">
        <h2 class="text-3xl font-black uppercase mb-8 text-center">Calendrier</h2>
        <div id="calendar" class="bg-white p-6 rounded-xl border-2 border-border shadow-soft font-sans"></div>
    </div>
</section>

<!-- FullCalendar CDN -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            locale: 'fr',
            firstDay: 1, // Monday
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            slotMinTime: '08:00:00',
            slotMaxTime: '23:00:00',
            allDaySlot: false,
            events: 'assets/events.json', // Load events from JSON file
            eventDidMount: function(info) {
                // Add Tailwind classes to events if needed (though className in JSON handles it)
            }
        });
        calendar.render();
    });
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
