<?php
// This is a test file to demonstrate SQL injection vulnerabilities
// DO NOT use this in a production environment

// Simulating the vulnerable code from ProductsController.php
function simulateKeywordsSearch($keywords) {
    // This is vulnerable to SQL injection
    $sql = "SELECT * FROM products WHERE name LIKE '%$keywords%'";
    
    echo "Generated SQL: " . htmlspecialchars($sql) . "\n\n";
    
    // Example of how this could be exploited:
    if (strpos($keywords, "'") !== false || strpos($keywords, "\"") !== false) {
        echo "Potential SQL injection detected in keywords!\n";
        echo "This could allow an attacker to modify the query logic.\n\n";
    }
}

function simulateOrderByVulnerability($orderBy, $direction = "ASC") {
    // This is vulnerable to SQL injection
    $sql = "SELECT * FROM products ORDER BY $orderBy $direction";
    
    echo "Generated SQL: " . htmlspecialchars($sql) . "\n\n";
    
    // Example of how this could be exploited:
    if (strpos($orderBy, ";") !== false || strpos($orderBy, "--") !== false) {
        echo "Potential SQL injection detected in order by!\n";
        echo "This could allow an attacker to execute additional SQL statements.\n\n";
    }
}

// Simulating the secure alternatives
function secureKeywordsSearch($keywords) {
    // Using parameter binding (prepared statements)
    $sql = "SELECT * FROM products WHERE name LIKE ?";
    $params = ["%$keywords%"];
    
    echo "Secure SQL: " . htmlspecialchars($sql) . "\n";
    echo "Parameters: " . htmlspecialchars(json_encode($params)) . "\n\n";
}

function secureOrderBySearch($orderBy, $direction = "ASC") {
    // Whitelist of allowed columns
    $allowedColumns = ['id', 'name', 'price', 'created_at'];
    $allowedDirections = ['ASC', 'DESC'];
    
    $safeColumn = in_array($orderBy, $allowedColumns) ? $orderBy : 'id';
    $safeDirection = in_array(strtoupper($direction), $allowedDirections) ? $direction : 'ASC';
    
    $sql = "SELECT * FROM products ORDER BY $safeColumn $safeDirection";
    
    echo "Secure SQL: " . htmlspecialchars($sql) . "\n\n";
}

// Example of DB::unprepared usage and its risks
function demonstrateUnprepared($userInput) {
    // VULNERABLE - DO NOT USE IN PRODUCTION
    $sql = "SELECT * FROM products WHERE name LIKE '%$userInput%'";
    echo "Unprepared SQL (vulnerable): " . htmlspecialchars($sql) . "\n\n";
    
    // Secure alternative using prepared statements
    $sql = "SELECT * FROM products WHERE name LIKE ?";
    $params = ["%$userInput%"];
    echo "Prepared SQL (secure): " . htmlspecialchars($sql) . "\n";
    echo "Parameters: " . htmlspecialchars(json_encode($params)) . "\n\n";
}

// Test cases
echo "<pre>\n";
echo "=== Testing Keywords Search Vulnerability ===\n\n";
simulateKeywordsSearch("iPhone"); // Normal case
simulateKeywordsSearch("' OR '1'='1"); // SQL injection attempt
secureKeywordsSearch("' OR '1'='1"); // Secure alternative

echo "=== Testing Order By Vulnerability ===\n\n";
simulateOrderByVulnerability("name"); // Normal case
simulateOrderByVulnerability("name; DROP TABLE users; --"); // SQL injection attempt
secureOrderBySearch("name; DROP TABLE users; --"); // Secure alternative

echo "=== Understanding DB::unprepared ===\n\n";
demonstrateUnprepared("iPhone"); // Normal case
demonstrateUnprepared("' OR '1'='1"); // SQL injection attempt
echo "</pre>";
