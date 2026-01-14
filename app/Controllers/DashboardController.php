<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Models\Customer;

class DashboardController extends Controller {
    public function index() {
        $this->auth();
        
        $userModel = new User();
        $customerModel = new Customer();
        
        $usersCount = count($userModel->all());
        $customersCount = count($customerModel->all());
        
        $this->view('dashboard/index', [
            'usersCount' => $usersCount,
            'customersCount' => $customersCount,
            'title' => 'Dashboard'
        ]);
    }
}
