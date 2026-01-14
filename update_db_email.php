<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\Core\Database;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo "Connecting to DB...\n";
$db = Database::getInstance()->getConnection();
echo "Connected.\n";

try {
    $db->beginTransaction();

    echo "Renaming table...\n";
    $db->exec("ALTER TABLE customers RENAME TO customers_old");

    echo "Creating new table...\n";
    $sqlCustomers = "CREATE TABLE customers (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        dni TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL,
        email TEXT, 
        phone TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )";
    $db->exec($sqlCustomers);

    echo "Copying data...\n";
    $db->exec("INSERT INTO customers (id, dni, password, email, phone, created_at, updated_at)
               SELECT id, dni, password, email, phone, created_at, updated_at FROM customers_old");

    echo "Dropping old table...\n";
    $db->exec("DROP TABLE customers_old");

    $db->commit();
    echo "Table updated successfully.\n";

} catch (Exception $e) {
    echo "Caught Exception: " . $e->getMessage() . "\n";
    if ($db->inTransaction()) {
        $db->rollBack();
    }
}