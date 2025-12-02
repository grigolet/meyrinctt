<?php
$config = require __DIR__ . '/config.php';
$page_title = "Le Club - " . $config['site_name'];
$hero_title = "Le Club";
$hero_subtitle = "Découvrez l'équipe du Meyrin CTT.";
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/hero.php';

$committee = [
    ['role' => 'Présidente', 'name' => 'Mme Joan Helfer', 'email' => 'helferjoan@hotmail.com'],
    ['role' => 'Vice-Président', 'name' => 'M. Jean-Pierre Revol', 'email' => 'jean-pierre.revol@cern.ch'],
    ['role' => 'Vice-Président', 'name' => 'M. Gianluca Rigoletti', 'email' => 'gianluca.rigoletti@gmail.com'],
    ['role' => 'Trésorier', 'name' => 'M. Alain Reynier', 'email' => 'alain-reynier@hotmail.com'],
    ['role' => 'Secrétaire', 'name' => 'M. Reynald Schmid', 'email' => 'reynald.schmid@bluewin.ch'],
    ['role' => 'Informatique', 'name' => 'M. Alan Lumley', 'email' => 'alan@lumley.ch'],
    ['role' => 'Salle & Bar', 'name' => 'M. Carsten Neubauer', 'email' => 'carsten.neubauer@web.de'],
    ['role' => 'Webmaster', 'name' => 'M. Dominique Schneider', 'email' => 'schneiderdom@bluewin.ch'],
    ['role' => 'Techniques', 'name' => 'M. Bugra Bilin', 'email' => 'bbilin1986@gmail.com'],
];
?>

<section class="py-16">
    <div class="max-w-[1200px] mx-auto px-4">
        
        <div class="mb-16 text-center">
            <h2 class="text-3xl font-black uppercase mb-8 inline-block border-b-4 border-primary">Le Comité 2025 / 2026</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 text-left">
                <?php foreach ($committee as $member): ?>
                <div class="bg-surface border-2 border-border rounded-xl p-6 shadow-soft hover:shadow-hover transition-all flex flex-col items-center text-center">
                    <div class="w-24 h-24 rounded-full bg-gray-200 border-2 border-border mb-4 overflow-hidden">
                        <!-- Placeholder for profile photo -->
                        <svg class="w-full h-full text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <span class="block text-sm font-bold text-primary uppercase mb-1"><?php echo $member['role']; ?></span>
                    <h3 class="text-xl font-extrabold mb-2"><?php echo $member['name']; ?></h3>
                    <a href="mailto:<?php echo $member['email']; ?>" class="text-gray-600 hover:text-primary transition-colors flex items-center gap-2 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                        <?php echo $member['email']; ?>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="bg-primary/5 border-2 border-primary rounded-xl p-8 text-center max-w-[800px] mx-auto">
            <h3 class="text-2xl font-black uppercase mb-4">Membre d'honneur</h3>
            <p class="text-xl font-bold mb-2">Monsieur Richard Bourleau</p>
            <!-- <div class="w-16 h-1 bg-primary mx-auto my-4"></div>
            <p class="italic text-gray-700">Mérite administratif décerné par l’AGTT à Joan HELFER pour 20 années de Présidence du Meyrin CTT.</p> -->
        </div>

    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
