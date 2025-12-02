<?php
$config = require __DIR__ . '/config.php';
$page_title = "Contact - " . $config['site_name'];
$hero_title = "Contact";
$hero_subtitle = "Une question ? Envie de nous rejoindre ?";

// Initialize variables
$success_message = '';
$error_message = '';
$form_data = [
    'name' => '',
    'email' => '',
    'message' => ''
];

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_contact'])) {
    // Get and sanitize form data
    $form_data['name'] = trim($_POST['name'] ?? '');
    $form_data['email'] = trim($_POST['email'] ?? '');
    $form_data['message'] = trim($_POST['message'] ?? '');
    
    // Validation
    $errors = [];
    
    if (empty($form_data['name'])) {
        $errors[] = "Le nom est requis.";
    } elseif (strlen($form_data['name']) < 2) {
        $errors[] = "Le nom doit contenir au moins 2 caractères.";
    }
    
    if (empty($form_data['email'])) {
        $errors[] = "L'email est requis.";
    } elseif (!filter_var($form_data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'adresse email n'est pas valide.";
    }
    
    if (empty($form_data['message'])) {
        $errors[] = "Le message est requis.";
    } elseif (strlen($form_data['message']) < 10) {
        $errors[] = "Le message doit contenir au moins 10 caractères.";
    }
    
    // If no errors, send email
    if (empty($errors) && $config['contact']['enable_notifications']) {
        $to = $config['contact']['email_to'];
        $subject = $config['contact']['email_subject'];
        $from = $config['contact']['email_from'];
        
        // Build email body
        $email_body = "Nouveau message de contact depuis le site web\n\n";
        $email_body .= "Nom: " . $form_data['name'] . "\n";
        $email_body .= "Email: " . $form_data['email'] . "\n\n";
        $email_body .= "Message:\n" . $form_data['message'] . "\n\n";
        $email_body .= "---\n";
        $email_body .= "Envoyé le: " . date('d/m/Y à H:i:s') . "\n";
        $email_body .= "IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'Unknown');
        
        // Email headers
        $headers = [];
        $headers[] = "From: " . $from;
        $headers[] = "Reply-To: " . $form_data['email'];
        $headers[] = "X-Mailer: PHP/" . phpversion();
        $headers[] = "Content-Type: text/plain; charset=UTF-8";
        
        // Send email
        if (mail($to, $subject, $email_body, implode("\r\n", $headers))) {
            $success_message = "Votre message a été envoyé avec succès ! Nous vous répondrons dans les plus brefs délais.";
            // Clear form data on success
            $form_data = ['name' => '', 'email' => '', 'message' => ''];
        } else {
            $error_message = "Une erreur s'est produite lors de l'envoi du message. Veuillez réessayer ou nous contacter directement par email.";
        }
    } elseif (!empty($errors)) {
        $error_message = implode('<br>', $errors);
    }
}

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/hero.php';
?>

<section class="py-16">
    <div class="max-w-[1200px] mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">

            <!-- Form -->
            <div class="bg-white border-2 border-border rounded-xl p-8 shadow-soft">
                <h2 class="text-2xl font-black uppercase mb-6">Envoyez un message</h2>
                
                <?php if ($success_message): ?>
                    <div class="mb-6 p-4 bg-green-50 border-2 border-green-500 rounded-lg text-green-800">
                        <strong>✓ Succès !</strong><br>
                        <?php echo htmlspecialchars($success_message); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($error_message): ?>
                    <div class="mb-6 p-4 bg-red-50 border-2 border-red-500 rounded-lg text-red-800">
                        <strong>✗ Erreur</strong><br>
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                
                <form action="contact.php" method="POST">
                    <div class="mb-6">
                        <label class="block font-bold mb-2" for="name">Nom <span class="text-red-500">*</span></label>
                        <input 
                            type="text" 
                            id="name"
                            name="name"
                            value="<?php echo htmlspecialchars($form_data['name']); ?>"
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
                            value="<?php echo htmlspecialchars($form_data['email']); ?>"
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
                            placeholder="Votre message..."><?php echo htmlspecialchars($form_data['message']); ?></textarea>
                    </div>
                    <button 
                        type="submit" 
                        name="submit_contact"
                        class="inline-block px-8 py-4 bg-primary text-white border-2 border-primary rounded-full font-bold uppercase shadow-soft transition-all hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-hover active:translate-0 active:shadow-none cursor-pointer">Envoyer</button>
                    <p class="mt-4 text-sm text-gray-600"><span class="text-red-500">*</span> Champs obligatoires</p>
                </form>
            </div>

            <!-- Info -->
            <div>
                <h2 class="text-2xl font-black uppercase mb-6">Coordonnées</h2>
                <div class="bg-white border-2 border-border rounded-xl p-8 shadow-soft mb-8">
                    <p class="text-lg leading-relaxed mb-4"><strong>Meyrin CTT</strong><br>Rue de Livron 2<br>1217 Meyrin<br><em>Local en-dessous de la Piscine</em> </p>
                    <p class="text-lg leading-relaxed">info@meyrinctt.ch</p>
                </div>
                <div class="border-2 border-border rounded-xl h-[300px] overflow-hidden shadow-soft">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2760.857686796446!2d6.078496315556114!3d46.23340697911744!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x478c626e5b5b5b5b%3A0x5b5b5b5b5b5b5b5b!2sRue%20de%20Livron%202%2C%201217%20Meyrin!5e0!3m2!1sen!2sch!4v1634567890123!5m2!1sen!2sch" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
