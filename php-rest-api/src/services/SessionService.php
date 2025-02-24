<?php

namespace App\Services;

class SessionService
{
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function createSession($userId, $verificationCode = null)
    {
        $_SESSION['user_id'] = $userId;
        if ($verificationCode) {
            $_SESSION['verification_code'] = $verificationCode;
        }
    }

    public function destroySession()
    {
        session_unset();
        session_destroy();
    }

    public function getUserId()
    {
        return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    }

    public function getVerificationCode()
    {
        return isset($_SESSION['verification_code']) ? $_SESSION['verification_code'] : null;
    }

    public function markUserAsVerified()
    {
        $_SESSION['is_verified'] = true;
    }

    public function isUserVerified()
    {
        return isset($_SESSION['is_verified']) && $_SESSION['is_verified'];
    }
}