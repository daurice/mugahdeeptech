<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$meta = page_meta('Contact', 'Book an AI and data consultation with Mugah DeepTech in Nairobi, Kenya.');
$errors = [];
$success = false;
$values = ['full_name' => '', 'email' => '', 'phone' => '', 'company' => '', 'service' => '', 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? null)) {
        $errors[] = 'Security check failed. Please reload the page and try again.';
    }

    foreach ($values as $key => $_) {
        $values[$key] = trim((string) ($_POST[$key] ?? ''));
    }

    if (strlen($values['full_name']) < 2) {
        $errors[] = 'Please enter your full name.';
    }
    if (!filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }
    if ($values['service'] === '' || !in_array($values['service'], service_options(), true)) {
        $errors[] = 'Please choose a valid service.';
    }
    if (strlen($values['message']) < 10) {
        $errors[] = 'Please enter a message with at least 10 characters.';
    }

    if (!$errors) {
        $stmt = $pdo->prepare('INSERT INTO inquiries (full_name, email, phone, company, service, message, ip_address, user_agent) VALUES (:full_name, :email, :phone, :company, :service, :message, :ip_address, :user_agent)');
        $stmt->execute([
            ':full_name' => $values['full_name'],
            ':email' => $values['email'],
            ':phone' => $values['phone'],
            ':company' => $values['company'],
            ':service' => $values['service'],
            ':message' => $values['message'],
            ':ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
            ':user_agent' => substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 255),
        ]);
        $success = true;
        $values = array_fill_keys(array_keys($values), '');
    }
}

include __DIR__ . '/includes/header.php';
?>
<section class="page-hero"><div class="container"><p class="eyebrow">Contact</p><h1>Book an AI consultation.</h1><p>Tell us where you are headed. We will help clarify the best path from data, automation, and AI opportunity to measurable business outcomes.</p></div></section>
<section class="section-pad">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5">
                <div class="glass-card h-100">
                    <h2>Nairobi, Kenya</h2>
                    <p>Serving executive teams, growing companies, NGOs, and institutions ready to build intelligent operations.</p>
                    <div class="contact-line"><strong>Email</strong><span>consult@mugahdeeptech.net</span></div>
                    <div class="contact-line"><strong>Focus</strong><span>AI strategy, analytics, automation, ML, dashboards, and training</span></div>
                </div>
            </div>
            <div class="col-lg-7">
                <form class="glass-card contact-form" method="post" action="<?= site_url('contact.php'); ?>" novalidate>
                    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()); ?>">
                    <?php if ($success): ?><div class="alert alert-success">Thank you. Your inquiry has been received.</div><?php endif; ?>
                    <?php if ($errors): ?><div class="alert alert-danger"><?= e(implode(' ', $errors)); ?></div><?php endif; ?>
                    <div class="row g-3">
                        <div class="col-md-6"><label>Full Name</label><input class="form-control" name="full_name" value="<?= e($values['full_name']); ?>" required></div>
                        <div class="col-md-6"><label>Email</label><input class="form-control" type="email" name="email" value="<?= e($values['email']); ?>" required></div>
                        <div class="col-md-6"><label>Phone</label><input class="form-control" name="phone" value="<?= e($values['phone']); ?>"></div>
                        <div class="col-md-6"><label>Company</label><input class="form-control" name="company" value="<?= e($values['company']); ?>"></div>
                        <div class="col-12"><label>Service Interested In</label><select class="form-select" name="service" required><option value="">Select a service</option><?php foreach (service_options() as $service): ?><option value="<?= e($service); ?>" <?= $values['service'] === $service ? 'selected' : ''; ?>><?= e($service); ?></option><?php endforeach; ?></select></div>
                        <div class="col-12"><label>Message</label><textarea class="form-control" name="message" rows="5" required><?= e($values['message']); ?></textarea></div>
                        <div class="col-12"><button class="btn btn-premium btn-lg" type="submit">Send Inquiry</button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
