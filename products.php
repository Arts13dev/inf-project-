<?php
// products.php
header('Content-Type: application/json');
include 'db_connect.php';

$response = ['success' => false, 'products' => [], 'product' => null];

// Check if a specific product ID is requested
if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    $stmt = $conn->prepare("SELECT id, name, price, stock, image, description FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($product = $result->fetch_assoc()) {
        $response['success'] = true;
        $response['product'] = $product;
    }
    $stmt->close();
} else {
    // Otherwise, fetch all products
    $result = $conn->query("SELECT id, name, price, stock, image FROM products");
    $products = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        $response['success'] = true;
        $response['products'] = $products;
    }
}

$conn->close();
echo json_encode($response);
?>
