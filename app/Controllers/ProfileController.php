<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class ProfileController extends Controller {
    public function index() {
        $this->auth();
        $userModel = new User();
        $user = $userModel->find($_SESSION['user_id']);
        
        $this->view('profile/index', ['user' => $user, 'title' => 'Mi Perfil']);
    }

    public function update() {
        $this->auth();
        $id = $_SESSION['user_id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        
        $data = [
            'name' => $name,
            'email' => $email
        ];

        if (!empty($_POST['password'])) {
            $data['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
        }

        $userModel = new User();
        $userModel->update($id, $data);
        
        $_SESSION['user_name'] = $name; // Update session name
        $_SESSION['success'] = 'Perfil actualizado correctamente.';
        $this->redirect('/profile');
    }
}
