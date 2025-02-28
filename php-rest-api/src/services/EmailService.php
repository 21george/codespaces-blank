<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailService
{
    public function sendVerificationEmail($email, $verificationCode)
    {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.example.com'; // Set the SMTP server to send through
            $mail->SMTPAuth = true;
            $mail->Username = 'your_email@example.com'; // SMTP username
            $mail->Password = 'your_password'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('your_email@example.com', 'Mailer');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Email Verification';
            $mail->Body = "Your verification code is: $verificationCode";

            $mail->send();
            echo "Verification email sent to $email with code: $verificationCode";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function sendOTP($email, $otp)
    {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.example.com'; // Set the SMTP server to send through
            $mail->SMTPAuth = true;
            $mail->Username = 'your_email@example.com'; // SMTP username
            $mail->Password = 'your_password'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('your_email@example.com', 'Mailer');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code';
            $mail->Body = "Your OTP code is: $otp";

            $mail->send();
            echo "OTP email sent to $email with code: $otp";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}