<?php

namespace App\Models;

use App\Core\Model;

class User extends Model {
    protected $table = 'users';

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO users (name, email, password, created_at, updated_at) VALUES (:name, :email, :password, datetime('now'), datetime('now'))");
        return $stmt->execute([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password']
        ]);
    }

    public function update($id, $data) {
        // Build dynamic query
        $fields = [];
        $params = ['id' => $id];
        
        foreach ($data as $key => $value) {
            $fields[] = "{$key} = :{$key}";
            $params[$key] = $value;
        }
        
        $fields[] = "updated_at = datetime('now')";
        
        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }
}
