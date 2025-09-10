<?php
require 'db_connect.php';
session_start();
header('Content-Type: application/json');

$response = ['success' => false, 'message' => 'Invalid request.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';

    if (empty($email) || empty($password)) {
        $response['message'] = 'Email and password are required.';
        echo json_encode($response);
        exit;
    }

    // Check for admin credentials first
    if ($email === 'admin' && $password === '1234') {
        $_SESSION['user_id'] = 'admin';
        $_SESSION['user_role'] = 'admin';
        $response = ['success' => true, 'redirect' => 'admin_dashboard.html'];
        echo json_encode($response);
        exit;
    }

    // Validate against the database for regular users
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            // Password is correct, start session
            $_SESSION['user_id'] = $id;
            $_SESSION['user_role'] = 'user';
            $response = ['success' => true, 'redirect' => 'home.html'];
        } else {
            $response['message'] = 'Invalid email or password.';
        }
    } else {
        $response['message'] = 'Invalid email or password.';
    }
    $stmt->close();
}

$conn->close();
echo json_encode($response);
?>