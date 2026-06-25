<?php
/**
 * Inscription (Registration) page template
 */

function inscription_lang_value($item, string $field, string $lang, string $fallback = ''): string
{
    $localized = $field . '_' . $lang;
    $default = $field . '_fr';

    if (is_array($item)) {
        return (string)($item[$localized] ?? $item[$default] ?? $item[$field] ?? $fallback);
    }

    if (is_object($item)) {
        $content = method_exists($item, 'content') ? $item->content() : null;
        $value = $content
            ? $content->get($localized)->or($content->get($default))->or($content->get($field))->value()
            : $item->{$localized}()->or($item->{$default}())->or($item->{$field}())->value();
        return trim((string)$value) !== '' ? (string)$value : $fallback;
    }

    return $fallback;
}

function inscription_content_value($item, string $field, string $fallback = ''): string
{
    if (is_array($item)) {
        return (string)($item[$field] ?? $fallback);
    }

    if (is_object($item)) {
        $content = method_exists($item, 'content') ? $item->content() : null;
        $value = $content ? $content->get($field)->value() : $item->{$field}()->value();
        return trim((string)$value) !== '' ? (string)$value : $fallback;
    }

    return $fallback;
}

function inscription_field_name($field, int $sectionIndex, int $fieldIndex): string
{
    $raw = is_array($field)
        ? ($field['name'] ?? 'field_' . $sectionIndex . '_' . $fieldIndex)
        : inscription_content_value($field, 'name', 'field_' . $sectionIndex . '_' . $fieldIndex);

    $name = preg_replace('/[^a-zA-Z0-9_-]/', '', (string)$raw);
    return $name !== '' ? $name : 'field_' . $sectionIndex . '_' . $fieldIndex;
}

function inscription_width_class($field): string
{
    $width = is_array($field) ? ($field['width'] ?? 'half') : inscription_content_value($field, 'width', 'half');

    return match ($width) {
        'full' => 'inscription-field--full',
        'third' => 'inscription-field--third',
        default => 'inscription-field--half',
    };
}

function inscription_options($field): array
{
    if (is_array($field)) {
        return $field['options'] ?? [];
    }

    $content = method_exists($field, 'content') ? $field->content() : null;
    $options = $content ? $content->get('options') : $field->options();

    if ($options->isEmpty()) {
        return [];
    }

    return iterator_to_array($options->toStructure());
}

function inscription_bool($field, string $key): bool
{
    if (is_array($field)) {
        return (bool)($field[$key] ?? false);
    }

    $content = method_exists($field, 'content') ? $field->content() : null;
    return $content ? $content->get($key)->toBool() : $field->{$key}()->toBool();
}

function inscription_render_text(string $value, string $clubEmail): string
{
    return str_replace('{{club_email}}', $clubEmail, $value);
}

snippet('header');
snippet('hero');

$onlineFormEnabled = $page->online_form_enabled()->isEmpty() || $page->online_form_enabled()->toBool();
$formSections = $page->online_form_sections()->isNotEmpty()
    ? $page->online_form_sections()->toStructure()
    : [];
$fees = $page->fees()->isNotEmpty() ? $page->fees()->toStructure() : [];
$printLogoUrl = url('assets/logo.png');
$contactPage = page('contact');
$clubEmail = $contactPage && $contactPage->contact_email()->isNotEmpty()
    ? $contactPage->contact_email()->value()
    : 'info@meyrinctt.ch';
?>

