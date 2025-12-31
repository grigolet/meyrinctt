<?php
/**
 * Contact page controller
 *
 * Handles contact form submission, validation, Turnstile verification, and email sending.
 * Uses flash messages with Post/Redirect/Get pattern for better UX.
 */

use Kirby\Http\Remote;

return function ($kirby, $page, $site) {
    $session = $kirby->session();

    // Retrieve flash messages (automatically removed after reading)
    $flash = $session->pull('contact_flash');
    $alert = $flash['alert'] ?? null;
    $errorModal = $flash['errorModal'] ?? null;

    // Retrieve preserved form data on error
    $data = $session->pull('contact_data') ?? ['name' => '', 'email' => '', 'subject' => '', 'message' => ''];

    if ($kirby->request()->is('POST') && get('submit_contact')) {
        $formData = [
            'name' => get('name'),
            'email' => get('email'),
            'subject' => get('subject'),
            'message' => get('message')
        ];

        $rules = [
            'name' => ['required', 'minLength' => 2],
            'email' => ['required', 'email'],
            'subject' => ['required', 'minLength' => 3],
            'message' => ['required', 'minLength' => 10]
        ];

        $messages = [
            'name' => 'Le nom est requis (minimum 2 caracteres)',
            'email' => "L'adresse email n'est pas valide",
            'subject' => 'Le sujet est requis (minimum 3 caracteres)',
            'message' => 'Le message est requis (minimum 10 caracteres)'
        ];

        if ($invalid = invalid($formData, $rules, $messages)) {
            // Validation failed - flash error and preserve form data
            $session->set('contact_flash', [
                'alert' => [
                    'type' => 'error',
                    'message' => implode('<br>', $invalid)
                ]
            ]);
            $session->set('contact_data', $formData);
            go($page->url());
        }

        // Verify Turnstile captcha if enabled
        $turnstileEnabled = option('turnstile.enabled', false);
        $turnstileValid = true;

        if ($turnstileEnabled) {
            $turnstileToken = get('cf-turnstile-response');
            $turnstileSecret = option('turnstile.secretKey', '');

            if (empty($turnstileToken)) {
                $turnstileValid = false;
                $session->set('contact_flash', [
                    'alert' => [
                        'type' => 'error',
                        'message' => 'Veuillez completer la verification captcha.'
                    ]
                ]);
                $session->set('contact_data', $formData);
                go($page->url());
            } else {
                $turnstileValid = verifyTurnstile($turnstileToken, $turnstileSecret);
                if (!$turnstileValid) {
                    $session->set('contact_flash', [
                        'alert' => [
                            'type' => 'error',
                            'message' => 'La verification captcha a echoue. Veuillez reessayer.'
                        ]
                    ]);
                    $session->set('contact_data', $formData);
                    go($page->url());
                }
            }
        }

        // All validations passed - try to send email
        try {
            $kirby->email([
                'from' => $site->email_from()->or('noreply@meyrinctt.ch')->value(),
                'replyTo' => $formData['email'],
                'to' => $site->email_to()->or('info@meyrinctt.ch')->value(),
                'subject' => $formData['subject'],
                'body' => "Nouveau message de contact depuis le site web\n\n" .
                          "Nom: " . $formData['name'] . "\n" .
                          "Email: " . $formData['email'] . "\n" .
                          "Sujet: " . $formData['subject'] . "\n\n" .
                          "Message:\n" . $formData['message']
            ]);

            // Success - flash success message and redirect (form data cleared)
            $session->set('contact_flash', [
                'alert' => [
                    'type' => 'success',
                    'message' => $page->success_message()->or('Votre message a ete envoye avec succes ! Nous vous repondrons dans les plus brefs delais.')->value()
                ]
            ]);
            go($page->url());

        } catch (Exception $e) {
            // Log the error
            $errorMessage = $e->getMessage();
            error_log("[" . date('Y-m-d H:i:s') . "] Contact form SMTP error: " . $errorMessage . " | From: " . $formData['email']);

            // Flash error modal and preserve form data
            $session->set('contact_flash', [
                'errorModal' => [
                    'title' => 'Erreur d\'envoi',
                    'message' => "Une erreur s'est produite lors de l'envoi du message. Veuillez reessayer plus tard ou nous contacter directement par email.",
                    'details' => $errorMessage
                ]
            ]);
            $session->set('contact_data', $formData);
            go($page->url());
        }
    }

    return [
        'alert' => $alert,
        'data' => $data,
        'errorModal' => $errorModal,
        'turnstileEnabled' => option('turnstile.enabled', false),
        'turnstileSiteKey' => option('turnstile.siteKey', '')
    ];
};

/**
 * Verify Turnstile captcha token with Cloudflare API
 */
function verifyTurnstile(string $token, string $secretKey): bool
{
    try {
        $response = Remote::post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'data' => [
                'secret' => $secretKey,
                'response' => $token
            ]
        ]);

        $result = $response->json();
        return $result['success'] ?? false;
    } catch (Exception $e) {
        error_log("[" . date('Y-m-d H:i:s') . "] Turnstile verification error: " . $e->getMessage());
        return false;
    }
}
