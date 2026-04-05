<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomVerifyEmail extends Notification implements ShouldQueue
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Verify Your Email Address - '.config('app.name'))
            ->html(
                <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Email Verification</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9fafb;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: white;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white !important;
            padding: 14px 28px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin: 20px 0;
            text-align: center;
        }
        .button:hover {
            opacity: 0.9;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #6b7280;
            font-size: 12px;
        }
        .highlight {
            color: #667eea;
            font-weight: bold;
        }
        .note {
            background: #f3f4f6;
            padding: 15px;
            border-radius: 8px;
            font-size: 14px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="margin: 0;">Welcome to {{ config('app.name') }}</h1>
        <p style="margin: 10px 0 0 0; opacity: 0.9;">Please verify your email address</p>
    </div>
    
    <div class="content">
        <p>Hello <strong>{{ $notifiable->name }}</strong>,</p>
        
        <p>Thank you for registering with <span class="highlight">{{ config('app.name') }}</span>! We're excited to have you as a member of our community.</p>
        
        <p>To complete your registration and access all features, please verify your email address by clicking the button below:</p>
        
        <p style="text-align: center;">
            <a href="{$verificationUrl}" class="button">Verify Email Address</a>
        </p>
        
        <div class="note">
            <p style="margin: 0;"><strong>Important:</strong></p>
            <ul style="margin: 10px 0 0 0; padding-left: 20px;">
                <li>This verification link will expire in 60 minutes</li>
                <li>If you didn't create an account, please ignore this email</li>
            </ul>
        </div>
        
        <p style="margin-top: 20px;">If you're having trouble clicking the button, copy and paste the URL below into your browser:</p>
        <p style="word-break: break-all; font-size: 12px; color: #6b7280;">{$verificationUrl}</p>
        
        <p style="margin-top: 30px;">Welcome aboard,<br><strong>The {{ config('app.name') }} Team</strong></p>
    </div>
    
    <div class="footer">
        <p>This is an automated message. Please do not reply directly to this email.</p>
    </div>
</body>
</html>
HTML
            );
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }

    protected function verificationUrl(object $notifiable): string
    {
        return url(route('verification.verify', [
            'id' => $notifiable->getKey(),
            'hash' => sha1($notifiable->getEmailForVerification()),
        ], false));
    }
}
