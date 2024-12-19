<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTestEmail extends Command
{
    protected $signature = 'email:send-test';
    protected $description = 'Send a test email';

    public function handle()
    {
        $toEmail = 'ravelonarivoantonio@gmail.com'; 
        $subject = 'Email de validation';
        $messageBody = '<h1>Email de validation</h1><p>LELENA.</p>';

        // Envoi de l'email
        try {
            Mail::html($messageBody, function ($message) use ($toEmail, $subject) {
                $message->to($toEmail)
                    ->subject($subject);
            });

            $this->info('Email envoyé avec succès !');
        } catch (\Exception $e) {
            $this->error('Erreur d\'envoi : ' . $e->getMessage());
        }
    }
}
