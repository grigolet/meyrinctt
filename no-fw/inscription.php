<?php
$config = require __DIR__ . '/config.php';
$page_title = "Inscription - " . $config['site_name'];
$hero_title = "Inscription";
$hero_subtitle = "Rejoignez le Meyrin CTT pour la saison 2025 - 2026.";
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/hero.php';
?>

<section class="py-16">
    <div class="max-w-[1000px] mx-auto px-4">
        
        <!-- Fees Table -->
        <div class="bg-white border-2 border-border rounded-xl p-8 shadow-soft mb-16">
            <h2 class="text-3xl font-black uppercase mb-6 text-center">Tarifs d'adhésion 2025-2026</h2>
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
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 border-2 border-border font-medium">Adultes (dès 18 ans)</td>
                            <td class="p-4 border-2 border-border text-right font-mono">CHF 210.00</td>
                            <td class="p-4 border-2 border-border text-right font-mono">CHF 150.00</td>
                            <td class="p-4 border-2 border-border text-right font-bold font-mono text-primary">CHF 360.00</td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 border-2 border-border font-medium">Juniors (moins de 18 ans) avec cours</td>
                            <td class="p-4 border-2 border-border text-right font-mono">CHF 220.00</td>
                            <td class="p-4 border-2 border-border text-right font-mono">CHF 100.00</td>
                            <td class="p-4 border-2 border-border text-right font-bold font-mono text-primary">CHF 320.00</td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 border-2 border-border font-medium">Conjoints</td>
                            <td class="p-4 border-2 border-border text-right font-mono">CHF 100.00</td>
                            <td class="p-4 border-2 border-border text-right font-mono">CHF 160.00</td>
                            <td class="p-4 border-2 border-border text-right font-bold font-mono text-primary">CHF 260.00</td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 border-2 border-border font-medium">Membres externes sans cours</td>
                            <td class="p-4 border-2 border-border text-right font-mono">CHF 100.00</td>
                            <td class="p-4 border-2 border-border text-right font-mono">-</td>
                            <td class="p-4 border-2 border-border text-right font-bold font-mono text-primary">CHF 100.00</td>
                        </tr>
                        <tr class="bg-primary/5 hover:bg-primary/10 transition-colors">
                            <td class="p-4 border-2 border-border font-medium">Baby Ping</td>
                            <td class="p-4 border-2 border-border text-right font-mono">CHF 120.00</td>
                            <td class="p-4 border-2 border-border text-right font-mono">—</td>
                            <td class="p-4 border-2 border-border text-right font-bold font-mono text-primary">CHF 50.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-6 p-4 bg-primary/5 border-l-4 border-primary rounded">
                <p class="text-sm text-gray-700"><strong>Note:</strong> Rabais par enfant si plusieurs membres de la famille: 40.- CHF</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-16">
            <!-- Adhesion -->
            <div class="bg-surface border-2 border-border rounded-xl p-8 shadow-soft">
                <h2 class="text-2xl font-black uppercase mb-6 flex items-center gap-3">
                    <span class="w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center text-sm">1</span>
                    Demande d'adhésion
                </h2>
                <p class="mb-6 text-gray-700">Pour nous rejoindre, veuillez remplir le formulaire d'adhésion ou passer directement au club.</p>
                
                <div class="flex flex-col gap-4">
                    <a href="https://www.meyrinctt.ch/docs/Demande%20d%27adh%C3%A9sion%20Meyrin%20CTT_fr.pdf" target="_blank" class="flex items-center justify-between p-4 border-2 border-border rounded-lg hover:bg-gray-50 transition-colors group">
                        <span class="font-bold">Formulaire (Français)</span>
                        <span class="text-primary group-hover:translate-x-1 transition-transform">&rarr;</span>
                    </a>
                    <a href="https://www.meyrinctt.ch/docs/Demande%20d%27adh%C3%A9sion%20Meyrin%20CTT_en.pdf" target="_blank" class="flex items-center justify-between p-4 border-2 border-border rounded-lg hover:bg-gray-50 transition-colors group">
                        <span class="font-bold">Formulaire (English)</span>
                        <span class="text-primary group-hover:translate-x-1 transition-transform">&rarr;</span>
                    </a>
                </div>

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
                <p class="mb-6 text-gray-700">Pour les joueurs désirant rejoindre une équipe pour la compétition, veuillez remplir les documents suivants.</p>
                
                <div class="flex flex-col gap-4">
                    <a href="https://www.meyrinctt.ch/docs/Demande%20de%20licence%20saison%202025-2026.pdf" target="_blank" class="flex items-center justify-between p-4 border-2 border-border rounded-lg hover:bg-gray-50 transition-colors group">
                        <span class="font-bold">Demande de licence</span>
                        <span class="text-primary group-hover:translate-x-1 transition-transform">&rarr;</span>
                    </a>
                    <a href="https://www.meyrinctt.ch/docs/Formulaire%20dopage.pdf" target="_blank" class="flex items-center justify-between p-4 border-2 border-border rounded-lg hover:bg-gray-50 transition-colors group">
                        <span class="font-bold">Formulaire dopage</span>
                        <span class="text-primary group-hover:translate-x-1 transition-transform">&rarr;</span>
                    </a>
                </div>

                <div class="mt-8 pt-6 border-t-2 border-gray-100">
                    <h3 class="font-bold uppercase text-sm text-gray-500 mb-2">Paiements</h3>
                    <p class="font-medium">CCP du Club: <span class="font-mono bg-gray-100 px-2 py-1 rounded">12-19447-4</span></p>
                </div>
            </div>
        </div>

        <div class="text-center bg-primary/5 rounded-xl p-8 border-2 border-primary/20">
            <h3 class="text-xl font-black uppercase mb-4">Besoin d'aide ?</h3>
            <p class="mb-6">Pour plus d'informations, vous pouvez contacter la présidente du Meyrin CTT, Mme Joan Helfer.</p>
            <a href="mailto:helferjoan@hotmail.com" class="inline-block px-8 py-3 bg-primary text-white font-bold rounded-full shadow-soft hover:shadow-hover transition-all">Nous contacter</a>
        </div>

    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
