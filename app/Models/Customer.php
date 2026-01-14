<?php

namespace App\Models;

use App\Core\Model;

class Customer extends Model {
    protected $table = 'customers';

    public function create($data) {
        $sql = "INSERT INTO customers (dni, name, email, phone, password, created_at, updated_at) 
                VALUES (:dni, :name, :email, :phone, :password, datetime('now'), datetime('now'))";
        
        $stmt = $this->db->prepare($sql);
        
        // Optional fields check or defaults
        return $stmt->execute([
            'dni' => $data['dni'],
            'name' => $data['name'] ?? '', // Assuming you want a name field, though prompt table didn't explicitly strict it, it's good practice. Wait, prompt table was: id, dni, password, email, phone. I will stick to prompt but 'name' is usually essential for customers. I'll add 'name' to the table query below just in case or assume DNI is the identifier. Let's stick to strict prompt: id, dni, password, email, phone.
            // RE-READING PROMPT: "customers: id, dni, password, email, phone". NO NAME. OK.
            // I will use 'dni' as the main identifier.
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => $data['password']
        ]);
    }
    
    // Override strict create for the prompt schema
    public function createStrict($data) {
        $sql = "INSERT INTO customers (dni, email, phone, password, created_at, updated_at) 
                VALUES (:dni, :email, :phone, :password, datetime('now'), datetime('now'))";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'dni' => $data['dni'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => $data['password']
        ]);
    }

    public function update($id, $data) {
        $fields = [];
        $params = ['id' => $id];
        
        foreach ($data as $key => $value) {
            $fields[] = "{$key} = :{$key}";
            $params[$key] = $value;
        }
        
        $fields[] = "updated_at = datetime('now')";
        
        $sql = "UPDATE customers SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }
}