<?php
// Handles the contact form and sends the message to your email using PHPMailer (SMTP).
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/includes/PHPMailer/Exception.php';
require __DIR__ . '/includes/PHPMailer/PHPMailer.php';
require __DIR__ . '/includes/PHPMailer/SMTP.php';

$config = require __DIR__ . '/includes/config.php';
$mail   = $config['mail'];

// Small helper: go back to the form with a status message.
function back(string $status): void {
    header('Location: index.php?status=' . $status . '#contact');
    exit;
}

// Only accept form submissions (POST).
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php#contact');
    exit;
}

// Honeypot: real people never see this hidden field, bots fill it.
if (!empty($_POST['website'])) {
    back('sent');
}

// Clean the input.
$name    = trim(strip_tags($_POST['name'] ?? ''));
$email   = trim($_POST['email'] ?? '');
$message = trim(strip_tags($_POST['message'] ?? ''));

// Validate. strlen counts bytes, which is fine as a simple upper limit.
if (
    $name === '' || $message === '' ||
    strlen($name) > 160 || strlen($message) > 3000 ||
    !filter_var($email, FILTER_VALIDATE_EMAIL)
) {
    back('invalid');
}

// If the email settings are missing, report an error instead of pretending it was sent.
$useResend = $mail['resend_key'] !== '';
if ($mail['to'] === '' || (!$useResend && ($mail['user'] === '' || $mail['pass'] === ''))) {
    error_log('Contact form: set RESEND_API_KEY + MAIL_TO (Railway) or SMTP_USER + SMTP_PASS + MAIL_TO (XAMPP).');
    back('error');
}

$subject = 'Portfolio message from ' . $name;
$body    = "Name: $name\nEmail: $email\n\nMessage:\n$message";

// ---- Railway: send through Resend's HTTPS API (works without SMTP) ----
if ($useResend) {
    $payload = json_encode([
        'from'     => $mail['resend_from'],
        'to'       => [$mail['to']],
        'reply_to' => $email,
        'subject'  => $subject,
        'text'     => $body,
    ]);
    $ch = curl_init('https://api.resend.com/emails');
    curl_setopt_array($ch, [
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => $payload,
        CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $mail['resend_key'], 'Content-Type: application/json'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 10,
    ]);
    $response = curl_exec($ch);
    $code     = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    curl_close($ch);
    if ($response === false || $code < 200 || $code >= 300) {
        error_log('Contact form Resend error (' . $code . '): ' . $response);
        back('error');
    }
    back('sent');
}

// ---- XAMPP: send through Gmail SMTP with PHPMailer ----

try {
    $m = new PHPMailer(true);   // true = throw exceptions on failure
    $m->isSMTP();
    $m->Host       = $mail['host'];
    $m->Port       = $mail['port'];
    $m->SMTPAuth   = true;
    $m->Username   = $mail['user'];
    $m->Password   = $mail['pass'];
    $m->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $m->CharSet    = 'UTF-8';
    $m->Timeout    = 10;

    $m->setFrom($mail['user'], 'Portfolio Contact Form');
    $m->addAddress($mail['to']);
    $m->addReplyTo($email, $name);   // pressing Reply answers the visitor

    $m->Subject = $subject;
    $m->Body    = $body;
    $m->send();

    back('sent');
} catch (Exception $e) {
    error_log('Contact form mail error: ' . $e->getMessage());
    back('error');
}
