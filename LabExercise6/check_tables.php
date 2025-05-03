<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Checking database tables...\n";

try {
    $conn = new PDO("mysql:host=127.0.0.1;port=3306;dbname=websec", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $result = $conn->query("SHOW TABLES");
    
    echo "Tables in 'websec' database:\n";
    while ($row = $result->fetch(PDO::FETCH_NUM)) {
        echo "- " . $row[0] . "\n";
    }
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
