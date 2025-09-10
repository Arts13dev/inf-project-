
<?php
// orders.php
include 'db_connect.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Save new order from cart
    $data = json_decode(file_get_contents('php://input'), true);
    $cart = $data['cart'] ?? [];
    if (empty($cart)) {
        echo json_encode(['success' => false, 'message' => 'Cart is empty.']);
        exit;
    }
    // For demo, use user_id = 1. In production, use session user id.
    $user_id = 1;
    $order_ids = [];
    foreach ($cart as $item) {
        // You may want to look up product_id by name in production
        $product_name = $item['name'];
        $quantity = $item['quantity'];
        $price = $item['price'];
        // Find product_id
        $stmt = $conn->prepare('SELECT id FROM products WHERE name = ? LIMIT 1');
        $stmt->bind_param('s', $product_name);
        $stmt->execute();
        $stmt->bind_result($product_id);
        if ($stmt->fetch()) {
            $stmt->close();
            // Insert order
            $status = 'confirmed';
            $insert = $conn->prepare('INSERT INTO orders (user_id, product_id, quantity, status) VALUES (?, ?, ?, ?)');
            $insert->bind_param('iiis', $user_id, $product_id, $quantity, $status);
            if ($insert->execute()) {
                $order_ids[] = $conn->insert_id;
            }
            $insert->close();
        } else {
            $stmt->close();
        }
    }
    $conn->close();
    if (!empty($order_ids)) {
        echo json_encode(['success' => true, 'order_ids' => $order_ids]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Order failed.']);
    }
    exit;
}

// GET: fetch orders
$result = $conn->query('SELECT id, user_id, product_id, quantity, status, created_at FROM orders');
$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}
$conn->close();
echo json_encode(['success' => true, 'orders' => $orders]);
?>
