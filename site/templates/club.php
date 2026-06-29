<?php
/**
 * Club page template
 * 
 * Displays club information, history, committee, and notable players.
 */
snippet('header');
snippet('hero');
?>

<section class="py-16">
    <div class="max-w-[1200px] mx-auto px-4">
        
        <!-- Club Overview Section -->
        <div class="mb-16 flex flex-col items-center">
            <h2 class="text-3xl font-black uppercase mb-8 text-center pb-4 border-b-4 border-primary inline-block">Le Club en Chiffres</h2>

            <div class="max-w-[900px] mx-auto mt-12">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Members stat -->
                    <div class="bg-surface border-2 border-border rounded-xl p-6 text-center shadow-soft hover:shadow-hover transition-all">
                        <div class="text-5xl font-black text-primary mb-2"><?= $page->stat_members()->or('160') ?>+</div>
                        <div class="text-lg font-bold uppercase">Membres</div>
                    </div>
                    <!-- Licensed players stat -->
                    <div class="bg-surface border-2 border-border rounded-xl p-6 text-center shadow-soft hover:shadow-hover transition-all">
                        <div class="text-5xl font-black text-primary mb-2"><?= $page->stat_licensed()->or('60') ?></div>
                        <div class="text-lg font-bold uppercase">Joueurs Licenciés</div>
                    </div>
                    <!-- Youth school stat -->
                    <div class="bg-surface border-2 border-border rounded-xl p-6 text-center shadow-soft hover:shadow-hover transition-all">
                        <div class="text-5xl font-black text-primary mb-2"><?= $page->stat_min_age()->or('6') ?>+</div>
                        <div class="text-lg font-bold uppercase">Âge École Jeunesse</div>
                    </div>
                </div>

                <?php if ($page->about_text()->isNotEmpty()): ?>
                <div class="bg-surface border-2 border-border rounded-xl p-8 shadow-soft">
                    <h3 class="text-2xl font-black mb-6">À Propos du Club</h3>
                    <div class="space-y-4 leading-relaxed">
                        <?= $page->about_text()->toBlocks() ?>
                    </div>
                </div>
                <?php endif ?>
            </div>
        </div>

        <!-- TTStats Widget Section -->
        <?php
        $ttstatsEnabled = $page->ttstats_enabled()->isEmpty() || $page->ttstats_enabled()->toBool();
        $ttstatsUrl = $page->ttstats_url()->or('https://ttstats.ch/widget/33165?theme=light&lang=fr');
        ?>
        <?php if ($ttstatsEnabled && $ttstatsUrl->isNotEmpty()): ?>
        <div class="mb-16 mt-32 text-center">
            <h2 class="text-3xl font-black uppercase mb-8 text-center pb-4 border-b-4 border-primary inline-block"><?= $page->ttstats_title()->or('Résultats TTStats')->esc() ?></h2>

            <div class="max-w-[1100px] mx-auto">
                <div class="bg-surface border-2 border-border rounded-xl p-3 md:p-4 shadow-soft overflow-hidden">
                    <iframe
                        src="<?= $ttstatsUrl->esc() ?>"
                        width="100%"
                        height="<?= $page->ttstats_height()->or('700')->esc() ?>"
                        frameborder="0"
                        scrolling="auto"
                        class="w-full rounded-lg border-0"
                        style="min-height: 520px;"
                        title="<?= $page->ttstats_iframe_title()->or('TTStats Club Widget')->esc() ?>"
                    ></iframe>
                </div>
            </div>
        </div>
        <?php endif ?>

        <!-- Club Carousel Section -->
        <?php if ($page->images()->template('carousel-image')->count() > 0): ?>
        <div class="mb-16 mt-32">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-black uppercase mb-4 text-center pb-4 border-b-4 border-primary inline-block">
                    <?= $page->carousel_title()->or('Notre Club en Images')->esc() ?>
                </h2>
                <?php if ($page->carousel_subtitle()->isNotEmpty()): ?>
                <div class="formatted-text text-lg text-gray-600 mt-4 max-w-2xl mx-auto">
                    <?= $page->carousel_subtitle()->kt() ?>
                </div>
                <?php endif ?>
            </div>

            <div class="max-w-[1100px] mx-auto">
                <div class="club-carousel swiper border-2 border-border rounded-xl overflow-hidden shadow-soft">
                    <div class="swiper-wrapper">
                        <?php foreach ($page->images()->template('carousel-image') as $image): ?>
                        <?php $focusPosition = meyrinctt_focus_position($image); ?>
                        <div class="swiper-slide">
                            <div class="relative aspect-[16/9] bg-gray-100">
                                <picture>
                                    <source 
                                        srcset="<?= $image->srcset([800, 1200, 1600]) ?>" 
                                        type="image/webp"
                                        sizes="(max-width: 768px) 100vw, (max-width: 1200px) 90vw, 1100px"
                                    >
                                    <img 
                                        src="<?= $image->resize(1200)->url() ?>" 
                                        alt="<?= $image->alt()->or($page->carousel_title())->esc() ?>" 
                                        class="w-full h-full object-cover"
                                        <?php if ($focusPosition): ?>style="object-position: <?= esc($focusPosition, 'attr') ?>"<?php endif ?>
                                        loading="lazy"
                                    >
                                </picture>
                                <?php if ($image->caption()->isNotEmpty()): ?>
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-6">
                                    <p class="text-white text-lg font-semibold">
                                        <?= $image->caption()->esc() ?>
                                    </p>
                                </div>
                                <?php endif ?>
                            </div>
                        </div>
                        <?php endforeach ?>
                    </div>
                    
                    <!-- Navigation buttons -->
                    <div class="swiper-button-prev !text-primary !w-12 !h-12 after:!text-2xl !bg-white/90 hover:!bg-white !rounded-full !left-4 !shadow-lg"></div>
                    <div class="swiper-button-next !text-primary !w-12 !h-12 after:!text-2xl !bg-white/90 hover:!bg-white !rounded-full !right-4 !shadow-lg"></div>
                    
                    <!-- Pagination -->
                    <div class="swiper-pagination !bottom-6"></div>
                </div>
            </div>
        </div>
        <?php endif ?>

        <!-- Club History Section -->
        <?php if ($page->history_timeline()->isNotEmpty()): ?>
        <div class="mb-16 mt-32 text-center">
            <h2 class="text-3xl font-black uppercase mb-8 text-center pb-4 border-b-4 border-primary inline-block"><?= $page->history_title()->or('Histoire du Club')->esc() ?></h2>
            <div class="max-w-[900px] mx-auto">
                <div class="space-y-8">
                    <?php foreach ($page->history_timeline()->toStructure() as $event): ?>
                    <div class="bg-surface border-2 border-border rounded-xl p-8 shadow-soft">
                        <span class="inline-block px-4 py-1 bg-primary text-white font-bold text-sm uppercase rounded-full mb-4"><?= $event->year()->esc() ?></span>
                        <h3 class="text-2xl font-black mb-4"><?= $event->title()->esc() ?></h3>
                        <div class="formatted-text mb-4 leading-relaxed">
                            <?= $event->description()->kt() ?>
                        </div>
                    </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
        <?php endif ?>

        <!-- Club Statutes Section -->
        <?php
        $statutesPdf = $page->statutes_pdf()->toFile();
        $defaultStatutesPath = kirby()->root('index') . '/assets/documents/Statuts_Meyrin_CTT.pdf';
        $statutesUrl = $statutesPdf?->url() ?? url('assets/documents/Statuts_Meyrin_CTT.pdf');
        $statutesFilename = $statutesPdf?->filename() ?? 'Statuts_Meyrin_CTT.pdf';
        ?>
        <?php if ($statutesPdf || is_file($defaultStatutesPath)): ?>
        <div class="mb-16 mt-32 text-center">
            <h2 class="text-3xl font-black uppercase mb-8 text-center pb-4 border-b-4 border-primary inline-block"><?= $page->statutes_title()->or('Statuts du Club')->esc() ?></h2>

            <div class="max-w-[900px] mx-auto">
                <div class="bg-primary/5 border-2 border-primary rounded-xl p-6 md:p-8 shadow-soft flex flex-col md:flex-row items-center gap-6 text-center md:text-left">
                    <div class="w-20 h-20 flex-shrink-0 rounded-lg bg-primary text-white flex items-center justify-center text-xl font-black" aria-hidden="true">
                        PDF
                    </div>

                    <div class="flex-1">
                        <h3 class="text-2xl font-black mb-2"><?= $page->statutes_document_title()->or('Statuts du Meyrin CTT')->esc() ?></h3>
                        <?php if ($page->statutes_description()->isNotEmpty()): ?>
                        <div class="formatted-text text-gray-700 leading-relaxed">
                            <?= $page->statutes_description()->kt() ?>
                        </div>
                        <?php else: ?>
                        <p class="text-gray-700 leading-relaxed">Consultez les statuts officiels qui définissent l'organisation et le fonctionnement du club.</p>
                        <?php endif ?>
                    </div>

                    <a
                        href="<?= esc($statutesUrl, 'attr') ?>"
                        download="<?= esc($statutesFilename, 'attr') ?>"
                        class="inline-flex flex-shrink-0 items-center justify-center gap-3 rounded-lg bg-primary px-6 py-4 font-bold text-white shadow-soft transition-all hover:-translate-y-1 hover:bg-primary-dark hover:shadow-hover focus:outline-none focus-visible:ring-4 focus-visible:ring-primary/25"
                    >
                        <span aria-hidden="true">&darr;</span>
                        <span><?= $page->statutes_button_label()->or('Télécharger les statuts')->esc() ?></span>
                    </a>
                </div>
            </div>
        </div>
        <?php endif ?>

        <!-- Committee Section -->
        <?php if ($page->committee_members()->isNotEmpty()): ?>
        <div class="mb-16 mt-32 text-center">
            <h2 class="text-3xl font-black uppercase mb-8 text-center pb-4 border-b-4 border-primary inline-block"><?= $page->committee_title()->or('Le Comité')->esc() ?></h2>

            <div class="max-w-[900px] mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($page->committee_members()->toStructure() as $member): ?>
                    <div class="bg-surface border-2 border-border rounded-xl p-6 shadow-soft hover:shadow-hover transition-all">
                        <!-- Avatar -->
                        <div class="flex justify-center mb-4">
                            <?php if ($member->photo()->toFile()): ?>
                            <?php $photo = $member->photo()->toFile(); ?>
                            <?php $focusPosition = meyrinctt_focus_position($photo); ?>
                            <picture>
                                <source srcset="<?= $photo->srcset('avatar') ?>" type="image/webp">
                                <img 
                                    src="<?= $photo->crop(120, 120)->url() ?>" 
                                    alt="<?= $member->name()->esc() ?>" 
                                    class="w-24 h-24 rounded-full object-cover border-4 border-primary"
                                    width="120"
                                    height="120"
                                    <?php if ($focusPosition): ?>style="object-position: <?= esc($focusPosition, 'attr') ?>"<?php endif ?>
                                    loading="lazy"
                                >
                            </picture>
                            <?php else: 
                                $initials = strtoupper(substr($member->name(), 0, 1));
                            ?>
                                <div class="w-24 h-24 rounded-full bg-primary flex items-center justify-center text-white text-3xl font-black border-4 border-primary">
                                    <?= $initials ?>
                                </div>
                            <?php endif ?>
                        </div>
                        
                        <div class="text-sm font-bold text-primary uppercase mb-1 text-center"><?= $member->role()->esc() ?></div>
                        <div class="text-lg font-bold mb-2 text-center"><?= $member->name()->esc() ?></div>
                        <?php if ($member->email()->isNotEmpty()): ?>
                        <a href="mailto:<?= $member->email()->esc() ?>" class="text-sm text-gray-600 hover:text-primary transition-colors block text-center"><?= $member->email()->esc() ?></a>
                        <?php endif ?>
                    </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
        <?php endif ?>

        <!-- Technical Advisors Section -->
        <?php if ($page->technical_advisors()->isNotEmpty()): ?>
        <div class="mb-16 text-center">
            <h2 class="text-3xl font-black uppercase mb-6 text-center pb-4 border-b-4 border-primary inline-block"><?= $page->technical_advisors_title()->or('Conseiller technique')->esc() ?></h2>

            <?php if ($page->technical_advisors_intro()->isNotEmpty()): ?>
            <div class="formatted-text max-w-[760px] mx-auto mb-8 text-gray-700">
                <?= $page->technical_advisors_intro()->kt() ?>
            </div>
            <?php endif ?>

            <div class="max-w-[900px] mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php foreach ($page->technical_advisors()->toStructure() as $advisor): ?>
                    <div class="bg-surface border-2 border-border rounded-xl p-6 shadow-soft text-left">
                        <div class="flex flex-col sm:flex-row gap-5 items-center sm:items-start">
                            <?php if ($advisor->photo()->toFile()): ?>
                            <?php $photo = $advisor->photo()->toFile(); ?>
                            <?php $focusPosition = meyrinctt_focus_position($photo); ?>
                            <picture class="flex-shrink-0">
                                <source srcset="<?= $photo->srcset('avatar') ?>" type="image/webp">
                                <img
                                    src="<?= $photo->crop(120, 120)->url() ?>"
                                    alt="<?= $advisor->name()->esc() ?>"
                                    class="w-24 h-24 rounded-full object-cover border-4 border-primary"
                                    width="120"
                                    height="120"
                                    <?php if ($focusPosition): ?>style="object-position: <?= esc($focusPosition, 'attr') ?>"<?php endif ?>
                                    loading="lazy"
                                >
                            </picture>
                            <?php else:
                                $initials = strtoupper(substr($advisor->name()->or('C')->value(), 0, 1));
                            ?>
                                <div class="flex-shrink-0 w-24 h-24 rounded-full bg-primary flex items-center justify-center text-white text-3xl font-black border-4 border-primary">
                                    <?= $initials ?>
                                </div>
                            <?php endif ?>

                            <div class="text-center sm:text-left">
                                <div class="text-sm font-bold text-primary uppercase mb-1"><?= $advisor->role()->or('Conseiller technique')->esc() ?></div>
                                <div class="text-lg font-bold mb-2"><?= $advisor->name()->esc() ?></div>
                                <?php if ($advisor->description()->isNotEmpty()): ?>
                                <div class="formatted-text text-sm text-gray-700 mb-3">
                                    <?= $advisor->description()->kt() ?>
                                </div>
                                <?php endif ?>
                                <?php if ($advisor->email()->isNotEmpty()): ?>
                                <a href="mailto:<?= $advisor->email()->esc() ?>" class="text-sm text-gray-600 hover:text-primary transition-colors"><?= $advisor->email()->esc() ?></a>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
        <?php endif ?>

        <!-- Honorary President Section -->
        <?php if ($page->honorary_president_name()->isNotEmpty() || $page->honorary_president_photo()->isNotEmpty() || $page->honorary_president_description()->isNotEmpty()): ?>
        <?php $honoraryPresidentPhoto = $page->honorary_president_photo()->toFile(); ?>
        <div class="mb-16 mt-32 text-center">
            <h2 class="text-3xl font-black uppercase mb-8 text-center pb-4 border-b-4 border-primary inline-block"><?= $page->honorary_president_title()->or("Présidente d'honneur")->esc() ?></h2>

            <div class="max-w-[900px] mx-auto">
                <div class="bg-surface border-2 border-border rounded-xl p-6 md:p-8 shadow-soft">
                    <div class="grid grid-cols-1 md:grid-cols-[220px_1fr] gap-8 items-center text-left">
                        <div class="flex justify-center">
                            <?php if ($honoraryPresidentPhoto): ?>
                            <?php $focusPosition = meyrinctt_focus_position($honoraryPresidentPhoto); ?>
                            <picture>
                                <source srcset="<?= $honoraryPresidentPhoto->srcset('card') ?>" type="image/webp">
                                <img
                                    src="<?= $honoraryPresidentPhoto->crop(320, 320)->url() ?>"
                                    alt="<?= $page->honorary_president_name()->or($page->honorary_president_title())->esc() ?>"
                                    class="w-44 h-44 md:w-52 md:h-52 rounded-xl object-cover border-4 border-primary shadow-soft"
                                    width="320"
                                    height="320"
                                    <?php if ($focusPosition): ?>style="object-position: <?= esc($focusPosition, 'attr') ?>"<?php endif ?>
                                    loading="lazy"
                                >
                            </picture>
                            <?php else: ?>
                            <?php $initials = strtoupper(substr($page->honorary_president_name()->or('H'), 0, 1)); ?>
                            <div class="w-44 h-44 md:w-52 md:h-52 rounded-xl bg-primary flex items-center justify-center text-white text-6xl font-black border-4 border-primary shadow-soft">
                                <?= esc($initials) ?>
                            </div>
                            <?php endif ?>
                        </div>

                        <div class="text-center md:text-left">
                            <?php if ($page->honorary_president_name()->isNotEmpty()): ?>
                            <div class="text-sm font-bold text-primary uppercase mb-2"><?= $page->honorary_president_title()->or("Présidente d'honneur")->esc() ?></div>
                            <h3 class="text-3xl font-black mb-4"><?= $page->honorary_president_name()->esc() ?></h3>
                            <?php endif ?>
                            <?php if ($page->honorary_president_description()->isNotEmpty()): ?>
                            <div class="formatted-text leading-relaxed text-gray-700">
                                <?= $page->honorary_president_description()->kt() ?>
                            </div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif ?>

        <!-- Club Achievements Section -->
        <?php if ($page->club_achievements()->isNotEmpty()): ?>
        <?php $achievementsImage = $page->achievements_image()->toFile(); ?>
        <div class="mb-16 mt-32 text-center">
            <h2 class="text-3xl font-black uppercase mb-8 text-center pb-4 border-b-4 border-primary inline-block"><?= $page->achievements_title()->or('Palmarès du Club')->esc() ?></h2>

            <div class="max-w-[1000px] mx-auto">
                <div class="bg-primary/5 border-2 border-primary rounded-xl p-6 md:p-10 shadow-soft overflow-hidden">
                    <div class="grid grid-cols-1 lg:grid-cols-[280px_1fr] gap-8 lg:gap-10 items-center">
                        <div class="flex flex-col items-center text-center">
                            <?php if ($achievementsImage): ?>
                            <?php $focusPosition = meyrinctt_focus_position($achievementsImage); ?>
                            <picture>
                                <source srcset="<?= $achievementsImage->srcset('card') ?>" type="image/webp">
                                <img
                                    src="<?= $achievementsImage->resize(520)->url() ?>"
                                    alt="<?= $page->achievements_title()->or('Palmarès du Club')->esc() ?>"
                                    class="max-h-64 w-full max-w-[260px] object-contain"
                                    <?php if ($focusPosition): ?>style="object-position: <?= esc($focusPosition, 'attr') ?>"<?php endif ?>
                                    loading="lazy"
                                >
                            </picture>
                            <?php else: ?>
                            <div class="flex h-44 w-44 items-center justify-center rounded-full bg-white text-7xl shadow-soft border-2 border-border" aria-hidden="true">&#127942;</div>
                            <?php endif ?>

                            <?php if ($page->achievements_intro()->isNotEmpty()): ?>
                            <div class="formatted-text mt-6 leading-relaxed text-gray-700">
                                <?= $page->achievements_intro()->kt() ?>
                            </div>
                            <?php endif ?>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-5">
                            <?php foreach ($page->club_achievements()->toStructure() as $achievement): ?>
                            <div class="bg-surface border-2 border-border rounded-xl p-6 text-center shadow-soft">
                                <div class="text-5xl md:text-6xl font-black text-primary mb-3 leading-none"><?= $achievement->number()->esc() ?></div>
                                <div class="text-lg font-bold leading-snug"><?= $achievement->label()->esc() ?></div>
                                <?php if ($achievement->description()->isNotEmpty()): ?>
                                <div class="formatted-text mt-3 text-sm leading-relaxed text-gray-600">
                                    <?= $achievement->description()->kt() ?>
                                </div>
                                <?php endif ?>
                            </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif ?>

        <!-- Coaches Section -->
        <?php if ($page->coaches_members()->isNotEmpty()): ?>
        <div id="entraineur" data-anchor-aliases="entraineurs,nos-entraineurs" class="mb-16 mt-32 text-center">
            <h2 class="text-3xl font-black uppercase mb-8 text-center pb-4 border-b-4 border-primary inline-block"><?= $page->coaches_title()->or('Nos Entraîneurs')->esc() ?></h2>

            <div class="max-w-[900px] mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($page->coaches_members()->toStructure() as $coach): ?>
                    <?php
                    $coachTitlesRaw = $coach->titles()->isNotEmpty()
                        ? $coach->titles()->value()
                        : $coach->specialty()->value();
                    $coachTitles = array_filter(
                        array_map('trim', preg_split('/\r\n|\r|\n/', $coachTitlesRaw ?: '')),
                        fn ($title) => $title !== ''
                    );
                    ?>
                    <div class="bg-surface border-2 border-border rounded-xl p-6 shadow-soft hover:shadow-hover transition-all">
                        <!-- Avatar -->
                        <div class="flex justify-center mb-4">
                            <?php if ($coach->photo()->toFile()): ?>
                            <?php $photo = $coach->photo()->toFile(); ?>
                            <?php $focusPosition = meyrinctt_focus_position($photo); ?>
                            <picture>
                                <source srcset="<?= $photo->srcset('avatar') ?>" type="image/webp">
                                <img 
                                    src="<?= $photo->crop(120, 120)->url() ?>" 
                                    alt="<?= $coach->name()->esc() ?>" 
                                    class="w-24 h-24 rounded-full object-cover border-4 border-primary"
                                    width="120"
                                    height="120"
                                    <?php if ($focusPosition): ?>style="object-position: <?= esc($focusPosition, 'attr') ?>"<?php endif ?>
                                    loading="lazy"
                                >
                            </picture>
                            <?php else: 
                                $initials = strtoupper(substr($coach->name(), 0, 1));
                            ?>
                                <div class="w-24 h-24 rounded-full bg-primary flex items-center justify-center text-white text-3xl font-black border-4 border-primary">
                                    <?= $initials ?>
                                </div>
                            <?php endif ?>
                        </div>
                        
                        <div class="text-lg font-bold mb-3 text-center"><?= $coach->name()->esc() ?></div>
                        <?php if (!empty($coachTitles)): ?>
                        <div class="flex flex-wrap justify-center gap-2">
                            <?php foreach ($coachTitles as $coachTitle): ?>
                            <span class="inline-flex rounded-full border border-primary/20 bg-primary/10 px-3 py-1 text-xs font-bold uppercase tracking-wide text-primary">
                                <?= esc($coachTitle) ?>
                            </span>
                            <?php endforeach ?>
                        </div>
                        <?php endif ?>
                    </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
        <?php endif ?>

        <!-- Notable Players -->
        <?php if ($page->notable_players()->isNotEmpty()): ?>
        <div class="mb-16 mt-32 text-center">
            <h2 class="text-3xl font-black uppercase mb-8 text-center pb-4 border-b-4 border-primary inline-block">Joueurs Remarquables</h2>
            
            <div class="max-w-[900px] mx-auto">
                <div class="bg-primary/5 border-2 border-primary rounded-xl p-8 shadow-soft">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php foreach ($page->notable_players()->toStructure() as $player): ?>
                        <div class="flex items-start gap-3">
                            <span class="text-2xl"><?= $player->icon()->or('🏆')->esc() ?></span>
                            <div>
                                <h4 class="font-bold text-lg mb-1"><?= $player->name()->esc() ?></h4>
                                <p class="text-sm text-gray-700"><?= $player->achievement()->esc() ?></p>
                            </div>
                        </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif ?>

    </div>
</section>

<?php snippet('footer') ?>
