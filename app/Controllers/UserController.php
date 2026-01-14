<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class UserController extends Controller {
    public function index() {
        $this->auth();
        $userModel = new User();
        $users = $userModel->all();
        $this->view('users/index', ['users' => $users, 'title' => 'Usuarios']);
    }

    public function create() {
        $this->auth();
        $this->view('users/create', ['title' => 'Crear Usuario']);
    }

    public function store() {
        $this->auth();
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $userModel = new User();
        // Check if email exists
        if ($userModel->firstWhere('email', $email)) {
             $_SESSION['error'] = 'El email ya existe.';
             $this->redirect('/users/create');
             return;
        }

        $userModel->create([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);

        $_SESSION['success'] = 'Usuario creado correctamente.';
        $this->redirect('/users');
    }

    public function edit($id) {
        $this->auth();
        $userModel = new User();
        $user = $userModel->find($id);
        
        if (!$user) {
            $this->redirect('/users');
        }

        $this->view('users/edit', ['user' => $user, 'title' => 'Editar Usuario']);
    }

    public function update($id) {
        $this->auth();
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

        $_SESSION['success'] = 'Usuario actualizado correctamente.';
        $this->redirect('/users');
    }

    public function delete($id) {
        $this->auth();
        // Prevent deleting self (simple check)
        if ($id == $_SESSION['user_id']) {
            $this->json(['success' => false, 'message' => 'No puedes eliminar tu propia cuenta.']);
            return;
        }

        $userModel = new User();
        $userModel->delete($id);
        $this->json(['success' => true]);
    }
}
