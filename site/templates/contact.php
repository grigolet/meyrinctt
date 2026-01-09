<?php
/**
 * Contact page template
 *
 * Contact form with Turnstile captcha and club information.
 * Form logic is handled by the controller (site/controllers/contact.php)
 */
snippet('header');
snippet('hero');
?>

<section class="py-16">
    <div class="max-w-[1200px] mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">

            <!-- Form -->
            <div>
                <h2 class="text-2xl font-black uppercase mb-6"><?= $page->form_title()->or('Envoyez un message')->esc() ?></h2>
                <div class="bg-white border-2 border-border rounded-xl p-8 shadow-soft">
                    <?php if ($alert): ?>
                    <div class="mb-6 p-4 <?= $alert['type'] === 'success' ? 'bg-green-50 border-2 border-green-500 text-green-800' : 'bg-red-50 border-2 border-red-500 text-red-800' ?> rounded-lg">
                        <strong><?= $alert['type'] === 'success' ? '&#10003; Succes !' : '&#10007; Erreur' ?></strong><br>
                        <?= $alert['message'] ?>
                    </div>
                    <?php endif ?>

                    <form action="<?= $page->url() ?>" method="POST">
                        <input type="hidden" name="submit_contact" value="1">
                        <div class="mb-6">
                            <label class="block font-bold mb-2" for="name">Nom <span class="text-red-500">*</span></label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="<?= Str::esc($data['name']) ?>"
                                required
                                class="w-full p-3 border-2 border-[#ddd] rounded-md font-sans focus:border-primary focus:outline-none transition-colors"
                                placeholder="Votre nom complet">
                        </div>
                        <div class="mb-6">
                            <label class="block font-bold mb-2" for="email">Email <span class="text-red-500">*</span></label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="<?= Str::esc($data['email']) ?>"
                                required
                                class="w-full p-3 border-2 border-[#ddd] rounded-md font-sans focus:border-primary focus:outline-none transition-colors"
                                placeholder="votre.email@exemple.com">
                        </div>
                        <div class="mb-6">
                            <label class="block font-bold mb-2" for="subject">Sujet <span class="text-red-500">*</span></label>
                            <input
                                type="text"
                                id="subject"
                                name="subject"
                                value="<?= Str::esc($data['subject']) ?>"
                                required
                                class="w-full p-3 border-2 border-[#ddd] rounded-md font-sans focus:border-primary focus:outline-none transition-colors"
                                placeholder="Sujet de votre message">
                        </div>
                        <div class="mb-6">
                            <label class="block font-bold mb-2" for="message">Message <span class="text-red-500">*</span></label>
                            <textarea
                                id="message"
                                name="message"
                                required
                                class="w-full p-3 border-2 border-[#ddd] rounded-md font-sans h-[150px] focus:border-primary focus:outline-none transition-colors"
                                placeholder="Votre message..."><?= Str::esc($data['message']) ?></textarea>
                        </div>

                        <?php if ($turnstileEnabled): ?>
                        <div class="mb-6">
                            <div class="cf-turnstile" data-sitekey="<?= $turnstileSiteKey ?>"></div>
                        </div>
                        <?php endif ?>

                        <button
                            type="submit"
                            class="inline-block px-8 py-4 bg-primary text-white border-2 border-primary rounded-full font-bold uppercase shadow-soft transition-all hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-hover active:translate-0 active:shadow-none cursor-pointer">
                            Envoyer
                        </button>
                        <p class="mt-4 text-sm text-gray-600"><span class="text-red-500">*</span> Champs obligatoires</p>
                    </form>
                </div>
            </div>

            <!-- Info -->
            <section>
                <h2 class="text-2xl font-black uppercase mb-6"><?= $page->info_title()->or('Coordonnees')->esc() ?></h2>
                <div class="bg-white border-2 border-border rounded-xl p-8 shadow-soft mb-8">
                    <p class="text-lg leading-relaxed mb-4">
                        <strong><?= $site->title()->esc() ?></strong><br>
                        <?php if ($site->club_address()->isNotEmpty()): ?>
                            <?= $site->club_address()->kirbytext() ?>
                        <?php else: ?>
                            Rue de Livron 2<br>1217 Meyrin
                        <?php endif ?>
                        <?php if ($site->club_location_note()->isNotEmpty()): ?>
                        <br><em><?= $site->club_location_note()->esc() ?></em>
                        <?php endif ?>
                    </p>
                    <p class="text-lg leading-relaxed"><?= $site->club_email()->or('info@meyrinctt.ch')->esc() ?></p>
                </div>

                <?php if ($page->map_embed()->isNotEmpty()): ?>
                <div class="bg-white border-2 border-border rounded-xl overflow-hidden shadow-soft">
                    <?= $page->map_embed()->value() ?>
                </div>
                <?php endif ?>

                <?php if ($page->directions()->isNotEmpty()): ?>
                <div class="mt-8 bg-white border-2 border-border rounded-xl p-8 shadow-soft">
                    <h3 class="font-black uppercase mb-4">Comment nous trouver</h3>
                    <?= $page->directions()->kt() ?>
                </div>
                <?php endif ?>
            </section>

        </div>
    </div>
</section>

<!-- Error Modal Dialog -->
<dialog id="error-modal" class="fixed inset-0 z-[100] p-0 m-0 bg-transparent backdrop:bg-black/50 open:flex items-center justify-center">
    <div class="bg-white border-2 border-red-500 rounded-xl p-8 shadow-lg max-w-md mx-4">
        <div class="flex items-center gap-3 mb-4">
            <span class="text-red-500 text-3xl">&#9888;</span>
            <h3 id="error-modal-title" class="text-xl font-black uppercase text-red-700">Erreur</h3>
        </div>
        <p id="error-modal-message" class="text-gray-700 mb-4">Une erreur s'est produite.</p>
        <details id="error-modal-details" class="mb-6 hidden">
            <summary class="cursor-pointer text-sm text-gray-500 hover:text-gray-700">Details techniques</summary>
            <pre id="error-modal-details-text" class="mt-2 p-3 bg-gray-100 rounded text-xs overflow-auto max-h-32 text-gray-600"></pre>
        </details>
        <button
            onclick="document.getElementById('error-modal').close()"
            class="inline-block px-6 py-3 bg-red-500 text-white border-2 border-red-500 rounded-full font-bold uppercase shadow-soft transition-all hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-hover active:translate-0 active:shadow-none cursor-pointer">
            Fermer
        </button>
    </div>
</dialog>

<?php if ($turnstileEnabled): ?>
<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
<?php endif ?>

<?php if ($errorModal): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('error-modal');
        const title = document.getElementById('error-modal-title');
        const message = document.getElementById('error-modal-message');
        const details = document.getElementById('error-modal-details');
        const detailsText = document.getElementById('error-modal-details-text');

        title.textContent = <?= json_encode($errorModal['title']) ?>;
        message.textContent = <?= json_encode($errorModal['message']) ?>;

        <?php if (!empty($errorModal['details'])): ?>
        details.classList.remove('hidden');
        detailsText.textContent = <?= json_encode($errorModal['details']) ?>;
        <?php endif ?>

        modal.showModal();
    });
</script>
<?php endif ?>

<?php snippet('footer') ?>
