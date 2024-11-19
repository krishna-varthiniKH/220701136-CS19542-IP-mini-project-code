<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_auth";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the posted data
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    die("No data received");
}

$products = $data['products'];
$subtotal = $data['subtotal'];
$tax = $data['tax'];
$discount = $data['discount'];
$total = $data['total'];

// Insert each product into the bills table
foreach ($products as $product) {
    $stmt = $conn->prepare("INSERT INTO bills (product_name, quantity, price_each, total) VALUES (?, ?, ?, ?)");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("siid", $product['name'], $product['quantity'], $product['price'], $product['total']);
    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }
}

// Prepare response
$response = [
    'message' => 'Bill saved successfully!',
];

// Close connection
$stmt->close();
$conn->close();

// Return response
header('Content-Type: application/json');
echo json_encode($response);
?>
