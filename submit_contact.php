<?php
require 'db_connect.php';
header('Content-Type: application/json');

$response = ['success' => false, 'message' => 'Invalid request.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $name = $data['name'] ?? '';
    $email = $data['email'] ?? '';
    $message = $data['message'] ?? '';

    if (!empty($name) && !empty($email) && !empty($message)) {
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Thank you for your message! We will get back to you soon.';
        } else {
            $response['message'] = 'Failed to send message. Please try again later.';
        }
        $stmt->close();
    } else {
        $response['message'] = 'All fields are required.';
    }
}

$conn->close();
echo json_encode($response);
?>