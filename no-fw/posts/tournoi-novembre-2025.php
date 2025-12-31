<?php
// Post metadata (used for listings)
$post_metadata = [
    'title' => 'Tournoi Interne de Novembre',
    'date' => '2025-11-15',
    'image' => 'assets/photo-2.jpg',
    'excerpt' => 'Le tournoi interne de novembre a rassemblé plus de 30 participants dans une ambiance conviviale et compétitive.'
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
            Le tournoi interne de novembre s'est déroulé le samedi 15 novembre dans une excellente ambiance.
            Plus de 30 participants de tous niveaux se sont affrontés dans un esprit sportif et convivial.
        </p>

        <h2 class="text-3xl font-black uppercase mb-3 mt-8">
            Résultats
        </h2>

        <div class="not-prose bg-surface border-2 border-border rounded-xl p-6 my-6">
            <div class="space-y-4">
                <div class="flex items-center gap-4">
                    <span class="text-4xl">🥇</span>
                    <div>
                        <div class="font-bold text-lg">1ère place</div>
                        <div class="text-gray-600">Marc Dubois</div>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-4xl">🥈</span>
                    <div>
                        <div class="font-bold text-lg">2ème place</div>
                        <div class="text-gray-600">Sophie Martin</div>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-4xl">🥉</span>
                    <div>
                        <div class="font-bold text-lg">3ème place</div>
                        <div class="text-gray-600">Pierre Leroy</div>
                    </div>
                </div>
            </div>
        </div>

        <p class="leading-relaxed">
            Félicitations à tous les participants et rendez-vous pour le prochain tournoi en décembre!
        </p>

        <div class="p-4 border-l-4 rounded-lg bg-green-50 border-green-500 text-green-900 mt-6 not-prose">
            <p class="font-bold">🎉 Merci à tous les bénévoles qui ont organisé cet événement!</p>
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
