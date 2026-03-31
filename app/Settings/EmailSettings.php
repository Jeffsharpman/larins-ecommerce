<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class EmailSettings extends Settings
{
    public string $mail_driver = 'smtp';

    public ?string $mail_host = null;

    public ?int $mail_port = null;

    public ?string $mail_username = null;

    public ?string $mail_password = null;

    public string $mail_from_address = 'noreply@example.com';

    public ?string $mail_from_name = null;

    public string $mail_encryption = 'tls';

    public bool $queue_emails = true;

    public ?string $mailgun_domain = null;

    public ?string $mailgun_secret = null;

    public ?string $ses_key = null;

    public ?string $ses_secret = null;

    public static function group(): string
    {
        return 'mail';
    }
}
