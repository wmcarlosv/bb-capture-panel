<?php
// Setup DB
require_once __DIR__ . '/vendor/autoload.php';

use App\Core\Database;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Ensure DB directory exists
$dbDir = __DIR__ . '/database';
if (!is_dir($dbDir)) {
    mkdir($dbDir, 0777, true);
    // SQLite requires write permission on the directory
    chmod($dbDir, 0777); 
}

// Ensure DB file exists
$dbFile = $dbDir . '/database.sqlite';
if (!file_exists($dbFile)) {
    touch($dbFile);
    chmod($dbFile, 0666); // Read/Write for file
}

$db = Database::getInstance()->getConnection();

// Create Users Table
$sqlUsers = "CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    reset_token TEXT NULL,
    reset_expires DATETIME NULL
)";
$db->exec($sqlUsers);

// Create Customers Table
$sqlCustomers = "CREATE TABLE IF NOT EXISTS customers (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    dni TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    email TEXT NOT NULL,
    phone TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
)";
$db->exec($sqlCustomers);

// Seed Admin User
$stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE email = 'admin@admin.com'");
$stmt->execute();
if ($stmt->fetchColumn() == 0) {
    $pass = password_hash('admin', PASSWORD_BCRYPT);
    $stmt = $db->prepare("INSERT INTO users (name, email, password) VALUES ('Admin', 'admin@admin.com', ?)");
    $stmt->execute([$pass]);
    echo "Admin user created: admin@admin.com / admin\n";
} else {
    echo "Admin user already exists.\n";
}

echo "Database setup completed.\n";

