<?php
// Central settings: personal info, links, and mail settings.
// SECRETS (like the email app password) never go in this file because it is
// pushed to GitHub. They are read from environment variables (on the hosting
// dashboard) or from includes/config.local.php (ignored by Git, for XAMPP).

$local = is_file(__DIR__ . '/config.local.php') ? require __DIR__ . '/config.local.php' : [];

// env('KEY') -> hosting environment variable first, then config.local.php, then default.
$env = function (string $key, string $default = '') use ($local): string {
    $value = getenv($key);
    if ($value !== false && $value !== '') {
        return $value;
    }
    return (string) ($local[$key] ?? $default);
};

return [
    // ---- Personal info (edit these) ----
    'name'       => 'John Angelo Decendario',
    'first_name' => 'John Angelo',
    'initials'   => 'JA',
    'role'       => 'IT Student and Web Developer',
    'year_level' => '2nd year',
    'email'      => 'decendariojohnangelo9@gmail.com',
    'github'     => 'https://github.com/decendariojohnangelo9-coder',
    'linkedin'   => 'https://www.linkedin.com/in/john-angelo-decendario',

    // ---- Contact form mail settings (secrets come from env / config.local.php) ----
    'mail' => [
        'host' => $env('SMTP_HOST', 'smtp.gmail.com'),
        'port' => (int) $env('SMTP_PORT', '587'),
        'user' => $env('SMTP_USER'),   // the Gmail address that sends the message
        'pass' => $env('SMTP_PASS'),   // Gmail App Password (NOT your normal password)
        'to'   => $env('MAIL_TO'),     // where messages are delivered (can be the same Gmail)
    ],
];