<section class="py-16 inscription-page">
    <div class="max-w-[1100px] mx-auto px-4">
        <div class="bg-white border-2 border-border rounded-xl p-8 shadow-soft mb-16 inscription-fees-overview">
            <h2 class="text-3xl font-black uppercase mb-6 text-center"><?= $page->fees_title()->or("Tarifs d'adhésion 2025-2026")->esc() ?></h2>

            <?php if ($page->fees()->isNotEmpty()): ?>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-primary text-white">
                            <th class="p-4 text-left font-bold uppercase text-sm border-2 border-primary">Catégorie</th>
                            <th class="p-4 text-right font-bold uppercase text-sm border-2 border-primary">Cotisation sans licence</th>
                            <th class="p-4 text-right font-bold uppercase text-sm border-2 border-primary">Cotisation avec licence AGTT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($fees as $fee): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 border-2 border-border font-medium"><?= $fee->category()->esc() ?></td>
                            <td class="p-4 border-2 border-border text-right font-mono"><?= $fee->cotisation()->esc() ?></td>
                            <td class="p-4 border-2 border-border text-right font-mono"><?= $fee->licence()->or('-')->esc() ?></td>
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

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-16 inscription-downloads">
            <div class="bg-surface border-2 border-border rounded-xl p-8 shadow-soft">
                <h2 class="text-2xl font-black uppercase mb-6 flex items-center gap-3">
                    <span class="w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center text-sm">1</span>
                    Demande d'adhésion
                </h2>
                <div class="formatted-text mb-6 text-gray-700 min-h-24">
                    <?= $page->adhesion_description()->or("Pour nous rejoindre, veuillez remplir le formulaire d'adhésion ou passer directement au club.")->kt() ?>
                </div>

                <?php if ($page->adhesion_forms()->isNotEmpty()): ?>
                <div class="flex flex-col gap-4">
                    <?php foreach ($page->adhesion_forms()->toStructure() as $form): ?>
                        <?php if ($file = $form->file()->toFile()): ?>
                        <a href="<?= $file->url() ?>" target="_blank" class="flex items-center justify-between p-4 border-2 border-border rounded-lg hover:bg-gray-50 transition-colors group">
                            <span class="font-bold"><?= $form->title()->esc() ?></span>
                            <span class="text-primary group-hover:translate-x-1 transition-transform">-&gt;</span>
                        </a>
                        <?php endif ?>
                    <?php endforeach ?>
                </div>
                <?php endif ?>
            </div>

            <div class="bg-surface border-2 border-border rounded-xl p-8 shadow-soft">
                <h2 class="text-2xl font-black uppercase mb-6 flex items-center gap-3">
                    <span class="w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center text-sm">2</span>
                    Demande de licence
                </h2>
                <div class="formatted-text mb-6 text-gray-700 min-h-24">
                    <?= $page->licence_description()->or("Pour les joueurs désirant rejoindre une équipe pour la compétition, veuillez remplir les documents suivants.")->kt() ?>
                </div>

                <?php if ($page->licence_forms()->isNotEmpty()): ?>
                <div class="flex flex-col gap-4">
                    <?php foreach ($page->licence_forms()->toStructure() as $form): ?>
                        <?php if ($file = $form->file()->toFile()): ?>
                        <a href="<?= $file->url() ?>" target="_blank" class="flex items-center justify-between p-4 border-2 border-border rounded-lg hover:bg-gray-50 transition-colors group">
                            <span class="font-bold"><?= $form->title()->esc() ?></span>
                            <span class="text-primary group-hover:translate-x-1 transition-transform">-&gt;</span>
                        </a>
                        <?php endif ?>
                    <?php endforeach ?>
                </div>
                <?php endif ?>
            </div>
        </div>

        <?php if ($onlineFormEnabled && count($formSections) > 0): ?>
        <form id="inscription-online-form" class="inscription-online-form bg-white border-2 border-border rounded-xl shadow-soft mb-16" data-inscription-form novalidate>
            <div class="inscription-form-toolbar">
                <div>
                    <p class="text-sm font-bold uppercase text-primary mb-2">Formulaire remplissable</p>
                    <h2 class="text-3xl font-black uppercase" data-lang-fr="<?= $page->online_form_title_fr()->or("Demande d'adhésion")->esc() ?>" data-lang-en="<?= $page->online_form_title_en()->or('Membership application')->esc() ?>">
                        <?= $page->online_form_title_fr()->or("Demande d'adhésion")->esc() ?>
                    </h2>
                    <p class="mt-3 text-gray-700" data-lang-fr="<?= $page->online_form_intro_fr()->esc() ?>" data-lang-en="<?= $page->online_form_intro_en()->esc() ?>">
                        <?= $page->online_form_intro_fr()->esc() ?>
                    </p>
                </div>

                <div class="inscription-form-actions">
                    <div class="inscription-lang-toggle" role="group" aria-label="Language">
                        <button type="button" class="is-active" data-inscription-lang="fr">FR</button>
                        <button type="button" data-inscription-lang="en">EN</button>
                    </div>
                    <button type="button" class="btn-primary inscription-print-button" data-inscription-print-empty data-lang-fr="Télécharger le PDF vierge" data-lang-en="Download blank PDF">
                        Télécharger le PDF vierge
                    </button>
                </div>
            </div>

            <div class="inscription-print-header">
                <img src="<?= $printLogoUrl ?>" alt="<?= $site->title()->esc() ?>">
                <div>
                    <p class="inscription-club-name">Meyrin - Club de Tennis de Table</p>
                    <p>Affilié à l'Association Genevoise (AGTT) et à la Fédération Suisse (STT) de Tennis de Table</p>
                    <p>Local: rue De-Livron 2</p>
                </div>
            </div>

            <div class="inscription-form-body">
                <?php if (count($fees) > 0): ?>
                <section class="inscription-form-section inscription-tariff-section">
                    <h3 data-lang-fr="Montant des cotisations annuelles" data-lang-en="Annual membership fees">Montant des cotisations annuelles</h3>
                    <div class="inscription-tariff-table-wrap">
                        <table class="inscription-tariff-table">
                            <thead>
                                <tr>
                                    <th data-lang-fr="Catégorie" data-lang-en="Category">Catégorie</th>
                                    <th data-lang-fr="Sans licence" data-lang-en="Without license">Sans licence</th>
                                    <th data-lang-fr="Avec licence AGTT" data-lang-en="With AGTT license">Avec licence AGTT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($fees as $index => $fee): ?>
                                <?php
                                $feeKey = $fee->fee_key()->or('fee-' . $index)->value();
                                $feeLabelFr = $fee->category()->value();
                                $feeLabelEn = $fee->category_en()->or($fee->category())->value();
                                $hasCotisation = $fee->cotisation()->isNotEmpty();
                                $hasLicence = $fee->licence()->isNotEmpty();
                                ?>
                                <tr>
                                    <td>
                                        <span data-lang-fr="<?= esc($feeLabelFr, 'attr') ?>" data-lang-en="<?= esc($feeLabelEn, 'attr') ?>">
                                            <?= esc($feeLabelFr) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <label class="inscription-fee-option <?= $hasCotisation ? '' : 'is-disabled' ?>" for="membership-fee-<?= esc($feeKey, 'attr') ?>-without">
                                            <input
                                                type="radio"
                                                name="membership_fee"
                                                value="<?= esc($feeKey . ':without-license', 'attr') ?>"
                                                id="membership-fee-<?= esc($feeKey, 'attr') ?>-without"
                                                <?= $hasCotisation ? '' : 'disabled' ?>
                                                required>
                                            <span><?= $fee->cotisation()->or('-')->esc() ?></span>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="inscription-fee-option <?= $hasLicence ? '' : 'is-disabled' ?>" for="membership-fee-<?= esc($feeKey, 'attr') ?>-with">
                                            <input
                                                type="radio"
                                                name="membership_fee"
                                                value="<?= esc($feeKey . ':with-license', 'attr') ?>"
                                                id="membership-fee-<?= esc($feeKey, 'attr') ?>-with"
                                                <?= $hasLicence ? '' : 'disabled' ?>
                                                required>
                                            <span><?= $fee->licence()->or('-')->esc() ?></span>
                                        </label>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if ($page->fees_note()->isNotEmpty()): ?>
                    <p class="inscription-fees-note"><?= $page->fees_note()->esc() ?></p>
                    <?php endif ?>
                </section>
                <?php endif ?>

                <?php foreach ($formSections as $sectionIndex => $section): ?>
                <section class="inscription-form-section">
                    <h3 data-lang-fr="<?= esc(inscription_lang_value($section, 'title', 'fr'), 'attr') ?>" data-lang-en="<?= esc(inscription_lang_value($section, 'title', 'en'), 'attr') ?>">
                        <?= esc(inscription_lang_value($section, 'title', 'fr')) ?>
                    </h3>

                    <div class="inscription-field-grid">
                        <?php foreach ($section->content()->get('fields')->toStructure() as $fieldIndex => $field): ?>
                        <?php
                        $type = inscription_content_value($field, 'type', 'text');
                        $name = inscription_field_name($field, $sectionIndex, $fieldIndex);
                        if ($name === 'information_notice') {
                            $type = 'notice';
                        } elseif ($name === 'image_rights') {
                            $type = 'checkbox';
                        }
                        $id = 'inscription-' . $name;
                        $labelFr = inscription_lang_value($field, 'label', 'fr');
                        $labelEn = inscription_lang_value($field, 'label', 'en', $labelFr);
                        $helpFr = inscription_lang_value($field, 'help', 'fr');
                        $helpEn = inscription_lang_value($field, 'help', 'en', $helpFr);
                        $labelFr = inscription_render_text($labelFr, $clubEmail);
                        $labelEn = inscription_render_text($labelEn, $clubEmail);
                        $helpFr = inscription_render_text($helpFr, $clubEmail);
                        $helpEn = inscription_render_text($helpEn, $clubEmail);
                        $required = inscription_bool($field, 'required');
                        $widthClass = inscription_width_class($field);
                        ?>

                        <?php if ($type === 'notice'): ?>
                        <div class="inscription-field inscription-notice <?= $widthClass ?>">
                            <p data-lang-fr="<?= esc($labelFr, 'attr') ?>" data-lang-en="<?= esc($labelEn, 'attr') ?>"><?= esc($labelFr) ?></p>
                        </div>
                        <?php elseif ($type === 'signature'): ?>
                        <div class="inscription-field inscription-signature-field <?= $widthClass ?>">
                            <label for="<?= esc($id, 'attr') ?>" data-lang-fr="<?= esc($labelFr, 'attr') ?>" data-lang-en="<?= esc($labelEn, 'attr') ?>"><?= esc($labelFr) ?></label>
                            <div class="inscription-signature-box" id="<?= esc($id, 'attr') ?>"></div>
                            <?php if ($helpFr !== '' || $helpEn !== ''): ?>
                            <p class="inscription-help" data-lang-fr="<?= esc($helpFr, 'attr') ?>" data-lang-en="<?= esc($helpEn, 'attr') ?>"><?= esc($helpFr) ?></p>
                            <?php endif ?>
                        </div>
                        <?php else: ?>
                        <div class="inscription-field <?= $widthClass ?>">
                            <?php if ($type !== 'checkbox'): ?>
                            <label for="<?= esc($id, 'attr') ?>" data-lang-fr="<?= esc($labelFr, 'attr') ?>" data-lang-en="<?= esc($labelEn, 'attr') ?>"><?= esc($labelFr) ?></label>
                            <?php endif ?>

                            <?php if ($type === 'textarea'): ?>
                            <textarea id="<?= esc($id, 'attr') ?>" name="<?= esc($name, 'attr') ?>" rows="3" <?= $required ? 'required' : '' ?>></textarea>
                            <?php elseif ($type === 'checkbox'): ?>
                            <label class="inscription-checkbox-field" for="<?= esc($id, 'attr') ?>">
                                <input id="<?= esc($id, 'attr') ?>" name="<?= esc($name, 'attr') ?>" type="checkbox" value="1" <?= $required ? 'required' : '' ?>>
                                <span data-lang-fr="<?= esc($labelFr, 'attr') ?>" data-lang-en="<?= esc($labelEn, 'attr') ?>"><?= esc($labelFr) ?></span>
                            </label>
                            <?php elseif ($type === 'select'): ?>
                            <select id="<?= esc($id, 'attr') ?>" name="<?= esc($name, 'attr') ?>" <?= $required ? 'required' : '' ?>>
                                <option value="" data-lang-fr="Choisir..." data-lang-en="Choose...">Choisir...</option>
                                <?php foreach (inscription_options($field) as $option): ?>
                                <?php
                                $optionValue = is_array($option) ? ($option['value'] ?? '') : inscription_content_value($option, 'value');
                                $optionFr = inscription_lang_value($option, 'label', 'fr', (string)$optionValue);
                                $optionEn = inscription_lang_value($option, 'label', 'en', $optionFr);
                                ?>
                                <option value="<?= esc($optionValue, 'attr') ?>" data-lang-fr="<?= esc($optionFr, 'attr') ?>" data-lang-en="<?= esc($optionEn, 'attr') ?>"><?= esc($optionFr) ?></option>
                                <?php endforeach ?>
                            </select>
                            <?php elseif ($type === 'date'): ?>
                            <input
                                id="<?= esc($id, 'attr') ?>"
                                name="<?= esc($name, 'attr') ?>"
                                type="text"
                                inputmode="numeric"
                                autocomplete="off"
                                data-date-input
                                data-placeholder-fr="jj.mm.aaaa"
                                data-placeholder-en="dd.mm.yyyy"
                                data-title-fr="Format: jj.mm.aaaa"
                                data-title-en="Format: dd.mm.yyyy"
                                placeholder="jj.mm.aaaa"
                                pattern="\d{2}\.\d{2}\.\d{4}"
                                title="Format: jj.mm.aaaa"
                                <?= $required ? 'required' : '' ?>>
                            <?php else: ?>
                            <input id="<?= esc($id, 'attr') ?>" name="<?= esc($name, 'attr') ?>" type="<?= esc($type, 'attr') ?>" <?= $required ? 'required' : '' ?>>
                            <?php endif ?>

                            <?php if ($helpFr !== '' || $helpEn !== ''): ?>
                            <p class="inscription-help" data-lang-fr="<?= esc($helpFr, 'attr') ?>" data-lang-en="<?= esc($helpEn, 'attr') ?>"><?= esc($helpFr) ?></p>
                            <?php endif ?>
                        </div>
                        <?php endif ?>
                        <?php endforeach ?>
                    </div>
                </section>
                <?php endforeach ?>
            </div>

            <div class="inscription-form-bottom-actions">
                <button type="button" class="btn-primary inscription-print-button" data-inscription-print data-lang-fr="<?= $page->online_form_submit_label_fr()->or('Télécharger le PDF rempli')->esc() ?>" data-lang-en="<?= $page->online_form_submit_label_en()->or('Download filled PDF')->esc() ?>">
                    <?= $page->online_form_submit_label_fr()->or('Télécharger le PDF rempli')->esc() ?>
                </button>
            </div>
        </form>
        <?php endif ?>

        <div class="mt-8 pt-6 border-t-2 border-gray-100 mb-16 inscription-payment-info">
            <h1 class="text-3xl font-black uppercase my-8">
                Adresse postale et informations de paiement
            </h1>
            <h3 class="font-bold uppercase text-sm text-gray-500 mb-2">Adresse postale</h3>
            <p class="font-medium">MEYRIN CTT<br>2, rue De-Livron<br>1217 Meyrin</p>
            <?php if ($page->payment_info()->isNotEmpty()): ?>
                <h3 class="font-bold uppercase text-sm text-gray-500 my-2">Paiements</h3>
                <p class="font-medium">CCP du Club: <span class="font-mono bg-gray-100 px-2 py-1 rounded"><?= $page->payment_info()->esc() ?></span></p>
            <?php endif ?>
        </div>

        <div class="text-center bg-primary/5 rounded-xl p-8 border-2 border-primary/20 inscription-help-box">
            <h3 class="text-xl font-black uppercase mb-4">Besoin d'aide ?</h3>
            <p class="mb-6">Pour plus d'informations, vous pouvez contacter la présidente du Meyrin CTT.</p>
            <a href="<?= page('contact')?->url() ?>" class="inline-block px-8 py-3 bg-primary text-white font-bold rounded-full shadow-soft hover:shadow-hover transition-all">Nous contacter</a>
        </div>
    </div>
</section>

<?php snippet('footer') ?>
