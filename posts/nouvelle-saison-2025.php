<?php
// Post metadata (used for listings)
$post_metadata = [
    'title' => 'Début de la Nouvelle Saison 2025-2026',
    'date' => '2025-09-01',
    'image' => 'assets/posts/banner-1.jpg',
    'excerpt' => 'La nouvelle saison commence début septembre avec de nombreuses nouveautés et objectifs ambitieux pour toutes nos équipes.'
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
            C'est avec beaucoup d'enthousiasme que nous entamons la nouvelle saison 2025-2026!
            Le club compte cette année plus de 160 membres et aligne 8 équipes dans les différentes ligues suisses.
        </p>

        <h2 class="text-3xl font-black uppercase mb-3 mt-8">
            Nouveautés de la saison
        </h2>

        <ul class="list-disc list-inside space-y-2">
            <li>Nouveau créneau d'entraînement le mercredi soir pour les juniors</li>
            <li>Installation de 2 nouvelles tables professionnelles</li>
            <li>Programme de formation pour les entraîneurs</li>
            <li>Partenariat avec l'école primaire de Meyrin</li>
        </ul>

        <h2 class="text-3xl font-black uppercase mb-3 mt-8">
            Nos objectifs
        </h2>

        <p class="leading-relaxed">
            Cette saison, nos équipes visent plusieurs objectifs ambitieux:
        </p>

        <div class="not-prose bg-primary/5 border-2 border-primary rounded-xl p-6 my-6">
            <ul class="space-y-3">
                <li class="flex items-start gap-3">
                    <span class="text-xl">🎯</span>
                    <span>Maintien en LNB pour notre équipe première</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="text-xl">🎯</span>
                    <span>Promotion en 2ème ligue pour notre équipe réserve</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="text-xl">🎯</span>
                    <span>Développer l'école de jeunesse avec 20 nouveaux juniors</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="text-xl">🎯</span>
                    <span>Organiser 3 tournois majeurs dans nos installations</span>
                </li>
            </ul>
        </div>

        <p class="leading-relaxed">
            Nous comptons sur le soutien de tous nos membres et partenaires pour atteindre ces objectifs.
            Bonne saison à tous!
        </p>

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
