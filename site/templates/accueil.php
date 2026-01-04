<?php
/**
 * Home page template - Accueil
 * 
 * The main landing page with hero, news, and club sections.
 */
snippet('header');
?>

<?php snippet('hero-cta', [
    'title' => $page->hero_title()->or('Tennis de Table Meyrin'),
    'subtitle' => $page->hero_subtitle()->or('Passion, Compétition et Convivialité.')
]) ?>

<!-- News Section -->
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
        
        <?php if ($newsPage = page('actualites')): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($newsPage->children()->listed()->sortBy('date', 'desc')->limit(3) as $article): ?>
                <?php snippet('article-card', ['article' => $article]) ?>
            <?php endforeach ?>
        </div>
        
        <div class="text-center mt-12">
            <a href="<?= $newsPage->url() ?>" class="inline-block px-8 py-4 bg-primary text-white border-2 border-primary rounded-full font-bold uppercase shadow-soft transition-all hover:-translate-y-1 hover:shadow-hover hover:bg-primary-dark active:translate-0 active:shadow-none cursor-pointer">
                Voir plus d'actualités
            </a>
        </div>
        <?php endif ?>
    </div>
</section>

<!-- Club Section -->
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
            <?php if ($page->cards()->isNotEmpty()): ?>
                <?php foreach ($page->cards()->toStructure() as $card): ?>
                <a href="<?= $card->link()->toUrl() ?>" class="bg-surface border-2 border-border rounded-xl p-8 shadow-soft transition-all hover:-translate-y-1.5 hover:shadow-hover hover:border-primary group">
                    <h3 class="text-primary mb-3 text-2xl font-extrabold uppercase group-hover:underline"><?= $card->title()->esc() ?></h3>
                    <p class="mb-4"><?= $card->description()->esc() ?></p>
                    <span class="text-primary font-bold text-sm uppercase inline-flex items-center gap-2"><?= $card->link_text()->or('En savoir plus')->esc() ?> <span class="group-hover:translate-x-1 transition-transform">&rarr;</span></span>
                </a>
                <?php endforeach ?>
            <?php else: ?>
            <!-- Default cards -->
            <a href="<?= page('horaires')?->url() ?>" class="bg-surface border-2 border-border rounded-xl p-8 shadow-soft transition-all hover:-translate-y-1.5 hover:shadow-hover hover:border-primary group">
                <h3 class="text-primary mb-3 text-2xl font-extrabold uppercase group-hover:underline">Entraînements</h3>
                <p class="mb-4">Des créneaux pour tous les niveaux, du débutant au compétiteur confirmé. Consultez nos horaires d'entraînement hebdomadaires.</p>
                <span class="text-primary font-bold text-sm uppercase inline-flex items-center gap-2">Voir les horaires <span class="group-hover:translate-x-1 transition-transform">&rarr;</span></span>
            </a>
            <a href="<?= page('club')?->url() ?>" class="bg-surface border-2 border-border rounded-xl p-8 shadow-soft transition-all hover:-translate-y-1.5 hover:shadow-hover hover:border-primary group">
                <h3 class="text-primary mb-3 text-2xl font-extrabold uppercase group-hover:underline">Compétition</h3>
                <p class="mb-4">Plusieurs équipes engagées dans les championnats régionaux et nationaux. Rejoignez nos compétiteurs passionnés.</p>
                <span class="text-primary font-bold text-sm uppercase inline-flex items-center gap-2">En savoir plus <span class="group-hover:translate-x-1 transition-transform">&rarr;</span></span>
            </a>
            <a href="<?= page('club')?->url() ?>" class="bg-surface border-2 border-border rounded-xl p-8 shadow-soft transition-all hover:-translate-y-1.5 hover:shadow-hover hover:border-primary group">
                <h3 class="text-primary mb-3 text-2xl font-extrabold uppercase group-hover:underline">École de Jeunes</h3>
                <p class="mb-4">Une école de tennis de table pour les enfants dès 6 ans, encadrée par des entraîneurs diplômés et passionnés.</p>
                <span class="text-primary font-bold text-sm uppercase inline-flex items-center gap-2">Découvrir l'école <span class="group-hover:translate-x-1 transition-transform">&rarr;</span></span>
            </a>
            <?php endif ?>
        </div>
        
        <!-- Call to Action with description -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center bg-primary/5 border-2 border-primary/20 rounded-xl p-8 lg:p-12">
            <div>
                <h3 class="text-3xl font-black uppercase mb-4"><?= $page->club_title()->or('Pourquoi rejoindre le Meyrin CTT ?')->esc() ?></h3>
                <?php if ($page->club_description()->isNotEmpty()): ?>
                    <?= $page->club_description()->kt() ?>
                <?php else: ?>
                <p class="text-lg mb-4">Plus qu'un simple club de tennis de table, le Meyrin CTT est une véritable communauté où la passion du sport se mêle à la convivialité. Avec plus de 160 membres et une soixantaine de licenciés, nous offrons un environnement accueillant pour tous les âges et tous les niveaux.</p>
                <?php endif ?>
                
                <?php if ($page->club_features()->isNotEmpty()): ?>
                <ul class="space-y-2 mb-6">
                    <?php foreach ($page->club_features()->toStructure() as $feature): ?>
                    <li class="flex items-start gap-2">
                        <span class="text-primary font-bold">✓</span>
                        <span><?= $feature->feature()->esc() ?></span>
                    </li>
                    <?php endforeach ?>
                </ul>
                <?php else: ?>
                <ul class="space-y-2 mb-6">
                    <li class="flex items-start gap-2"><span class="text-primary font-bold">✓</span><span>Entraîneurs qualifiés et expérimentés</span></li>
                    <li class="flex items-start gap-2"><span class="text-primary font-bold">✓</span><span>Installations modernes et bien équipées</span></li>
                    <li class="flex items-start gap-2"><span class="text-primary font-bold">✓</span><span>Ambiance chaleureuse et familiale</span></li>
                    <li class="flex items-start gap-2"><span class="text-primary font-bold">✓</span><span>Participation aux championnats suisses</span></li>
                </ul>
                <?php endif ?>
                
                <a href="<?= page('inscription')?->url() ?>" class="inline-block px-8 py-4 bg-primary text-white border-2 border-primary rounded-full font-bold uppercase shadow-soft transition-all hover:-translate-y-1 hover:shadow-hover hover:bg-primary-dark active:translate-0 active:shadow-none cursor-pointer">
                    Inscription
                </a>
            </div>
            <div class="hidden lg:block">
                <?php if ($heroImage = $page->images()->first()): ?>
                <img src="<?= $heroImage->resize(600)->url() ?>" alt="<?= $site->title()->esc() ?>" class="rounded-xl shadow-soft border-2 border-border">
                <?php endif ?>
            </div>
        </div>
    </div>
</section>

<?php snippet('footer') ?>
