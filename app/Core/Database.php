<?php

namespace App\Core;

use PDO;
use PDOException;

class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        try {
            $dbPathFromEnv = $_ENV['DB_DATABASE'] ?? 'database/database.sqlite';
            // Simple logic: if it starts with ../, we are in public/, so it works relative to that.
            // But we want to be robust.
            
            // Assume the app root is two levels up from this file's directory (app/Core) -> app -> root
            $rootPath = dirname(__DIR__, 2);
            
            // Normalize path relative to root if it starts with ./ or no slash, or handling ../
            // But since .env usually has relative path to root or public, let's just look for it.
            
            // Best bet: Use the hardcoded logic that we know works for this structure, or resolve against root.
            $absolutePath = $rootPath . '/database/database.sqlite';

            $this->connection = new PDO("sqlite:" . $absolutePath);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
}
