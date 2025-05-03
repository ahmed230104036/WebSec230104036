<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Test SQL Injection in Laravel Application</h1>";

// Function to make HTTP request
function makeRequest($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);
    
    return [
        'status' => $info['http_code'],
        'content' => $response
    ];
}

// Function to count products in response
function countProducts($html) {
    // This is a simple way to count products, might need adjustment based on actual HTML structure
    return substr_count($html, 'class="card mt-2"');
}

echo "<h2>Testing 'keywords' Parameter</h2>";

// Normal search
$normalUrl = "http://localhost:8000/products?keywords=TV";
echo "<h3>Normal Search: $normalUrl</h3>";
$normalResponse = makeRequest($normalUrl);
echo "Status Code: " . $normalResponse['status'] . "<br>";
$normalCount = countProducts($normalResponse['content']);
echo "Products Found: " . $normalCount . "<br>";

// SQL Injection test
$sqliUrl = "http://localhost:8000/products?keywords=" . urlencode("' OR '1'='1");
echo "<h3>SQL Injection Test: $sqliUrl</h3>";
$sqliResponse = makeRequest($sqliUrl);
echo "Status Code: " . $sqliResponse['status'] . "<br>";
$sqliCount = countProducts($sqliResponse['content']);
echo "Products Found: " . $sqliCount . "<br>";

// Check if SQL Injection worked
if ($sqliCount > $normalCount) {
    echo "<div style='color:red; font-weight:bold;'>SQL Injection Successful! More products returned with injection.</div>";
} else {
    echo "<div style='color:green; font-weight:bold;'>SQL Injection Failed or Application is Protected.</div>";
}

echo "<h2>Testing 'order_by' Parameter</h2>";

// Normal order
$normalOrderUrl = "http://localhost:8000/products?order_by=name";
echo "<h3>Normal Order: $normalOrderUrl</h3>";
$normalOrderResponse = makeRequest($normalOrderUrl);
echo "Status Code: " . $normalOrderResponse['status'] . "<br>";

// SQL Injection test for order_by
$sqliOrderUrl = "http://localhost:8000/products?order_by=" . urlencode("(SELECT password FROM users WHERE id=1)");
echo "<h3>SQL Injection Test: $sqliOrderUrl</h3>";
$sqliOrderResponse = makeRequest($sqliOrderUrl);
echo "Status Code: " . $sqliOrderResponse['status'] . "<br>";

// Check if SQL Injection worked
if ($sqliOrderResponse['status'] == 500) {
    echo "<div style='color:red; font-weight:bold;'>SQL Injection Might Be Successful! Server returned 500 error.</div>";
} else {
    echo "<div style='color:green; font-weight:bold;'>SQL Injection Failed or Application is Protected.</div>";
}

// Another SQL Injection test for order_by
$sqliOrderUrl2 = "http://localhost:8000/products?order_by=" . urlencode("name; DROP TABLE test; --");
echo "<h3>SQL Injection Test 2: $sqliOrderUrl2</h3>";
$sqliOrderResponse2 = makeRequest($sqliOrderUrl2);
echo "Status Code: " . $sqliOrderResponse2['status'] . "<br>";

// Check if SQL Injection worked
if ($sqliOrderResponse2['status'] == 500) {
    echo "<div style='color:red; font-weight:bold;'>SQL Injection Might Be Successful! Server returned 500 error.</div>";
} else {
    echo "<div style='color:green; font-weight:bold;'>SQL Injection Failed or Application is Protected.</div>";
}
?>
