<?php
/**
 * Inscription (Registration) page template
 */
snippet('header');
snippet('hero');
?>

<section class="py-16">
    <div class="max-w-[1000px] mx-auto px-4">
        
        <!-- Fees Table -->
        <div class="bg-white border-2 border-border rounded-xl p-8 shadow-soft mb-16">
            <h2 class="text-3xl font-black uppercase mb-6 text-center"><?= $page->fees_title()->or("Tarifs d'adhésion 2025-2026")->esc() ?></h2>
            
            <?php if ($page->fees()->isNotEmpty()): ?>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-primary text-white">
                            <th class="p-4 text-left font-bold uppercase text-sm border-2 border-primary">Catégorie</th>
                            <th class="p-4 text-right font-bold uppercase text-sm border-2 border-primary">Cotisation</th>
                            <th class="p-4 text-right font-bold uppercase text-sm border-2 border-primary">Licence AGTT</th>
                            <th class="p-4 text-right font-bold uppercase text-sm border-2 border-primary">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($page->fees()->toStructure() as $fee): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 border-2 border-border font-medium"><?= $fee->category()->esc() ?></td>
                            <td class="p-4 border-2 border-border text-right font-mono"><?= $fee->cotisation()->esc() ?></td>
                            <td class="p-4 border-2 border-border text-right font-mono"><?= $fee->licence()->or('—')->esc() ?></td>
                            <td class="p-4 border-2 border-border text-right font-bold font-mono text-primary"><?= $fee->total()->esc() ?></td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <?php endif ?>
            
            <?php if ($page->fees_note()->isNotEmpty()): ?>
            <div class="mt-6 p-4 bg-primary/5 border-l-4 border-primary rounded">
                <p class="text-sm text-gray-700"><strong>Note:</strong> <?= $page->fees_note()->esc() ?></p>
            </div>
            <?php endif ?>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-16">
            <!-- Adhesion -->
            <div class="bg-surface border-2 border-border rounded-xl p-8 shadow-soft">
                <h2 class="text-2xl font-black uppercase mb-6 flex items-center gap-3">
                    <span class="w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center text-sm">1</span>
                    Demande d'adhésion
                </h2>
                <p class="mb-6 text-gray-700 min-h-24"><?= $page->adhesion_description()->or("Pour nous rejoindre, veuillez remplir le formulaire d'adhésion ou passer directement au club.")->esc() ?></p>
                
                <?php if ($page->adhesion_forms()->isNotEmpty()): ?>
                <div class="flex flex-col gap-4">
                    <?php foreach ($page->adhesion_forms()->toStructure() as $form): ?>
                    <a href="<?= $form->url()->esc() ?>" target="_blank" class="flex items-center justify-between p-4 border-2 border-border rounded-lg hover:bg-gray-50 transition-colors group">
                        <span class="font-bold"><?= $form->title()->esc() ?></span>
                        <span class="text-primary group-hover:translate-x-1 transition-transform">&rarr;</span>
                    </a>
                    <?php endforeach ?>
                </div>
                <?php endif ?>

                <div class="mt-8 pt-6 border-t-2 border-gray-100">
                    <h3 class="font-bold uppercase text-sm text-gray-500 mb-2">Adresse Postale</h3>
                    <p class="font-medium">MEYRIN CTT<br>2, rue De-Livron<br>1217 Meyrin</p>
                </div>
            </div>

            <!-- Licence -->
            <div class="bg-surface border-2 border-border rounded-xl p-8 shadow-soft">
                <h2 class="text-2xl font-black uppercase mb-6 flex items-center gap-3">
                    <span class="w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center text-sm">2</span>
                    Demande de licence
                </h2>
                <p class="mb-6 text-gray-700 min-h-24"><?= $page->licence_description()->or("Pour les joueurs désirant rejoindre une équipe pour la compétition, veuillez remplir les documents suivants.")->esc() ?></p>
                
                <?php if ($page->licence_forms()->isNotEmpty()): ?>
                <div class="flex flex-col gap-4">
                    <?php foreach ($page->licence_forms()->toStructure() as $form): ?>
                    <a href="<?= $form->url()->esc() ?>" target="_blank" class="flex items-center justify-between p-4 border-2 border-border rounded-lg hover:bg-gray-50 transition-colors group">
                        <span class="font-bold"><?= $form->title()->esc() ?></span>
                        <span class="text-primary group-hover:translate-x-1 transition-transform">&rarr;</span>
                    </a>
                    <?php endforeach ?>
                </div>
                <?php endif ?>

                <?php if ($page->payment_info()->isNotEmpty()): ?>
                <div class="mt-8 pt-6 border-t-2 border-gray-100">
                    <h3 class="font-bold uppercase text-sm text-gray-500 mb-2">Paiements</h3>
                    <p class="font-medium">CCP du Club: <span class="font-mono bg-gray-100 px-2 py-1 rounded"><?= $page->payment_info()->esc() ?></span></p>
                </div>
                <?php endif ?>
            </div>
        </div>

        <div class="text-center bg-primary/5 rounded-xl p-8 border-2 border-primary/20">
            <h3 class="text-xl font-black uppercase mb-4">Besoin d'aide ?</h3>
            <p class="mb-6">Pour plus d'informations, vous pouvez contacter la présidente du Meyrin CTT.</p>
            <a href="<?= page('contact')?->url() ?>" class="inline-block px-8 py-3 bg-primary text-white font-bold rounded-full shadow-soft hover:shadow-hover transition-all">Nous contacter</a>
        </div>

    </div>
</section>

<?php snippet('footer') ?>
