<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('mail.mail_driver', 'smtp');
        $this->migrator->add('mail.mail_host', null);
        $this->migrator->add('mail.mail_port', 587);
        $this->migrator->add('mail.mail_username', null);
        $this->migrator->add('mail.mail_password', null);
        $this->migrator->add('mail.mail_from_address', 'noreply@example.com');
        $this->migrator->add('mail.mail_from_name', null);
        $this->migrator->add('mail.mail_encryption', 'tls');
        $this->migrator->add('mail.queue_emails', true);
        $this->migrator->add('mail.mailgun_domain', null);
        $this->migrator->add('mail.mailgun_secret', null);
        $this->migrator->add('mail.ses_key', null);
        $this->migrator->add('mail.ses_secret', null);
    }
};
