<?php
/**
 * Contact page template
 * 
 * Contact form and club information.
 */
snippet('header');
snippet('hero');

// Form handling
$alert = null;

if ($kirby->request()->is('POST') && get('submit_contact')) {
    $data = [
        'name' => get('name'),
        'email' => get('email'),
        'message' => get('message')
    ];
    
    $rules = [
        'name' => ['required', 'minLength' => 2],
        'email' => ['required', 'email'],
        'message' => ['required', 'minLength' => 10]
    ];
    
    $messages = [
        'name' => 'Le nom est requis (minimum 2 caractères)',
        'email' => "L'adresse email n'est pas valide",
        'message' => 'Le message est requis (minimum 10 caractères)'
    ];
    
    if ($invalid = invalid($data, $rules, $messages)) {
        $alert = [
            'type' => 'error',
            'message' => implode('<br>', $invalid)
        ];
    } else {
        // Send email if notifications are enabled
        if ($site->enable_notifications()->toBool()) {
            try {
                $kirby->email([
                    'from' => $site->email_from()->or('noreply@meyrinctt.ch')->value(),
                    'replyTo' => $data['email'],
                    'to' => $site->email_to()->or('info@meyrinctt.ch')->value(),
                    'subject' => $site->email_subject()->or('Nouveau message depuis le site Meyrin CTT')->value(),
                    'body' => "Nouveau message de contact depuis le site web\n\n" .
                              "Nom: " . $data['name'] . "\n" .
                              "Email: " . $data['email'] . "\n\n" .
                              "Message:\n" . $data['message']
                ]);
                
                $alert = [
                    'type' => 'success',
                    'message' => $page->success_message()->or('Votre message a été envoyé avec succès ! Nous vous répondrons dans les plus brefs délais.')->value()
                ];
                $data = ['name' => '', 'email' => '', 'message' => ''];
            } catch (Exception $e) {
                $alert = [
                    'type' => 'error',
                    'message' => "Une erreur s'est produite lors de l'envoi du message. Veuillez réessayer."
                ];
            }
        } else {
            $alert = [
                'type' => 'success',
                'message' => 'Votre message a été reçu (notifications désactivées).'
            ];
            $data = ['name' => '', 'email' => '', 'message' => ''];
        }
    }
}

$data = $data ?? ['name' => '', 'email' => '', 'message' => ''];
?>

<section class="py-16">
    <div class="max-w-[1200px] mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">

            <!-- Form -->
            <div class="bg-white border-2 border-border rounded-xl p-8 shadow-soft">
                <h2 class="text-2xl font-black uppercase mb-6"><?= $page->form_title()->or('Envoyez un message')->esc() ?></h2>
                
                <?php if ($alert): ?>
                <div class="mb-6 p-4 <?= $alert['type'] === 'success' ? 'bg-green-50 border-2 border-green-500 text-green-800' : 'bg-red-50 border-2 border-red-500 text-red-800' ?> rounded-lg">
                    <strong><?= $alert['type'] === 'success' ? '✓ Succès !' : '✗ Erreur' ?></strong><br>
                    <?= $alert['message'] ?>
                </div>
                <?php endif ?>
                
                <form action="<?= $page->url() ?>" method="POST">
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
                        <label class="block font-bold mb-2" for="message">Message <span class="text-red-500">*</span></label>
                        <textarea 
                            id="message"
                            name="message"
                            required
                            class="w-full p-3 border-2 border-[#ddd] rounded-md font-sans h-[150px] focus:border-primary focus:outline-none transition-colors"
                            placeholder="Votre message..."><?= Str::esc($data['message']) ?></textarea>
                    </div>
                    <button 
                        type="submit" 
                        name="submit_contact"
                        class="inline-block px-8 py-4 bg-primary text-white border-2 border-primary rounded-full font-bold uppercase shadow-soft transition-all hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-hover active:translate-0 active:shadow-none cursor-pointer">
                        Envoyer
                    </button>
                    <p class="mt-4 text-sm text-gray-600"><span class="text-red-500">*</span> Champs obligatoires</p>
                </form>
            </div>

            <!-- Info -->
            <div>
                <h2 class="text-2xl font-black uppercase mb-6"><?= $page->info_title()->or('Coordonnées')->esc() ?></h2>
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
            </div>

        </div>
    </div>
</section>

<?php snippet('footer') ?>
