<?php
$config = require __DIR__ . '/config.php';
$page_title = "Le Club - " . $config['site_name'];
$hero_title = "Le Club";
$hero_subtitle = "Découvrez l'équipe du Meyrin CTT.";
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/hero.php';

$committee = [
    ['role' => 'Présidente', 'name' => 'Mme Joan Helfer', 'email' => 'helferjoan@hotmail.com'],
    ['role' => 'Vice-Président', 'name' => 'M. Jean-Pierre Revol', 'email' => 'jean-pierre.revol@cern.ch'],
    ['role' => 'Vice-Président', 'name' => 'M. Gianluca Rigoletti', 'email' => 'gianluca.rigoletti@gmail.com'],
    ['role' => 'Trésorier', 'name' => 'M. Alain Reynier', 'email' => 'alain-reynier@hotmail.com'],
    ['role' => 'Secrétaire', 'name' => 'M. Reynald Schmid', 'email' => 'reynald.schmid@bluewin.ch'],
    ['role' => 'Informatique', 'name' => 'M. Alan Lumley', 'email' => 'alan@lumley.ch'],
    ['role' => 'Salle & Bar', 'name' => 'M. Carsten Neubauer', 'email' => 'carsten.neubauer@web.de'],
    ['role' => 'Webmaster', 'name' => 'M. Dominique Schneider', 'email' => 'schneiderdom@bluewin.ch'],
    ['role' => 'Techniques', 'name' => 'M. Bugra Bilin', 'email' => 'bbilin1986@gmail.com'],
];
?>

