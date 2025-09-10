<?php
header('Content-Type: application/json');
require 'db_connect.php';

$response = ['success' => false, 'message' => 'An unknown error occurred.'];

// Check if all required fields are present
if (isset($_POST['name'], $_POST['price'], $_POST['description'], $_POST['stock'], $_FILES['image'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $stock = $_POST['stock'];
    $image = $_FILES['image'];

    // --- Image Upload Handling ---
    $uploadDir = 'uploads/';
    // Create a unique filename to prevent overwriting
    $imageExtension = pathinfo($image['name'], PATHINFO_EXTENSION);
    $imageName = uniqid('product_', true) . '.' . $imageExtension;
    $uploadFilePath = $uploadDir . $imageName;

    // Allowed file types
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array(strtolower($imageExtension), $allowedTypes)) {
        $response['message'] = 'Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.';
        echo json_encode($response);
        exit;
    }

    // Move the uploaded file to the target directory
    if (move_uploaded_file($image['tmp_name'], $uploadFilePath)) {
        // --- Database Insertion ---
        $stmt = $conn->prepare("INSERT INTO products (name, price, description, stock, image) VALUES (?, ?, ?, ?, ?)");
        // The path stored in the DB is relative to the project root
        $stmt->bind_param("sdsis", $name, $price, $description, $stock, $uploadFilePath);

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Product uploaded successfully!';
        } else {
            $response['message'] = 'Database error: Failed to save product.';
            // Optional: remove uploaded file if DB insert fails
            unlink($uploadFilePath);
        }
        $stmt->close();
    } else {
        $response['message'] = 'Failed to upload image.';
    }
} else {
    $response['message'] = 'Missing required fields.';
}

$conn->close();
echo json_encode($response);
?>