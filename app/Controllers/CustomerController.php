<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Customer;

class CustomerController extends Controller {
    public function index() {
        $this->auth();
        $model = new Customer();
        $customers = $model->all();
        $this->view('customers/index', ['customers' => $customers, 'title' => 'Clientes']);
    }
}
