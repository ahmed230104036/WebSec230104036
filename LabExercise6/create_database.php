<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Attempting to connect to MySQL...\n";

try {
    $conn = new PDO("mysql:host=127.0.0.1;port=3306", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected successfully to MySQL.\n";

    // Create database if it doesn't exist
    $sql = "CREATE DATABASE IF NOT EXISTS websec";
    $conn->exec($sql);

    echo "Database 'websec' created successfully or already exists.\n";

    // Check if the database exists
    $result = $conn->query("SHOW DATABASES LIKE 'websec'");
    if ($result->rowCount() > 0) {
        echo "Verified: Database 'websec' exists.\n";
    } else {
        echo "Warning: Database 'websec' was not found after creation attempt.\n";
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
