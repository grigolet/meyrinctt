<?php
// Post metadata (used for listings)
$post_metadata = [
    'title' => 'Inscriptions 2025',
    'date' => '2025-11-22',
    'image' => 'assets/photo-1.jpg',
    'excerpt' => 'Les inscriptions pour la nouvelle saison sont ouvertes. Rejoignez nos équipes dès maintenant pour profiter de nos installations rénovées.'
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

        <!-- Post content - just write HTML here -->
        <p class="leading-relaxed">
            Les inscriptions pour la nouvelle saison sont ouvertes. Rejoignez nos équipes dès maintenant pour profiter de nos installations rénovées.
        </p>

        <h2 class="text-3xl font-black uppercase mb-3 mt-8">
            Pourquoi s'inscrire maintenant ?
        </h2>

        <ul class="list-disc list-inside space-y-2">
            <li>Accès illimité aux entraînements</li>
            <li>Participation aux tournois internes et externes</li>
            <li>Encadrement professionnel avec nos entraîneurs qualifiés</li>
            <li>Ambiance conviviale dans un club dynamique</li>
        </ul>

        <div class="p-4 border-l-4 rounded-lg bg-blue-50 border-blue-500 text-blue-900 mt-6 not-prose">
            <p class="font-bold">📢 Réduction de 20% pour les inscriptions avant le 15 janvier!</p>
        </div>

        <p class="leading-relaxed mt-6">
            Pour plus d'informations ou pour vous inscrire, contactez-nous via le formulaire de contact ou venez nous rendre visite lors de nos séances d'entraînement.
        </p>

        <!-- Optional: Attachments section -->
        <div class="mt-12 p-8 bg-surface border-2 border-border rounded-xl shadow-soft not-prose">
            <h3 class="text-2xl font-black uppercase mb-6 pb-4 border-b-2 border-border">
                Pièces jointes
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="assets/documents/formulaire-inscription.pdf" download
                   class="flex items-start gap-4 p-4 border-2 border-border rounded-lg hover:border-primary hover:shadow-soft transition-all group">
                    <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-lg bg-primary/10 text-primary group-hover:bg-primary group-hover:text-white transition-colors text-2xl">
                        📄
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-text group-hover:text-primary transition-colors mb-1">
                            Formulaire d'inscription
                        </h4>
                        <p class="text-sm text-gray-600">PDF - 250 KB</p>
                    </div>
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </a>
            </div>
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