<section class="py-16">
    <div class="max-w-[1200px] mx-auto px-4">
        
        <div class="mb-16 text-center">
            <h2 class="text-3xl font-black uppercase mb-8 inline-block border-b-4 border-primary">Le Comité 2025 / 2026</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 text-left">
                <?php foreach ($committee as $member): ?>
                <div class="bg-surface border-2 border-border rounded-xl p-6 shadow-soft hover:shadow-hover transition-all flex flex-col items-center text-center">
                    <div class="w-24 h-24 rounded-full bg-gray-200 border-2 border-border mb-4 overflow-hidden">
                        <!-- Placeholder for profile photo -->
                        <svg class="w-full h-full text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <span class="block text-sm font-bold text-primary uppercase mb-1"><?php echo $member['role']; ?></span>
                    <h3 class="text-xl font-extrabold mb-2"><?php echo $member['name']; ?></h3>
                    <a href="mailto:<?php echo $member['email']; ?>" class="text-gray-600 hover:text-primary transition-colors flex items-center gap-2 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                        <?php echo $member['email']; ?>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="bg-primary/5 border-2 border-primary rounded-xl p-8 text-center max-w-[800px] mx-auto">
            <h3 class="text-2xl font-black uppercase mb-4">Membre d'honneur</h3>
            <p class="text-xl font-bold mb-2">Monsieur Richard Bourleau</p>
            <!-- <div class="w-16 h-1 bg-primary mx-auto my-4"></div>
            <p class="italic text-gray-700">Mérite administratif décerné par l'AGTT à Joan HELFER pour 20 années de Présidence du Meyrin CTT.</p> -->
        </div>

        <!-- Club Overview Section -->
        <div class="mb-16 mt-16">
            <h2 class="text-3xl font-black uppercase mb-8 text-center pb-4 border-b-4 border-primary inline-block">Le Club en Chiffres</h2>

            <div class="max-w-[900px] mx-auto mt-12">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Members stat -->
                    <div class="bg-surface border-2 border-border rounded-xl p-6 text-center shadow-soft hover:shadow-hover transition-all">
                        <div class="text-5xl font-black text-primary mb-2">160+</div>
                        <div class="text-lg font-bold uppercase">Membres</div>
                    </div>
                    <!-- Licensed players stat -->
                    <div class="bg-surface border-2 border-border rounded-xl p-6 text-center shadow-soft hover:shadow-hover transition-all">
                        <div class="text-5xl font-black text-primary mb-2">60</div>
                        <div class="text-lg font-bold uppercase">Joueurs Licenciés</div>
                    </div>
                    <!-- Youth school stat -->
                    <div class="bg-surface border-2 border-border rounded-xl p-6 text-center shadow-soft hover:shadow-hover transition-all">
                        <div class="text-5xl font-black text-primary mb-2">6+</div>
                        <div class="text-lg font-bold uppercase">Âge École Jeunesse</div>
                    </div>
                </div>

                <div class="bg-surface border-2 border-border rounded-xl p-8 shadow-soft">
                    <h3 class="text-2xl font-black mb-6">À Propos du Club</h3>
                    <div class="space-y-4 leading-relaxed">
                        <p>
                            Le Meyrin CTT est une association sportive de tennis de table dynamique, comptant plus de 160 membres
                            dont environ 60 joueurs licenciés. Notre club offre un environnement convivial pour les joueurs de tous niveaux,
                            du débutant au compétiteur confirmé.
                        </p>
                        <p>
                            Nous proposons une <strong>école de jeunesse</strong> accueillant les enfants dès l'âge de 6 ans, avec
                            un encadrement professionnel et des installations de qualité. Nos équipes participent activement aux ligues suisses,
                            représentant fièrement Meyrin dans les compétitions régionales et nationales.
                        </p>
                        <p>
                            Le club organise régulièrement des <strong>tournois internes et stages</strong>, et met également ses installations
                            à disposition pour la location d'événements. Avec une histoire riche et des installations modernes,
                            Meyrin CTT continue d'être un pilier du tennis de table dans la région genevoise.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Club History Section -->
        <div class="mb-16 mt-16">
            <h2 class="text-3xl font-black uppercase mb-8 text-center pb-4 border-b-4 border-primary inline-block">Histoire du Club</h2>

            <div class="max-w-[900px] mx-auto">
                <!-- Timeline style layout -->
                <div class="space-y-8 mt-12">

                    <!-- Origin Section -->
                    <div class="bg-surface border-2 border-border rounded-xl p-8 shadow-soft">
                        <span class="inline-block px-4 py-1 bg-primary text-white font-bold text-sm uppercase rounded-full mb-4">1977</span>
                        <h3 class="text-2xl font-black mb-4">Les Origines au BIT</h3>
                        <p class="mb-4 leading-relaxed">
                            Le club de tennis de table trouve ses origines au Bureau International du Travail en 1977,
                            établi grâce aux efforts de Jean Lambert, son président fondateur. Les membres provenaient
                            principalement des organisations internationales telles que le BIT, l'OMS, l'UIT et le GATT
                            (devenu OMC), ainsi que des représentants de missions diplomatiques.
                        </p>
                    </div>

                    <!-- Early Development -->
                    <div class="bg-surface border-2 border-border rounded-xl p-8 shadow-soft">
                        <span class="inline-block px-4 py-1 bg-primary text-white font-bold text-sm uppercase rounded-full mb-4">Années 80</span>
                        <h3 class="text-2xl font-black mb-4">Premiers Succès</h3>
                        <p class="mb-4 leading-relaxed">
                            Dès la première année, le club inscrit des équipes dans les ligues genevoises. L'équipe
                            masculine première est finalement promue en Ligue Nationale A. Cependant, la hauteur de
                            plafond inadéquate du BIT pour les standards de compétition nécessite le transport des
                            tables pour chaque match, créant des défis logistiques importants.
                        </p>
                    </div>

                    <!-- Merger -->
                    <div class="bg-surface border-2 border-border rounded-xl p-8 shadow-soft">
                        <span class="inline-block px-4 py-1 bg-primary text-white font-bold text-sm uppercase rounded-full mb-4">Fusion</span>
                        <h3 class="text-2xl font-black mb-4">Union avec Meyrin CTT</h3>
                        <p class="mb-4 leading-relaxed">
                            Pour résoudre ces limitations, le club du BIT fusionne avec Meyrin CTT, avec lequel il
                            entretenait déjà des relations amicales. Cette consolidation s'avère fructueuse et perdure
                            aujourd'hui. Les descendants de la famille Lambert restent d'ailleurs des joueurs actifs.
                            Le club conserve ses uniformes bleus en hommage aux couleurs de l'ONU.
                        </p>
                    </div>

                    <!-- Notable Players -->
                    <div class="bg-primary/5 border-2 border-primary rounded-xl p-8 shadow-soft">
                        <h3 class="text-2xl font-black mb-6 text-primary">Joueurs Remarquables</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex items-start gap-3">
                                <span class="text-2xl">🥉</span>
                                <div>
                                    <h4 class="font-bold text-lg mb-1">Jean Lambert</h4>
                                    <p class="text-sm text-gray-700">Médaille de bronze en double aux championnats du monde seniors (1996)</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="text-2xl">🥇</span>
                                <div>
                                    <h4 class="font-bold text-lg mb-1">Jacky Versang</h4>
                                    <p class="text-sm text-gray-700">Champion du monde vétérans (1996)</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="text-2xl">🏆</span>
                                <div>
                                    <h4 class="font-bold text-lg mb-1">Herbert Neubauer</h4>
                                    <p class="text-sm text-gray-700">Sept fois champion du monde vétérans avec 60 médailles d'or suisses</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="text-2xl">🌟</span>
                                <div>
                                    <h4 class="font-bold text-lg mb-1">Wei Zheng</h4>
                                    <p class="text-sm text-gray-700">Champion de Chine jeunesse</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3 md:col-span-2">
                                <span class="text-2xl">🌍</span>
                                <div>
                                    <h4 class="font-bold text-lg mb-1">Joueurs d'élite internationaux</h4>
                                    <p class="text-sm text-gray-700">Le club a également accueilli des joueurs d'élite de Chine, des États-Unis et de Russie</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Club Statutes Section -->
        <div class="mb-16">
            <h2 class="text-3xl font-black uppercase mb-8 text-center pb-4 border-b-4 border-primary inline-block">Statuts du Club</h2>

            <div class="max-w-[700px] mx-auto mt-12">
                <div class="bg-surface border-2 border-border rounded-xl p-8 shadow-soft hover:shadow-hover transition-all">
                    <div class="flex items-start gap-6">
                        <!-- PDF Icon -->
                        <div class="flex-shrink-0 w-20 h-20 bg-red-50 rounded-xl flex items-center justify-center border-2 border-red-200">
                            <svg class="w-12 h-12 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                            </svg>
                        </div>

                        <!-- Content -->
                        <div class="flex-1">
                            <h3 class="text-2xl font-black mb-2">Statuts Meyrin CTT</h3>
                            <p class="text-gray-700 mb-4 leading-relaxed">
                                Consultez les statuts officiels du club de tennis de table de Meyrin,
                                incluant les règles de gouvernance, les droits et devoirs des membres,
                                et la structure organisationnelle.
                            </p>
                            <a href="assets/documents/Statuts_Meyrin_CTT.pdf"
                               download
                               class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-white border-2 border-primary rounded-full font-bold uppercase text-sm shadow-soft hover:shadow-hover hover:-translate-y-0.5 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Télécharger les Statuts (PDF)
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Additional info -->
                <div class="mt-6 p-4 bg-primary/5 border-l-4 border-primary rounded-lg">
                    <p class="text-sm text-gray-700">
                        <strong>Note:</strong> Les statuts ont été approuvés lors de l'assemblée générale.
                        Pour toute question concernant les statuts, veuillez contacter le
                        <a href="contact.php" class="text-primary hover:underline font-bold">comité du club</a>.
                    </p>
                </div>
            </div>
        </div>

    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
