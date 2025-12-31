<?php
$config = require __DIR__ . '/config.php';
$page_title = "Accueil - " . $config['site_name'];

// Load recent news posts from posts/ directory
$posts = [];
$posts_dir = __DIR__ . '/posts';
if (is_dir($posts_dir)) {
    $files = glob($posts_dir . '/*.php');
    foreach ($files as $file) {
        // Skip README and other non-post files
        if (basename($file) === 'README.md') continue;

        // Include the file to get metadata only
        $metadata_only = true;
        $post_metadata = null;
        include $file;

        if ($post_metadata) {
            $post_metadata['slug'] = basename($file, '.php');
            $posts[] = $post_metadata;
        }
        unset($metadata_only, $post_metadata);
    }
    // Sort by date desc
    usort($posts, function($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });
    // Get only the 3 most recent
    $posts = array_slice($posts, 0, 3);
}

include __DIR__ . '/includes/header.php';
?>

    <section class="py-32 bg-bg border-b-2 border-border relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full bg-[url('assets/hero.webp')] bg-cover bg-center z-0"></div>
        <div class="absolute top-0 left-0 w-full h-full bg-black/30 z-0 pointer-events-none"></div>

        <div class="absolute top-0 left-0 w-full pointer-events-none z-0">
            <div class="ball absolute bg-white/10 rounded-full w-10 h-10 animate-float"></div>
            <div class="ball absolute bg-white/10 rounded-full w-10 h-10 animate-float"></div>
            <div class="ball absolute bg-white/10 rounded-full w-10 h-10 animate-float"></div>
            <div class="ball absolute bg-white/10 rounded-full w-10 h-10 animate-float"></div>
            <div class="ball absolute bg-white/10 rounded-full w-10 h-10 animate-float"></div>
        </div>

        <div class="max-w-[900px] mx-auto px-4 text-center relative z-10">
            <h1 class="text-5xl md:text-7xl font-black mb-4 text-white leading-none uppercase tracking-tighter drop-shadow-[0_4px_4px_rgba(0,0,0,0.5)] text-shadow-lg/30">
                Tennis de Table Meyrin</h1>
            <p class="text-xl md:text-2xl font-bold text-white mb-16 max-w-[700px] mx-auto drop-shadow-[0_2px_2px_rgba(0,0,0,0.5)] text-shadow-lg/30">Passion, Compétition
                et Convivialité.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="contact.php" class="inline-block px-8 py-4 bg-primary text-white border-2 border-primary rounded-full font-bold uppercase shadow-soft transition-all hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-hover active:translate-0 active:shadow-none cursor-pointer hover:bg-primary-dark">Rejoignez-nous</a>
                <a href="horaires.php" class="inline-block px-8 py-4 bg-white text-primary border-2 border-white rounded-full font-bold uppercase shadow-soft transition-all hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-hover active:translate-0 active:shadow-none cursor-pointer hover:bg-gray-100">Voir
                    les horaires</a>
            </div>
        </div>
    </section>

    <section class="py-16 relative overflow-hidden">
        <!-- Decorative Racket SVG -->
        <div class="absolute -right-10 top-10 w-64 h-64 opacity-5 pointer-events-none rotate-12 z-0">
            <svg viewBox="0 0 100 100" fill="currentColor" class="text-primary w-full h-full">
                <path d="M50 5 C35 5 25 15 25 30 C25 45 35 55 50 55 C65 55 75 45 75 30 C75 15 65 5 50 5 Z M50 55 L50 95" stroke="currentColor" stroke-width="8" stroke-linecap="round" fill="none" />
                <circle cx="50" cy="30" r="20" fill="currentColor" opacity="0.2" />
            </svg>
        </div>

        <div class="max-w-[1200px] mx-auto px-4 relative z-10">
            <h2 class="text-4xl font-black uppercase mb-8 inline-block border-b-4 border-primary">Actualités</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                <?php foreach ($posts as $post): ?>
                <a href="posts/<?php echo $post['slug']; ?>.php" class="block bg-surface border-2 border-border rounded-xl shadow-soft transition-transform hover:-translate-y-1.5 hover:shadow-hover overflow-hidden relative group">
                    <div class="absolute top-2.5 right-2.5 w-[30px] h-[30px] bg-[url('assets/paddle-illustration.png')] bg-contain bg-no-repeat opacity-10 z-0">
                    </div>
                    <div class="h-[240px] border-b-2 border-border bg-cover bg-center" style="background-image: url('<?php echo htmlspecialchars($post['image']); ?>');"></div>
                    <div class="p-8 relative z-10">
                        <span class="block text-sm font-bold text-primary uppercase mb-2"><?php echo date('d M Y', strtotime($post['date'])); ?></span>
                        <h3 class="text-2xl font-extrabold mb-2 leading-tight"><?php echo htmlspecialchars($post['title']); ?></h3>
                        <p class="mb-4"><?php echo htmlspecialchars($post['excerpt']); ?></p>
                        <span class="inline-block mt-4 font-bold text-text border-b-2 border-accent uppercase text-sm">Lire
                            la suite</span>
                    </div>
                </a>
                <?php endforeach; ?>

            </div>
            
            <div class="text-center mt-12">
                <a href="news.php" class="inline-block px-8 py-4 bg-primary text-white border-2 border-primary rounded-full font-bold uppercase shadow-soft transition-all hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-hover active:translate-0 active:shadow-none cursor-pointer">Voir plus d'actualités</a>
            </div>
        </div>
    </section>

    <section class="py-16 bg-white relative overflow-hidden">
        <!-- Decorative Ball SVG -->
        <div class="absolute -left-10 bottom-10 w-48 h-48 opacity-5 pointer-events-none z-0">
            <svg viewBox="0 0 100 100" fill="currentColor" class="text-primary w-full h-full">
                <circle cx="50" cy="50" r="40" stroke="currentColor" stroke-width="8" fill="none" />
                <path d="M10 50 Q50 20 90 50" stroke="currentColor" stroke-width="4" fill="none" opacity="0.5" />
            </svg>
        </div>

        <div class="max-w-[1200px] mx-auto px-4 relative z-10">
            <h2 class="text-4xl font-black uppercase mb-8 inline-block border-b-4 border-primary">Le Club</h2>
            
            <!-- Club Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                <a href="horaires.php" class="bg-surface border-2 border-border rounded-xl p-8 shadow-soft transition-all hover:-translate-y-1.5 hover:shadow-hover hover:border-primary group">
                    <h3 class="text-primary mb-3 text-2xl font-extrabold uppercase group-hover:underline">Entraînements</h3>
                    <p class="mb-4">Des créneaux pour tous les niveaux, du débutant au compétiteur confirmé. Consultez nos horaires d'entraînement hebdomadaires.</p>
                    <span class="text-primary font-bold text-sm uppercase inline-flex items-center gap-2">Voir les horaires <span class="group-hover:translate-x-1 transition-transform">&rarr;</span></span>
                </a>
                <a href="club.php" class="bg-surface border-2 border-border rounded-xl p-8 shadow-soft transition-all hover:-translate-y-1.5 hover:shadow-hover hover:border-primary group">
                    <h3 class="text-primary mb-3 text-2xl font-extrabold uppercase group-hover:underline">Compétition</h3>
                    <p class="mb-4">Plusieurs équipes engagées dans les championnats régionaux et nationaux. Rejoignez nos compétiteurs passionnés.</p>
                    <span class="text-primary font-bold text-sm uppercase inline-flex items-center gap-2">En savoir plus <span class="group-hover:translate-x-1 transition-transform">&rarr;</span></span>
                </a>
                <a href="club.php" class="bg-surface border-2 border-border rounded-xl p-8 shadow-soft transition-all hover:-translate-y-1.5 hover:shadow-hover hover:border-primary group">
                    <h3 class="text-primary mb-3 text-2xl font-extrabold uppercase group-hover:underline">École de Jeunes</h3>
                    <p class="mb-4">Une école de tennis de table pour les enfants dès 6 ans, encadrée par des entraîneurs diplômés et passionnés.</p>
                    <span class="text-primary font-bold text-sm uppercase inline-flex items-center gap-2">Découvrir l'école <span class="group-hover:translate-x-1 transition-transform">&rarr;</span></span>
                </a>
            </div>
            
            <!-- Call to Action with Image -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center bg-primary/5 border-2 border-primary/20 rounded-xl p-8 lg:p-12">
                <div>
                    <h3 class="text-3xl font-black uppercase mb-4">Pourquoi rejoindre le Meyrin CTT ?</h3>
                    <p class="text-lg mb-4">Plus qu'un simple club de tennis de table, le Meyrin CTT est une véritable communauté où la passion du sport se mêle à la convivialité. Avec plus de 160 membres et une soixantaine de licenciés, nous offrons un environnement accueillant pour tous les âges et tous les niveaux.</p>
                    <ul class="space-y-2 mb-6">
                        <li class="flex items-start gap-2">
                            <span class="text-primary font-bold">✓</span>
                            <span>Entraîneurs qualifiés et expérimentés</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-primary font-bold">✓</span>
                            <span>Installations modernes et bien équipées</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-primary font-bold">✓</span>
                            <span>Ambiance chaleureuse et familiale</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-primary font-bold">✓</span>
                            <span>Participation aux championnats suisses</span>
                        </li>
                    </ul>
                    <a href="inscription.php" class="inline-block px-8 py-4 bg-primary text-white border-2 border-primary rounded-full font-bold uppercase shadow-soft transition-all hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-hover">S'inscrire maintenant</a>
                </div>
                <div class="rounded-xl overflow-hidden border-2 border-border shadow-soft">
                    <img src="assets/photo-2.jpg" alt="Joueurs du Meyrin CTT" class="w-full h-auto object-cover">
                </div>
            </div>
        </div>
    </section>

<?php include __DIR__ . '/includes/footer.php'; ?>
