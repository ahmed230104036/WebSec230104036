<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>SQL Injection Tester</h1>";

// Function to test SQL injection
function testSQLInjection($conn, $query) {
    try {
        $result = $conn->query($query);
        echo "<div style='color:green'>Query executed successfully!</div>";
        echo "<h3>Results:</h3>";
        echo "<table border='1'>";
        
        // Get column names
        $firstRow = $result->fetch(PDO::FETCH_ASSOC);
        if ($firstRow) {
            echo "<tr>";
            foreach (array_keys($firstRow) as $column) {
                echo "<th>" . htmlspecialchars($column) . "</th>";
            }
            echo "</tr>";
            
            // Output first row
            echo "<tr>";
            foreach ($firstRow as $value) {
                echo "<td>" . htmlspecialchars($value ?? 'NULL') . "</td>";
            }
            echo "</tr>";
            
            // Output remaining rows
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>" . htmlspecialchars($value ?? 'NULL') . "</td>";
                }
                echo "</tr>";
            }
        } else {
            echo "<tr><td>No results</td></tr>";
        }
        
        echo "</table>";
        return true;
    } catch (PDOException $e) {
        echo "<div style='color:red'>Error: " . $e->getMessage() . "</div>";
        return false;
    }
}

// Connect to database
try {
    $conn = new PDO("mysql:host=127.0.0.1;port=3306;dbname=websec", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<div style='color:green'>Connected to database successfully!</div>";
    
    // Test cases for keywords parameter
    echo "<h2>Testing 'keywords' Parameter</h2>";
    
    echo "<h3>Normal Query:</h3>";
    $query = "SELECT * FROM products WHERE name LIKE '%TV%'";
    echo "<code>" . htmlspecialchars($query) . "</code>";
    testSQLInjection($conn, $query);
    
    echo "<h3>SQL Injection Test 1: ' OR '1'='1</h3>";
    $query = "SELECT * FROM products WHERE name LIKE '%' OR '1'='1%'";
    echo "<code>" . htmlspecialchars($query) . "</code>";
    testSQLInjection($conn, $query);
    
    echo "<h3>SQL Injection Test 2: UNION Attack</h3>";
    $query = "SELECT * FROM products WHERE name LIKE '%' UNION SELECT 1,2,3,4,5,6,7,8,9,10 -- %'";
    echo "<code>" . htmlspecialchars($query) . "</code>";
    testSQLInjection($conn, $query);
    
    // Test cases for order_by parameter
    echo "<h2>Testing 'order_by' Parameter</h2>";
    
    echo "<h3>Normal Query:</h3>";
    $query = "SELECT * FROM products ORDER BY name ASC";
    echo "<code>" . htmlspecialchars($query) . "</code>";
    testSQLInjection($conn, $query);
    
    echo "<h3>SQL Injection Test: Subquery</h3>";
    $query = "SELECT * FROM products ORDER BY (SELECT 1)";
    echo "<code>" . htmlspecialchars($query) . "</code>";
    testSQLInjection($conn, $query);
    
    echo "<h3>SQL Injection Test: Multiple Statements</h3>";
    $query = "SELECT * FROM products ORDER BY name; SELECT * FROM users; -- ";
    echo "<code>" . htmlspecialchars($query) . "</code>";
    testSQLInjection($conn, $query);
    
} catch(PDOException $e) {
    echo "<div style='color:red'>Connection failed: " . $e->getMessage() . "</div>";
}
?>
