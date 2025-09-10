<?php
require 'db_connect.php';
session_start();
header('Content-Type: application/json');

$response = ['success' => false, 'message' => 'Not logged in.'];

if (isset($_SESSION['user_id']) && $_SESSION['user_id'] !== 'admin') {
    $userId = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT full_name, email FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        $response['success'] = true;
        $response['user'] = $user;
        unset($response['message']);
    } else {
        $response['message'] = 'User not found.';
    }
    $stmt->close();
}

$conn->close();
echo json_encode($response);
?>