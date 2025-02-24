<?php
namespace App\Controllers;

use App\Models\User;
use App\Services\SessionService;

class AuthController
{
    private $sessionService;

    public function __construct()
    {
        $this->sessionService = new SessionService();
    }

    public function login($data)
    {
        $username = $data['username'];
        $password = $data['password'];
        $Age=$data['Age'];

        // Here you would normally fetch the user from a database
        // For simplicity, we are using a hardcoded user
        $user = new User('testuser', 50000, 'USA', 'private');
        $user->setPassword('password123'); // Set a password for the user

        if ($username === $user->getName() && password_verify($password, $user->getPassword())) {
            $this->sessionService->createSession($user->getId());
            return ['status' => 'success', 'message' => 'Login successful'];
        }

        return ['status' => 'error', 'message' => 'Invalid credentials'];
    }

    public function logout()
    {
        $this->sessionService->destroySession();
        return ['status' => 'success', 'message' => 'Logout successful'];
    }
}