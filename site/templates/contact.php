<?php
/**
 * Contact page template
 *
 * Displays club contact information and location details.
 */
snippet('header');
snippet('hero', ['subtitle' => '']);

$contactEmail = $page->contact_email();
$mapUrl = $page->map_url();
$mapSrc = null;

if ($mapUrl->isNotEmpty()) {
    $candidate = $mapUrl->value();
    $host = parse_url($candidate, PHP_URL_HOST);
    $path = parse_url($candidate, PHP_URL_PATH) ?: '';

    if ($host && preg_match('/^(www|maps)\.google\.com$/i', $host) && str_contains($path, '/maps/embed')) {
        $mapSrc = $candidate;
    }
}
?>

<section class="py-16">
    <div class="max-w-[1200px] mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
            <section>
                <h2 class="text-2xl font-black uppercase mb-6">Contact</h2>
                <div class="bg-white border-2 border-border rounded-xl p-8 shadow-soft mb-8">
                    <p class="text-lg leading-relaxed mb-6">
                        Pour toute demande d'information, vous pouvez contacter le club par email.
                    </p>
                    <?php if ($contactEmail->isNotEmpty()): ?>
                    <a href="mailto:<?= $contactEmail->esc() ?>" class="inline-flex w-full sm:w-auto items-center justify-center rounded-md border-2 border-primary bg-primary px-5 py-3 font-bold text-white transition-colors hover:bg-primary-dark focus:outline-none focus-visible:ring-4 focus-visible:ring-primary/25">
                        <?= $contactEmail->esc() ?>
                    </a>
                    <?php endif ?>
                </div>

                <h2 class="text-2xl font-black uppercase mb-6"><?= $page->info_title()->esc() ?></h2>
                <div class="bg-white border-2 border-border rounded-xl p-8 shadow-soft">
                    <?php if ($page->coordinates()->isNotEmpty()): ?>
                    <div class="prose text-lg leading-relaxed">
                        <?= $page->coordinates()->kt() ?>
                    </div>
                    <?php endif ?>
                </div>
            </section>

            <section>
                <h2 class="text-2xl font-black uppercase mb-6">Localisation</h2>
                <?php if ($mapSrc): ?>
                <div class="bg-white border-2 border-border rounded-xl overflow-hidden shadow-soft">
                    <iframe
                        src="<?= esc($mapSrc, 'attr') ?>"
                        width="600"
                        height="450"
                        style="border:0;"
                        allowfullscreen
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        class="block w-full aspect-[4/3]">
                    </iframe>
                </div>
                <?php endif ?>
            </section>
        </div>
    </div>
</section>

<?php snippet('footer') ?>
