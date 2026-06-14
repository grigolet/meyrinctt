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

        <!-- Club Carousel Section -->
        <?php if ($page->images()->template('carousel-image')->count() > 0): ?>
        <div class="mb-16 mt-32">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-black uppercase mb-4 text-center pb-4 border-b-4 border-primary inline-block">
                    <?= $page->carousel_title()->or('Notre Club en Images')->esc() ?>
                </h2>
                <?php if ($page->carousel_subtitle()->isNotEmpty()): ?>
                <p class="text-lg text-gray-600 mt-4 max-w-2xl mx-auto">
                    <?= $page->carousel_subtitle()->esc() ?>
                </p>
                <?php endif ?>
            </div>

            <div class="max-w-[1100px] mx-auto">
                <div class="club-carousel swiper border-2 border-border rounded-xl overflow-hidden shadow-soft">
                    <div class="swiper-wrapper">
                        <?php foreach ($page->images()->template('carousel-image') as $image): ?>
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
                        <p class="mb-4 leading-relaxed"><?= $event->description()->kt() ?></p>
                    </div>
                    <?php endforeach ?>
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
                            <picture>
                                <source srcset="<?= $photo->srcset('avatar') ?>" type="image/webp">
                                <img 
                                    src="<?= $photo->crop(120, 120)->url() ?>" 
                                    alt="<?= $member->name()->esc() ?>" 
                                    class="w-24 h-24 rounded-full object-cover border-4 border-primary"
                                    width="120"
                                    height="120"
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

        <!-- Coaches Section -->
        <?php if ($page->coaches_members()->isNotEmpty()): ?>
        <div id="entraineur" data-anchor-aliases="entraineurs,nos-entraineurs" class="mb-16 mt-32 text-center">
            <h2 class="text-3xl font-black uppercase mb-8 text-center pb-4 border-b-4 border-primary inline-block"><?= $page->coaches_title()->or('Nos Entraîneurs')->esc() ?></h2>

            <div class="max-w-[900px] mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($page->coaches_members()->toStructure() as $coach): ?>
                    <div class="bg-surface border-2 border-border rounded-xl p-6 shadow-soft hover:shadow-hover transition-all">
                        <!-- Avatar -->
                        <div class="flex justify-center mb-4">
                            <?php if ($coach->photo()->toFile()): ?>
                            <?php $photo = $coach->photo()->toFile(); ?>
                            <picture>
                                <source srcset="<?= $photo->srcset('avatar') ?>" type="image/webp">
                                <img 
                                    src="<?= $photo->crop(120, 120)->url() ?>" 
                                    alt="<?= $coach->name()->esc() ?>" 
                                    class="w-24 h-24 rounded-full object-cover border-4 border-primary"
                                    width="120"
                                    height="120"
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
                        
                        <div class="text-sm font-bold text-primary uppercase mb-1 text-center"><?= $coach->specialty()->esc() ?></div>
                        <div class="text-lg font-bold mb-2 text-center"><?= $coach->name()->esc() ?></div>
                        <?php if ($coach->email()->isNotEmpty()): ?>
                        <a href="mailto:<?= $coach->email()->esc() ?>" class="text-sm text-gray-600 hover:text-primary transition-colors block text-center"><?= $coach->email()->esc() ?></a>
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
