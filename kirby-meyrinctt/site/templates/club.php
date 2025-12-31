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
        <div class="mb-16 mt-16">
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

        <!-- Club History Section -->
        <?php if ($page->history_timeline()->isNotEmpty()): ?>
        <div class="mb-16 mt-16">
            <h2 class="text-3xl font-black uppercase mb-8 text-center pb-4 border-b-4 border-primary inline-block"><?= $page->history_title()->or('Histoire du Club')->esc() ?></h2>

            <div class="max-w-[900px] mx-auto">
                <div class="space-y-8 mt-12">
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

        <!-- Notable Players -->
        <?php if ($page->notable_players()->isNotEmpty()): ?>
        <div class="mb-16 mt-16">
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

        <!-- Committee Section -->
        <?php if ($page->committee_members()->isNotEmpty()): ?>
        <div class="mb-16 mt-16">
            <h2 class="text-3xl font-black uppercase mb-8 text-center pb-4 border-b-4 border-primary inline-block"><?= $page->committee_title()->or('Le Comité')->esc() ?></h2>

            <div class="max-w-[900px] mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($page->committee_members()->toStructure() as $member): ?>
                    <div class="bg-surface border-2 border-border rounded-xl p-6 shadow-soft hover:shadow-hover transition-all">
                        <div class="text-sm font-bold text-primary uppercase mb-1"><?= $member->role()->esc() ?></div>
                        <div class="text-lg font-bold mb-2"><?= $member->name()->esc() ?></div>
                        <?php if ($member->email()->isNotEmpty()): ?>
                        <a href="mailto:<?= $member->email()->esc() ?>" class="text-sm text-gray-600 hover:text-primary transition-colors"><?= $member->email()->esc() ?></a>
                        <?php endif ?>
                    </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
        <?php endif ?>

    </div>
</section>

<?php snippet('footer') ?>
