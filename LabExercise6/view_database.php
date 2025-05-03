<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Database Contents</h1>";

try {
    $conn = new PDO("mysql:host=127.0.0.1;port=3306;dbname=websec", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>Products Table</h2>";
    $stmt = $conn->query("SELECT * FROM products");
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Code</th><th>Name</th><th>Price</th><th>Model</th><th>Description</th><th>Photo</th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['code'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['price'] . "</td>";
        echo "<td>" . $row['model'] . "</td>";
        echo "<td>" . $row['description'] . "</td>";
        echo "<td>" . $row['photo'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<h2>Users Table</h2>";
    $stmt = $conn->query("SELECT id, name, email, email_verified_at, created_at FROM users");
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Email Verified At</th><th>Created At</th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['email_verified_at'] . "</td>";
        echo "<td>" . $row['created_at'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<h2>Permissions Table</h2>";
    $stmt = $conn->query("SELECT * FROM permissions");
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Name</th><th>Display Name</th><th>Guard Name</th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['display_name'] . "</td>";
        echo "<td>" . $row['guard_name'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<h2>Roles Table</h2>";
    $stmt = $conn->query("SELECT * FROM roles");
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Name</th><th>Guard Name</th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['guard_name'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<h2>Model Has Roles Table</h2>";
    $stmt = $conn->query("SELECT * FROM model_has_roles");
    echo "<table border='1'>";
    echo "<tr><th>Role ID</th><th>Model Type</th><th>Model ID</th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row['role_id'] . "</td>";
        echo "<td>" . $row['model_type'] . "</td>";
        echo "<td>" . $row['model_id'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
} catch(PDOException $e) {
    echo "<p style='color:red'>Error: " . $e->getMessage() . "</p>";
}
?>
