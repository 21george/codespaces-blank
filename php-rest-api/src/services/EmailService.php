<?php

namespace App\Services;

class EmailService
{
    public function sendVerificationEmail($email, $verificationCode)
    {
        // Here you would normally use a mailer library to send the email
        // For simplicity, we are just printing the verification code
        echo "Verification email sent to $email with code: $verificationCode";
    }
}