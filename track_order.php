<?php
// track_order.php
require 'db_connect.php';
header('Content-Type: application/json');

$orderId = $_GET['order_id'] ?? null;
if (!$orderId) {
    echo json_encode(['success' => false, 'message' => 'Order ID required.']);
    exit;
}

$stmt = $conn->prepare('SELECT status FROM orders WHERE id = ?');
$stmt->bind_param('i', $orderId);
$stmt->execute();
$stmt->bind_result($status);
if ($stmt->fetch()) {
    echo json_encode(['success' => true, 'status' => $status]);
} else {
    echo json_encode(['success' => false, 'message' => 'Order not found.']);
}
$stmt->close();
$conn->close();
?>
