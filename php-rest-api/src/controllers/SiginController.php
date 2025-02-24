<?php

namespace App\Controllers;

use App\Models\User;
use App\Services\EmailService;
use App\Services\SessionService;

class SignInController
{
    private $sessionService;
    private $emailService;

    public function __construct()
    {
        $this->sessionService = new SessionService();
        $this->emailService = new EmailService();
    }

    public function register($data)
    {
        $username = $data['username'];
        $password = $data['password'];
        $email = $data['email'];
        $age = $data['age'];

        // Here you would normally save the user to a database
        // For simplicity, we are using a hardcoded user
        $user = new User($username, 50000, 'USA', 'private');
        $user->setPassword($password); // Set a password for the user

        // Send verification email
        $verificationCode = uniqid();
        $this->emailService->sendVerificationEmail($email, $verificationCode);

        // Save the user and verification code to the session (or database)
        $this->sessionService->createSession($user->getId(), $verificationCode);

        return ['status' => 'success', 'message' => 'Registration successful. Please check your email for verification.'];
    }

    public function verifyEmail($verificationCode)
    {
        $sessionVerificationCode = $this->sessionService->getVerificationCode();

        if ($verificationCode === $sessionVerificationCode) {
            // Mark the user as verified (in the database or session)
            $this->sessionService->markUserAsVerified();
            return ['status' => 'success', 'message' => 'Email verification successful.'];
        }

        return ['status' => 'error', 'message' => 'Invalid verification code.'];
    }
}