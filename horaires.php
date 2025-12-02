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
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border-spacing-0 border-2 border-border rounded-xl overflow-hidden shadow-soft bg-white">
                <thead>
                    <tr>
                        <th class="p-5 text-left bg-primary-light text-primary font-extrabold uppercase text-sm border-b border-[#eee]">Jour</th>
                        <th class="p-5 text-left bg-primary-light text-primary font-extrabold uppercase text-sm border-b border-[#eee]">Heure</th>
                        <th class="p-5 text-left bg-primary-light text-primary font-extrabold uppercase text-sm border-b border-[#eee]">Groupe</th>
                        <th class="p-5 text-left bg-primary-light text-primary font-extrabold uppercase text-sm border-b border-[#eee]">Lieu</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-[#fafafa] transition-colors">
                        <td class="p-5 border-b border-[#eee]">Lundi</td>
                        <td class="p-5 border-b border-[#eee]">16h30 - 21h00</td>
                        <td class="p-5 border-b border-[#eee]">Entraînements membres</td>
                        <td class="p-5 border-b border-[#eee]">École des Boudines</td>
                    </tr>
                     <tr class="hover:bg-[#fafafa] transition-colors">
                        <td class="p-5 border-b border-[#eee]">Lundi</td>
                        <td class="p-5 border-b border-[#eee]">dès 21h00</td>
                        <td class="p-5 border-b border-[#eee]">Entraînements CERN</td>
                        <td class="p-5 border-b border-[#eee]">École des Boudines</td>
                    </tr>
                    <tr class="hover:bg-[#fafafa] transition-colors">
                        <td class="p-5 border-b border-[#eee]">Mardi</td>
                        <td class="p-5 border-b border-[#eee]">14h00 - Fermeture</td>
                        <td class="p-5 border-b border-[#eee]">Jeu libre</td>
                        <td class="p-5 border-b border-[#eee]">École des Boudines</td>
                    </tr>
                    <tr class="hover:bg-[#fafafa] transition-colors">
                        <td class="p-5 border-b border-[#eee]">Mercredi</td>
                        <td class="p-5 border-b border-[#eee]">14h00 - 19h15</td>
                        <td class="p-5 border-b border-[#eee]">Entraînements membres</td>
                        <td class="p-5 border-b border-[#eee]">École des Boudines</td>
                    </tr>
                     <tr class="hover:bg-[#fafafa] transition-colors">
                        <td class="p-5 border-b border-[#eee]">Mercredi</td>
                        <td class="p-5 border-b border-[#eee]">16h30 - 18h00</td>
                        <td class="p-5 border-b border-[#eee]">Sport pour tous (Meyrinois)</td>
                        <td class="p-5 border-b border-[#eee]">École des Boudines</td>
                    </tr>
                    <tr class="hover:bg-[#fafafa] transition-colors">
                        <td class="p-5 border-b border-[#eee]">Jeudi</td>
                        <td class="p-5 border-b border-[#eee]">14h00 - 16h00</td>
                        <td class="p-5 border-b border-[#eee]">Club des aînés (sauf vacances)</td>
                        <td class="p-5 border-b border-[#eee]">École des Boudines</td>
                    </tr>
                    <tr class="hover:bg-[#fafafa] transition-colors">
                        <td class="p-5 border-b border-[#eee]">Jeudi</td>
                        <td class="p-5 border-b border-[#eee]">17h45 - 19h15</td>
                        <td class="p-5 border-b border-[#eee]">Entraînements membres</td>
                        <td class="p-5 border-b border-[#eee]">École des Boudines</td>
                    </tr>
                    <tr class="hover:bg-[#fafafa] transition-colors">
                        <td class="p-5 border-b border-[#eee]">Vendredi</td>
                        <td class="p-5 border-b border-[#eee]">16h15 - 20h00</td>
                        <td class="p-5 border-b border-[#eee]">Entraînements membres</td>
                        <td class="p-5 border-b border-[#eee]">École des Boudines</td>
                    </tr>
                     <tr class="hover:bg-[#fafafa] transition-colors">
                        <td class="p-5 border-b-0 border-[#eee]">Vendredi</td>
                        <td class="p-5 border-b-0 border-[#eee]">dès 20h00</td>
                        <td class="p-5 border-b-0 border-[#eee]">Entraînements CERN</td>
                        <td class="p-5 border-b-0 border-[#eee]">École des Boudines</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-12 text-center">
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
