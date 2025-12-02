<?php
// Post metadata (used for listings)
$post_metadata = [
    'title' => 'Stage Jeunes Été 2025',
    'date' => '2025-07-10',
    'image' => 'assets/photo-4.jpg',
    'excerpt' => 'Un stage intensif pour les jeunes joueurs pendant les vacances d\'été. Inscriptions ouvertes jusqu\'au 30 juin!'
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
            Le Meyrin CTT organise son stage jeunes d'été du 15 au 26 juillet 2025.
            Ce stage s'adresse aux jeunes de 8 à 16 ans, tous niveaux confondus.
        </p>

        <h2 class="text-3xl font-black uppercase mb-3 mt-8">
            Informations pratiques
        </h2>

        <div class="not-prose bg-surface border-2 border-border rounded-xl overflow-hidden my-6">
            <table class="w-full">
                <tbody class="divide-y-2 divide-border">
                    <tr>
                        <td class="p-4 font-bold bg-primary/5">📅 Dates</td>
                        <td class="p-4">15-26 juillet 2025 (2 semaines)</td>
                    </tr>
                    <tr>
                        <td class="p-4 font-bold bg-primary/5">🕐 Horaires</td>
                        <td class="p-4">9h00 - 16h00 (du lundi au vendredi)</td>
                    </tr>
                    <tr>
                        <td class="p-4 font-bold bg-primary/5">👥 Âge</td>
                        <td class="p-4">8-16 ans (tous niveaux)</td>
                    </tr>
                    <tr>
                        <td class="p-4 font-bold bg-primary/5">💰 Tarif</td>
                        <td class="p-4">CHF 250.- (membres) / CHF 300.- (non-membres)</td>
                    </tr>
                    <tr>
                        <td class="p-4 font-bold bg-primary/5">📍 Lieu</td>
                        <td class="p-4">Gymnase de Meyrin, Chemin de la Versoix 2</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <h2 class="text-3xl font-black uppercase mb-3 mt-8">
            Programme
        </h2>

        <ul class="list-disc list-inside space-y-2">
            <li>Entraînement technique et tactique</li>
            <li>Matches et tournois internes</li>
            <li>Préparation physique adaptée</li>
            <li>Analyse vidéo des matchs</li>
            <li>Sorties et activités ludiques</li>
        </ul>

        <div class="p-4 border-l-4 rounded-lg bg-yellow-50 border-yellow-500 text-yellow-900 mt-6 not-prose">
            <p class="font-bold">⚠️ Places limitées à 24 participants - Inscriptions avant le 30 juin!</p>
        </div>

        <p class="leading-relaxed mt-6">
            Le repas de midi est inclus dans le prix du stage. Encadrement assuré par des entraîneurs diplômés.
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
