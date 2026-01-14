<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class AuthController extends Controller {
    
    public function loginForm() {
        $this->guest();
        $this->view('auth/login');
    }

    public function login() {
        $this->guest();
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $userModel = new User();
        $user = $userModel->firstWhere('email', $email);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $this->redirect('/dashboard');
        } else {
            $_SESSION['error'] = 'Credenciales incorrectas';
            $this->redirect('/login');
        }
    }

    public function logout() {
        session_destroy();
        $this->redirect('/login');
    }

    public function forgotPasswordForm() {
        $this->guest();
        $this->view('auth/forgot-password');
    }

    public function sendResetLink() {
        // Mock implementation for now as we don't have a real mailer setup yet
        // but the prompt asked for the structure.
        $email = $_POST['email'] ?? '';
        $userModel = new User();
        $user = $userModel->firstWhere('email', $email);

        if ($user) {
            $token = bin2hex(random_bytes(32));
            // Update user with token
            $userModel->update($user['id'], [
                'reset_token' => $token,
                'reset_expires' => date('Y-m-d H:i:s', strtotime('+1 hour'))
            ]);
            
            $_SESSION['success'] = 'Enlace de recuperación enviado (Simulado). Token: ' . $token;
        } else {
            $_SESSION['error'] = 'Email no encontrado';
        }
        $this->redirect('/forgot-password');
    }
}
