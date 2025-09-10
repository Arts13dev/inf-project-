<?php
// profile.php
require 'db_connect.php';
session_start();
header('Content-Type: application/json');

$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    echo json_encode(['success' => false, 'message' => 'Not logged in.']);
    exit;
}

// Fetch user profile
$stmt = $conn->prepare('SELECT full_name, email FROM users WHERE id = ?');
$stmt->bind_param('i', $userId);
$stmt->execute();
$stmt->bind_result($fullName, $email);
if ($stmt->fetch()) {
    echo json_encode(['success' => true, 'fullName' => $fullName, 'email' => $email]);
} else {
    echo json_encode(['success' => false, 'message' => 'User not found.']);
}
$stmt->close();
$conn->close();
?>
