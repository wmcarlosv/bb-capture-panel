<?php

namespace App\Core;

class Controller {
    protected function view($view, $data = []) {
        extract($data);
        require_once __DIR__ . '/../../app/Views/' . $view . '.php';
    }

    protected function redirect($url) {
        header("Location: {$url}");
        exit;
    }

    protected function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    // Helper for checking auth
    protected function auth() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
    }
    
    // Helper for checking guest
    protected function guest() {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/dashboard');
        }
    }
}
