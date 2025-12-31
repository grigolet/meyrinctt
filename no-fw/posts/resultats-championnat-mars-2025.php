<?php
// Post metadata (used for listings)
$post_metadata = [
    'title' => 'Résultats du Championnat de Mars',
    'date' => '2025-03-20',
    'image' => 'assets/photo-5.jpg',
    'excerpt' => 'Belle performance de nos équipes lors du championnat régional de mars avec plusieurs victoires importantes.'
];

// Only render if not being included for metadata
if (!isset($metadata_only)) {
    // Local variables for page setup
    $post_title = $post_metadata['title'];
    $post_date = $post_metadata['date'];
    $post_image = $post_metadata['image'];

// Page setup
$config = require __DIR__ . '/../config.php';
$page_title = $post_title . " - " . $config['site_name'];
$hero_title = $post_title;
$hero_subtitle = date('d M Y', strtotime($post_date));
$hero_bg = $post_image;

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/hero.php';
?>

<section class="py-16">
    <div class="max-w-[800px] mx-auto px-4 prose lg:prose-xl">

        <p class="leading-relaxed">
            Le weekend du 15-16 mars a été marqué par d'excellents résultats pour nos équipes lors des rencontres
            du championnat régional. Retour sur ces performances prometteuses.
        </p>

        <h2 class="text-3xl font-black uppercase mb-3 mt-8">
            Ligue Nationale B
        </h2>

        <div class="not-prose bg-surface border-2 border-border rounded-xl p-6 my-6">
            <div class="text-center mb-4">
                <span class="inline-block px-4 py-2 bg-primary text-white font-bold rounded-full">
                    Victoire 7-3
                </span>
            </div>
            <div class="text-center">
                <div class="text-2xl font-black mb-2">Meyrin CTT I</div>
                <div class="text-gray-600">vs</div>
                <div class="text-2xl font-black mt-2">Genève TT</div>
            </div>
        </div>

        <p class="leading-relaxed">
            Notre équipe première continue sur sa lancée avec une belle victoire face à Genève TT.
            Marc Dubois et Sophie Martin se sont particulièrement distingués avec 2 victoires chacun.
        </p>

        <h2 class="text-3xl font-black uppercase mb-3 mt-8">
            2ème Ligue
        </h2>

        <div class="not-prose grid grid-cols-1 md:grid-cols-2 gap-4 my-6">
            <div class="bg-surface border-2 border-border rounded-xl p-4">
                <div class="text-center">
                    <span class="inline-block px-3 py-1 bg-green-500 text-white font-bold text-sm rounded-full mb-3">
                        Victoire 6-4
                    </span>
                    <div class="font-bold">Meyrin CTT II</div>
                    <div class="text-sm text-gray-600">vs Lausanne TT</div>
                </div>
            </div>
            <div class="bg-surface border-2 border-border rounded-xl p-4">
                <div class="text-center">
                    <span class="inline-block px-3 py-1 bg-red-500 text-white font-bold text-sm rounded-full mb-3">
                        Défaite 3-7
                    </span>
                    <div class="font-bold">Meyrin CTT III</div>
                    <div class="text-sm text-gray-600">vs Yverdon TT</div>
                </div>
            </div>
        </div>

        <h2 class="text-3xl font-black uppercase mb-3 mt-8">
            Classement actuel
        </h2>

        <p class="leading-relaxed">
            Après ces résultats, Meyrin CTT I se positionne en 3ème place du classement LNB,
            tandis que notre équipe II se hisse à la 2ème place de sa poule, avec de réelles chances de promotion.
        </p>

        <div class="p-4 border-l-4 rounded-lg bg-blue-50 border-blue-500 text-blue-900 mt-6 not-prose">
            <p class="font-bold">📢 Prochaine rencontre: Samedi 29 mars à domicile contre Neuchâtel TT</p>
        </div>

        <!-- Back link -->
        <div class="mt-12 pt-8 border-t-2 border-border">
            <a href="../news.php" class="font-bold text-primary hover:underline">&larr; Retour aux actualités</a>
        </div>

    </div>
</section>

<?php
    include __DIR__ . '/../includes/footer.php';
} // End of metadata_only check
?>
