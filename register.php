<?php
// register.php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'db_connect.php'; // Use the connection from this file
header('Content-Type: application/json');

$fullName = $_POST['fullName'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($fullName) || empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}

// Check if email already exists
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Email already registered.']);
    $stmt->close();
    $conn->close();
    exit;
}
$stmt->close();

// Hash password for security
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert new user
$stmt = $conn->prepare("INSERT INTO users (fullName, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $fullName, $email, $hashedPassword);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Registration successful.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Registration failed. Please try again.']);
}

$stmt->close();
$conn->close();
?>